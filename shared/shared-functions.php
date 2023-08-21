
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';

function logout(){
    // session_start(); // Make sure you start the session first
    
    // Clear session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect
    header('location: ../index.php');
    exit; 
}

function getUsername(){
    return $_SESSION['username'];
}
function getRole(){
    return $_SESSION['role'];
}
function insertResponse($role, $formData){
    $conn = connection();

    $formID = $formData['form_id'];
    $userID = $formData['user_id'];

    foreach ($formData['sections'] as $section) {
        $sectionID = $section['section_id'];

        foreach ($section['question'] as $question) {
            $questionType = $question['question_type'];
            $questionID = $question['question_id'];
            $response = $question['response'];

            $responseValue = '';

            switch ($questionType) {
                case 'choice':
                    $responseValue = $response['selected_' . $questionType];
                    break;
                case 'dropdown':
                    $responseValue = $response['selected_option'];
                    break;
                case 'date':
                case 'time':
                    $responseValue = $response[ $questionType . '_response'];
                    break;
                case 'paragraph':
                    $responseValue = $response['text_response'];
                    break;
                case 'scale':
                    $responseValue = json_encode($response['scale_responses']);
                    break;
                default:
                    // Handle unknown question types
            }

            $sql = "INSERT INTO form_response (form_id, user_id, section_id, question_id, response_value, response_type)
                    VALUES ('$formID', '$userID', '$sectionID', '$questionID', '$responseValue', '$questionType')";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
}

function createForm($role, $formData) {
    $conn = connection();
    $section_count = 0;
    $formID = 0;

    foreach ($formData['data'] as $item) {
        if ($item['type'] === 'form-title') {
            $formTitle = mysqli_real_escape_string($conn, $item['question']);
            $sql = "INSERT INTO form (`form_name`, `form_description`, `form_type`) 
            VALUES ('$formTitle', 'null', null)";
            
            if ($conn->query($sql)) {
                $formID = $conn->insert_id;
                
                 // Insert into form_permission with default values
                 $insertPermissionSql = "INSERT INTO form_permission (`user_id`, `role`, `form_id`, `can_access`, `can_modify`)
                 VALUES (0, 'superadmin', '$formID', 1, 1)";
                 
                 if (!$conn->query($insertPermissionSql)) {
                     echo "Error: " . $insertPermissionSql . "<br>" . $conn->error;
                 }

            }
        } else if ($item['type'] === 'section') {
            $section_count++;
            $sectionName = mysqli_real_escape_string($conn, $item['question']);
            $sql = "INSERT INTO form_section (`form_id`, `section_name`, `section_order`) VALUES
            ('$formID', '$sectionName', $section_count)";
            
            if ($conn->query($sql) === TRUE) {
                $sectionID = $conn->insert_id; // Retrieve the inserted section_id
            } else {
                echo "Error inserting section: " . $conn->error;
            }
        } else {
            $questionType = mysqli_real_escape_string($conn, $item['type']);
            $options = mysqli_real_escape_string($conn, $item['options']);
            $questionOrder = $item['order'];
            $pageID = 1;

            $sql = "INSERT INTO form_question (`section_id`, `question_type`, `options`, `question_order`, `page_id`, `form_id`)
            VALUES ('$sectionID', '$questionType', '$options', '$questionOrder', '$pageID', '$formID')";

            
            if (!$conn->query($sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
}




?>
