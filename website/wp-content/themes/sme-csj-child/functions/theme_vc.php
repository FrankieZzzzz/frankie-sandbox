<?php

//*** Visual Composer custom modules ***//

if(class_exists('WPBMap')) {

// Site language
$lang = get_locale();

// Create link with array
function createLink($array) {
	if ($array["url"]) {
		$btnLink = "<a href='{$array["url"]}' target='{$array["target"]}' rel='{$array["rel"]}'>{$array["title"]}</a>";
		return $btnLink;
	}
}

// Create button with array
function createButton($array, $btnStyle) {
	if ($array["url"]) {
		$btnLink = "<a href='{$array["url"]}' class='btn {$btnStyle}' target='{$array["target"]}' rel='{$array["rel"]}'>{$array["title"]}</a>";
		return $btnLink;
	}
}

// Global vc arrays
$vcTxtColors = array(
	__( 'Select' ),
	__( 'Dark Grey' ) => 'txt-dgrey',
	__( 'Green' ) => 'txt-green',
	__( 'Yellow' ) => 'txt-yellow',
	__( 'Navy' ) => 'txt-navy',
	__( 'White' ) => 'txt-white',
	__( 'Grey' ) => 'txt-grey',
	__( 'Black' ) => 'txt-black',
);

$vcBgColors = array(
	__( 'Select' ),
	__( 'CSJ Prime Green' ) => 'prime_green',
	__( 'CSJ Light Green' ) => 'light_green',
	__( 'CSJ Charcoal Grey ' ) => 'charcoal_grey',
	__( 'CSJ Steel Grey' ) => 'steel_grey',
	__( 'CSJ Prime Dark Grey' ) => 'dark_grey',
);

// Button colours
$vcBtnCustomColors = array(
	__( 'Dark Grey' ) => 'dgrey_button',
	__( 'Green' ) => 'green_button',
	__( 'Dark Grey Outline' ) => 'dgrey_outline_button',
	__( 'Green Outline' ) => 'green_outline_button',
	__( 'Green Text Link' ) => 'green_link',
	__( 'Green Text Inline Link' ) => 'green_in-link',
	__( 'White Text Link' ) => 'white_link',
	__( 'Grey Text Link' ) => 'grey_link',
	__( 'Black Text Link' ) => 'black_link',
);
$vcBtnColors = array(
	'type' => 'dropdown',
	'heading' => 'Color',
	'param_name' => 'color',
	'value' => $vcBtnCustomColors
);

// Button Styles	
$vcBtnCustomStyles = array(
	__( 'None' ) => 'na',
);
$vcBtnStyles = array(
	'type' => 'dropdown',
	'heading' => 'Style',
	'param_name' => 'style',
	'value' => $vcBtnCustomStyles
);

// Button shapes
$vcBtnCustomShapes = array(
	__( 'Square' ) => 'square',
	__( 'Rounded' ) => 'rounded',
	__( 'Round' ) => 'round',
	__( 'None' ) => 'na',
);
$vcBtnShapes = array(
	'type' => 'dropdown',
	'heading' => 'Shape',
	'param_name' => 'shape',
	'value' => $vcBtnCustomShapes
);

$vcTabColors = array(
	'type' => 'dropdown',
	'heading' => 'Color',
	'param_name' => 'color',
	'value' => array(
		'Dark Grey' => 'dgrey_tab',
		'Green' => 'green_tab',
		'Navy' => 'navy_tab',
		'Grey' => 'grey',
		'White' => 'white',
	)
);

// After VC Init
add_action( 'vc_after_init', 'vc_after_init_actions' );
function vc_after_init_actions() {
	// Remove VC Elements
	if( function_exists('vc_remove_element') ){ 
		vc_remove_element( 'vc_column_text' );
		vc_remove_element( 'vc_custom_heading' );
		vc_remove_element( 'vc_cta' );
	}
}

// Customizing default vc button params
add_action( 'vc_after_init', 'vc_btn_custom' );
function vc_btn_custom() {
	global $vcBtnColors, $vcBtnStyles, $vcBtnShapes;
	// Override default colours
	vc_add_param('vc_btn', $vcBtnColors);
	vc_add_param('vc_btn', $vcBtnStyles);
	vc_add_param('vc_btn', $vcBtnShapes);
}

$vcDividerAttr = array(
	array(
		'type' => 'dropdown',
		'heading' => 'Style',
		'param_name' => 'style',
		'value' => array(
			'CSJ Divider Solid' => 'csj_divider',
			// 'Divider - Arrow Down' => 'divider_ad',
			// 'Frame 1 - Top' => 'frame_1_top',
			// 'Frame 1 - Bottom' => 'frame_1_bot',
			// 'Solid' => 'solid',
			// 'Dot' => 'dot',
			// 'Dash' => 'dash',
		),
		'description' => __( 'Select the border/frame colour.', 'innermost' )
	),
	array(
		'type' => 'dropdown',
		'heading' => 'Color',
		'param_name' => 'color',
		'value' => $vcBgColors,
		'description' => __( 'Select the border/frame style.', 'innermost' )
	),
	array(
		'type' => 'dropdown',
		'heading' => 'Alignment',
		'param_name' => 'align',
		'value' => array(
			'Center' => 'align_center',
			'Left' => 'align_left',
			'Right' => 'align_right',
			'Sticky Top' => 'sticky_top',
			'Sticky Bottom' => 'sticky_bot',
		),
		'description' => __( 'Select the border/frame style.', 'innermost' )
	)
);

add_action( 'vc_after_init', 'vc_divider_custom' );
function vc_divider_custom() {
	global $vcDividerAttr;
	// Override default
	vc_add_params( 'vc_separator', $vcDividerAttr );
}

// Add/Remove VC widgets: only keep widgets based on project requirements

include_once "vc_templates/vc_content_block.php";
include_once "vc_templates/vc_heading_block.php";
include_once "vc_templates/vc_cta_card.php";
include_once "vc_templates/vc_cta_card_lg.php";
include_once "vc_templates/vc_cta_card_sm.php";
include_once "vc_templates/vc_cta_card_bg.php";
include_once 'vc_templates/vc_testimonial.php';
include_once "vc_templates/vc_testimonial_slider.php";
include_once 'vc_templates/vc_slider.php';
include_once "vc_templates/vc_modal_btn.php";
include_once "vc_templates/vc_tile_cta.php";
include_once "vc_templates/vc_image_carousel.php";

} // endif class_exists('WPBMap')

?>