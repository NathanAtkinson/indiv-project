<?php

/**
 * User
 * TODO change from past project to incorporate needed functionality
 */
class Recommend extends CustomModel {


	public static function getRecs() {

		//insert array of users to get results TODO
		//then filter results by getting recipes that use only returned ingredients
		//BACKLOG: then filter based on order history

		$getRecs =<<<sql
        SELECT
            *
        FROM topping
        WHERE topping_id NOT IN 
        (SELECT 
        	topping_id
		FROM user
		JOIN user_topping_dislike USING (user_id)
		WHERE user_id IN (1,2,7))
		LIMIT 5;
sql;

        return db::execute($getRecs);
	}

}