<?php 

include '../config.php';

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

$model_dis = new Models_Districts();
if ($city_code != 0) {
    $list_dis = $model_dis->customFilter('',array('citi_code' => $city_code));
    if (isset($_function) && $_function == "edit_form") {
        $id_element = "district_edit";
    }else{
        $id_element = "district";
    }
    ?>

    <select class="form-control select2_js" name="district" style='width: 100%' id="<?= $id_element?>">
        <option value="0">Quận/Huyện...</option>
        <?php foreach ($list_dis as $li) { ?>
            <option value="<?= $li->code ?>"><?= $li->name ?></option>  
        <?php } ?>                   
    </select>
<?php }elseif ($city_code == 0) { ?>
    <select  class="form-control select2_js" name="district" style='width: 100%'>
    <option value="0">Quận/Huyện...</option>               
</select>
<?php } ?>   
