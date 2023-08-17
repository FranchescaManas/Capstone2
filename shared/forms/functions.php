
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';


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


// have a different file for this
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the AJAX request
    $formData = json_decode($_POST['data'], true);
    $actionData = json_decode($_POST['action'], true);

    $action = $actionData['action'];
    $role = $actionData['role'];

    if($role == 'student'){
        insertResponse($role, $formData);
        echo "success";
    }


}



?>
