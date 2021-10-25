<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    $model_wares = new Models_WareHouses();
    $list_ware = $model_wares->customFilter('',array('user_id' => $adminuser->getId(), 'status' => 1));
    $count = count($list_ware);
    $model_cities = new Models_Cities();
    $list_cities = $model_cities->getList2();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= Commons_WebConst::TITLE_WEB ?> - Tạo đơn lẻ</title>
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
                        <h1 class="h3 mb-0 text-gray-800">TẠO ĐƠN LẺ</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="formCreateOrder">     
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label_black"><i class="fa fa-home" aria-hidden="true"></i> Kho lấy hàng <span style="color: red">*</span></label></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="load_select">
                                                                <div class="input-group">
                                                                    <select name="ware_id" class="select2_js_2" id="ware" style="width: 100%;">
                                                                        <?php if ($count == 0) { ?>
                                                                            <option value="0">Kho hàng</option>
                                                                        <?php } ?>
                                                                        <?php foreach ($list_ware as $li) { 
                                                                            if ($li->primary_selec == 1) {
                                                                                $selected = 'selected';
                                                                            }else{
                                                                                $selected = '';
                                                                            }
                                                                            echo "<option $selected value=".$li->getId().">$li->name - $li->phone - $li->address, $li->commune, $li->district, $li->city</option>";
                                                                        }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 hr-right">
                                                <h5 class="">- Phần thông tin người nhận:</h5>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fa fa-phone" aria-hidden="true"></i> Số điện thoại <span style="color: red">*</span></label>
                                                    <input placeholder="Nhập SĐT người nhận" required="" type="text" class="form-control" name="phone">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fa fa-user" aria-hidden="true"></i> Tên người nhận <span style="color: red">*</span></label>
                                                    <input placeholder="Tên người nhận..." required="" type="text" class="form-control" name="name">
                                                </div>  
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-map-marker-alt"></i> Địa chỉ chi tiết (cách nhau bởi dấu phẩy)<span style="color: red">*</span></label>
                                                    <input placeholder="VD: số 15 đường quang trung, quang trung,hà đông,hà nội" required="" type="text" class="form-control" name="address" id="address">
                                                </div>
                                                <div id="load_address">
                                                    <div class="form-group">
                                                        <label class="label_black"><i class="fas fa-map-marked-alt"></i> Tỉnh/Thành <span style="color: red">*</span></label>
                                                        <select name="city" class="form-control select2_js_2" id="city">
                                                            <option value="0">Tỉnh/Thành...</option>
                                                            <?php foreach ($list_cities as $li) { ?>
                                                                <option value="<?= $li->code ?>"><?= $li->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="label_black"><i class="fas fa-map-marked-alt"></i> Quận/Huyện <span style="color: red">*</span></label>
                                                        <div id="load_district">
                                                            <select name="district" class="form-control select2_js_2 district" id="district">
                                                                <option value="0">Quận/Huyện...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="label_black"><i class="fas fa-map-marked-alt"></i> Phường/Xã <span style="color: red">*</span></label>
                                                        <div id="load_commune">
                                                            <select name="commune" class="form-control select2_js_2 commune" id="commune">
                                                                <option value="0">Phường/Xã...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <h5 class="">- Phần thông tin hàng hóa:</h5>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-barcode"></i> Mã đơn khách hàng</label>
                                                    <input placeholder="Nhập mã đơn của shop, để rỗng hệ thống sẽ tự tạo" required="" type="text" class="form-control" name="soc">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-box-open"></i> Tên sản phẩm <span style="color: red">*</span></label>
                                                    <input placeholder="Sản phẩm cần giao..." required="" type="text" class="form-control" name="product">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-balance-scale"></i> Khối lượng [Gram] <span style="color: red">*</span></label>
                                                    <input placeholder="Khối lượng của sản phẩm [Gram]..." required="" type="text" class="form-control" name="weight">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-ruler-vertical"></i> Kích thước [Cm]</label>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <input placeholder="Chiều dài" required="" type="text" class="form-control number_cleave" value="5" name="length" id="length">
                                                        </div>
                                                        <div class="col-4">
                                                            <input placeholder="Chiều rộng" required="" type="text" class="form-control number_cleave" value="5" name="width" id="width">
                                                        </div>
                                                        <div class="col-4">
                                                            <input placeholder="Chiều cao" required="" type="text" class="form-control number_cleave" value="5" name="height" id="height">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fab fa-cloudscale"></i> KL Quy Đổi: ([dài*rộng*cao]/6) [Đơn vị: Gram]</label>
                                                    <input placeholder="Khối lượng quy đổi từ kích thước..." readonly type="text" class="form-control" value="21" name="weight_exchange" id="weight_exchange">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-clipboard"></i> Ghi chú đơn hàng</label>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" <?php echo ($adminuser->config_note_select == 0) ? 'checked' : '' ?> type="radio" name="config_note_select" id="seen" value="0">
                                                        <label class="form-check-label" for="seen" style="color:#333;font-size: 15px;font-weight: 400;">
                                                            Cho khách xem hàng
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" <?php echo ($adminuser->config_note_select == 1) ? 'checked' : '' ?> type="radio" name="config_note_select" id="noseen" value="1">
                                                        <label class="form-check-label" for="noseen" style="color:#333;font-size: 15px;font-weight: 400;">
                                                            Không cho khách xem hàng
                                                        </label>
                                                    </div>
                                                    <textarea class="form-control mt-1" name="config_note_text" rows="2" placeholder="Thêm ghi chú khác"><?= $adminuser->config_note_text?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 hr-right">
                                                <h5 class="">- Phần phí thanh toán:</h5>
                                                <div style="font-weight: bold">
                                                    <ul class="list-group mb-3">
                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                          <div>
                                                            <span class="my-0">Phí giao hàng</span>
                                                          </div>
                                                          <span class="text-muted">18,000 đ</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                          <div>
                                                            <span class="my-0">Phí COD</span>
                                                          </div>
                                                          <span class="text-muted">0 đ</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                          <div>
                                                            <span class="my-0">Phí bảo hiểm</span>
                                                          </div>
                                                          <span class="text-muted">0 đ</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between text-success">
                                                          <span>Tổng (VNĐ)</span>
                                                          <strong>18,000 đ</strong>
                                                        </li>
                                                    </ul>
                                                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Tạo đơn</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-hand-holding-usd"></i> Số tiền thu hộ (COD) </label>
                                                    <input placeholder="Nhập số tiền thu hộ để rỗng = 0" required="" type="text" class="form-control" name="product">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="label_black"><i class="fas fa-money-check-alt"></i> Giá trị đơn hàng </label>
                                                    <input placeholder="Nhập giá trị đơn hàng để rỗng = 0" required="" type="text" class="form-control" name="weight">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12">
                                                            <label class="label_black"><i class="fas fa-user-tag"></i> Người trả cước </label>
                                                            <div class="form-check mt-1">
                                                                <input class="form-check-input" type="radio" name="config_payer" id="sender" value="0" <?php echo ($adminuser->config_payer == 0) ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="sender" style="color:#333;font-size: 15px;font-weight: 400;">
                                                                    Người gửi (sẽ trừ phí cước sau khi đối soát)
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="config_payer" id="receiver" value="1" <?php echo ($adminuser->config_payer == 1) ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="receiver" style="color:#333;font-size: 15px;font-weight: 400;">
                                                                    Người nhận (sẽ cộng tiền cước vào COD)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- <div class="">
                                            
                                        </div> -->
                                    </form>
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
<script type="text/javascript" src="js/cleavejs/cleave.min.js"></script>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        function calExchange(width,height,length) {
            var cal = (width*height*length)/6;
            return cal;
        }
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
                    $('.select2_js').select2();  
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
                                $('.select2_js').select2();     
                            }         
                        });  
                    });     
                }         
            });     
        });
        $('#address').unbind();
        $('#address').on('blur', function(){
            var address = $('#address').val();    
            $.ajax({
                url: 'ajax/load_address_ai.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    address: address,             
                },
                success : function(data) {
                    $('#city').html(data.city)
                    $('#district').html(data.district)
                    $('#load_commune select').html(data.commune);
                    $('.select2_js').select2();     
                }         
            }); 
        });
        $('#width').on('blur',function() {
            var width = $('#width').val();
            var height = $('#height').val();
            var length = $('#length').val();
            var exchange = Math.ceil(calExchange(width,height,length));
            $('#weight_exchange').val(exchange);

        });
        $('#height').on('blur',function() {
            var width = $('#width').val();
            var height = $('#height').val();
            var length = $('#length').val();
            var exchange = Math.ceil(calExchange(width,height,length));
            $('#weight_exchange').val(exchange);
            
        });
        $('#length').on('blur',function() {
            var width = $('#width').val();
            var height = $('#height').val();
            var length = $('#length').val();
            var exchange = Math.ceil(calExchange(width,height,length));
            $('#weight_exchange').val(exchange);
        });
        $('.number_cleave').toArray().forEach(function(field){
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            })
        });
    });
</script>