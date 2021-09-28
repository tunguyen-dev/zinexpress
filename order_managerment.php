<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $data = Commons_OrdersConst::ARRAY_MENU_TAB_ORDER;
    $innerHtmlStatusDock = '';
    // foreach ($data as $key => $value) {
    //     $innerHtmlStatusDock .= "<li class='notification inline search_status'  style='color: black' id='filter_$key' onclick = 'changeTab("."\"".$key."\"".");'><a><span >".$value['name']."</span ><span class='badge' id = 'notification_$key' ></span ></a ></li >";
    // }
    foreach ($data as $key => $value) {
        $innerHtmlStatusDock .= "<li class='notification inline search_status'  style='color: black' id='filter_$key' onclick = 'changeTab("."\"".$key."\"".");'><a><span >".$value['name']."</span ><span class='text-danger'> (0)</span></a ></li >";
    }
    $model_wares = new Models_WareHouses();
    $list_ware = $model_wares->customFilter('',array('user_id' => $adminuser->getId(), 'status' => 1));
    $count = count($list_ware);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Quản lý đơn hàng</title>
    <?php include 'includes/inc_head.php'?>
    <style>
       /* span.select2-container {
            z-index: 10050;
        }*/
        .modal-body{
            max-height: 450px;
            overflow-y: auto;
        }
        .notification {
            position: relative;
            border-color: #dee2e6 #dee2e6 #fff;

        }

        .notification.inline {
            padding: 10px;
            display: inline-block;
        }
        .notification span {
            font-weight: bold;
            /*font-family: "Open Sans", sans-serif !important;*/
            font-family: inherit !important;
            padding-bottom: 5px;
        }

        .notification:hover{
            cursor: pointer;
            color: #3d63d2;
        }
         .notification span:hover{
            color: #3d63d2;
        }
        .notification .badge {
            padding: 5px 10px;
            right: -10px;
            margin-left: 5px;
            border-top-left-radius: 2em;
            border-top-right-radius: 2em;
            border-bottom-left-radius: 2em;
            border-bottom-right-radius: 2em;
            background-color: #f39834;
            color: #ffffff;
        }

    </style>
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
                        <h1 class="h3 mb-0 text-gray-800">Quản lý đơn hàng</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Quản lý đơn hàng</span> </h6>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-3 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" class="input-daterange form-control" name="date_range" id="date_range">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã vận đơn,SĐT" class="form-control" name="code_phone">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã đơn shop" class="form-control" name="soc">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="form-group">
                                            <select name="ware_id" class="select2_js_2" id="warehourse_select_id" style="width: 100%;">
                                                <option value="0" selected>Tất cả kho hàng</option>
                                                <?php foreach ($list_ware as $li) { 
                                                    echo "<option value=".$li->getId().">$li->name</option>";
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search fa-sm"></i> Tìm</button>
                                    </div>
                                </div>   
                            </form> 
                            <div class="row">
                                <ul class="nav-link list-inline root_nav_stt"><?= $innerHtmlStatusDock ?></ul>
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">STT</th>
                                                <th style="width: 22%">Mã Đơn</th>
                                                <th style="width: 20%">Sản phẩm</th>
                                                <th style="width: 42%">Bên nhận</th>
                                                <th style="width: 17%">Phí</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="text-primary" style="font-weight: bold; font-size: 18px;">8485513156456</span><br>
                                                        <span class="label label-secondary">Tạo mới</span>
                                                    </div>
                                                    <div style="color: #717171!important; font-weight: bold;">
                                                        <span>Kho zyn 1</span> - <span>0387172821</span>
                                                    </div>
                                                    <button class="btn btn-outline-primary send_feedback_od" type="button"><i class="far fa-comments"></i> Gửi yêu cầu</button>
                                                </td>
                                                <td>
                                                    <span style="font-weight: 700;">Nhẫn Nhiệt Độ - 8</span>
                                                    <div style="overflow: hidden;">
                                                        <span class="float-left">Tạo qua:</span>
                                                        <span class="float-right">
                                                            <label class="label label-light-green" style="font-size: 13px;"><i class="fas fa-cloud-upload-alt"></i> Excel</label>
                                                        </span>
                                                    </div>
                                                    <div style="overflow: hidden;">
                                                        <span class="weight float-left">Khối lượng:</span>
                                                        <span class="float-right" style="font-weight: 700;">4,500 gr</span>
                                                    </div>
                                                    <div style="overflow: hidden;">
                                                        <span class="float-left">COD:</span>
                                                        <span class="float-right">
                                                            <strong>0₫</strong>
                                                        </span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="color: #717171!important;">
                                                        <div class="btn-group btn-xs btn-outline" role="group" aria-label="">
                                                            <button type="button" class="btn btn-outline-primary btn-xs journey"><i class="fas fa-map-marker-alt"></i> Hành Trình</button>
                                                            <button type="button" class="btn btn-outline-primary btn-xs print_od"><i class="fas fa-print"></i> In bill</button>
                                                            <a href="<?= Commons_WebConst::HTACCESS_DETAIL_ORDER?>-8485513156456" target="_blank" class="btn btn-outline-primary btn-xs"><i class="fas fa-info"></i> Chi tiết</a>
                                                            <button type="button" class="btn btn-danger btn-xs journey"><i class="fas fa-trash-alt"></i> Hủy</button>
                                                        </div><br>
                                                        <span class="float-right">Đỗ Thị Duyên - 0387172821</span><br>
                                                        <span style="font-weight: bold; text-align: justify;">nvaklksdjalksjdlkjals, Ngõ asdasd, xomsg 1 ,Lương quy, xuân nộn, đông anh, hà nội</span><br>
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div style="overflow: hidden;">
                                                        <span class="float-left">Ship:</span>
                                                        <span class="float-right">
                                                            <strong>18,000₫</strong>
                                                        </span>
                                                    </div>
                                                    <div style="overflow: hidden;">
                                                        <span class="float-left">BH:</span>
                                                        <span class="float-right">
                                                            <strong>0₫ </strong>
                                                        </span>
                                                    </div>
                                                    <div style="overflow: hidden;">
                                                        <span class="float-left">COD:</span>
                                                        <span class="float-right">
                                                            <strong>0₫ </strong>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

    </div>
</body>

</html>
<!-- Date range picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js?v=1.0"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js?v=1.0"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css?v=1.0"/>
<script type="text/javascript">
    $(document).ready(function(){
        var status_tab = 'stt_total';
        $('#msg_err_feedback').hide();
        $('#msg_err_journeies').hide();
        changeTab(status_tab);
        $('.input-daterange').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                "customRangeLabel": "Khoảng thời gian",
            },
            "autoApply": true,
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 ngày gần đây': [moment().subtract(6, 'days'), moment()],
                '30 ngày gần đây': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Tất cả': [ moment().year(2021).month(1).date(1), moment()]
            }
        });
        $('.send_feedback_od').on('click', function(){
            $('#feedbackModal').modal('show');
            $('#content_fb').val('');
            $('#feedback_select').val('');
        });
        
        $('.journey').on('click', function(){
            $('#journeyModal').modal('show');
        });
        $('.print_od').on('click', function(){
            $('#printModal').modal('show');
        });
    });
    function changeTab(id) {
        status_tab = id;
        $('.notification').not('#filter_' + id).css({"border-bottom": "0px", "color": "#010101"});
        $('.notification').not('#filter_' + id).hover(function () {
                $(this).css("color", "#3d63d2");
            }, function () {
                $(this).css("color", "black");
            }
        );
        $('#filter_' + id).hover(function () {
                $(this).css("color", "#3d63d2");
            }, function () {
                $(this).css("color", "#3d63d2");
            }
        );
        $('#filter_' + id).css({"border-bottom": "2px solid #3d63d2", "color": "#3d63d2"});
    }
