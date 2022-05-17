<?php
require_once 'init.php';

class Session {

    private $userid;
    private $usertype;
    private $logged_in_user = false; 
    
    
    

    function __construct() {
        ob_start();
        session_start();
        $this->check_loginuser();
    }

    /*-------------------BELOW ARE SESSION CODES FOR  ACCOUNT
    public function loginaccount($account) { 
        if ($account) {
            $this->accountid = $_SESSION['accountid'] = $account->id;
            $this->logged_in_account = true;
            return true;
        } else {
            return false;
        }
    }

    private function check_loginaccount() {
        if (isset($_SESSION['accountid'])) {
            $this->accountid = $_SESSION['accountid'];
            $this->logged_in_account = true;
        } else {
            unset($this->accountid);
            $this->logged_in_account = false;
        }
    }

    public function is_logged_in_account() {
        return $this->logged_in_account;
    }

    public function getaccountid() {
        return $this->accountid;
    }

    public function logoutaccount() {
        unset($_SESSION['accountid']);
        unset($this->accountid);
        $this->logged_in_account = false;
    }
    */


      //-------------------BELOW ARE SESSION CODES FOR  ADMIN
    public function loginuser($user) { 
        if ($user) {
            $this->userid = $_SESSION['userid'] = $user->userid;
            $this->usertype = $_SESSION['usertype'] = $user->usertype;
            $this->logged_in_user = true;
            return true;
        } else {
            return false;
        }
    }

    private function check_loginuser() {
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
            $this->logged_in_user = true;
        } else {
            unset($this->userid);
            $this->logged_in_user = false;
        }
    }

    public function is_logged_in_user() {
        return $this->logged_in_user;
    }

    public function getuserid() {
        return $this->userid;
    }
    
    public function getusertype() {
        return $this->usertype;
    }

    public function logoutuser() {
        unset($_SESSION['userid']);
        unset($this->userid);
        $this->logged_in_user = false;
    }
    
    
    //-------------------BELOW ARE SESSION CODES FOR PRODUCT ID
    public function setcprodid($cprod) {
        if ($cprod) {
            $this->cprodid = $_SESSION['cprodid'] = $cprod->cprodid;
            $this->setted_cprodid = true;
            return true;
        } else {
            return false;
        }
    }

    private function check_ifsetcprodid() {
        if (isset($_SESSION['cprodid'])) {
            $this->cprodid = $_SESSION['cprodid'];
            $this->setted_cprodid = true;
        } else {
            unset($this->cprodid);
            $this->setted_cprodid = false;
        }
    }

    public function is_setted_cprodid() {
        return $this->setted_cprodid;
    }

    public function getcprodid() {
        return $this->cprodid;
    }

    public function unsetcprodid() {
        unset($_SESSION['cprodid']);
        unset($this->cprodid);
        $this->setted_cprodid = false;
    }

}

$session = new Session();
