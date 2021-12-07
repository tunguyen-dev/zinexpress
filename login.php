<?php
    include 'config.php';
    unset($_SESSION['user_logged']);
    unset($_SESSION['phone']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= Commons_WebConst::TITLE_WEB ?> - Đăng nhập</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="<?= $icon_web?>" />
        <!--===============================================================================================-->
        <!-- <link rel="stylesheet" type="text/css" href="login_tem/vendor/bootstrap/css/bootstrap.min.css"> -->
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="login_tem/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="login_tem/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="login_tem/css/util.css">
        <link rel="stylesheet" type="text/css" href="login_tem/css/main.css?v=1.2">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
        <script src="js/sweetalert/sweetalert.min.js"></script>
        <script src="js/jquery.form.js"></script>
        <script>
            $(document).ready(function () {
                $("#msg_err").hide();
                $("#msg_err_log").hide();
                $("#formLogin").ajaxForm({
                    url : './ajax/login.php',
                    type : 'post',
                    dataType : 'json',
                    beforeSend : function() {
                        $("#msg_err").show();
                        $("#msg_err_log").hide();
                        $("#btn_login").hide();
                    },
                    success : function(data) {
                        if(data.code == 1) {
                            $("#msg_err").hide();
                            $("#msg_err_log").html("<span class='label label-danger'>" + data.msg + "</span>");
                            $("#btn_login").show();
                            $("#msg_err_log").show();
                        }
                        if(data.code == 0) {
                            location.href= "thong-ke";
                        }if(data.code == 2) {
                            location.href= "xac-thuc-2-yeu-to";
                        }
                    }
                });
                $(".toggle-password").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                        var input = $('#password');
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });
        </script>
        <style>
            .field-icon {
                float: right;
                margin-right: 10px;
                margin-top: -32px;
                position: relative;
                z-index: 2;
            }
            .field-icon:hover{
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div class="limiter">
            <div class="container-login100" style="background-image: url('login_tem/images/bg-01.jpg');">
                <div class="wrap-login100 p-t-30 p-b-50">
                    <span class="login100-form-title p-b-41" style="font-weight: 700">
                        Đăng nhập
                    </span>
                    <form class="login100-form validate-form p-b-33 p-t-5" id="formLogin">

                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" placeholder="Số điện thoại hoặc Email" name="user" required="" autofocus>
                            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" id="password" placeholder="Mật khẩu" name="password" required="">
                            <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>

                        <div class="container-login100-form-btn m-t-32">
                            <button class="login100-form-btn" style="font-weight: 700" id="btn_login">
                                Đăng nhập
                            </button>
                            <div class="clearfix"></div>
                            <div id="msg_err" style="text-align: center;" class="text-primary">
                                <span class="spinner-border spinner-border-sm"></span> Xin mời chờ...
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
