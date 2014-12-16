<?php

// Suggestions Page Controller
class Controller extends AppController {
	protected function init() {

		if (!UserLogin::isLogged()){
            header('Location: /');
            exit();
        }

        //sets variables
		$maxSuggestions = 7;
		$suggestion_count = 0;
		$deferredSuggestions = [];
		$exemptRecipesList = array(0);

		$user_id = UserLogin::getUserID();
		// $user = new User($user_id);

		//Builds string of users for mySQL here
		if ($_POST['user-ids'] != "") {
			$users = $_POST['user-ids'];
			$users .= "," . $user_id;
		//If no extra users were selected, then just uses current user_id
		} else {
			$users = $user_id;
		}

		//used for data-user-ids in page
		$this->view->users = $users;

		//Builds objects for use later
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

		//if the dislikes list is empty, doesn't fetch recipes to add to exempt list
		if(!empty($disliked_toppings)) {
			$input['topping_ids'] = $disliked_toppings;
			$exemptRecipes = $recommend->getExemptRecipes($input);

			//otherwise builds array of exempt recipes
			while ($row = $exemptRecipes->fetch_assoc()) {
				$exemptRecipesList[] = $row['pizza_recipe_id'];
			}
		}

		//prepares input with user_id/user_ids (set above)
		$input['user_ids'] = $users;
		$userSuggestions = $recommend->userSuggestions($input);

		//builds suggestions based on users votes
		while($suggestion = $userSuggestions->fetch_assoc()) {
			//if exempted, skip the recipe
			if(in_array($suggestion['pizza_recipe_id'], $exemptRecipesList)){
				continue;
			}

			//if cumulative votes are less than 1, then will recommend later by putting 
			//into array for later retrieval
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
				
				//builds the fragment and adds it to view for later rendering
				$this->view->suggestions .= $suggestion_populator->render();
				$suggestion_count++;
				$exemptRecipesList[] = $suggestion['pizza_recipe_id'];
			}
		}

		//runs query to get vote totals globally
		$globalRecipesfromDB = $recommend->globalSuggestions();

		//while there are results, loop through them.
		while($suggestion = $globalRecipesfromDB->fetch_assoc()) {

			//doesn't create fragment for exempted recipe or one already created in user suggestion
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

			//ensures doesn't create fragment for that recipe again
			$exemptRecipesList[] = $suggestion['pizza_recipe_id'];
		}

		//anything that was deferred is now created here.  This allows for presenting negative
		//voted recipes that don't have exempted ingredients
		foreach($deferredSuggestions as $pizza_recipe_id => $name) {

			//recipe may have been created in global recs, don't wnat to present again.
			if(in_array($deferredSuggestions[$pizza_recipe_id], $exemptRecipesList)){
				continue;
			}

			//if suggestions equal to max, then hide for later retrieval
			if($suggestion_count >= $maxSuggestions) {
				$suggestion_populator->hidden = "other-option";
			} else {
				$suggestion_populator->hidden = "";
			}
			$suggestion_populator->pizza_recipe_id = $pizza_recipe_id;
			$suggestion_populator->name = $name;
			$this->view->suggestions .= $suggestion_populator->render();
			$suggestion_count++;
		}
	}
}

$controller = new Controller();

extract($controller->view->vars);
?>

<div class="primary-content">
	<nav>
		<a href="/build">BACK</a>
		<form action="/nearby" method="POST">
			<input type="hidden" name="pizza-recipe-names" id="pizza-recipe-names">
			<button id="nearby">Nearby Pizza Places</button>
		</form>
		<a id="sign-out" href="/logout">SIGN OUT</a>
	</nav>
	<div class="suggestions" data-user-ids="<?php echo $users ?>">
		 <?php echo $suggestions ?>
	</div>
</div>
