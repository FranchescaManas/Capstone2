<?php

session_start();

$userID = $_SESSION['user_id'];
$role = $_SESSION['role'];
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

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
    // include '../connection.php';
    include '../navbar.php';
    // include_once '../connection.php';
    include '../shared-functions.php';
    include './FormClass.php';

    // creating object to access methods from the FormClass.php
    $form = new Form;

    if (isset($_POST['viewForm'])) {
        $formId = $_POST['viewForm'];
        $formName = $form->getFormName($formId);
        ?>
        <header class="form-response-body">
            <h4 class="form-response-group text-center" id="form-response-name">
                <?php
                if (isset($formName)) {
                    echo $formName;
                }
                ?>
            </h4>
        </header>
        <main class='form-response-body'>
            <?php $form->loadFormData($formId); ?>
            <!-- <button id="modify-sub/mit" class="rounded">Save Changes</button> -->
        </main>
        <?php

    } else if (isset($_POST['evaluateForm'])) {
        $formId = $_POST['evaluateForm'];
        $formName = $form->getFormName($formId);
        ?>
            <header class="form-response-body">
                <h4 class="form-response-group text-center" id="form-response-name">
                    <?php
                    if (isset($formName)) {
                        echo $formName;
                    }
                    ?>
                </h4>
            </header>
            <main class='form-response-body'>
            <?php $form->loadFormData($formId); ?>
                <button id="response-submit" class="rounded">Submit</button>
            </main>
            <script>
            var formID = <?php echo json_encode($formId); ?>;
            var userID = <?php echo json_encode($userID); ?>;
            // console.log(formID);
            </script>
        <?php
    } else {
        // searches the forms accessible to the current role and id
        $formId = $form->getFormID($userID, $role);


        // counts how many forms the user has access to
        if ($role === 'superadmin') {
            header('location: ../../' . $role . '/index.php?page=forms');
        }
        if (count($formId) === 1) {
            // check the current access that the user has on the form
            $access = $form->checkAccess($formId[0], $role);
            // if user has access then load/generate the form
            if ($access === 'can access') {
                $formName = $form->getFormName($formId[0]);
                ?>
                    <header class="form-response-body">
                        <h4 class="form-response-group text-center" id="form-response-name">
                            <?php
                            if (isset($formName)) {
                                echo $formName;
                            }
                            ?>
                        </h4>
                    </header>
                    <main class='form-response-body'>
                    <?php $form->loadFormData($formId[0]); ?>
                        <button id="response-submit" class="rounded">Submit</button>
                    </main>
                    <script>
                    var formID = <?php echo json_encode($formId); ?>;
                    var userID = <?php echo json_encode($userID); ?>;
                    console.log(formID);
                    </script>
                <?php
                // if user has modification access, then display modify button
            } else if ($access === 'can modify') {
                header('location: ../../' . $role . '/index.php?page=forms');

            } else {
                // design no permission message
                echo "no permission to forms";
            }
            // if user has access to more than 1 forms then go the page where it will display the list of forms depending on their role
        } else {

            header('location: ../../' . $role . '/index.php?page=forms');
        }
    }



    ?>


    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>

</body>

</html>