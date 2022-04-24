<?php
// require_once ('../../bootstrapping.php');
define("PATH", '/dwpSocialWeb/'); //Change '/dwpSocialWeb/' to '/' on the live server

$a = new AdminController();
if (!(isset($_SESSION['userId']) && $a->isUserAdmin($_SESSION['userId']))) {
  $redirect = new Redirector(PATH . 'home');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Web icon -->
  <link rel="icon" href="views/web/img/assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <?php
  echo '<link href= "' . PATH . 'views/admin/css/admin-styles.css" rel="stylesheet" />';
  ?>
  <!-- Font awesome CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <!-- jQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Chart js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Datatables CDN -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
  <title>Socially · Admin</title>
</head>

<body>
  <!-- Header navbar -->
  <?php include('views/admin/shared/admin-header.php') ?>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <?php include('views/admin/shared/admin-sidebar.php') ?>
      <!-- Main content -->
      <main class="col-md-10" id="admin-content">
        <?php
        if (empty($args[1])) {
          include('views/admin/shared/admin-stats-panel.php');
          include('pages/admin-home.php');
        } else if (!empty($args[1])) {
          if ($args[1] == 'posts') {
            include('pages/admin-posts.php');
          } else if (!empty($args) && $args[1] == 'users') {
            include('pages/admin-users.php');
          } else if (!empty($args) && $args[1] == 'user') {
            include('pages/admin-edit-user.php');
          } else if (!empty($args) && $args[1] == 'comments') {
            include('pages/admin-comments.php');
          }
        }
        ?>
      </main>
    </div>
  </div>
</body>
<?php echo '<script src="' . PATH . 'views/admin/js/admin-dashboard.js"></script>'; ?>

</html>