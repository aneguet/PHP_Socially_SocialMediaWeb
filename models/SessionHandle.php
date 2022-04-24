<?php
class SessionHandle
{
    public function __construct()
    {
        // session_start();
    }

    public function logged_in()
    {
        
        return isset($_SESSION['userId']);
    }

    public function confirm_logged_in()
    {
        if (!$this->logged_in()) {
            // $redirect = new Redirector("login.php");
            return true; //not logged in
        } else {
            $this->checkSessionTime();
            return false; //logged in
        }
    }

    public function checkSessionTime() {
        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 3600) {// 60min
            session_regenerate_id(true);  
            $_SESSION['CREATED'] = time();  // update creation time
        }
    }
}
