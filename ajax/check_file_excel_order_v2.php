<?php 
use PhpOffice\PhpSpreadsheet\IOFactory;

include '../config.php';
include '../Classes/PHPExcel.php';
include '../vendor/autoload.php';
//place this before any script you want to calculate time

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

if(!is_object($adminuser)) {
    echo json_encode(array('code' => 1,'status' => false, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}
$db = Models_Db::getDBO();
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
if ($adminuser->config_note_select == 0) {
    $note_select = "Cho khách xem hàng";
}else{
    $note_select = "Không cho khách xem hàng";
}
if ($adminuser->config_note_text == '' || $adminuser->config_note_text == null) {
    $note_select .= ", ".$adminuser->config_note_text;
}else{
    $note_select = $note_select;
}
if ($_FILES['file']['tmp_name']) {
    $file = $_FILES['file']['tmp_name'];
    $extendFile = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    if (!in_array(basename($extendFile), array('xls', 'xlsx'))) {
        echo json_encode(array('code' => 1, 'msg' => 'Chỉ được upload các định dạng xls, xlsx!'));
        exit();
    }
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = [];
    $errHead = '';
    $arrHead = Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER;
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        if ($row->getRowIndex() == 4) {
            foreach ($cellIterator as $cell) if (isset(Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['name'] ) && Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['name'] != null) {
                if ( isset(Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['name']) && Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['name'] != $cells[] = $cell->getValue()) {
                    $errHead .= 'Cột ' . $cell->getColumn() . ' không hợp lệ trong mẫu tạo đơn hàng, ';
                }
            }
            if ($errHead != '') {
                echo json_encode(array('code' => 1, 'msg' => $errHead));
                exit();
            }
        } elseif ($row->getRowIndex() > 5) {
            $flag = false;
            foreach ($cellIterator as $cell) {
                if (isset(Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['value']) && Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['value'] == 'formular') {
                    $formular_value = $cell->getOldCalculatedValue();
                    if ($formular_value == null || $formular_value == '') {
                        $formular_value = $cell->getValue();
                    }
                    $cells[] = $formular_value;
                } elseif (isset(Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['value']) && Commons_UploadConst::UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE[$cell->getColumn()]['value'] == 'value') {
                    $value = $cell->getValue();
                    $value = str_replace('"', '', $value);
                    $value = str_replace("'", '', $value);
                    $cells[] = $value;
                    //$cells[] = $cell->getValue();
                }
                if ($cell->getColumn() == "D") {
                    if ($cell->getValue() != null && $cell->getValue() != '') {
                        $flag = true;
                    }
                }
            }
            if ($flag) $data[] = $cells;
        }
    }
    if ($data == null || count($data) == 0) {
        echo json_encode(array('code' => 1, 'msg' => 'File tải lên không có dữ liệu '));
        exit();
    }
    $htmlTable = '';
    $model_cities = new Models_Cities();
    $list_cities = $model_cities->getList2();
    $option_province = '';
    $model_com = new Models_Communes();
    $model_dis = new Models_Districts();
    // $model_order = new Models_Orders();;
    $array_done = array();
    $htmlTable_total = '';
    $msg_error = '';

    $total_count = 0;
    $stt = 0;
    $br = '';

    foreach ($data as $excel) {

        $option_province = '';

        $total_count++;

        $element_error = '';
        $soc = $excel[1];
        $soc = preg_replace('/\s+/', '', $soc);
        $soc = str_replace('\\', '', $soc);
        $product = $excel[5];
        if(!isset($product)) {
            $element_error .= " Trường '" . $arrHead[5] . "' không được để trống,00000 ";
        }


        $product = str_replace('\\', '', $product);
        $name = $excel[2];          
        $name = str_replace('\\', '', $name);
        $phone = $excel[3];
        $phone = str_replace('\\', '', $phone);
        $phone = preg_replace('/\s+/', '', $phone);
        if (strlen($phone) == 9 && substr($phone, 0, strlen($phone)) != '0') {
            $phone = '0' . $phone;
        }
        $valid_phone = true;
        if ($phone == null || $phone == '' || (strlen($phone) != 10 && strlen($phone) != 11) ) {
            $valid_phone = false;
        }


        if ($phone == null && $phone == '') {
            $element_error .= "(Dòng $stt) Trường '" . $arrHead[2] . "' không được để trống, ";
        }
        $address = $excel[4];
        $address = str_replace('\\', '', $address);
        if ($address == null || $address == '') {
             $element_error .= " Trường '" . $arrHead[3] . "' không được để trống, ";
        }

        $cod = $excel[8];
        $cod = str_replace('\\', '', $cod);
        $cod = intval(str_replace(".00", "", $cod));
        $insured = '0';
        $insured = str_replace('\\', '', $insured);
        $insured = intval(str_replace(".00", "", $insured));
        $price = $excel[7];
        $price = str_replace('\\', '', $price);
        $price = intval(str_replace(".00", "", $price));
        $weight = $excel[6];
        $weight = str_replace('\\', '', $weight);
        $array_split_add = multiexplode(array(",", ".", "|", ";", "/"), preg_replace('!\s+!', ' ', strtolower(Commons_Formulars::stripVN(trim($address, ' ')))));
        $exit_province = false;
        $province_select = 0;
        $exit_district = false;
        $district_select = 0;
        $option_district = '';
        $citi_code = 0;
        $district_code = 0;
        $commune_code = 0;
        $district = '';
        $city = '';
        $regex_site_name = '';
        $select_province = false;
        $select_district = false;

        $province_select_text = '';
        $district_select_text = '';
        $commune_select_text = '';

        if ($address != null && $address != '') {
            $pro_pt = strtolower(Commons_Formulars::stripVN(preg_replace('!\s+!', ' ', strtolower(trim($array_split_add[count($array_split_add) - 1], ' ')))));
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
                $search_province = strtolower(Commons_Formulars::stripVN($li->name));
                if (!$exit_province && strtolower(Commons_Formulars::stripVN($search_province)) == $pro_pt ||
                    strpos(strtolower(Commons_Formulars::stripVN($search_province)), $pro_pt)) {
                    $option_province .= "<option value='$li->code' selected>$li->name </option>";
                    $province_select = $li->code;
                    $exit_province = true;

                    $province_select_text = $li->name;

                    $city = strtolower(Commons_Formulars::stripVN($li->name));
                    if (startsWith($city, 'thanh pho ')) {
                        $city = substr($city, 10, strlen($city));
                    } elseif (startsWith($city, 'tinh ')) {
                        $city = substr($city, 5, strlen($city));
                    }
                    $select_province = true;
                } else {
                    $option_province .= "<option value='$li->code'>$li->name </option>";
                }
            }
            if ($exit_province) {
                $list_dis = $model_dis->customFilter('', array('citi_code' => $province_select));
                $district_pt = strtolower(Commons_Formulars::stripVN(strtolower(trim($array_split_add[count($array_split_add) - 2], ' '))));
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
                } elseif (
                startsWith($district_pt, 'thi xa')
                ) {
                    $district_pt = substr($district_pt, 7, -1);
                }
                foreach ($list_dis as $li) {
                    if (!$exit_district && strtolower(Commons_Formulars::stripVN($li->name)) == $district_pt ||
                        strpos(strtolower(Commons_Formulars::stripVN($li->name)), $district_pt)) {
                        $option_district .= "<option value='$li->code' selected>$li->name </option>";
                        $select_district = true;
                        $exit_district = true;
                        $district_select = $li->code;
                        $district_select_text = $li->name;
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
            }elseif($exit_province){
                $list_dis = $model_dis->customFilter('', array('citi_code' => $province_select));
                foreach ($list_dis as $li) {
                    $option_district .= "<option value='$li->code' data-id='$key'>$li->name</option>";
                }
            }

            $exit_commune = false;
            $option_commune = '';
            if ($exit_district) {
                $commune_pt = strtolower(Commons_Formulars::stripVN(trim($array_split_add[count($array_split_add) - 3], ' ')));
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
                } elseif (
                startsWith($commune_pt, 'thi xa')
                ) {
                    $commune_pt = substr($commune_pt, 7, -1);
                }
                $list_com = $model_com->customFilter('', array('dis_code' => $district_select));
                foreach ($list_com as $li) {
                    if (!$exit_commune && strtolower(Commons_Formulars::stripVN($li->name)) == $commune_pt ||
                        strpos(strtolower(Commons_Formulars::stripVN($li->name)), $commune_pt)) {
                        $option_commune .= "<option value='$li->code' selected>$li->name </option>";
                        $exit_commune = true;
                        $commune_select_text = $li->name;
                    } else {
                        $option_commune .= "<option value='$li->code'>$li->name</option>";
                    }
                }
            }
        }else {
            foreach ($list_cities as $li) {
                $option_province .= "<option value='$li->code'>$li->name</option>";
            }
        }
        $province_class = 'city';
        if (!$select_province) {
            $province_class .= ' city_un_defined';
        }
        $district_class = 'district';
        $commune_class = 'commune';
        if (!$select_district) {
            $district_class .= ' district_un_defined';
            $commune_class .= ' commune_un_defined';
        }

        $weight = intval(str_replace(".00", "", $weight));
        $length = $excel[9];
        $length = str_replace('\\', '', $length);
        $length = intval(str_replace(".00", "", $length));
        $width = $excel[10];
        $width = str_replace('\\', '', $width);
        $width = intval(str_replace(".00", "", $width));
        $height = $excel[11];
        $height = str_replace('\\', '', $height);
        $height = intval(str_replace(".00", "", $height));

        
        if ($element_error != '') {
            $msg_error .= $br . 'SĐT ' . ($phone) . ' Lỗi: ' . $element_error;
            $br = '<br><br>';
        }
        $note = $excel[12];

        $note = $note_select.(str_replace('\\', '', $note));

        if ($select_district && $select_province && $valid_phone && $exit_commune
            && ($address != null && $address != '')
            && ($name != null && $name != '')
            && ($product != null && $product != '')
            && ($weight != null && $weight != '')
            && ($cod != null && $cod != '')
            && ($price != null && $price != '')
        ) {

            if($commune_select_text == '') {
                $commune_select_text = '_0_Phường xã...';
            }
            array_push($array_done, array(
                "name"=>$name,
                "phone"=>$phone,
                "soc"=>$soc,
                "product"=>$product,
                "note"=>$note,
                "address"=>$address,
                "city"=>$province_select_text,
                "district"=>$district_select_text,
                "commune"=>$commune_select_text,
                "weight"=>$weight,
                "length"=>$length,
                "height"=>$height,
                "width"=>$width,
                "value"=>$price,
                "amount"=>$cod,));

        } else {
            $stt++;
            $htmlTable = '';

            $htmlTable .= '<tr>';

            $htmlTable .= "<td>$stt</td>";


            $htmlTable .= "<td style='width:15% !important'>
                                <input placeholder='tên khách hàng' class='form-control input-sm name' type='text' value='" . $name . "'>
                                <input placeholder='sdt khách hàng (*)' class='form-control input-sm phone' type='Number' value='" . $phone . "'>
                                <div class='label label-danger error_msg_name' style='display: none;'></div>
                                <div class='label label-danger error_msg_phone' style='display: none;'></div>
                                <div class='label label-danger error_msg_product' style='display: none;'></div>
                                <div class='label label-danger error_msg_address'  style='display: none;'></div>
                                <div class='label label-danger error_msg_city' style='display: none;'></div>
                                <div class='label label-danger error_msg_district' style='display: none;'></div>
                                <div class='label label-danger error_msg_commune' style='display: none;'></div>
                                <div class='label label-danger error_msg_weight' style='display: none;'></div>
                                <div class='label label-danger error_msg_length' style='display: none;'></div>
                                <div class='label label-danger error_msg_width' style='display: none;'></div>
                                <div class='label label-danger error_msg_height' style='display: none;'></div>
                                <div class='label label-danger error_msg_amount' style='display: none;'></div>
                                <div class='label label-danger error_msg_value' style='display: none;'></div>
                                <div class='label label-danger error_msg_warehouse' style='display: none;'></div>
                         </td>";

            $htmlTable .= "<td style='width:25% !important'>
                            <input placeholder='Mã đơn hàng' class='form-control input-sm soc' type='text' value='" . $soc . "'>
                            <input placeholder='Tên sản phẩm' class='form-control input-sm product' type='text' value='" . $product . "'>
                            <textarea placeholder='ghi chú' class='form-control input-sm note' type='text' value='' style='width: 99%; margin-top: 0px; margin-bottom: 0px; height: 80px;' >" . $note . "</textarea>
                            ";

            $htmlTable .= "</select>
                                
                     </td>";

            $htmlTable .= "<td style='width:40% !important'>
                        <textarea placeholder='địa chỉ chi tiết, xã, huyện, tỉnh' class='form-control input-sm address' type='text' value='$address'  style='width: 99%; margin-top: 0px; margin-bottom: 0px; height: 80px;'>$address</textarea>
                        <select class='form-control input-sm $province_class'>
                            <option value='0' >Tỉnh/Thành...</option>
                            $option_province
                        </select>
                                                            <br>
                        <select class='form-control input-sm $district_class'>    
                            <option value='0' >Quận/Huyện...</option>
                            $option_district
                        </select>
                        <br>
                        <select class='form-control input-sm $commune_class'>
                             <option value='0' >Phường/Xã...</option>
                             $option_commune
                         </select>
                     </td>";

            $htmlTable .= "<td style='width:20% !important'>
                        <table style='width: 99%'>
                        <tbody>
                            <tr>
                                <td style='width: 30%'>KL [gr]</td>
                                <td>
                                <input class='form-control input-sm  format_number weight' type='text' value='" . number_format($weight) . "'>
                                </td>
                            </tr>
                            <tr><td style='width: 35%'>COD [đ]</td><td><input class='form-control input-sm format_number amount' type='text' value='" . number_format($cod) . "'></td></tr>
                            <tr><td style='width: 35%'>Giá trị[đ]</td><td><input class='form-control input-sm  format_number value' type='text' value='" . number_format($price) . "'></td></tr>
                        </tbody>
                        </table>
                        </td>";
            $htmlTable .= '</tr>';

            $htmlTable_total .= $htmlTable; // . $htmlTable_total;
        }
    }
    if ($msg_error != '') {
        echo json_encode(array('code' => 1, 'msg' => $msg_error));
    } else {
        echo json_encode(array('code' => 0, 'body_table' => $htmlTable_total,
            'array_verified'=> $array_done,
            'total_count'=>$total_count,
            'success_count'=>count($array_done),
            'error_count'=>$stt
        ));
    }
}else{
    echo json_encode(array('code' => 1,'status' => false,'msg' => 'Hãy chọn file tải lên!'));
}    

?>
 