<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';
function checkStatus($facultyID, $user_id){
    $conn = connection();

    $sql = "SELECT `evaluator_id`, `target_id` from evaluation where `target_id` = $facultyID and`evaluator_id` = $user_id";

    $result = $conn->query($sql);

    if($result->num_rows >0){
        return 'Submitted';
    }else{
        return 'Not Submitted';
    }
}
function getFaculty($user_id){
  $conn = connection();

  $sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].professor')) AS faculty_name,
   JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].course_code')) AS course_code,
   JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].faculty_id')) AS faculty_id FROM 
   student WHERE user_id = $user_id";

  $result = $conn->query($sql);

  if($result){
    
    while ($row = $result->fetch_assoc()) {
        
        $professorsArray = json_decode($row['faculty_name']); // Corrected variable name
        $courseCodesArray = json_decode($row['course_code']);
        $facultyID = json_decode($row['faculty_id']);
        
        for ($i = 0; $i < count($professorsArray); $i++) {
            
            echo '
            <div class="faculty-row row ms-2 my-3 ps-2" id='.$facultyID[$i].'>
                        <div class="col-10">
                            '.$professorsArray[$i].'
                        </div>
                        <div class="col-2">
                            '.checkStatus($facultyID[$i], $user_id).'
                        </div>
                    </div>
            ';
            
        }
    }
  }
}
?>

