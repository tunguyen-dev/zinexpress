<?php
    include 'config.php';
    unset($_SESSION['admins_logged']);
    unset($_SESSION['phone']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= Commons_WebConst::TITLE_WEB ?> - Đăng nhập</title>
        <?php include 'includes/inc_head.php'?>
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
                                <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-7">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Đăng ký tài khoản!</h1>
                                        </div>
                                        <form class="user" id="formReg">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="shop_name" placeholder="Tên shop/ công ty" required="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" placeholder="Số điện thoại" required="" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" placeholder="Địa chỉ email" required="" name="email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" placeholder="Mật khẩu" required="" name="password">
                                            </div>
                                            <!-- <div class="form-group">
                                                <input type="text" class="form-control form-control-user" placeholder="Mã bưu cục" required="" name="post_code">
                                            </div> -->
                                            <button type="submit" class="btn btn-primary btn-user btn-block" id="btn_reg"> Đăng ký</button>
                                            <div id="msg_err" style="text-align: center;" class="text-primary">
                                                <span class="spinner-border spinner-border-sm"></span> Xin mời chờ...
                                            </div>

                                            <span id="msg_err_log"></span>
                                           <!--  <hr> -->
                                           <!--  <a href="index.html" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Register with Google
                                            </a>
                                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                            </a> -->
                                            <hr>
                                            <div class="text-center">
                                                <a class="small" href="<?= Commons_WebConst::HTACCESS_FORGET ?>">Quên mật khẩu?</a>
                                            </div>
                                            <div class="text-center">
                                                <a class="small" href="<?= Commons_WebConst::HTACCESS_LOGIN ?>">Đã có tài khoản? Đăng nhập!</a>
                                            </div>
                                            <?php
                                                require "vendor/autoload.php";
                                                $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

                                                $key_secret = $g->generateSecret();
                                            ?>
                                            <input type="hidden" name="key_secret" value="<?= $key_secret?>">
                                        </form>    
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
<script>
    $(document).ready(function () {
        $("#msg_err").hide();
        $("#msg_err_log").hide();
        
        $("#formReg").ajaxForm({
            url : './ajax/reg.php',
            type : 'post',
            dataType : 'json',
            beforeSend : function() {
                $("#msg_err").show();
                $("#btn_reg").hide();
                $("#msg_err_log").hide();
            },
            success : function(data) {
                if(data.code !== 0) {
                    $("#msg_err").hide();
                    $("#msg_err_log").html("<span class='label label-danger'>" + data.msg + "</span>");
                    $("#btn_reg").show();
                    $("#msg_err_log").show();
                }
                if(data.status) {
                    location.href= "thong-ke";
                }
            }
        });
    });
</script>