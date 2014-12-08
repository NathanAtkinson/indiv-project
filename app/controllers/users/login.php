<?php 

class Controller extends AjaxController {
    protected function init() {
        // if($_POST['email']){
        //     $user = new User($_POST);
        // } 
        // else {
            $user_id = $_POST['user_id'];
            $user = (new User())->isValid($_POST);
        // }

        if($user){
            $this->view['redirect'] = '/profile?user_id=' . $user->user_id;
            UserLogin::logIn($user->user_id);
        } else {
            $this->view['redirect'] = '/';
            $this->view['errormsg'] = 'Please enter a valid User Name and Password.';
        }
        exit();
    }
}

$controller = new Controller();