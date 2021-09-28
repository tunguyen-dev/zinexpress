<?php


class Commons_UploadConst
{
    const UPLOAD_ORDER_BY_BATCH_HEADER = array("STT", "Mã đơn shop",
        "Tên người nhận (*)", "Số ĐT người nhận (*)", "Địa chỉ nhận (*)",
        "Tên hàng hóa (*)", "Trọng lượng (gram)  (*)",
        "Tiền thu hộ COD (VND)", "Dài (cm)", "Rộng (cm)",
        "Cao (cm)", "Ghi chú thêm"
    );
    const UPLOAD_ORDER_BY_BATCH_HEADER_VT_TEMP_VALUE = array(
        "A"=>array("name"=>"STT", "value"=>'value'),
        "B"=>array("name"=>"Mã đơn shop", "value"=>'value'),
        "C"=>array("name"=>"Tên người nhận (*)", "value"=>'value'),
        "D"=>array("name"=>"Số ĐT người nhận (*)", "value"=>'value'),
        "E"=>array("name"=>"Địa chỉ nhận (*)", "value"=>'value'),
        "F"=>array("name"=>"Tên hàng hóa (*)", "value"=>'value'),
        "G"=>array("name"=>"Trọng lượng (gram)  (*)", "value"=>'value'),
        "H"=>array("name"=>"Giá trị hàng (VND) (*)", "value"=>'value'),
        "I"=>array("name"=>"Tiền thu hộ COD (VND)", "value"=>'value'),
        "J"=>array("name"=>"Dài (cm)", "value"=>'value'),
        "K"=>array("name"=>"Rộng (cm)", "value"=>'value'),
        "L"=>array("name"=>"Cao (cm)", "value"=>'value'),
        "M"=>array("name"=>"Ghi chú thêm", "value"=>'value'),
    );

}