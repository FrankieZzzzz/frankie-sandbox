<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Obituary_Scripts{
	
	public $text_domain = 'wp-obituary';
	
	function __construct(){
		//** add_action( 'wp_enqueue_script', array( $this, 'frontend_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
	}
	
	function frontend_scripts(){
		//** wp_register_script( 'wp-obituary-admin-script', WP_OBITUARY_URL . 'admin/assets/js/wp-obituary-admin-script.js', array( 'jquery' ), '2.0.0', TRUE );
		//** wp_enqueue_script( 'wp-obituary-admin-script' );
		
	}
	function frontend_styles(){
		wp_register_style( 'wp-obituary-css', WP_OBITUARY_URL . 'assets/css/wp-obituary-styles.css', false, '2.0.0' );
        wp_enqueue_style( 'wp-obituary-css' );
	}
}

new WP_Obituary_Scripts;