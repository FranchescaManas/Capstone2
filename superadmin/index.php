<!-- 
    This page consists of 2 php files: student-navmenubar.php and by default - student-dashboard.php
    This right side of this page dynamicall changes depending on the option that the user picks.

    Notice that the url holds the value that current page is showing once option in sidemenu is clicked
    example:
    http://localhost/Capstone/student/index.php?page=dashboard

    NEXT:
    super-admin-navmenubar.php
    student-dashboard.php
    student-forms.php -> (THERE IS A CONDITION IN LOADING THIS PAGE: 
        this will only be displayed if there are more than one forms assigned to students
        see forms/form.php for the logic. Else, if there is only 1 form assigned to the user:
        it will redirect directly to form.php and generate the form contents).


    Previous:
    ../login.php

    INCLUSIONS:
    ./shared/shared-functions.php -> to access functions
    ./super-admin-modals.php -> holds the code for the pop up container for schedule form button and assign form 
    button
 -->


<?php
session_start();

include '../shared/shared-functions.php';
include '../shared/forms/FormClass.php';

// include_once '../shared/connection.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../shared/css/components.css">
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- Bootstrap css cdn -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <style>
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(223, 222, 222, 0.73); /* Gray color with 0.6 opacity */
            z-index: -1;
        }

     </style>
</head>
<body class='d-flex flex-row'>
    <aside>
        <?php include './superadmin-navmenubar.php';?>
    </aside>
    <?php 
    //to switch pages without reloading entire session
    $page = 'dashboard';

    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page !== 'forms'){
            include './superadmin-'.$page.'.php';
        }else{
            include '../shared/forms/form-view.php';
        }
    }
    
    ?>
    
    
    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</body>
</html>