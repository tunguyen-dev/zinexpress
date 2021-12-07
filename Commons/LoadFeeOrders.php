<?php


class Commons_LoadFeeOrders
{   
    // private $type;
    public $fee_sameprice;
    // public $price_up;
    // public $weight_vuot;
    // public $price_max;
    
    function caculateFeeShip($user_id,$region_sender,$region_receiver,$area,$dis_id,$weight){
        $model_sp = new Models_SamePrices();
        $fee_sameprice = 0;
        /**************************** TỈNH TP *****************************************/
            $list_same_citi = $model_sp->customQuery("SELECT dis_id,weight,price,weight_plus,price_plus FROM SamePrices WHERE area = $area AND user_id = $user_id AND dis_id LIKE '%{$dis_id}%'");
            $count_same_citi = count($list_same_citi);
            
            if ($count_same_citi > 0) {
                $model_citi = new Models_Cities();
                $model_dis = new Models_Districts();
                $arr_same = "";
                foreach ($list_same_citi as $li) {
                    $check = false;
                    $arr_dis_id = explode(",", $li->dis_id);
                    foreach ($arr_dis_id as $dis) {
                        if (intval($dis) == intval($dis_id)) {
                            $check = true;
                        }
                    }
                    if ($check == true) {
                        $arr_same = array(
                            "weight" => $li->weight,
                            "price" => $li->price,
                            "weight_plus" => $li->weight_plus,
                            "price_plus" => $li->price_plus
                        );
                        break;
                    }
                }
                if (is_array($arr_same)) {
                    $obj_citi = $model_citi->getObjectByCondition('',array('code' => $area));
                    $obj_dis = $model_dis->getObjectByCondition('',array('code' => $dis_id));
                    if ($weight <= $arr_same['weight']) {
                        return array('fee_sameprice'=>$arr_same['price'],'type'=> "$obj_citi->name - $obj_dis->name"); 
                        exit;
                    }else {
                        //LẤY RA KL TĂNG 
                        $weight_plus = $arr_same['weight_plus'];
                        $weight_over = $weight - $arr_same['weight'];
                        $solan = ceil($weight_over/$weight_plus);
                        $price_plus = $arr_same['price_plus'];
                        $price_up = $price_plus*$solan;
                        $fee_ship = $arr_same['price']+$price_up;
                        return array('fee_sameprice'=>$fee_ship,'type'=> "$obj_citi->name - $obj_dis->name"); 
                        exit;
                    }
                    
                }
            }
        /**************************** END TỈNH TP *****************************************/


        /**************************** NỘI MIỀN *****************************************/
        if ($region_sender == $region_receiver) {
            $obj_in_region = $model_sp->getObjectByCondition('',array('area' => 101, 'user_id' => $user_id));
            if (is_object($obj_in_region)) {
                $weight_same = $obj_in_region->weight;
                $price = $obj_in_region->price;
                if ($weight <= $weight_same) {
                    return array('fee_sameprice'=>$price,'type'=> "Nội miền"); 
                    exit;
                }else {
                    //LẤY RA KL TĂNG 
                    $weight_plus = $obj_in_region->weight_plus;
                    $weight_over = $weight - $weight_same;
                    $solan = ceil($weight_over/$weight_plus);
                    $price_plus = $obj_in_region->price_plus;
                    $price_up = $price_plus*$solan;
                    $fee_ship = $price+$price_up;
                    return array('fee_sameprice'=>$fee_ship,'type'=> "Nội miền"); 
                    exit;
                }
            }
        }
        /**************************** LIÊN MIỀN *****************************************/
        elseif ($region_sender != $region_receiver) {
            $obj_out_region = $model_sp->getObjectByCondition('',array('area' => 102,'user_id' => $user_id));
            if (is_object($obj_out_region)) {
                $weight_same = $obj_out_region->weight;
                $price = $obj_out_region->price;
                if ($weight <= $weight_same) {
                    return array('fee_sameprice'=>$price,'type'=> "Liên miền"); 
                    exit;
                }else {
                    //LẤY RA KL TĂNG 
                    $weight_plus = $obj_out_region->weight_plus;
                    $weight_over = $weight - $weight_same;
                    $solan = ceil($weight_over/$weight_plus);
                    $price_plus = $obj_out_region->price_plus;
                    $price_up = $price_plus*$solan;
                    $fee_ship = $price+$price_up;
                    return array('fee_sameprice'=>$fee_ship,'type'=> "Liên miền"); 
                    exit;
                }
            }
        }
        /**************************** TOÀN QUỐC *****************************************/
            $obj_nationwide = $model_sp->getObjectByCondition('',array('area' => 100,'user_id' => $user_id));
            if (is_object($obj_nationwide)) {
                $weight_same = $obj_nationwide->weight;
                $price = $obj_nationwide->price;
                if ($weight <= $weight_same) {
                    return array('fee_sameprice'=>$price,'type'=> "Toàn quốc"); 
                    exit;
                }else {
                    //LẤY RA KL TĂNG 
                    $weight_plus = $obj_nationwide->weight_plus;
                    $weight_over = $weight - $weight_same;
                    $solan = ceil($weight_over/$weight_plus);
                    $price_plus = $obj_nationwide->price_plus;
                    $price_up = $price_plus*$solan;
                    $fee_ship = $price+$price_up;
                    return array('fee_sameprice'=>$fee_ship,'type'=> "Toàn quốc"); 
                    exit;
                }
            }
        /**************************** END TOÀN QUỐC *****************************************/
        return array('fee_sameprice'=> 0,'type'=> "Không thuộc gói nào");
        exit;
    }
    function caculateFeeCod($cod){
        $fee_cod = $cod*0.005;
        return $fee_cod;
    }
    function caculateFeeInsurance($value){
        $fee_insurance = $value*0.005;
        return $fee_insurance;
    }
    function caculateFeeDoiSoat($cod,$prepay,$fee,$fee_return,$fee_cod,$fee_insurance){
        $money = $cod+$prepay-$fee-$fee_return-$fee_cod-$fee_insurance;
        return $money;
    }
}


?>