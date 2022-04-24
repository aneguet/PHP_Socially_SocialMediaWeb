<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

class UserController extends MediaController
{
    public $msg = array(
        "id" => "",
        "text" => "",
    );

    public function registerUser($username, $email, $password, $avatar)
    {
        $u = new UserModel($username, $email, $password);
        $res = $u->registerUser($username, $email, $password, $avatar);
        $this->msg = $u->message;
        return $res; // If user is successfully created, returns their user Id
    }

    public function getUserInfo($userId)
    {
        $u = new UserModel($userId);
        $data = [
            'userId' => $u->getUserId(),
            'username' => $u->getUsername(),
            'avatar' => $u->getUserAvatar(),
            'email' => $u->getUserEmail(),
            'rank' => $u->getUserRank(),
            'role' => $u->getUserRole(),
            'banned' => $u->getUserStatus()
        ];
        return $data;
    }

    public function getUserCountStats ($userId)
    {
        $u = new UserModel ($userId);
        $stats = [
            'tot_comments' => '',
            'tot_posts'=> ''
        ];
        $tableParam = 'comment'; $fieldParam = 'user_id';
        $result = $u->getUserCountStats($tableParam, $fieldParam, $userId);
        $stats['tot_comments'] = $result[0];
        $tableParam = 'post'; $fieldParam = 'user_id';
        $result = $u->getUserCountStats($tableParam, $fieldParam, $userId);
        $stats['tot_posts'] = $result[0];
        return $stats;
    }

    public function getUserPassword()
    {
        $u = new UserModel($_SESSION['userId']);
        $data = $u->getUserPassword();
        return $data;
    }

    // Instances a user object. Mostly used to set user info
    public function setUser()
    {
        $u = new UserModel($_SESSION['userId']);
        return $u;
    }

