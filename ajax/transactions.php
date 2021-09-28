<?php
// use Commons as tool;
// require __DIR__ . '/../vendor/autoload.php';
include '../config.php';

// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

//check login
if(!is_object($dropship_er)) {
    echo json_encode(array('code' => 1, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}

// check ngan hang chon
$models_userbanks = new Models_DropshipBanks();
$models_users = new Models_Dropshipers();
$userbanks = $models_userbanks->getObject(intval($user_bank_id));
if(!is_object($userbanks)) {
    echo json_encode(array('code' => 1, 'msg' => 'Bạn chưa chọn ngân hàng!'));
    exit();
}
else {
    $models_banks = new Models_Banks();
    $banks = $models_banks->getObject($userbanks->bank_id);
}
$money = str_replace(',', '', $money);
$money = intval($money);
if($money < 100000) {
    echo json_encode(array('code' => 1, 'msg' => 'Số tiền giao dịch lớn >= 100,000đ'));
    exit();
}

// check so tien
$db = Models_Db::getDBO();
$db->beginTransaction();
$id = intval($dropship_id);
$adminuser = $models_users->getObject($id, 1);
// $current_balance = $adminuser->balance;
// $update_balance = $current_balance - $money;

// kiem tra so tien
$current_balance = $adminuser->balance;
if ($_function == "deposit") {
    $update_balance = $current_balance + $money;
}elseif ($_function == "withdraw") {
    $update_balance = $current_balance - $money;
}
if($update_balance < 0) {
    echo json_encode(array('code' => 1, 'msg' => 'Số tiền không đủ để giao dịch!'));
    $db->rollBack();
    exit();
}
$model_branch = new Models_BranchBanks();
$Commons_GetIp = new Commons_GetIp();
$Common_Random = new Commons_RandomCodeTran();
$models_histories = new Models_Histories();
$models_transactions = new Models_Transactions();

$transactions = new Persistents_Transactions();
$histories = new Persistents_Histories();
if (isset($otp_tran)) {
    if (empty($otp_tran)) {
        echo json_encode(array('code' => 1, 'msg' => 'Vui lòng nhập mã xác thực'));
        exit;
    }else {
        $secret = $adminuser->key_secret;
        $check_otp = Commons_Action::au_otp($secret,$otp_tran);
        if ($check_otp == false) {
            echo json_encode(array('code' => 1, 'msg' => 'Sai mã xác thực'));
            exit;
        }
    }
}
if ($_function == "withdraw") {
   
    // update tien vao tai khoan
    $adminuser->balance = $update_balance;
    $models_users->setPersistents($adminuser);
    if($models_users->edit(array('balance'), 1)) {
        // $commonRandom = new Commons_RandomCodeTran();
        $code = $Common_Random->tranid();
        // $info = $banks->name . ":" . $userbanks->acc_number . ":" . $userbanks->acc_name . ":" . $userbanks->acc_branch;
        
        $ip = $Commons_GetIp->get_client_ip();
        $time = time();
        $logs = "<span style='font-weight: bold;fon-size: 18px;color:#ed5565'>Rút tiền</span>:<br> 
        - Thao tác: <strong>$dropship_er->name(Người dùng)</strong><br>
        - Time: <strong>".date('d-m-Y H:i:s',$time)."</strong><br>
        - IP:<strong> $ip
        </strong><br><br>";
        $type = 1;
        $note_history = 'Dropship-ER: <strong>'.$adminuser->name.'</strong> tạo lệnh rút tiền. Số tiền: <strong>' .number_format($money).'đ</strong> Mã GD: <strong>'.$code.'</strong>';
        
        $transactions->tran_id = $code;
        $transactions->dropship_id = $adminuser->getId();
        $transactions->dropshipbank_id = $userbanks->getId();
        $transactions->money = $money;
        $transactions->time_created = $time;
        $transactions->type = $type;
        $transactions->status = 0;
        $transactions->logs = $logs;
        $models_transactions->setPersistents($transactions);
        $id_tran = $models_transactions->addV2(1);
        if($id_tran > 0) {
            
            $histories->dropship_id = $adminuser->getId();
            $histories->pk_id = $id_tran;
            $histories->cur_balance = $current_balance;
            $histories->last_balance = $update_balance;
            $histories->time = $time;
            $histories->note = $note_history;
            $histories->status = 1;
            $histories->type = $type;
            $models_histories->setPersistents($histories);
            if($models_histories->add()) {
                $db->commit();
                echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'Tạo lệnh thành công'));
                exit;
            }
            else {
                echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Lỗi thêm bản ghi lịch sử'));
                $db->rollBack();
                exit;
            }
        }
        else {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Lỗi thêm bản ghi giao dịch'));
            $db->rollBack();
            exit;
        }
    }
    else {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Hệ thống lỗi'));
        $db->rollBack();
        exit;
    }
}elseif ($_function == "deposit") {
    $code = $Common_Random->tranid();
    // $info = $banks->name . ":" . $userbanks->acc_number . ":" . $userbanks->acc_name . ":" . $userbanks->acc_branch;
    
    $ip = $Commons_GetIp->get_client_ip();
    $time = time();
    $logs = "<span style='font-weight: bold;fon-size: 18px;color:#ed5565'>Nạp tiền</span>:<br> 
    - Thao tác: <strong>$dropship_er->name(Người dùng)</strong><br>
    - Time: <strong>".date('d-m-Y H:i:s',$time)."</strong><br>
    - IP:<strong> $ip
    </strong><br><br>";
    $type = 0;
    $note_history = 'Dropship-ER: <strong>'.$adminuser->name.'</strong> tạo lệnh nạp tiền. Số tiền: <strong>' .number_format($money).'đ</strong> Mã GD: <strong>'.$code.'</strong>';
    
    $transactions->tran_id = $code;
    $transactions->dropship_id = $adminuser->getId();
    $transactions->dropshipbank_id = $userbanks->getId();
    $transactions->money = $money;
    $transactions->time_created = $time;
    $transactions->type = $type;
    $transactions->status = 0;
    $transactions->logs = $logs;
    $models_transactions->setPersistents($transactions);
    $id_tran = $models_transactions->addV2(1);
    if($id_tran > 0) {
        
        $histories->dropship_id = $adminuser->getId();
        $histories->pk_id = $id_tran;
        $histories->cur_balance = $current_balance;
        $histories->last_balance = $update_balance;
        $histories->time = $time;
        $histories->note = $note_history;
        $histories->status = 1;
        $histories->type = $type;
        $models_histories->setPersistents($histories);
        if($models_histories->add()) {
            $db->commit();
            echo json_encode(array('code' => 0, 'status' => true, 'msg' => 'Tạo lệnh thành công'));
            exit;
        }
        else {
            echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Lỗi thêm bản ghi lịch sử'));
            $db->rollBack();
            exit;
        }
    }
    else {
        echo json_encode(array('code' => 1, 'status' => false, 'msg' => 'Lỗi thêm bản ghi giao dịch'));
        $db->rollBack();
        exit;
    }
}


