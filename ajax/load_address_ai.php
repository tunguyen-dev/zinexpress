<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function multiexplode($delimiters, $string)
{
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}

$models_regexSearchSite = new Models_RegexSearchSite();
$persistents_regexSearchSite = new Persistents_RegexSearchSite();
$regex_site = $models_regexSearchSite->getList2();
$model_cities = new Models_Cities();
$model_dis = new Models_Districts();
/** @var TYPE_NAME $address */
$array_split_add = multiexplode(array(",", ".", "|", ";", "/"), preg_replace('!\s+!', ' ', strtolower(Commons_Formulars::stripVN(trim($address, ' ')))));
$exit_province = false;
$province_select = 0;
$exit_district = false;
$district_select = 0;
$option_district = '';
$add_processing = strtolower(Commons_Formulars::stripVN(trim($address, ' ')));
$citi_code = 0;
$district_code = 0;
$commune_code = 0;
$district = '';
$city = '';
$list_cities = $model_cities->getList2();
$model_com = new Models_Communes();
$regex_site_name = '';
if (count($array_split_add) >= 3) {
    $pro_pt = preg_replace('!\s+!', ' ', strtolower(trim($array_split_add[count($array_split_add) - 1], ' ')));
    if (startsWith($pro_pt, 't ')) {
        $pro_pt = substr($pro_pt, 2, -1);
    } elseif (startsWith($pro_pt, 't. ') ||
        startsWith($pro_pt, 'tp ')) {
        $pro_pt = substr($pro_pt, 3, -1);
    } elseif (
    startsWith($pro_pt, 'tp. ')) {
        $pro_pt = substr($pro_pt, 4, -1);
    }
    foreach ($list_cities as $li) {
        if (!$exit_province && strtolower(Commons_Formulars::stripVN($li->name)) == $pro_pt ||
            strpos(strtolower(Commons_Formulars::stripVN($li->name)), $pro_pt)) {
            $option_province .= "<option value='$li->code' selected>$li->name </option>";
            $province_select = $li->code;
            $exit_province = true;
            $city = strtolower(Commons_Formulars::stripVN($li->name));
            if (startsWith($city, 'thanh pho ')) {
                $city = substr($city, 10, strlen($city));
            } elseif (startsWith($city, 'tinh ')) {
                $city = substr($city, 5, strlen($city));
            }
        } else {
            $option_province .= "<option value='$li->code'>$li->name </option>";
        }
    }
    if ($exit_province) {
        $list_dis = $model_dis->customFilter('', array('citi_code' => $province_select));
        $district_pt = preg_replace('!\s+!', ' ', strtolower(trim($array_split_add[count($array_split_add) - 2], ' ')));
        if (startsWith($district_pt, 'q ') ||
            startsWith($district_pt, 'h ')) {
            $district_pt = substr($district_pt, 2, -1);
        } elseif (startsWith($district_pt, 'q. ') ||
            startsWith($district_pt, 'h. ') ||
            startsWith($district_pt, 'tp ') ||
            startsWith($district_pt, 'tt ') ||
            startsWith($district_pt, 'tx ')) {
            $district_pt = substr($district_pt, 3, -1);
        } elseif (
            startsWith($district_pt, 'tp. ') ||
            startsWith($district_pt, 'tt. ') ||
            startsWith($district_pt, 'tx. ')) {
            $district_pt = substr($district_pt, 4, -1);
        }
        foreach ($list_dis as $li) {

            if (!$exit_district && strtolower(Commons_Formulars::stripVN($li->name)) == $district_pt ||
                strpos(strtolower(Commons_Formulars::stripVN($li->name)), $district_pt)) {
                $option_district .= "<option value='$li->code' selected>$li->name </option>";
                $exit_district = true;
                $district_select = $li->code;
                $district = strtolower(Commons_Formulars::stripVN($li->name));
                if (startsWith($district, 'huyen ')) {
                    $district = substr($district, 6, strlen($district));
                } elseif (startsWith($district, 'quan ')) {
                    $district = substr($district, 5, strlen($district));
                } elseif (startsWith($district, 'thanh pho ')) {
                    $district = substr($district, 10, strlen($district));
                } elseif (startsWith($district, 'thi xa ')) {
                    $district = substr($district, 7, strlen($district));
                }
            } else {
                $option_district .= "<option value='$li->code' data-id='$key'>$li->name</option>";
            }
        }
    }
    $exit_commune = false;
    $option_commune = '';
    if ($exit_district) {
        $commune_pt = preg_replace('!\s+!', ' ', strtolower(trim($array_split_add[count($array_split_add) - 3], ' ')));
        if (startsWith($commune_pt, 'p ') ||
            startsWith($commune_pt, 'x ')) {
            $commune_pt = substr($commune_pt, 2, -1);
        } elseif (startsWith($commune_pt, 'p. ') ||
            startsWith($commune_pt, 'x. ') ||
            startsWith($commune_pt, 'tt ') ||
            startsWith($commune_pt, 'tx ')) {
            $commune_pt = substr($commune_pt, 3, -1);
        } elseif (
            startsWith($commune_pt, 'tt. ') ||
            startsWith($commune_pt, 'tx. ')) {
            $commune_pt = substr($commune_pt, 4, -1);
        }
        $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
        foreach ($list_com as $li) {
            if (!$exit_commune && strtolower(Commons_Formulars::stripVN($li->name)) == $commune_pt ||
                strpos(strtolower(Commons_Formulars::stripVN($li->name)), $commune_pt)) {
                $option_commune .= "<option value='$li->code' selected>$li->name </option>";
                $exit_commune = true;
            } else {
                $option_commune .= "<option value='$li->code'>$li->name </option>";
            }
        }
    }
    if ($exit_district && !$exit_commune) {
        $option_commune = '';
        $regex_site_name = '/' . $district . ".*" . $city . '/i';
        $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
        foreach ($list_com as $li) {
            $commune = strtolower(Commons_Formulars::stripVN($li->name));
            if (startsWith($commune, 'phuong ')) {
                $commune = substr($commune, 7, strlen($commune));
            } elseif (startsWith($commune, 'thi tran ')) {
                $commune = substr($commune, 9, strlen($commune));
            } elseif (startsWith($commune, 'xa ')) {
                $commune = substr($commune, 3, strlen($commune));
            }
            if (intval($commune) > 0) {
                $int_commune = intval($commune);
                if (intval($commune) < 10) {
                    $commune_regex = "(p |p|p.|phuong|phuong |phuong.|phuong0|phuong 0|phuong.0|p 0|p0|p.0)+$int_commune+";
                } else {
                    $commune_regex = "(p |p.|p|phuong|phuong |phuong.|phuong)+$int_commune+";
                }
            } else {
                $commune_regex = '(p |p.|p|phuong|phuong |phuong.|x |x.|x|xa |xa.|xa. |tr|tr |tr.|thi tran. |thi tran |thi tran.)' . $commune;
            }
            $regex_site_name_full = '/' . $commune_regex . '.*' . substr($regex_site_name, 1, strlen($regex_site_name));
            if (!$exit_commune && preg_match($regex_site_name_full, $add_processing)) {
                $option_commune .= "<option value='$li->code' selected>$li->name</option>";
                $exit_commune = true;
            } else {
                $option_commune .= "<option value='$li->code'>$li->name</option>";
            }
        }
    }
}
$tmp = '';
if ($district == '' || $city == '') {
    $length = 9999;
    foreach ($regex_site as $site) {

        if (preg_match($site->regex_name_corp, $add_processing)) {
            preg_match($site->regex_name_corp, $add_processing, $regex_rs, PREG_UNMATCHED_AS_NULL);
            $codes = explode("_", $site->codes_corp);
            $length_tmp = strlen($regex_rs[0]);
            if ($length_tmp < $length) {
                $citi_code = $codes[1];
                $district_code = $codes[0];
                $regex_site_name = $site->regex_name_corp;
                $tmp .= "<option value='$li->code'>$regex_site_name</option>";
                $length = $length_tmp;
            }
        }
    }
    if ($citi_code != 0 && $district_code != 0) {
        $option_province = '';
        $option_district = '';
        $option_commune = '';
        foreach ($list_cities as $li) {

            if (!$exit_province && $citi_code == $li->code) {
                $option_province .= "<option value='$li->code' selected>$li->name</option>";
                $province_select = $li->code;
                $exit_province = true;
            } else {
                $option_province .= "<option value='$li->code'>$li->name</option>";
            }
        }
        $option_province .= $tmp . ' == ' . $add_processing . '' . $address;

        if ($exit_province) {
            $list_dis = $model_dis->customFilter('', array('citi_code' => $province_select));
            foreach ($list_dis as $li) {

                if (!$exit_district && $li->code == $district_code) {
                    $option_district .= "<option value='$li->code' selected>$li->name </option>";
                    $exit_district = true;
                    $district_select = $li->code;
                } else {
                    $option_district .= "<option value='$li->code' data-id='$key'>$li->name </option>";
                }

            }
        }
        $exit_commune = false;
        $option_commune = '';

        if ($exit_district && $add_processing != '') {
            $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
            foreach ($list_com as $li) {
                $commune = strtolower(Commons_Formulars::stripVN($li->name));
                if (startsWith($commune, 'phuong ')) {
                    $commune = substr($commune, 7, strlen($commune));
                } elseif (startsWith($commune, 'thi tran ')) {
                    $commune = substr($commune, 9, strlen($commune));
                } elseif (startsWith($commune, 'xa ')) {
                    $commune = substr($commune, 3, strlen($commune));
                }
                if (intval($commune) > 0) {
                    if (intval($commune) < 10) {
                        $commune_regex = "(p |p|p.|phuong|phuong |phuong.|phuong0|phuong 0|phuong.0|p 0|p0|p.0)" . intval($commune);
                    } else {
                        $commune_regex = '(p |p.|p|phuong|phuong |phuong.|phuong)' . intval($commune);
                    }
                } else {
                    $commune_regex = '(p |p.|p|phuong|phuong |phuong.|x |x.|x|xa |xa.|xa. |tr|tr |tr.|thi tran. |thi tran |thi tran.)' . $commune;
                }
                $regex_site_name_full = '/' . $commune_regex . '.*' . substr($regex_site_name, 1, strlen($regex_site_name));
                if (!$exit_commune && preg_match($regex_site_name_full, $add_processing)) {
                    $option_commune .= "<option value='$li->code' selected>$li->name</option>";
                    $exit_commune = true;
                } else {
                    $option_commune .= "<option value='$li->code'>$li->name</option>";
                }
            }
        }
    } else {
        $option_province = '';
        $option_district = '';
        $option_commune = '';
        if ($add_processing != null && $add_processing != '') {
            foreach ($list_cities as $li) {
                $city = strtolower(Commons_Formulars::stripVN($li->name));
                if (startsWith($city, 'thanh pho ')) {
                    $city = substr($city, 10, strlen($city));
                } elseif (startsWith($city, 'tinh ')) {
                    $city = substr($city, 5, strlen($city));
                }
                if (!$exit_province && strpos($add_processing, $city)) {
                    $option_province .= "<option value='$li->code' selected>$li->name</option>";
                    $province_select = $li->code;
                    $exit_province = true;
                } else {
                    $option_province .= "<option value='$li->code'>$li->name</option>";
                }
            }
        }
        if ($exit_province && $add_processing != '') {
            $list_dis = $model_dis->customFilter('', array('citi_code' => $province_select));
            foreach ($list_dis as $li) {
                $district = strtolower(Commons_Formulars::stripVN($li->name));
                if (startsWith($district, 'huyen ')) {
                    $district = substr($district, 6, strlen($district));
                } elseif (startsWith($district, 'quan ')) {
                    $district = substr($district, 5, strlen($district));
                } elseif (startsWith($district, 'thanh pho ')) {
                    $district = substr($district, 10, strlen($district));
                } elseif (startsWith($district, 'thi xa ')) {
                    $district = substr($district, 7, strlen($district));
                }
                if (!$exit_district && strpos($add_processing, $district)) {
                    $option_district .= "<option value='$li->code' selected>$li->name </option>";
                    $exit_district = true;
                    $district_select = $li->code;
                } else {
                    $option_district .= "<option value='$li->code' data-id='$key'>$li->name </option>";
                }
            }
        }
        $exit_commune = false;
        $option_commune = '';
        if ($exit_district) {
            $commune_pt = preg_replace('!\s+!', ' ', strtolower(trim($array_split_add[count($array_split_add) - 3], ' ')));
            if (startsWith($commune_pt, 'p ') ||
                startsWith($commune_pt, 'x ')) {
                $commune_pt = substr($commune_pt, 2, -1);
            } elseif (startsWith($commune_pt, 'p. ') ||
                startsWith($commune_pt, 'x. ') ||
                startsWith($commune_pt, 'tt ') ||
                startsWith($commune_pt, 'tx ')) {
                $commune_pt = substr($commune_pt, 3, -1);
            } elseif (
                startsWith($commune_pt, 'tt. ') ||
                startsWith($commune_pt, 'tx. ')) {
                $commune_pt = substr($commune_pt, 4, -1);
            }
            $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
            foreach ($list_com as $li) {
                if (!$exit_commune && strtolower(Commons_Formulars::stripVN($li->name)) == $commune_pt ||
                    strpos(strtolower(Commons_Formulars::stripVN($li->name)), $commune_pt)) {
                    $option_commune .= "<option value='$li->code' selected>$li->name </option>";
                    $exit_commune = true;
                } else {
                    $option_commune .= "<option value='$li->code'>$li->name </option>";
                }
            }
        }
        if ($exit_district && $add_processing != '') {
            $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
            foreach ($list_com as $li) {
                $commune = strtolower(Commons_Formulars::stripVN($li->name));
                if (startsWith($commune, 'phuong ')) {
                    $commune = substr($commune, 7, strlen($commune));
                } elseif (startsWith($commune, 'thi tran ')) {
                    $commune = substr($commune, 9, strlen($commune));
                } elseif (startsWith($commune, 'xa ')) {
                    $commune = substr($commune, 3, strlen($commune));
                }
                if (!$exit_commune && strpos($add_processing, $commune)) {
                    $option_commune .= "<option value='$li->code' selected>$li->name </option>";
                    $exit_commune = true;
                } else {
                    $option_commune .= "<option value='$li->code'>$li->name </option>";
                }
            }
        }
    }
}
echo json_encode(array(
    "city" => $option_province,
    "district" => $option_district,
    "commune" => $option_commune
));
?>  