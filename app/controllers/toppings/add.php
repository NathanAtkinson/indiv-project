<?php

/**
 * Ajax Controller
 */
 class Controller extends AjaxController {

	protected function init() {

      $user = new User(UserLogin::getUserID());
      //TODO this isn't working to set the userID
      // $_POST['user_id'] = $user->user_id;

      $topping_id = $_POST['topping_id'];

      $topping = new Topping($topping_id);


      // $input = [$this->user_id, $topping_id];
      $topping->insert($_POST);
      
      $this->view['topping_id'] = $topping_id;
	}
}
$controller = new Controller();
