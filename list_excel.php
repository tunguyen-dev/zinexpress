<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Danh sách file excel</title>
    <?php include 'includes/inc_head.php'?>
    <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
    <style>
        div#DataTables_Table_0_info {
            padding-bottom: 5px;
        }
        .mail-box {
            padding-left: 10px;
            padding-right: 10px;
        }
        #table_file_id thead {
            display: none;
        }

        .file_list_content {
            overflow-y: auto;
            max-height: 450px;
        }

        .feed-element:hover {
            background-color: #dee2e6;
        }
        .feed-element {
            /* margin-top: 0; */
            padding: 10px;
            cursor: pointer;
        }

        .file_list_content {
            padding: 0px !important;
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
                        <h1 class="h3 mb-0 text-gray-800">Danh sách file excel tải lên</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Danh sách file excel tải lên</span> </h6>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-3 wrapper  white-bg page-heading">
                                    <div class="ibox ">
                                        <div class="ibox-title border-bottom">
                                            <h5>Danh sách file đơn hàng</h5>
                                        </div>
                                        <div class="ibox-content file_list_content">
                                            <div class="feed-activity-list file_upload_list">
                                                <div class="feed-element border-bottom" id="1">
                                                    <div>
                                                        <small class='float-right' style="color: #1ab394 !important;font-weight: 700">14-03-2021 15:21</small>
                                                        <strong style="font-weight: 700">Kho: ZYN STORE</strong>
                                                        <div style="font-weight: 700"><i class='fa fa-file-excel-o' aria-hidden='true'></i> tao_don_hang_file_20.xlsx</div>
                                                        <br><small class='float-right text-muted' style="font-weight: 700">20 đơn</small>
                                                        <br><small class='float-right label label-success'>Shop trả phí giao hàng</small>
                                                        <label class="label label-primary">Đã xử lý</label>
                                                    </div>
                                                </div>
                                                <div class="feed-element border-bottom" id="2">
                                                    <div>
                                                        <small class='float-right' style="color: #1ab394 !important;font-weight: 700">14-03-2021 15:21</small>
                                                        <strong style="font-weight: 700">Kho: ZYN STORE</strong>
                                                        <div style="font-weight: 700"><i class='fa fa-file-excel-o' aria-hidden='true'></i> tao_don_hang_file_20.xlsx</div>
                                                        <br><small class='float-right text-muted' style="font-weight: 700">20 đơn</small>
                                                        <br><small class='float-right label label-success'>Shop trả phí giao hàng</small>
                                                        <label class="label label-primary">Đã xử lý</label>
                                                    </div>
                                                </div>
                                                <div class="feed-element border-bottom" id="3">
                                                    <div>
                                                        <small class='float-right' style="color: #1ab394 !important;font-weight: 700">14-03-2021 15:21</small>
                                                        <strong style="font-weight: 700">Kho: ZYN STORE</strong>
                                                        <div style="font-weight: 700"><i class='fa fa-file-excel-o' aria-hidden='true'></i> tao_don_hang_file_20.xlsx</div>
                                                        <br><small class='float-right text-muted' style="font-weight: 700">20 đơn</small>
                                                        <br><small class='float-right label label-success'>Shop trả phí giao hàng</small>
                                                        <label class="label label-primary">Đã xử lý</label>
                                                    </div>
                                                </div>
                                                <div class="feed-element border-bottom" id="4">
                                                    <div>
                                                        <small class='float-right' style="color: #1ab394 !important;font-weight: 700">14-03-2021 15:21</small>
                                                        <strong style="font-weight: 700">Kho: ZYN STORE</strong>
                                                        <div style="font-weight: 700"><i class='fa fa-file-excel-o' aria-hidden='true'></i> tao_don_hang_file_20.xlsx</div>
                                                        <br><small class='float-right text-muted' style="font-weight: 700">20 đơn</small>
                                                        <br><small class='float-right label label-success'>Shop trả phí giao hàng</small>
                                                        <label class="label label-primary">Đã xử lý</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 animated fadeInRight">
                                    <div class="mail-box-header">
                                        <h2>
                                            <input type='hiden' id="ids_cr" style="display: none">
                                            Đơn hàng trong file
                                        </h2>
                                        <button class="btn btn-outline btn-danger print_label" target="_blank">
                                            <i class="fa fa-print"></i> In Nhãn 100*75
                                        </button>
                                        <button class="btn btn-outline btn-primary export_excel" target="_blank">
                                            <i class="fa fa-file-excel"></i> Xuất Excel
                                        </button>

                                    </div>

                                    <div class="mail-box">
                                        <div class="table-responsive">
                                            <table class="table table-hover table_detail_file_id">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Đơn hàng</th>
                                                    <th>Người nhận & địa chỉ</th>
                                                    <th>Kích thước & Giá trị</th>
                                                    <th>Mô tả</th>
                                                </tr>
                                                </thead>
                                                <tbody id="body_detail_file_id">
                                                    <tr>
                                                        <td>1</td>
                                                        <td style='width: 30%'>
                                                            <div>Mã đơn: <strong>679832487982</strong></div>  
                                                            <div  style='word-break: break-all;'>Mã đơn KH: <strong>SHOPZYN131</strong></div>  
                                                            <div>Tên SP: <strong>Ao quan</strong></div>
                                                            <div>Ghi chú: <strong>giao nhanh giup shop</strong></div>
                                                            <div> <label class="label label-primary">Đã xử lý</label></div>
                                                        </td>
                                                        <td style='width: 35%'>
                                                            <div>Tên: <strong>Duyen</strong></div>  
                                                            <div>SĐT: <strong>0387172821</strong></div>
                                                            <hr>
                                                            <div>Chi tiết: <strong>13/454 pho vong</strong></div>  
                                                            <div>Xã/Phường: <strong>Phuong Van Phuc</strong></div>  
                                                            <div>Quận/Huyện: <strong>Ha Dong</strong></div>
                                                            <div>Tỉnh/Thành Phố: <strong>Thanh Pho Ha Noi</strong></div>
                                                        </td>
                                                        <td style='width: 15%'>
                                                            <div>Thu hộ (COD): <strong>500,000đ</strong></div>  
                                                            <div>Giá trị: <strong>1,000,000đ</strong></div>

                                                            <hr>
                                                            <div>Khối lượng: <strong>1 Kg</strong></div>  
                                                            <div>Chiều dài: <strong>5 cm</strong></div>
                                                            <div>Chiều rộng: <strong>5 cm</strong></div>
                                                            <div>Chiều cao: <strong>5 cm</strong></div>
                                                        </td>
                                                        <td style='width: 20%'>
                                                            <div>Tạo: <strong>28-09-2021 15:04</strong></div>
                                                            <div>Xử lý: <strong>28-09-2021 15:21</strong></div>
                                                            <br>
                                                            <div  ><strong class='label label-primary'>Lên đơn thành công</strong><div>
                                                            <button class='btn btn-outline-danger btn-xs go_order_mng' id = ''><i class='fa fa-paper-plane'></i> Tới đơn hàng này</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td style='width: 30%'>
                                                            <div>Mã đơn: <strong>679832487982</strong></div>  
                                                            <div  style='word-break: break-all;'>Mã đơn KH: <strong>SHOPZYN131</strong></div>  
                                                            <div>Tên SP: <strong>Ao quan</strong></div>
                                                            <div>Ghi chú: <strong>giao nhanh giup shop</strong></div>
                                                            <div> <label class="label label-primary">Đã xử lý</label></div>
                                                        </td>
                                                        <td style='width: 35%'>
                                                            <div>Tên: <strong>Duyen</strong></div>  
                                                            <div>SĐT: <strong>0387172821</strong></div>
                                                            <hr>
                                                            <div>Chi tiết: <strong>13/454 pho vong</strong></div>  
                                                            <div>Xã/Phường: <strong>Phuong Van Phuc</strong></div>  
                                                            <div>Quận/Huyện: <strong>Ha Dong</strong></div>
                                                            <div>Tỉnh/Thành Phố: <strong>Thanh Pho Ha Noi</strong></div>
                                                        </td>
                                                        <td style='width: 15%'>
                                                            <div>Thu hộ (COD): <strong>500,000đ</strong></div>  
                                                            <div>Giá trị: <strong>1,000,000đ</strong></div>

                                                            <hr>
                                                            <div>Khối lượng: <strong>1 Kg</strong></div>  
                                                            <div>Chiều dài: <strong>5 cm</strong></div>
                                                            <div>Chiều rộng: <strong>5 cm</strong></div>
                                                            <div>Chiều cao: <strong>5 cm</strong></div>
                                                        </td>
                                                        <td style='width: 20%'>
                                                            <div>Tạo: <strong>28-09-2021 15:04</strong></div>
                                                            <div>Xử lý: <strong>28-09-2021 15:21</strong></div>
                                                            <br>
                                                            <div  ><strong class='label label-primary'>Lên đơn thành công</strong><div>
                                                            <button class='btn btn-outline-danger btn-xs go_order_mng' id = ''><i class='fa fa-paper-plane'></i> Tới đơn hàng này</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td style='width: 30%'>
                                                            <div>Mã đơn: <strong>679832487982</strong></div>  
                                                            <div  style='word-break: break-all;'>Mã đơn KH: <strong>SHOPZYN131</strong></div>  
                                                            <div>Tên SP: <strong>Ao quan</strong></div>
                                                            <div>Ghi chú: <strong>giao nhanh giup shop</strong></div>
                                                            <div> <label class="label label-primary">Đã xử lý</label></div>
                                                        </td>
                                                        <td style='width: 35%'>
                                                            <div>Tên: <strong>Duyen</strong></div>  
                                                            <div>SĐT: <strong>0387172821</strong></div>
                                                            <hr>
                                                            <div>Chi tiết: <strong>13/454 pho vong</strong></div>  
                                                            <div>Xã/Phường: <strong>Phuong Van Phuc</strong></div>  
                                                            <div>Quận/Huyện: <strong>Ha Dong</strong></div>
                                                            <div>Tỉnh/Thành Phố: <strong>Thanh Pho Ha Noi</strong></div>
                                                        </td>
                                                        <td style='width: 15%'>
                                                            <div>Thu hộ (COD): <strong>500,000đ</strong></div>  
                                                            <div>Giá trị: <strong>1,000,000đ</strong></div>

                                                            <hr>
                                                            <div>Khối lượng: <strong>1 Kg</strong></div>  
                                                            <div>Chiều dài: <strong>5 cm</strong></div>
                                                            <div>Chiều rộng: <strong>5 cm</strong></div>
                                                            <div>Chiều cao: <strong>5 cm</strong></div>
                                                        </td>
                                                        <td style='width: 20%'>
                                                            <div>Tạo: <strong>28-09-2021 15:04</strong></div>
                                                            <div>Xử lý: <strong>28-09-2021 15:21</strong></div>
                                                            <br>
                                                            <div  ><strong class='label label-primary'>Lên đơn thành công</strong><div>
                                                            <button class='btn btn-outline-danger btn-xs go_order_mng' id = ''><i class='fa fa-paper-plane'></i> Tới đơn hàng này</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

    </div>
</body>

</html>
<!-- Date range picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js?v=1.0"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js?v=1.0"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css?v=1.0"/>
<script src="js/sweetalert/sweetalert.min.js"></script>
<script>
    $('.feed-element').on('click', function () {
        id = $(this).attr("id");
        $('.feed-element').css('background-color', '#ffffff')
        // $('.feed-element:hover').css('background-color', '#dee2e6')
        $('.feed-element').css('background-color', '#ffffff')
        $('#' + id).css('background-color', '#dee2e6')
    })
</script>