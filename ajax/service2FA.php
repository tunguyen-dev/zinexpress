<?php
declare(strict_types=1);
include "../config.php";
if(!is_object($adminuser)) {
    echo "bạn chưa đăng nhập";
    exit();
}

// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

// get user by username
$model_user = new Models_Users();
$secret = $adminuser->key_secret;

if (!isset($authenticator)) {
    $authenticator = 'off';
} else {
    $authenticator = 'on';
}
if ($authenticator == $adminuser->authenticator) {
    echo json_encode(array('code' => 1, 'msg' => 'Trạng thái không có sự thay đổi vui lòng thao tác!'));
    exit;
}
// echo $authenticator;
// exit;
require "../vendor/autoload.php";
$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
$check;
$key_secret = $g->generateSecret();
if (!empty($otp)) {
	$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
	if ($g->checkCode($secret, $otp)) {
		$authenticator = $adminuser->authenticator;
		if ($authenticator == "on") {
			$check = false;
			$adminuser->authenticator = "off";
			$adminuser->key_secret = $key_secret;
		}
		if ($authenticator == "off") {
			$check = true;
			$adminuser->authenticator = "on";
		}
		$model_user->setPersistents($adminuser);
		if ($check == true) {
			$model_user->edit(array('authenticator'), 1);
		}else{
			$model_user->edit(array('authenticator','key_secret'), 1);
		}
	    echo json_encode(array('code' => 0,'msg' => 'Xác thực thành công'));
        exit;
	} else {
	    echo json_encode(array('code' => 1, 'msg' => 'Mã xác thực sai'));
        exit;
	}

}else {
	echo json_encode(array('code' => 1, 'msg' => 'Vui lòng nhập mã xác thực!'));
    exit;
}

?>
