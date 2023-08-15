<<<<<<< HEAD
<?php
session_start();
?>

=======
>>>>>>> aa054d0125a322c50082cf8752dd5839cd8f281a
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Form</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/forms.css">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>    bootstrap cdn
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(202, 202, 202, 0.55);
            z-index: -1;
        }

     </style>
</head>
   
<body>
    <?php
    include '../navbar.php';
    // include './functions.php';
    include './FormClass.php';

    $form = new Form;
    
    ?>
    <header class="form-response-body">
        <h4 class="form-response-group text-center" id="form-response-name">
            <?php
            echo $form->getFormName(1);
            ?>
        </h4>
    </header>

    <div class="container text-center" id="login-container"
    style="padding-bottom: 30px"
    >

        <div class="d-flex justify-content-center mb-3">

            <h4>Evaluation Succesful</h4>
            
        </div>

        <img src="..\..\assets\images\check.png" alt="check" width="30px" height="30px" class="mx-2">


        <div>
            <form action="" method="post" class="d-flex flex-column text-start" id="login-form">

            <button type="submit" class="rounded-pill" name="btn_login" style=
            "
                font-weight: 500;
                background-color: var(--button-red);
                color: white;
                border: none;
                margin-top: 15px !important;
                padding: 5px 0 !important;
                width: 100%;
            ">Start Another</button>
             <button type="submit" class="rounded-pill" name="btn_login" style=
            "
                font-weight: 500;
                background-color: white;
                color:  black;
                border: none;
                margin-top: 0 !important;
                padding: 5px 0 !important;
                width: 100%;
            ">Return to Dashboard</button>

        </div>





</form>

    </div>   
   

    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>

</body>
</html>


=======
    <title>Document</title>
</head>
<body>
    <h2>form done</h2>
</body>
</html>
>>>>>>> aa054d0125a322c50082cf8752dd5839cd8f281a
