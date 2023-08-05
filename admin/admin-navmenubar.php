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
            <a href="./admin-home.php?page=dashboard">Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="./admin-home.php?page=faculty">Faculty Members</a>
        </li>
        <li class="sidebar-item">
            <a href="./admin-home.php?page=students">Students</a>
        </li>
        </li>
        <li class="sidebar-item">
            <a href="./admin-home.php?page=forms">Forms</a>
        </li>
    </ul>

    <div class="account-details d-flex flex-column justify-content-center align-items-center">
        <img class="user-profile my-2" src="../assets/images/user.jpg" 
            alt="user-profile" width="40px">
        <h6>{{John Doe}}</h6>
        <small>{{Faculty}}</small>
        <button type="submit" class="rounded-pill py-1">Log out</button>
    </div>
</nav>