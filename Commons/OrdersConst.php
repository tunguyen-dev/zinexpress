<?php

class Commons_OrdersConst {

    const ARRAY_MENU_TAB_ORDER = array(
        'stt_total' => array ('name' => "Tất cả", 'status' => ""),
        'stt_create_new' => array ('name' => "Tạo mới", 'status' => "0"),//Tạo mới
        'stt_picking' => array ('name' => "Đang lấy", 'status' => "1"), //ĐANG LẤY HÀNG
        'stt_pickup_successed' => array ('name' => "Đã lấy", 'status' => "2"), //ĐÃ LẤY HÀNG
        'stt_enter_storage' => array ('name' => "Nhập kho", 'status' => "3"), //ĐÃ NHẬP KHO
        'stt_delivering' => array ('name' => "Đang giao", 'status' => "4"), //ĐANG GIAO HÀNG
        'stt_delivered' => array ('name' => "Đã giao", 'status' => "5"), //ĐÃ GIAO HÀNG
        'stt_delivered_forcontrol' => array ('name' => "Đã giao/ Đã đối soát", 'status' => "6"),//Đã giao/ Đã đối soát
        'stt_delivery_ailed' => array ('name' => "Giao thất bại", 'status' => "7"),//Giao hàng thất bại
        'stt_pickup_failed' => array ('name' => "Lấy thất bại", 'status' => "8"),//Lấy hàng thất bại
        'stt_waiting_for' => array ('name' => "Chờ chuyển hoàn", 'status' => "9"),//Chờ duyệt hoàn
        'stt_waited_for' => array ('name' => "Đã duyệt hoàn", 'status' => "10"),//Đã duyệt hoàn
        'stt_returning' => array ('name' => "Đang trả", 'status' => "11"),//Đang trả hàng
        'stt_returned' => array ('name' => "Đã trả", 'status' => "12"),//Đã trả hàng
        'stt_returned_forcontrol' => array ('name' => "Đã trả/ Đã đối soát", 'status' => "13"),//Đã trả hàng/ Đã đối soát
        'stt_cancel' => array ('name' => "Hủy", 'status' => "-1"),//HỦY


    );

}