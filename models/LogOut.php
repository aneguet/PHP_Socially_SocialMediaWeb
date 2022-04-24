<?php
class LogOut
{
    public function __construct()
    {
    //Unset all session variables
    $_SESSION = array();

    //Destroy the session cookie
    if(isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    //Destroy the session
    session_destroy();
    }
}

?>