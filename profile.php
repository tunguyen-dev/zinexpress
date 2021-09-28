<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    if (isset($_GET['_function'])) {
        $_function = $_GET['_function'];
    }else{
        $_function = 'load_profile';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Quản lý tài khoản</title>
    <?php include 'includes/inc_head.php'?>
    <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'includes/inc_nav.php'?>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include 'includes/inc_nav2.php'?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quản lý tài khoản</h1>
                    </div>
                    <!-- LOAD DỮ LIỆU -->
                    <ul class="nav nav-tabs left-tabs">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($_function == "load_profile") ? 'active' : '' ?> tilte_click" data-function='load_profile' data-title="Thông tin cá nhân" href data-toggle="tab"><i class="far fa-address-card"></i> Thông tin cá nhân</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tilte_click" data-function='load_userbank' data-title="Tài khoản ngân hàng" href data-toggle="tab"><i class="fab fa-cc-paypal"></i> Tài khoản ngân hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tilte_click" data-function='load_change_pass' data-title="Đổi mật khẩu" href data-toggle="tab"><i class="fas fa-lock"></i> Đổi mật khẩu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tilte_click <?php echo ($_function == "load_config_orders") ? 'active' : '' ?>" data-function='load_config_orders' data-title="Cài đặt tạo đơn" href data-toggle="tab"><i class="fas fa-shopping-cart"></i> Cài đặt tạo đơn</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Thông tin cá nhân</span> </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div id="load_data">
                                     
                                </div>
                                <div id="msg_err_load" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php include 'includes/inc_footer.php' ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>  
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#msg_err_load").hide();
        var _function = '<?= $_function?>';
        function load_data(_function){
            $.ajax({
                url: 'ajax/setting_account.php',
                type: 'POST',
                data: {
                    _function: _function,      
                },
                beforeSend : function() {
                    $("#msg_err_load").show();
                    $("#load_data").hide();
                },
                success : function(data) {
                    $("#msg_err_load").hide();
                    $("#load_data").show();
                    $('#load_data').html(data);
                    if (_function == 'load_profile') {
                        var elem = document.querySelector('.js-switch');
                        var switchery = new Switchery(elem, { color: '#3199f2' });
                        $("#msg_err_edit").hide();
                        // GỬI REQUEST XỬ LÝ DỮ LIỆU
                        $("#formEditProfile").ajaxForm({
                            url : './ajax/setting_account.php',
                            type : 'post',
                            dataType : 'json',
                            beforeSend : function() {
                                $("#msg_err_edit").show();
                                $("#btn_save").hide();
                            },
                            success : function(data) {
                                if(data.code == 1) {
                                    $("#btn_save").show();
                                    $("#msg_err_edit").hide();
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["error"]("",data.msg);
                                }
                                if(data.code == 0) {
                                    $("#btn_save").show();
                                    $("#msg_err_edit").hide();
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "1500",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["success"]("",data.msg);
                                    load_data(_function);
                                }
                            }
                        });
                        $("#form2FA").ajaxForm({
                            url : './ajax/service2FA.php',
                            type : 'post',
                            dataType : 'json',
                            beforeSend : function() {
                                $("#btn-2fa").hide();
                            },
                            success : function(data) {
                                if(data.code !== 0) {
                                    $("#msg_err_2fa").html("<span class='label label-danger'>" + data.msg + "</span>");
                                    $("#btn-2fa").show();
                                }else{
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "1500",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["success"]("",data.msg);
                                    load_data(_function);
                                }
                            }
                        });
                    }
                    if (_function == 'load_userbank') {
                        $('.select2_js').select2();
                        $("#formSaveBank").ajaxForm({
                            url : './ajax/setting_account.php',
                            type : 'post',
                            dataType : 'json',
                            beforeSend : function() {
                                $("#btn_add_bank").hide();
                            },
                            success : function(data) {
                                if(data.code !== 0) {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["error"]("",data.msg);
                                }
                                else {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "1500",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["success"]("",data.msg);
                                    load_data(_function);
                                }
                                $("#btn_add_bank").show();
                            }
                        });
                    }
                    if (_function == 'load_change_pass') {
                        $("#formChangePass").ajaxForm({
                            url : './ajax/setting_account.php',
                            type : 'post',
                            dataType : 'json',
                            beforeSend : function() {
                                $("#btn_save_pass").hide();
                            },
                            success : function(data) {
                                if(data.code !== 0) {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["error"]("",data.msg);
                                }
                                else {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "1500",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["success"]("",data.msg);
                                    load_data(_function);
                                }
                                $("#btn_save_pass").show();
                            }
                        });
                    }
                    if (_function == 'load_config_orders') {
                        $("#formConfigOrder").ajaxForm({
                            url : './ajax/setting_account.php',
                            type : 'post',
                            dataType : 'json',
                            beforeSend : function() {
                                $("#btn_save_order").hide();
                            },
                            success : function(data) {
                                if(data.code !== 0) {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["error"]("",data.msg);
                                }
                                else {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "progressBar": true,
                                        "preventDuplicates": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "400",
                                        "hideDuration": "1000",
                                        "timeOut": "1500",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                    toastr["success"]("",data.msg);
                                    load_data(_function);
                                }
                                $("#btn_save_order").show();
                            }
                        });
                    }
                }         
            });
        }
        load_data(_function);
        $('.tilte_click').on('click', function(){
            var title = $(this).attr('data-title');
            var _function = $(this).attr('data-function');
            $('#text-title').text(title);
            load_data(_function);
        });
        
    }); 
</script>
