<!DOCTYPE html>
<html lang="en">

<?php
// Enable Equipment Type
if (isset($_GET['ENA'])) {
    $EquipmentTypeId = $_GET['ENA'];

    $sql = "UPDATE tDelaysEquipmentType SET
            [Enabled] = 1
            WHERE EquipmentTypeId = '$EquipmentTypeId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentTypeEdit.php' </script>";
    die;
}
// Disable Equipment Type
if (isset($_GET['DEC'])) {
    $EquipmentTypeId = $_GET['DEC'];

    $sql = "UPDATE tDelaysEquipmentType SET
            [Enabled] = 0
            WHERE EquipmentTypeId = '$EquipmentTypeId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentTypeEdit.php' </script>";
    die;
}

// New Equipment Type
if (isset($_POST['equipType'])) {
    $equipType = $_POST['equipType'];
    $OPType = "TMM";
    $Department = "Plant";
    $equipTypeId = "";

    //GetNext Equipment Type ID
    $sql = "SELECT 
                MAX(tDelaysEquipmentType.EquipmentTypeId) + 1 as EquipmentTypeId
            From
                tDelaysEquipmentType";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $equipTypeId =  sqlQuery($sql, $sqlargs);
    $equipTypeId = $equipTypeId[0][0]['EquipmentTypeId'];

    //Add new equipment type
    $sql = "INSERT INTO tDelaysEquipmentType 
            (OPType, EquipmentTypeId, EquipmentType ,Department, [Enabled])
            VALUES(:OP, :EqID, :Eq, :Dep, '1');";
    $sqlargs = array(
        ':OP' => $OPType,
        ':EqID' => $equipTypeId,
        ':Eq' => $equipType,
        ':Dep' => $Department
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentTypeEdit.php' </script>";
    die;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Equipment Type Update</title>

    <!-- Chrome/android APP settings -->
    <meta name="theme-color" content="#4287f5">
    <link rel="icon" href="img/icon.png" sizes="192x192">
    <!-- end of Chrome/Android App Settings  -->

    <!-- Bootstrap // you can use hosted CDN here-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <!-- end of bootstrap -->
    <?php
    //SQL get Equipment Type
    $sql = 'Select * From tDelaysEquipmentType;';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $SelectEquipment =  sqlQuery($sql, $sqlargs);

    ?>
</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Equipment Type's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Add New Equipment Type
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="equipType">Equipment Name</label>
                            <input type="text" class="form-control" id="equipType" name="equipType" placeholder="Equipment Name" required>
                        </div>
                        <button class="btn btn-outline-success btn-lg form-control">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Form Summart -->

        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                Equipment Type Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Equipment name</label>
                        <?php
                        foreach ($SelectEquipment[0] as $SelectEquipmentRec) {
                            if ($SelectEquipmentRec['Enabled'] == 1) {
                                // if enabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $SelectEquipmentRec['EquipmentTypeId'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectEquipmentRec['EquipmentTypeId'] . '" name="LinArt' .
                                    $SelectEquipmentRec['EquipmentTypeId'] . '" placeholder="' .
                                    $SelectEquipmentRec['EquipmentType'] . '">
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $SelectEquipmentRec['EquipmentTypeId'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectEquipmentRec['EquipmentTypeId'] . '" name="LinArt' .
                                    $SelectEquipmentRec['EquipmentTypeId'] . '" placeholder="' .
                                    $SelectEquipmentRec['EquipmentType'] . '">
                            </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- form end -->
            <br><br>
            <!-- Main Content Start-->

        </div>
        <!-- Page End -->
        <button class="btn btn-outline-danger btn-lg form-control mt-3" onclick="document.location.href='index.php'">Cancel</button>
        <br>
        <br>

        <!-- Start of Bootstrap JS -->
        <script src="js/jquery-3.3.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- end of Bootstrap JS -->

    </div>
    <!-- Page End -->
</body>

</html>