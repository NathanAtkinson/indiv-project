<?php

/*
* Used to retrieve dislikes of a user.  Passed back and then put into
* payload, which can then be used by jQ to reflect user's dislikes.
*/
class Controller extends AjaxController {
	protected function init() {

		$user_id = $_POST($user_id);
		$user = new User($user_id);

		//gets dislikes that user has made in the past
		$user_dislikes = $user->getPreferences();
		while ($row = $user_dislikes->fetch_assoc()){
			$dislikes[] = ['topping_id'=>$row['topping_id']];
		}

	    //pass the results back
		$this->view['dislikes-object'] = $user_dislikes;
		$this->view['dislikes'] = $dislikes;
		exit();
	}
}
$controller = new Controller();
