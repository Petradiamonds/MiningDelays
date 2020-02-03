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
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- end of bootstrap -->

</head>

<body class="bg-primary">
    <!-- Page Start -->
    <div class="container bg-white">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="index.php">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top bg-white rounded" alt="">
                Mining Delays Summary
            </a>
        </nav>
        <!-- NAV END -->

        <!-- Main Content Start-->
        <?php
        $SelectDate = date('Y-m-d');
        
        if(isset($_GET['SelectDate'])){
            $SelectDate = $_GET['SelectDate'];
        }

        #SQL Connect
        $sql = 'select tDelaysActuals.*,
                tDelaysComponent.ComponentDescription,
                tDelaysEquipmentType.EquipmentType,
                tDelaysEquipment.EquipmentDescription,
                tDelaysDiscipline.DisciplineDescription,
                tDelaysFailure.FailureDescription
                
                from [tDelaysActuals]
                inner join tDelaysComponent on tDelaysComponent.ComponentID = tDelaysActuals.ComponentID
                inner join tDelaysEquipmentType on tDelaysEquipmentType.EquipmentTypeID = tDelaysActuals.EquipmentTypeID
                inner join tDelaysEquipment on tDelaysEquipment.EquipmentID = tDelaysActuals.EquipmentID
                inner join tDelaysDiscipline on tDelaysDiscipline.DisciplineID = tDelaysActuals.DisciplineID
                inner join tDelaysFailure on tDelaysFailure.FailureID = tDelaysActuals.FailureID

                where CalendarDate =:SelectDate;';
        $sqlargs = array('SelectDate' => $SelectDate);
        require_once 'config/db_query.php'; 
        $Delays =  sqlQuery($sql,$sqlargs);
        ?>


        <!-- Form Summary -->
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                Change Date:
                <form>
                    <input class="form-control" type="date" name="SelectDate" value="<?php echo $SelectDate; ?>"
                        onchange="this.form.submit();">
                </form>
                <br>
                Delay Summary:
            </div>
            <div class="card-body bg-light">
                <!-- Filters -->
                <div>
                    <b>Toggle column:</b>
                    <a class="toggle-vis" data-column="1">Shift#</a> |
                    <a class="toggle-vis" data-column="2">EquipmentType</a> |
                    <a class="toggle-vis" data-column="3">Equipment</a> |
                    <a class="toggle-vis" data-column="4">Component</a> |
                    <a class="toggle-vis" data-column="5">Discipline</a> |
                    <a class="toggle-vis" data-column="6">Failure</a> |
                    <a class="toggle-vis" data-column="7">Start</a> |
                    <a class="toggle-vis" data-column="8">End</a> |
                    <a class="toggle-vis" data-column="9">Hours</a> |
                    <a class="toggle-vis" data-column="10">Comment</a>
                </div>
                <!-- Table Start -->
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>Shift#</th>
                            <th>EquipmentType</th>
                            <th>Equipment</th>
                            <th>Component</th>
                            <th>Discipline</th>
                            <th>Failure</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Hours</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $i = 0;
                    foreach ($Delays[0] as $Rec) {
                    ?>
                        <tr>
                            <td> <a
                                    href="edit.php?DelayId=<?php echo $Rec['DelayId'] ?>"><?php echo $Rec['DelayId'] ?></a>
                            </td>
                            <td><?php echo $Rec['ShiftNumber']; ?></td>
                            <td><?php echo $Rec['EquipmentType']; ?></td>
                            <td><?php echo $Rec['EquipmentDescription']; ?></td>
                            <td><?php echo $Rec['ComponentDescription']; ?></td>
                            <td><?php echo $Rec['DisciplineDescription']; ?></td>
                            <td><?php echo $Rec['FailureDescription']; ?></td>
                            <td><?php echo $Rec['StartTime']; ?></td>
                            <td><?php echo $Rec['EndTime']; ?></td>
                            <td><?php echo $Rec['BreakdownHours']; ?></td>
                            <td><?php echo $Rec['AdditionalReason']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Shift#</th>
                            <th>EquipmentType</th>
                            <th>Equipment</th>
                            <th>Component</th>
                            <th>Discipline</th>
                            <th>Failure</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Hours</th>
                            <th>Comment</th>
                        </tr>
                    </tfoot>
                </table>
                <!-- Table End -->
            </div>
        </div>
        <button class="btn btn-outline-primary btn-lg form-control"
            onclick="document.location.href='index.php'">Home</button>
        <!-- Form Summary -->
        <br><br>
        <!-- Main Content Start-->

    </div>
    <!-- Page End -->

    <!-- Start of Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap4.min.js"></script>
    <!-- end of Bootstrap JS -->

    <!-- Page Level JS -->
    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "scrollX": true
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