<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

if ($district != 0) {
    $model_com = new Models_Communes();
    $list_com = $model_com->customFilter('',array('dis_code' => $district));
    if (isset($_function) && $_function == "edit_form") {
        $id_element = "commune_edit";
    }else{
        $id_element = "commune";
    }
    ?>

    <select class="form-control select2_js" name="commune" id="<?= $id_element?>" style='width: 100%'>
        <option value="0">Phường/Xã...</option>
        <?php foreach ($list_com as $li) { ?>
        <option value="<?= $li->code ?>"><?= $li->name ?></option>  
        <?php } ?>                      
    </select>
<?php }elseif ($district == 0) { ?>
    <select class="form-control select2_js" name="commune" style='width: 100%'>
        <option value="0">Phường/Xã...</option>                    
    </select> 
<?php } ?>   