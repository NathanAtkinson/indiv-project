<?php

// Profile Page Controller
class Controller extends AppController {
	protected function init() {

		// More code could go here depending on what you want to do with this page

	}

}
$controller = new Controller();

// Extract Main Controler Vars
extract($controller->view->vars);

?>

<div class="suggestions">
	<a href="/build">BACK</a>
	<div class="suggestion">
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
	</div>


</div>