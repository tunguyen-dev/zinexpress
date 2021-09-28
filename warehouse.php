<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $model_cities = new Models_Cities();
    $list_cities = $model_cities->getList2();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Kho hàng</title>
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
                        <h1 class="h3 mb-0 text-gray-800">KHO HÀNG (ĐỊA CHỈ LẤY, TRẢ HÀNG)</h1>
                        <button type="button" class="btn btn-outline-primary" id="btn_add_ware"><i class="fas fa-plus" ></i> Tạo kho</button>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3">
                            <select class="form-control" id="status" style='width: 100%'>
                                <option value="1" selected>Đang hoạt động</option>
                                <option value="0">Dừng hoạt động</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" class="form-control form-control-user" placeholder="Nhập tên kho hoặc SĐT" id="text_search"/>
                        </div>
                    </div>
                    <!-- LOAD DỮ LIỆU -->
                    <div id="load_data_ware"></div>
                    <!-- <div id="msg_err_load" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div> -->
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
    <script src="js/sweetalert/sweetalert.min.js"></script>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('#msg_err').hide();
        $("#msg_err_log").hide(); 
        $('#msg_err_edit').hide();
        $("#msg_err_log_edit").hide();
        $("#msg_err_load_form").hide(); 
        function ajax_data(){
            $.ajax({
                url: 'ajax/warehouse.php',
                type: 'POST',
                data: {
                    _function: "load_data",      
                    status: $('#status').val(),
                    text_search: $('#text_search').val(),
                },
                success : function(data) {
                    $('#load_data_ware').html(data);  
                    $('.btn_primary_selec').on('click', function(){ 
                        var id = $(this).attr('data-id');
                        swal({
                            title: "Chọn làm kho mặc định?",
                            text: "Thao tác này sẽ chọn kho này thành kho mặc định!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK, Chọn",
                            cancelButtonText: "Hủy!",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: 'ajax/warehouse.php',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        _function: "change_primary",      
                                        id: id
                                    },
                                    success : function(data) {
                                        if (data.code == 0) {
                                            swal("Chọn kho mặc định thành công", data.msg, "success");
                                            ajax_data();
                                        }
                                    }         
                                });
                            } else {
                                swal("Hủy", "Thao tác đã được hủy", "error");
                            }
                        });
                    });
                    $('.btn_trash_ware').on('click', function(){ 
                        var id = $(this).attr('data-id');
                        swal({
                            title: "Tạm dưng hoạt động kho?",
                            text: "Thao tác này sẽ tạm dừng hoạt động của kho hàng!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK, Chọn",
                            cancelButtonText: "Hủy!",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: 'ajax/warehouse.php',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        _function: "trash_ware",      
                                        id: id
                                    },
                                    success : function(data) {
                                        if (data.code == 0) {
                                            swal("Tạm dừng thành công", data.msg, "success");
                                            ajax_data();
                                        }
                                    }         
                                });
                            } else {
                                swal("Hủy", "Thao tác đã được hủy", "error");
                            }
                        });
                    });
                    $('.btn_return_ware').on('click', function(){ 
                        var id = $(this).attr('data-id');
                        swal({
                            title: "Khôi phục hoạt động kho?",
                            text: "Thao tác này sẽ khôi phục lại hoạt động của kho hàng!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK, Chọn",
                            cancelButtonText: "Hủy!",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: 'ajax/warehouse.php',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        _function: "return_ware",      
                                        id: id
                                    },
                                    success : function(data) {
                                        if (data.code == 0) {
                                            swal("Khôi phục thành công", data.msg, "success");
                                            ajax_data();
                                        }
                                    }         
                                });
                            } else {
                                swal("Hủy", "Thao tác đã được hủy", "error");
                            }
                        });
                    });
                    $('.btn_edit_ware').on('click', function(){
                        var id = $(this).attr('data-id');
                        $("#msg_err_log_edit").hide();
                        $.ajax({
                            url: 'ajax/warehouse.php',
                            type: 'POST',
                            data: {
                                _function: "load_form_edit",      
                                id: id
                            },
                            beforeSend : function() {
                                $("#msg_err_load_form").show();
                                $("#load_form_edit").hide();
                            },
                            success : function(data) {
                                $("#msg_err_load_form").hide();
                                $("#load_form_edit").show();
                                $('#load_form_edit').html(data);
                                $('#modalEditWare').modal('show');
                                $('.select2_js').select2({
                                    dropdownParent: $('#modalEditWare')
                                });
                                $('#city_edit').on('change', function(){
                                    var code = $('#city_edit').val();
                                    $('#commune_edit').val(0);
                                    $.ajax({
                                        url: 'ajax/load_district.php',
                                        type: 'POST',
                                        data: {
                                            city_code: code,
                                            _function: 'edit_form'           
                                        },
                                        success : function(data) {
                                            $('#load_district_edit').html(data);
                                            $('.select2_js').select2({
                                                dropdownParent: $('#modalEditWare')
                                            });  
                                            $('#district_edit').on('change', function() {
                                                var code_dis = $('#district_edit').val();    
                                                $.ajax({
                                                    url: 'ajax/load_commune.php',
                                                    type: 'POST',
                                                    data: {
                                                        district: code_dis,
                                                        _function: 'edit_form'          
                                                    },
                                                    success : function(data) {
                                                        $('#load_commune_edit').html(data);
                                                        $('.select2_js').select2({
                                                            dropdownParent: $('#modalEditWare')
                                                        });     
                                                    }         
                                                });  
                                            });     
                                        }         
                                    });  
                                });
                                $('#district_edit').on('change', function() {
                                    var code_dis = $('#district_edit').val();    
                                    $.ajax({
                                        url: 'ajax/load_commune.php',
                                        type: 'POST',
                                        data: {
                                            district: code_dis,
                                            _function: 'edit_form'         
                                        },
                                        success : function(data) {
                                            $('#load_commune_edit').html(data);
                                            $('.select2_js').select2({
                                                dropdownParent: $('#modalEditWare')
                                            });     
                                        }         
                                    });  
                                }); 

                            }         
                        });
                    });
                }         
            });
        }
        $('#btn_add_ware').on('click',function(){
            $('#modalWare').modal('show');
            $('.select2_js').select2({
                dropdownParent: $('#modalWare')
            });
        }); 
        $('body').on('change', '#city', function(e){
            var code = $('#city').val();
            $('#commune').val(0);
            $.ajax({
                url: 'ajax/load_district.php',
                type: 'POST',
                data: {
                    city_code: code           
                },
                success : function(data) {
                    $('#load_district').html(data);
                    $('.select2_js').select2({
                        dropdownParent: $('#modalWare')
                    });  
                    $('#district').on('change', function() {
                        var code_dis = $('#district').val();    
                        $.ajax({
                            url: 'ajax/load_commune.php',
                            type: 'POST',
                            data: {
                                district: code_dis,             
                            },
                            success : function(data) {
                                $('#load_commune').html(data);
                                $('.select2_js').select2({
                                    dropdownParent: $('#modalWare')
                                });     
                            }         
                        });  
                    });     
                }         
            });     
        });
        $("#formAddWare").ajaxForm({
            url : './ajax/warehouse.php',
            type : 'post',
            dataType : 'json',
            beforeSend : function() {
                $("#msg_err").show();
                $("#msg_err_log").hide();
                $("#btn_add").hide();
            },
            success : function(data) {
                if(data.code == 1) {
                    $("#msg_err").hide();
                    $("#msg_err_log").html("<span class='label label-danger'>" + data.msg + "</span>");
                    $("#btn_add").show();
                    $("#msg_err_log").show();
                }
                if(data.code == 0) {
                    $("#msg_err").hide();
                    swal({
                        title: "Thành Công!",
                        text: "Thêm kho hàng thành công!",
                        type: "success",
                    });
                    $(".confirm").on("click",function() {
                        location.reload();
                    })
                }
            }
        });
        $("#formEditWare").ajaxForm({
            url : './ajax/warehouse.php',
            type : 'post',
            dataType : 'json',
            beforeSend : function() {
                $("#msg_err_edit").show();
                $("#msg_err_log_edit").hide();
                $("#btn_edit").hide();
            },
            success : function(data) {
                if(data.code == 1) {
                    $("#msg_err_edit").hide();
                    $("#msg_err_log_edit").html("<span class='label label-danger'>" + data.msg + "</span>");
                    $("#btn_edit").show();
                    $("#msg_err_log_edit").show();
                }
                if(data.code == 0) {
                    $("#btn_edit").show();
                    $("#msg_err_edit").hide();
                    $('#modalEditWare').modal('hide');
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "progressBar": true,
                        "preventDuplicates": false,
                        "positionClass": "toast-top-right",
                        "onclick": null,
                        "showDuration": "400",
                        "hideDuration": "1000",
                        "timeOut": "7000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr["success"]("",data.msg);
                    ajax_data();
                }
            }
        });
        $('#status').on('change', function(){
            ajax_data(); 
        });
        $('#text_search').on('blur', function(){
            ajax_data();
        });
        $('#text_search').on('keyup', function (event){
            if (event.keyCode == 13) {
                ajax_data();
            }
        }); 
        ajax_data();
    });
