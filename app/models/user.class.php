<?php

/**
 * User
 */
class User extends Model {

	/**
	 * Insert User
	 */
	protected function insert($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you

		// Prepare SQL Values
		$sql_values = [
			'user_id' => $input['user_id'],
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'email' => $input['email'],
			'password' => $input['password'],
			'datetime_added' => 'NOW()'
		];

		// Ensure values are encompassed with quote marks
		$sql_values = db::auto_quote($sql_values, ['datetime_added']);

		// Insert
		$results = db::insert('user', $sql_values);
		
		// Return the Insert ID
		return $results->insert_id;

	}

	/**
	 * Update User
	 */
	public function update($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you

		// Prepare SQL Values
		$sql_values = [
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'email' => $input['email'],
			'password' => $input['password']
		];

		// Ensure values are encompassed with quote marks
		$sql_values = db::auto_quote($sql_values);

		// Update
		db::update('user', $sql_values, "WHERE user_id = {$this->user_id}");
		
		// Return a new instance of this user as an object
		return new User($this->user_id);

	}

}