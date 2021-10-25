<?php
    include 'config.php';
    if(!is_object($adminuser)) {
        header("Location: ".Commons_WebConst::HTACCESS_LOGIN);
    }
    // echo $_GET['code'];
?>
<!DOCTYPE html>
<html lang="vi">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>In Đơn Hàng - Khổ 100*75</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <!-- <link href="https://mysupership.com/custom/plg/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="css/print_100_75.css" rel="stylesheet" type="text/css" />
        <link href="css/boostrap_print.min.css" rel="stylesheet" type="text/css" />
        <link href="plugin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="css/print_all.css" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/png" href="<?= $icon_web?>" />
        <style type="text/css" media="print">
            @page 
            {
                size:  auto;   /* auto is the initial value */
                margin: 0mm;  /* this affects the margin in the printer settings */
            }

            html
            {
                background-color: #FFFFFF; 
                margin: 0px;  /* this affects the margin on the html before sending to printer */
            }
            

        </style>
    </head>
    <body>
        <a class="btn btn-danger hidden-print custom-button" onclick="javascript:window.print();">
            IN ĐƠN HÀNG
            <i class="fa fa-print"></i>
        </a>
        <div id="orders-sticker">
            <div style="width: 460px; height: 300px; margin: 0 auto;">
                <div class="page" style="border: 0px solid #000; margin-bottom: 10px; padding: 10px;">
                    <table cellpadding="7" style="margin: 0;">
                        <tr>
                            <td width="500" height="225" style="position: relative; font-size: 14px !important;">
                                <div style="display: flex; border-bottom: 1px dashed #000;">
                                    <div style="flex: 1;" >
                                        <img style="margin-left: -22px" src="<?=$logo_text_removegb?>" width="250"/> 
                                    </div>
                                    <div style="font-size: 25px;width:200px; text-align: right;font-weight:bold;padding-top: 5px">
                                        <div>
                                            HN-HA DONG
                                        </div>
                                    </div>
                                    
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                    <div>                                     
                                        <div>
                                            <!-- <img id="barcode"/> -->
                                            <img class="barcode_img" jsbarcode-value="84845645645" jsbarcode-format="auto" jsbarcode-width="2" jsbarcode-height="75"/>
                                        </div>
                                    </div>
                                    <div style="flex: 1; text-align: right; font-size: 12px; float-right; margin-top:0px">
                                        <div style="font-size: 10px;">
                                            <b>SHOP</b>: <strong>ZYN STORE</strong>
                                        </div>
                                        <div>
                                            <strong>
                                                038***2821
                                            </strong>
                                        </div>
                                        <div style="font-size: 17px;">
                                            <strong>COD: 5,000,000</strong>
                                        </div>
                                        <div style="font-size: 12px;">
                                            <strong>KL: 1Kg</strong>
                                        </div>
                                        <div style="font-size: 12px;">
                                            <strong>15-10-2021 15:25</strong>
                                        </div>
                                        <div>.</div>
                                    </div>
                                </div>
                                <!-- <div class="margin-top-5 margin-bottom-10">
                                    
                                </div> -->
                                <div class="margin-top-5 margin-bottom-5">
                                    <div>
                                        <div style="font-size: 12px;">
                                            <strong>Gói hàng: Giay adidas</strong>
                                        </div>
                                        <div style="font-size: 12px;" class="italic margin-top-5"><strong>0387172821, Tu nguyen, so 15 ngach 51, Phường Vạn Phúc, Quận Hà Đông, Thành Phố Hà Nội</strong></div>
                                        <div style="font-size: 12px;">Mã Shop: <strong>SHPZYN145</strong></div>
                                        <div style="font-size: 15px;"><strong>Ghi chú: </strong>Không cho khách xem hàng - giao nhanh giúp shop</div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- <img class="barcode_img" jsbarcode-value="84845645645" jsbarcode-format="auto" jsbarcode-width="2" jsbarcode-height="75"/> -->
        </div>
        <!-- <script src="plugin/jquery/jquery.min.js"></script> -->
        <!-- <script type="text/javascript" src="js/qrcode/qrcode.js?v=1.0"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/barcodes/JsBarcode.code128.min.js"></script>
        
        <!-- <script src="js/jsbarcode.js"></script> -->
        <script >
            setTimeout(function () {
                window.print();
            }, 1000);
            // // $("#barcode").JsBarcode("8485464546",{width:2,height:50});
            // JsBarcode("#barcode", "8485464546", {format: "CODE128"}); //But you can still specify it
            JsBarcode(".barcode_img").init();
        </script>
    </body>
</html>
