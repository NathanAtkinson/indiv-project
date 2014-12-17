<?php

/*
* Profile Page Controller
*/
class Controller extends AppController {
	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

		$user_id = UserLogin::getUserID();
		$user = new User($user_id);

		$user_name = $user->getUserName();
		$this->view->user_name = $user_name;
		$location = $user->getLocation();

		//gets votes that user has made in the past
		$user_dislikes = $user->getPreferences();
		while ($row = $user_dislikes->fetch_assoc()){
			$dislikes[] = ['topping_id'=>$row['topping_id']];
		}

	    //pass the results to payload so that jQuery can use them 
	    //to select the dropdowns.
		Payload::add('dislikes', $dislikes);

		//creates profile section of page passing in identifying info
		$profile_creator = new ProfileViewFragment();
		$profile_creator->user_name = xss::protection($user_name);
		$profile_creator->picture_id = xss::protection($user_id);
		$profile_creator->user_id = xss::protection($user_id);
		if(empty($location)){
			$profile_creator->location = "";
		} else {
			$profile_creator->location = xss::protection($location);
		}
		$this->view->profile = $profile_creator->render();

		$this->view->user_id = $user->user_id;
		$this->view->password = $user->password;
		$this->view->email = $user->email;
		$this->view->location = $user->location;
		
	}
}
$controller = new Controller();

extract($controller->view->vars);
?>

<div class="primary-content">
	<nav>
		<a id="" href="/profile">Back</a>
		<a id="sign-out" href="/logout">SIGN OUT</a>

	</nav>

	<?php echo $profile ?>
	<div class="update-form">
		<form action="/update" class="reptile-form">
			<input class="user_id" type="hidden" name="user_id"  value="<?php echo $user_id?>">
			<!-- <input class="email" type="email" name="email" title="E-mail" data-exp-name="email" value="<?php echo $email; ?>"> -->
			<input class="location" type="text" name="location" title="Location" data-exp-name="location" value="<?php echo $location; ?>">
			<button class="submit">Submit Changes</button>
		</form>
	</div>
</div>