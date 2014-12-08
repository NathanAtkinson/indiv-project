<?php


//TODO may not implement this, because then have to implement remove dislikes if they're unselected
// May be easier to do 2 page process?
// Profile Page Controller
class Controller extends AjaxController {
	protected function init() {

		$user_id = $_POST($user_id);
		$user = new User($user_id);

		//gets votes that user has made in the past
		$user_dislikes = $user->getPreferences();
		while ($row = $user_dislikes->fetch_assoc()){
			$dislikes[] = ['topping_id'=>$row['topping_id']];
		}
	    //pass the results to payload so that jQuery can use them 
	    //to select the dropdowns.
		// Payload::add('dislikes', $dislikes);
		
		$this->view['dislikes-object'] = $user_dislikes;
		$this->view['dislikes'] = $dislikes;
		exit();
	}

}
$controller = new Controller();
