<?php
require_once '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
if(empty($password) || strlen($password) <= 7) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mật khẩu phải trên 7 ký tự!'));
    exit();
}
$model_dropship = new Models_Dropshipers();
// $models_users = new Models_Users($users);
// if ok
$salt = md5(time().rand(10000,99999));
$password = hash('sha256', $password . $salt);
// $users = $models_users->getObjectByCondition('', array('phone' => $phone));
$dropship = $model_dropship->getObjectByCondition('', array('phone' => $phone));
$dropship->salt = $salt;
$dropship->password = $password;
$dropship->otp_reset_pass = 0;
$model_dropship->setPersistents($dropship);
$model_dropship->edit(array('password','salt','otp_reset_pass'), 1);

$_SESSION['dropshipers_logged'] = $dropship;
echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'đổi mật khẩu thành công'));

