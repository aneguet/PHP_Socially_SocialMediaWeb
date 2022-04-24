<?php
require_once('bootstrapping.php');
$session = new SessionHandle();
if ($session->confirm_logged_in()) {
  $redirect = new Redirector("login");
} else {
  $c = new UserController();
  $userData = $c->getUserInfo($_SESSION['userId']);
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <!-- Web icon -->
  <link rel="icon" href="views/web/img/assets/favicon.ico" type="image/x-icon">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Bootstrap 5.1.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="views/web/css/styles.css" />
  <link rel="stylesheet" href="views/web/css/utilities.css" />
  <link rel="stylesheet" href="views/web/css/about_us.css" />
  <link rel="stylesheet" href="views/web/css/new_post.css" />
  <link rel="stylesheet" href="views/web/css/show_post.css" />
  <link rel="stylesheet" href="views/web/css/profile-style.css" />
  <link rel="stylesheet" href="views/web/css/category_posts.css" />
  <link rel="stylesheet" href="views/web/css/all_categories.css" />
  <!-- Tiny MCE | Text editor for text styling -->
  <script src="https://cdn.tiny.cloud/1/miwptpgkuardbryq4clyxu4r63ugkxeiu94huixvgv7nn7lr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Socially</title>
</head>

<body>
  <div class="container-fluid d-flex flex-column">
    <?php require_once('views/shared/header.php'); ?>
    <div class="row">
      <!-- Left content -->
      <div class="content_left col col-lg-2 col-sm-3 col-xs-12 d-flex min-vh-100">
        <?php require_once('views/shared/left_menu.php'); ?>
      </div>

      <!-- Main content -->
      <div class="col col-lg-10 col-sm-9 col-xs-12" id='content'>
        <?php $_SESSION['feed_page'] = "userfeed" ?>
        <?php require_once('views/pages/feeds.php'); ?>
      </div>

    </div>
  </div> <!-- header view container fluid div-->
</body>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="views/web/js/utils.js"></script>
<script type="text/javascript" src="views/web/js/dynamic-content.js"></script>
<script type="text/javascript" src="views/web/js/header.js"></script>
<script type="text/javascript" src="views/web/js/left-menu.js"></script>
<script type="text/javascript" src="views/web/js/about_us.js"></script>
<script type="text/javascript" src="views/web/js/feeds.js"></script>
<script type="text/javascript" src="views/web/js/show_post.js"></script>
<script type="text/javascript" src="views/web/js/new_post.js"></script>
<script type="text/javascript" src="views/web/js/user_profile.js"></script>
<script type="text/javascript" src="views/web/js/category_posts.js"></script>
<script type="text/javascript" src="views/web/js/all_categories.js"></script>

</html>