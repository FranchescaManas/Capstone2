
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
    $formID = 0;
    $sectionID = null; // Initialize with null to represent no section
    $section_count = 0;
    foreach ($formData['data'] as $item) {
        if ($item['type'] === 'form-title') {
            $formTitle = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';

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
            } else {
                echo "Error inserting form: " . $conn->error;
            }
        } else if ($item['type'] === 'section') {
            $sectionName = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $section_count++;
            
            $sql = "INSERT INTO form_section (`form_id`, `section_name`, `section_order`) VALUES
            ('$formID', '$sectionName', $section_count)";
            
            if ($conn->query($sql) === TRUE) {
                $sectionID = $conn->insert_id; // Retrieve the inserted section_id
            } else {
                echo "Error inserting section: " . $conn->error;
            }
        } else {
            $question = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $questionType = isset($item['type']) ? mysqli_real_escape_string($conn, $item['type']) : '';
            $options = isset($item['options']) ? json_encode($item['options']) : null;
            $questionOrder = isset($item['order']) ? $item['order'] : 0;
            $pageID = 1;

            $sql = "INSERT INTO form_question (`section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssiii", $sectionID, $question, $questionType, $options, $questionOrder, $formID, $pageID);

            if ($stmt->execute()) {
                // Query executed successfully
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }

    $conn->close();
}

function deleteForm($formID){
    $conn = connection();
    
    // Delete from form_question table
    $deleteFormPermission = "DELETE FROM form_permission WHERE form_id = '$formID'";
    if ($conn->query($deleteFormPermission) === FALSE) {
        echo "Error deleting from form_question: " . $conn->error;
    }
    // Delete from form_question table
    $deleteFormQuestions = "DELETE FROM form_question WHERE form_id = '$formID'";
    if ($conn->query($deleteFormQuestions) === FALSE) {
        echo "Error deleting from form_question: " . $conn->error;
    }
    // Delete from form_section table
    $deleteFormSections = "DELETE FROM form_section WHERE form_id = '$formID'";
    if ($conn->query($deleteFormSections) === FALSE) {
        echo "Error deleting from form_section: " . $conn->error;
    }


    // Delete from form table
    $deleteForm = "DELETE FROM form WHERE form_id = '$formID'";
    if ($conn->query($deleteForm) === FALSE) {
        echo "Error deleting from form: " . $conn->error;
    }

    $conn->close();

}


function loadForm($role, $formID)
{
    $conn = connection();


    $sql = "SELECT
        f.form_id,
        fq.question_id,
        fq.question_text,
        fq.question_type,
        fq.options,
        fq.question_order,
        fs.section_id,
        fs.section_name,
        fs.section_order,
        fp.page_id,
        fp.page_sequence
    FROM
        form f            LEFT JOIN
        form_question fq ON f.form_id = fq.form_id
    LEFT JOIN
        form_section fs ON fq.section_id = fs.section_id
    LEFT JOIN
        form_page fp ON fq.form_id = fp.form_id
    WHERE
        fq.form_id = $formID
    ORDER BY
        fp.page_sequence ASC,
        fs.section_order ASC,
        fq.question_order ASC;
    ";
    

    $result = $conn->query($sql);

    if ($result) {

        while ($row = $result->fetch_assoc()) {
            $questionID = $row['question_id'];
            $questionText = $row['question_text'];
            $questionType = $row['question_type'];

            echo generateFormFieldGroup($questionType, $questionID);
        }
        $result->free();
    } else {
        // Handle the query error
        echo "Error: " . ($conn)->error;
    }
}



function generateFormFieldGroup($selectedValue, $questionID) {
    $questionTypes = [
        ["value" => "textbox", "text" => "Textbox"],
        ["value" => "paragraph", "text" => "Short Paragraph"],
        ["value" => "date", "text" => "Date"],
        ["value" => "time", "text" => "Time"],
        ["value" => "choice", "text" => "Multiple Choice"],
        ["value" => "dropdown", "text" => "Dropdown"],
        ["value" => "scale", "text" => "Linear Scale"],
        ["value" => "page", "text" => "Page"],
        ["value" => "section", "text" => "Section"]
    ];

    $formGroupHtml = '<div class="field-group" id="' . $questionID++ . '">';
    $formGroupHtml .= '<section class="w-100">';
    $formGroupHtml .= '<input type="text" class="field-question rounded" placeholder="Question">';
    $formGroupHtml .= '<select name="field-option" class="field-option rounded">';
    foreach ($questionTypes as $type) {
        $selected = ($type['value'] === $selectedValue) ? 'selected' : '';
        $formGroupHtml .= '<option value="' . $type['value'] . '" ' . $selected . '>' . $type['text'] . '</option>';
    }
    $formGroupHtml .= '</select>';
    $formGroupHtml .= '</section>';
    if ($selectedValue === 'choice' || $selectedValue === 'dropdown') {
        // do something
    } else if ($selectedValue === 'date' || $selectedValue === 'time') {
        // do something
    } else if ($selectedValue === 'section' || $selectedValue === 'page' || $selectedValue === 'paragraph') {
        // do something
    } else if ($selectedValue === 'scale') {
        // do something
    } 
    $formGroupHtml .= '</div>';

    return $formGroupHtml;
}








?>


