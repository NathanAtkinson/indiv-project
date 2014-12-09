<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {

		$user_id = UserLogin::getUserID();
		$user = new User($user_id);

		// $this->view->user_name = 'Username here';
		$user_name = $user->getUserName();



		//gets votes that user has made in the past
		$user_dislikes = $user->getPreferences();
		while ($row = $user_dislikes->fetch_assoc()){
			$dislikes[] = ['topping_id'=>$row['topping_id']];
		}
	    //pass the results to payload so that jQuery can use them 
	    //to select the dropdowns.
		Payload::add('dislikes', $dislikes);
		

		$profile_creator = new ProfileViewFragment();
		$profile_creator->user_name = xss::protection($user_name);
		$profile_creator->user_id = xss::protection($user_id);
		$this->view->profile = $profile_creator->render();


		//gets list of toppings from DB
		$toppings_from_DB = Topping::getAll();

		$topping_populator = new ToppingViewFragment();
		//Creates object to populate the topping fragments
		//Uses results from DB to dynamically create with ID and name
		while($topping = $toppings_from_DB->fetch_assoc()) {
			$topping_populator->topping_id = xss::protection($topping['topping_id']);
			$topping_populator->name = xss::protection($topping['name']);
			$this->view->toppings .= $topping_populator->render();
		}

	}

}
$controller = new Controller();

// Extract Main Controler Vars
extract($controller->view->vars);

?>
	<nav>
		<a id="build-suggestion" href="/build">Build Suggestion</a>
		<a id="sign-out" href="/">SIGN OUT</a>
	</nav>

	<?php echo $profile ?>
	<!-- <div class="this-user">
		<div class="profile-info">
			<div class="image">image here</div>
			<h3><?php echo $user_name ?></h3>
			<img src="" alt="">
		</div>
		<a id="build-suggestion" href="/build">Build Suggestion</a>
	</div> -->


<div class="user toppings">
	<h3>My Dislikes:</h3>
	<?php echo $toppings ?>
	
</div>