<?php
if (isset($_POST['Failure'])){

}else{
//SQL Connect Failure
$sql = 'select top 1000 [PDP].[dbo].[tDelaysFailure].* from [PDP].[dbo].[tDelaysFailure]';
$sqlargs = array();
require_once 'config/db_query.php'; 
$Fail =  sqlQuery($sql,$sqlargs);
?>

<!-- form start-->
<div class="card">
    <div class="card-header bg-success">
        Failure
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Failure"> Failure</label>
                <select type="text" class="form-control" id="Failure" name="Failure" required>
                    <option value="">Please Select</option>
                    <?php
                    foreach ($Fail[0] as $FailRec) {
                       echo '<option value="'.$FailRec['FailureId'].'">'.$FailRec['FailureDescription'].'</option>';
                    }
                    ?>
                    <option value="#ADD">Add New Failure</option>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- form end -->
<?php }?>