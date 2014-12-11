<?php

/**
 * User
 * TODO change from past project to incorporate needed functionality
 */
class Recommend extends CustomModel {

	protected function insert(){

	}

	//gets dislikes from a string of users
	public function getDislikes($users) {

		//TODO
		/*$cleanedInput = $this->cleanInput(
            ['users'],
            $input
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		$getDislikes =<<<sql
        SELECT *
        FROM topping
        WHERE topping_id IN 
        (SELECT 
        	topping_id
		FROM user
		JOIN user_topping_dislike USING (user_id)
		WHERE user_id IN ({$users}));
sql;
		return db::execute($getDislikes);
		
	}

	public  function getExemptRecipes($toppings) {
		// gets topping dislikes

		//TODO
		/*$cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input,
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		$getExemptRecipes =<<<sql
        SELECT * 
        FROM pizza_recipe_topping 
        JOIN pizza_recipe USING (pizza_recipe_id) 
        JOIN topping USING (topping_id) 
        WHERE topping_id IN ({$toppings})
        GROUP BY pizza_recipe_id
sql;
		return db::execute($getExemptRecipes);
		
	}





	public  function globalSuggestions($recipe_ids) {

		//TODO how should I extract or build the array of users for below query?
		//TODO
	/*$cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input,
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		$globalSuggestions =<<<sql
		SELECT user_id, pizza_recipe_id, name, sum(vote_total) as total
        FROM pizza_recipe
        LEFT JOIN user_pizza_vote USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
        WHERE pizza_recipe_id NOT IN ({$recipe_ids})
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;


		return db::execute($globalSuggestions);
	}

	public  function userSuggestions($user_ids, $recipe_ids) {

		//TODO
	/*$cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input,
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		$userSuggestions =<<<sql
		SELECT user_id, pizza_recipe_id, name, sum(vote_total) as total
        FROM pizza_recipe
        LEFT JOIN user_pizza_vote USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
		where user_id IN ({$user_ids})
		and pizza_recipe_id NOT IN ({$recipe_ids})
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;
		return db::execute($userSuggestions);
	}

	
		

	public  function indifferentSuggestion() {

		$indifferentSuggestions =<<<sql
		SELECT user_id, pizza_recipe_id, name, sum(vote_total) as total
        FROM pizza_recipe
        LEFT JOIN user_pizza_vote USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;

		return db::execute($indifferentSuggestions);
	}




	public  function getPastOrders($user_ids, $exemptRecipes) {

		//TODO
	/*$cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input,
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		$getPastOrders =<<<sql
		SELECT pizza_recipe_id, sum(pizza_recipe_id) as total
		FROM past_order
		JOIN user USING (user_id)
		JOIN pizza_recipe USING (pizza_recipe_id)
		WHERE user_id IN ({$user_ids})
sql;
		// AND pizza_recipe_id NOT IN ({$exemptRecipes})

		return db::execute($getPastOrders);
	}



	// add to DB good recommendations
	public function addOrder($user_id, $pizza_recipe_id) {

		// $cleanedInput = $this->cleanInput(
  //           ['user_id', 'pizza_recipe_id'],
  //           $input
  //       );

  //       if (is_string($cleanedInput)) {
  //           return null;
  //       }

		$addOrders =<<<sql
		INSERT INTO 
		past_order
		(`user_id`, `pizza_recipe_id`, `timestamp`) 
		VALUES ('{$user_id}', '{$pizza_recipe_id}', CURRENT_TIMESTAMP);
sql;
		// AND pizza_recipe_id NOT IN ({$exemptRecipes})

		db::execute($addOrders);
	}


	//when user selects "good" suggestion, upvotes to keep track
	public static function upVote($user_id, $pizza_recipe_id) {

		// $cleanedInput = $this->cleanInput(
  //           ['user_id', 'pizza_recipe_id'],
  //           $input
  //       );

  //       if (is_string($cleanedInput)) {
  //           return null;
  //       }

		$upVote =<<<sql
		INSERT INTO user_pizza_vote
		(`user_id`, `pizza_recipe_id`, `vote_total`) 
		VALUES ('{$user_id}', '{$pizza_recipe_id}', 1)
		ON DUPLICATE KEY UPDATE
		vote_total=vote_total + 1
sql;

		db::execute($upVote);
	}




	public static function downVote($user_id, $pizza_recipe_id) {

		// $cleanedInput = $this->cleanInput(
  //           ['user_id', 'pizza_recipe_id'],
  //           $input
  //       );

  //       if (is_string($cleanedInput)) {
  //           return null;
  //       }

		$downVote =<<<sql
		INSERT INTO user_pizza_vote
		(`user_id`, `pizza_recipe_id`, `vote_total`) 
		VALUES ('{$user_id}', '{$pizza_recipe_id}', -1)
		ON DUPLICATE KEY UPDATE
		vote_total=vote_total -1
sql;

		db::execute($downVote);
	}
	




	//past query, to save for now
	/*$getRecs =<<<sql
        SELECT
            *
        FROM topping
        WHERE topping_id NOT IN 
        (SELECT 
        	topping_id
		FROM user
		JOIN user_topping_dislike USING (user_id)
		WHERE user_id IN ({$users}))
		LIMIT 5;
sql;

        return db::execute($getRecs);
	}*/

}