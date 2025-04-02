<?php

// ACF
if(function_exists('acf_add_local_field_group')) {

	// Save ACF JSON files
	add_filter('acf/settings/save_json', 'my_acf_json_save_point');
	 
	function my_acf_json_save_point( $path ) {
	    
	    // update path
	    $path = get_stylesheet_directory() . '/acf-json';
	    
	    // return
	    return $path;
	    
	}

	// Load ACF JSON files
	add_filter('acf/settings/load_json', 'my_acf_json_load_point');

	function my_acf_json_load_point( $paths ) {
	    
	    // remove original path (optional)
	    unset($paths[0]);
	    
	    // append path
	    $paths[] = get_stylesheet_directory() . '/acf-json';
	    
	    // return
	    return $paths;
	    
	}

}

?>