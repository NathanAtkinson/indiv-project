<?php

/**
 * Adds topping dislike for user into DB
 */
 class Controller extends AjaxController {

	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }
        
		$user = new User(UserLogin::getUserID());
		$topping_id = $_POST['topping_id'];

		$topping = new Topping($topping_id);

		$input['user_id'] = $user->user_id;
		$input['topping_id'] = $topping_id;
		$topping->insert($input);

		$this->view['topping_id'] = $topping_id;
	}
}
$controller = new Controller();
