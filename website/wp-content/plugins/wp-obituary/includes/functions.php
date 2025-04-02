<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wp_obituary_get_template_locator( $template ) {
	$plugin_dir = basename(dirname( WP_OBITUARY_FILE ));
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $wp_obituray_file = locate_template( array( $plugin_dir.'/' . $template ) ) ) {
        $file = $wp_obituray_file;
    } else {
        $file = dirname( WP_OBITUARY_FILE ) . '/templates/' . $template;
    }
    return apply_filters( 'wp_obituary_locate_template' . $template, $file );
}

function wp_obituary_template_selector( $template ) {
    $post_id = get_the_ID();
    if ( is_singular('wp_obituary') ) {
        return wp_obituary_get_template_locator( 'single' );
    }elseif( is_tax( 'obituary_cat' ) ){
		return wp_obituary_get_template_locator( 'archive' );
	}
	return $template;
}

function wp_obituary_get_template( $template ){
	return include_once(  wp_obituary_get_template_locator( $template ) );
}

if ( ! function_exists( 'wp_obituary_posted_on' ) ) :
	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 */
	function wp_obituary_posted_on() {
		printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'wp-obituary' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'wp-obituary' ), get_the_author() ) ),
				get_the_author()
			)
		);
	}
endif;
add_filter( 'body_class','wp_obituary_body_classes' );
function wp_obituary_body_classes( $classes ) {
 	if( is_singular('wp_obituary')  ){
		$template_layout = get_post_meta( get_the_ID(), 'obituary-layout', TRUE );
		$classes[] = 'obituary '.$template_layout;
	}elseif( is_tax( 'obituary_cat' ) ){
		$term_id 			= get_queried_object()->term_id;
		$template_layout 	= get_term_meta( $term_id, 'obituary-archive-template', true );
		$classes[] = 'obituary '.$template_layout;
	}
    return $classes;
}

/**

 * Adds a box to the main column on the Post and Page edit screens.

 */

function wpffo_add_meta_box() {

	$screens = array( 'wp_obituary' );

	foreach ( $screens as $screen ) {

		add_meta_box(

			'wpffo-funeral-service',

			__( 'Funeral Service', 'wpffo_textdomain' ),

			'wpffo_meta_box_callback',

			$screen,

			'advanced',

			'high'

		);

	}

}

add_action( 'add_meta_boxes', 'wpffo_add_meta_box' );

/**

 * Prints the box content.

 * 

 * @param WP_Post $post The object for the current post/page.

 */

function wpffo_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.

	wp_nonce_field( 'wpffo_meta_box', 'wpffo_meta_box_nonce' );

	/*

	 * Use get_post_meta() to retrieve an existing value

	 * from the database and use the value for the form.

	 */
	$my_data = get_post_meta( $post->ID, 'wpffo_data', true );

$fixed_serialized_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {
    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
}, $my_data );

$wpffo_data = unserialize( base64_decode($fixed_serialized_data ));
	//var_dump($wpffo_data);
