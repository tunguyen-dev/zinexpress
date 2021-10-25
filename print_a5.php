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
        <title>In Đơn Hàng - A5</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <!-- <link href="https://mysupership.com/custom/plg/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/print_a5.css" />
        <link rel="icon" type="image/png" href="<?= $icon_web?>" />
    </head>
    <body>
        <a class="btn btn-danger hidden-print custom-button" style="background-color: #e02d1b !important;color: #fff;cursor: pointer" onclick="javascript:window.print();">
            IN ĐƠN HÀNG
        </a>
        <div class="sheet">
            <!-- HEADER -->
            <div class="aui-group" style="border: 1px solid #333; border-bottom: none; padding: 10px;">
                <div class="aui-item" style="text-align: center;">
                    <div class="aui-left">
                        <div class="aui-item lable-logo" style="vertical-align: middle; margin-top: -15px; padding-top: 15px;">
                            <!-- <img src="assets/img/doitac/logobest2.png" style="height: 50px;" alt="" /> -->
                            <img src="<?=$logo_text_removegb?>" width="400"/> 
                        </div>
                    </div>
                </div>
                <div class="aui-item">
                    <div style="text-transform: uppercase; font-size: 24px; font-weight: bold;">Phiếu giao hàng</div>
                    <div>Ngày tạo đơn: 40-03-2021 15:21</div>
                </div>
            </div>
            <!-- END OF HEADER -->
            <!-- CART, PACKAGE_ORDER INFO -->
            <div class="aui-group" style="border: 1px solid #333; margin: 0; border-bottom: none;">
                <!--*********************************** BAR CODE ************************************-->
                <div class="aui-item barcode" style="border-right: 1px solid #333; padding: 5px; width: 45%; text-align: center;">
                        <div>
                            <img class="barcode_img" jsbarcode-value="84845645645" jsbarcode-format="auto" jsbarcode-width="2" jsbarcode-height="50"/>
                        </div>
                </div>
                <!--*********************************** END BAR CODE ************************************-->
                <div class="aui-item stations" style="border-right: 1px solid #333; padding: 5px 0; text-align: center;">
                    <table style="border-bottom: 1px solid;">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Lấy Hàng: </b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Xa Tan Trieu, Huyen Thanh Tri, Thanh Pho Ha Noi
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <b>Giao Hàng: </b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Phuong Van Phuc, Quan Ha Dong, Thanh Pho Ha Noij
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--*********************************** QR CODE ************************************-->
                <!-- <div class="aui-item qrcode" style="border-right: 0; padding: 0; width: 15%; text-align: center;">
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHQAAAB0AQMAAABuVIRkAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAlElEQVQ4jeXUsRHDMAwDQGyA/bfEBghJ+5w4HeHSLCy9Cp4E6Qy8vmwL0gyJ66uumSV2wTPE7pZPbD/wLOF2vo07SP3lu/HZ81YbmzBcW3JokyJrVZG718iILKI35Os+tharHw0i8pEnpdA+H9M3z511HKl2pcwThOtKclcYhnPXo/Lv/2DlXjpeVOTOs09DZX51fQCxMzS7Qw/CUgAAAABJRU5ErkJggg=="
                    />
                </div> -->
                <!--*********************************** END QR CODE ************************************-->
            </div>
            <!-- CART, PACKAGE_ORDER INFO -->
            <!-- ADDRESS -->
            <div class="aui-group pkg-address" style="border: 1px solid #333; margin: 0; border-bottom: none;">
                <div class="aui-item" style="border-right: 1px solid #333; width: 45%;">
                    <div style="padding: 10px 10px 10px 30px; font-size: 16px;">
                        <div style="font-weight: bold; padding: 0 0 10px 0; text-align: center; text-decoration: underline;">Shop/cửa hàng</div>
                        <div><b>Tên: ZYN SHOP</b></div>
                        <div><b>ĐT: </b>0387***2821</div>
                        <div><b>ĐC: 165 Trieu Khuc, Tan Trieu, Thanh Tri, Ha Noi</div>
                    </div>
                </div>
                <div class="aui-item" style="border-right: 0;">
                    <div style="padding: 10px; font-size: 16px;">
                        <div style="font-weight: bold; padding: 0 0 10px 0; text-align: center; text-decoration: underline;">Người nhận hàng:</div>
                        <div><b>Tên: </b><b>Duyen Do</b></div>
                        <div><b>ĐT: </b>036***040</div>
                        <div><b>ĐC: 165 Trieu Khuc, Tan Trieu, Thanh Tri, Ha Noi</div>
                    </div>
                </div>
            </div>
            <!-- ADDRESS -->
            <!-- CLIENT ID -->
            <div class="aui-group label-row" style="min-height: 80px;">
                <div class="aui-item" style="width: 35%; padding-left: 30px;">
                    <span class="label-h1">Mã đơn KH: SHOPZYN1213</span>
                    <div style="font-weight: bold; font-size: 25px">
                       
                    </div>
                </div>
                <div class="aui-item" style="padding: 5px; text-align: center;"></div>
            </div>
            <!-- CLIENT ID -->
            <!-- PRODUCT INFO -->
            <div class="aui-group label-row product-info" style="border-bottom: 1px solid #333;">
                <div class="aui-item" style="padding-left: 10px; font-weight: bold; width: 20%;">
                    <div class="pick-money" style="margin-top: 40px;">
                        <div style="font-size: 16px;">COD</div>
                        500,000 ₫
                    </div>
                    <div class="pick-money">
                        <div style="font-size: 16px;">Khối lượng</div>
                        1 KG
                    </div>
                </div>
                <div class="aui-item label-cell" style="width: 27%; padding: 0 10px;">
                    <div style="font-weight: bold; margin-top: 8px;">
                        Ghi chú hàng hóa
                    </div>
                    <div class="label-note">
                        giao nhanh gip shop
                    </div>
                </div>
                <div class="aui-item" style="width: 33%; padding-left: 0;">
                    <div class="aui-group aui-border-b aui-h">
                        <div class="aui-item aui-border-r pdl-0" style="width: 90%;">Sản phẩm</div>
                    </div>
                    <div class="aui-group aui-border-b">
                        <div class="aui-item aui-border-r" style="width: 90%; padding-left: 10px;">- Quan ao</div>
                    </div>
                </div>  
                <div class="aui-item label-row product-info" style="padding-left: 0;">
                    <div class="aui-group aui-border-b aui-h">
                        <div class="aui-item pdl-0" style="width: 90%;">Xác nhận hàng nguyên vẹn</div>
                    </div>
                </div>
            </div>
            <!-- PRODUCT INFO -->
        </div>
        <style>
            @media print and (orientation: landscape) {
                /* Your code for landscape orientation */
                @page {
                    margin: 0.5cm auto 0.7cm auto;
                }
            }
            body {
                margin: 0;
            }
            .sheet {
                margin: 5mm 0 10mm 5mm !important;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                display: block;
                height: auto;
                /* width: 850px; */
            }

            /*!** For screen preview **!*/
            @media screen {
                body {
                    background: #e0e0e0 !important;
                }
                .sheet {
                    background: white;
                    box-shadow: 0 0.5mm 2mm rgba(0, 0, 0, 0.3);
                    margin: 5mm auto;
                }
            }

            .label-row {
                border: 1px solid #333;
                border-bottom: none;
                margin: 0;
            }
            .label-cell {
                border-right: 1px solid #333;
            }
            .pick-money {
                margin: 10px 0;
                border: 1px solid #333;
                padding: 9px;
                font-size: 19pt;
                text-align: center;
            }
            .aui-border-b {
                margin: 0;
                border-bottom: 1px solid #333;
            }
            .pdl-0 {
                padding-left: 0 !important;
            }
            .aui-border-r {
                border-right: 1px solid #333;
            }
            .aui-h {
                text-align: center;
                font-weight: bold;
            }
            .label-h1 {
                font-weight: bold;
                font-size: 16px;
            }
            .product-info {
                min-height: 235px;
            }
            .pkg-address {
                min-height: 130px;
            }
            .label-note {
                font-size: 13pt;
                margin: 10px 0;
                border: 1px solid #333;
                padding: 9px;
                min-height: 40mm;
            }
            .system-note {
                display: none;
            }
            table.aui > tbody > tr,
            table.aui > tfoot > tr {
                border: none;
            }
            .barcode img {
                height: auto;
                width: auto;
            }
            table.product-list td,
            table.product-list th {
                font-size: 13px;
            }
            .stations table td {
                padding: 0;
            }
            @media print {
                /*@page {*/
                /*    margin: .5cm;*/
                /*}*/
                a[href]:after {
                    content: " (" attr(href) ")";
                }
                a:link:after,
                a:visited:after {
                    content: "";
                }
            }
        </style>
        <style type="text/css" media="print">
            a[href]:after {
                content: " (" attr(href) ")";
            }
        </style>
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
