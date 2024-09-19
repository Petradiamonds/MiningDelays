<!DOCTYPE html>
<html lang="en">

<?php
// Enable Equipment Type
if (isset($_GET['ENA'])) {
    $ComponentId = $_GET['ENA'];

    $sql = "UPDATE tDelaysComponent SET
            [Active] = 1
            WHERE ComponentId = '$ComponentId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='componentEdit.php' </script>";
    die;
}
// Disable Equipment Type
if (isset($_GET['DEC'])) {
    $ComponentId = $_GET['DEC'];

    $sql = "UPDATE tDelaysComponent SET
            [Active] = 0
            WHERE ComponentId = '$ComponentId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='componentEdit.php' </script>";
    die;
}

// New component
if (isset($_POST['componentType'])) {
    $componentType = $_POST['componentType'];
    $OPType = "TMM";

    //GetNext Component ID
    $sql = "SELECT 
                MAX(tDelaysComponent.ComponentId) + 1 as ComponentId
            From
                tDelaysComponent";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $componentId =  sqlQuery($sql, $sqlargs);
    $componentId = $componentId[0][0]['ComponentId'];

    //Add new component
    $sql = "INSERT INTO tDelaysComponent 
            (ComponentId, ComponentDescription, Active ,OpType)
            VALUES(:CompID, :Comp, '1', :OP);";
    $sqlargs = array(
        'CompID' => $componentId,
        'Comp' => $componentType,
        'OP' => $OPType
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='componentEdit.php' </script>";
    die;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Component Update</title>

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
    $sql = 'SELECT * From tDelaysComponent
             Order By ComponentDescription;';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $SelectComponent =  sqlQuery($sql, $sqlargs);

    ?>
</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Component's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Add New Component
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="componentType">Component Name</label>
                            <input type="text" class="form-control" id="componentType" name="componentType" placeholder="Component Name" required>
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
                Component Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Equipment name</label>
                        <?php
                        foreach ($SelectComponent[0] as $SelectComponentRec) {
                            if ($SelectComponentRec['Active'] == 1) {
                                // if enabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $SelectComponentRec['ComponentId'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectComponentRec['ComponentId'] . '" name="LinArt' .
                                    $SelectComponentRec['ComponentId'] . '" placeholder="' .
                                    $SelectComponentRec['ComponentDescription'] . '">
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $SelectComponentRec['ComponentId'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectComponentRec['ComponentId'] . '" name="LinArt' .
                                    $SelectComponentRec['ComponentId'] . '" placeholder="' .
                                    $SelectComponentRec['ComponentDescription'] . '">
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