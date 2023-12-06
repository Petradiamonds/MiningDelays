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
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- end of bootstrap -->

</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="pt-5 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Plant Delays Summary
            </a>
        </nav>
        <!-- NAV END -->

        <!-- Main Content Start-->
        <?php
        $SelectDate = date('Y-m-d');

        if (isset($_GET['SelectDate'])) {
            $SelectDate = $_GET['SelectDate'];
        }

        #SQL Connect
        $sql = "SELECT TOP (100) PERCENT dbo.tDelaysActuals.CalendarDateStart, dbo.tDelaysActuals.StartTime, dbo.tDelaysActuals.EquipmentTypeID, dbo.tDelaysActuals.EquipmentId, dbo.tDelaysActuals.BreakdownDescription, 
        dbo.tDelaysActuals.ComponentId, dbo.tDelaysActuals.DisciplineId, dbo.tDelaysActuals.FailureId, dbo.tDelaysActuals.TagId, dbo.tDelaysActuals.Tons, dbo.tDelaysActuals.BreakdownHours, dbo.tDelaysActuals.WorkPerformed, 
        dbo.tDelaysActuals.ArtisanAssigned, dbo.tDelaysActuals.ProgressReport, dbo.tDelaysActuals.DamageDetail, dbo.tDelaysActuals.REQNumber, dbo.tDelaysActuals.CalendarDateEnd, dbo.tDelaysActuals.EndTime, 
        dbo.tDelaysActuals.UserId, dbo.tDelaysActuals.DateStamp, dbo.tDelaysActuals.DelayId, dbo.tDelaysEquipmentType.EquipmentType, dbo.tDelaysEquipmentType.OPType, dbo.tDelaysEquipment.EquipmentDescription
        FROM dbo.tDelaysActuals INNER JOIN
        dbo.tDelaysEquipmentType ON dbo.tDelaysEquipmentType.EquipmentTypeId = dbo.tDelaysActuals.EquipmentTypeID INNER JOIN
        dbo.tDelaysEquipment ON dbo.tDelaysEquipment.EquipmentId = dbo.tDelaysActuals.EquipmentId AND dbo.tDelaysActuals.EquipmentTypeID = dbo.tDelaysEquipment.EquipmentTypeId
        WHERE (dbo.tDelaysActuals.EndTime IS NULL OR
        dbo.tDelaysActuals.EndTime = '') AND (dbo.tDelaysEquipmentType.OPType = 'TMM')
        ORDER BY dbo.tDelaysActuals.CalendarDateStart DESC;";
        $sqlargs = array();
        require_once 'config/db_query.php';
        $Delays =  sqlQuery($sql, $sqlargs);
        ?>


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Update Delay:
            </div>
            <div class="card-body bg-light">
                <!-- Filters -->
                <div>
                    <b>Toggle column:</b>
                    <a class="toggle-vis" data-column="1">Start</a> |
                    <a class="toggle-vis" data-column="2">EquipmentType</a> |
                    <a class="toggle-vis" data-column="3">Equipment</a> |
                    <a class="toggle-vis" data-column="4">Comment</a>
                </div>
                <!-- Table Start -->
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>Start</th>
                            <th>EquipmentType</th>
                            <th>Equipment</th>
                            <th>Desc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($Delays[0] as $Rec) {
                        ?>
                            <form action="edit.php" method="POST">
                                <tr>
                                    <td> <a class="btn btn-primary btn-block btn-xs" href="edit.php?DelayId=<?php echo $Rec['DelayId'] ?>"><?php echo $Rec['DelayId'] ?></a>
                                    </td>
                                    <td><?php echo substr($Rec['CalendarDateStart'], 0, 10) . ' ' . $Rec['StartTime']; ?>
                                    </td>
                                    <td><?php echo $Rec['EquipmentType']; ?></td>
                                    <td><?php echo $Rec['EquipmentDescription']; ?></td>
                                    <td><?php echo $Rec['BreakdownDescription']; ?></td>
                                </tr>
                            </form>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Start</th>
                            <th>EquipmentType</th>
                            <th>Equipment</th>
                            <th>Desc</th>
                        </tr>
                    </tfoot>
                </table>
                <!-- Table End -->
            </div>
        </div>
        <button class="btn btn-outline-primary btn-lg form-control" onclick="document.location.href='index.php'">Home</button><br><br>
        <button class="btn btn-outline-info btn-lg form-control" onclick="document.location.href='summaryAll.php'">See
            All
            Delays</button>
        <!-- Form Summary -->
        <br><br>
        <!-- Main Content Start-->

    </div>
    <!-- Page End -->

    <!-- Start of Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap4.min.js"></script>
    <!-- end of Bootstrap JS -->

    <!-- Page Level JS -->
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "scrollX": true,
                "order": [
                    [0, "desc"]
                ]
            });

            $('a.toggle-vis').on('click', function(e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());
            });
        });
    </script>

</body>

</html>