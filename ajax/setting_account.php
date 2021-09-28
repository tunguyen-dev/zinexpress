<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
if(!is_object($adminuser)) {
    echo json_encode(array('code' => 1, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}
$web = Commons_WebConst::TITLE_WEB;
if($_function == "load_profile"){?>
    <div class="row">
        <div class="col-lg-4 col-md-12 b-r">
            <form id="formEditProfile">
                <div class="form-group">
                    <input type="hidden" name="_function" value="edit_profile">
                    <label style="color: #333;font-size: 15px">Tên shop, công ty</label>
                    <input type="text" class="form-control form-control-user" name="shop_name" value="<?= $adminuser->shop_name?>" required="" />
                </div>
                <div class="form-group">
                    <label style="color: #333;font-size: 15px">Email</label>
                    <input type="text" class="form-control form-control-user" readonly value="<?= $adminuser->email?>" name="email" required=""/>
                </div>
                <div class="form-group">
                    <label style="color: #333;font-size: 15px">Số điện thoại</label>
                    <input type="text" class="form-control form-control-user" readonly name="phone" value="<?= $adminuser->phone?>" required=""/>
                </div>
                <div class="form-group">
                    <label style="color: #333;font-size: 15px">CMT/ Mã số thuế</label>
                    <input type="text" class="form-control form-control-user" placeholder="CMT hoặc mã số thuế" name="identity_card" value="<?= $adminuser->identity_card?>"/>
                </div>
                <div id="btn_save">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
                <div id="msg_err_edit" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>
            </form>
        </div>
        <div class="col-lg-4 col-md-12 b-r">
            <form role="form" method="POST" id="form2FA">
                <div class="form-group">
                <!-- // khoatv edit for change ratio btn to toggle btn begin -->
                    <div class="row">
                        <h6 class="col "><strong>Xác minh mật khẩu 2 lớp</strong></h6>
                        <div class="col-auto">
                            <input name="authenticator" type="checkbox" class="js-switch" <?php echo ($adminuser->authenticator == "on") ? 'checked' : '' ?> />
                        </div>
                    </div>
                </div>
                <!-- // khoatv edit for change ratio btn to toggle btn end -->
                <div class="form-group">
                    <input type="text" placeholder="Mã xác thực" class="form-control" required="" name="otp">
                </div>
                <div class="form-group">
                    <p id="msg_err_2fa"></p>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="btn-2fa"><strong>Xác nhận</strong></button>
                </div>
            </form>
            <div style="text-align: justify">
                <p><strong><span class='text-danger'>**Chú ý:</span></strong> nếu chọn <strong>TẮT</strong> chúng tôi sẽ tạo ra mã QR Code mới do đó bạn cần quét lại mã QR Code.</p>

                <span><strong><span class='text-success'>Hướng dẫn: </span></strong>để kích hoạt dịch vụ bảo mật 2 lớp bạn cần quét mã QR Code bằng ứng dụng Google Authenticator trên thiết bị của bạn sau đó chọn <strong>BẬT</strong> nhập mã xác thực bấm xác thực để kích hoạt dịch vụ</span>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <h4>Ảnh QR Code</h4>
            <?php if ($adminuser->authenticator == "off") {
                
                require '../vendor/autoload.php';
                $secret = $adminuser->key_secret;
                $link =  \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($adminuser->phone, $secret, $web);
            ?>
                <div>
                    <p class="text-center"><img src="<?= $link?>" alt=""></p>
                </div>
                <div style="text-align: justify">
                    <p><strong><span class='text-danger'>**Khuyến nghị: nên bật chức năng xác thực 2 lớp để bảo mật tài khoản tốt nhất.</p></span></strong>
                </div>
            <?php }?>
            <?php if ($adminuser->authenticator == "on") {?>
                <div class="alert alert-info" style="color: black;text-align: justify">
                    <p>Đang bật dịch vụ đăng nhập 2 lớp nên chúng tôi sẽ ẩn đi mã QR Code và mã SECRET. Để tắt vui lòng chọn <strong>TẮT</strong> và nhập mã xác minh.</p>
                </div>
            <?php }?>

        </div>
    </div>  
<?php }elseif ($_function == 'edit_profile') {
    $model_user = new Models_Users();
    $array_update = array();
    if ($shop_name != $adminuser->shop_name) {
        $adminuser->shop_name = $shop_name;
        array_push($array_update, "shop_name");
    }
    if ($identity_card != $adminuser->identity_card) {
        $adminuser->identity_card = $identity_card;
        array_push($array_update, "identity_card");
    }
    $model_user->setPersistents($adminuser);
    if ($model_user->edit($array_update, 1)) {
        echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Cập nhật thông tin thành công'));
    }else{
        echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Không có sự thay đổi nào'));
    }
}elseif($_function == 'load_userbank'){?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form role="form" id="formSaveBank">
                <input type="hidden" name="_function" value="save_bank">
                <div class="form-group">
                    <select name="bank_id" class="form-control select2_js" style="width: 100%">
                        <option value="0">Chọn tên ngân hàng</option>
                        <?php
                            $models_banks = new Models_Banks();
                            $list_banks = $models_banks->customFilter('', array('status' => 1), 'ID ASC');
                            $id_check = $adminuser->bank_id;
                            foreach($list_banks as $banks) {
                                if ($id_check == $banks->getId()) {
                                    $check = "selected";
                                }else{
                                    $check = "";
                                }
                                echo "<option value='{$banks->getId()}' $check> {$banks->name} </option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Chi nhánh ngân hàng..." value="<?= $adminuser->acc_branch?>" required="" class="form-control" name="acc_branch">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Chủ tài khoản..." value="<?= $adminuser->acc_name?>" required="" class="form-control" name="acc_name">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Số tài khoản..." value="<?= $adminuser->acc_number?>" required="" class="form-control" name="acc_number">
                </div>
                <!-- <div class="form-group">
                    <p id="msg_err_bank"></p>
                </div> -->
                <?php if ($adminuser->authenticator == 'on') {?>
                    <div class="form-group">
                        <input type="text" placeholder="Mã xác thực 2 lớp..." required="" class="form-control" name="opt_check">
                    </div>
                <?php }?>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="btn_add_bank"><strong><i class="far fa-save"></i> Lưu</strong></button>
                </div>
            </form>
        </div>
    </div>
<?php }elseif($_function == 'save_bank'){
    if (!Library_Validation::isNumber($acc_number)) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Số tài khoản chỉ được chứa số'));
        exit;
    }
    if ($bank_id == 0) {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Chưa chọn ngân hàng'));
        exit;
    }
    $check = true;
    $model_user = new Models_Users();
    // $array_update = array();
    if (isset($opt_check)) {
        if (!Library_Validation::isNumber($opt_check)) {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực chỉ được chứa số'));
            exit;
        }
        if ($opt_check == 0 || $opt_check == '') {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng nhập mã xác thực'));
            exit;
        }
        $check = false;
        $secret = $adminuser->key_secret;
        require "../vendor/autoload.php";
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if ($g->checkCode($secret, $opt_check)) {
            $check = true;
        }else {
            $check = false;
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực sai'));
            exit;

        }
    }
    if ($check == true) {
        if ($bank_id != $adminuser->bank_id) {
            $adminuser->bank_id = $bank_id;
            array_push($array_update, "bank_id");
        }
        if ($acc_branch != $adminuser->acc_branch) {
            $adminuser->acc_branch = $acc_branch;
            array_push($array_update, "acc_branch");
        }
        if ($acc_number != $adminuser->acc_number) {
            $adminuser->acc_number = $acc_number;
            array_push($array_update, "acc_number");
        }
        if ($acc_name != $adminuser->acc_name) {
            $adminuser->acc_name = $acc_name;
            array_push($array_update, "acc_name");
        }
        $model_user->setPersistents($adminuser);
        if ($model_user->edit($array_update, 1)) {
            echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Cập nhật thông tin thành công'));
        }else{
            echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Không có sự thay đổi nào'));
        }
    }else{
        echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Chưa xác thực mã bảo mật'));
    }
}elseif($_function == 'load_change_pass'){?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form role="form" id="formChangePass">
                <input type="hidden" name="_function" value="change_password">
                <div class="form-group">
                    <input type="password" placeholder="Nhập mật khẩu cũ..." required="" class="form-control" name="old_pass">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Nhập mật khẩu mới..." required="" class="form-control" name="new_pass">
                </div>
                <?php if ($adminuser->authenticator == 'on') {?>
                    <div class="form-group">
                        <input type="text" placeholder="Mã xác thực 2 lớp..." required="" class="form-control" name="opt_check">
                    </div>
                <?php }?>
                <div class="form-group mt-4">
                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="btn_save_pass"><strong><i class="far fa-save"></i> Cập nhật</strong></button>
                </div>
            </form>
        </div>
    </div>
<?php }elseif ($_function == 'change_password') {
    $model_user = new Models_Users();
    $obj_user = $model_user->getObject($adminuser->getId());
    $secret = $obj_user->key_secret;
    $salt = $obj_user->salt;

    $password_new = hash('sha256', $new_pass . $salt);
    $password_old = hash('sha256', $old_pass . $salt);
    $password_true = $obj_user->password;
    $check = true;
    if ($password_true == $password_old) {
        if ($password_new == $password_true) {
            echo json_encode(array('code' => 1, 'msg' => 'Mật khẩu mới trùng với mật khẩu cũ!'));
            exit;
        }
        if (isset($opt_check)) {
            if (!Library_Validation::isNumber($opt_check)) {
                echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực chỉ được chứa số'));
                exit;
            }
            if ($opt_check == 0 || $opt_check == '') {
                echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng nhập mã xác thực'));
                exit;
            }
            $check = false;
            $secret = $adminuser->key_secret;
            require "../vendor/autoload.php";
            $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
            if ($g->checkCode($secret, $opt_check)) {
                $check = true;
            }else {
                $check = false;
                echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực sai'));
                exit;

            }
        }
        if ($check == true) {
            $obj_user->password = $password_new;
            $model_user->setPersistents($obj_user);      
            if ($model_user->edit(array('password'), 1)) {
                echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Cập nhật thành công'));
            }else{
                echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Có lỗi xảy ra!'));
            }
        }
    }else{
        echo json_encode(array('code' => 1, 'msg' => 'Mật khẩu cũ không đúng!'));
        exit;
    }
}elseif($_function == 'load_config_orders'){?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form role="form" id="formConfigOrder">
                <input type="hidden" name="_function" value="config_order">
                <div class="form-group">
                    <label style="margin-left: -10px;color:#333;font-size: 17px;font-weight: 800;">TÙY CHỌN LẤY HÀNG</label>
                    <div class="form-check mt-1">
                        <input class="form-check-input" type="radio" name="config_pickup" id="pickup_home"    value="0" <?php echo ($adminuser->config_pickup == 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="pickup_home" style="color:#333;font-size: 15px;font-weight: 400;">
                            Đến lấy tại nhà
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="config_pickup" id="pickup_post" value="1" <?php echo ($adminuser->config_pickup == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="pickup_post" style="color:#333;font-size: 15px;font-weight: 400;">
                            Gửi hàng tại bưu cục
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label style="margin-left: -10px;color:#333;font-size: 17px;font-weight: 800;">NGƯỜI TRẢ CƯỚC</label>
                    <div class="form-check mt-1">
                        <input class="form-check-input" type="radio" name="config_payer" id="sender" value="0" <?php echo ($adminuser->config_payer == 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="sender" style="color:#333;font-size: 15px;font-weight: 400;">
                            Người gửi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="config_payer" id="receiver" value="1" <?php echo ($adminuser->config_payer == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="receiver" style="color:#333;font-size: 15px;font-weight: 400;">
                            Người nhận
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label style="margin-left: -10px;color:#333;font-size: 17px;font-weight: 800;">GHI CHÚ ĐƠN HÀNG</label>
                    <div class="form-check mt-1">
                        <input class="form-check-input" <?php echo ($adminuser->config_note_select == 0) ? 'checked' : '' ?> type="radio" name="config_note_select" id="seen" value="0">
                        <label class="form-check-label" for="seen" style="color:#333;font-size: 15px;font-weight: 400;">
                            Cho khách xem hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" <?php echo ($adminuser->config_note_select == 1) ? 'checked' : '' ?> type="radio" name="config_note_select" id="noseen" value="1">
                        <label class="form-check-label" for="noseen" style="color:#333;font-size: 15px;font-weight: 400;">
                            Không cho khách xem hàng
                        </label>
                    </div>
                    <textarea class="form-control mt-1" name="config_note_text" rows="3" placeholder="Thêm ghi chú khác"><?= $adminuser->config_note_text?></textarea>
                </div>
               
                <?php if ($adminuser->authenticator == 'on') {?>
                    <div class="form-group">
                        <input type="text" placeholder="Mã xác thực 2 lớp..." required="" class="form-control" name="opt_check">
                    </div>
                <?php }?>
                <div class="form-group mt-4">
                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="btn_save_order"><strong><i class="far fa-save"></i> Cập nhật</strong></button>
                </div>
            </form>
        </div>
    </div>
<?php }elseif($_function == 'config_order'){
    $check = true;
    $model_user = new Models_Users();
    // $array_update = array();
    if (isset($opt_check)) {
        if (!Library_Validation::isNumber($opt_check)) {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực chỉ được chứa số'));
            exit;
        }
        if ($opt_check == 0 || $opt_check == '') {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng nhập mã xác thực'));
            exit;
        }
        $check = false;
        $secret = $adminuser->key_secret;
        require "../vendor/autoload.php";
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if ($g->checkCode($secret, $opt_check)) {
            $check = true;
        }else {
            $check = false;
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mã xác thực sai'));
            exit;

        }
    }
    if ($check == true) {
        if ($config_pickup != $adminuser->config_pickup) {
            $adminuser->config_pickup = $config_pickup;
            array_push($array_update, "config_pickup");
        }
        if ($config_note_select != $adminuser->config_note_select) {
            $adminuser->config_note_select = $config_note_select;
            array_push($array_update, "config_note_select");
        }
        if ($config_note_text != $adminuser->config_note_text) {
            $adminuser->config_note_text = $config_note_text;
            array_push($array_update, "config_note_text");
        }
        if ($config_payer != $adminuser->config_payer) {
            $adminuser->config_payer = $config_payer;
            array_push($array_update, "config_payer");
        }
        $model_user->setPersistents($adminuser);
        if ($model_user->edit($array_update, 1)) {
            echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Cập nhật thông tin thành công'));
        }else{
            echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Không có sự thay đổi nào'));
        }
    }else{
        echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Chưa xác thực mã bảo mật'));
    }
}?>
