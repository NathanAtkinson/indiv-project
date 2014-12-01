<?php

// Controller
class Controller extends AppController {
	protected function init() {
		
		// Send a variable to the main view
		$this->view->welcome = 'Welcome to MVC';

		// Send a variable to a sub view
		$this->view->primary_header->welcome = 'Welcome Student!';

	}
}
$controller = new Controller();

// Extract Main Controller Vars
extract($controller->view->vars);

?>

<!-- Notice this welcome variable was created above and passed into the view -->
<h3><?php echo $welcome; ?></h3>