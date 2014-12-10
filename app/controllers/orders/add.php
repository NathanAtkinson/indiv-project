<?php

/**
 * Ajax Controller
 */
 class Controller extends AjaxController {

	protected function init() {

      $user = new User(UserLogin::getUserID());
      //TODO this isn't working to set the userID
      $user_ids = $_POST['user_ids'];
      $pizza_recipe_id = $_POST['pizza_recipe_id'];
      $array_user_ids = explode(",", $user_ids);

      foreach ($array_user_ids as $index => $user_id) {
            Recommend::addOrder($user_id, $pizza_recipe_id);
      }
      
      $this->view['pizza_recipe_id'] = $pizza_recipe_id;
      $this->view['user_ids'] = $user_ids;

	}
}
$controller = new Controller();
