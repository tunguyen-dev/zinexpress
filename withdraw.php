<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $models_banks = new Models_Banks();
    $obj_banks = $models_banks->getObject($adminuser->bank_id);
    $models_branch = new Models_BranchBanks();
    $id_branch_check = $adminuser->branch_id;
    $obj_branch = $models_branch->getObject($id_branch_check);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Rút tiền</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Rút tiền</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Đặt lệnh rút tiền</span> </h6>
                        </div>
                        <div class="card-body">
                            <form role="form" id="formWithDraw">
                                <div class="form-group">
                                    <input type="text" value="<?= $obj_banks->name?>" required="" class="form-control" name="name_bank" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" value="<?= $obj_branch->name?>" required="" class="form-control" name="name_branch" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Chủ tài khoản..." value="<?= $adminuser->acc_name?>" required="" class="form-control" name="acc_name" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Số tài khoản..." value="<?= $adminuser->acc_number?>" required="" class="form-control" name="acc_number" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Nhập số tiền muốn rút" required="" class="form-control number_cleave" name="money" id="money">
                                </div>
                                <!-- <div class="form-group">
                                    <p id="msg_err_bank"></p>
                                </div> -->
                                <?php if ($adminuser->authenticator == 'on') {?>
                                    <div class="form-group">
                                        <input type="text" placeholder="Mã xác thực 2 lớp..." required="" class="form-control" name="opt_check">
                                    </div>
                                <?php }?>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="btn_add_bank"><strong><i class="fas fa-donate"></i> Rút tiền</strong></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><span id="text-title">Lịch sử rút tiền</span> </h6>
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
                                        <div class="input-group">
                                            <input type="text" placeholder="Mã giao dịch" class="form-control" name="code">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search fa-sm"></i> Tìm</button>
                                    </div>
                                </div>   
                            </form> 
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table" style="border: 1px solid #e3e6f0 !important; color: #333;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Mã giao dịch</th>
                                                    <th>Số tiền</th>
                                                    <th>Thời gian tạo</th>
                                                    <th>Thời gian thành công</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>GD20829139</td>
                                                    <td>200,000</td>
                                                    <td>23/09/2021 20:50:39</td>
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
<script type="text/javascript" src="js/cleavejs/cleave.min.js"></script>
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
    $('.number_cleave').toArray().forEach(function(field){
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        })
    });
</script>