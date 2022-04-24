<?php
// require_once('../../bootstrapping.php');
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign Up</title>
  <!-- Web icon -->
  <link rel="icon" href="views/web/img/assets/favicon.ico" type="image/x-icon">
  <!-- Bootstrap 5.1.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Stylesheets -->
  <link rel="stylesheet" href="views/web/css/login-signup.css" />
  <link rel="stylesheet" href="views/web/css/utilities.css" />
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body id="signup">
  <div class="container-fluid d-flex flex-column">
    <div class="row min-vh-100">
      <div id="signup-form" class="col col-lg-4 col-md-9 col-sm-12 col-xs-12 mx-auto form-wrap">
        <!-- Standard top popup message -->
        <div class="text-center mb-3 alert alert-danger py-2 fade show d-none" role="alert" id="general-message">
          <span class="my-2 " id="general"></span>
        </div>
        <h1>Sign Up</h1>
        <form action="" method="post">
          <!-- USERNAME -->
          <div class="form-group">
            <label for="username">Username<span class="required_field">*</span></label>
            <!-- required="" aria-required="true" -->
            <input type="text" name="username" id="username" autocomplete="off" autofocus="autofocus" onfocus="this.select()" />
          </div>
          <!-- USERNAME Error -->
          <span class="msg error-message my-2" id="username-error"></span>
          <!-- EMAIL -->
          <div class="form-group">
            <label for="email">Email<span class="required_field">*</span></label>
            <input type="text" name="email" id="email" autocomplete="off" />
          </div>
          <!-- EMAIL Error -->
          <span class="msg error-message my-2" id="email-error"></span>
          <!-- PASSWORD -->
          <div class="form-group" id="password-parent">
            <label for="password">Password<span class="required_field">*</span></label>
            <i id="password-show" class="fas fa-eye-slash"></i>
            <input type="password" name="password" id="password" autocomplete="off" />
          </div>
          <!-- PASSWORD Error -->
          <span class="msg error-message my-2" id="password-error"></span>
          <!-- PASSWORD 2 -->
          <div class="form-group" id="password2-parent">
            <label for="password2">Confirm Password<span class="required_field">*</span></label>
            <i id="password2-show" class="fas fa-eye-slash"></i>
            <input type="password" name="password2" id="password2" autocomplete="off" />
          </div>
          <!-- PASSWORD 2  Error -->
          <span class="msg error-message my-2" id="password2-error"></span>
          <!-- TERMS OF USE -->
          <div class="terms-margin">
            <input type="checkbox" id="termsofuse" name="termsofuse" class="custom-checkbox">
            <label for="termsofuse"> I accept the Terms of Use.<span class="required_field">*</span></label>
          </div>
          <!-- TERMS OF USE Error -->
          <span class="msg error-message my-2" id="termsofuse-error"></span>
          <input type="button" name="submit" value="Submit" id="submit" onclick="validate_signup()">
          <p class="bottom-text">
            By continuing, you agree to our
            <a class="purple-color" href="#">Terms & Conditions</a> and
            <a class="purple-color" href="#">Privacy Policy</a>
          </p>
        </form>
        <footer>
          <p>Already have an account? <a class="purple-color" href="login">Login Here</a></p>
        </footer>
      </div>
    </div> <!-- container -->
  </div>
  <!-- Validation -->
  <script type="text/javascript" src="views/web/js/utils.js"></script>
  <script type="text/javascript" src="views/web/js/signup.js"></script>
</body>

</html>