<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Lịch sử giao dịch</title>
    <?php include 'includes/inc_head.php'?>
    
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
                        <h1 class="h3 mb-0 text-gray-800">Lịch sử giao dịch</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Lịch sử giao dịch</span> </h6>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" class="input-daterange form-control" name="date_range" id="date_range">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="form-group">
                                            <select name="ware_id" class="select2_js_2" id="status" style="width: 100%;">
                                                <option value="">Tất cả loại giao dịch</option>
                                                <option value="0">Nhận tiền từ PĐS</option>
                                                <option value="2">Nhận tiền đền bù</option>
                                                <option value="1">Rút tiền</option>
                                                <option value="1">Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã giao dịch" class="form-control" name="code">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search fa-sm"></i> Tìm</button>
                                    </div>
                                </div>   
                            </form> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table" style="border: 1px solid #e3e6f0 !important; color: #333;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Mã giao dịch</th>
                                                    <th>Loại</th>
                                                    <th>Số tiền</th>
                                                    <th>Số dư đầu</th>
                                                    <th>Số dư cuối</th>
                                                    <th>Nội dung</th>
                                                    <th>Thời gian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>GD20829139</td>
                                                    <td>Nhận tiền từ PĐS</td>
                                                    <td><i class="fa fa-arrow-down" aria-hidden="true" style="color: #5cb85c"></i> 200,000</td>
                                                    <td>0</td>
                                                    <td>200,000</td>
                                                    <td>Nhận tiền từ Phiếu Đối Soát: <strong>PDSTOPM5702319228_23_09</strong>. Bởi Nhân Viên: <strong>FC Ha Dong 2</strong></td>
                                                    <td>23/09/2021 20:50:39</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>GD20829140</td>
                                                    <td>Nhận tiền đền bù</td>
                                                    <td><i class="fa fa-arrow-down" aria-hidden="true" style="color: #5cb85c"></i> 153,000</td>
                                                    <td>200,000</td>
                                                    <td>353,000</td>
                                                    <td>Nhận tiền đền bù đơn hàng: <strong>843294309</strong>. Bởi Nhân Viên: <strong>FC Ha Dong 2</strong></td>
                                                    <td>23/09/2021 20:50:39</td>
                                                </tr><tr>
                                                    <td>3</td>
                                                    <td>GD20829141</td>
                                                    <td>Rút tiền</td>
                                                    <td><i class="fa fa-arrow-up" aria-hidden="true" style="color: #fa170f"></i> -353,000</td>
                                                    <td>353,000</td>
                                                    <td>0</td>
                                                    <td>Shop yêu cầu rút tiền. Mã giao dịch: <strong>GD20829141</strong></td>
                                                    <td>23/09/2021 20:50:39</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
<script>
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
</script>