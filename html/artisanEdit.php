<!DOCTYPE html>
<html lang="en">

<?php
// Enable Artisan
if (isset($_GET['ENA'])) {
    $CompanyNumber = $_GET['ENA'];

    $sql = "UPDATE tDelaysArtisanSelection SET
            [ActiveEmployee] = 1
            WHERE CompanyNumber = '$CompanyNumber';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='artisanEdit.php' </script>";
    die;
}
// Disable Artisan
if (isset($_GET['DEC'])) {
    $CompanyNumber = $_GET['DEC'];

    $sql = "UPDATE tDelaysArtisanSelection SET
            [ActiveEmployee] = 0
            WHERE CompanyNumber = '$CompanyNumber';";
    $sqlargs = array();
    require_once 'config/db_query.php';
    $Eq =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='artisanEdit.php' </script>";
    die;
}

// New Artisan
if (isset($_POST['VipArtisan'])) {
    $CompanyNumber = $_POST['VipArtisan'];

    //SQL Connect VIP Artisan by CompanyNumber
    $sql = "SELECT [PDP].[dbo].[vHREmployees].* from [PDP].[dbo].[vHREmployees]
            Where EmployeeCode = :CompID";
    $sqlargs = array('CompID' => $CompanyNumber);
    require_once 'config/db_query.php';
    $VipEmp =  sqlQuery($sql, $sqlargs);

    //Add new Artisan
    $sql = "INSERT INTO tDelaysArtisanSelection 
            (CompanyNumber, Displayname ,ActiveEmployee)
            VALUES(:Comp, :Disp, '1');";
    $sqlargs = array(
        'Disp' => $VipEmp[0][0]['DisplayName'],
        'Comp' => $VipEmp[0][0]['EmployeeCode']
    );
    require_once 'config/db_query.php';
    $Art =  sqlQuery($sql, $sqlargs);

    echo "<script> document.location.href='artisanEdit.php' </script>";
    die;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artisan Update</title>

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
    //SQL Connect VIP Artisan
    $sql = 'SELECT [PDP].[dbo].[vHREmployees].* from [PDP].[dbo].[vHREmployees]
            order by [DisplayName] ASC';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $VipEmp =  sqlQuery($sql, $sqlargs);

    //SQL Connect Delay Artisan
    $sql = 'select [PDP].[dbo].[tDelaysArtisanSelection].* from [PDP].[dbo].[tDelaysArtisanSelection]
        order by [DisplayName] ASC';
    $sqlargs = array();
    require_once 'config/db_query.php';
    $DelEmp =  sqlQuery($sql, $sqlargs);

    ?>
</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Artisan's
            </a>
        </nav>
        <!-- NAV END -->


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Artisan Selection From Payroll
            </div>
            <div class="card-body bg-light">
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="VipArtisan">Artisan Name</label>
                            <select type="text" class="form-control" id="VipArtisan" name="VipArtisan" required>
                                <option value="">Please Select</option>
                                <?php
                                foreach ($VipEmp[0] as $VipEmpRec) {
                                    echo '<option value="' . $VipEmpRec['EmployeeCode'] . '">' . $VipEmpRec['DisplayName'] . '</option>';
                                }
                                ?>
                            </select>
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
                Artisan Selection For TMM Delays
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="LinArt1">Linked Artisan name</label>
                        <?php
                        foreach ($DelEmp[0] as $DelEmpRec) {

                            if ($DelEmpRec['ActiveEmployee'] == 1) {
                                // if enabled
                                echo '<!-- ART -->
                                <div class="input-group mb-2">
                                <a href="?DEC=' . $DelEmpRec['CompanyNumber'] . '">
                                    <div class="input-group-primary">
                                        <div class="input-group-text bg-info">✓</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $DelEmpRec['CompanyNumber'] . '" name="LinArt' .
                                    $DelEmpRec['CompanyNumber'] . '" placeholder="' .
                                    $DelEmpRec['Displayname'] . '">
                            </div>';
                            } else {
                                // if disabled
                                echo '<!-- ART -->
                                <div class="input-group mb-2">
                                <a href="?ENA=' . $DelEmpRec['CompanyNumber'] . '">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-secondary">X</div>
                                    </div>
                                </a>
                                <input type="text" class="form-control" id="LinArt' .
                                    $DelEmpRec['CompanyNumber'] . '" name="LinArt' .
                                    $DelEmpRec['CompanyNumber'] . '" placeholder="' .
                                    $DelEmpRec['Displayname'] . '">
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
            //Discipline
            function filterDiscipline(ComID) {
                console.log("disp filter");
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
                console.log("filterFailure filter");
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