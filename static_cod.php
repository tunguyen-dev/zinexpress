<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $data = Commons_OrdersConst::ARRAY_MENU_TAB_ORDER;
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
    <title><?= Commons_WebConst::TITLE_WEB ?> - Thống kê COD</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Thống kê COD</h1>
                        <div class="input-group" style="width: 300px !important" >
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="input-daterange form-control" name="date_range" id="date_range">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Thống kê COD</span> </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myBarChart"></canvas>
                                        <!-- <canvas id="myPieChart"></canvas> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="border: 1px solid #e3e6f0 !important; color: #333;">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 25px">Trạng thái</th>
                                                    <th>Số đơn</th>
                                                    <th>Chiếm</th>
                                                    <th>COD</th>
                                                    <th>Cước</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $html = "";
                                                    foreach ($data as $key => $value) {
                                                        if ($value['status'] == "") {
                                                            continue;
                                                        }
                                                        $html .= "<tr>";
                                                            $html .= "<td style='padding-left: 25px'>".Commons_ConvertStatusOrder::ConvertStatus($value['status'])."</td>";
                                                            $html .= "<td>13</td>";
                                                            $html .= "<td>20%</td>";
                                                            $html .= "<td>400,000</td>";
                                                            $html .= "<td>20,000</td>";
                                                        $html .= "</tr>";
                                                    }
                                                    echo $html;
                                                ?>
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
    var ctx = document.getElementById("myBarChart");
    // var ctx2 = document.getElementById("myPieChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $label_chart ?> ,
            datasets: [{
                data: [15, 4, 1, 2, 6, 10, 45, 10, 15, 25, 35, 5],
                backgroundColor: <?= $color_chart ?> ,
                // hoverBackgroundColor: ['#2e59d9', '#ed2337', '#177a63'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Biểu đồ số lượng đơn hàng"
            },
        },
    });
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