</script>
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gửi yêu cầu đơn hàng: <span class="text-primary" style="font-weight: bold; font-size: 18px;">8485513156456</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" id="formAddWare">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="_function" value="add_ware">
                        <span>Bạn muốn yêu cầu về vấn đề gì?</span>
                        <select class="form-control  mt-2" name="feedback_select" id="feedback_select" style='width: 100%'>
                            <option value="">Hãy chọn lí do yêu cầu xử lý</option>
                            <optgroup label="Chỉnh sửa đơn hàng">
                                <option value="2">Sửa SĐT người nhận</option>
                                <option value="3">Sửa địa chỉ</option>
                                <option value="4">Sửa COD (Tiền thu hộ)</option>
                            </optgroup>
                            <optgroup label="Hẹn lịch">
                                <option value="2">Hẹn lấy hàng</option>
                                <option value="3">Hẹn trả hàng</option>
                                <option value="4">Hẹn giao hàng</option>
                            </optgroup>
                            <optgroup label="Giục lấy/giao/trả hàng">
                                <option value="5">Giục lấy hàng</option>
                                <option value="6">Giục trả hàng</option>
                                <option value="7">Giục giao hàng</option>
                                <option value="7">Giục chuyển COD</option>
                            </optgroup>
                            <optgroup label="Khiếu nại">
                                <option value="5">Thu sai COD</option>
                                <option value="6">Đối soát thiếu tiền</option>
                                <option value="7">Chưa nhận được tiền chuyển khoản</option>
                                <option value="7">Hàng hỏng vỡ</option>
                                <option value="7">Hàng thất lạc, giao thiếu, giao nhầm</option>
                                <option value="7">Chưa nhận được hàng trả</option>
                            </optgroup>
                            <optgroup label="Khác">
                                <option value="5">Yêu cầu khác (Thời gian xử lý chấm hơn)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="Nội dung yêu cầu" class="form-control" name="content_fb" id="content_fb"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="btn_add">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </div>
                    <div id="msg_err_feedback" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>

                    <span id="msg_err_log"></span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="journeyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hành trình đơn hàng: <span class="text-primary" style="font-weight: bold; font-size: 18px;">8485513156456</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="msg_err_journeies" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin mời chờ...</div>
                <table class="table table-striped" style=" font-size: 15px;">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th style="text-align: center;">Hành trình</th>
                            <th style="width: 25%">Thời gian</th>
                            <th style="width: 25%">Shipper</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nhân viên shipper A đã lấy hàng thanhf coong vao hom qua luc chieu toi co toi o nha</td>
                            <td>03-08-2021 15:30:30</td>
                            <td>Nguyễn The A <br> 0387172525</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Nhân viên shipper A đã lấy hàng</td>
                            <td>03-08-2021 15:30:30</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Nhân viên shipper A đã lấy hàng</td>
                            <td>03-08-2021 15:30:30</td>
                            <td>Nguyễn The A <br> 0387172525</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">In nhãn dán: <span class="text-primary" style="font-weight: bold; font-size: 18px;">8485513156456</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <a href="" class="btn btn-danger" >Khổ 100*75</a>
                    <a href="" class="btn btn-danger" >Khổ 50*50</a>
                    <a href="" class="btn btn-danger" >Khổ A5</a>
                    <a href="" class="btn btn-danger" >Khổ A6</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>