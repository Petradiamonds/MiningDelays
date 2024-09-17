<!DOCTYPE html>
<html lang="en">

<?php
// Enable Equipment Type
if (isset($_GET['ENA'])) {
    $EquipmentId = $_GET['ENA'];

    $sql = "UPDATE tDelaysEquipment SET
            [Active] = 1
            WHERE EquipmentId = '$EquipmentId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentEdit.php' </script>";
    die;
}
// Disable Equipment Type
if (isset($_GET['DEC'])) {
    $EquipmentId = $_GET['DEC'];

    $sql = "UPDATE tDelaysEquipment SET
            [Active] = 0
            WHERE EquipmentId = '$EquipmentId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentEdit.php' </script>";
    die;
}

// New Equipment
if (isset($_POST['equipment'])) {
    $equipmentDescription = $_POST['equipment'];
    $equipmentTypeID = $_POST['equipmentTypeId'];
    $ONKEYCode = $_POST['ONKEYCode'];

    //GetNext Equipment Type ID
    $sql = "SELECT 
                MAX(tDelaysEquipment.EquipmentId) + 1 as EquipmentId
            From
                tDelaysEquipment";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $EquipmentId =  sqlQuery($sql, $sqlargs);
    $EquipmentId = $EquipmentId[0][0]['EquipmentId'];

    //Add new equipment type
    $sql = "INSERT INTO tDelaysEquipment 
            (EquipmentTypeId, EquipmentId, EquipmentDescription ,Active, ONKEYCode)
            VALUES(:TypeId, :Id, :EquDesc, '1', :Code);";
    $sqlargs = array(
        ':TypeId' => $equipmentTypeID,
        ':Id' => $EquipmentId,
        ':EquDesc' => $equipmentDescription,
        ':Code' => $ONKEYCode
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='equipmentEdit.php' </script>";
    die;
}

//Get Equipment Types list
$sql = 'SELECT * From tDelaysEquipmentType
                    where [Enabled] = 1
                    order by EquipmentType;';
$sqlargs = array();
require_once 'config/db_query.php';
$SelectEquipmentType =  sqlQuery($sql, $sqlargs);
echo "<script> let EquipmentType = [" . json_encode($SelectEquipmentType[0]) . "];</script>";
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Equipment Update</title>

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
                Equipment's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Add New Equipment
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="equipType">Equipment Type</label>
                            <select name="equipmentTypeId" id="equipmentTypeId" class="form-control" required>
                                <option value="">Select Equipment Type</option>
                                <?php
                                foreach ($SelectEquipmentType[0] as $SelectEquipmentTypeRec) {
                                    echo '<option value="' . $SelectEquipmentTypeRec['EquipmentTypeId'] . '">' . $SelectEquipmentTypeRec['EquipmentType'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="EquipmentDescription">Equipment Name</label>
                            <input type="text" class="form-control" id="EquipmentDescription" name="equipment" placeholder="Equipment Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ONKEYCode">ONKEY Code</label>
                            <input type="text" class="form-control" id="ONKEYCode" name="ONKEYCode" placeholder="Please add ONKey Code" required>
                        </div>
                    </div>
                    <button class="btn btn-outline-success btn-lg form-control">Add</button>
                </form>
            </div>
        </div>
        <!-- Form Summart -->

        <!-- form start-->
        <div class="card">
            <?php
            //SQL get Equipment
            $filter = '';
            if (isset($_GET['filter'])) {
                $filter = $_GET['filter'];
            }

            $sql = 'SELECT  
                        tDelaysEquipmentType.EquipmentType,
                        tDelaysEquipment.* 
                    from [PDP].[dbo].[tDelaysEquipment]
                    left join  tDelaysEquipmentType on tDelaysEquipment.EquipmentTypeId = tDelaysEquipmentType.EquipmentTypeId
                    where tDelaysEquipmentType.EquipmentTypeId like :TypeId
                    order by tDelaysEquipmentType.EquipmentType,  tDelaysEquipment.EquipmentDescription;';
            $sqlargs = array(
                ':TypeId' => "%" . $filter
            );
            require_once 'config/db_query.php';
            $SelectEquipment =  sqlQuery($sql, $sqlargs);
            ?>
            <div class="card-header bg-success">
                Equipment Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Equipment name</label>
                        <div class="input-group mb-2 bg-success p-2 rounded">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Filter</div>
                            </div>
                            <select name="filter" id="filter" class="form-control" onchange="updateFilter()">
                                <?php
                                if (isset($_GET['filter'])) {
                                    echo '<option value=""></option>';
                                }
                                ?>
                                <option value="">All</option>
                                <?php
                                foreach ($SelectEquipmentType[0] as $SelectEquipmentTypeRec) {
                                    echo '<option value="' . $SelectEquipmentTypeRec['EquipmentTypeId'] . '">' . $SelectEquipmentTypeRec['EquipmentType'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <button class="btn btn-outline-info">&nbsp;&nbsp;&nbsp;</button>
                            <input type="text" style="font-weight: bold;" class="form-control" value="Type" readonly>
                            <input type="text" style="font-weight: bold;" class="form-control" value="Name" readonly>
                            <input type="text" style="font-weight: bold;" class="form-control" value="ONKey code:" readonly>
                        </div>
                        <?php
                        foreach ($SelectEquipment[0] as $SelectEquipmentRec) {
                            if ($SelectEquipmentRec['Active'] == 1) {
                                // if enabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $SelectEquipmentRec['EquipmentId'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control"' .
                                    'value="' .
                                    $SelectEquipmentRec['EquipmentType'] . '" readonly>
                                <input type="text" class="form-control"' .
                                    'value="' .
                                    $SelectEquipmentRec['EquipmentDescription'] . '" readonly>
                                <input type="text" class="form-control"' .
                                    'value="' . $SelectEquipmentRec['ONKEYCode'] . '" readonly>
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $SelectEquipmentRec['EquipmentId'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control"' .
                                    'value="' .
                                    $SelectEquipmentRec['EquipmentType'] . '" readonly>
                                <input type="text" class="form-control"' .
                                    'value="' .
                                    $SelectEquipmentRec['EquipmentDescription'] . '" readonly>
                                <input type="text" class="form-control"' .
                                    'value="' . $SelectEquipmentRec['ONKEYCode'] . '" readonly>
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

        <!-- Page Level Scripts -->

        <script>
            function updateFilter() {
                var filter = document.getElementById("filter").value;
                window.location.href = "?filter=" + filter;
            }
        </script>
        <!-- End of Page Level -->
    </div>
    <!-- end of page -->
</body>

</html>