<?php

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Access form data
    $fieldOption = $_POST['field-option'];
    $fieldQuestion = $_POST['field-question'];
    
    // Display the form data
    echo "Field Option: " . $fieldOption . "<br>";
    echo "Field Question: " . $fieldQuestion;
}


?>
