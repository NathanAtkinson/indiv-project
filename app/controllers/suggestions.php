<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {


		$user_id = UserLogin::getUserID();
		$user = new User($user_id);

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

		//Builds string for mySQL here.  
		//If no extra users were selected, then just uses current user_id
		if ($_POST['user-ids'] != "") {
			$users = $_POST['user-ids'];
			$users .= "," . $user_id;
		} else {
			$users = $user_id;
		}

		$this->view->users = $users;

	
		$results = Recommend::getDislikes($users);
		$disliked_toppings = "";
		while ($row = $results->fetch_assoc()) {
			$disliked_toppings .= $row['topping_id'];
			$disliked_toppings .= ",";
		}
		
		
		

		if ($_POST['topping-ids'] != "") {
			$toppings = $_POST['topping-ids'];
			$disliked_toppings .= $toppings;
		} else {
			// removes extra ,
			$disliked_toppings = substr($disliked_toppings, 0, -1);
		}

	/*	echo "disliked_toppings";
		print_r($disliked_toppings);*/
		


		// $users .= 5;

		//builds a string of the users so that query can work
		// foreach ($users as $key => $value) {
		// 	$sqlArray .= $value . ",";
		// 	# code...
		// }
		//removes the extra "," that's not needed in the string
		// $sqlArray = substr($sqlArray, 0, -1);

		$badRecipes = Recommend::getBadRecipes($disliked_toppings);

		$badRecipesList = "";
		while ($row = $badRecipes->fetch_assoc()) {
			$badRecipesList .= $row['pizza_recipe_id'];
			$badRecipesList .= ",";
		}


		$badRecipesList = substr($badRecipesList, 0, -1);

		/*echo "badRecipesList";
		print_r($badRecipesList);*/

		$goodRecipesfromDB = Recommend::getGoodRecipes($badRecipesList);

		// $goodRecipesList = "";
		// while ($row = $goodRecipes->fetch_assoc()) {
		// 	$goodRecipesList .= $row['pizza_recipe_id'];
		// 	$goodRecipesList .= ",";
		// }

		// $goodRecipesList = substr($goodRecipesList, 0, -1);


		$suggestion_populator = new SuggestionViewFragment();

		while($suggestion = $goodRecipesfromDB->fetch_assoc()) {
			$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
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
<div class="suggestions" data-user-ids="<?php echo $users ?>">
	<?php echo $suggestions ?>
</div>