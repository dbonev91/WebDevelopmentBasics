<?php
class Protector {
    private static $_instance = null;
    private static $_db = null;
    
    private function __construct () {
        self::$_db = new \GF\DB\SimpleDB();
    }
    
    public static function csrfProtectGenerator () {
        $_SESSION['CSRFToken'] = uniqid(mt_rand(), true);
        return $_SESSION['CSRFToken'];
    }
    
    public static function csrfChecker ($csrf) {
        if (!isset($_SESSION['CSRFToken']) || $csrf != $_SESSION['CSRFToken']) {
            throw new \Exception('Inavlid Request!');
            exit;
        }
    }
    
    public static function checkSessionToken () {
        $userData = self::$_db->prepare("SELECT username, id FROM blog_users WHERE username=?")->execute(array(self::returnValidUser()));
        $userData = $userData->fetchAllAssoc();
        $isValidToken = $_SESSION['sessionToken'] == self::createSessionToken($userData[0]['username'], $userData[0]['id']);
        if (!$isValidToken) {
            throw new \Exception("Invalid session token! Please logout and login again!");
        }
    }
    
    public static function createSessionToken ($username, $salt) {
        $saltedUsername = $salt . $username . $salt;
        $sessionToken = md5($saltedUsername);

        return $sessionToken;
    }
    
    public static function returnValidUser () {
        if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
            }
            else if (isset($_SESSION['admin'])) {
                $user = $_SESSION['admin'];
            }
        }
        else {
            throw new \Exception("You are not logged in!");
        }
        
        return $user;
    }
    
    public static function getInstance () {
        if (self::$_instance == null) {
            self::$_instance = new Protector();
        }
        
        return self::$_instance;
    }
}