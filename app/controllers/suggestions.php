<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

		$maxSuggestions = 7;
		$suggestion_count = 0;
		$deferredSuggestions = [];
		$exemptRecipesList = array(0);
		$user_id = UserLogin::getUserID();
		// $user = new User($user_id);


		//Builds string for mySQL here.  
		//If no extra users were selected, then just uses current user_id
		if ($_POST['user-ids'] != "") {
			$users = $_POST['user-ids'];
			$users .= "," . $user_id;
		} else {
			$users = $user_id;
		}

		//used for data-user-ids in page
		$this->view->users = $users;

		$recommend = new Recommend();
		$suggestion_populator = new SuggestionViewFragment();

		//gets dislikes based on the user id('s)
		$input['user_ids'] = $users;
		$results = $recommend->getDislikes($input);
		$disliked_toppings = "";

		//compiles a string of disliked toppings
		while ($dislike = $results->fetch_assoc()) {
			$disliked_toppings .= $dislike['topping_id'];
			$disliked_toppings .= ",";
		}
				
		//If no dislikes sent from prior page, appends to string of the list.  
		//Otherwise, removes extra "," from the string
		if ($_POST['topping-ids'] != "") {
			$toppings = $_POST['topping-ids'];
			$disliked_toppings .= $toppings;
		} else {
			$disliked_toppings = substr($disliked_toppings, 0, -1);
		}




			
		//if the list is empty, doesn't fetch exempted recipes
		if(!empty($disliked_toppings)) {
			$input['topping_ids'] = $disliked_toppings;
			$exemptRecipes = $recommend->getExemptRecipes($input);

			//builds array of exempt recipes
			while ($row = $exemptRecipes->fetch_assoc()) {
				$exemptRecipesList[] = $row['pizza_recipe_id'];
			}
		}


		$input['user_ids'] = $users;
		$userSuggestions = $recommend->userSuggestions($input);

		while($suggestion = $userSuggestions->fetch_assoc()) {
			if(in_array($suggestion['pizza_recipe_id'], $exemptRecipesList)){
				continue;
			}

			//if cumulative votes are less than 1, then will recommend later by putting into array
			if($suggestion['total'] < 1){
				$pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
				$deferredSuggestions[$pizza_recipe_id] = xss::protection($suggestion['name']);
			//if positive vote, creates fragment.
			} else {
				$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
				$suggestion_populator->name = xss::protection($suggestion['name']);
				//currently only show maxSuggestions.  If already that many, hide suggestion
				if($suggestion_count >= $maxSuggestions) {
					$suggestion_populator->hidden = "other-option";
				} else {
					$suggestion_populator->hidden = "";
				}
				
				//builds the fragment and adds it to view for later
				$this->view->suggestions .= $suggestion_populator->render();
				$suggestion_count++;
				$exemptRecipesList[] = $suggestion['pizza_recipe_id'];
			// print_r($exemptRecipesList);
			}
		}

		$globalRecipesfromDB = $recommend->globalSuggestions();

		while($suggestion = $globalRecipesfromDB->fetch_assoc()) {

			// print_r($suggestion['pizza_recipe_id']);
			if(in_array($suggestion['pizza_recipe_id'], $exemptRecipesList)){
				continue;
			}
			//makes sure only show max suggestions, otherwise hide for later (if needed)
			if($suggestion_count >= $maxSuggestions) {
				$suggestion_populator->hidden = "other-option";
			} else {
				$suggestion_populator->hidden = "";
			}

			//build suggestion fragments
			$suggestion_populator->pizza_recipe_id = xss::protection($suggestion['pizza_recipe_id']);
			$suggestion_populator->name = xss::protection($suggestion['name']);
			$this->view->suggestions .= $suggestion_populator->render();
			$suggestion_count++;
			$exemptRecipesList[] = $suggestion['pizza_recipe_id'];
		}

		foreach($deferredSuggestions as $pizza_recipe_id => $name) {
			if(in_array($deferredSuggestions[$pizza_recipe_id], $exemptRecipesList)){
				continue;
			}
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
		<a href="/nearby">Nearby Pizza Places</a>
		<a id="sign-out" href="/logout">SIGN OUT</a>
	</nav>
	<div class="suggestions" data-user-ids="<?php echo $users ?>">
		 <?php echo $suggestions ?>
	</div>
</div>
