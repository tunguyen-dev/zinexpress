<?php
require_once '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}
//check login
if(!is_object($admins)) {
    echo json_encode(array('code' => 1, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}

        
$model_notifications = new Models_NotificationAdmins();
// $model_od = new Models_Orders();
if (!isset($_function)) {
    $list_notification = $model_notifications->customQuery("SELECT * FROM NotificationAdmins where 1 = 1 ORDER BY time_created DESC LIMIT 10");
    foreach ($list_notification as $key => $li) {
        // $_time = time() - $li->time_created;
        // $_day = floor($_time/86400);
        // $_hour =  floor($_time%86400/3600);
        // $_minus =  round($_time%3600/60);
        // if ($_day == 0 && $_hour != 0) {
        //     $time_display = $_hour." giờ trước";
        // }elseif ($_day == 0 && $_hour == 0 && $_minus != 0) {
        //     $time_display = $_minus." phút trước";
        // }elseif ($_minus == 0) {
        //     $time_display = "Vừa xong";
        // }else {
        //     $time_display = $_day ." ngày trước ";
        // }
        $time_search = date("d/m/Y", $li->time_created) ." - ". date("d/m/Y", $li->time_created);
    
        if ($li->function == "Transactions") {
            $url = $base_url."/".$li->link."?id=".$li->pk_id."&date=".$time_search;
        }
        
        $time_seen = date("d-m H:i",$li->time_seen);
        
        $arr_list[] = array('id' => $li->getId(),'link' => $url,'desc' => $li->description, 'time' => date("d-m-y H:i", $li->time_created), 'seen' => $li->seen);
    
        
    }
    $list_noseen = $model_notifications->customQuery("SELECT * FROM NotificationAdmins WHERE seen = 0");
    $total_noseen = count($list_noseen);
    
    echo json_encode(array('total_noseen' => $total_noseen, 'list_no' => $arr_list));  
}elseif ($_function = "load_more") {
    $html = '';
    $list_notification = $model_notifications->customQuery("SELECT * FROM NotificationAdmins where 1 = 1 ORDER BY time_created DESC LIMIT $start,10");
    foreach ($list_notification as $key => $li) {
        $_time = time() - $li->time_created;
        $_day = floor($_time/86400);
        $_hour =  floor($_time%86400/3600);
        $_minus =  round($_time%3600/60);
        if ($_day == 0 && $_hour != 0) {
            $time_display = $_hour." giờ trước";
        }elseif ($_day == 0 && $_hour == 0 && $_minus != 0) {
            $time_display = $_minus." phút trước";
        }elseif ($_minus == 0) {
            $time_display = "Vừa xong";
        }else {
            $time_display = $_day ." ngày trước ";
        }
        $time_search = date("d/m/Y", $li->time_created) ." - ". date("d/m/Y", $li->time_created);
    
        if ($li->function == "Transactions") {
            $url = $base_url."/".$li->link."?id=".$li->pk_id."&date=".$time_search;
        } 
        $time_seen = date("d-m H:i",$li->time_seen);
        if ($li->seen == 0) {
            $html .= "
                <li><a href='".$url."' data-id='".$li->getId()."' class='dropdown-item click_seen' style='color:#dc3545'><div> ".$li->description."<br><span class='text-muted small' style='font-size: 12px'>".date("d-m-y H:i", $li->time_created)."</span> </div></a></li>
                <li class='dropdown-divider'></li>
            ";
        }else{
            $html .= "
            <li><a href='".$url."' class='dropdown-item'><div> ".$li->description."<br><span class='text-muted small' style='font-size: 12px'>".date("d-m-y H:i", $li->time_created)."</span> <span class='text-muted float-right' style='font-size: 12px'><i class='fa fa-eye'> Đã đọc</i></span></div></a></li>
            <li class='dropdown-divider'></li>
        ";
        }
        
    }
    echo $html;
}

?>
