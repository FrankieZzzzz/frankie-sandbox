<?php

/**

 * Plugin Name: WP Obituary Manager 

 * Plugin URI: http://www.wptaskforce.com

 * Description: WP Obituary Manager plugin will helps you manage your obituary sites easy.

 * Version: 2.0.4

 * Author: WPTaskForce.com

 * Text Domain: wp-obituary

 * Domain Path: /languages

 */



if ( ! defined( 'WPINC' ) ) {

	die;

}



/** Define plugin constants */

define( 'WP_OBITUARY_FILE', __FILE__ );

define( 'WP_OBITUARY_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_OBITUARY_PATH', plugin_dir_path( __FILE__ ) );



//** Includes files'



require_once( WP_OBITUARY_PATH.'admin/admin.php' );

require_once( WP_OBITUARY_PATH.'includes/functions.php' );

require_once( WP_OBITUARY_PATH.'classes/class-scripts.php' );



add_action('plugins_loaded', 'wp_obituary_textdomain');

add_filter( 'template_include', 'wp_obituary_template_selector');