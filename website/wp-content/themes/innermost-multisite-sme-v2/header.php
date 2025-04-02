<?php
global $cacheVersion,
	$template_directory_uri,
	$stylesheet_directory_uri,
	$current_user,
	$site_title,
	$home_url,
	$site_stylesheet_url,
	$site_sticky_header_option,
    $site_header_width_option,
	$site_mobile_menu_type,
	$site_search_options,
	$site_social_media_option,
	$site_header_logo,
	$site_header_logo2,
	$site_parent_css,
	$site_scripts_header;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php 
        wp_head(); 
        $twitter_image = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url($post->ID, 'medium' ) : get_field( 'social_share', 'option' )['twitter_image'];
        $facebook_image = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url($post->ID, 'medium' ) : get_field( 'social_share', 'option' )['facebook_image'];
        $facebook_app_id = get_field( 'social_share', 'option' )['facebook_app_id'];
        $share_descr = get_the_excerpt() ? get_the_excerpt() : get_bloginfo('description');
    ?>
    <meta name="description" content="<?php echo $share_descr ?>">
    <link rel="canonical" href="<?php echo home_url( $wp->request )?>">
    <?php
        // META Open Graph
        if ($facebook_image) : ?>
        <meta property="og:url" content="<?php echo home_url( $wp->request )?>">
        <meta property="og:title" content="<?php echo get_the_title()?>">
        <meta property="og:description" content="<?php echo $share_descr ?>">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="<?php echo get_locale()?>">
        <meta property="og:image" content="<?php echo $facebook_image?>" />
    <?php endif; ?>
    <?php 
        // FB APP ID
        if ($facebook_app_id) : ?>
        <meta property="fb:app_id" content="<?php echo get_field( 'social_share', 'option' )['facebook_app_id'] ?>" />
    <?php endif; ?>
    <?php 
        // META Twitter Image
        if ($twitter_image): ?>
        <meta name="twitter:title" content="<?php echo get_the_title()?>">
        <meta name="twitter:description" content="<?php echo $share_descr ?>">
        <meta name="twitter:image" content="<?php echo $twitter_image ?>">
        <meta name="twitter:card" content="summary_large_image">
    <?php endif; ?>
    <?php
        // SME Parent CSS toggle
        if ($site_parent_css != true) : ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $template_directory_uri; ?>/css/style.css?ver=<?php echo $cacheVersion; ?>">
    <?php endif; ?>
    <?php
        // Include child stylesheet if using child theme
        if(is_child_theme()) : ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $stylesheet_directory_uri; ?>/css/child-style.css?ver=<?php echo $cacheVersion; ?>">
    <?php endif; ?>
    <?php 
        // Custom header script option
        if (isset($site_scripts_header) && $site_scripts_header){
            echo $site_scripts_header;
        }
    ?>
    <?php
        // Preload video.js on front page
        if (is_front_page() && is_plugin_active( 'advanced-custom-fields-pro/acf.php') && get_field('vid_intro_banner')) : ?>
        <link href="<?php echo $template_directory_uri; ?>/vendor/videojs/video-js.min.css" rel="stylesheet">
        <script src="<?php echo $template_directory_uri; ?>/vendor/videojs/video.min.js"></script>
    <?php endif; ?>
</head>

<body id="top" <?php body_class($site_mobile_menu_type); ?>>
<?php wp_body_open(); ?>
<?php 
/*facebook share script*/
if ($facebook_app_id) :?>
<script>
window.fbAsyncInit = function() {
FB.init({
appId: '<?php echo get_field( 'social_share', 'option' )['facebook_app_id'] ?>',
autoLogAppEvents : true,
xfbml: true,
version: 'v11.0'
});
};
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<?php endif;?>
<?php $site_header_sticky_class = (isset($site_sticky_header_option) && $site_sticky_header_option)?'site-header-sticky':'';?>

<div id="site-body">

<?php if(is_front_page()) {?>
	<a class="skip-link screen-reader-text" href="#main-content"><?php echo __('Skip to content', "SITE_TEXT_DOMAIN"); ?></a>
<?php } else { ?>
	<a class="skip-link screen-reader-text" href="#main-content"><?php echo __('Skip to content', "SITE_TEXT_DOMAIN"); ?></a>
<?php }; ?>

