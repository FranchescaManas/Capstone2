<?
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate</title>
    <link rel="stylesheet" href="/capstone/shared/css/components.css">
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="d-flex flex-column justify-content-center align-content-center ">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/navbar.php';
    ?>
    <!-- LOGIN FORM -->
    <div class="container text-center" id="login-container">

        <div class="d-flex justify-content-center mb-3">

            <h4>{{FORM TITLE}}</h4>

        </div>

        <form action="" method="post" class="d-flex flex-column text-start" id="login-form">
                <div class="row d-flex flex-row justify-content-center ">
                    <div class="d-flex flex-column w-25">
                        <label for="semeseter">Semester</label>
                        <input type="text" name="semester">
                    </div>
                    <div class="d-flex flex-column w-25">
                        <label for="school_year">School Year</label>
                        <input type="text" name="semester">
                    </div>
                </div>
                <h5>Faculty Information</h5>
                <div class="row">

                    <div class="col-6">
                        <label for="studentNo">Student No.:</label>
                        <input type="text" name="studentNo" id="studentNo" class="rounded">
                    </div>
                    <div class="col-6">
                        <label for="section">Section:</label>
                        <input type="text" name="section" id="section" class="rounded">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="professor">Professor:</label>
                        <select name="professor" id="professor" class="rounded">
                            <option value="test">test</option>
                            <option value="test">test</option>
                            <option value="test">test</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="classSchedule">Class Schedule:</label>
                        <input type="text" name="classSchedule" id="classSchedule" class="rounded">
                    </div>
                </div>
                
            <button type="submit" class="rounded-pill fw-bold" name="btn_login">Start Evaluation</button>
        </form>



    </div>



    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>