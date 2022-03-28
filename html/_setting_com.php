<?php
if (isset($_POST['Equipment'])){

}else{
//SQL Connect Equipment
$sql = 'select top 1000 [PDP].[dbo].[tDelaysComponent].* from [PDP].[dbo].[tDelaysComponent]';
$sqlargs = array();
require_once 'config/db_query.php'; 
$Com =  sqlQuery($sql,$sqlargs);
?>

<!-- form start-->
<div class="card">
    <div class="card-header bg-success">
        Component
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Component"> Component</label>
                <select type="text" class="form-control" id="Component" name="Component" required>
                    <option value="">Please Select</option>
                    <?php
                    foreach ($Com[0] as $ComRec) {
                       echo '<option value="'.$ComRec['ComponentId'].'">'.$ComRec['ComponentDescription'].'</option>';
                    }
                    ?>
                    <option value="#ADD">Add New Component</option>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- form end -->
<?php }?>