    // Validation
    function validateSignUpFields(&$username, &$email, &$password, &$password2)
    {
        $isDataValid = false;
        // Variables sanitizing
        $username = htmlspecialchars(trim($username));
        $username = str_replace(' ', '', $username);

        $email = htmlspecialchars(trim($email));
        $email = str_replace(' ', '', $email);

        $password = htmlspecialchars(trim($password));
        $password = str_replace(' ', '', $password);

        $password2 = htmlspecialchars(trim($password2));
        $password2 = str_replace(' ', '', $password2);

        // Regex
        $username_regexp = "/^[0-9A-Za-z\_]+$/";
        $email_regexp = "/^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/";
        $password_regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/";


        // USERNAME
        if (empty($username)) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username cannot be empty.";
        }
        // Username length
        else if (strlen($username) < 4) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username must have at least 4 characters.";
        } else if (strlen($username) > 30) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username cannot exceed 30 characters.";
        }
        // Username is not the accepted type
        else if (!preg_match($username_regexp, $username)) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username can only contain letters, numbers and underscores.";
        }
        // EMAIL
        else if (empty($email)) {
            $this->msg["id"] = "email";
            $this->msg["text"] = "Email cannot be empty.";
        }
        // Email is not the accepted type
        else if (!preg_match($email_regexp, $email)) {
            $this->msg["id"] = "email";
            $this->msg["text"] = "This email is not valid.";
        }
        // PASSWORD
        else if (empty($password)) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password cannot be empty.";
        }
        // Password length
        else if (strlen($password) < 6) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password must have at least 6 characters.";
        } else if (strlen($password) > 30) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password cannot exceed 30 characters.";
        }
        // Password is not the accepted type
        else if (!preg_match($password_regexp, $password)) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
        }
        // PASSWORD 2
        else if (empty($password2)) {
            $this->msg["id"] = "password2";
            $this->msg["text"] = "Password cannot be empty.";
        }
        // PASSWORD VS PASSWORD  2
        // Passwords have different values
        else if (!($password === $password2)) {
            $this->msg["id"] = "password2";
            $this->msg["text"] = "Passwords must be identical.";
        } else {
            $isDataValid = true;
        }
        return $isDataValid;
    }

    function validateUserProfile(&$email, &$password, &$password1, &$password2)
    {
        $isDataValid = true;
        // Variables sanitizing

        $email = htmlspecialchars(trim($email));
        $email = str_replace(' ', '', $email);

        $password = htmlspecialchars(trim($password));
        $password = str_replace(' ', '', $password);

        $password1 = htmlspecialchars(trim($password1));
        $password1 = str_replace(' ', '', $password1);

        $password2 = htmlspecialchars(trim($password2));
        $password2 = str_replace(' ', '', $password2);

        // Regex
        $email_regexp = "/^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/";
        $password_regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/";

        // No field 
        if (!$email && !$password && !$password1 && !$password2) {
            $this->msg["id"] = "general";
            $this->msg["text"] = "Write an email or password to save changes.";
            $isDataValid = false;
        } else if ($email) { // check if email is the accepted type
            if (!preg_match($email_regexp, $email)) {
                $this->msg["id"] = "email";
                $this->msg["text"] = "This email is not valid.";
                $isDataValid = false;
            } else {
                if ($this->getUserInfo($_SESSION['userId'])['email'] === $email) {
                    $this->msg["id"] = "email";
                    $this->msg["text"] = "The new email should be different than your current one.";
                    $isDataValid = false;
                } else if (($password && (!$password1 || !$password2)) || ($password1 && (!$password || !$password2)) || ($password2 && (!$password || !$password1))) {
                    $this->msg["id"] = "general";
                    $this->msg["text"] = "The new password, the confirmation password and the current password are required to upload your information.";
                    $isDataValid = false;
                } else if ($password && $password1 && $password2) {
                    if (!password_verify($password, $this->getUserPassword())) {
                        $this->msg["id"] = "password";
                        $this->msg["text"] = "Your current password is incorrect. Try again.";
                        $isDataValid = false;
                    } else if (!preg_match($password_regexp, $password1)) {
                        $this->msg["id"] = "general";
                        $this->msg["text"] = "The new password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
                        $isDataValid = false;
                    } else if (strlen($password1) < 6) {
                        $this->msg["id"] = "password1";
                        $this->msg["text"] = "Password must have at least 6 characters.";
                        $isDataValid = false;
                    } else if (strlen($password1) > 30) {
                        $this->msg["id"] = "password1";
                        $this->msg["text"] = "Password cannot exceed 30 characters.";
                        $isDataValid = false;
                    } else if ($password1 !== $password2) {
                        $this->msg["id"] = "general";
                        $this->msg["text"] = "The new password and the confirmation password don't match.";
                        $isDataValid = false;
                    } else if (($password === $password1) && ($password1 === $password2) && ($password === $password2)) {
                        $this->msg["id"] = "general";
                        $this->msg["text"] = "The new password should be different than your current one.";
                        $isDataValid = false;
                    }
                }
            }
        } else if (($password && (!$password1 || !$password2)) || ($password1 && (!$password || !$password2)) || ($password2 && (!$password || !$password1))) {
            $this->msg["id"] = "general";
            $this->msg["text"] = "The new password, the confirmation password and the current password are required to upload your information.";
            $isDataValid = false;
        } else if ($password && $password1 && $password2) {
            if (!password_verify($password, $this->getUserPassword())) {
                $this->msg["id"] = "password";
                $this->msg["text"] = "Your current password is incorrect. Try again.";
                $isDataValid = false;
            } else if (!preg_match($password_regexp, $password1)) {
                $this->msg["id"] = "general";
                $this->msg["text"] = "The new password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
                $isDataValid = false;
            } else if (strlen($password1) < 6) {
                $this->msg["id"] = "password1";
                $this->msg["text"] = "Password must have at least 6 characters.";
                $isDataValid = false;
            } else if (strlen($password1) > 30) {
                $this->msg["id"] = "password1";
                $this->msg["text"] = "Password cannot exceed 30 characters.";
                $isDataValid = false;
            } else if ($password1 !== $password2) {
                $this->msg["id"] = "general";
                $this->msg["text"] = "The new password and the confirmation password don't match.";
                $isDataValid = false;
            } else if (($password === $password1) && ($password1 === $password2) && ($password === $password2)) {
                $this->msg["id"] = "general";
                $this->msg["text"] = "The new password should be different than your current one.";
                $isDataValid = false;
            }
        }
        return $isDataValid;
    }

    function validateNewAvatar(&$imageFile)
    {
        $dataIsValid = true;
        if (!empty($imageFile)) { // The user uploaded an avatar

            if ($this->isImageTheSupportedType($imageFile['type'])) {
                //Image size bigger than 2MB
                if ($this->isImageBiggerThan2MB($imageFile['size'])) {
                    $this->msg["id"] = 'avatar';
                    $this->msg["text"] = 'Maximum image size is 2MB';
                    $dataIsValid = false;
                } else if ($this->getImageWidth($imageFile['tmp_name']) < 120) { // The image is too small
                    $this->msg["id"] = 'avatar';
                    $this->msg["text"] = 'Image is too small. Choose an image of a minimum width of 120px.';
                    $dataIsValid = false;
                } else if ($this->getImageWidth($imageFile['tmp_name']) > 1920 || $this->getImageHeight($imageFile['tmp_name']) > 1920) { // The image is too big in px
                    $this->msg["id"] = 'avatar';
                    $this->msg["text"] = "Image width or height can't be bigger than 1920px.";
                    $dataIsValid = false;
                } else if ($this->getImageRatio($imageFile['tmp_name']) < 0.5) { // Image's height size is too big
                    $this->msg["id"] = 'avatar';
                    $this->msg["text"] = 'Image height is too big in relation to its width. (Accepted ratios: 0.5-3)';
                    $dataIsValid = false;
                } else if ($this->getImageRatio($imageFile['tmp_name']) > 3) { // Image's width size is too big
                    $this->msg["id"] = 'avatar';
                    $this->msg["text"] = 'Image width is too big in relation to its height. (Accepted ratios: 0.5-3)';
                    $dataIsValid = false;
                }
            } else {
                $this->msg["id"] = 'avatar';
                $this->msg["text"] = 'Only jpeg, jpg, png and gif images are allowed';
                $dataIsValid = false;
            }
        } else { // The user didn't upload an avatar
            $this->msg["id"] = 'avatar';
            $this->msg["text"] = 'You uploaded no image.';
            $dataIsValid = false;
        }
        return $dataIsValid;
    }
}
