<?php
// require '../../bootstrapping.php';

class AdminController
{

    public $msg = array(
        "id" => "",
        "text" => "",
    );

    public function isUserAdmin($userId)
    {
        $a = new AdminDaoModel();
        $result = $a->isUserAdmin($userId);
        return $result;
        // if (!$result){
        //     return false;
        // } else {
        //     return true;
        // }
    }

    // Dashboard functions
    public function adminPostCategoriesChartData()
    {
        $a = new AdminDaoModel();
        $result = $a->adminPostCategoriesChartData();
        return $result;
    }
    public function getAdminDashboardStats()
    {
        $a = new AdminDaoModel();
        $result = $a->getAdminDashboardStats();
        return $result;
    }
    // User functions
    public function getUsersData()
    {
        $a = new AdminDaoModel();
        $result = $a->getUsersData();
        return $result;
    }
    public function deleteUser($userId)
    {
        $a = new AdminDaoModel();
        if (is_numeric($userId)) {
            $result = $a->deleteUser($userId);
            if ($result == true) {
                $result = 'User deleted successfully';
            } else {
                $result = 'Something went wrong. Contact administration';
            }
        } else {
            $result = 'Could not process the data';
        }

        return $result;
    }
    public function banUser($userId, $isBanned)
    {
        $a = new AdminDaoModel();
        if (is_numeric($isBanned) && is_numeric($userId)) {
            if ($isBanned == 1 or $isBanned == 0) {
                $newStatus = $isBanned == 0 ? 1 : 0;
                $result = $a->banUser($userId, $newStatus);
                if ($isBanned == 0) {
                    $result = 'User account deactivated';
                } else {
                    $result = 'User account activated';
                }
            } else {
                $result = 'Could not process the data';
            }
        } else {
            $result = 'Could not process the data';
        }
        //Check if user is banned or not and apply new ban status. If they are banned (1) now they'll be unbanned (0)
        return $result;
    }

    // Edit user functions 

    //Function gathers the form sent via POST from the edit user in the admin section and validates its inputs
    public function validateForm($postData)
    {

        $this->msg['id'] = 'result';
        $this->msg['text'] = 'User updated successfuly. The page will refresh in 3 seconds.';

        $u = new UserModel($postData['userid']);
        foreach ($postData as $key => $value) {
            if (!empty($value)) {
                $value = $this->validateInput($value);
                // Checks the key name of the array and updates the data
                if ($key == 'username') {
                    if ($this->validateAdminUsername($value)) {
                        $u->setUsername($value);
                    } else {
                        return $this->msg;
                    }
                } else if ($key == 'email') {
                    if ($this->validateAdminEmail($value)) {
                        $u->setUserEmail($value);
                    } else {
                        return $this->msg;
                    }
                } else if ($key == 'password') {
                    if ($this->validateAdminPassword($value)) {
                        $iterations = ['cost' => 12];
                        $hashed_password = password_hash($value, PASSWORD_BCRYPT, $iterations);
                        $u->setUserPassword($hashed_password);
                    } else {
                        return $this->msg;
                    }
                } else if ($key == 'userrank') {
                    $u->setUserRank($value);
                } else if ($key == 'userpermission') {
                    $u->setUserRole($value);
                }
            }
        }

        return  $this->msg;
    }

    //Post functions
    public function getPostsData()
    {
        $a = new AdminDaoModel();
        $result = $a->getPostsData();
        return $result;
    }
    public function deletePost($postId)
    {
        $a = new AdminDaoModel();
        $result = $a->deletePost($postId);
        if ($result == true) {
            $result = 'Post deleted successfully. The page will now be refreshed.';
        } else {
            $result = 'Something went wrong. Contact administration';
        }
        return $result;
    }
    // Comments functions
    public function getCommentsData()
    {
        $a = new AdminDaoModel();
        $result = $a->getCommentsData();
        return $result;
    }
    public function deleteComment($commentId)
    {
        $a = new AdminDaoModel();
        $result = $a->deleteComment($commentId);
        if ($result == true) {
            $result = 'Comment deleted successfully. The page will now be refreshed.';
        } else {
            $result = 'Something went wrong. Contact administration';
        }
        return $result;
    }


    // Validations

    public function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace(' ', '', $data);
        return $data;
    }

    private function validateAdminUsername($username)
    {
        $username_regexp = "/^[0-9A-Za-z\_]+$/";
        $dataOk = true;

        // Username length
        if (strlen($username) < 4) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username must have at least 4 characters.";
            $dataOk = false;
        } else if (strlen($username) > 30) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username cannot exceed 30 characters.";
            $dataOk = false;
        }
        // Username is not the accepted type
        else if (!preg_match($username_regexp, $username)) {
            $this->msg["id"] = "username";
            $this->msg["text"] = "Username can only contain letters, numbers and underscores.";
            $dataOk = false;
        }

        return $dataOk;
    }

    private function validateAdminEmail($email)
    {
        $email_regexp = "/^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/";
        $dataOk = true;

        // EMAIL
        if (empty($email)) {
            $this->msg["id"] = "email";
            $this->msg["text"] = "Email cannot be empty.";
            $dataOk = false;
        }
        // Email is not the accepted type
        else if (!preg_match($email_regexp, $email)) {
            $this->msg["id"] = "email";
            $this->msg["text"] = "This email is not valid.";
            $dataOk = false;
        }
        return $dataOk;
    }
    private function validateAdminPassword($password)
    {
        $password_regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/";
        $dataOk = true;


        // PASSWORD
        if (empty($password)) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password cannot be empty.";
            $dataOk = false;
        }
        // Password length
        else if (strlen($password) < 6) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password must have at least 6 characters.";
            $dataOk = false;
        } else if (strlen($password) > 30) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password cannot exceed 30 characters.";
            $dataOk = false;
        }
        // Password is not the accepted type
        else if (!preg_match($password_regexp, $password)) {
            $this->msg["id"] = "password";
            $this->msg["text"] = "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
            $dataOk = false;
        }

        return $dataOk;
    }

    public function checkUserIdExists($inputId)
    {
        $a = new AdminDaoModel();
        $tableParam = 'user';
        $fieldParam = 'user_id';
        $result = $a->checkIdExists($tableParam, $fieldParam, $inputId);
        return $result;
    }
}
