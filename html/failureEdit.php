<!DOCTYPE html>
<html lang="en">

<?php
// Enable Failure Type
if (isset($_GET['ENA'])) {
    $FailureId = $_GET['ENA'];

    $sql = "UPDATE tDelaysFailure SET
            [Active] = 1
            WHERE FailureId = '$FailureId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='failureEdit.php' </script>";
    die;
}
// Disable Failure Type
if (isset($_GET['DEC'])) {
    $FailureId = $_GET['DEC'];

    $sql = "UPDATE tDelaysFailure SET
            [Active] = 0
            WHERE FailureId = '$FailureId';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='failureEdit.php' </script>";
    die;
}

// New Failure
if (isset($_POST['FailureType'])) {
    $FailureType = $_POST['FailureType'];

    //GetNext Failure ID
    $sql = "SELECT 
                MAX(tDelaysFailure.FailureId) + 1 as FailureId
            From
                tDelaysFailure";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $FailureId =  sqlQuery($sql, $sqlargs);
    $FailureId = $FailureId[0][0]['FailureId'];

    //Add new Failure
    $sql = "INSERT INTO tDelaysFailure 
            (FailureId, FailureDescription, Active)
            VALUES(:FailId, :FailDesc, '1');";
    $sqlargs = array(
        'FailId' => $FailureId,
        'FailDesc' => $FailureType
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='failureEdit.php' </script>";
    die;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Failure Update</title>

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
    //SQL get Failure Type
    $sql = 'SELECT * From tDelaysFailure
             Order By FailureDescription;';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $SelectFailure =  sqlQuery($sql, $sqlargs);

    ?>
</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Failure's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Add New Failure
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="FailureType">Failure Name</label>
                            <input type="text" class="form-control" id="FailureType" name="FailureType" placeholder="Failure Name" required>
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
                Failure Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Failure name</label>
                        <?php
                        foreach ($SelectFailure[0] as $SelectFailureRec) {
                            if ($SelectFailureRec['Active'] == 1) {
                                // if enabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $SelectFailureRec['FailureId'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectFailureRec['FailureId'] . '" name="LinArt' .
                                    $SelectFailureRec['FailureId'] . '" placeholder="' .
                                    $SelectFailureRec['FailureDescription'] . '">
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- EQP -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $SelectFailureRec['FailureId'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $SelectFailureRec['FailureId'] . '" name="LinArt' .
                                    $SelectFailureRec['FailureId'] . '" placeholder="' .
                                    $SelectFailureRec['FailureDescription'] . '">
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