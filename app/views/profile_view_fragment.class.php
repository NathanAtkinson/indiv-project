<?php 

/*
* Creates fragment for profile.  
*/
class ProfileViewFragment extends ViewFragment {

  private $template =<<<html
  	<div class="this-user">
  		<div class="profile-info" data-user_id ="{{user_id}}">
  			<div class="image"><img src="/app/images/users/{{picture_id}}.jpg"></div>
  			<h3>{{user_name}}</h3>
  			<h3>{{location}}</h3>
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










