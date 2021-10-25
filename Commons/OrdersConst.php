<?php

class Commons_OrdersConst {

    const ARRAY_MENU_TAB_ORDER = array(
        'stt_total' => array ('name' => "Tất cả", 'status' => ""),
        'stt_create_new' => array ('name' => "Tạo mới", 'status' => "0", 'color' => "#dddde2"),//Tạo mới
        'stt_picking' => array ('name' => "Đang lấy", 'status' => "1", 'color' => "#f8ac59"), //ĐANG LẤY HÀNG
        'stt_pickup_successed' => array ('name' => "Đã lấy", 'status' => "2", 'color' => "rgb(81, 169, 245)"), //ĐÃ LẤY HÀNG
        'stt_enter_storage' => array ('name' => "Nhập kho", 'status' => "3", 'color' => "#1c84c6"), //ĐÃ NHẬP KHO
        'stt_waited_for' => array ('name' => "Đang vận chuyển", 'status' => "4", 'color' => "rgb(2, 184, 177)"),//ĐANG VẬN CHUYỂN
        'stt_delivering' => array ('name' => "Đang giao", 'status' => "5", 'color' => "rgb(51, 110, 161)"), //ĐANG GIAO HÀNG
        'stt_delivered' => array ('name' => "Đã giao", 'status' => "6", 'color' => "rgb(92, 184, 92)"), //ĐÃ GIAO HÀNG
        // 'stt_delivered_forcontrol' => array ('name' => "Đã giao/ Đã đối soát", 'status' => "6"),//Đã giao/ Đã đối soát
        // 'stt_returned_forcontrol' => array ('name' => "Đã đối soát", 'status' => "6"),//Đã trả hàng/ Đã đối soát
        'stt_delivery_ailed' => array ('name' => "Giao thất bại", 'status' => "7", 'color' => "#d9534f"),//Giao hàng thất bại
        'stt_returning' => array ('name' => "Chuyển kho trả", 'status' => "8", 'color' => "#e83e8c"),//Đang trả hàng
        'stt_returned' => array ('name' => "Đang trả", 'status' => "9", 'color' => "#26a69a"),//Đã trả hàng
        'stt_returned' => array ('name' => "Đã trả", 'status' => "10", 'color' => "#6610f2"),//Đã trả hàng
        'stt_pickup_failed' => array ('name' => "Lấy thất bại", 'status' => "11", 'color' => "#EE7C6B"),//Lấy hàng thất bại
        'stt_cancel' => array ('name' => "Hủy", 'status' => "-1", 'color' => "#333"),//HỦY


    );
    // const ARRAY_MENU_FORCONTROL = array(
    //     'stt_total_for' => array ('name' => "Tất cả", 'status' => ""),
    //     'stt_for_control' => array ('name' => "Chưa đối soát", 'status' => "0"),//Tạo mới
    //     'stt_un_for_control' => array ('name' => "Đã đối soát", 'status' => "1"), //ĐANG LẤY HÀNG


    // );
    const ARRAY_MENU_FEEDBACK_ORDER = array(
        'stt_total' => array ('name' => "Tất cả", 'status' => ""),
        'stt_processing' => array ('name' => "Chờ xử lý", 'status' => "0"),//CHỜ XỬ LÝ
        'stt_processed' => array ('name' => "Đã xử lý", 'status' => "1"), //ĐÃ XỬ LÝ
        'stt_refuse' => array ('name' => "Từ chối", 'status' => "-1"), //TỪ CHỐI
    );
    const ARRAY_MENU_FORCONTROL = array(
        'stt_total' => array ('name' => "Tất cả", 'status' => ""),
        'stt_paid' => array ('name' => "Đã trả tiền", 'status' => "0", 'color' => "rgb(92, 184, 92)"),//Tạo mới
        'stt_for_control' => array ('name' => "Đã đối soát", 'status' => "1", 'color' => "rgb(81, 169, 245)"), //ĐANG LẤY HÀNG
        'stt_un_for_control' => array ('name' => "Chưa đối soát", 'status' => "2", 'color' => "#d9534f"), //ĐÃ LẤY HÀNG


    );
}