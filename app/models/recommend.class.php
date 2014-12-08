<?php

/**
 * User
 * TODO change from past project to incorporate needed functionality
 */
class Recommend extends CustomModel {


	public static function getRecs($users) {

		//insert array of users to get results TODO
		//then filter results by getting recipes that use only returned ingredients
		//BACKLOG: then filter based on order history

		//refined search: SELECT * FROM pizza_recipe_topping JOIN pizza_recipe USING (pizza_recipe_id) JOIN topping USING (topping_id) where topping_id IN (1,2)

		$getRecs =<<<sql
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
	}

}