<?php
if (isset($_POST['Delay'])){
$EquipmentType = $_POST['EquipmentType'];
$Equipment =  $_POST['Equipment'];
$BreakdownDesc =  $_POST['BreakdownDesc'];

$StartDate =  $_POST['StartDate'];
$StartTime =  $_POST['StartTime'];
$uid = $_SERVER['AUTH_USER'];

$sql = "INSERT INTO tDelaysActuals 
            (CalendarDateStart, EquipmentTypeId ,EquipmentId ,StartTime ,BreakdownHours ,Tons ,BreakdownDescription ,UserId)
            VALUES('$StartDate', '$EquipmentType', '$Equipment', '$StartTime', '0', '0','$BreakdownDesc','$uid');";

$sqlargs = array();
require_once 'config/db_query.php'; 
$Eq =  sqlQuery($sql,$sqlargs);

echo "<script> document.location.href='index.php' </script>";
die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mining Delays</title>

    <!-- Chrome/android APP settings -->
    <meta name="theme-color" content="#4287f5">
    <link rel="icon" href="img/icon.png" sizes="192x192">
    <!-- end of Chrome/Android App Settings  -->

    <!-- Bootstrap // you can use hosted CDN here-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <!-- end of bootstrap -->

</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Mining Delays
            </a>
        </nav>
        <!-- NAV END -->

        <!-- Main Content Start-->
        <?php
        
        //Equipment Type
        $sql = "SELECT EquipmentTypeId ,EquipmentType
                from [PDP].[dbo].[vDelaysAllLinks]
                WHERE OpType = 'TMM'
                group by EquipmentTypeId ,EquipmentType,OpType
                order by EquipmentType asc;";
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $Eqt =  sqlQuery($sql,$sqlargs);
        
        //SQL Equipment
        $sql = 'select EquipmentId ,EquipmentDescription ,EquipmentTypeId ,EquipmentType
                from [PDP].[dbo].[vDelaysAllLinks]
                group by EquipmentId ,EquipmentDescription ,EquipmentTypeId ,EquipmentType
                Order By EquipmentDescription ASC;';
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $Eq =  sqlQuery($sql,$sqlargs);

        echo "<script>
            let Equipment = [";
            echo json_encode($Eq[0]);
        echo    "];
            </script>";
?>

        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                New Delay
            </div>
            <div class="card-body">
                <form method="POST">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="StartDate">Start Date</label>
                            <input type="date" class="form-control" id="StartDate" name="StartDate" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="StartTime">Start Time</label>
                            <input type="time" class="form-control" id="StartTime" name="StartTime" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="EquipmentType">Equipment Type</label>
                            <select type="text" class="form-control" id="EquipmentType" name="EquipmentType"
                                onchange="filterEquipment(this)" required>
                                <option value="">Select Equipment Type </option>
                                <?php
                                foreach ($Eqt[0] as $EqtRec) {
                                    echo '<option value="'.$EqtRec['EquipmentTypeId'].'">'.$EqtRec['EquipmentType'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="Equipment">Equipment</label>
                            <select type="text" class="form-control" id="Equipment" name="Equipment" required>
                                <option value="">Select Equipment </option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="BreakdownDesc">Breakdown Description (Free Text)</label>
                        <input type="text" class="form-control" id="BreakdownDesc" name="BreakdownDesc"
                            placeholder="Type you comments here..." required>
                    </div>

                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Cancel</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success btn-lg form-control" name="Delay">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- form end -->
        <br><br>
        <!-- Main Content Start-->


    </div>
    <!-- Page End -->

    <!-- Start of Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- end of Bootstrap JS -->

    <!-- Page Specific JS -->
    <script>
    function filterEquipment(eqtId) {
        var select = document.getElementById("Equipment");
        var length = select.options.length;
        for (i = length - 1; i >= 0; i--) {
            select.options[i] = null;
        }
        var opt = document.createElement("option");
        opt.value = "";
        opt.text = "Select Equipment ";
        select.add(opt, null);

        Equipment[0].forEach(element => {
            if (element.EquipmentTypeId == eqtId.value) {
                opt = document.createElement("option");
                opt.value = element.EquipmentId;
                opt.text = element.EquipmentDescription;
                select.add(opt, null);
            };
        });
    }
    </script>
</body>

</html>