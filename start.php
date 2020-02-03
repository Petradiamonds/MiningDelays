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
        $sql = 'select * from [tDelaysEquipmentType];';
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $EqType =  sqlQuery($sql,$sqlargs);
        ?>


        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                Delay Selection
            </div>
            <div class="card-body">
                <form action="Form1.php">

                    <div class="form-row-3">
                        <div class="form-group col-md-12">
                            <label for="EquipmentType">Equipment Type:</label>
                            <select name="EquipmentType" id="EquipmentType" class="form-control" required>
                                <option value="">Please Select</option>
                                <?php
                                foreach ($EqType[0] as $opt) {
                                    echo '<option value="'.$opt['EquipmentTypeId'].'">'.$opt['EquipmentType'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-6">
                            <button class="btn btn-outline-danger btn-lg form-control"
                                onclick="document.location.href='index.php'">Cancel</button>
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