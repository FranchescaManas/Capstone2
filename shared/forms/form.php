<?php
session_start();

$userID = $_SESSION['user_id'];
$role= $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <main class='form-response-body'>
        <?php
        
        $formId = $form->getFormID($userID, $role);
        if(count($formId) === 1){
            $access = $form->checkAccess($formId[0], $role);
            echo $access;
            if($access === 'can access'){
                $form->loadFormData($formId[0]);
            }else if($access === 'can modify'){
                echo "user can modify";
            }else if($access === 'full access'){
                echo "user has full access";
            }else{
                echo "no permission to forms";
            }
        }else{
            
            header('location: ../../'.$role.'/index.php?page=forms');
            
        }
           
        ?>
         <button id="response-submit" class="rounded">Submit</button>


    </main>


   

    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>

</body>
</html>


