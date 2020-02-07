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
    <div class="container bg-white rounded">

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
        #SQL Connect
        $sql = 'select * from [tDelaysComponent]
                WHERE [Active] = -1 and EquipmentTypeID = :EquipmentType 
                Order By ComponentDescription ASC;';
        $sqlargs = array('EquipmentType' => $_GET['EquipmentType']);
        require_once 'config/db_query.php'; 
        $Eq =  sqlQuery($sql,$sqlargs);
        ?>

        <!-- BreadCrumb Start -->
        <div class="my-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item " aria-current="page">Equipment
                    </li>
                    <li class="breadcrumb-item  text-primary active font-weight-bold" aria-current="page">Component</li>
                    <li class="breadcrumb-item " aria-current="page">ComponentDiscipline</li>
                    <li class="breadcrumb-item " aria-current="page">Failure</li>
                </ol>
            </nav>
        </div>
        <!-- BreadCrumb End -->

        <!-- form start-->
        <div class="card">
            <div class="card-header">
                Component
            </div>
            <div class="card-body">
                <form action="Form3.php">

                    <?php
                    $i = 0;
                    foreach ($Eq[0] as $Opt) {
                    ?>

                    <!-- Radio1 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Component" value="<?php echo $Opt["ComponentId"]; ?>" required
                                    id="radio<?php echo $i; ?>">
                            </div>
                        </div>
                        <label class="input-group-text form-control"
                            for="radio<?php echo $i; ?>"><?php echo $Opt["ComponentDescription"] ?></label>
                    </div>

                    <?php
                    $i++;
                    }
                    ?>

                    <input type="hidden" name="EquipmentType" value="<?php echo $_GET['EquipmentType']; ?>">
                    <input type="hidden" name="Equipment" value="<?php echo $_GET['Equipment']; ?>">
                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Restart</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary btn-lg form-control">Next</button>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- end of Bootstrap JS -->

</body>

</html>