<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {


		$user_id = UserLogin::getUserID();
		$user = new User($user_id);



		//TODO need to build array here.  
		// $users = [1,7,8];
		$users = $_POST['user-ids'];
		$users .= "," . $user_id;
		// $users .= 5;

		//builds a string of the users so that query can work
		// foreach ($users as $key => $value) {
		// 	$sqlArray .= $value . ",";
		// 	# code...
		// }
		//removes the extra "," that's not needed in the string
		// $sqlArray = substr($sqlArray, 0, -1);
		$suggestion_populator = new SuggestionViewFragment();

		$suggestions_from_DB = Recommend::getRecs($users);

		while($suggestion = $suggestions_from_DB->fetch_assoc()) {
			$suggestion_populator->topping_id = xss::protection($suggestion['topping_id']);
			$suggestion_populator->name = xss::protection($suggestion['name']);
			$this->view->suggestions .= $suggestion_populator->render();
		}
	}

}
$controller = new Controller();

// Extract Main Controler Vars
extract($controller->view->vars);

?>

<nav>
	<a href="/build">BACK</a>
	<a id="sign-out" href="/">SIGN OUT</a>
</nav>
<div class="suggestions">
	<?php echo $suggestions ?>
</div>