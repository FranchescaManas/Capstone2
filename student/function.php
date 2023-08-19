<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';

function getFaculty($user_id){
  $conn = connection();

  $sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].professor')) AS faculty_name,
   JSON_UNQUOTE(JSON_EXTRACT(data, '$.courses[*].course_code')) AS course_code FROM 
   student WHERE user_id = $user_id";

  $result = $conn->query($sql);

  if($result){
    
    while ($row = $result->fetch_assoc()) {
        
        $professorsArray = json_decode($row['faculty_name']); // Corrected variable name
        $courseCodesArray = json_decode($row['course_code']);
        
        // Iterate through the professors and their course codes
        for ($i = 0; $i < count($professorsArray); $i++) {
            // Display each faculty name
            // echo $professorsArray[$i] . '<br>';

            echo '
            <div class="row ms-2 my-3 ps-2">
                        <div class="col-10">
                            '.$professorsArray[$i].'
                        </div>
                        <div class="col-2">
                            Status
                        </div>
                    </div>
            ';
            
        }
    }
  }
}
?>