<div id="site-header" class="<?php echo $site_header_sticky_class; ?>">

	<?php
		// Global Home Alert
		$home_banner_alert_options = false;
		if (function_exists('get_field')) {
			$home_banner_alert_options = get_field('home_banner_alert_options', 'options');
		}
		if (is_front_page() && !empty($home_banner_alert_options['display'])) {
	?>
	<div id="head-alert" class="header__alert" role="alert">
		<?php if ($home_banner_alert_options['link'] && $home_banner_alert_options['content']) { ?>
			<a href="<?php echo $home_banner_alert_options['link']['url']; ?>" data-bs-toggle="modal" data-bs-target="#smeAlertModal" aria-label="<?php _e('Banner Alert', "SITE_TEXT_DOMAIN"); ?>">
				<main class="container-fluid" aria-label="<?php _e('Banner Alert', "SITE_TEXT_DOMAIN"); ?>">
					<?php echo $home_banner_alert_options['text'] ?>
                </main>
			</a>
			<div class="modal fade" id="smeAlertModal" tabindex="-1" role="dialog" aria-labelledby="smeAlertModal" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-body">
			        		<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			          			<i class="far fa-xmark"></i>
			        		</button>
			        		<?php echo $home_banner_alert_options['content'] ?>
			      		</div>
			    	</div>
			  	</div>
			</div>
		<?php } else if ($home_banner_alert_options['link']) { ?>
			<a href="<?php echo $home_banner_alert_options['link']['url']; ?>" target="<?php echo $home_banner_alert_options['link']['target']; ?>" aria-label="<?php _e('Banner Alert', "SITE_TEXT_DOMAIN"); ?>">
				<main class="container-fluid" aria-label="<?php _e('Banner Alert', "SITE_TEXT_DOMAIN"); ?>">
					<?php echo $home_banner_alert_options['text'] ?>
                </main>
			</a>
		<?php } else { ?>
			<div class="container-fluid">
				<?php echo $home_banner_alert_options['text'] ?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<div class="header__main">

		<div class="<?php echo $site_header_width_option; ?>">
			<div class="row">
				<div class="col-md-3 header__main-wrapper">
					<div class="header__main-logo-wrapper d-flex align-items-center justify-content-between">
						<div id="site-logo" class="header__main-logo" role="navigation">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="d-flex align-items-center justify-content-left" aria-label="<?php _e('Home', "SITE_TEXT_DOMAIN"); ?>">
							<?php if(isset($site_header_logo) && $site_header_logo) { ?>
								<img src="<?php echo $site_header_logo['url']; ?>" class="logo" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
								<?php
									// Use code below to display secondary logo
									if (isset($site_header_logo2) && $site_header_logo2) {
										echo "<img src='${site_header_logo2['url']}' class='logo2' alt='${site_header_logo2['alt']}'/>";
									}
								?>
							<?php } else { ?>
								<?php echo get_bloginfo( 'name' ); ?>
							<?php } ?>
							</a>
						</div>
						<button class="header__main-mobile d-md-none" aria-label="Menu Toggle"><i class="far fa-bars"></i></button>
					</div>
					<?php get_template_part('global-menu-mobile'); ?>
				</div>
				<div class="col-md-9 d-none d-md-block ">
					<?php if( has_nav_menu('global-menu') || isset($site_social_media_option) && in_array('header', $site_social_media_option) || isset($site_search_options) && $site_search_options['display'] == 'global' ){ ?>
					<div class="header__global-nav navbar-expand-md justify-content-end align-items-center d-flex">
						<?php
							// Call Social Media
							if(isset($site_social_media_option) && in_array('header', $site_social_media_option)) {
								// see site_social_media.php
								echo do_shortcode('[social_media_bar]');
							}
							// Call Global Navigation
							if(has_nav_menu('global-menu')) {
								wp_nav_menu( array( 'theme_location' => 'global-menu', 'container_id' => 'global-navbar', 'container' => 'nav', 'container_aria_label' => 'Global Menu', 'container_class' => 'header__global-nav__menu', 'menu_class'=>'navbar-nav ml-auto','walker' => new BootstrapWalker()) );
							}
							// Call Site Search
							if(isset($site_search_options) && $site_search_options['display'] == 'global') {
								if($site_search_options['type'] == 'icon') {
									// Call Navigation search icon - Search modal located in footer
									echo '<a href="#" class="header__global-search" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Site Search Toggle"><i class="far fa-search"></i></a>';
								} else if ($site_search_options['type'] == 'input') {
									// Call Navigation search input
									echo '<form role="search" method="get" class="header__global-searchform" action="' . home_url( '/' ) . '"><input type="text" class="form-control" placeholder="Search" name="s" required aria-label="Site Search Input"></form>';
								}
							}
						?>
					</div>
					<?php } ?>
					<div class="header__primary-nav navbar-expand-md justify-content-end align-items-center d-flex">
						<?php
							if(has_nav_menu( 'main-menu' )){
								wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'main-menu', 'container' => 'nav', 'container_aria_label' => 'Primary Menu', 'container_class' => 'header__primary-nav__menu', 'menu_class' => 'navbar-nav', 'walker' => new BootstrapWalker()) );
							}
							if(isset($site_search_options) && $site_search_options['display'] == 'main') {
								if($site_search_options['type'] == 'icon') {
									// Call Navigation search icon - Search modal located in footer
									echo '<a href="#" class="header__primary-search" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Site Search Toggle"><i class="far fa-search"></i></a>';
								} else if ($site_search_options['type'] == 'input') {
									// Call Navigation search input
									echo '<form role="search" method="get" class="header__primary-searchform" action="' . home_url( '/' ) . '"><input type="text" class="form-control" placeholder="Search" name="s" required aria-label="Site Search Input"></form>';
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>

		<?php
			// Call Mobile Global Navigation
			if(has_nav_menu( 'secondary-menu' )){
				echo '<div class="header__secondary"><div class="container-lg"><div class="row"><div class="col navbar-expand-md">';
				wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container_id' => '', 'container' => 'div', 'container_class' => 'header__secondary__menu', 'menu_class'=>'header__secondary__menu__nav navbar-nav','walker' => new BootstrapWalker()) );
				echo '</div></div></div></div>';
			}
		?>

	</div><!-- .header__main -->

</div><!-- .header -->