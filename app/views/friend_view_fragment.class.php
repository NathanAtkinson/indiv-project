<?php 

/*
* Creates fragment for friends on build suggestion page
*/
class FriendViewFragment extends ViewFragment {


      // <img src="/app/images/jon.jpg" alt="">
  private $template =<<<html
  <div class="friend">
      <a href="#" data-user-id="{{user_id}}"></i> {{user_name}}</a>
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


















