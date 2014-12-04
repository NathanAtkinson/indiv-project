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



<div class="primary-content">
	<div class="friends">
	<a href="/profile">BACK</a>
		<!-- <div>
			<img src="" alt="">
			<h3 id="user">Current user...</h3>
		</div> -->
		
		<h3>Other Users:</h3>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
		<div class="friend">
			<img src="" alt="">
			<a href="#"></i>user One</a>
		</div>
	</div>

	<div class="toppings">
		<h3>Other toppings you don't want this time:</h3>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div><div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<div class="topping">
			<a href="#"></i>Topping One</a>
		</div>
		<a href="/suggestions" id="suggestions">Get suggestions</a>
	</div>

</div>