<?php
require_once '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

if(empty($password) || strlen($password) <= 7) {
    echo json_encode(array('code' => 1, 'msg' => 'Mật khẩu phải trên 7 ký tự!'));
    exit();
}

$model_dropship = new Models_Dropshipers();
// if ok
$salt = md5(time().rand(10000,99999));
$password = hash('sha256', $password . $salt);
$dropship = $model_dropship->getObjectByCondition('', array('email' => $email));
if (is_object($dropship)) {
    $dropship->salt = $salt;
    $dropship->password = $password;
    $dropship->code_reset_pass = '';

    $model_dropship->setPersistents($dropship);
    if ( $model_dropship->edit(array('password','salt','code_reset_pass'), 1)) {
        $_SESSION['dropshipers_logged'] = $dropship;
        echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'đổi mật khẩu thành công'));
        exit;
    }else {
        echo json_encode(array('code' => 1, 'msg' => 'Có lỗi xảy ra!'));
    }

    
    
} else{
    echo json_encode(array('code' => 1, 'msg' => 'Lỗi link đổi mật khẩu không đúng!'));
}


