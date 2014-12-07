<?php

/**
* TODO change from past project
 * Topping
 */
class Topping extends CustomModel {

	/**
	 * Insert Topping - no user can input a topping
	 */
	protected function insert($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you

		// Prepare SQL Values
		$sql_values = [
			'name' => $input['name']
		];

		// Ensure values are encompassed with quote marks
		$sql_values = db::auto_quote($sql_values, ['datetime_added']);

		// Insert
		$results = db::insert('topping', $sql_values);
		
		// Return the Insert ID
		return $results->insert_id;
	}

	/**
	 * Update Topping - won't be done by user...  TODO
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
    * return all toppings 
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