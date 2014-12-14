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

		$recommend = new Recommend();
	
		//gets dislikes based on the user id's and compiles a string
		$input['user_ids'] = $users;
		$results = $recommend->getDislikes($input);
		$disliked_toppings = "";
		while ($row = $results->fetch_assoc()) {
			$disliked_toppings .= $row['topping_id'];
			$disliked_toppings .= ",";
		}
		
		
		//if 1x dislikes included, appends to string of the list.  Otherwise, removes
		//extra "," from the string
		if ($_POST['topping-ids'] != "") {
			$toppings = $_POST['topping-ids'];
			$disliked_toppings .= $toppings;
		} else {
			$disliked_toppings = substr($disliked_toppings, 0, -1);
		}

		// checks if there are dislikes, if not, user is indifferent and runs query reflecting that
		if(empty($disliked_toppings)) {
			//get all recipes ranked based on no dislikes
			$input['user_ids'] = $users;
			$goodRecipesfromDB = $recommend->indifferentSuggestion($input);
		} else {
			//get list of recipes exempted by topping dislikes
			$input['topping_ids'] = $disliked_toppings;
			$exemptRecipes = $recommend->getExemptRecipes($input);


			$exemptRecipesList = "";
			while ($row = $exemptRecipes->fetch_assoc()) {
				$exemptRecipesList .= $row['pizza_recipe_id'];
				$exemptRecipesList .= ",";
			}

			//removes the extra "," that's not needed in the string
			while(substr($exemptRecipesList, -1) == ","){
		 		$exemptRecipesList = substr($exemptRecipesList, 0, -1);
			}

			$input['user_ids'] = $users;
			$input['recipe_ids'] = $exemptRecipesList;
			$userSuggestions = $recommend->userSuggestions($input);
		}

		$suggestion_populator = new SuggestionViewFragment();
		
		$maxSuggestions = 7;
		$suggestion_count = 0;

		// Will be used to store bad recommendations, still show them, but last
		$deferredSuggestions = [];
		//had to put () around suggestoin/fetch assoc
		while(($suggestion = $userSuggestions->fetch_assoc())) {
			if($suggestion['total'] < 1){
				$pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
				$deferredSuggestions[$pizza_recipe_id] = xss::protection($suggestion['name']);
			} else {
				$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
				$suggestion_populator->name = xss::protection($suggestion['name']);
				if($suggestion_count >= $maxSuggestions) {
					$suggestion_populator->hidden = "hidden";
				} else {
					$suggestion_populator->hidden = "";
				}
				
				$this->view->suggestions .= $suggestion_populator->render();
				$suggestion_count++;
			}
			
			$exemptRecipesList .= ",";
			$exemptRecipesList .= $suggestion['pizza_recipe_id'];
			//made mistake by adding , after recipe id added...  led to combining
			//of id's ex: 22,36 was 2236.  Which then didn't exempt it, leading to 
			//duplication of Suggestions
			
		}


		//removes the extra "," that's not needed in the string
		while(substr($exemptRecipesList, -1) == ","){
		 	$exemptRecipesList = substr($exemptRecipesList, 0, -1);
		}

		// if($suggestion_count < $maxSuggestions) {
		$input['recipe_ids'] = $exemptRecipesList;
		$globalRecipesfromDB = $recommend->globalSuggestions($input);
		$exemptArray = explode(",", $exemptRecipesList);
		while($suggestion = $globalRecipesfromDB->fetch_assoc()) {

			//was adding pizza 2x, even though query was run to exempt it.
			if(in_array($suggestion['pizza_recipe_id'], $exemptArray)){
				continue;
			}
			if($suggestion_count >= $maxSuggestions) {
				$suggestion_populator->hidden = "other-option";
			} else {
				$suggestion_populator->hidden = "";
			}
			$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
			$suggestion_populator->name = xss::protection($suggestion['name']);
			$this->view->suggestions .= $suggestion_populator->render();
			$suggestion_count++;
			// $chosen_recipes[] = $suggestion['pizza_recipe_id'];
		}

		foreach($deferredSuggestions as $pizza_recipe_id => $name) {
			if($suggestion_count >= $maxSuggestions) {
				$suggestion_populator->hidden = "other-option";
			} else {
				$suggestion_populator->hidden = "";
			}
			$suggestion_populator->pizza_recipe_id = $pizza_recipe_id;
			$suggestion_populator->name = $name;
			$this->view->suggestions .= $suggestion_populator->render();
			$suggestion_count++;
			// $chosen_recipes[] = $suggestion['pizza_recipe_id'];
		}
	}
}

$controller = new Controller();

// Extract Main Controler Vars
extract($controller->view->vars);

?>


<div class="primary-content">
	<nav>
		<a href="/build">BACK</a>
		<a id="sign-out" href="/logout">SIGN OUT</a>
	</nav>
	<div class="suggestions" data-user-ids="<?php echo $users ?>">
		 <?php echo $suggestions ?>
	</div>
</div>
