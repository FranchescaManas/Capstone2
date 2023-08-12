<?php
require '../connection.php';
class Form{
    private $formName;
    private $formData;

    private $conn;

    public $formCount = 0;

    function getFormName(){
        return $this->formName;
    }
    function loadFormData()
    {
        $this->conn = connection();
    
        $sql = "SELECT
                f.form_id,
                f.form_name,
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
                form f
            LEFT JOIN
                form_question fq ON f.form_id = fq.form_id
            LEFT JOIN
                form_section fs ON fq.section_id = fs.section_id
            LEFT JOIN
                form_page fp ON fq.form_id = fp.form_id
            WHERE
                fq.form_id = 1
            ORDER BY
                fp.page_sequence ASC,
                fs.section_order ASC,
                fq.question_order ASC;
    ";
    
    $result = ($this->conn)->query($sql);
    
    if ($result) {
        $currentSection = null;

        while ($row = $result->fetch_assoc()) {
            $this->formName = $row['form_name'];
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
                } else if ($type == 'dropdown') {
                    $this->dropdownFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'date' || $type == 'time') {
                    $this->dateTimeFieldInput($type, $row['question_text'], $row['question_id']);
                }
                

            } else {
                if ($type === 'paragraph') {
                    $this->paragraphFieldInput($row['question_text'], $row['question_id']);
                } else if ($type == 'choice') {
                    $this->choiceFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'dropdown') {
                    $this->dropdownFieldInput($row['question_text'], $row['options'], $row['question_id']);
                } else if ($type == 'date' || $type == 'time') {
                    $this->dateTimeFieldInput($type, $row['question_text'], $row['question_id']);
                }
            }
        }
        $result->free();
    } else {
        // Handle the query error
        echo "Error: " . ($this->conn)->error;
    }
    
    
    }


    function section($sectionID, $sectionName){
        echo '<section class="form-response-group section" id="' . $sectionID . '">
        <h5>' . $sectionName . '</h5></section>';
    }

    function paragraphFieldInput($formQuestion, $questionID){
        echo '
        <div class="form-response-group paragraph" id="'. $questionID.'">
            <h6>'. $formQuestion. '</h6>
            <textarea name="field-response-paragraph-'. $questionID.'" class="response-paragraph w-100 mt-2" rows=8"></textarea>
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
        <div class="form-response-group" id="'. $questionID.'">
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
    

}
?>