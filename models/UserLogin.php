<?php
require_once('Redirector.php');
class UserLogin extends DbConn
{

    public $message = array(
        "id" => "",
        "text" => "",
    );
    public function loginUser($username, $password)
    {
        $user = trim($username);
        $pass = trim($password);
        $sql = 'SELECT user_id, username, avatar,`password` from user where username = ? LIMIT 1';
        $result = $this->selectQueryBind($sql, $user);
        // User exists
        if (count($result) == 1) {
            // Hashed password comparison
            // We compare the input pass to one found on the database (hashed) 
            if (password_verify($pass, $result[0]['password'])) {
                $u = new UserModel($result[0]['user_id']);
                if ($u->getUserStatus()) { // Check if user is banned
                    $this->message["id"] = "general";
                    $this->message["text"] = "You are banned. Contact the administrator to be able to log in again with this user.";
                    session_destroy();  // we make sure the session is not kept
                } else {
                    $_SESSION['userId'] = $result[0]['user_id'];
                    $_SESSION['username'] = $result[0]['username'];
                    $_SESSION['avatar'] = $result[0]['avatar'];
                    session_regenerate_id(true);
                }
            } else {
                $this->message["id"] = "general";
                $this->message["text"] = "Username/password combination incorrect. Please make sure your caps lock key is off and try again.";
            }
            // User doesn't exist
        } else {
            $this->message["id"] = "general";
            $this->message["text"] = "No such username in the database. Please make sure your caps lock key is off and try again.";
        }

        return $this->message;
    }
}
