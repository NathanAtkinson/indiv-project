<?php

// Build Suggestion Controller
class Controller extends AppController {
	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

		$user_id = UserLogin::getUserID();
		$user = new User($user_id);

		//gets dislikes that user has made in the past
		$user_dislikes = $user->getPreferences();
		while ($row = $user_dislikes->fetch_assoc()){
			$dislikes[] = ['topping_id'=>$row['topping_id']];
		}

	    //pass the results to payload so that jQuery can use them 
	    //to select the dropdowns.
		Payload::add('dislikes', $dislikes);

		//gets all users (currently) in DB and builds friend fragments
		$friend_populator = new FriendViewFragment();
		$friends_from_DB = User::getAll();
		while($friend = $friends_from_DB->fetch_assoc()) {
			//skips if current user
			if ($user_id === $friend['user_id']) {
				continue;
			};
			$friend_populator->user_id = xss::protection($friend['user_id']);
			$friend_populator->user_name = xss::protection($friend['user_name']);
			$friend_populator->hidden = $isSameUser ? '' : 'hidden';
			$this->view->friends .= $friend_populator->render();
		}

		//gets from DB toppings list and creates fragments
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

extract($controller->view->vars);
?>

<div class="primary-content">
	<nav>
		<a href="/profile">BACK</a>
		<a id="sign-out" href="/logout">SIGN OUT</a>
	</nav>
	<div class="friends">
		<h3>Other Users:</h3>
		<?php echo $friends ?>
		<form action="/suggestions" method="POST">
			<input type="hidden" name="user-ids" id="user-ids">
			<input type="hidden" name="topping-ids" id="topping-ids">
			<button id="suggestions">Get suggestions</button>
		</form>
	</div>
	<div class="build toppings">
		<h3>Other toppings you don't want this time:</h3>
		<?php echo $toppings ?>
	</div>
</div>