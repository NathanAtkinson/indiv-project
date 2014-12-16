<?php

/**
 * Topping Class - Adds/Removes dislikes, retrieves same info
 */
class Topping extends CustomModel {

	/*
	* Validation
	*/
	protected function validators() {
        return [
            'user_id' => [FILTER_VALIDATE_INT, ['min_range' => 0]],
            'topping_id' => [FILTER_VALIDATE_INT, ['min_range' => 0]]
        ];
    }


	//Insert Topping Dislike
	public function insert($input) {

        $cleanedInput = $this->cleanInput(
            ['user_id', 'topping_id'],
            $input
        );
        
        if (is_string($cleanedInput)) return null;

		db::insert('user_topping_dislike', $cleanedInput);
	}


	//Removes a topping dislike
	public function remove($input) {

		$cleanedInput = $this->cleanInput(
            ['user_id', 'topping_id'],
            $input
        );

        if (is_string($cleanedInput)) return null;

		$removeDislike =<<<sql
        DELETE
        FROM user_topping_dislike
        WHERE user_id = {$cleanedInput['user_id']}
        AND topping_id = {$cleanedInput['topping_id']}
		LIMIT 1;
sql;

		db::execute($removeDislike);
	}


	//return list of all toppings  (name and id)
    public static function getAll() {

        $gettoppings =<<<sql
        SELECT
            *
        FROM topping;
sql;

        return db::execute($gettoppings);
    }
}