<?php

/**
 * Ajax Controller
 */
 class Controller extends AjaxController {

	protected function init() {

      //TODO need to clean input/output.  Currently works with removal

      $user = new User(UserLogin::getUserID());
      // $_POST['user_id'] = $user->user_id;

      /*$topping_id = $_POST['topping_id'];
      $user_id = $_POST['user_id'];*/


      $topping = new Topping($topping_id);


      $input = [$user_id, $topping_id];
      // print_r($_POST);
      $topping->remove($_POST);
      // $this->view['message'] = 'success';
      
	}
}
$controller = new Controller();
