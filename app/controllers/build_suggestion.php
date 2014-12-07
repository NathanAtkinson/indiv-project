<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {

		// More code could go here depending on what you want to do with this page



		$friend_populator = new FriendViewFragment();

		$friends_from_DB = User::getAll();

		while($friend = $friends_from_DB->fetch_assoc()) {
			$friend_populator->user_id = xss::protection($friend['user_id']);
			$friend_populator->user_name = xss::protection($friend['user_name']);
			$this->view->friends .= $friend_populator->render();
		}


		$topping_populator = new ToppingViewFragment();

		$toppings_from_DB = Topping::getAll();

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



<div class="primary-content">
	<div class="friends">
	<a href="/profile">BACK</a>
		<h3>Other Users:</h3>
		<?php echo $friends ?>
	</div>

	<div class="toppings">
		<h3>Other toppings you don't want this time:</h3>
		<?php echo $toppings ?>
		<a href="/suggestions" id="suggestions">Get suggestions</a>
	</div>

</div>