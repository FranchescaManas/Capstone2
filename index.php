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
<body>
    <?php
    
    include './shared/navbar.php';
    
    ?>

    <!-- LOGIN FORM -->
    <div class="container" id="login-container" style="border: 1px solid black;">
        <div class="d-flex">
            <img src="assets\images\logo.png" alt="SBCA logo" width="25px">
            <h4>San Beda College Alabang</h4>
        </div>

        
        <form action="" method="post" class="d-flex flex-column" id="login-form">
            <label for="username">Username</label>
            <input type="text" name="username" id="">
            <label for="password">Password</label>
            <input type="password" name="password" id="">

            <button type="submit">Log In</button>
        </form>
       
    </div>



    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>