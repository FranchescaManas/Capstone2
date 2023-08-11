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
            <a href="./index.php?page=classroom">Classroom Observation</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=performance">Performance Appraisal</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=feedback">Student Feedback</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=certification">Certificates</a>
        </li>
        <li class="sidebar-item">
            <a href="./index.php?page=forms">Forms</a>
        </li>
    </ul>

    <div class="account-details d-flex flex-column justify-content-center align-items-center">
        <img class="user-profile my-2" src="../assets/images/user.jpg" 
            alt="user-profile" width="40px">
        <h6><?php echo getUsername(); ?></h6>
        <small><?php echo getRole(); ?></small>
        <form action="#" method="post" class="w-100">
            <button type="submit" name="btn-logout" class="rounded-pill py-1">Log out</button>
        </form>
    </div>

    <?php
    if(isset($_POST['btn-logout'])){
        logout();
    }
    ?>
</nav>