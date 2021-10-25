<?php
require_once '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

// check name
// if($shop_name == "" || strlen($shop_name) >= 30) {
//     echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Tên nhỏ hơn 30 ký tự!'));
//     exit();
// }

// check valid phone
if(!Library_Validation::isPhoneNumber($phone)) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Số điện thoại không hợp lệ!'));
    exit();
}

// check valid email
if(!Library_Validation::isEmailValid($email)) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Email không hợp lệ!'));
    exit();
}

if(empty($password) || strlen($password) <= 7) {
    echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mật khẩu phải trên 7 ký tự!'));
    exit();
}
// check name
// if($post_code == "") {
//     echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Vui lòng nhập mã bưu cục!'));
//     exit();
// }
$models_user = new Models_Users();

// if ok
$salt = md5(time().rand(10000,99999));
$password = hash('sha256', $password . $salt);
$user = new Persistents_Users();
$user->shop_name = $shop_name;
$user->phone = $phone;
$user->email = $email;
$user->salt = $salt;
$user->password = $password;
// $user->post_code = $post_code;

$user_phone = $models_user->getObjectByCondition('',array('phone' => $phone));
$user_email = $models_user->getObjectByCondition('',array('email' => $email));
if (is_object($user_phone)) {
    echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'SĐT đăng ký đã tồn tại!'));
    exit;
}elseif (is_object($user_email)) {
    echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Email đăng ký đã tồn tại!'));
    exit;
}
$user->key_secret = $key_secret;
$user->authenticator = 'off';
$user->time_created = time();
$user->status = 1;
$models_user->setPersistents($user);
$user_id = $models_user->addV2(1);

if($user_id) {
    echo json_encode(array('status' => true, 'code' => 0, 'msg' => 'Đăng ký thành công'));
}
else {
    echo json_encode(array('status' => false, 'code' => 1, 'msg' => 'Lỗi đăng ký. Vui lòng phản hồi hỗ trợ!'));
}

