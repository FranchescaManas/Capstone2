<?php

require '../shared/connection.php';

// require 'FormClass.php';

function loadFormsGroup(){
    $conn = connection();

    $sql = "SELECT * FROM form";
    $result = $conn->query($sql);

  
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc())
        {
            echo '
                <div class="form-card" id="'.$row['form_id'].'">
                    <h4>'.$row['form_name'].'</h4>
                    <p>'.$row['form_description'].'</p>

                    <div class="d-flex justify-content-end">
                        <button class="red-btn small-btn rounded">View</button>
                    </div>
                </div>
            ';

        }
    } 
    else {
        echo "0 results";
    }
  
   $conn->close();

    



}





?>
