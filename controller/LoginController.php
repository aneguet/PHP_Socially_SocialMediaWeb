<?php

class LoginController
{
    public $msg = array(
        "id" => "",
        "text" => "",
    );

    public function loginUser($username, $password)
    {
        $u = new UserLogin();
        $res = $u->loginUser($username, $password);
        return $res;
    }

    // Validation functions
    // Variables are passed by reference
    // If we sanitize the input here, it has effect on ViewsController variable
    public function validateUsername(&$username)
    {

        $dataIsValid = true;
        $username = htmlspecialchars(trim($username)); // sanitizes input before sql query and removes spaces
        $username = str_replace(' ', '', $username);    // removes any space between characters

        if (empty($username)) {

            $this->msg["id"] = "username";
            $this->msg["text"] = "Username cannot be empty.";
            $dataIsValid = false;
        }

        return $dataIsValid;
    }
    public function validatePassword(&$password)
    {
        $dataIsValid = true;
        $password = htmlspecialchars(trim($password));
        $password = str_replace(' ', '', $password);

        if (empty($password)) {

            $this->msg["id"] = "password";
            $this->msg["text"] = "Password cannot be empty.";
            $dataIsValid = false;
        }

        return $dataIsValid;
    }
}
