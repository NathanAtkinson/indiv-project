<?php 

/*
* Logs in user
*/

class Controller extends AjaxController {
    protected function init() {

        //if there's an e-mail, this is for signing up a new user
        if($_POST['email']){
            $user = new User($_POST);
        } 

        //otherwise logging in.  Check credentials
        else {
            $user_id = $_POST['user_id'];
            $user = (new User())->isValid($_POST);
        }

        //Is there's a user object, redirect to profile with the id.
        if($user){
            $this->view['redirect'] = '/profile?user_id=' . $user->user_id;
            UserLogin::logIn($user->user_id);
        
        //otherwise pass back error message
        } else {
            $this->view['errormsg'] = 'Please enter a valid User Name and Password.';
        }
        exit();
    }
}

$controller = new Controller();