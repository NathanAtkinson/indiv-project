<?php 

/*
* Handles Login of user, etc
*/
class UserLogin{

    //Logs user in
    public static function logIn ($user_id){    
        $_SESSION['logged_user'] = $user_id;
    }

    //Verify user is logged in
    public static function isLogged(){
        return is_numeric($_SESSION['logged_user']);
    }

    //logs user out
    public static function logOut(){
        unset($_SESSION['logged_user']);
    }

    //returns user_id
    public static function getUserID(){
        return $_SESSION['logged_user'];
    }
}