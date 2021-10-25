<?php
// namespace Commons;
class Commons_ConvertStatusOrder{
	static function ConvertStatus($status) {
        $label_status = "";
        if ($status == -1) {
            $label_status = "<span class='label label-danger' style='background-color: black; color: #fff'>Đã hủy</span>";
        }elseif ($status == 0) {
            $label_status = "<span class='label label-secondary'>Tạo mới</span>";
        }elseif($status == 1){
            $label_status = "<span class='label label-secondary' style='background-color: #f8ac59; color: #fff'>Đang lấy hàng</span>";
        }elseif($status == 2){
            $label_status = "<span class='label label-secondary' style='background-color: rgb(81, 169, 245); color: #fff'>Đã lấy hàng</span>";
        }elseif($status == 3){
            $label_status = "<span class='label label-secondary' style='background-color: #1c84c6; color: #fff'>Đã nhập kho</span>";
        }elseif($status == 4){
            $label_status = "<span class='label label-secondary' style='background-color: rgb(2, 184, 177); color: #fff'>Đang vận chuyển</span>";
        }elseif($status == 5){
            $label_status = "<span class='label label-secondary' style='background-color: rgb(51, 110, 161); color: #fff'>Đang giao hàng</span>";
        }elseif($status == 6){
            $label_status = "<span class='label label-secondary'  style='background-color: rgb(92, 184, 92); color: #fff'>Giao thành công</span>";
        }elseif($status == 7){
            $label_status = "<span class='label label-danger'>Giao hàng thất bại</span>";
        }elseif($status == 8){
            $label_status = "<span class='label label-danger' style='background-color: #e83e8c; color: #fff'>Chuyển kho trả</span>";
        }elseif($status == 9){
            $label_status = "<span class='label label-secondary' style='background-color: #26a69a; color: #fff'>Đang trả hàng</span>";
        }elseif($status == 10){
            $label_status = "<span class='label label-secondary' style='background-color: #6610f2; color: #fff'>Đã trả</span>";
        }elseif($status == 11){
            $label_status = "<span class='label label-secondary'  style='background-color: #EE7C6B; color: #fff'>Lấy hàng thất bại</span>";
        }

        return $label_status;
    }
}