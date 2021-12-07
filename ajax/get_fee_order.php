<?php
    include '../config.php';

    // get post data
    foreach($_POST as $key => $value) {
        $$key = Library_Validation::antiSql($value);
    }
    // echo "<pre />";
    // var_dump($_POST);
    if ($adminuser->same_price == 0) {
        echo '<div class="alert alert-danger" role="alert" >Tài khoản chưa được cài giá vui lòng liên hệ bộ phận CSKH</div>';
        exit();
    }

    //LAY THONG TIN DIA CHI GUI DI TU KHO HANG
    $model_ware = new Models_WareHouses();
    $obj_ware = $model_ware->getObject($ware_id);
    if (!is_object($obj_ware)) {
        echo '<div class="bg-danger p-xs b-r-sm" >Vui lòng tạo kho hàng trước khi tạo đơn</div>';
        exit();
    }
    
    if ($weight == "" || $weight == null) {
        $weight = 0;
    }
    if ($city == 0 || $district == 0) {
        echo '<div class="alert alert-danger" role="alert" >Vui lòng chọn đầy đủ địa chỉ giao hàng</div>';
        exit();
    }
    if ($weight >= $weight_exchange) {
        $weight_cal = $weight;
    }else{
        $weight_cal = $weight_exchange;
    }
    if ($weight_cal == 0) {
        echo '<div class="alert alert-danger" role="alert" >Vui lòng nhập khối lượng hàng hóa</div> ';
        exit();
    }
    

    // $model_cities = new Models_Cities();

    // // TINH/TP NGUOI GUI
    // $obj_sender_city = $model_cities->getObjectByCondition('',array('code' => $obj_ware->city));
    // $region_sender = $obj_sender_city->region;
    // $sender_city = $obj_ware->city;
    // // TINH/TP NGUOI NHAN
    // $obj_receiver_city = $model_cities->getObjectByCondition('',array('code' => $city));
    // $receiver_city = $city;
    // $region_receiver = $obj_receiver_city->region;

    // // QUAN/HUYEN NGUOI GUI
    // $model_dis = new Models_Districts();
    // $obj_sender_district = $model_dis->getObjectByCondition('',array('code' => $obj_ware->district));
    // $sender_dis = $obj_ware->district;
    // $sender_district = $obj_sender_district->name;
    // // QUAN/HUYEN NGUOI NHAN
    // $obj_receiver_district = $model_dis->getObjectByCondition('',array('code' => $district));
    // $receiver_district = $district;
    // $region_dis = $obj_receiver_district->region;

    // $Commons_Loadfe = new Commons_LoadFeeOrders();

    // $fee_sameprice_arr = $Commons_Loadfe->caculateFeeShip($adminuser->getId(),$region_sender,$region_receiver,$receiver_city,$receiver_district,$weight_cal);
    // echo $fee_sameprice = $fee_sameprice_arr['fee_sameprice'];
    // if ($fee_sameprice == 0) {
    //     echo '<div class="alert alert-danger" >Vùng hiện tại chưa được đồng giá</div>';
    //     exit();
    // }
    // if ($adminuser->fee_cod == 1 && $amount > 3000000) {
    //     $fee_cod = $Commons_Loadfe->caculateFeeCod($amount);
    // }else {
    //     $fee_cod = 0;
    // }
    // if ($adminuser->fee_insurance == 1 && $gia_tri > 3000000) {
    //     $fee_insurance = $Commons_Loadfe->caculateFeeInsurance($gia_tri);
    // }else {
    //     $fee_insurance = 0;
    // }
    // if ($payer == "") {
    //     $cod_payer = number_format($amount+$fee_sameprice);
    // }else {
    //     $cod_payer = number_format($amount);
    // }