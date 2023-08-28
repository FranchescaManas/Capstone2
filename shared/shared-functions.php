<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';

function logout()
{
    // session_start(); // Make sure you start the session first

    // Clear session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect
    header('location: ../index.php');
    exit;
}

function getUsername()
{
    return $_SESSION['username'];
}
function getRole()
{
    return $_SESSION['role'];
}
function insertResponse($role, $formData)
{
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
                    $responseValue = $response[$questionType . '_response'];
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
function createForm($role, $formData)
{
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
                // Insert into form_permission with default values
                $insertPageSql = "INSERT INTO form_page (`form_id`,`page_sequence`)
                 VALUES ($formID, 1)";

                if ($conn->query($insertPageSql) === TRUE) {
                    $pageID = $conn->insert_id; // Retrieve the inserted section_id
                } else {
                    echo "Error inserting section: " . $conn->error;
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

function deleteForm($formID)
{
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


    // Delete from form page
    $deletePage = "DELETE FROM form_page WHERE form_id = '$formID'";
    if ($conn->query($deletePage) === FALSE) {
        echo "Error deleting from form: " . $conn->error;
    }
    // Delete from form table
    $deleteForm = "DELETE FROM form WHERE form_id = '$formID'";
    if ($conn->query($deleteForm) === FALSE) {
        echo "Error deleting from form: " . $conn->error;
    }

    $conn->close();

}
function getFormName($formID)
{
    $conn = connection();

    $sql = "SELECT form_name FROM form where form_id = $formID";

    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $formName = $row['form_name'];
    }


    return $formName;
}

function loadForm($role, $formID)
{
    $conn = connection();

    $sectionQuery = "SELECT
        fs.section_id,
        fs.section_name,
        fs.section_order
    FROM
        form_section fs
    WHERE
        fs.form_id = $formID
    ORDER BY
        fs.section_order ASC;
    ";

    $sql = "SELECT
        f.form_id,
        fq.question_id,
        fq.question_text,
        fq.question_type,
        fq.options,
        fq.question_order,
        fs.section_id,
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

    $selectedValue = [
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

    $sectionResult = $conn->query($sectionQuery);
    if ($sectionResult) {
        $currentSectionID = null; // Initialize the current section ID
        while ($sectionRow = $sectionResult->fetch_assoc()) {
            // Check if a new section is encountered
            if ($currentSectionID !== $sectionRow['section_id']) {
                if ($currentSectionID !== null) {
                    // Close the previous section if applicable
                    echo '</div>';
                }

                // Open the new section
                echo '<div class="field-group">';
                echo '<section class="w-100">';
                echo '<input type="text" class="field-question rounded field-section" value="' . $sectionRow['section_name'] . '"
                id="' . $sectionRow['section_id'] . '">';
                echo '<select name="field-option" class="field-option rounded">';
                foreach ($selectedValue as $type) {
                    $selected = ($type['value'] === 'section') ? 'selected' : 'section';
                    echo '<option value="' . $type['value'] . '" ' . $selected . '>' . $type['text'] . '</option>';
                }
                echo '</select>';
                echo '</section>';
                echo '</div>';

                // Update the current section ID
                $currentSectionID = $sectionRow['section_id'];
            }

            // Fetch and display questions within the same loop
            $questionResult = $conn->query($sql);
            if ($questionResult) {
                while ($questionRow = $questionResult->fetch_assoc()) {
                    
                    if ($questionRow['section_id'] == $currentSectionID) {
        
                        $formGroupHtml = '<div class="field-group" id="' . $questionRow['question_order'] . '">';
                        $formGroupHtml .= '<section class="w-100">';
                        $formGroupHtml .= '<input type="text" class="field-question rounded field-' . $questionRow['question_type'] . '" value="' . $questionRow['question_text'] . '" id="' . $questionRow['question_id'] . '">';
                        $formGroupHtml .= '<select name="field-option" class="field-option rounded">';
                        foreach ($selectedValue as $type) {
                            $selected = ($type['value'] === $questionRow['question_type']) ? 'selected' : '';
                            $formGroupHtml .= '<option value="' . $type['value'] . '" ' . $selected . '>' . $type['text'] . '</option>';
                        }
            
                        $formGroupHtml .= '</select>';
                        $formGroupHtml .= '</section>';
                        if (in_array($questionRow['question_type'], ['choice', 'dropdown', 'scale'])) {
                            $formGroupHtml .= "<section class='form-options w-100 my-1' id='form-options{$questionRow['question_id']}'>";
                            $dataArray = json_decode($questionRow['options'], true);
                            $optionCount = 0;
                            if ($questionRow['question_type'] === 'choice' || $questionRow['question_type'] === 'dropdown') {
                                $formGroupHtml .= '<div class="form-option-container" id="form-option-container{$questionID}">';
                                foreach ($dataArray as $key => $value) {
                                    $formGroupHtml .= '<input type="text" class="add-option-input w-75 mb-1" 
                        name="add_option_input' . $optionCount++ . '?>" 
                        value="' . $value . '">';
                                }
                                $formGroupHtml .= '</div><a href="javascript:void(0)" class="add-option">
                        <small> Add option or <u>import from excel</u></small>
                    </a>
                    ';
                            } else if ($questionType === 'scale') {
                                $formGroupHtml .= '<section class="form-options w-100 my-1" id="form-options' . $questionRow['question_id'] . '">';
            
                                // Scale range and labels
                                $formGroupHtml .= '<div class="d-flex w-100">';
                                $formGroupHtml .= '<aside class="scale-range d-flex flex-row me-5">';
                                $formGroupHtml .= '<select name="startselect" class="rounded" id="start_select">';
                                $formGroupHtml .= '<option value="1">1</option>';
                                $formGroupHtml .= '</select>';
                                $formGroupHtml .= '<p> to </p>';
                                $formGroupHtml .= '<select name="endselect" class="end_select">';
                                for ($i = 1; $i <= 5; $i++) {
                                    $formGroupHtml .= '<option value="' . $i . '">' . $i . '</option>';
                                }
                                $formGroupHtml .= '</select>';
                                $formGroupHtml .= '</aside>';
            
                                $formGroupHtml .= '<aside class="d-flex flex-column w-100 ml-3">';
                                $formGroupHtml .= '<p>Scale Labels:</p>';
                                $formGroupHtml .= '<div class="scale-options d-flex flex-column flex-wrap" id="' . $questionRow['question_id'] . '">';
            
                                // Display scale labels from JSON options
                                $scaleLabels = json_decode($questionRow['options'], true)['scale-labels'];
                                foreach ($scaleLabels as $label => $labelText) {
                                    $formGroupHtml .= '<input type="text" class="scale-input w-25 mb-2" 
                        name="' . $label . '" value="' . $labelText . '">';
                                }
            
                                $formGroupHtml .= '</div>';
                                $formGroupHtml .= '</aside>';
                                $formGroupHtml .= '</div>';
            
                                // Scale statements
                                $formGroupHtml .= '<div class="statements mt-5">';
                                foreach ($dataArray['scale-statement'] as $statement => $statementText) {
                                    $formGroupHtml .= '<input type="text" class="scale-statement w-75 mb-1" 
                        name="' . $statement . '" value="' . $statementText . '">';
                                }
                                $formGroupHtml .= '</div>';
            
                                // Add statement link
                                $formGroupHtml .= '<a href="javascript:void(0)" class="add-scale-statement">
                        <small> Add statement</small>
                    </a>';
            
                                $formGroupHtml .= '</section>';
                            }
                        }
                        $formGroupHtml .= '</div>';
            
                        echo $formGroupHtml;
            
                    }
                }
                $questionResult->free();
            } else {
                // Handle question query error
                echo "Error: " . $conn->error;
            }
        }

        // Close the last section if applicable
        if ($currentSectionID !== null) {
            echo '</div>';
        }

        $sectionResult->free();
    } else {
        // Handle section query error
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}



function updateForm($formData)
{
    $conn = connection();
    $sectionID = null; // Initialize with null to represent no section
    $section_count = 0;

    $formID = $formData['formid'];

    // Retrieve the maximum page_sequence for the form
    $maxPageSeqResult = $conn->query("SELECT MAX(page_sequence) as max_page_sequence FROM form_page WHERE form_id = $formID");
    $maxPageSeqRow = $maxPageSeqResult->fetch_assoc();
    $pageID = $maxPageSeqRow['max_page_sequence'] + 1;

    // print_r($formData);

    // print_r($formData);
    foreach ($formData['data'] as $item) {

        if ($item['type'] === 'form-title') {
            $formTitle = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';

            $sql = "UPDATE form SET `form_name` = '$formTitle' WHERE `form_id` = $formID";

            if (!$conn->query($sql)) {
                echo "Error updating form title: " . $conn->error;
            }
            // echo $sql;
        } else if ($item['type'] === 'section') {
            $sectionName = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $sectionID = isset($item['questionID']) ? $item['questionID'] : ''; // No need to escape integer
            $section_count++;

            // Check if the section already exists in the database
            $sectionExistsQuery = "SELECT section_id FROM form_section WHERE `section_id` = " . $sectionID;

            $sectionExistsResult = $conn->query($sectionExistsQuery);

            if ($sectionExistsResult->num_rows > 0) {
                // Section already exists, update its name
                $updateSectionSql = "UPDATE form_section SET section_name = '$sectionName' WHERE form_id = $formID AND section_id = " . $sectionID;
                if ($conn->query($updateSectionSql) === TRUE) {
                    // Section updated successfully
                } else {
                    echo "Error updating section: " . $conn->error;
                }

                // Retrieve the existing section_id
                $sectionIDRow = $sectionExistsResult->fetch_assoc();
                $sectionID = $sectionIDRow['section_id'];
            } else {
                // Section doesn't exist, insert a new section
                $section_count++;

                $insertSectionSql = "INSERT INTO form_section (`form_id`, `section_name`, `section_order`) VALUES
                ('$formID', '$sectionName', $section_count)";

                if ($conn->query($insertSectionSql) === TRUE) {
                    $sectionID = $conn->insert_id; // Retrieve the inserted section_id
                } else {
                    echo "Error inserting section: " . $conn->error;
                }
            }
        } else {
            $question = isset($item['question']) ? mysqli_real_escape_string($conn, $item['question']) : '';
            $questionType = isset($item['type']) ? mysqli_real_escape_string($conn, $item['type']) : '';
            $options = isset($item['options']) ? json_encode($item['options']) : null;
            $questionOrder = isset($item['order']) ? $item['order'] : 0;
            // $pageID = 1;


            $insertQuestionSql = "INSERT INTO form_question (`section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $updateQuestionSql = "UPDATE form_question 
            SET `question_text` = ?, `question_type` = ?, `options` = ?, `question_order` = ?, `form_id` = ?, `section_id` = ?, `page_id` = ?
            WHERE `question_id` = ?";


            // Check if the question exists in the database
            $questionExistsQuery = "SELECT question_id FROM form_question WHERE question_id = " . $item['questionID'];
            $questionExistsResult = $conn->query($questionExistsQuery);

            if ($questionExistsResult->num_rows > 0) {
                // echo $question;
                // Question already exists, update it
                $stmt = $conn->prepare($updateQuestionSql);
                $stmt->bind_param("sssiiiii", $question, $questionType, $options, $questionOrder, $formID, $sectionID, $pageID, $item['questionID']);
            } else {
                // echo "insert question";
                // Question doesn't exist, insert it
                $stmt = $conn->prepare($insertQuestionSql);
                $stmt->bind_param("isssiii", $sectionID, $question, $questionType, $options, $questionOrder, $formID, $pageID);
            }

            if ($stmt->execute()) {
                // echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        
    }

    $conn->close();
}

function getRoles(){
    $conn = connection();

        $sql = "SELECT DISTINCT `role` FROM users";

        $result = $conn->query($sql);

        $roles = array();
        
        if($result){
            while($row = $result->fetch_assoc()){
                $roles[] = $row['role'];
            }
            return $roles;
        }

    return $roles;
}

function getForms(){
    $conn = connection();

    $sql = "SELECT `form_id`, `form_name` FROM form";

    $result = $conn->query($sql);

    $forms = array();
    
    if($result){
        while($row = $result->fetch_assoc()){
            $forms[$row['form_id']] = $row['form_name'];
        }
        return $forms;
    }
}











?>