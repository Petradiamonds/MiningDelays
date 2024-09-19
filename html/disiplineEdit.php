<!DOCTYPE html>
<html lang="en">

<?php
// Enable Discipline Type
if (isset($_GET['ENA'])) {
    $DisciplineId = $_GET['ENA'];

    $sql = "UPDATE tDelaysDiscipline SET
            [Active] = 1
            WHERE DisciplineId = '$DisciplineId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='disiplineEdit.php' </script>";
    die;
}
// Disable Discipline Type
if (isset($_GET['DEC'])) {
    $DisciplineId = $_GET['DEC'];

    $sql = "UPDATE tDelaysDiscipline SET
            [Active] = 0
            WHERE DisciplineId = '$DisciplineId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='disiplineEdit.php' </script>";
    die;
}

// New discipline
if (isset($_POST['disciplineType'])) {
    $disciplineType = $_POST['disciplineType'];
    $EquipmentType = "TMM";

    //GetNext discipline ID
    $sql = "SELECT 
                MAX(tDelaysDiscipline.DisciplineId) + 1 as DisciplineId
            From
                tDelaysDiscipline";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $DisciplineId =  sqlQuery($sql, $sqlargs);
    $DisciplineId = $DisciplineId[0][0]['DisciplineId'];

    //Add new discipline
    $sql = "INSERT INTO tDelaysDiscipline 
            (DisciplineId, DisciplineDescription, Active ,EquipmentType)
            VALUES(:DispId, :Comp, '1', :EquipmentType);";
    $sqlargs = array(
        'DispId' => $DisciplineId,
        'Comp' => $disciplineType,
        'EquipmentType' => $EquipmentType
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='disiplineEdit.php' </script>";
    die;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Discipline Update</title>

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
    //SQL get Discipline Type
    $sql = 'SELECT * From tDelaysDiscipline
             Order By disciplineDescription;';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Selectdiscipline =  sqlQuery($sql, $sqlargs);

    ?>
</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Discipline's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Add New Discipline
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="disciplineType">Discipline Name</label>
                            <input type="text" class="form-control" id="disciplineType" name="disciplineType" placeholder="Discipline Name" required>
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
                discipline Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Discipline name</label>
                        <?php
                        foreach ($Selectdiscipline[0] as $SelectdisciplineRec) {
                            if ($SelectdisciplineRec['Active'] == 1) {
                                // if enabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $SelectdisciplineRec['DisciplineId'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectdisciplineRec['DisciplineId'] . '" name="LinArt' .
                                    $SelectdisciplineRec['DisciplineId'] . '" placeholder="' .
                                    $SelectdisciplineRec['DisciplineDescription'] . '">
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $SelectdisciplineRec['DisciplineId'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectdisciplineRec['DisciplineId'] . '" name="LinArt' .
                                    $SelectdisciplineRec['DisciplineId'] . '" placeholder="' .
                                    $SelectdisciplineRec['DisciplineDescription'] . '">
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