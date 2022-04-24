<div class="row navbar d-flex align-items-center h-auto sticky-top">
  <div class="col col-9 navbar_left d-flex align-items-center flex-fill my-2">
    <div>
      <a id="logo-link"><img class="navbar_logo" src="views/web/img/assets/logo_low.png" alt="socially_logo" /></a>
    </div>
    <!-- Dropdown menu -->
    <div id="header-buttons" class="dropdown mx-3">
      <button type="button" class="btn" id="all-cats">All categories</button>
      <button type="button" class="btn" id="popular-feed" onclick="<?php $_SESSION['feed_page'] = "popularfeed" ?>">Popular feed</button>
      <button type="button" class="btn" id="about-us" onclick="goToAboutPage()">About us</button>
    </div>
  </div>
  <div class="col col-3 navbar_right d-flex align-items-center flex-fill my-2">
    <!-- Scroll to top button -->
    <div class="d-flex align-items-center" id="scrollTop">
      <i class="fas fa-arrow-up" data-toggle="tooltip" data-placement="bottom" title="Scroll to Top"></i>
    </div>
    <?php if ($userData['role'] == 'Admin') {
      echo '<a class="btn btn-outline-success mx-2" href="admin">Admin </a>';
    } ?>
    <div class="navbar_profile d-flex align-items-center" id="user_profile">
      <img src="./views/web/img/avatars/<?php echo $userData['avatar'] ?>" alt="avatar" id="user_profile" />
      <span><?php echo $userData['username'] ?></span>
    </div>
    <div class="navbar_links">
      <i class="fa fa-plus" id="new_post" data-toggle="tooltip" data-placement="bottom" title="New Post"></i>
      <a id="logout" href="logout/1"><i class="fas fa-sign-out-alt" data-toggle="tooltip" data-placement="bottom" title="Logout"></i></a>
    </div>
  </div>
</div>