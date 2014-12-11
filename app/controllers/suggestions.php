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

	
		//gets dislikes based on the user id's and compiles a string
		$results = Recommend::getDislikes($users);
		$disliked_toppings = "";
		while ($row = $results->fetch_assoc()) {
			$disliked_toppings .= $row['topping_id'];
			$disliked_toppings .= ",";
			/*echo "\ndisliked toppings: ";
			print_r($disliked_toppings);*/
		}
		
		
		//if 1x dislikes included, appends to string of the list.  Otherwise, removes
		//extra "," from the string
		if ($_POST['topping-ids'] != "") {
			$toppings = $_POST['topping-ids'];
			$disliked_toppings .= $toppings;
			/*echo "\n topping-ids present";
			print_r($disliked_toppings);*/
		} else {
			$disliked_toppings = substr($disliked_toppings, 0, -1);
			/*echo "\n no topping-ids";
			print_r($disliked_toppings);*/
		}


		// checks if there are dislikes, if not, user is indifferent and runs query reflecting that
		if(empty($disliked_toppings)) {
			//get all recipes ranked based on no dislikes
			// $goodRecipesfromDB = Recommend::globalSuggestions($users);
			$goodRecipesfromDB = Recommend::indifferentSuggestion($users);
		} else {
			//get list of recipes exempted by topping dislikes
			$exemptRecipes = Recommend::getExemptRecipes($disliked_toppings);


			$exemptRecipesList = "";
			while ($row = $exemptRecipes->fetch_assoc()) {
				$exemptRecipesList .= $row['pizza_recipe_id'];
				$exemptRecipesList .= ",";
			}

			//removes the extra "," that's not needed in the string
			while(substr($exemptRecipesList, -1) == ","){
		 		$exemptRecipesList = substr($exemptRecipesList, 0, -1);
			}
			// echo ('badrecipelist:');
			// print_r($exemptRecipesList);

			// $goodRecipesfromDB = Recommend::globalSuggestions($exemptRecipesList);
			$goodRecipesfromDB = Recommend::userSuggestions($users, $exemptRecipesList);
			/*echo ('goodRecipes from DB:');
			print_r($goodRecipesfromDB);*/
		}

		$suggestion_populator = new SuggestionViewFragment();
		
		$max_suggestions = 7;
		$suggestion_count = 0;

		//had to put () around suggestoin/fetch assoc
		while(($suggestion = $goodRecipesfromDB->fetch_assoc()) && $suggestion_count < $max_suggestions) {
			/*echo('inside while');
			echo("pizzaId:" . $suggestion['pizza_recipe_id']);*/
			$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
			$suggestion_populator->name = xss::protection($suggestion['name']);
			$this->view->suggestions .= $suggestion_populator->render();
			$suggestion_count++;

			//made mistake by adding , after recipe id added...  led to combining
			//of id's ex: 22,36 was 2236.  Which then didn't exempt it, leading to 
			//duplication of recommendations
			$exemptRecipesList .= ",";
			$exemptRecipesList .= $suggestion['pizza_recipe_id'];
			/*echo('exempt recipes');
			print_r($exemptRecipesList);*/

		}


		//removes the extra "," that's not needed in the string
		while(substr($exemptRecipesList, -1) == ","){
		 	$exemptRecipesList = substr($exemptRecipesList, 0, -1);
		}

		if($suggestion_count < $max_suggestions) {
			$globalRecipesfromDB = Recommend::globalSuggestions($exemptRecipesList);
			// echo ('globalRecipes from DB:');
			// print_r($globalRecipesfromDB);
			while(($suggestion = $globalRecipesfromDB->fetch_assoc()) && $suggestion_count < $max_suggestions) {
				
				$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
				$suggestion_populator->name = xss::protection($suggestion['name']);
				$this->view->suggestions .= $suggestion_populator->render();
				$suggestion_count++;
				$chosen_recipes[] = $suggestion['pizza_recipe_id'];
			}
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