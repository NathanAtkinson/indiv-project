<?php

class Controller extends AppController {
	protected function init() {
		
			// $this->view->selected_suggestions .= '<div class="selected-suggestions">';
		
		//if not thing selected on last page, don't populate div of selections.
		if(!empty($_POST['pizza-recipe-names'])){
			$recipe_names = xss::protection($_POST['pizza-recipe-names']);
			$recipe_names_array = explode(";", $recipe_names);

			foreach ($recipe_names_array as $name) {
				$this->view->selected_suggestions .= "<div>$name</div>";
			}
		}
		// $this->view->selected_suggestions .= '</div>';
		
        $this->view->map = '<div id="map-canvas">map div</div>';
	}
}

$controller = new Controller();

extract($controller->view->vars);

?>

<div class="primary-content">
    <nav>
        <a href="/suggestions">BACK</a>
        <a id="sign-out" href="/logout">SIGN OUT</a>
    </nav>
    	<?php echo $map ?>
    	<div class="selected-suggestions">
    		<?php echo $selected_suggestions ?>
    	</div>
</div>

<!-- includes script needed for map -->
<script src="/js/map.js"></script>
