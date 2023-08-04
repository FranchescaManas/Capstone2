<!-- LOGIN PAGE FOR ALL USERS -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./shared/css/components.css">
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
   
<body class="d-flex flex-column justify-content-center align-content-center " style="border: 1px solid blue;">
    <?php
    include './shared/navbar.php';
    ?>
    <!-- LOGIN FORM -->
    <div class="container" id="login-container">
        <div class="d-flex justify-content-center mb-3">
            <img src="assets\images\logo.png" alt="SBCA logo" width="30px" height="35px" class="mx-2">
            <h4>San Beda College Alabang</h4>
        </div>

        
        <form action="" method="post" class="d-flex flex-column" id="login-form">
            <label for="username">Username</label>
            <input type="text" name="username" id="" class="rounded-pill border border-secondary">
            <label for="password">Password</label>
            <input type="password" name="password" id="" class="rounded-pill border border-secondary">

            <button type="submit" class="rounded-pill">Log In</button>
        </form>
       
    </div>



    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>