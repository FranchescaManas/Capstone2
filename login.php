<!-- 
    When the login button is clicked, it executes the login function by providing the needed arguments/parameters.
    the login function also sets the session variables so that the users username, userID, role, and name
    is made accessible to other files its connected to as long as session_start() is present before the html tag.

    NEXT:
    superadmin/index.php
    admin/index.php     
    faculty/index.php   
    student/index.php

    PREVIOUS:
    index.php

    INCLUSIONS:
    ./shared/connection.php -> to connect to the database

    All index files depending on user is that first thing that will load. It includes the {{role}}-navmenu.php
    Thus, the ui won't work properly if the index.php is not loaded first as its a combination of 2 php files.

 -->

<?php
session_start();
require './shared/connection.php';


function login($username, $password){
    $conn = connection();

    $sql = "SELECT * FROM users WHERE  username = '$username'";
    
    if($result = $conn->query($sql)){
        if($result->num_rows == 1){
            $user_row = $result-> fetch_assoc();
            
            if(password_verify($password, $user_row['password'])){
                
                print_r($user_row);

                // SESSION VARIABLES

                $_SESSION['user_id'] = $user_row['user_id'];
                $_SESSION['username'] = $user_row['username'];
                $_SESSION['full_name'] = $user_row['firstname'] . " " . $user_row['lastname'];
                $_SESSION['role'] = $user_row['role'];

                // page redirection depending on user's role

               if($_SESSION['role'] == 'superadmin'){
                    header('location: ./superadmin');
                    exit;
               }elseif($_SESSION['role'] == 'admin'){
                    header('location: ./admin/');
                    exit;
               }elseif($_SESSION['role'] == 'faculty'){
                    header('location: ./faculty');
                    exit;
                }elseif($_SESSION['role'] == 'student'){
                    header('location: ./student');
                    exit;
                }else{
                    echo "<p class='text-danger'>An error has occured.</p>";
                }

            }else{
                echo "<p class='text-danger'>Incorrect password.</p>";
            }
        }else{
            echo "<p class='text-danger'>Username not found.</p>";
        }
    }else{
        die("Error with the query: " . $conn->error);
    }
}



if(isset($_POST['btn_login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username,  $password);
}

    
?>