<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Thống kê</title>
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
                        <h1 class="h3 mb-0 text-gray-800">THỐNG KÊ</h1>
                        <div class="input-group" style="width: 200px !important" >
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" value="07/2021" id="datepicker">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Đã chuyển tiền</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">40,000 ₫</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Chờ chuyển tiền (Đã đối soát)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">215,000 ₫</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Chưa đối soát</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50,000 ₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Đơn khác (Trừ hủy)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">500,000 ₫</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-9 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thống kê đơn hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Tỉ lệ giao hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Thành công
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Hoàn
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-danger"></i> Khác
                                        </span>
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
    
    <script src="plugin/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js?v=1.0"></script>
    <script src="js/demo/chart-pie-demo.js?v=1.0"></script>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function(){
        // $('#datepicker').daterangepicker({
        //     locale: {
        //         format: 'MM/YYYY',
        //         "customRangeLabel": "Khoảng thời gian",
        //         "daysOfWeek": [
        //             "Thứ 2",
        //             "Thứ 3",
        //             "Thứ 4",
        //             "Thứ 5",
        //             "Thứ 6",
        //             "Thứ 7",
        //             "CN"
        //         ],
        //         "monthNames": [
        //             "Tháng 1",
        //             "Tháng 2",
        //             "Tháng 3",
        //             "Tháng 4",
        //             "Tháng 5",
        //             "Tháng 6",
        //             "Tháng 7",
        //             "Tháng 8",
        //             "Tháng 9",
        //             "Tháng 10",
        //             "Tháng 11",
        //             "Tháng 12"
        //         ],
        //     },
        //     "autoApply": true,
        //     "monthSelect": true,
        //     "singleDatePicker": true,
        //     ranges: {
        //         'Tháng 1': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 2': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        //         'Tháng 3': [moment().startOf('month'), moment().endOf('month')],    
        //         'Tháng 4': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 5': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 6': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 7': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 8': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 9': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 10': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 11': [moment().startOf('month'), moment().endOf('month')],
        //         'Tháng 12': [moment().startOf('month'), moment().endOf('month')],        
        //     }
        // });
        // $("#datepicker").datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     showButtonPanel: true,
        //     dateFormat: 'MM yy',
        //     onClose: function(dateText, inst) { 
        //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        //         $(this).datepicker('setDate', new Date(year, month, 1));
        //     }        
        // });
        $('#datepicker').datepicker({
            format: "mm/yyyy",
            startView: 1,
            minViewMode: 1,
            language: "vi",
            autoclose: true
        });
        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"],
            datasets: [{
              label: "Tổng đơn hàng",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: [20, 10, 20, 30, 40, 50, 100, 100, 500, 200, 150, 300, 300, 20, 15, 50, 300, 20, 15, 28, 93, 20, 30, 250, 100, 300, 220, 13, 300],
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 6,
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return number_format(value)+' đơn';
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: false
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + number_format(tooltipItem.yLabel)+' đơn';
                }
              }
            }
          }
        });
        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ["Thành công", "Hoàn", "Khác"],
            datasets: [{
              data: [55, 30, 15],
              backgroundColor: ['#4e73df', '#e74a3b', '#1cc88a'],
              hoverBackgroundColor: ['#2e59d9', '#ed2337', '#177a63'],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
            },
            legend: {
              display: false
            },
            cutoutPercentage: 80,
          },
        });
    });
</script>