<?php 

/*
* Base class for view fragments
*/
class ViewFragment {
	
	// Fill Template
	public static function fill($record, $template) {
		$search_keys = array_keys($record);
		array_walk($search_keys, ['self', 'fixKeys']);
		$values = array_values($record);
		return str_replace($search_keys, $values, $template);
	}

	// Callback to fix keys with mustashes
	private static function fixKeys(&$search) {
		$search = '{{' . $search . '}}';
	}
}