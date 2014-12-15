<?php

/**
 * Downvote recipe
 */
 class Controller extends AjaxController {

	protected function init() {

      $user = new User(UserLogin::getUserID());
      $user_ids = $_POST['user_ids'];
      $pizza_recipe_id = $_POST['pizza_recipe_id'];
      $array_user_ids = explode(",", $user_ids);

      $recommend = new Recommend();
      //downVote the recipe_id for each user in suggestion
      foreach ($array_user_ids as $index => $user_id) {
            $input['user_id'] = $user_id;
            $input['recipe_id'] = $pizza_recipe_id;
            $recommend->downVote($input);
      }
      
      $this->view['pizza_recipe_id'] = $pizza_recipe_id;
      $this->view['user_ids'] = $user_ids;

	}
}
$controller = new Controller();
