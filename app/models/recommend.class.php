<?php

/**
 * User
 * TODO change from past project to incorporate needed functionality
 */
class Recommend extends CustomModel {

	//gets dislikes from a string of users
	public static function getDislikes($users) {
		// gets topping dislikes
		//TODO
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

	public static function getExemptRecipes($toppings) {
		// gets topping dislikes
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





	public static function globalSuggestions($recipe_ids) {

		//TODO how should I extract or build the array of users for below query?


		$globalSuggestions =<<<sql
		SELECT user_id, pizza_recipe_id, name, count(pizza_recipe_id) as total
        FROM pizza_recipe
        LEFT JOIN past_order USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
        WHERE pizza_recipe_id NOT IN ({$recipe_ids})
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;

		return db::execute($globalSuggestions);
	}

	public static function userSuggestions($user_ids, $recipe_ids) {

		$userSuggestions =<<<sql
		SELECT user_id, pizza_recipe_id, name, count(pizza_recipe_id) as total
        FROM pizza_recipe
        LEFT JOIN past_order USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
		where user_id IN ({$user_ids})
		and pizza_recipe_id NOT IN ({$recipe_ids})
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;
		return db::execute($userSuggestions);
	}

	
		

	public static function indifferentSuggestion() {

		//TODO how should I extract or build the array of users for below query?


		$getGoodRecipes =<<<sql
		SELECT user_id, pizza_recipe_id, name, count(pizza_recipe_id) as total
        FROM pizza_recipe
        LEFT JOIN past_order USING (pizza_recipe_id)
        LEFT JOIN `user` USING (user_id)
        GROUP BY pizza_recipe_id
        ORDER BY total DESC
sql;

		return db::execute($getGoodRecipes);
	}




	public static function getPastOrders($user_ids, $exemptRecipes) {

		$getPastOrders =<<<sql
		SELECT pizza_recipe_id, count(pizza_recipe_id) as total
		FROM past_order
		JOIN user USING (user_id)
		JOIN pizza_recipe USING (pizza_recipe_id)
		WHERE user_id IN ({$user_ids})
sql;
		// AND pizza_recipe_id NOT IN ({$exemptRecipes})

		return db::execute($getPastOrders);
	}



	// add to DB good recommendations
	public static function addOrder($user_id, $pizza_recipe_id) {

		$addOrders =<<<sql
		INSERT INTO 
		past_order
		(`user_id`, `pizza_recipe_id`, `timestamp`) 
		VALUES ('{$user_id}', '{$pizza_recipe_id}', CURRENT_TIMESTAMP);
sql;
		// AND pizza_recipe_id NOT IN ({$exemptRecipes})

		db::execute($addOrders);
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