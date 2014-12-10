<?php 


class SuggestionViewFragment extends ViewFragment {


      // <p>{{ingredient_list?}}</p>
  private $template =<<<html
  <div class="suggestion">
    <div>
      <h3>{{name}}</h3>
    </div>
    <a href="#" data-pizza-recipe-id="{{pizza_recipe_id}}">This was a good suggestion</a>
  </div>
html;

	//from the controller, put in values into this array by key/value pairs
	//be sure to use the same names used in the template above						
	private $values = [];


	public function __set($property_name, $value) {
		$this->values[$property_name] = $value;

	}

	//This returns a string.  For this to work, will have to have passed key/value pairs.
	public function render() {
		return parent::fill($this->values, $this->template);
	}
}


















