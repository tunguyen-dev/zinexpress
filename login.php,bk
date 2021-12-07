<?php
    include 'config.php';
    unset($_SESSION['user_logged']);
    unset($_SESSION['phone']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= Commons_WebConst::TITLE_WEB ?> - Đăng nhập</title>
        <?php include 'includes/inc_head.php'?>
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

    <body class="bg-gradient-primary">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Đăng nhập!</h1>
                                        </div>
                                        <form class="user" id="formLogin">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" placeholder="Số điện thoại hoặc Email..." name="user"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" placeholder="Mật khẩu..." name="password" />
                                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                          <!--   <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1" style="color: #333;font-size: 15px;font-weight: 400;margin-left: -10px;">Nhớ tài khoản</label>
                                            </div><br> -->
                                            <button type="submit" class="btn btn-primary btn-user btn-block" id="btn_login"> Đăng nhập</button>
                                            <div id="msg_err" style="text-align: center;" class="text-primary">
                                                <span class="spinner-border spinner-border-sm"></span> Xin mời chờ...
                                            </div>

                                            <span id="msg_err_log"></span>
                                           <!--  <a href="index.html" class="btn btn-google btn-user btn-block"> <i class="fab fa-google fa-fw"></i> Login with Google </a>
                                            <a href="index.html" class="btn btn-facebook btn-user btn-block"> <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook </a> -->
                                        </form>
                                        <hr />
                                        <div class="text-center">
                                            <a class="small" href="<?= Commons_WebConst::HTACCESS_FORGET ?>">Quên mật khẩu?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="<?= Commons_WebConst::HTACCESS_REGISTER ?>">Đăng ký tài khoản!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
