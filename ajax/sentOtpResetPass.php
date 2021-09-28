<?php
include '../config.php';

// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}


// get user by username
$models_dropshiper = new Models_Dropshipers();
$dropshiper = $models_dropshiper->getObjectByCondition('', array('phone' => $phone));
if ($dropshiper->status == 0) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Tài khoản đã bị khóa vui lòng liên hệ CSKH để được tư vấn!'));
    exit;
}
if(is_object($dropshiper)) {
    
    $dropshiper->otp_reset_pass = 1;
    $models_dropshiper->setPersistents($dropshiper);
    $models_dropshiper->edit(array('otp_reset_pass'), 1);

    $_SESSION['phone'] = $phone;

    echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'gui otp thanh cong!'));
}
else {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Tài khoản không tồn tại!'));
}