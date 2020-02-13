<!-- form start-->
<div class="card">
    <div class="card-header bg-success">
        Equipment Type
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="BreakdownDesc"> Equipment Type</label>
                <input type="text" value="<?php echo $Eq[0][0]['BreakdownDescription'] ?>" class="form-control"
                    id="BreakdownDesc" name="BreakdownDesc" required>
            </div>
            <div class="form-group col-md-6">
                <label for="BreakdownDesc"> Equipment Type Description</label>
                <input type="text" value="<?php echo $Eq[0][0]['BreakdownDescription'] ?>" class="form-control"
                    id="BreakdownDesc" name="BreakdownDesc" required>
            </div>
        </div>
    </div>
</div>
<!-- form end -->