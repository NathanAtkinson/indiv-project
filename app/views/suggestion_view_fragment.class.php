<?php 

/*
* Creates fragments for the recommendations
*/
class SuggestionViewFragment extends ViewFragment {


	//sets template to create recommendations.  Hides them with {{hidden}} if needed
	//by adding other-option class
	private $template =<<<html
	  <div class="suggestion {{hidden}}" >
	    <div>
	      <h3>{{name}}</h3>
	    </div>
	    <div class="feedback" data-pizza-recipe-id="{{pizza_recipe_id}}">
	    	Good suggestion? 
	    	<a href="#" data-vote="yes">Yes</a>
	    	<a href="#" data-vote="no">No</a>
	  	</div>
	  </div>
html;

	//from the controller, put in values into this array by key/value pairs
	//using the same names used in the template above						
	private $values = [];

	public function __set($property_name, $value) {
		$this->values[$property_name] = $value;
	}

	//This returns a string.  For this to work, will have to have passed key/value pairs.
	public function render() {
		return parent::fill($this->values, $this->template);
	}
}


















