<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; TUNGUYEN-DEV 2021</span>
        </div>
    </div>
</footer>
<!-- Custom scripts for all pages-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script src="js/sb-admin-2.min.js?v=1.0"></script>
<?php
    $model_ware = new Models_WareHouses();
    $obj_ware = $model_ware->getObjectByCondition('',array('user_id' => $adminuser->getId()));
    // var_dump($obj_ware);
    $model_cities = new Models_Cities();
    $list_cities = $model_cities->getList2();
?>
<?php if (!is_object($obj_ware)) {?>
    <link href="css/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="js/sweetalert/sweetalert.min.js"></script>
    <!-- Modal ADD WARE-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#modalWareRequired').modal('show');
            $('#msg_err_required').hide();
            $("#msg_err_log_required").hide(); 

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
                        $('.select2_js').select2({
                            dropdownParent: $('#modalWareRequired')
                        });  
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
                                    $('.select2_js').select2({
                                        dropdownParent: $('#modalWareRequired')
                                    });     
                                }         
                            });  
                        });     
                    }         
                });     
            });

            $("#formAddWareRequired").ajaxForm({
                url : './ajax/warehouse.php',
                type : 'post',
                dataType : 'json',
                beforeSend : function() {
                    $("#msg_err_required").show();
                    $("#msg_err_log_required").hide();
                    $("#btn_add_required").hide();
                },
                success : function(data) {
                    if(data.code == 1) {
                        $("#msg_err_log_required").html("<span class='label label-danger'>" + data.msg + "</span>");
                        $("#btn_add_required").show();
                        $("#msg_err_log_required").show();
                    }
                    if(data.code == 0) {
                        swal({
                            title: "Th??nh C??ng!",
                            text: "Th??m kho h??ng th??nh c??ng!",
                            type: "success",
                        });
                        $(".confirm").on("click",function() {
                            location.reload();
                        })
                    }
                    $("#msg_err_required").hide();
                }
            });
        });
    </script>
    <div class="modal fade" id="modalWareRequired" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">B???n ch??a c?? kh?? h??ng t???o kho h??ng ngay ????? s??? d???ng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="user" id="formAddWareRequired">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="_function" value="add_ware">
                            <input type="text" class="form-control form-control-user" placeholder="T??n kho (t??n n??y s??? hi???n thi tr??n bill)" name="name" required="" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" placeholder="S??? ??i???n tho???i (s??? n??y s??? hi???n th??? tr??n bill)" name="phone" required="" value="<?= $adminuser->phone?>"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" placeholder="?????a ch??? chi ti???t" name="address" required=""/>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <select class="form-control select2_js" name="city" id="city" style='width: 100%'>
                                    <option>T???nh/TP...</option>
                                    <?php
                                        foreach ($list_cities as $li_ci) {
                                            echo "<option value='$li_ci->code'>$li_ci->name</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div id="load_district">
                                    <select class="form-control select2_js" name="district" style='width: 100%'>
                                        <option>Qu???n/Huy???n...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div id="load_commune">
                                    <select class="form-control select2_js" name="commune" style='width: 100%'>
                                        <option>Ph?????ng/X??...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="btn_add_required">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">????ng</button>
                            <button type="submit" class="btn btn-primary">T???o kho</button>
                        </div>
                        <div id="msg_err_required" style="text-align: center;" class="text-primary"><span class="spinner-border spinner-border-sm"></span> Xin m???i ch???...</div>

                        <span id="msg_err_log_required"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php }?>