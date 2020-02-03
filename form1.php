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

        <!-- BreadCrumb Start -->
        <div class="my-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item  text-primary active font-weight-bold" aria-current="page">Equipment
                    </li>
                    <li class="breadcrumb-item " aria-current="page">Component</li>
                    <li class="breadcrumb-item " aria-current="page">Failure</li>
                    <li class="breadcrumb-item " aria-current="page">ComponentDiscipline</li>
                </ol>
            </nav>
        </div>
        <!-- BreadCrumb End -->

        <!-- form start-->
        <div class="card">
            <div class="card-header bg-success">
                Equipment
            </div>
            <div class="card-body">
                <form action="Form2.php">

                    <!-- Radio1 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio1">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio1">Option 1</label>
                    </div>

                    <!-- Radio2 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio2">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio2">Option 2</label>
                    </div>

                    <!-- Radio3 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio3">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio3">Option 3</label>
                    </div>

                    <!-- Radio4 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio4">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio4">Option 4</label>
                    </div>

                    <!-- Radio5 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio5">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio5">Option 5</label>
                    </div>

                    <!-- Radio6 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio6">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio6">Option 6</label>
                    </div>

                    <!-- Radio7 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio7">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio7">Option 7</label>
                    </div>

                    <!-- Radio8 -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="Equipment" required id="radio8">
                            </div>
                        </div>
                        <label class="input-group-text form-control" for="radio8">Option 8</label>
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