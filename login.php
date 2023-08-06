<?php
require './shared/connection.php';

function login($username, $password){
    $conn = connection();

    $sql = "SELECT * FROM users WHERE  username = '$username'";
    
    if($result = $conn->query($sql)){
        if($result->num_rows == 1){
            $user_row = $result-> fetch_assoc();
            
            if(password_verify($password, $user_row['password'])){
                // TODO: ADD SESSION LATER
                // session_start();

                $_SESSION['user_id'] = $user_row['id'];
                $_SESSION['username'] = $user_row['username'];
                $_SESSION['full_name'] = $user_row['first_name'] . " " . $user_row['last_name'];
                $_SESSION['role'] = $user_row['role'];

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
                    header('location: student');
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