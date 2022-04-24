<?php
if (!empty($args)) {
    if (!empty($args[2]) && is_numeric($args[2])) {
        $a = new AdminController();
        $data = $a->validateInput($args[2]);
        $userId = $data;
        if ($a->checkUserIdExists($userId)) {
            $u = new UserController();
            $data = $u->getUserInfo($userId);
            $stats = $u->getUserCountStats($userId);
        } else {
            echo '<script type="text/javascript">window.location.href ="/404" ; </script>';
            // $redirector = new Redirector(PATH . '404');
        }
    } else {
        echo '<script type="text/javascript">window.location.href ="/404" ; </script>';
        // $redirector = new Redirector(PATH . '404');
    }
}
?>
<div class="col-md-10 pt-3 px-4">
    <div class="row">
        <section id="user-profile">
            <div class="user-profile-wrapper">
                <h4 class="pb-2 border-bottom">User account</h4>
                <div class="d-flex align-items-start py-3 border-bottom">
                    <div class="col-md-6 d-flex px-2 user-profile-info" id="user-info-section">
                        <div class="col-md-4">
                            <?php echo '<img src="' . PATH . 'views/web/img/avatars/' . $data['avatar'] . '" class="img" alt="">' ?>
                        </div>
                        <div class="col-md-6 d-flex-column px-2 align-self-center">
                            <div class="d-flex user-title-info">
                                <p><b><?php echo $data['username'] ?></b></p>
                                <span class="role-badge"><?php echo $data['role'] ?></span>
                            </div>
                            <span class="user-rank"><?php echo $data['rank'] ?></span>
                            <span class="secondary-text"><?php echo $data['email'] ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex-column px-2" id="user-comments-section">
                        <h5>User statistics</h5>
                        <p><b>Total comments:&nbsp;</b><span class="number-user-posts"><?php echo $stats['tot_comments'][0] ?></span></p>
                        <p><b>Total posts:&nbsp;</b><span class="number-user-posts"><?php echo $stats['tot_posts'][0] ?></span></p>
                    </div>
                </div>

                <!-- Edit user info  -->
                <div class="py-2">
                    <h4>Edit user</h4>
                    <form action="" method="post" id="adminEditUserForm">
                        <div class="row py-2">
                            <div class="col-md-6">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="admin-edit-user-username" class="bg-light form-control" placeholder="<?php echo $data['username'] ?>">
                                <span class="msg error-message my-2" id="username-error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="admin-edit-user-email" class="bg-light form-control" placeholder="<?php echo $data['email'] ?>">
                                <span class="msg error-message my-2" id="email-error"></span>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="bg-light form-control" placeholder="••••••" id="admin-edit-user-password">
                                <span class="msg error-message my-2" id="password-error">
                            </div>
                        </div>
                        <div class="row py-1 user-role-options">
                            <div class="col-md-12 py-2">
                                <h6><label for="rank">User Rank</label> </h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input user-rank-input" type="radio" name="userRank" id="beginnerRank" value="Beginner" <?php if ($data['rank'] == 'Beginner')  echo 'checked' ?>>
                                    <label class="form-check-label" for="beginner">Beginner</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input user-rank-input" type="radio" name="userRank" id="experiencedRank" value="Experienced" <?php if ($data['rank'] == 'Experienced') echo 'checked' ?>>
                                    <label class="form-check-label" for="experienced">Experienced</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input user-rank-input" type="radio" name="userRank" id="veterandRank" value="Veteran" <?php if ($data['rank'] == 'Veteran') echo 'checked' ?>>
                                    <label class="form-check-label" for="veteran">Veteran</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input user-rank-input" type="radio" name="userRank" id="administrationdRank" value="Administration" <?php if ($data['rank'] == 'Administration') echo 'checked' ?>>
                                    <label class="form-check-label" for="administration">Administration</label>
                                </div>
                            </div>
                        </div>
                        <div class="row py-1 user-role-options">
                            <div class="col-md-12" id="role">
                                <div class="col-md-12 py-2">
                                    <h6><label for="rank">User permission</label> </h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="userPermission" id="userPermission" value="User" <?php if ($data['role'] == 'User') echo 'checked' ?>>
                                        <label class="form-check-label" for="user">User</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="userPermission" id="moderatorPermission" value="Moderator" <?php if ($data['role'] == 'Moderator') echo 'checked' ?>>
                                        <label class="form-check-label" for="moderator">Moderator</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="userPermission" id="adminPermission" value="Admin" <?php if ($data['role'] == 'Admin') echo 'checked' ?>>
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="userId" name="userId" value=<?php echo $userId ?>>

                        <div class="py-3 pb-4 border-bottom d-flex justify-content-start">
                            <button class="btn btn-primary mr-3" onclick="adminUpdateUser(event)">Save Changes</button>
                        </div>
                        <div>
                            <span class="msg error-message my-2" id="success-info">
                        </div>
                    </form>


                    <!-- Disable user -->
                    <div class="d-flex justify-content-between align-items-center pt-3" id="deactivate">
                        <div> <b>Activate/Deactivate account</b>
                            <p>User won't be able to log in</p>

                            <button class="btn btn-danger my-3" id="deactivateUserBtn" onclick="<?php echo 'return adminBanUser(this.value, ' . $data['banned'] . ')' ?>" value=<?php echo $userId ?>>
                                <?php if ($data['banned'] == 0) {
                                    echo 'Deactivate';
                                } else {
                                    echo 'Activate';
                                }  ?>
                            </button>
                        </div>
                    </div>
                    <div>
                        <span class="msg error-message my-2" id="success-info-user-ban">
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>


<?php echo '<script src="' . PATH . 'views/admin/js/admin-validation.js"></script>'; ?>
<?php echo '<script src="' . PATH . 'views/web/js/utils.js"></script>'; ?>