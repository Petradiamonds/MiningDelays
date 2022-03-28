<?php

$datestring = new DateTime();

if (isset($_POST['Delay'])){
$ID = $_POST['Delay'];
$EquipmentType = $_POST['EquipmentType'];
$Equipment =  $_POST['Equipment'];
$Component =  $_POST['Component'];
$Failure =  $_POST['Failure'];
$WorkPerformed =  $_POST['WorkPerformed'];
$ComponentDiscipline=  $_POST['ComponentDiscipline'];
$BreakdownDesc=  $_POST['BreakdownDesc'];
$DamageDetail=  $_POST['DamageDetail'];
$ArtisanAssigned=  $_POST['ArtisanAssigned'];
$REQNumber=  $_POST['REQNumber'];
$ProgressReport=  $_POST['ProgressReportOLD']."\r\n".$datestring->format('Y-m-d H:i:s').' - '.$_POST['ProgressReport'] ;
$StartDate =  $_POST['CalendarDateStart'];
$EndDate =  $_POST['EndDate'];

echo $EndDate;

$StartTime =  $_POST['StartTime'];
$EndTime =  $_POST['EndTime'];
$uid = $_SERVER['AUTH_USER'];

$StartDate = substr($StartDate,0,10);
$EndDate = substr($EndDate,0,10);

$sDay = strtotime("$StartDate $StartTime");
$eDay = strtotime("$EndDate $EndTime");

$diff = abs($sDay-$eDay);
$hr = ($diff / 60 / 60);
$min = explode(".",$hr);

$hr = $min[0];
$min = round(("0.$min[1]")*60);
$min = str_pad($min, 2, '0', STR_PAD_LEFT);
$br_hours = $hr.':'.$min;


$sql = "UPDATE tDelaysActuals SET
            CalendarDateStart = '$StartDate',
            EquipmentTypeId = '$EquipmentType',
            EquipmentId = '$Equipment',
            ComponentId = '$Component',
            DisciplineId = '$ComponentDiscipline',
            FailureId = '$Failure',
            DamageDetail = '$DamageDetail',  
            ArtisanAssigned = '$ArtisanAssigned', 
            REQNumber = '$REQNumber', 
            ProgressReport = '$ProgressReport',
            StartTime = '$StartTime',
            EndTime = '$EndTime',
            CalendarDateEnd = '$EndDate',
            BreakdownHours = '$br_hours',
            Tons = '0',
            WorkPerformed = '$WorkPerformed',
            BreakdownDescription = '$BreakdownDesc',
            UserId = '$uid'
        WHERE DelayId = $ID;
        ";

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
    <title>Plant Delays</title>

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
                Plant Delays
            </a>
        </nav>
        <!-- NAV END -->

        <!-- Main Content Start-->
        <?php
        //SQL Connect Equipment
        $sql = 'select [PDP].[dbo].[vDelays].* from [PDP].[dbo].[vDelays]
                WHERE DelayId = :ID;';
        $sqlargs = array('ID' => $_GET['DelayId']);
        require_once 'config/db_query.php'; 
        $Eq =  sqlQuery($sql,$sqlargs);

        //SQL Component
        $sql = 'select * from [PDP].[dbo].[vEquipTypeComp_Link]
                WHERE  active = -1 and EquipmentTypeID = :ID
                ORDER BY ComponentDescription ASC;';
        $sqlargs = array('ID' => $Eq[0][0]['EquipmentTypeID'] );
        require_once 'config/db_query.php'; 
        $Com =  sqlQuery($sql,$sqlargs);

        //SQL Discipline
        $sql = 'select tDelaysDiscipline.*, tDelaysComponentDisciplineLink.EquipmentTypeId,tDelaysComponentDisciplineLink.ComponentId  from [PDP].[dbo].[tDelaysDiscipline]
                Inner Join [PDP].[dbo].[tDelaysComponentDisciplineLink] on [tDelaysComponentDisciplineLink].DisciplineId =  [tDelaysDiscipline].DisciplineId
                WHERE  active = -1    and EquipmentTypeID = :ID;';
        $sqlargs = array('ID' => $Eq[0][0]['EquipmentTypeID'] );
        require_once 'config/db_query.php'; 
        $Des =  sqlQuery($sql,$sqlargs);
        echo "<script> let Discipline = [" . json_encode($Des[0]) . "];</script>";

        //SQL Failure
        $sql = 'select[tDelaysFailure].*,tDelaysDisciplineFailureLink.* from [PDP].[dbo].[tDelaysFailure]
        INNER JOIN [PDP].[dbo].[tDelaysDisciplineFailureLink] on [tDelaysDisciplineFailureLink].FailureId = [tDelaysFailure].FailureId
        WHERE  active = -1;';
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $Fail =  sqlQuery($sql,$sqlargs);
        echo "<script> let Failure = [" . json_encode($Fail[0]) . "];</script>";
        ?>

        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Selection Summary Delay
            </div>
            <div class="card-body bg-light">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="EquipmentType">Equipment Type</label>
                        <input type="text" value="<?php echo $Eq[0][0]['EquipmentType'] ?>" class="form-control"
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Equipment">Equipment</label>
                        <input type="text" value="<?php echo $Eq[0][0]['EquipmentDescription'] ?>" class="form-control"
                            id="Equipment" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="StartDate">Start Date</label>
                        <input type="date" class="form-control" id="StartDate"
                            value="<?php echo substr($Eq[0][0]['CalendarDateStart'],0,10); ?>" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="StartTime">Start Time</label>
                        <input type="time" class="form-control" id="StartTime" name="StartTime"
                            value="<?php echo ($Eq[0][0]['StartTime']) ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Summart -->

        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                Continuous Update of Delay
            </div>
            <div class="card-body">
                <form method="POST">

                    <input type="hidden" name="Delay" value="<?php echo  $Eq[0][0]['DelayId']; ?>">
                    <input type="hidden" name="EquipmentType" id="EquipmentType"
                        value="<?php echo  $Eq[0][0]['EquipmentTypeID']; ?>">
                    <input type="hidden" name="Equipment" value="<?php echo  $Eq[0][0]['EquipmentId']; ?>">
                    <input type="hidden" name="CalendarDateStart"
                        value="<?php echo  $Eq[0][0]['CalendarDateStart']; ?>">
                    <input type="hidden" name="StartTime" value="<?php echo  $Eq[0][0]['StartTime']; ?>">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="BreakdownDesc">Breakdown Description</label>
                            <input type="text" value="<?php echo $Eq[0][0]['BreakdownDescription'] ?>"
                                class="form-control" id="BreakdownDesc" name="BreakdownDesc" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="Component">Component</label>
                            <select type="text" class="form-control" id="Component" name="Component"
                                onchange="filterDiscipline(this)" required>
                                <?php 
                                if ($Eq[0][0]['ComponentId'] === ''){
                                    echo '<option value="">Select Component </option>';
                                }else{
                                    foreach ($Com[0] as $ComRec) {
                                        if ($ComRec['ComponentId'] === $Eq[0][0]['ComponentId']){
                                            echo '<option value="'.$ComRec['ComponentId'].'" selected>'.$ComRec['ComponentDescription'].'</option>';
                                        }else{
                                            echo '<option value="'.$ComRec['ComponentId'].'">'.$ComRec['ComponentDescription'].'</option>';
                                        }
                                        
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ComponentDiscipline">Discipline</label>
                            <select type="text" class="form-control" id="ComponentDiscipline" name="ComponentDiscipline"
                                onchange="filterFailure(this)" required>
                                <option value="">Select Discipline </option>
                                <?php echo '<script>let DisciplineOpt="'.$Eq[0][0]['DisciplineId'].'"</script>';?>
                            </select>
                            <script>
                                var select = document.getElementById("ComponentDiscipline");
                                var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                 for (const Obb of Discipline[0]){
                                     if (Obb.DisciplineId == DisciplineOpt){
                                        var DisciplineDescription = Obb.DisciplineDescription;
                                        var DisciplineId = Obb.DisciplineId;
                                     }
                                 }

                                 var opt = document.createElement("option");
                                 opt.value = DisciplineId;
                                 opt.text = DisciplineDescription;
                                 select.add(opt, null);
                            </script>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Failure">Failure</label>
                            <select type="text" class="form-control" id="Failure" Name="Failure" required>
                                <option value="">Select Failure </option>
                                <?php echo '<script>let FailureOpt="'.$Eq[0][0]['FailureId'].'"</script>';?>
                            </select>
                            <script>
                                var select = document.getElementById("Failure");
                                var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                 for (const Obb of Failure[0]){
                                     if (Obb.FailureId == FailureOpt){
                                        var FailureDescription = Obb.FailureDescription;
                                        var FailureId = Obb.FailureId;
                                     }
                                 }

                                 var opt = document.createElement("option");
                                 opt.value = FailureId;
                                 opt.text = FailureDescription;
                                 select.add(opt, null);
                            </script>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="DamageDetail">Damage Detail</label>
                            <input type="text" value="<?php echo $Eq[0][0]['DamageDetail'] ?>" class="form-control" name="DamageDetail"  placeholder="Damage details in full..">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ArtisanAssigned">Artisan assisgned</label>
                            <input type="text" value="<?php echo $Eq[0][0]['ArtisanAssigned'] ?>" class="form-control" name="ArtisanAssigned" placeholder="Artisan name">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="REQNumber">REQNumber</label>
                            <input type="text" value="<?php echo $Eq[0][0]['REQNumber'] ?>" class="form-control" name="REQNumber" placeholder="REQ number with delivery date">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="ProgressReport">Progress Update</label>
                            <input type="hidden" value="<?php echo $Eq[0][0]['ProgressReport'] ?>" name="ProgressReportOLD">
                            <input type="text" value="" class="form-control" id="ProgressReport" name="ProgressReport" placeholder="Add update here" required>
                            <hr>
                            <label for="ProgressReport">Progress Report</label>
                            <textarea class="form-control" cols="30" rows="10" readonly>
                            <?php echo $Eq[0][0]['ProgressReport'] ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Cancel</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success btn-lg form-control">Update</button>
                        </div>
                    </div>
                </form>
                </div>
        </div>
        <!-- form end -->
        <br><br>
        <!-- form start-->
        <div class="card">
            <div class="card-header bg-info">
                Close Delay
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="EndDate">End Date</label>
                            <input type="date" class="form-control" id="EndDate" name="EndDate" value="" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="EndTime">End Time</label>
                            <input type="time" class="form-control" id="EndTime" name="EndTime" value="" required>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="WorkPerformed">Work Performed</label>
                            <input type="text" class="form-control" id="WorkPerformed" name="WorkPerformed"
                                placeholder="Type you work performed here...">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Cancel</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success btn-lg form-control">Close</button>
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

    <!-- Page Level Scripts -->
    <script>
    //Discipline
    function filterDiscipline(ComID) {
        var select = document.getElementById("Failure");
        var length = select.options.length;
        for (i = length - 1; i >= 0; i--) {
            select.options[i] = null;
        }
        var opt = document.createElement("option");
        opt.value = "";
        opt.text = "Select Failure ";
        select.add(opt, null);

        var select = document.getElementById("ComponentDiscipline");
        var length = select.options.length;
        for (i = length - 1; i >= 0; i--) {
            select.options[i] = null;
        }
        var opt = document.createElement("option");
        opt.value = "";
        opt.text = "Select Discipline ";
        select.add(opt, null);

        EquipmentType = document.getElementById("EquipmentType");
        Discipline[0].forEach(element => {
            if (element.EquipmentTypeId == EquipmentType.value && element.ComponentId == ComID.value) {
                opt = document.createElement("option");
                opt.value = element.DisciplineId;
                opt.text = element.DisciplineDescription;
                select.add(opt, null);
            };
        });
    }

    function filterFailure(DisID) {
        var select = document.getElementById("Failure");
        var length = select.options.length;
        for (i = length - 1; i >= 0; i--) {
            select.options[i] = null;
        }
        var opt = document.createElement("option");
        opt.value = "";
        opt.text = "Select Failure ";
        select.add(opt, null);

        Failure[0].forEach(element => {
            if (element.DisciplineId == DisID.value) {
                opt = document.createElement("option");
                opt.value = element.FailureId;
                opt.text = element.FailureDescription;
                select.add(opt, null);
            };
        });
    }
    </script>
</body>

</html>