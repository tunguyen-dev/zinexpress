<?php
require '../vendor/autoload.php';
class Commons_Action {
	function au_otp($secret,$otp) {
        $check = false;
        
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if ($g->checkCode($secret, $otp)) {
            $check = true;
        } else {
            $check = false;
        }
        return $check;
        
    }
    function request_notification_pusher() {

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher\Pusher(
            '248b9554562e32128c87',
            '8c2ed472895af1e189bd',
            '1025414',
            $options
        );
        $data['message'] = "Shop: ".$name.' vừa tạo gửi phàn hồi về đơn hàng: '.$obj_od->code;
        $data['title'] = "Yêu cầu phản hồi đơn hàng";
        $data['uid'] = $adminuser->getId();
        $data['post_code'] = $adminuser->post_code;
        $pusher->trigger('Adminsys', 'orders-created', $data);
    }
}