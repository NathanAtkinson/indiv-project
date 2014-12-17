<?php

/**
 * Adds order to DB
 */
 class Controller extends AjaxController {

	protected function init() {

      if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
      }

      //gets ID of user logged in
      $user = new User(UserLogin::getUserID());

      //gets id's of all users in suggestion
      $user_ids = $_POST['user_ids'];

      //gets the recipe_id to be added to DB
      $pizza_recipe_id = $_POST['pizza_recipe_id'];
      $array_user_ids = explode(",", $user_ids);

      $recommend = new Recommend();

      //enters into DB the order for each user
      foreach ($array_user_ids as $index => $user_id) {
            $input['user_id'] = $user_id;
            $input['recipe_id'] = $pizza_recipe_id;
            $recommend->addOrder($input);
      }

      //enters into DB an upvote for each user
      foreach ($array_user_ids as $index => $user_id) {
            $input['user_id'] = $user_id;
            $input['recipe_id'] = $pizza_recipe_id;
            $recommend->upVote($input);
      }
      
      $this->view['pizza_recipe_id'] = $pizza_recipe_id;
      $this->view['user_ids'] = $user_ids;

	}
}
$controller = new Controller();
