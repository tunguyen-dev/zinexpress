<?php
declare(strict_types=1);
include "../config.php";



// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

// get user by username
$model_dropship = new Models_Dropshipers();
$dropshiper = $model_dropship->getObjectByCondition('', array('phone' => $phone));
$secret = $dropshiper->key_secret;
require "../vendor/autoload.php";
$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
if (!empty($otp)) {
	$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
	if ($g->checkCode($secret, $otp)) {
		$_SESSION['dropshipers_logged'] = $dropshiper;
	    echo json_encode(array('code' => 0,'msg' => 'Đăng nhập thành công'));
	} else {
	    echo json_encode(array('code' => 1, 'msg' => 'Mã xác thực sai'));
	}

}else {
	echo json_encode(array('code' => 1, 'msg' => 'Vui lòng nhập mà xác thực!'));
}

?>
