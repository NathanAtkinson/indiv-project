<?php

/**
 * Topping
 */
class Topping extends CustomModel {

	/**
	 * Insert Topping Dislike
	 */
	public function insert($input) {

		// Prepare SQL Values
        // $cleanedInput = $this->cleanInput(
        //     ['user_id', 'topping_id'],
        //     $input
        // );

        // if (is_string($cleanedInput)) return null;

		// db::insert('user_topping_dislike', $cleanedInput);
		db::insert('user_topping_dislike', $input);
	}


	/*
	* Removes a topping dislike
	*/
	public function remove($input) {

		$user_id = $input['user_id'];
		$topping_id = $input['topping_id'];
		/*
		$cleanedInput = $this->cleanInput(
            ['user_id', 'topping_id'],
            $input
        );

        if (is_string($cleanedInput)) return null;*/

		$removeDislike =<<<sql
        DELETE
        FROM user_topping_dislike
        WHERE user_id = {$user_id}
        AND topping_id = {$topping_id}
		LIMIT 1;
sql;

		db::execute($removeDislike);
	}


	/**
	 * Update Topping - won't be done by user...  TODO  probably remove
	 */
	public function update($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you

		// Prepare SQL Values
		$sql_values = [
		
		];

		// Ensure values are encompassed with quote marks
		$sql_values = db::auto_quote($sql_values);

		// Update
		db::update('topping', $sql_values, "WHERE topping_id = {$this->topping_id}");
		
		// Return a new instance of this Topping as an object
		return new Topping($this->Topping_id);

	}

	
	/*
    * return list of all toppings  (name and id)
    */ 
    public static function getAll() {
        $gettoppings =<<<sql
        SELECT
            *
        FROM topping;
sql;

        return db::execute($gettoppings);
    }

}