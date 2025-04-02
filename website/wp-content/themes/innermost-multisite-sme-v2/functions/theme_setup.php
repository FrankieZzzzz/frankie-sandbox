<?php
/* Function: custom_theme_setup */

add_action('after_setup_theme', 'custom_theme_setup');

function custom_theme_setup(){

	//enable post thumbnails - feature image
	add_theme_support('post-thumbnails');

	//enable automatic feed links
	add_theme_support('automatic-feed-links');

	//register menu location
	register_nav_menus( array(
		'main-menu' => 'Main Menu',
		'secondary-menu' => 'Secondary Menu',
		'global-menu' => 'Global Menu',
		'footer-menu' => 'Footer Menu',
		'mobile-menu' => 'Mobile Menu',
		'sfooter-menu-1' => 'Super Footer Menu 1',
		'sfooter-menu-2' => 'Super Footer Menu 2',
		'sfooter-menu-3' => 'Super Footer Menu 3',
		'sfooter-menu-4' => 'Super Footer Menu 4',
		'sfooter-menu-5' => 'Super Footer Menu 5',
		'sfooter-menu-6' => 'Super Footer Menu 6',
		'error-404-menu' => 'Error 404 Menu'
	) );

	if (is_singular()) wp_enqueue_script('comment-reply');

	//add custom header theme support
	add_theme_support('custom-header');

	//add custom background theme support
	add_theme_support('custom-background');

	//add title tag theme support
	add_theme_support('title-tag');

	//add editor style to theme
	add_editor_style();

}

/* Function: baw_hack_wp_title_for_home - customize wp title */
add_filter('wp_title', 'custom_wp_title');
function custom_wp_title( $title ){
	global $site_title;
	if( empty( $title ) && ( is_home() || is_front_page() ) ) {
		return $site_title;
	}else{
		return $title . $site_title;
	}
	return $title;
}

/* Function: custom_scripts_styles - add js/css to header or footer */
function custom_scripts_styles() {
	global
	$cacheVersion,
	$template_directory_uri;
	wp_enqueue_script('jquery');
	// $css_minify = 0;
	// $js_minify = 0;
	//link style.css
	wp_enqueue_style('style-css', $template_directory_uri . '/style.css', '' ); // empty theme css file
}
add_action('wp_enqueue_scripts', 'custom_scripts_styles');

/* Function: Deferred non-core dependant stylesheets to footer */
function deferred_footer_scripts_styles() {
	global
	$cacheVersion,
	$smooth_scrolling,
	$template_directory_uri;

	//link bootstrap v5 css
	wp_enqueue_style('bootstrap5-css', $template_directory_uri . '/vendor/bootstrap/5.3.3/css/bootstrap.min.css', '', '5.3.3');

	// link font awesome 6 css
	wp_enqueue_style('fontawesome6-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/fontawesome.min.css', '', '6.5.1' );
	wp_enqueue_style('fontawesome6-brands-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/brands.min.css', '', '6.5.1' );
	// wp_enqueue_style('fontawesome6-thin-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/thin.min.css', '', '6.5.1' );
	// wp_enqueue_style('fontawesome6-light-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/light.min.css', '', '6.5.1' );
	wp_enqueue_style('fontawesome6-regular-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/regular.min.css', '', '6.5.1' );
	// wp_enqueue_style('fontawesome6-solid-css', $template_directory_uri . '/vendor/fontawesome/6.5.1/css/solid.min.css', '', '6.5.1' );

	//link bootstrap v5 js bundle
	wp_enqueue_script('bootstrap5-js', $template_directory_uri . '/vendor/bootstrap/5.3.3/js/bootstrap.bundle.min.js', '', '5.3.3');



	//link bootstrap v5 css
	// wp_enqueue_style('bootstrap5-css', $template_directory_uri . '/vendor/bootstrap/5.1.3/css/bootstrap.min.css', '', '5.1.3');

	// link font awesome 6 css
	// wp_enqueue_style('fontawesome6-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/fontawesome.min.css', '', '6.4.2' );
	// wp_enqueue_style('fontawesome6-brands-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/brands.min.css', '', '6.4.2' );
	// wp_enqueue_style('fontawesome6-thin-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/thin.min.css', '', '6.4.2' );
	// wp_enqueue_style('fontawesome6-light-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/light.min.css', '', '6.4.2' );
	// wp_enqueue_style('fontawesome6-regular-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/regular.min.css', '', '6.4.2' );
	// wp_enqueue_style('fontawesome6-solid-css', $template_directory_uri . '/vendor/fontawesome/6.4.2/css/solid.min.css', '', '6.4.2' );

	//link bootstrap v5 js bundle
	// wp_enqueue_script('bootstrap5-js', $template_directory_uri . '/vendor/bootstrap/5.1.3/js/bootstrap.bundle.min.js', '', '5.1.3');

	if (isset($smooth_scrolling) && $smooth_scrolling){
		wp_enqueue_script('smooth-scroll', $template_directory_uri .'/js/smoothscroll.min.js', '', '1.0' );
	}

	//link global common js
	//wp_enqueue_script('common-js', $template_directory_uri . '/js/common.min.js', '', $cacheVersion, true );
	wp_enqueue_script('common-js', $template_directory_uri . '/js/common.js', '', $cacheVersion, true );
	wp_localize_script( 'common-js', 'social_share_object',
        array(
            'twitterURL' => 'https://twitter.com/share?url={0}&text={1}&hashtags={2}&via={3}&related={4}',
            //'facebookURL' => "https://www.facebook.com/dialog/share?app_id={0}&method=share&href={1}",
			//'fbapp' => get_field( 'social_share', 'option' )['facebook_app_id'],
			'linkedinURL' => 'https://www.linkedin.com/sharing/share-offsite/?url={0}',
			'shareTag' => get_field( 'social_share', 'option' )['share_tag'],
			'share' => sprintf('%s - %s', get_the_title(), get_bloginfo('name')),
			'mailto' => 'mailto:?subject={0}&BODY={1}',
        )
    );
}
add_action('get_footer', 'deferred_footer_scripts_styles');

