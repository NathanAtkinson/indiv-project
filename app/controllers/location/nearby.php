<?php

class Controller extends AppController {
	protected function init() {
		



        
	}
}

$controller = new Controller();

extract($controller->view->vars);

?>

<nav>
    <a href="/profile">BACK</a>
    <!-- <a href="/suggestions" id="suggestions">Get suggestions</a> -->
    <!-- <div id="suggestions">get suggestions</div> -->
    <!-- <a href="" id="suggestions">Get suggestions</a> -->
    <a id="sign-out" href="/logout">SIGN OUT</a>
</nav>
<div id="map-canvas">map div</div>

    