echo '<div class="outer-repeater">';
echo ' <div data-repeater-list="wpffo_data" class="outer">';
	if(!empty($wpffo_data)){
$x=0;
	foreach($wpffo_data as $data){
		

	// FUNERAL HOME SECTIOM
	
	echo '<div data-repeater-item class="outer">
         <p>
        <label for="wpffo_venue_name">Visitation/Service Name : </label>
        <input type="text"  name="wpffo_venue_name" value="'.stripslashes($data['wpffo_venue_name']).'" size="25">
      </p>
          <p>
        <label for="wpffo_venue">Venue : </label>
        <input type="text"  name="wpffo_venue" value="'.stripslashes($data['wpffo_venue']).'" size="25">
      </p>
          <p>
        <label for="wpffo_address">Address : </label>
        <input type="text"  name="wpffo_address" value="'.stripslashes($data['wpffo_address']).'" size="25">
      </p>
          <div class="inner-repeater">
            <div data-repeater-list="date_time" class="inner">
              ';
		 $date_time= $data['date_time'];
		  if(!empty($date_time)){
$y=0;
	foreach($date_time as $datetime){
     echo' <div data-repeater-item class="inner">
          <p>  <label for="wpffo_date">Date : </label>
        <input type="text"  name="wpffo_date" value="'.$datetime['wpffo_date'].'" size="25" class="datepicker">
      </p>
          <p>
        <label for="wpffo_time"> Time : </label>
        <input type="text"  name="wpffo_time_from" value="'.$datetime['wpffo_time_from'].'" size="25" class="timepicker"> to <input type="text"  name="wpffo_time_to" value="'.$datetime['wpffo_time_to'].'" size="25" class="timepicker">
      </p><input data-repeater-delete type="button" value="Delete" class="inner button button-primary button-large"/>
              </div>';
	  $y++;
	}
	
	}else{
		echo '<div class="inner-repeater">
            <div data-repeater-list="date_time" class="inner">
              <div data-repeater-item class="inner">
          <p>
        <label for="wpffo_date">Date : </label>
        <input type="text"  name="wpffo_date" value="" size="25" class="datepicker">
      </p>
          <p>
        <label for="wpffo_time"> Time : </label>
        <input type="text"  name="wpffo_time_from" value="" size="25" class="timepicker"> to <input type="text"  name="wpffo_time_to" value="" size="25" class="timepicker">
      </p>
	  
	  <input data-repeater-delete type="button" value="Delete" class="inner button button-primary button-large"/>
              </div>
            </div>
            <input data-repeater-create type="button" value="Add Date & Time" class="inner button button-primary button-large"/>
          </div>
';
		
		}
	  
	  $wpffo_message=(isset($datetime['wpffo_message']))?$datetime['wpffo_message']:'';
	 echo'  
            </div>
            <input data-repeater-create type="button" value="Add Date & Time" class="inner button button-primary button-large"/>
          </div>
          <p>
        <label for="wpffo_message">Note : </label>
        <textarea rows="4" cols="50"  name="wpffo_message">'.$wpffo_message.'</textarea>
      </p>
          <input data-repeater-delete type="button" value="Delete" class="button button-primary button-large"/>
        </div>';$x++;
	}
	
	}else{
	echo '<div data-repeater-item class="outer">
         <p>
        <label for="wpffo_venue_name">Visitation/Service Name : </label>
        <input type="text"  name="wpffo_venue_name" value="" size="25">
      </p>
          <p>
        <label for="wpffo_venue">Venue : </label>
        <input type="text"  name="wpffo_venue" value="" size="25">
      </p>
          <p>
        <label for="wpffo_address">Address : </label>
        <input type="text"  name="wpffo_address" value="" size="25">
      </p>
          <div class="inner-repeater">
            <div data-repeater-list="date_time" class="inner">
              <div data-repeater-item class="inner">
          <p>
        <label for="wpffo_date">Date : </label>
        <input type="text"  name="wpffo_date" value="" size="25" class="datepicker">
      </p>
          <p>
        <label for="wpffo_time"> Time : </label>
        <input type="text"  name="wpffo_time_from" value="" size="25" class="timepicker"> to <input type="text"  name="wpffo_time_to" value="" size="25" class="timepicker">
      </p>
	  
	  <input data-repeater-delete type="button" value="Delete" class="inner button button-primary button-large"/>
              </div>
            </div>
            <input data-repeater-create type="button" value="Add Date & Time" class="inner button button-primary button-large"/>
          </div>
          <p>
        <label for="wpffo_message">Note : </label>
        <textarea rows="4" cols="50" name="wpffo_message"></textarea>
      </p>
          <input data-repeater-delete type="button" value="Delete" class="button button-primary button-large"/>
        </div>'; echo ' ';
		}
		echo "</div>";
      echo '<input data-repeater-create type="button" value="Add Visitation/Services" class="button button-primary button-large"/>';
	  echo "</div>";
	echo "<script>
    jQuery(document).ready(function ($) {
    
'use strict';
        window.outerRepeater = $('.outer-repeater').repeater({
            isFirstItemUndeletable: true,
            defaultValues: { 'text-input': 'outer-default' },
            show: function () {
                console.log('outer show');
                $(this).slideDown();
				$('.datepicker').datepicker();
				$('.timepicker').timepicker();
            },
            hide: function (deleteElement) {
                console.log('outer delete');
                $(this).slideUp(deleteElement);
				$('.datepicker').datepicker();
				$('.timepicker').timepicker();
            },
            repeaters: [{
                isFirstItemUndeletable: true,
                selector: '.inner-repeater',
                defaultValues: { 'inner-text-input': 'inner-default' },
                show: function () {
                    console.log('inner show');
                    $(this).slideDown();
					$('.datepicker').datepicker();
					$('.timepicker').timepicker();
                },
                hide: function (deleteElement) {
                    console.log('inner delete');
                    $(this).slideUp(deleteElement);
					$('.datepicker').datepicker();
					$('.timepicker').timepicker();
                }
            }]
        });
		$('.datepicker').datepicker();
		$('.timepicker').timepicker();
    });
</script>";

	
	
	

}

function wpffo_obit_date_meta_box() {

	$screens = array( 'wp_obituary' );

	foreach ( $screens as $screen ) {

		add_meta_box(

			'wpffo-deceased-information',

			__( 'Deceased Information', 'wpffo_textdomain' ),

			'wpffo_di_box_callback',

			$screen,

			'side',

			'high'

		);

	}

}

