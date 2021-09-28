<?php
session_start();
include '../config.php';

// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
// if(!isset($_COOKIE["member_login"])) {     
    // get user by username
    $models_users = new Models_Users();
    $pos = strpos($user, "@");
    if ($pos !== false) {
        $users = $models_users->getObjectByCondition('', array('email' => $user));
    } else{
        $users = $models_users->getObjectByCondition('', array('phone' => $user));
    }

    // print_r($admins)
    if(is_object($users) && $users->status == 1) {
        $salt = $users->salt;
        $password_true = $users->password;
        $password = hash('sha256', $password . $salt);
        
        if($password == $password_true) {
            // if(!empty($remember)) {
            //     setcookie ("member_login",$users,time()+ (3600 * 24 * 30));
            // } else {
            //     if(isset($_COOKIE["member_login"])) {
            //         setcookie ("member_login","");
            //     }
            // }
            if ($users->authenticator == "on" && $users->au_login == 1) {
                $_SESSION['phone'] = $users->phone;
                echo json_encode(array('code' => 2,'status' => true,'msg' => 'chuyển hướng xác thực!'));
            }
            else {
                // luu sesion 
                $_SESSION['user_logged'] = $users;
                echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'Đăng nhập thành công!'));
            }
        }
        else {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Mật khẩu không đúng!'));
        }
    }
    else {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Tài khoản không tồn tại!'));
    }
// }
