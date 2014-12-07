<?php 

class UserLogin{

    public static function logIn ($user_id){    
        $_SESSION['logged_user'] = $user_id;
    }

    public static function isLogged(){
        return is_numeric($_SESSION['logged_user']);
    }

    public static function logOut(){
        unset($_SESSION['logged_user']);
    }

    public static function getUserID(){
        return $_SESSION['logged_user'];
    }
}