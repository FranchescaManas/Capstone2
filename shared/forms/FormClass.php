
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';
class Form{
    private $formName;
    private $formData;

    private $conn;

    public $formCount = 0;


    function getFormName($formID){
        $this->conn = connection();

        $sql = "SELECT form_name FROM form where form_id = $formID";

        if ($result = $this->conn->query($sql)) {
            $row = $result->fetch_assoc();
            $this->formName = $row['form_name'];
        }
        

        return $this->formName;
    }


    function getFormID($userID, $userRole){
        $this->conn = connection();

        $sql = "SELECT * FROM form_permission WHERE `role` = '$userRole'";

        $result = ($this->conn)->query($sql);

        $formIDs = array();
        
        if($result){
            while($row = $result->fetch_assoc()){
                $formIDs[] = $row['form_id'];
            }
            return $formIDs;
        }
    }

    function checkAccess($formID, $role, $userID = null) {
        $this->conn = connection();
        
        if ($userID === null) {
            $sql = "SELECT * FROM form_permission WHERE `role` = '$role' AND `form_id` = $formID";
        } else {
            $sql = "SELECT * FROM form_permission WHERE `user_id` = '$userID' AND `form_id` = $formID";
        }
        
        $result = ($this->conn)->query($sql);
        
        if ($result) {
            $permission = $result->fetch_assoc();
        
            if ($permission['can_access'] == 1 && $permission['can_modify'] == 1) {
                return 'full access';
            } elseif ($permission['can_access'] == 1) {
                return 'can access';
            } elseif ($permission['can_modify'] == 1) {
                return 'can modify';
            } else {
                return 'no access permitted';
            }
        } else {
            return 'error accessing permission data';
        }
    }
    

    

    function loadFormData($formID)
    {
        $this->conn = connection();
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
    
    $result = ($this->conn)->query($sql);
    
    if ($result) {
        $currentSection = null;
        $statementCount = 1;

        while ($row = $result->fetch_assoc()) {
            $type = $row['question_type'];

            if ($row['section_id'] >= 1) {
                if ($row['section_id'] !== $currentSection) {
                    $this->section($row['section_id'], $row['section_name']);
                    $currentSection = $row['section_id'];
                    
                }
                if ($type === 'paragraph') {
                    $this->paragraphFieldInput($row['question_text'], $row['question_id']);
                } else if ($type == 'choice') {
                    $this->choiceFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'textbox') {
                    $this->textboxFieldInput($row['question_text'], $row['question_id']);
                } else if ($type == 'dropdown') {
                    $this->dropdownFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'date' || $type == 'time') {
                    $this->dateTimeFieldInput($type, $row['question_text'], $row['question_id']);
                }else if ($type === 'scale') {
                    $this->scaleFieldInput($row['question_text'], $row['options'], $row['question_id'], $statementCount);
                }
                

            } else {
                if ($type === 'paragraph') {
                    $this->paragraphFieldInput($row['question_text'], $row['question_id']);
                } else if ($type == 'choice') {
                    $this->choiceFieldInput($row['question_text'], $row['options'], $row['question_id']);
                }else if ($type == 'textbox') {
                    $this->textboxFieldInput($row['question_text'], $row['question_id']);
                } else if ($type == 'dropdown') {
                    $this->dropdownFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'date' || $type == 'time') {
                    $this->dateTimeFieldInput($type, $row['question_text'], $row['question_id']);
                }else if ($type === 'scale') {
                    $this->scaleFieldInput($row['question_text'], $row['options'], $row['question_id'], $statementCount);
                }
            }
        }
        $result->free();
    } else {
        // Handle the query error
        echo "Error: " . ($this->conn)->error;
    }
    
    
    }

