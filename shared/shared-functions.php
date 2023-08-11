<?php

echo "flakdjf";

function logout(){
    // session_destroy();
    header('location: ../index.php');
}

function getUsername(){
    return $_SESSION['username'];
}
function getRole(){
    return $_SESSION['role'];
}

?>