add_action( 'add_meta_boxes', 'wpffo_obit_date_meta_box' );


function wpffo_di_box_callback( $post ) {
	
	
	echo '<p class="label"><label for="ff-first_name">First Name</label></p>';
	echo '<div class="ff-first_name_wrap"><input type="text" id="ff-first_name" class="text" name="ff-first_name" value="'.get_post_meta( $post->ID, 'ff-first_name', true ).'" placeholder="" required></div>';
	echo '<p class="label"><label for="ff-last_name">Last Name</label></p>';
	echo '<div class="ff-last_name_wrap"><input type="text" id="ff-last_name" class="ff-last_name" name="ff-last_name" value="'.get_post_meta( $post->ID, 'ff-last_name', true ).'" placeholder="" required></div>';
	echo '<p class="label"><label for="ff-date_of_birth">Date of Birth</label></p>';
	echo '<div class="ff-date_of_birth_wrap"><input type="text" id="ff-date_of_birth" class="ff-date_of_birth datepicker" name="ff-date_of_birth" value="'.get_post_meta( $post->ID, 'ff-date_of_birth', true ).'" placeholder=""></div>';
	echo '<p class="label"><label for="ff-date_of_death">Date of Death</label></p>';
	echo '<div class="ff-date_of_death_wrap"><input type="text" id="ff-date_of_death" class="ff-date_of_death datepicker" name="ff-date_of_death" value="'.get_post_meta( $post->ID, 'ff-date_of_death', true ).'" placeholder="" required></div>';
}
/**

 * When the post is saved, saves our custom data.

 *

 * @param int $post_id The ID of the post being saved.

 */

function wpffo_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */
	// Check if our nonce is set.

	if ( ! isset( $_POST['wpffo_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wpffo_meta_box_nonce'], 'wpffo_meta_box' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;

		}

	}	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['wpffo_data'] ) ) {

		return;

	}

	// Sanitize user input.
	$wpffo_data= array();
	$wpffo_data = $_POST['wpffo_data'];

	if(!empty($wpffo_data)){ 
	
		$wpffo_data =base64_encode(serialize($wpffo_data));
	
	}
	// Update the meta field in the database.
	// UPDATE FUNERAL HOME POST META VALUE
	update_post_meta( $post_id, 'wpffo_data', $wpffo_data );
	update_post_meta( $post_id, 'ff-first_name', $_POST['ff-first_name'] );
	update_post_meta( $post_id, 'ff-last_name', $_POST['ff-last_name'] );
	update_post_meta( $post_id, 'ff-date_of_birth', $_POST['ff-date_of_birth'] );
	update_post_meta( $post_id, 'ff-date_of_death', $_POST['ff-date_of_death'] );

}

add_action( 'save_post', 'wpffo_save_meta_box_data' );

 add_action( 'wp_enqueue_scripts', 'register_wpffo_styles' );



 function register_wpffo_styles() {



	global $wpffo_dir;



	wp_register_style( 'wpffo-style', WP_OBITUARY_URL. 'assets/css/style.css' );



	wp_enqueue_style( 'wpffo-style' );



 }

 

 add_action( 'admin_init', 'wpffo_admin_scipt' );

 

 function wpffo_admin_scipt(){

	 global $wpffo_dir;

	 wp_register_script( 'wpffo-script', WP_OBITUARY_URL. 'assets/js/wpffo-script.js', array( 'jquery' ), '1.0.0');

	 wp_register_script( 'jquery-date-picker-ui','//code.jquery.com/ui/1.12.0/jquery-ui.js');

	 wp_register_script( 'wpffo-timepicker-script', WP_OBITUARY_URL. 'assets/js/jquery.timepicker.js');
	 
	 wp_register_script( 'wpffo-repeater-script', WP_OBITUARY_URL. 'assets/js/jquery.repeater.js');	 

	// wp_register_script( 'wpffo-bootstrap-script', WP_OBITUARY_URL. 'assets/js/bootstrap-datepicker.js');

	 wp_register_script( 'wpffo-site-script', WP_OBITUARY_URL. 'assets/js/site.js');

	 

	 

	 wp_register_style( 'jquery-date-picker-style', '//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css' );

	 wp_register_style( 'wpffo-admin-style', WP_OBITUARY_URL. 'assets/css/admin-style.css' );

	 wp_register_style( 'jquery-timepicker-style', WP_OBITUARY_URL. 'assets/css/jquery.timepicker.css' );

	// wp_register_style( 'jquery-bootstrap-style', WP_OBITUARY_URL. 'assets/css/bootstrap-datepicker.css' );

	 wp_register_style( 'jquery-site-style', WP_OBITUARY_URL. 'assets/css/site.css' );

	 

	 wp_enqueue_style( array( 'jquery-date-picker-style', 'wpffo-admin-style', 'jquery-timepicker-style', 'jquery-bootstrap-style', 'jquery-site-style' ) );

	 wp_enqueue_script( array( 'wpffo-script', 'jquery-date-picker-ui', 'wpffo-timepicker-script', 'wpffo-bootstrap-script', 'wpffo-site-script','wpffo-repeater-script' ) );

	 

 }

