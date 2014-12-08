<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {

		// More code could go here depending on what you want to do with this page



		$suggestion_populator = new SuggestionViewFragment();

		//TODO need to build array here.  Need to make it so mySQL will use array
		$users = 7;
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

<div class="suggestions">
	<a href="/build">BACK</a>
	<?php echo $suggestions ?>
	<!-- <div class="suggestion">
		<div>
			<h3>Recipe Title</h3>
			<p>ingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizza</p>
		</div>
		<a href="/selected">Was this a good suggestion?</a>
	</div>
	<div class="suggestion">
		<div>
			<h3>Recipe Title</h3>
			<p>ingredients in the pizza</p>
		</div>
		<a href="/selected">Was this a good suggestion?</a>
	</div>
	<div class="suggestion">
		<div>
			<h3>Recipe Title</h3>
			<p>ingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizzaingredients in the pizza</p>
		</div>
		<a href="/selected">Was this a good suggestion?</a>
	</div>
	<div class="suggestion">
		<div>
			<h3>Recipe Title</h3>
			<p>ingredients in the pizza</p>
		</div>
		<a href="/selected">Was this a good suggestion?</a>
	</div>
	<div class="suggestion">
		<div>
			<h3>Recipe Title</h3>
			<p>ingredients in the pizza</p>
		</div>
		<a href="/selected">Was this a good suggestion?</a>
	</div> -->


</div>