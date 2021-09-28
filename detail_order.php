<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    // echo $_GET['id'];
    // exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Chi tiết đơn hàng</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng: <span class="text-primary">8485513156456</span></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <span>
                                       <span style="font-weight: 700">Mã vận đơn: </span>
                                       <span class="float-right text-danger"><i class="fas fa-barcode"></i> <strong>8485513156456</strong></span>
                                    </span><br>
                                    <span>
                                       <span style="font-weight: 700">Mã khách hàng: </span>
                                       <span class="float-right "> AUTO45641</span>
                                    </span><br>
                                    <span>
                                       <span style="font-weight: 700">Ngày tạo: </span>
                                       <span class="float-right "> 14-03-2021 13:10:00</span>
                                    </span><br>
                                    <span>
                                        <span style="font-weight: 700">Trạng thái: </span>
                                        <span class="float-right "> <?= Commons_ConvertStatusOrder::ConvertStatus(6)?></span>
                                    </span>
                                    <hr>
                                    <h5><strong class='text-danger'>Người gửi</strong></h5>
                                    <span>
                                        <span style="font-weight: 700">Tên người gửi: </span>
                                        <span class="float-right "> SHOP TUZYN</span>
                                        </span><br>
                                        <span>
                                        <span style="font-weight: 700">SĐT: </span>
                                        <span class="float-right "> 0387170000</span>
                                    </span><br>
                                    <span>
                                        <span style="font-weight: 700">Địa chỉ: </span>
                                        <span> số 68 ngõ 68 vạn phúc, Phường Vạn Phúc, Quận Hà Đông, Thành Phố Hà Nội</span>
                                    </span>
                                    <hr>
                                    <h5><strong class='text-danger'>Người nhận</strong></h5>
                                    <span>
                                        <span style="font-weight: 700">Tên người nhận: </span>
                                        <span class="float-right "> TU NGUYEN</span>
                                        </span><br>
                                        <span>
                                        <span style="font-weight: 700">SĐT nhận: </span>
                                        <span class="float-right "> 0387172222</span>
                                    </span><br>
                                    <span>
                                        <span style="font-weight: 700">Địa chỉ nhận: </span>
                                        <span> số 68 ngõ 68 vạn phúc, Phường Vạn Phúc, Quận Hà Đông, Thành Phố Hà Nội</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thông tin gói hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <span>
                                       <span style="font-weight: 700">Sẩn phẩm: </span>
                                       <span class="float-right">Quần áo</span>
                                    </span><br>
                                    <span>
                                       <span style="font-weight: 700">Khối lượng: </span>
                                       <span class="float-right "> 500 Gr</span>
                                    </span><br>
                                    <span>
                                       <span style="font-weight: 700">Chiều: </span>
                                       <span class="float-right "> D: 5cm - R: 5cm - C: 5cm</span>
                                    </span><br>
                                    <span>
                                       <span style="font-weight: 700">Ghi chú: </span>
                                       <span class="float-right "> giao nhanh giúp shop</span>
                                   </span>
                                   <span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Hành trình</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                   
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

<script type="text/javascript">
    
</script>
