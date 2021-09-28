<?php
include '../config.php';
ini_set('memory_limit', '256M');
// get post data
foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

//check login
if(!is_object($dropship_er)) {
    echo 'Bạn chưa đăng nhập!';
    exit();
}
$models_transactions = new Models_Transactions();
if($date_range != "") {
    list($start_date, $end_date) = explode(" - ", $date_range);
    $arr_start_date = explode("/", $start_date);
    $arr_end_date = explode("/", $end_date);
    $start_limit = mktime(0, 0, 0, $arr_start_date[1], $arr_start_date[0], $arr_start_date[2]);
    $end_limit = mktime(23, 59, 59, $arr_end_date[1], $arr_end_date[0], $arr_end_date[2]);    
}
else {
    $start_limit = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    $end_limit = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
}
$current_page = intval($current_page) == 0 ? 1 : intval($current_page);
$num_row_per_pages = $num_row;
$sql = "SELECT * FROM Transactions WHERE dropship_id = {$dropship_er->getId()} AND time_created BETWEEN {$start_limit} AND {$end_limit}";
if ($tran_id != "") {
    $sql .= " AND tran_id LIKE '%{$tran_id}%' ";
    $current_page = 1;
}
if ($status != "") {
    $sql .= " AND status = $status ";
    // $current_page = 1;
}
if ($type != "") {
    $sql .= " AND type = $type ";
    // $current_page = 1;
}
/********************************************************* */
$start_row = ($current_page - 1) * $num_row_per_pages;
$list_count = $models_transactions->customQuery($sql);
if ($num_row_per_pages != "") {
    
    $total_record = count($list_count);
    if($total_record % $num_row_per_pages == 0) {
        $total_page = $total_record/$num_row_per_pages;
    }
    else {
        $total_page = (int)($total_record/$num_row_per_pages + 1);
    }

    $sql .= " ORDER BY id DESC LIMIT $start_row, $num_row_per_pages";
    $lis_display = $models_transactions->customQuery($sql);
}else {
    $sql .= " ORDER BY id DESC";
    $lis_display = $models_transactions->customQuery($sql);
    $total_record = count($lis_display);
}
$stt;
$models_banks = new Models_Banks();
$model_branch = new Models_BranchBanks();
$models_dropbanks = new Models_DropshipBanks();

foreach ($lis_display as $key => $li) {
    $stt++;
    $obj_dropbank = $models_dropbanks->getObject($li->dropshipbank_id);
    $banks = $models_banks->getObject($obj_dropbank->bank_id);
    $branch_bank = $model_branch->getObject($obj_dropbank->branch_id);
?>
    <tr>
        <td ><?= $stt +($num_row_per_pages*($current_page-1))?></td>
        <td>
            <span style='font-weight: bold'>
                <?= $li->tran_id ?>
            </span>
        </td>
        <td>
            <?php 
                if ($li->type == 0) {
                    echo "<span style='font-weight: bold'>Lệnh CK: $li->tran_id $dropship_er->phone </span><a style='font-weight: bold' class='text-danger copy_ck' data-ck='$li->tran_id $dropship_er->phone'><i class='fa fa-files-o' aria-hidden='true'></i> Copy</a><br>";
                }
            ?>
            <span><?= $banks->name ?></span><br>
            <span><?= $branch_bank->name ?></span><br>
            <span><?= $obj_dropbank->acc_name ?></span><br>
            <span><?= $obj_dropbank->acc_number ?></span>
        </td>
        <td><span style='font-weight: bold' class="text-danger"><?= number_format($li->money)?>đ</span></td>
        <td>
            <?php if ($li->type == 0) {
                echo "<span class='label label-primary'>Nạp tiền</span>";
            }elseif ($li->type == 1) {
                echo "<span class='label label-danger'>Rút tiền</span>";
            }?>
        </td>  
        <td><?= date("d-m-Y H:i:s", $li->time_created)?></td>
        <td>
            <?php if ($li->status == 0) {
                echo "<span class='label label-warning'>Chờ duyệt</span>";
            }elseif ($li->status == 1) {
                echo "<span class='label label-success'>Thành công</span>";
            }?>
        </td>
    </tr>
<?php }?>
<tr style="font-weight: bold;font-size: 18px">
    <td colspan='2'>TỔNG</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="3">Đang ở <?= $current_page?>/<?= $total_page?> Trang. Tổng: <?= $total_record?> bản ghi</td>
    <td colspan='2'></td>
    <td colspan='2'>
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            <ul class="pagination">
                <?php
                    if($total_page > 1) {
                        if($current_page > 1) {
                            echo '<li class="paginate_button page-item previous" id="DataTables_Table_0_previous">
                                <a aria-controls="DataTables_Table_0" data-dt-idx="' . ($current_page - 1) . '" tabindex="0" class="page-link">Previous</a>
                            </li>';
                        }
                        
                        $step_begin = $current_page == 1 ? 2 : 1;
                        $step_end = $current_page == $total_page ? 2 : 1;
                        $begin = $current_page == 1 ? 1 : $current_page - $step_end == 0 ? 1 : $current_page - $step_end; 
                        $end = $current_page == $total_page ? $total_page : $current_page + $step_begin > $total_page ? $total_page : $current_page + $step_begin;
                        
                        echo $current_page - $step_end > 1 ? '<li class="paginate_button page-item">
                        <a aria-controls="DataTables_Table_0" tabindex="0">...</a>
                    </li>' : '';
                        for($i = $begin ; $i <= $end; $i ++) {
                            $active = $current_page == $i ? 'active' : '';
                            echo '<li class="paginate_button page-item ' . $active . '">
                                <a aria-controls="DataTables_Table_0" data-dt-idx="' . $i . '" tabindex="0" class="page-link">' . $i . '</a>
                            </li>';
                        }
                        echo $current_page + $step_begin < $total_page ? '<li class="paginate_button page-item">
                        <a aria-controls="DataTables_Table_0" tabindex="0">...</a>
                    </li>' : '';
                        
                        if ($current_page < $total_page) {
                            echo '<li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                <a aria-controls="DataTables_Table_0" data-dt-idx="' . ($current_page + 1) . '" tabindex="0" class="page-link">Next</a>
                            </li>';
                        }
                    }
                ?>
            </ul>
        </div>
        <input type="hidden" name="current_page" id="current_page" class="current_page" value="<?= $current_page ?>"/>
        <input type="hidden" name="" id="total-page" value="<?= $total_page ?>"/>
    </td>
</tr>