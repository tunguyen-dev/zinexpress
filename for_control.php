<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $data = Commons_OrdersConst::ARRAY_MENU_FORCONTROL;
    $label_chart = "[";
    $color_chart = "[";
    foreach ($data as $key => $value) {
        if ($value['status'] == "") {
            continue;
        }
        $label_chart .= '"'.$value['name'].'"'.",";
        $color_chart .= '"'.$value['color'].'"'.",";
    }
    $label_chart = rtrim($label_chart, ",")."]";
    $color_chart = rtrim($color_chart, ",")."]";
    // exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Phiếu đối soát</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Phiếu đối soát</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Phiếu đối soát</span> </h6>
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
                                                <option value="">Tất cả trạng thái</option>
                                                <option value="0">Chưa đối soát</option>
                                                <option value="1">Đã đối soát</option>
                                                <option value="2">Đã trả tiền</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã phiếu đối soát" class="form-control" name="code">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 m-b-xs">
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã đơn hàng" class="form-control" name="code_order">
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
                                                    <th>Phiếu đối soát</th>
                                                    <th>Số lượng đơn hàng</th>
                                                    <th>Tiền COD</th>
                                                    <th>Cước phí</th>
                                                    <th>Thực nhận</th>
                                                    <th>Chức năng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <h5 style="color: #e1293d !important; font-weight: 700">PDSTOPM4973118623_07_09</h5>
                                                        <label class="label label-success">Đã Đối Soát</label><br />
                                                        Ngày tạo: 07-09-2021 13:52<br/>
                                                        Ngày đối soát: 07-09-2021 13:53<br/>
                                                        Ngày trả tiền: 07-09-2021 14:50<br/>
                                                    </td>
                                                    <td>179</td>
                                                    <td>450,000 ₫</td>
                                                    <td>
                                                        Phí GH: 3,043,000 ₫<br />
                                                        Phí hoàn: 0 ₫<br />
                                                        Phí BH: 0 ₫<br />
                                                        Phí COD: 0 ₫<br />
                                                        Tổng cước: 0 ₫<br />
                                                    </td>
                                                    <td>-2,593,000 ₫</td>
                                                    <td>
                                                        <a href="detail_phieudoisoat.php?id=18655" class="btn btn-outline btn-primary btn-xs" target="_blank"><i class="fa fa-eye"></i> Xem</a>
                                                        <a href="ajax/export_excel_pds.php?pds_id=18655" class="btn btn-outline btn-danger btn-xs" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Excel</a>
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
<script src="plugin/chart.js/Chart.min.js"></script>
<!-- <script src="js/demo/chart-pie-demo.js?v=1.0"></script> -->
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