</script>

<!-- Modal ADD WARE-->
<div class="modal fade" id="modalWare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo kho hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" id="formAddWare">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="_function" value="add_ware">
                        <input type="text" class="form-control form-control-user" placeholder="Tên kho (tên này sẽ hiển thi trên bill)" name="name" required="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" placeholder="Số điện thoại (số này sẽ hiển thị trên bill)" name="phone" required="" value="<?= $adminuser->phone?>"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" placeholder="Địa chỉ chi tiết" name="address" required=""/>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <select class="form-control select2_js" name="city" id="city" style='width: 100%'>
                                <option>Tỉnh/TP...</option>
                                <?php
                                    foreach ($list_cities as $li_ci) {
                                        echo "<option value='$li_ci->code'>$li_ci->name</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div id="load_district">
                                <select class="form-control select2_js" name="district" style='width: 100%'>
                                    <option>Quận/Huyện...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div id="load_commune">
                                <select class="form-control select2_js" name="commune" style='width: 100%'>
                                    <option>Phường/Xã...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="btn_add">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tạo kho</button>
                    </div>
                    <div id="msg_err" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>

                    <span id="msg_err_log"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal EDIT WARE-->
<div class="modal fade" id="modalEditWare" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa kho hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" id="formEditWare">
                <div class="modal-body">
                    <div id="load_form_edit">
                        
                    </div>
                    <div id="msg_err_load_form" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>
                </div>
                <div class="modal-footer">
                    <div id="btn_edit">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                    <div id="msg_err_edit" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div> 
                </div>
                <p id="msg_err_log_edit" class="float-right" style="margin-right: 15px;"></p>
            </form>
        </div>
    </div>
</div>