/* Function: Insert GA4 script to the header */
function insert_ga4_script() {
	global $site_ga_id;
	if (isset($site_ga_id) && $site_ga_id){
		echo '<!-- Global site tag (gtag.js) - Google Analytics 4 -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=' . $site_ga_id . '"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag(\'js\', new Date());gtag(\'config\', \'' . $site_ga_id . '\');
			</script>';
	}
}
add_action('wp_head', 'insert_ga4_script');

/* Function: Insert GTM code snippets */
function insert_head_google_tag_manager() {
	global $site_google_tag_manager;
	if (isset($site_google_tag_manager) && $site_google_tag_manager){
		echo sprintf("<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','%s');</script>
<!-- End Google Tag Manager -->", $site_google_tag_manager);
	}
}
add_action('wp_head', 'insert_head_google_tag_manager');
function insert_body_google_tag_manager() {
	global $site_google_tag_manager;
	if (isset($site_google_tag_manager) && $site_google_tag_manager){
		echo sprintf('<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->', $site_google_tag_manager);
	}
}
add_action('wp_body_open', 'insert_body_google_tag_manager',5 );

/* Function: Insert scripts to the footer */
function insert_footer_scripts() {
	global $site_scripts_footer;
	if (isset($site_scripts_footer) && $site_scripts_footer){
		echo $site_scripts_footer;
	}
}
add_action('wp_footer', 'insert_footer_scripts');

/* Add widgets sidebar */
function custom_widgets_init(){
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'id' => 'sidebar-1',
		'description' => 'Appears on template pages with sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'sidebar-blog',
		'description' => 'Appears on posts',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Terms & Conditions',
		'id' => 'sidebar-privacy',
		'description' => 'Appears on pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}
add_action('widgets_init', 'custom_widgets_init');

/* Add custom dynamic widgets */

// custom recent posts with image
require_once "includes/custom_widgets/recent_post_with_img.php";

// custom recent posts with image
require_once "includes/custom_widgets/in_this_section_menu.php";

// add missing meta desc tag to events archive
function add_meta_desc_events_archive() {
	if ( is_post_type_archive( 'tribe_events' ) ) {
		echo '<meta name="description" content="Viewing all ' . get_bloginfo( 'name' ) . ' upcoming events, please check back often."/>';
	}
	return;
}
add_action( 'wp_head', 'add_meta_desc_events_archive' );

/* Page slug body class */
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/* custom vc file picker */
if(function_exists('vc_add_shortcode_param')) {
	require_once "theme_vc_functions.php";
}

/*
 * Create a column. And maybe remove some of the default ones
 * @param array $columns Array of all user table columns {column ID} => {column Name}
 */
add_filter( 'manage_users_columns', 'radii_modify_user_table' );

function radii_modify_user_table( $columns ) {

	// unset( $columns['posts'] ); // maybe you would like to remove default columns
	$columns['registration_date'] = 'Registration Date'; // add new

	return $columns;

}

/*
 * Fill our new column with the registration dates of the users
 * @param string $row_output text/HTML output of a table cell
 * @param string $column_id_attr column ID
 * @param int $user user ID (in fact - table row ID)
 */
add_filter( 'manage_users_custom_column', 'radii_modify_user_table_row', 10, 3 );

function radii_modify_user_table_row( $row_output, $column_id_attr, $user ) {

	$date_format = 'j M, Y H:i';

	switch ( $column_id_attr ) {
		case 'registration_date' :
			return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
			break;
		default:
	}

	return $row_output;

}

/*
 * Make our "Registration date" column sortable
 * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param}
 */
add_filter( 'manage_users_sortable_columns', 'radii_make_registered_column_sortable' );

function radii_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}

// excerpt trim function
if ( !function_exists( 'innermost_wp_trim_words' ) ) :
	function innermost_wp_trim_words( $text, $num_words = 55, $more = null ) {
	  if ( null === $more ) {
		$more = esc_html__( '&hellip;' );
	  }
	  $original_text = $text;
	  $html_tags = array('</p>', '</h1>', '</h2>', '</h3>', '</h4>', '</h5>', '</h6>', '</b>', '</a>', '</strong>', '</i>', '</li>');
	  $html_tags_space = array(' </p>', ' </h1>', ' </h2>', ' </h3>', ' </h4>', ' </h5>', ' </h6>', ' </b>', ' </a>', ' </strong>', ' </i>', ' </li>');
	  $text = str_replace($html_tags, $html_tags_space, $text);

	  $text = wp_strip_all_tags( $text );

	  $text = trim( preg_replace( '/[\n\r\t ]+/', ' ', $text ), ' ' );
	  preg_match_all( '/./u', $text, $words_array );
	  $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
	  $sep = '';

	  if ( count( $words_array ) > $num_words ) {
		array_pop( $words_array );
		$text = implode( $sep, $words_array );
		$text = $text . $more;
	  } else {
		$text = implode( $sep, $words_array );
	  }
	  return apply_filters( 'wp_trim_words', $text, $num_words, $more, $original_text );
	}
endif;

/* truncate_post function - auto-creation of post excerpts */
if ( !function_exists( 'truncate_post' ) ) :
	function truncate_post( $amount = 386, $echo = true, $post = '' ) {
	  if ( '' == $post ) {
		global $post;
	  }

	  if ( post_password_required( $post ) ) {
		$post_excerpt = get_the_password_form();

		if ( $echo ) {
		  echo $post_excerpt;
		  return;
		}

		return $post_excerpt;
	  }

	  $post_excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );

	  // get the post content
	  $truncate = $post->post_content;

	  // remove number counter shortcode
	  $truncate = preg_replace('/\[number_counter_widget(.+?)?\](?:(.+?)?\[\/number_counter_widget\])?/', '', $truncate);

	  // remove caption shortcode from the post content
	  $truncate = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate);

	  // apply content filters
	  $truncate = apply_filters( 'the_content', $truncate );

	  // decide if we need to append dots at the end of the string
	  if ( strlen( $truncate ) <= $amount ) {
		$echo_out = '';
	  } else {
		$post_link = get_the_permalink($post->ID);
		if ($post_link) {
		  $echo_out = " <a href='{$post_link}'>[...]</a>";
		} else {
		  $echo_out = ' [...]';
		}
		// $amount = $amount - 3;
	  }

	  // trim text to a certain number of characters, also remove spaces from the end of a string ( space counts as a character )
	  $truncate = rtrim( innermost_wp_trim_words( $truncate, $amount, '' ) );

	  // remove the last word to make sure we display all words correctly
	  if ( '' != $echo_out ) {
		$new_words_array = (array) explode( ' ', $truncate );
		array_pop( $new_words_array );

		$truncate = implode( ' ', $new_words_array );

		// append dots to the end of the string
		$truncate .= $echo_out;
	  }

	  if ( $echo ) {
		echo $truncate;
	  } else {
		return $truncate;
	  }
	}
endif;

?>