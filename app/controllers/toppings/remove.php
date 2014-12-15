<?php

/**
 * Removes a dislike for current user from DB
 */
 class Controller extends AjaxController {

	protected function init() {

      $user = new User(UserLogin::getUserID());

      $topping = new Topping($topping_id);

      $input['user_id'] = $user->user_id;
      $input['topping_id'] = $topping_id;
      $topping->remove($_POST);
	}
}
$controller = new Controller();
