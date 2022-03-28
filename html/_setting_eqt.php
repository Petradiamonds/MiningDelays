<?php
if (isset($_POST['EquipmentType'])){

}else{
//SQL Connect Equipment
$sql = 'select * from [PDP].[dbo].[tDelaysEquipmentType]';
$sqlargs = array();
require_once 'config/db_query.php'; 
$Eqt =  sqlQuery($sql,$sqlargs);
?>

<!-- form start-->
<div class="card">
    <div class="card-header bg-success">
        Equipment Type
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="EquipmentType"> Equipment Type</label>
                <select type="text" class="form-control" id="EquipmentType" name="EquipmentType" required>
                    <option value="">Please Select</option>
                    <?php
                    foreach ($Eqt[0] as $EqtRec) {
                       echo '<option value="'.$EqtRec['EquipmentTypeId'].'">'.$EqtRec['EquipmentType'].'</option>';
                    }
                    ?>
                    <option value="#ADD">Add New Equipment Type</option>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- form end -->
<?php }?>