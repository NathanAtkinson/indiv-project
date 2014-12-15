<?php

/**
 * User
 */
class User extends CustomModel {


	/*
	* Validation
	*/
	protected function validators() {
        return [
            'user_name' => [FILTER_CALLBACK,
                ['options' => function ($value) {
                    return (strlen($value) > 1) ? $value : false;
            }]],
            'user_id' => [FILTER_VALIDATE_INT],
            'password' => [FILTER_CALLBACK,
                ['options' => function ($value) {
                    return (strlen($value) > 5) ? $value : false;
            }]],
            'email' => [FILTER_VALIDATE_EMAIL]
        ];
    }

	/**
	 * Insert/Create new User
	 */
	protected function insert($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you
        $cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input/*, ['password']*/
        );

        

        /*if (is_string($cleanedInput)) {
            return null;
        }*/
        if (is_string($cleanedInput)) return null;
        

        $passwordInsert =<<<sql
        INSERT INTO 
        user (user_name, email, `password`)
        VALUES ({$cleanedInput['user_name']}, {$cleanedInput['email']},
        PASSWORD(CONCAT({$cleanedInput['user_name']}, {$cleanedInput['password']})));
sql;

        // Insert
        $results = db::execute($passwordInsert);

        // Return the Insert ID
        return $results->insert_id;
        
		// Prepare SQL Values
/*		$sql_values = [
			'user_id' => $input['user_id'],
			'user_name' => $input['user_name'],
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
*/
	}

	/**
	 * Update User
	 */
	public function update($input) {

		// Note that Server Side validation is not being done here
		// and should be implemented by you

        //TODO
    /*$cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input,
        );

        if (is_string($cleanedInput)) {
            return null;
        }*/

		// Prepare SQL Values
		$sql_values = [
			'user_name' => $input['user_name'],
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

	/*
	* Gets list of all users
	*/
	public static function getAll() {
        $getusers =<<<sql
        SELECT
            *
        FROM user;
sql;

        return db::execute($getusers);
    }


    /*
    * Checks if username and password are valid
    */
    public function isValid($input) {

        // validate user name, password
        $cleanedInput = $this->cleanInput(
            ['user_name', 'password'], 
            $input)
        ;

        if (is_string($cleanedInput)) return null;

        $sqlPasswordValidation =<<<sql
            SELECT user_id
            FROM user
            WHERE user_name = {$cleanedInput['user_name']}
            AND `password` =
            PASSWORD(CONCAT({$cleanedInput['user_name']},
                            {$cleanedInput['password']}));
sql;

        $result = db::execute($sqlPasswordValidation);
        $user = null;
        if ($row = $result->fetch_assoc()) {
            $user = new User($row['user_id']);
        }
        return $user;
    }


    //gets the user_name by using the user_id
    public function getUserName() {

        //TODO need to validate?  Getting user ID from object, not input

        $getUserName =<<<sql
        SELECT user_name
        FROM user
        WHERE user_id = {$this->user_id};
sql;

        $results = db::execute($getUserName);

        $user_name = null;
        if ($result = $results->fetch_assoc()) {
            $user_name = $result['user_name'];
        }
        return $user_name;
    }

//TODO need to finish this up to pull topping prefs for user
    public function getPreferences(){

        $getPreferences =<<<sql
        SELECT * 
        FROM user 
        JOIN user_topping_dislike USING (user_id)
        WHERE user_id = {$this->user_id}
sql;

        return db::execute($getPreferences);
    }
}