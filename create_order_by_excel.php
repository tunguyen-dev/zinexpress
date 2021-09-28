<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $model_wares = new Models_WareHouses();
    $list_ware = $model_wares->customFilter('',array('user_id' => $adminuser->getId(), 'status' => 1));
    $count = count($list_ware);
    $model_cities = new Models_Cities();
    $list_cities = $model_cities->getList2();

    $filename = "FILE_EXCEL_MAU_LEN_DON.xlsx";
    $filepath = $base_url . "/DownloadFileExcel/" . $filename;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Tạo đơn bằng excel</title>
    <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
    <?php include 'includes/inc_head.php'?>
</head>

<style type="text/css">
    
    .table td, .table th {
        padding: 0px;
        vertical-align: 0px;
        /*border-top: 1px solid #dee2e6; */
    }

    .page-heading {
        border-top: 0;
        padding: 12px 10px 12px 10px;
    }
</style>
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
                        <h1 class="h3 mb-0 text-gray-800">Nhập đơn hàng từ FILE EXCEL</h1>
                        <form id="formExcel" role="form" enctype="multipart/form-data">
                            <input type="file" name="file" style="display: none" id="file" accept=".xls,.xlsx">
                            <label class="custom-file-label" style="display: none"></label>
                        </form>  
                        <div>    
                            <button class="btn btn-outline-danger" type="button" id="uploadFile">
                                <span id="icon_upload"><i class="fas fa-upload"></i></span>
                                <span id="msg_err_check_file" class="text-danger"><span class="spinner-border spinner-border-sm"></span></span> Tải lên
                            </button>                 
                            <a class="btn btn-primary" type="button" href="<?= $filepath ?>"><i class="fas fa-download"></i> Tải file mẫu</a>
                            <button class="btn btn-secondary" type="button"><i class="fas fa-clipboard-list"></i> Quản lý file cũ</button>
                        </div>
                    </div>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Lưu ý: </strong> 
                        <ul>
                            <li>Các mục có dấu (*) vui lòng không bỏ trống</li>
                            <li>Phần địa chỉ vui lòng ghi cách nhau bởi dấu phẩy. VD: thôn a,xuân nộn,đông anh,hà nội</li>
                            <li>Phần ghi chú thêm sẽ được nối chuỗi với phần ghi chú cài đặt sẵn trong mục <strong><a href="" class="config_settings">Cài đặt tạo đơn</a></strong></li>
                            <li>Sau khi bấm tải lên hệ thống sẽ kiểm tra những đơn nào lỗi định dạng hoặc thiếu thông tin vui lòng sửa lại trên hệ thống trước khi bấm <strong>TẠO ĐƠN</strong></li>
                        </ul>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Nhập đơn hàng từ FILE EXCEL</h6>
                                </div>
                                <div class="card-body" id="fullScreenDiv">
                                    <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <select name="ware_id" class="select2_js_2" id="warehourse_select_id" style="width: 100%;">
                                                        <?php if ($count == 0) { ?>
                                                            <option value="0">Kho hàng</option>
                                                        <?php } ?>
                                                        <?php foreach ($list_ware as $li) { 
                                                            if ($li->primary_selec == 1) {
                                                                $selected = 'selected';
                                                            }else{
                                                                $selected = '';
                                                            }
                                                            echo "<option $selected value=".$li->getId().">$li->name - $li->phone - $li->address, $li->commune, $li->district, $li->city</option>";
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="float-right">
                                                    <span id="msg_err_upload" class="btn btn-primary"><span class="spinner-border spinner-border-sm"></span> Đang xử lý</span>
                                                    <button class="btn btn-primary sendData" type="button"><i class="fas fa-plus"></i> Đẩy đơn</button>
                                                    <button class="btn btn-outline-secondary config_settings" type="button"><i class="fas fa-cog"></i></button>
                                                </div>
                                               <!--  <button class="btn btn-outline-secondary" id="btnFullscreen" type="button"><i class="fas fa-expand-arrows-alt"></i></button> -->
                                            </div>
                                            <div class="col-12">
                                                <div id="load_alert">
                                                    <div class="alert alert-info">
                                                        <strong>Số đơn trong file là <span id="total_count"></span> đơn, <span class="text-success">có <span id="success_count"></span> đơn hợp lệ</span>, <span class="text-danger">có <span id="error_count"></span> đơn lỗi</span>, vui lòng sửa những đơn lỗi (nếu có) trước khi "TẠO ĐƠN"</strong>
                                                    </div>
                                                </div>
                                                <div class="msg_error">
                                                    <div id='error_upload_excel_id' class="alert alert-danger font-weight-bold">
                                                    </div>

                                                </div>
                                                <div id="load_order_logs">
                                                    
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Người nhận</th>
                                                                <th>Đơn hàng</th>
                                                                <th>Địa chỉ</th>
                                                                <th>KL và COD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="load_data_code">

                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: center;" id="msg_err_load_logs">
                                                        <span  class="text-primary" ><span class="spinner-border spinner-border-sm"></span> Đang xử lý</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
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
        <script src="js/sweetalert/sweetalert.min.js"></script>
    </div>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('#msg_err_check_file').hide();
        $('#msg_err_upload').hide();
        $('.msg_error').hide();
        $('#msg_err_load_logs').hide();
        $('.config_settings').on('click', function(e){
            e.preventDefault();
            window.open('quan-ly-tai-khoan?_function=load_config_orders','_blank');
        });
        $('#load_alert').hide();
        //BUTTON UPLOAD FILE EXCEL
        document.getElementById('uploadFile').addEventListener('click', openDialog);
        function openDialog() {
          document.getElementById('file').click();
        }
        document.getElementById("file").onchange = function() {
            var fd = new FormData();
            var files = $('#file')[0].files;
            fd.append('file',files[0]);
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            $('.msg_error').hide();
            $('#load_alert').hide();
            $('#msg_err_load_logs').show();
            $('#load_data_code').hide();
            $.ajax({
                url : 'ajax/check_file_excel_order_v2.php',
                type : 'POST',
                data : fd,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                beforeSend : function() {
                    $('#icon_upload').hide();
                    $('#msg_err_check_file').show();
                },
                success: function(data){
                    $('#icon_upload').show();
                    $('#msg_err_check_file').hide();
                    $('#msg_err_load_logs').hide();
                    $('#load_data_code').show();
                    $('#file').val("");
                    if (data.code == 1) {
                        swal({
                            title: "Lỗi tải lên file excel",
                            text: data.msg
                        });
                    }
                    if (data.code == 0) {
                        $('#load_alert').show();
                        $('#total_count').text(data.total_count);
                        $('#error_count').text(data.error_count);
                        $('#success_count').text(data.success_count);
                        if (data.body_table != undefined && data.body_table != null && data.body_table != '') {
                            $('#load_data_code').html(data.body_table)
                            $('.detail_table').show();
                            data_order_success = data.array_verified;
                            if(data.success_count == null || data.success_count <= 0)  data.success_count = 0;
                            if(data.total_count == null || data.total_count <= 0)  data.total_count = 0;
                            if(data.error_count == null || data.error_count <= 0) data.error_count = 0;
                            $('.upload_info td').html("Đã tải lên "+data.total_count+" đơn, trong đó có "+data.success_count+" đơn không lỗi, còn "+data.error_count+" đơn lỗi, vui lòng sửa lại những đơn lỗi (nếu có) trước khi 'Tạo đơn'");


                            var $target = $('#load_data_code ').children('tr');
                            $target.each(function () {
                                var name = $(this).find('.name').val();
                                if (name == null || name == '') {
                                    $(this).find('.error_msg_name').html('Tên KH không thể bỏ trông');
                                    $(this).find('.error_msg_name').show()
                                    $(this).find('.name').css('bord er-color', "#dc3545")
                                    error = true;
                                }

                                var phone = $(this).find('.phone').val();
                                if (phone == null || phone == '') {

                                    $(this).find('.phone').css('border-color', "#dc3545")
                                    $(this).find('div.error_msg_phone').show()
                                    $(this).find('div.error_msg_phone').html("trường 'số điện thoại' là bắt buộc nhập");
                                    error = true;
                                } else {
                                    var vnf_regex = /((09|03|07|08|05|02)+([0-9]{8,9})\b)/g;
                                    if (vnf_regex.test(phone) == false) {
                                        $(this).css('border-color', "#dc3545")
                                        $(this).find('div.error_msg_phone').show()
                                        $(this).find('div.error_msg_phone').html("'số điện thoại' của bạn không đúng định dạng!");
                                        error = true;
                                    }
                                }

                                var product = $(this).find('.product').val();

                                if (product == null || product == '') {
                                    $(this).find('.error_msg_product').html("vui lòng nhập trường Tên SP");
                                    $(this).find('.error_msg_product').show()
                                    $(this).find('.product').css('border-color', "#dc3545")
                                    error = true;
                                }

                                var address = $(this).find('.address').val();

                                if (address == null || address == '') {
                                    $(this).find('.error_msg_address').html("Vui lòng nhập thông tin trường địa chỉ");
                                    $(this).find('.error_msg_address').show()
                                    $(this).find('.address').css('border-color', "#dc3545")
                                    error = true;
                                } else {
                                    $(this).find('.address').css('border-color', "#28a745")
                                }

                                var city = $(this).find('.city').val();

                                if (city == null || city == '' || city == 0) {
                                    $(this).find('.error_msg_city').html("Vui lòng chọn Tỉnh/Thành phó");
                                    $(this).find('.error_msg_city').show()
                                    $(this).find('.city').css('border-color', "#dc3545")
                                    error = true;
                                } else {
                                    $(this).find('.city').css('border-color', "#28a745")
                                }
                                var district = $(this).find('.district').val();
                                if (district == null || district == '' || district == 0) {
                                    $(this).find('.error_msg_district').html("Vui lòng chọn Quận/huyện");
                                    $(this).find('.error_msg_district').show()
                                    $(this).find('.district').css('border-color', "#dc3545")
                                    error = true;
                                } else {
                                    $(this).find('.district').css('border-color', "#28a745")
                                }

                                var commune = $(this).find('.commune').val();
                                if (commune == null || commune == '' || commune == 0) {
                                    $(this).find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                                    $(this).find('.error_msg_commune').show()
                                    $(this).find('.commune').css('border-color', "#dc3545")
                                    error = true;
                                } else {
                                    $(this).find('.commune').css('border-color', "#28a745")
                                }

                            })
                            //
                            $('.city').select2();
                            $('.district').select2();
                            $('.commune').select2();
                            $('.city').on('change', function () {

                                $thiss = $(this);
                                if ($(this).val() == null || $(this).val() == '' || $(this).val() == 0) {
                                    $(this).closest('tr').find('.error_msg_city').html("Vui lòng chọn Tỉnh/Thành phó");
                                    $(this).closest('tr').find('.error_msg_city').show()
                                    $(this).css('border-color', "#dc3545")
                                    $(this).closest('tr').find('.error_msg_district').html("Vui lòng chọn Quận/huyện");
                                    $(this).closest('tr').find('.error_msg_district').show()
                                    $(this).closest('td').find('.district').css('border-color', "#dc3545")
                                    error = true;
                                    return;
                                } else {
                                    $(this).css('border-color', "#28a745")


                                    $(this).closest('tr').find('.error_msg_city').html("");
                                    $(this).closest('tr').find('.error_msg_city').hide()
                                    $(this).closest('tr').find('.error_msg_district').html("Vui lòng chọn Quận/huyện");
                                    $(this).closest('tr').find('.error_msg_district').show()
                                    $(this).closest('td').find('.district').css('border-color', "#dc3545")
                                }

                                $thiss.closest('td').children('.commune').html('')
                                var code = $(this).val();
                                $.ajax({
                                    url: 'ajax/load_district2.php',
                                    type: 'POST',
                                    data: {
                                        province: code,
                                    },
                                    success: function (data) {
                                        $thiss.closest('td').children('.district').html(data)
                                        $thiss.closest('td').children('.district').select2();
                                    }
                                });
                            })

                            $('.district').on('change', function () {
                                $thiss = $(this);
                                if ($(this).val() == null || $(this).val() == '' || $(this).val() == 0) {
                                    $(this).closest('tr').find('.error_msg_district').html("Vui lòng chọn Quận/huyện");
                                    $(this).closest('tr').find('.error_msg_district').show()
                                    $(this).css('border-color', "#dc3545")
                                    $(this).closest('tr').find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                                    $(this).closest('tr').find('.error_msg_commune').show()
                                    $(this).closest('td').find('.district').css('border-color', "#dc3545")
                                    error = true;
                                    return;
                                } else {
                                    $(this).css('border-color', "#28a745")
                                    $(this).closest('tr').find('.error_msg_district').html("");
                                    $(this).closest('tr').find('.error_msg_district').hide()
                                    $(this).closest('tr').find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                                    $(this).closest('tr').find('.error_msg_commune').show()
                                }
                                var code_dis = $(this).val();
                                $.ajax({
                                    url: 'ajax/load_commune.php',
                                    type: 'POST',
                                    data: {
                                        district: code_dis,
                                    },
                                    success: function (data) {
                                        $thiss.closest('td').children('.commune').html(data)
                                        $thiss.closest('td').children('.commune').select2();
                                    }
                                });
                            })

                            $('.commune').on('change', function () {
                                $thiss = $(this);
                                if ($(this).val() == null || $(this).val() == '' || $(this).val() == 0) {
                                    $(this).css('border-color', "#dc3545")
                                    $(this).closest('tr').find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                                    $(this).closest('tr').find('.error_msg_commune').show()
                                    error = true;
                                    return;
                                } else {
                                    $(this).css('border-color', "#28a745")

                                    $(this).closest('tr').find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                                    $(this).closest('tr').find('.error_msg_commune').hide()
                                }

                            })


                            $(".name")
                                .focusout(function () {

                                })
                                .blur(function () {
                                    var name = $(this).val();
                                    if (name !== '') {

                                        $(this).closest('tr').children('td').children('div.error_msg_name').hide()
                                        $(this).css('border-color', '#28a745')

                                    } else {
                                        $(this).css('border-color', "#dc3545")
                                        $(this).closest('tr').children('td').children('div.error_msg_name').show()
                                        $(this).closest('tr').children('td').children('div.error_msg_name').html("trường 'tên khách hàng' là bặt buộc");

                                    }
                                });

                            $(".phone")
                                .focusout(function () {

                                })
                                .blur(function () {
                                    // console.log($(this).val())
                                    var vnf_regex = /((09|03|07|08|05|02)+([0-9]{8,9})\b)/g;
                                    var mobile = $(this).val();
                                    if (mobile !== '') {
                                        if (vnf_regex.test(mobile) == false) {
                                            $(this).css('border-color', "#dc3545")
                                            $(this).closest('tr').children('td').children('div.error_msg_phone').show()
                                            $(this).closest('tr').children('td').children('div.error_msg_phone').html("'số điện thoại' của bạn không đúng định dạng!");
                                        } else {

                                            $(this).closest('tr').children('td').children('div.error_msg_phone').hide()
                                            $(this).css('border-color', '#28a745')

                                            // }
                                        }
                                    } else {
                                        $(this).css('border-color', "#dc3545")
                                        $(this).closest('tr').children('td').children('div.error_msg_phone').show()
                                        $(this).closest('tr').children('td').children('div.error_msg_phone').html("trường 'số điện thoại' là bắt buộc nhập");
                                    }
                                });


                            $(".product")
                                .focusout(function () {

                                })
                                .blur(function () {
                                    var name = $(this).val();
                                    if (name !== '') {
                                        $(this).closest('tr').children('td').children('div.error_msg_product').hide()
                                        $(this).css('border-color', '#28a745')
                                    } else {
                                        $(this).css('border-color', "#dc3545")
                                        $(this).closest('tr').children('td').children('div.error_msg_product').show()
                                        $(this).closest('tr').children('td').children('div.error_msg_product').html("Trường 'tên sản phầm' là bặt buộc");

                                    }
                                });
                            //
                            //
                            $(".address")
                                .focusout(function () {

                                })
                                .blur(function () {
                                    $thiss = $(this);
                                    var name = $(this).val();

                                    if (name !== '') {
                                        $(this).closest('tr').children('td').children('div.error_msg_address').hide()
                                        $(this).css('border-color', '#28a745')
                                    } else {
                                        $(this).css('border-color', "#dc3545")
                                        $(this).closest('tr').children('td').children('div.error_msg_address').show()
                                        $(this).closest('tr').children('td').children('div.error_msg_address').html("Trường 'địa chỉ' là bặt buộc");

                                    }
                                });
                            //
                            //
                            $('.format_number').keyup(function (event) {

                                // skip for arrow keys
                                if (event.which >= 37 && event.which <= 40) {
                                    event.preventDefault();
                                }

                                $(this).val(function (index, value) {
                                    return value
                                        .replace(/\D/g, "")
                                        // .replace(/([0-9])([0-9]{0})$/, '$1.$2')
                                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",")
                                        ;
                                });
                            });

                        }else {
                            data_order_success = data.array_verified;
                            if(data.success_count == null || data.success_count <= 0) return;
                            if(data.total_count == null || data.total_count <= 0) return;
                            if(data.error_count == null || data.error_count <= 0) data.error_count = 0;
                            $('.upload_info td').html("Đã tải lên "+data.total_count+" đơn, trong đó có "+data.success_count+" đơn không lỗi, còn "+data.error_count+" đơn lỗi, vui lòng sửa lại những đơn lỗi (nếu có) trước khi 'Tạo đơn'");
                        }
                    }
                }
            });
        }
        $('.sendData').on('click', function(){
            $('#msg_err_upload').show();
            $('.sendData').hide();
            $('.msg_error').hide();
            var $this_ = $(this);
            var errorTotal = false;
            var $target = $('#load_data_code').children('tr');
            var error = false;
            var error_msg = '';

            var arr = [];
            var i = 0
            if ($('.custom-file-label').html() == null || $('.custom-file-label').html() == '') {
                $("#error_upload_excel_id").html("Chưa chọn file tải lên");
                $('.msg_error').show();
                $("#error_upload_excel_id").show();
                $('#msg_err_upload').hide();
                $('.sendData').show();
                return;
            }
            if ($target.length > 0 ) {
                $target.each(function () {
                    i++;
                    var error_element = '';
                    var name = $(this).find('.name').val();
                    if (name == null || name == '') {
                        $(this).find('.error_msg_name').html('Tên KH không thể bỏ trông');
                        $(this).find('.error_msg_name').show()
                        $(this).find('.name').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". Tên KH không thể bỏ trông";
                    }
                    var phone = $(this).find('.phone').val();
                    if (phone == null || phone == '') {

                        $(this).find('.phone').css('border-color', "#dc3545")
                        $(this).find('div.error_msg_phone').show()
                        $(this).find('div.error_msg_phone').html("trường 'số điện thoại' là bắt buộc nhập");
                        error = true;
                        error_element += ". trường 'số điện thoại' là bắt buộc nhập";
                    } else {
                        var vnf_regex = /((09|03|07|08|05|02)+([0-9]{8,9})\b)/g;
                        if (vnf_regex.test(phone) == false) {
                            $(this).css('border-color', "#dc3545")
                            $(this).find('div.error_msg_phone').show()
                            $(this).find('div.error_msg_phone').html("'số điện thoại' của bạn không đúng định dạng!");
                            error = true;
                            error_element += ". 'số điện thoại' của bạn không đúng định dạng!";
                        }
                    }


                    var soc = $(this).find('.soc').val();

                    var product = $(this).find('.product').val();

                    if (product == null || product == '') {
                        $(this).find('.error_msg_product').html("vui lòng nhập trường Tên SP");
                        $(this).find('.error_msg_product').show()
                        $(this).find('.product').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". vui lòng nhập trường Tên SP";
                    }

                    var note = $(this).find('.note').val();
                    var address = $(this).find('.address').val();

                    if (address == null || address == '') {
                        $(this).find('.error_msg_address').html("Vui lòng nhập thông tin trường địa chỉ");
                        $(this).find('.error_msg_address').show()
                        $(this).find('.address').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". Vui lòng nhập thông tin trường địa chỉ";
                    }

                    var city = $(this).find('.city').val();
                    if (city == null || city == '') {
                        $(this).find('.error_msg_city').html("Vui lòng chọn Tỉnh/Thành phón");
                        $(this).find('.error_msg_address').show()
                        $(this).find('.city').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". Vui lòng chọn Tỉnh/Thành phố";
                    } else {
                        $(this).find('.city').css('border-color', "#28a745")
                    }

                    var district = $(this).find('.district').val();
                    if (district == null || district == '') {
                        $(this).find('.error_msg_district').html("Vui lòng chọn Quận/huyện");
                        $(this).find('.error_msg_district').show()
                        $(this).find('.district').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". Vui lòng chọn Quận/huyện";
                    } else {
                        $(this).find('.district').css('border-color', "#28a745")
                    }

                    var commune = $(this).find('.commune').val();
                    if (commune == null || commune == '') {
                        $(this).find('.error_msg_commune').html("Vui lòng chọn Xã/Phường");
                        $(this).find('.error_msg_commune').show()
                        $(this).find('.commune').css('border-color', "#dc3545")
                        error = true;
                        error_element += ". Vui lòng chọn Xã/Phường";
                    } else {
                        $(this).find('.commune').css('border-color', "#28a745")
                    }

                    var weight = $(this).find('.weight').val();
                    if (weight !== '') {
                        var weight = weight.split(",").join("");
                        if (weight < 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').show()
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').html("'Khối lượng' phải là số lớn hơn 0!");
                            error = true;
                            error_element += ". 'Khối lượng' phải là số lớn hơn 0!";
                        } else if (weight > 50000) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').show()
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').html("'Khối lượng' phải là số phải nhỏ hơn 50.000 gram!");
                            error = true;
                            error_element += ". 'Khối lượng' phải là số phải nhỏ hơn 50.000 gram!";
                        } else {
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').hide()
                            $(this).css('border-color', '#28a745')

                            // }
                        }
                    } else {
                        $(this).css('border-color', "#dc3545")
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').show()
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_weight').html("trường 'Khối lượng' là bắt buộc nhập");
                        error = true;
                        error_element += ". trường 'Khối lượng' là bắt buộc nhập";
                    }

                    var amount = $(this).find('.amount').val();
                    if (amount !== '') {
                        var amount = amount.split(",").join("");
                        if (amount < 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_amount').show()
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_amount').html("'phí thu hộ' phải là số lớn hơn 0!");
                            error = true;
                            error_element += ". 'phí thu hộ' phải là số lớn hơn 0!";
                        } else {
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_amount').hide()
                            $(this).css('border-color', '#28a745')
                        }
                    } else {
                        $(this).css('border-color', "#dc3545")
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_amount').show()
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_amount').html("trường 'thu hộ' là bắt buộc nhập");
                        error_element += ". trường 'thu hộ' là bắt buộc nhập";
                        error = true;
                    }

                    var value = $(this).find('.value').val();
                    if (value !== '') {
                        var value = value.split(",").join("");
                        if (value < 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_value').show()
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_value').html("'giá trị' phải là số lớn hơn 0!");
                            error = true;
                            error_element += ". 'giá trị' phải là số lớn hơn 0!";
                        } else {
                            $(this).closest('table').closest('tr').children('td').children('div.error_msg_value').hide()
                            $(this).css('border-color', '#28a745')
                        }
                    } else {
                        $(this).css('border-color', "#dc3545")
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_value').show()
                        $(this).closest('table').closest('tr').children('td').children('div.error_msg_value').html("trường 'giá trị' là bắt buộc nhập");
                        error = true;
                        error_element += ". trường 'giá trị' là bắt buộc nhập";
                    }
                    var ob = {};

                    if (error) {
                        errorTotal = true;
                    }
                    {
                        ob['name'] = name;
                        ob['phone'] = phone;
                        ob['ware_id'] = $('#warehourse_select_id').val();
                        ob['soc'] = soc;
                        ob['product'] = product;
                        ob['note'] = note;
                        ob['address'] = address;
                        if ($(this).find('.city').val() == null || $(this).find('.city').val() == '' || $(this).find('.city').val() == 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('tr').children('td').children('div.error_msg_city').show()
                            $(this).closest('tr').children('td').children('div.error_msg_city').html("vui lòng chọn Tỉnh/Thành phố");
                            error = true;
                            error_element += ". vui lòng chọn Tỉnh/Thành phố";
                        } else {
                            ob['city'] = $(this).find('.city option:selected').text();

                        }
                        if ($(this).find('.district').val() == null || $(this).find('.district').val() == '' || $(this).find('.district').val() == 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('tr').children('td').children('div.error_msg_district').show()
                            $(this).closest('tr').children('td').children('div.error_district').html("vui lòng chọn Quận/Huyện");
                            error_element += ". vui lòng chọn Quận/Huyện";
                            error = true;
                        } else {
                            ob['district'] = $(this).find('.district option:selected').text();
                        }

                        if ($(this).find('.commune').val() == null || $(this).find('.commune').val() == '' || $(this).find('.commune').val() == 0) {
                            $(this).css('border-color', "#dc3545")
                            $(this).closest('tr').children('td').children('div.error_msg_commune').show()
                            $(this).closest('tr').children('td').children('div.error_district').html("vui lòng chọn Xã/Phường");
                            error_element += ". vui lòng chọn Xã/Phường";
                            error = true;
                        } else {
                            ob['commune'] = $(this).find('.commune option:selected').text();
                        }
                        ob['weight'] = weight;
                        ob['value'] = value;
                        ob['amount'] = amount;

                        arr.push(ob);
                        if (error_element != null || error_element != '' || error_element.length <= 0) {
                            error_element = "Đơn " + i + " " + error_element;
                            error_msg += "<br>" + error_element;
                        }
                    }
                })
            } else if (data_order_success == undefined || data_order_success == null || data_order_success.length <= 0){
                $("#error_upload_excel_id").html("<span class='label label-danger' style='display:block; font-size:14px; overflow:auto'>Không có đơn hàng +</span>");
                $('.msg_error').show();
                $("#error_upload_excel_id").show();
                $('#msg_err_upload').hide();
                $('.sendData').show();
                return;
            }
            if (arr.length <= 0 && (data_order_success == undefined || data_order_success == null || data_order_success.length <= 0)) {
                $("#error_upload_excel_id").show();
                $("#error_upload_excel_id").html("<span class='label label-danger' style='display:block; font-size:14px; overflow:auto'>Không có đơn hàng _</span>");

                $('.msg_error').show();
                $('#msg_err_upload').hide();
                $('.sendData').show();
                return;
            }
            if (error == true) {
                errorTotal = true;
            }
            // console.log(error);
            // console.log(errorTotal);
            if (errorTotal) {
                $("#error_upload_excel_id").show();
                $("#error_upload_excel_id").html("Lỗi đẩy đơn hàng " + error_msg);
                $('.msg_error').show();
                $('#msg_err_upload').hide();
                $('.sendData').show();
                return;
            } else {
                $("#error_upload_excel_id").hide();
                if(data_order_success != undefined && data_order_success != null && data_order_success.length > 0)
                    for ( var i = 0, l = data_order_success.length; i < l; i++ ) {
                        element = data_order_success[i];
                        element['ware_id'] = $('#warehourse_select_id').val();
                        arr.push(element);
                    }
                $.ajax({
                    url: "ajax/upload_orders_by_batch.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        order_detail: JSON.stringify(arr),
                        '_file_name': $('.custom-file-label').html()
                    },
                    success: function (data) {
                        $('#msg_err_upload').hide();
                        $('.sendData').show();
                        if (data.code !== 0) {
                            $("#error_upload_excel_id").show();
                            $("#error_upload_excel_id").html("<span class='label label-danger' style='display:block; font-size:14px; overflow:auto'>" + data.msg + "</span>");
                            $('.msg_error').show();
                        } else {
                            $('.msg_err').hide();
                            alert("Tải file thành công bạn có thể đi đén trang quản lý đơn hàng theo lô ");
                            $("#error_upload_excel_id").show();
                            $('#error_upload_excel_id').html("<span class='label label-primary' style='display:block; font-size:14px; overflow:auto'>Đẩy đơn hàng thành công</span>");
                            location.reload();
                            $('#load_data_code').html('')
                            data_order_success = [];
                            $('.msg_err').hide();
                        }
                    }
                });
            }
        });
    });
</script>