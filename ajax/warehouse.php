<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
if(!is_object($adminuser)) {
    echo json_encode(array('code' => 1, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}
if ($_function == "add_ware") {

    if(!Library_Validation::isPhoneNumber($phone)) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'SĐT không hợp lệ!'));
        exit();
    }
    if ($city == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Tỉnh/Thành Phố!'));
        exit();
    }
    if ($district == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Quận/Huyện!'));
        exit();
    }
    if ($commune == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Phường/Xã!'));
        exit();
    }
    $model_cities = new Models_Cities();
    $model_dis = new Models_Districts();
    $model_com = new Models_Communes();
    // LAY TINH
    $obj_receiver_province2 = $model_cities->getObjectByCondition('',array('code' => $city));
    $province_w = $obj_receiver_province2->name;
    //LAU HUYEN
    $obj_receiver_district2 = $model_dis->getObjectByCondition('',array('code' => $district));
    $district_w = $obj_receiver_district2->name;
    //LAY XA
    $obj_receiver_com2 = $model_com->getObjectByCondition('',array('code' => $commune));
    $com_w = $obj_receiver_com2->name;
    $user_id = $adminuser->getId();
    if (isset($user_id)) {
        
        $model_wares = new Models_WareHouses();
        $wares = new Persistents_WareHouses();
        $wares->user_id = $user_id;
        $wares->name = $name;
        $wares->phone = $phone;
        $wares->address = $address;
        $wares->city = $province_w;
        $wares->district = $district_w;
        $wares->commune = $com_w;
        $wares->time_created = time();
        $model_wares->setPersistents($wares);
        if ($model_wares->addV2(1)) {
            echo json_encode(array('code' => 0, 'msg' => 'Tạo kho thành công!'));
            exit();
        } else{
            echo json_encode(array('code' => 1, 'msg' => 'Tạo thất bại vui lòng liên hệ hỗ trợ!'));
            exit();
        }
    } else{
        echo json_encode(array('code' => 1, 'msg' => 'Chưa đăng nhập!'));
        exit();
    }
}elseif($_function == "load_data"){
    $model_ware = new Models_WareHouses();
    // $list_ware = $model_ware->getList2();
    $sql = "SELECT * FROM WareHouses WHERE user_id = {$adminuser->getId()} ";
    if (isset($status)) {
        $sql .= " AND status = $status";
    }
    if (isset($text_search) && $text_search != '') {
        $sql .= " AND (name LIKE '%$text_search%' OR phone LIKE '%$text_search%')";
    }
    // echo $sql;
    $list_ware = $model_ware->customQuery($sql);
    $html ='';
    $html = '<div class="row">';
    foreach ($list_ware as $ware){
        if($ware->status == 1){
            $html_status = "<p class='text-success'>
                <i class='fas fa-circle'></i>
                <span style='margin-left: 15px;'>Đang hoạt động</span>
            </p>";
            if ($ware->primary_selec == 0) {
                $html_trash = "
                    <span class='text-danger hover_active tooltip_style btn_trash_ware' data-id='".$ware->getId()."'>
                        <i class='fas fa-trash-alt'></i>
                        <span class='tooltiptext_style'>Tạm dừng hoạt động</span>
                    </span>
                ";
            }else{
                $html_trash = "";
            }
        }else{
            $html_status = "<p class='text-danger'>
                <i class='fas fa-circle'></i>
                <span style='margin-left: 15px;'>Tạm dừng hoạt động</span>
            </p>";
            $html_trash = "
                <span class='text-success hover_active tooltip_style btn_return_ware' data-id='".$ware->getId()."'>
                    <i class='fas fa-undo'></i>
                    <span class='tooltiptext_style'>Khôi phục</span>
                </span>
            ";
        }
        if ($ware->primary_selec == 0 && $ware->status == 1) {
            $html_primary = "
                <span class='text-primary hover_active tooltip_style btn_primary_selec' data-id='".$ware->getId()."'>
                    <i class='far fa-check-circle'></i>
                    <span class='tooltiptext_style'>Đặt kho mặc định</span>
                </span>
            ";
        }else{
            $html_primary = "";
        }
        $html .= "<div class='col-lg-6 col-md-12'>
        <div class='card shadow mb-4'>
            <div class='card-header py-3'>
                <span class='m-0 font-weight-bold text-primary'>$ware->name</span>
                <div class='float-right'>
                    $html_primary
                    <span class='text-warning hover_active tooltip_style btn_edit_ware' data-id='".$ware->getId()."'>
                        <i class='fas fa-edit'></i>
                        <span class='tooltiptext_style'>Chỉnh sửa</span>
                    </span>
                    $html_trash
                </div>
            </div>
            <div class='card-body'>
                <p>
                    <i class='fas fa-phone-alt'></i>
                    <span style='margin-left: 15px;'>$ware->phone</span>
                </p>
                <p>
                    <i class='fas fa-map-marker-alt'></i>
                    <span style='margin-left: 15px;'>$ware->address, $ware->commune, $ware->district, $ware->city</span>
                </p>
                $html_status            
            </div>
        </div>
    </div> ";
    }
    $html .= "</div>";
    echo $html;
}elseif($_function == "change_primary"){
    $id = intval($id);
    $model_ware = new Models_WareHouses();
    // LẤY BẢN GHI KHO MẶC ĐỊNH TRƯỚC ĐÓ
    $obj_primary = $model_ware->getObjectByCondition('',array('primary_selec' => 1));
    // BẢN GHI KHO TRUYỀN LÊN
    $obj_ware = $model_ware->getObject($id);
    if (is_object($obj_primary)) {
        // CHUYỂN KHO MẶC ĐỊNH TRƯỚC ĐÓ VỀ KHO THƯỜNG VÌ CHỈ CÓ 1 KHO MẶC ĐỊNH
        $obj_primary->primary_selec = 0;
        $model_ware->setPersistents($obj_primary);
        $model_ware->edit(array('primary_selec'), 1);

        // CHUYỂN KHO ĐƯỢC CHỌN THÀNH KHO MẶC ĐỊNH
        $obj_ware->primary_selec = 1;
        $model_ware->setPersistents($obj_ware);
        $model_ware->edit(array('primary_selec'), 1);

        echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Chọn kho mặc định thành công'));
    }else{
        // CHUYỂN KHO ĐƯỢC CHỌN THÀNH KHO MẶC ĐỊNH
        $obj_ware->primary_selec = 1;
        $model_ware->setPersistents($obj_ware);
        $model_ware->edit(array('primary_selec'), 1);

        echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Chọn kho mặc định thành công'));
    }
}elseif($_function == "trash_ware"){
    $id = intval($id);
    $model_ware = new Models_WareHouses();
    // BẢN GHI KHO TRUYỀN LÊN
    $obj_ware = $model_ware->getObject($id);
    $obj_ware->status = 0;
    $model_ware->setPersistents($obj_ware);
    $model_ware->edit(array('status'), 1);

    echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Đã tạm dừng hoạt động của kho: '.$obj_ware->name));
}elseif($_function == "return_ware"){
    $id = intval($id);
    $model_ware = new Models_WareHouses();
    // BẢN GHI KHO TRUYỀN LÊN
    $obj_ware = $model_ware->getObject($id);
    $obj_ware->status = 1;
    $model_ware->setPersistents($obj_ware);
    $model_ware->edit(array('status'), 1);

    echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Đã khôi phục hoạt động của kho: '.$obj_ware->name));
}elseif($_function == "load_form_edit"){
    $id = intval($id);
    $model_ware = new Models_WareHouses();
    // BẢN GHI KHO TRUYỀN LÊN
    $obj_ware = $model_ware->getObject($id);
    $model_cities = new Models_Cities();
    $list_cities_2 = $model_cities->getList2();
    $model_dis = new Models_Districts();
    $model_com = new Models_Communes();
    $obj_city = $model_cities->getObjectByCondition('',array('name' => $obj_ware->city));
    $obj_dis =  $model_dis->getObjectByCondition('',array('name' => $obj_ware->district));

    // LẤY CODE CỦA THÀNH PHỐ
    $code_city = $obj_city->code;
    $list_dis = $model_dis->customFilter('',array('citi_code' => $code_city));
    // LẪY MÃ CODE CỦA QUẬN/HUYỆN
    $code_dis = $obj_dis->code;
    $list_com = $model_com->customFilter('',array('dis_code' => $code_dis));

    $option_cities = '';
    $option_dis = '';
    $option_com = '';
    foreach ($list_cities_2 as $li_ci2) {
        $selected = "";
        if ($li_ci2->name == $obj_ware->city) {
            $selected = "selected";
        }
        $option_cities .= "<option $selected value='$li_ci2->code'>$li_ci2->name</option>";
    }
    foreach ($list_dis as $li_dis) {
        $selected_dis = "";
        if ($li_dis->name == $obj_ware->district) {
            $selected_dis = "selected";
        }
        $option_dis .= "<option $selected_dis value='$li_dis->code'>$li_dis->name</option>";
    }
    foreach ($list_com as $li_com) {
        $selected_com= "";
        if ($li_com->name == $obj_ware->commune) {
            $selected_com = "selected";
        }
        $option_com .= "<option $selected_com value='$li_com->code'>$li_com->name</option>";
    }
    $html = '';
    $html .= "
        <div class='form-group'>
            <input type='hidden' name='_function' value='edit_ware'>
            <input type='hidden' name='id_update' value='".$obj_ware->getId()."'>
            <input type='text' class='form-control form-control-user' placeholder='Tên kho (tên này sẽ hiển thi trên bill)' name='name' value='$obj_ware->name' required='' />
        </div>
        <div class='form-group'>
            <input type='text' class='form-control form-control-user' placeholder='Số điện thoại (số này sẽ hiển thị trên bill)' name='phone' required='' value='$obj_ware->phone'/>
        </div>
        <div class='form-group'>
            <input type='text' class='form-control form-control-user' placeholder='Địa chỉ chi tiết' name='address' value='$obj_ware->address' required=''/>
        </div>
        <div class='row'>
            <div class='col-lg-4 col-md-12'>
                <select class='form-control select2_js' name='city' id='city_edit' style='width: 100%'>
                    $option_cities      
                </select>
            </div>
            <div class='col-lg-4 col-md-12'>
                <div id='load_district_edit'>
                    <select class='form-control select2_js' name='district' id='district_edit' style='width: 100%'>
                        $option_dis
                    </select>
                </div>
            </div>
            <div class='col-lg-4 col-md-12'>
                <div id='load_commune_edit'>
                    <select class='form-control select2_js' name='commune' id='commune_edit' style='width: 100%'>
                        <option value='0'>Phường/Xã...</option>
                        $option_com
                    </select>
                </div>
            </div>
        </div>
    ";
    echo $html;
}elseif($_function == "edit_ware"){
    if(!Library_Validation::isPhoneNumber($phone)) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'SĐT không hợp lệ!'));
        exit();
    }
    if ($city == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Tỉnh/Thành Phố!'));
        exit();
    }
    if ($district == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Quận/Huyện!'));
        exit();
    }
    if ($commune == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng chọn Phường/Xã!'));
        exit();
    }
    $model_cities = new Models_Cities();
    $model_dis = new Models_Districts();
    $model_com = new Models_Communes();
    // LAY TINH
    $obj_receiver_province2 = $model_cities->getObjectByCondition('',array('code' => $city));
    $province_w = $obj_receiver_province2->name;
    //LAU HUYEN
    $obj_receiver_district2 = $model_dis->getObjectByCondition('',array('code' => $district));
    $district_w = $obj_receiver_district2->name;
    //LAY XA
    $obj_receiver_com2 = $model_com->getObjectByCondition('',array('code' => $commune));
    $com_w = $obj_receiver_com2->name;
    
    $array_update = array();

    $id = intval($id_update);
    $model_ware = new Models_WareHouses();
    // BẢN GHI KHO TRUYỀN LÊN
    $obj_ware = $model_ware->getObject($id);

    if ($name != $obj_ware->name) {
        $obj_ware->name = $name;
        array_push($array_update, "name");
    }
    if ($phone != $obj_ware->phone) {
        $obj_ware->phone = $phone;
        array_push($array_update, "phone");
    }
    if ($address != $obj_ware->address) {
        $obj_ware->address = $address;
        array_push($array_update, "address");
    }
    if ($province_w != $obj_ware->city) {
        $obj_ware->city = $province_w;
        array_push($array_update, "city");
    }
    if ($district_w != $obj_ware->district) {
        $obj_ware->district = $district_w;
        array_push($array_update, "district");
    }
    if ($com_w != $obj_ware->commune) {
        $obj_ware->commune = $com_w;
        array_push($array_update, "commune");
    }
    $model_ware->setPersistents($obj_ware);
    if ($model_ware->edit($array_update, 1)) {
        echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Chỉnh sửa thông tin kho thành công'));
    }else{
        echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Không có sự thay đổi nào'));
    }

}?>
