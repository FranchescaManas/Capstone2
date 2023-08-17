<!-- 
    this is where the urls are set to switch pages on the superadmin nav menu by
    placing variables in the url 
    example:
    ./index.php?page=dashboard
    page is the variable name, (?) is used to assignment symbol, and dashboard is the variable

    NEXT: NONE

    PREVIOUS/INCLUDED IN: superadmin/index.php

 -->

<nav class="sidebar background-shade">
    <div class="row">
        <div class="col-2" >
            <img src="../assets/images/logo.png" alt="SBCA logo" width="45px">
        </div>
        <div class="col-10">
            <h4 style="padding-left: 5px;">San Beda College Alabang</h4>
        </div>
    </div>

    <ul>
        <li class="sidebar-item">
            <a href="./index.php?page=dashboard">Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=users">Users</a>
        </li>
        <li class="sidebar-item">
            <a href="../shared/forms/form.php">Forms</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=reports">Reports</a>
        </li>
    </ul>

    <div class="account-details d-flex flex-column justify-content-center align-items-center">
        <img class="user-profile my-2" src="../assets/images/user.jpg" 
            alt="user-profile" width="40px">
        <h6><?php echo getUsername(); ?></h6>
        <small><?php echo getRole(); ?></small>
        <form action="" method="post" class="w-100">
            <button type="submit" name="btn-logout" class="rounded-pill py-1">Log out</button>
        </form>
    </div>

    <?php
    if(isset($_POST['btn-logout'])){
        logout();
    }
    ?>
</nav>