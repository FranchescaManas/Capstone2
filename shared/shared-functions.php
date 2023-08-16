<!-- 
    This file contains functions that can be used by all types of roles
 -->
<?php

function logout(){
    session_destroy();
    header('location: ../index.php');
}

function getUsername(){
    return $_SESSION['username'];
}
function getRole(){
    return $_SESSION['role'];
}

?>