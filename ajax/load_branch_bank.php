<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

$model_branch = new Models_BranchBanks();
$list_branch = $model_branch->customFilter('',array('bank_id' => $bank_id));

 ?>
<select name="branch_id" id="branch_id" style="width:100%" class="form-control custom-select">
    <option value="0">Chọn chi nhánh...</option>
    <?php foreach ($list_branch as $li) { ?>
        <option value="<?= $li->getId() ?>"><?= $li->name ?></option>  
    <?php } ?>   
</select>