<?php
// Session handling
$session = new SessionHandle();
if ($session->confirm_logged_in()) {
  $redirect = new Redirector("../home/login.php");
}
$u = new UserController();
$userData = $u->getUserInfo($_SESSION['userId']);
?>

<div class="profile-section-title">
  <?php
  echo '<script type="text/javascript">scrollToTop();</script>';
  ?>
  <h2>User profile</h2>
</div>
<div class="row sections-style" id="profile-settings-section">
  <div class="col col-lg-12 col-xs-12 ">
    <div class="row mt-3 mb-3">
      <div class="col-lg-12 px-4">
        <div class="profile-section-subtitle">
          <h4>Profile Settings</h4>
          <hr>
        </div>
        <div class="profile-avatar d-flex flex-row">
          <!-- class="rounded-circle" -->
          <img src="views/web/img/avatars/<?php echo $userData['avatar'] ?>" alt="avatar" id="user_profile" />
          <div class="d-flex flex-column justify-content-center" id="username-info">
            <p id="username-title">Username</p>
            <p id="username-description"><?php echo $userData['username'] ?></p>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="new-avatar-form">
          <div class="d-flex align-items-center mt-3">
            <div class="custom-file">
              <p class="file-info-txt"><i>Choose a file to upload your current avatar. The image will be cropped at the centre, so we recommend that you choose a square image (or almost square) for better results.</i></p>
              <input type="file" name="new-avatar-upload" class="custom-file-input" id="new-avatar-upload" onchange="getImageDimensions(this)">
              <button class="btn" id="upload-avatar-button" type="button" onclick="uploadUserAvatar()">
                <i class="fa fa-fw fa-camera"></i>
                <span>Change avatar</span>

              </button>
              <button id="user-remove-img-btn" class="btn" type="button" onclick="removeUserAttachedImage()">Remove attached image</button>
            </div>
          </div>
          <div class="d-flex mt-1 mb-0">
            <span class="msg error-message my-2" id="avatar-error"></span>
            <div id="avatar-msg"></div>
          </div>
          <hr>
        </form>
        <div>
          <p class="file-info-txt"><i>Update your email, your password or both.</i></p>
          <form action="" method="post" id="profile-form" class="d-flex flex-column">
            <div class="d-flex">
              <div class="mb-3">
                <label>Email</label>
                <input class="form-control" type="text" autocomplete="off" name="email" id="email-profile" placeholder="<?php echo $userData['email'] ?>">
                <span class="msg error-message my-2" id="email-error"></span>
              </div>
            </div>

            <div class="d-flex">
              <div class="mr">
                <label>New Password</label>
                <input class="form-control" type="password" autocomplete="off" name="password1" id="password1-profile" placeholder="••••••">
                <span class="msg error-message my-2" id="password1-error"></span>
              </div>
              <div class="mr">
                <label>Confirm Password</label>
                <input class="form-control" type="password" autocomplete="off" name="password2" id="password2-profile" placeholder="••••••">
                <span class="msg error-message my-2" id="password2-error"></span>
              </div>
              <hr>
              <div class="mr">
                <label>Current Password</label>
                <input class="form-control" type="password" autocomplete="off" name="password" id="password-profile" placeholder="••••••">
                <span class="msg error-message my-2" id="password-error"></span>
              </div>
              <div>
                <div class="col d-flex justify-content-end pt-4 pb-2">
                  <button class="btn save-profile-button" type="button" onclick="submitUserSettingsForm()">Save Changes</button>
                </div>
              </div>
            </div>
          </form>
          <div class="success-message"></div>
          <span class="msg error-message my-2" id="general-error"></span>
        </div>
      </div>
    </div> <!-- Profile settings section end-->
  </div>
</div>