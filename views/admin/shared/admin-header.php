<nav id="admin-navbar" class="navbar navbar-dark bg-dark">
    <div class="col-md-2 my-2">
        <a href=<?php echo PATH . 'home'?> id="home_icon" class="navbar-brand"><i class="fas fa-home"></i></a>
    </div>
    <div class="admin_navbar_links px-3">
        <div class="admin_navbar_profile d-flex align-items-center" id="user_profile">
            <div class="profile_name d-flex align-items-center">
                <!-- <img src="./views/web/img/avatars/<?php echo $_SESSION['avatar'] ?>" alt="avatar" id="user_profile" /> -->
                <span><?php echo $_SESSION['username'] ?></span>
            </div>
            <a id="logout" href=<?php echo PATH . 'logout/1'?> data-toggle="tooltip" data-placement="bottom"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>