    function loadFormsGroup($form_id){
        $this->conn = connection();
    
        $sql = "SELECT * FROM form WHERE `form_id` = '$form_id'";
        $result = ($this->conn)->query($sql);
    
      
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc())
            {
                echo '
                    <div class="form-card" id="'.$row['form_id'].'">
                        <div class="kebab-menu">
                            <img src="https://img.icons8.com/?size=512&id=84119&format=png" alt="Three Dots Icon" class="kebab-icon" width="25px">
                            <ul class="kebab-options">
                                <li>
                                <form action="../shared/forms/create-form.php" method="post">
                                <button type="submit" name="modify" style="background: none; color:black;" value="'.$row['form_id'].'">Edit Form</button></li>
                                </form>
                                <li><button type="button" name="delete" value="'.$row['form_id'].'">Delete Form</button></li>
                            </ul>
                        </div>
                        <h4>'.$row['form_name'].'</h4>
                        <p>'.$row['form_description'].'</p>
    
                        <div class="d-flex justify-content-end">
                            <form action="../shared/forms/form.php" method="post">
                                <button class="view-form red-btn small-btn rounded" name="viewForm" value="'.$form_id.'">View</button>
                            </form>
                        </div>
                    </div>
                ';
    
            }
        } 
        else {
            echo "0 results";
        }
      
        ($this->conn)->close();
    
    }


    function section($sectionID, $sectionName){
        echo '<section class="form-response-group section" id="' . $sectionID . '">
        <h5>' . $sectionName . '</h5></section>';
    }

    function paragraphFieldInput($formQuestion, $questionID){
        echo '
        <div class="form-response-group paragraph" id="'. $questionID.'" >
            <h6>'. $formQuestion. '</h6>
            <textarea name="field-response-paragraph-'. $questionID.'" class="response-paragraph w-100 mt-2" rows=8"></textarea>
        </div>
        ';
    }
    function textboxFieldInput($formQuestion, $questionID){
        echo '
        <div class="form-response-group paragraph" id="'. $questionID.'" >
            <h6>'. $formQuestion. '</h6>
            <input type="text" name="field-response-input-'. $questionID.'" class="w-25"></input>
        </div>
        ';
    }

    function choiceFieldInput($formQuestion, $formOptions, $questionID){
        $dataArray = json_decode($formOptions, true);
    
        $html = '<div class="form-response-group choice" id="'.$questionID.'">' .
                    '<h6>' . $formQuestion . '</h6>';
    
        foreach ($dataArray as $key => $value) {
            $html .= '<label>
            <input type="radio" class="me-2" name="field-response-choice' . $questionID . '" value="' . $value . '">' . $value
            .
                    '</label>';
        }
    
        $html .= '</div>';
    
        echo $html;
    }

    function dateTimeFieldInput($type, $formQuestion, $questionID){
        echo '
        <div class="form-response-group '. $type .'" id="'. $questionID.'">
            <h6>' . $formQuestion .'</h6>
            <input type="'.$type.'" name="field-reponse-'.$type.'-'.$questionID.'" class="w-25">
        </div>
        ';
    }

    function dropdownFieldInput($formQuestion, $formOptions, $questionID){
        $dataArray = json_decode($formOptions, true);
        $html = '
        <div class="form-response-group dropdown" id="'. $questionID.'">
            <h6>' . $formQuestion . '</h6>
            <select name="field-response-dropdown-'. $questionID.'" class="w-25">';
        foreach ($dataArray as $key => $value) {
            $html .= '<option value="'.$value.'">'.$value.'</option>';
        }
        $html .= '
            </select>
        </div>
        ';
        
        echo $html;
    }

    function scaleFieldInput($formQuestion, $formOptions, $questionID, $statementCount){
        $jsonData = $formOptions;
        $data = json_decode($jsonData, true);
    
        echo '<div class="form-response-group scale" id="'.$questionID.'">
            <div class="scale-container">
                <table class="scale-table">
                    <thead class="scale-thead">
                        <tr class="scale-tr">
                            <th class="scale-th scale-statement fw-normal">'.strtoupper($formQuestion).'</th>';
        foreach ($data['scale-labels'] as $label) {
            echo '<th class="scale-th text-center">' . $label . '</th>';
        }
        echo '</tr>
                </thead>
                <tbody class="scale-tbody">';
        foreach ($data['scale-statement'] as $statement) {
            echo '<tr class="scale-tr"> 
                <td class="scale-td scale-statement">' . $statement . '</td>';
            foreach ($data['scale-labels'] as $label) {
                echo '<td class="scale-td">
                        <input type="radio" name="field-response-scale-'.$statementCount.'" value="'.$label.'">
                    </td>';
            }
            echo '</tr>';
            $statementCount++;
        }
        echo '</tbody>
            </table>
        </div>
        </div>';
    }
    
    
    
    
}

    





?>