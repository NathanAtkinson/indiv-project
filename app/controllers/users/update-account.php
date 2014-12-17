<?php

/*
* Used to update a user.
*/
class Controller extends AjaxController {
	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

        $user_id = UserLogin::getUserID();
		$user = new User($user_id);

		$input = $_POST;

		//sends update info to method
		$results = $user->update($input);

	    //redirect
		$this->view['redirect'] = '/profile';
		exit();
	}
}
$controller = new Controller();
