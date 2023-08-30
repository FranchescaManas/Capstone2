<?php
include '../shared-functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the AJAX request
    $formData = json_decode($_POST['data'], true);
    $actionData = json_decode($_POST['action'], true);

    $action = $actionData['action'];
    $role = $actionData['role'];

    if($role == 'student'){
        print_r($formData);
        // insertResponse($role, $formData);
        echo "success";
    }else if ($role === 'superadmin'){
        if($action === 'create form'){
            createForm($role, $formData);
        }else if($action === 'delete form'){
            deleteForm($formData);
        }else if($action === 'modify form'){
            updateForm($formData);
            // print_r($formData);
        }else if($action === 'update permission'){
            updatePermission($formData);
        }
        // TODO: put the success prompt in the ajax if query works
        echo "success";
    }

}

?>