<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $data = Commons_OrdersConst::ARRAY_MENU_FEEDBACK_ORDER;
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
    <title><?= Commons_WebConst::TITLE_WEB ?> - Quản lý phản hồi</title>
    <?php include 'includes/inc_head.php'?>
    <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Quản lý phản hồi</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Quản lý phản hồi</span> </h6>
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
                                    <div class="col-sm-2">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search fa-sm"></i> Tìm</button>
                                    </div>
                                </div>   
                            </form> 
                            <div class="row">
                                <ul class="nav-link list-inline root_nav_stt"><?= $innerHtmlStatusDock ?></ul>
                            </div>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Đơn hàng</th>
                                                <th>Phản hồi khách hàng</th>
                                                <th>Nội dung trả lời (Admins)</th>
                                                <th>Trạng thái phản hồi</th>
                                                <th>NV phản hồi</th>
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
                                                </td>
                                                <td>
                                                    <span class="label label-primary">Sửa COD</span><br>
                                                    <span>
                                                        Nội dung: sửa cod 300000
                                                    </span>
                                                </td>

                                                <td>
                                                    <span>
                                                        (14-3-2021 15:13 ) Đã sửa cod
                                                    </span>
                                                </td>
                                                
                                                <td>
                                                    <span class="label label-primary">Đã xử lý</span><br>
                                                    <div style="overflow: hidden">
                                                        <span class="text-danger float-left">
                                                            Tạo: </span><span class="float-right"><strong>06-10-2021 23:31</strong>
                                                        </span>
                                                    </div>
                                                    <div style="overflow: hidden">
                                                        <span class="text-danger float-left">
                                                            Phản hồi: </span><span class="float-right"><strong>06-10-2021 23:31</strong>
                                                        </span>
                                                    </div>
                                                    <!-- <div style="overflow: hidden">
                                                        <span class="text-success float-left">
                                                            Tạo: </span><span class="float-right"><strong>06-10-2021 23:31</strong>
                                                        </span>
                                                    </div> -->
                                                </td>
                                                <td>
                                                    <span>CSKH - DO DUYEN</span>
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
<script src="js/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var status_tab = 'stt_total';
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
        $('.journey').on('click', function(){
            $('#journeyModal').modal('show');
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
