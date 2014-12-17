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
            'email' => [FILTER_VALIDATE_EMAIL],
            'location' => [FILTER_SANITIZE_STRING]
        ];
    }

	/**
	 * Insert/Create new User
	 */
	protected function insert($input) {

        $cleanedInput = $this->cleanInput(
            ['user_name', 'email', 'password'],
            $input/*, ['password']*/
        );

        if (is_string($cleanedInput)) return null;

        $passwordInsert =<<<sql
        INSERT INTO 
        user (user_name, email, `password`)
        VALUES ({$cleanedInput['user_name']}, {$cleanedInput['email']},
        PASSWORD(CONCAT({$cleanedInput['user_name']}, {$cleanedInput['password']})));
sql;

        $results = db::execute($passwordInsert);

        // Return the Insert ID
        return $results->insert_id;
	}

	//Update User - currently not utilized TODO
	public function update($input) {


        $cleanedInput = $this->cleanInput(
            ['email', 'location'],
            $input
        );

        if (is_string($cleanedInput)) return null;
        
		// Update
		db::update('user', $cleanedInput, "WHERE user_id = {$this->user_id}");
		
		// // Return a new instance of this user as an object
		return new User($this->user_id);

	}

	//Gets list of all users
	public static function getAll() {
        $getusers =<<<sql
        SELECT
            *
        FROM user;
sql;

        return db::execute($getusers);
    }


    //Checks if username and password are valid
    public function isValid($input) {

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

        //sets user to null, then if there's a record, sets user to DB return
        $user = null;
        if ($row = $result->fetch_assoc()) {
            $user = new User($row['user_id']);
        }
        return $user;
    }


    //gets the user_name by using the user_id
    public function getUserName() {

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



    //gets the location by using the user_id
    public function getLocation() {

        $getUserName =<<<sql
        SELECT location
        FROM user
        WHERE user_id = {$this->user_id};
sql;

        $results = db::execute($getUserName);

        if ($result = $results->fetch_assoc()) {
            return $result['location'];
        }
    }

    
    //pull topping prefs for user
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