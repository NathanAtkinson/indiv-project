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
		$this->view->profile = $profile_creator->render();

		//gets list of toppings from DB
		$toppings_from_DB = Topping::getAll();

		//Creates object to populate the topping fragments
		$topping_populator = new ToppingViewFragment();
		//Uses results from DB to dynamically create with topping_id and name
		while($topping = $toppings_from_DB->fetch_assoc()) {
			$topping_populator->topping_id = xss::protection($topping['topping_id']);
			$topping_populator->name = xss::protection($topping['name']);
			$this->view->toppings .= $topping_populator->render();
		}
	}
}
$controller = new Controller();

extract($controller->view->vars);
?>

<div class="primary-content">
	<nav>
		<a id="not-semantic TODO coupons" href="/coupons" style="padding: 0; border: 0;"></a>
		<a id="build-suggestion" href="/build">Build Suggestion</a>
		<a id="sign-out" href="/logout">SIGN OUT</a>
	</nav>

	<?php echo $profile ?>

	<div class="user toppings">
		<h3><?php echo $user_name ?>'s Dislikes:</h3>
		<?php echo $toppings ?>
	</div>
</div>