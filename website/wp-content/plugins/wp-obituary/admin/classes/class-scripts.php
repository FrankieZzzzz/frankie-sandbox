<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Obituary_Admin_Scripts{
	
	public $text_domain = 'wp-obituary';
	
	function __construct(){
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
	}
	
	function admin_scripts(){
		$screen = get_current_screen();
		wp_register_script( 'wp-obituary-settings-script', WP_OBITUARY_URL . 'admin/assets/js/wp-obituary-settings-script.js', array( 'jquery' ), '2.0.0', TRUE );
		wp_register_script( 'wp-obituary-admin-script', WP_OBITUARY_URL . 'admin/assets/js/wp-obituary-admin-script.js', array( 'jquery' ), '2.0.0', TRUE );
		//** Add Script only ot the plugin settings page
		if( $screen->base == 'wp_obituary_page_wp-obituary-settings' ){
			wp_enqueue_script('jquery');
			wp_enqueue_media();
			wp_enqueue_script( 'wp-obituary-settings-script' );
		}
		//** Add script only to the wp_obituary post only
		if( $screen->id == 'wp_obituary' || $screen->id == 'edit-obituary_cat' ){
			wp_enqueue_script( 'wp-obituary-admin-script' );
		}
		
	}
	function admin_styles(){
		wp_register_style( 'wp-obituary-css', WP_OBITUARY_URL . 'admin/assets/css/wp-obituary-styles.css', false, '2.0.0' );
        wp_enqueue_style( 'wp-obituary-css' );
	}
}

new WP_Obituary_Admin_Scripts;