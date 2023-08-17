
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





?>
