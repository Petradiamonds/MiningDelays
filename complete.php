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
    <div class="container bg-white">

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
        //SQL Connect Equipment
        $sql = 'select * from [tDelaysEquipment]
                WHERE [Active] = -1 and EquipmentID = :Equipment 
                Order By EquipmentDescription ASC;';
        $sqlargs = array('Equipment' => $_GET['Equipment']);
        require_once 'config/db_query.php'; 
        $Eq =  sqlQuery($sql,$sqlargs);

        //Component
        $sql = 'select * from [tDelaysComponent]
                WHERE [Active] = -1 and ComponentID = :Component 
                Order By ComponentDescription ASC;';
        $sqlargs = array('Component' => $_GET['Component']);
        require_once 'config/db_query.php'; 
        $Co =  sqlQuery($sql,$sqlargs);

        //Failure
        $sql = 'select * from [tDelaysFailure]
                WHERE [Active] = -1 and FailureID = :Failure 
                Order By FailureDescription ASC;';
        $sqlargs = array('Failure' => $_GET['Failure']);
        require_once 'config/db_query.php'; 
        $Fa =  sqlQuery($sql,$sqlargs);

        //Discipline
        $sql = 'select * from [tDelaysDiscipline]
                WHERE [Active] = -1 and DisciplineID = :Discipline 
                Order By DisciplineDescription ASC;';
        $sqlargs = array('Discipline' => $_GET['Discipline']);
        require_once 'config/db_query.php'; 
        $Di =  sqlQuery($sql,$sqlargs);
        ?>


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Selection Summary Delay
            </div>
            <div class="card-body bg-light">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="Equipment">Equipment</label>
                        <input type="text" value="<?php echo $Eq[0][0]['EquipmentDescription'] ?>" class="form-control"
                            id="Equipment" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Component">Component</label>
                        <input type="text" value="<?php echo $Co[0][0]['ComponentDescription'] ?>" class="form-control"
                            id="Component" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Failure">Failure</label>
                        <input type="text" value="<?php echo $Fa[0][0]['FailureDescription'] ?>" class="form-control"
                            id="Failure" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ComponentDiscipline">Component Discipline</label>
                        <input type="text" value="<?php echo $Di[0][0]['DisciplineDescription'] ?>" class="form-control"
                            id="ComponentDiscipline" readonly>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Summart -->

        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                Save Delay
            </div>
            <div class="card-body">
                <form action="index.php" method="POST">


                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="StartDate">Start Date</label>
                            <input type="date" class="form-control" id="StartDate" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ShiftNr">Shift Nr</label>
                            <input type="number" class="form-control" id="ShiftNr" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="StartTime">Start Time</label>
                            <input type="time" class="form-control" id="StartTime" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="EndTime">End Time</label>
                            <input type="time" class="form-control" id="EndTime" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Free Text / Notes / Comments</label>
                        <input type="text" class="form-control" id="inputAddress"
                            placeholder="Type you comments here...">
                    </div>

                    <input type="hidden" name="EquipmentType" value="<?php echo $_GET['EquipmentType']; ?>">
                    <input type="hidden" name="Equipment" value="<?php echo $_GET['Equipment']; ?>">
                    <input type="hidden" name="Component" value="<?php echo $_GET['Component']; ?>">
                    <input type="hidden" name="Failure" value="<?php echo $_GET['Failure']; ?>">
                    <input type="hidden" name="Discipline" value="<?php echo $_GET['Discipline']; ?>">
                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Restart</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success btn-lg form-control">Save</button>
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