function wpffo_obituary_services(){

global $post;
$html='';

$options = get_option( 'wpffo_settings' );

$my_data = get_post_meta( $post->ID, 'wpffo_data', true );

$fixed_serialized_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {

    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';

}, $my_data );

$wpffo_data= unserialize( base64_decode($fixed_serialized_data) );
//print_r($wpffo_data);
if(!empty($wpffo_data[0]['wpffo_venue_name'])){
	 $html=' <h2 class="wpffo-post-meta-header">Service</h2>';

	 $html.='<div class="visitation_services_wrap clrfix">';

	 //var_dump($wpffo_data);
		if(!empty($wpffo_data) && is_array($wpffo_data)){
	 	foreach($wpffo_data as $data){

		if(!empty($data['wpffo_venue_name'])){

$html.='<div class="visitation_services">';

         

		$html.='<h3>'.stripslashes($data['wpffo_venue_name']).'</h3>
			<p class="service-add">'.stripslashes($data['wpffo_venue']).'</p>
			<p>
				<span class="event-icon">'.'<img src="'.get_site_url().'/wp-content/plugins/wp-obituary/images/map.png"'.'</span>
				'.stripslashes($data['wpffo_address']).'
			</p>';

		$date_time= $data['date_time'];

		if(!empty($date_time) && is_array($date_time)){

		foreach($date_time as $datetime ){

		$html.='<p>'.$datetime['wpffo_date'].'<br />'

		.$datetime['wpffo_time_from'].'"'.(!empty($datetime['wpffo_time_to']))?

			'<p>'

				.'<p class="service-date">

				<p><span class="event-icon">'.'<img src="'.get_site_url().'/wp-content/plugins/wp-obituary/images/calendar.png"'.'</span>'

				.$datetime['wpffo_date'].'</p>

				<p><span class="event-icon">'.'<img src="'.get_site_url().'/wp-content/plugins/wp-obituary/images/clock.png"'.'</span>'

				.$datetime['wpffo_time_from'].' - '.$datetime['wpffo_time_to']:''

			.'</p>';

				}

					}

	  
	  if(isset($datetime['wpffo_message'])){

	 $html.=' <p>'.$datetime['wpffo_message'].'</p>';
}
     

       $html.=' </div>';

		

		}

		}
		}$html.=' </div>';

}

	echo $html;	

}

add_action( 'wp_obituary_single_after_content', 'wpffo_obituary_services');


function wp_obituary_comment_form_submit_label($arg) {
	if ( is_singular('wp_obituary') || is_tax( 'obituary_cat' )) {
	$arg['label_submit'] = 'Submit Condolence';
		$arg['submit_button_label'] = 'Submit Condolence';
	}
	return $arg;
  }

  function wp_obituary_archive_title( $title ) {
    if ( is_category('obituary_cat') ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax('obituary_cat') ) {
        $title = single_term_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'wp_obituary_archive_title' );


  add_filter('comment_form_defaults', 'wp_obituary_comment_form_submit_label', 11);

  add_filter( 'get_the_archive_description', '__return_null');



function translate_text_to_germen($ttxt, $txt, $d) {
	global $wp_query;
	//var_dump($wp_query->query_vars['post_type']);
if($wp_query->query_vars['post_type']=='wp_obituary'){
   switch ($txt) {
      case 'Post comment':
         return 'Submit Condolence'; // Change text here
         break;
      
     case 'Leave a comment':
         return 'Offer Condolence'; // Change text here
         break; 
   }
}
   return $ttxt;
	
}

  add_filter('gettext', 'translate_text_to_germen', 20, 3);
/*

add_action('current_screen', 'wp_obituary_screen_callback');

function wp_obituary_screen_callback($screen) {
    if (  is_object($screen) && $screen->post_type == 'wp_obituary') {
        add_filter('gettext', 'translate_text_to_germen', 20, 3);
    }
}



add_action('current_screen', 'current_screen_callback');
function current_screen_callback($screen) {
    if( is_object($screen) && $screen->post_type == 'wp_obituary' ) {
        add_filter( 'gettext', 'theme_change_comments_label', 99, 3 );
    }
}

function theme_change_comments_label( $translated_text, $untranslated_text, $domain ) {

  
        $translated_text = str_ireplace( 'Post comment', 'Review', $untranslated_text ) ;
 

    return $translated_text;

}*/