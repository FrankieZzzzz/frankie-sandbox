<?php

// Site Auto Loading handling
function cleanThemeAutoload($class) {
  $file = dirname(__FILE__).'/includes/autoload_class/' .$class. '.php';
  if( file_exists($file) )
    require_once $file;
}
spl_autoload_register( 'cleanThemeAutoload' );

// Initialize global variables
$template_directory_uri = get_template_directory_uri();
$stylesheet_directory_uri = get_stylesheet_directory_uri();
$home_url = home_url();
$site_title = get_bloginfo("name");
$site_stylesheet_url = get_bloginfo("stylesheet_url");
$is_user_logged_in = is_user_logged_in();

// Get custom theme option from ACF
if (function_exists('acf_add_options_page') && function_exists('get_field')) {

  // Turn on output buffering
  ob_start();

  // set theme options page
  acf_set_options_page_menu('Theme Options');

  // set home alert options page
  $args = array(
    'page_title' => 'Home Alert',
    'menu_title' => 'Home Alert',
    'menu_slug' => 'home-alert',
    'capability' => 'edit_posts',
    'icon_url' => 'dashicons-align-center',
    'post_id' => 'options',
    'update_button'		=> __('Update', 'acf'),
    'updated_message'	=> __("Home Alert Updated", 'acf'),
  );
  acf_add_options_page( $args );

  // sticky header option
  if (!empty(get_field('header_settings', 'option')['sticky_header'])) {
    $site_sticky_header_option = get_field('header_settings', 'option')['sticky_header'];
  }
  // header width option
  if (!empty(get_field('header_settings', 'option')['header_width'])) {
    $site_header_width_option = get_field('header_settings', 'option')['header_width'];
  }
  // mobile menu option
  if (!empty(get_field('header_settings', 'option')['mobile_menu_type'])) {
    $site_mobile_menu_type = get_field('header_settings', 'option')['mobile_menu_type'];
  }
  // menu search icon
  if (!empty(get_field('header_settings', 'option')['search_options'])) {
    $site_search_options = get_field('header_settings', 'option')['search_options'];
  }
  // site logo
  if (!empty(get_field('header_settings', 'option')['logo_upload'])) {
    $site_header_logo = get_field('header_settings', 'option')['logo_upload'];
  }
  if (!empty(get_field('header_settings', 'option')['logo2_upload'])) {
    $site_header_logo2 = get_field('header_settings', 'option')['logo2_upload'];
  }
  // default banner
  if (!empty(get_field('header_settings', 'option')['default_banner_upload']['url'])) {
    $default_banner = get_field('header_settings', 'option')['default_banner_upload']['url'];
  }

  // smooth scrolling for anchors
  if (!empty(get_field('general_settings', 'option')['smooth_scrolling'])) {
    $smooth_scrolling = get_field('general_settings', 'option')['smooth_scrolling'];
  }
  // back to top
  if (!empty(get_field('general_settings', 'option')['back_to_top_button'])) {
    $back_to_top = get_field('general_settings', 'option')['back_to_top_button'];
  }

  // social share option
  if (!empty(get_field('social_share', 'option')['share_tag'])) {
    $site_social_share = get_field('social_share', 'option')['share_tag'];
  }

  // super footer option
  if (!empty(get_field('footer_settings', 'option')['super_footer'])) {
    $site_super_footer_option = get_field('footer_settings', 'option')['super_footer'];
  }
  if (!empty(get_field('footer_settings', 'option')['super_footer_columns'])) {
    $site_super_footer_columns = get_field('footer_settings', 'option')['super_footer_columns'];
  }
  if (!empty(get_field('footer_settings', 'option')['super_footer_bottom'])) {
    $site_super_footer_bottom = get_field('footer_settings', 'option')['super_footer_bottom'];
  }
  if (!empty(get_field('footer_settings', 'option')['super_footer_top'])) {
    $site_super_footer_top = get_field('footer_settings', 'option')['super_footer_top'];
  }

  // social media enable
  if (!empty(get_field('social_media_settings', 'option')['display_social_media'])) {
    $site_social_media_option = get_field('social_media_settings', 'option')['display_social_media'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_border'])) {
    $site_social_media_border = get_field('social_media_settings', 'option')['social_media_border'];
  }

  // social media links
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['youtube_link'])) {
    $site_social_youtube_option = get_field('social_media_settings', 'option')['social_media_links']['youtube_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['vimeo_link'])) {
    $site_social_vimeo_option = get_field('social_media_settings', 'option')['social_media_links']['vimeo_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['facebook_link'])) {
    $site_social_facebook_option = get_field('social_media_settings', 'option')['social_media_links']['facebook_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['twitter_link'])) {
    $site_social_twitter_option = get_field('social_media_settings', 'option')['social_media_links']['twitter_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['linkedin_link'])) {
    $site_social_linkedin_option = get_field('social_media_settings', 'option')['social_media_links']['linkedin_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['instagram_link'])) {
    $site_social_instagram_option = get_field('social_media_settings', 'option')['social_media_links']['instagram_link'];
  }
   if (!empty(get_field('social_media_settings', 'option')['social_media_links']['reddit_link'])) {
    $site_social_reddit_option = get_field('social_media_settings', 'option')['social_media_links']['reddit_link'];
  }
   if (!empty(get_field('social_media_settings', 'option')['social_media_links']['tiktok_link'])) {
    $site_social_tiktok_option = get_field('social_media_settings', 'option')['social_media_links']['tiktok_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['pinterest_link'])) {
    $site_social_pinterest_option = get_field('social_media_settings', 'option')['social_media_links']['pinterest_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['flickr_link'])) {
    $site_social_flickr_option = get_field('social_media_settings', 'option')['social_media_links']['flickr_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['tripadvisor_link'])) {
    $site_social_tripadvisor_option = get_field('social_media_settings', 'option')['social_media_links']['tripadvisor_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['ebay_link'])) {
    $site_social_ebay_option = get_field('social_media_settings', 'option')['social_media_links']['ebay_link'];
  }
  if (!empty(get_field('social_media_settings', 'option')['social_media_links']['news_subscribe_link'])) {
    $site_social_news_option = get_field('social_media_settings', 'option')['social_media_links']['news_subscribe_link'];
  }

  // footer Copyright
  if (!empty(get_field('footer_settings', 'option')['dynamic_copyright_year'])) {
    $site_copyright_year_option = get_field('footer_settings', 'option')['dynamic_copyright_year'];
  }
  if (!empty(get_field('footer_settings', 'option')['copyright_message'])) {
    $site_copyright_option = get_field('footer_settings', 'option')['copyright_message'];
  }
  if (!empty(get_field('footer_settings', 'option')['radii_branding_in_copyright'])) {
    $site_copyright_radii_option = get_field('footer_settings', 'option')['radii_branding_in_copyright'];
  }

  // footer disclaimer
  if (!empty(get_field('footer_settings', 'option')['disclaimer'])) {
    $site_footer_disclaimer = get_field('footer_settings', 'option')['disclaimer'];
  }

  // 404 message
  if (!empty(get_field('404_settings', 'option')['error_404_page_title'])) {
    $site_404_title = get_field('404_settings', 'option')['error_404_page_title'];
  }
  if (!empty(get_field('404_settings', 'option')['error_404_page_message'])) {
    $site_404_message = get_field('404_settings', 'option')['error_404_page_message'];
  }
  if (!empty(get_field('404_settings', 'option')['error_404_banner_image'])) {
    $site_404_image = get_field('404_settings', 'option')['error_404_banner_image']['url'];
  }

  // GA4
  if (!empty(get_field('site_scripts', 'option')['site_ga_id'])) {
    $site_ga_id = get_field('site_scripts', 'option')['site_ga_id'];
  }
  // GTM
  if (!empty(get_field('site_scripts', 'option')['google_tag_manager'])) {
    $site_google_tag_manager = get_field('site_scripts', 'option')['google_tag_manager'];
  }
  if (!empty(get_field('site_scripts', 'option')['scripts_in_header'])) {
    $site_scripts_header = get_field('site_scripts', 'option')['scripts_in_header'];
  }
  if (!empty(get_field('site_scripts', 'option')['scripts_in_footer'])) {
    $site_scripts_footer = get_field('site_scripts', 'option')['scripts_in_footer'];
  }

  // cache busting
  if(!empty(get_field('general_settings', 'option')['development_mode'])) {
    $site_dev_mode = get_field('general_settings', 'option')['development_mode'];
  }
  if(!empty(get_field('general_settings', 'option')['cache_version_override'])) {
    $site_cache_ver_override = get_field('general_settings', 'option')['cache_version_override'];
  }
  
  // comments form
  if(!empty(get_field('general_settings', 'option')['comments_form'])) {
    $site_comments_form = get_field('general_settings', 'option')['comments_form'];
  }

  // XMLRPC handling
  if(!empty(get_field('general_settings', 'option')['xmlrpc_option'])) {
    $site_use_xmlrpc_option = get_field('general_settings', 'option')['xmlrpc_option'];
  }

  // Disable SME Parent CSS
  if(!empty(get_field('general_settings', 'option')['parent_css'])) {
    $site_parent_css = get_field('general_settings', 'option')['parent_css'];
  }

}

// Version number variable for cache busting
if (isset($site_cache_ver_override) && $site_cache_ver_override){
  // Manual Override
  $cacheVersion = $site_cache_ver_override;
} elseif (isset($site_dev_mode) && $site_dev_mode){
  // Cache busting every minute
  $cacheVersion = date('Y') . 'd' . date('z') . 't' . date('H') . date('i') . 's' . date('s');
} else {
  // Cache busting every week
  $cacheVersion = date('Y') . 'w' . date('W');
}

// DISABLE XMLRPC handling
if(isset($site_use_xmlrpc_option) && !$site_use_xmlrpc_option) {

    add_filter("xmlrpc_enabled", "__return_false");
    // if call this, just die.
    if ( ! defined( "WPINC" ) ) {
      die;
    }
    // DISABLE xmlrpc pingback handling
    add_filter( "xmlrpc_methods", "remove_xmlrpc_pingback_ping" );
    function remove_xmlrpc_pingback_ping( $methods ) {
       unset( $methods["pingback.ping"] );
       return $methods;
    }
}

// DISABLE comments handling
if(isset($site_comments_form) && !$site_comments_form) {
  // Close comments on the front-end
  function site_disable_comments_status() {
    return false;
  }
  add_filter('comments_open', 'site_disable_comments_status', 20, 2);
  add_filter('pings_open', 'site_disable_comments_status', 20, 2);
  // Hide existing comments
  function site_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
  }
  add_filter('comments_array', 'site_disable_comments_hide_existing_comments', 10, 2);
}


//robots.txt ==============================================
add_filter('robots_txt',
function ($robotstext, $public){

	//check site option
	if( get_option( 'blog_public' ) == 0 ){
	$robotstext = "User-agent: *
Disallow: /";
	}else {
	$robotstext = "User-agent: *
Disallow: /wp-admin/
Disallow: /wp-login.php
Allow: /wp-admin/admin-ajax.php";
	}

    return $robotstext;
}
, 10, 2);

// Remove VC meta generator
add_action('wp_head', 'remove_vc_meta', 1);
function remove_vc_meta() {
  if ( class_exists( 'Vc_Manager' ) ) {
    remove_action('wp_head', array(visual_composer(), 'addMetaData'));
  }
}

// New allowed mime types.
function custom_mime_types($mimes) {
  $mimes['ico'] = 'image/x-icon';
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'custom_mime_types' );

?>