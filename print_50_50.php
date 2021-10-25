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
        <title>In Đơn Hàng - Khổ 50*50</title>
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
            <div style="width: 460px; height: auto; margin: 0 auto;">
                <div class="page" style="border: 0px solid #000; margin-bottom: 5px; padding: 10px;">
                    <table cellpadding="7" style="margin: 0;">
                        <tr>
                            <td width="225" height="auto" style="position: relative; font-size: 14px !important;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-end;border-bottom: 1px dashed #000; margin-bottom: 5px;">
                                    <div>
                                        <div>
                                            <!-- <img src="assets/img/doitac/logobest2.png" width="225" alt="BESTINC" height="35" /> -->
                                            <img src="<?=$logo_text_removegb?>" width="250"/> 
                                            <img class="barcode_img" jsbarcode-value="84845645645" jsbarcode-format="auto" jsbarcode-width="2" jsbarcode-height="75"/>
                                        </div>
                                    </div>
                                </div>
                                <div style="border-bottom: 1px dashed #000;padding-bottom:5px; margin-bottom: 1px;font-weight: bold; text-align: center;font-size:18px">
                                    <span>HN-HADONG-12</span>
                                </div>
                                <div class="">
                                    <div>
                                        <div style="font-size: 11px;">
                                            <strong>SHOP ZYN</strong><br>
                                        </div>
                                        <div style="font-size: 11px;">
                                        <strong>Tu nguyen</strong>, <strong>038***2821</strong>, <span>15/51, Phường Vạn Phúc, Quận Hà Đông, Thành Phố Hà Nội</span>
                                        </div>
                                        <span>Quàn bò nam</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
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
