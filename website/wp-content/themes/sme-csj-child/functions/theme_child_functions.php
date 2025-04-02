<?php


// Enqueue Child Theme Styles
function theme_enqueue_styles() {
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', wp_get_theme()->get('Version'));
	wp_enqueue_style('mmenu-menu-style', get_stylesheet_directory_uri() .'/vendor/mmenu/mmenu.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


// Enqueue Child Theme Scripts
function theme_enqueue_scripts() {
	wp_enqueue_script('mmenu-menu-script', get_stylesheet_directory_uri() . '/vendor/mmenu/mmenu.js', array('jquery'), '', true);
  	wp_enqueue_script('csj-child-js', get_stylesheet_directory_uri() . '/js/custom-sme_child.js', array('jquery'), false, false);
	wp_enqueue_script('social-share-script', get_stylesheet_directory_uri() . '/js/social-share.js', array('jquery'), '', true);
	wp_enqueue_script(
		'cookie-js',
		get_stylesheet_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), false, false
	);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Flickity Slider Init
function flickity_scripts($param = 'base') {
	// Get child theme directory
	global $stylesheet_directory_uri;

	// enqueue flickity base css & scripts
	wp_enqueue_style('flickity-css', $stylesheet_directory_uri . '/vendor/flickity/flickity.min.css');
	wp_enqueue_script('flickity-js', $stylesheet_directory_uri . '/vendor/flickity/flickity.pkgd.min.js' );
	wp_enqueue_script('flickity-hash-js', $stylesheet_directory_uri . '/vendor/flickity/hash.js' );

	if ($param === 'full') {
		// enqueue flickity optional scripts
		wp_enqueue_style('flickity-fs-css', $stylesheet_directory_uri . '/vendor/flickity/fullscreen.css');
		wp_enqueue_script('flickity-fs-js', $stylesheet_directory_uri . '/vendor/flickity/fullscreen.js' );
	}

	wp_enqueue_style('fontawesome6-solid-css', $stylesheet_directory_uri . '/vendor/fontawesome/6.5.1/css/solid.min.css', '', '6.5.1');
	wp_enqueue_style('fontawesome6-sharp-solid-css', $stylesheet_directory_uri . '/vendor/fontawesome/6.5.1/css/sharp-solid.min.css', '', '6.5.1');		

}

// Limit blog post exerpt length
// function custom_excerpt_length($length) {
//   return 56;
// }
// add_filter('excerpt_length', 'custom_excerpt_length', 999);

// Hides Post from wp-admin menu since this project doesn't require it
// function hide_post_from_menu () { 
//    remove_menu_page('edit.php');
// }
// add_action('admin_menu', 'hide_post_from_menu');

// function remove_exerpt_more_brackets() {
// 	return '...';
// }
// add_filter('excerpt_more', 'remove_exerpt_more_brackets');


function show_page_content($path) {
  $post = get_page_by_path($path);
  $content = apply_filters('the_content', $post->post_content);
  echo $content;
}

// Change the default excerpt length to 20 words.
function wpexplorer_excerpt_length( $length ) {
    $length = 20;
    return $length;
}
add_filter( 'excerpt_length', 'wpexplorer_excerpt_length', PHP_INT_MAX );

