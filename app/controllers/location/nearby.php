<?php

class Controller extends AppController {
	protected function init() {
		

        $this->view->map = '<div id="map-canvas">map div</div>';
	}
}

$controller = new Controller();

extract($controller->view->vars);

?>

<div class="primary-content">
    <nav>
        <a href="/profile">BACK</a>
        <a id="sign-out" href="/logout">SIGN OUT</a>
    </nav>

    <?php echo $map ?>

</div>

<!-- includes script needed for map -->
<script src="/js/map.js"></script>
