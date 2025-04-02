<?php
global $cacheVersion,
	$template_directory_uri,
	$stylesheet_directory_uri,
	$current_user,
	$site_title,
	$home_url,
	$site_stylesheet_url,
	$site_sticky_header_option,
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
<?php wp_head(); ?>
<?php
// $twitter_image = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url($post->ID, 'medium' ) : get_field( 'social_share', 'option' )['twitter_image'];
$twitter_image = get_field( 'social_share', 'option' )['twitter_image'];
$facebook_image = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url($post->ID, 'medium' ) : get_field( 'social_share', 'option' )['facebook_image'];
$facebook_app_id = get_field( 'social_share', 'option' )['facebook_app_id'];
$share_descr = get_the_excerpt() ? get_the_excerpt() : get_bloginfo('description');
?>
<meta name="description" content="">
<link rel="canonical" href="<?php echo home_url( $wp->request )?>">
<?php 
/*facebook share meta*/
if ($facebook_app_id) : ?>
<meta property="og:title" content="<?php echo get_the_title()?>">
<meta property="og:locale" content="<?php echo get_locale()?>">
<meta property="og:description" content="<?php echo $share_descr ?>">
<meta property="og:url" content="<?php echo home_url( $wp->request )?>">
<meta property="og:site_name" content="<?php echo get_bloginfo('name')?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo $facebook_image?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="1280" />
<meta property="og:image:height" content="720" />
<meta property="fb:app_id" content="<?php echo get_field( 'social_share', 'option' )['facebook_app_id'] ?>" />
<?php endif; ?>
<meta name="twitter:title" content="<?php echo get_the_title()?>">
<meta name="twitter:description" content="<?php echo $share_descr ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="<?php echo $twitter_image ?>">
<link rel="stylesheet" href="https://cloud.typography.com/7600420/6629632/css/fonts.css">
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
 <!-- Fundraise Up: the new standard for online giving -->
<script>(function(w,d,s,n,a){if(!w[n]){var l='call,catch,on,once,set,then,track'
.split(','),i,o=function(n){return'function'==typeof n?o.l.push([arguments])&&o
:function(){return o.l.push([n,arguments])&&o}},t=d.getElementsByTagName(s)[0],
j=d.createElement(s);j.async=!0;j.src='https://cdn.fundraiseup.com/widget/'+a+'';
t.parentNode.insertBefore(j,t);o.s=Date.now();o.v=4;o.h=w.location.href;o.l=[];
for(i=0;i<7;i++)o[l[i]]=o(l[i]);w[n]=o}
})(window,document,'script','FundraiseUp','AHNCTTUS');</script>
<!-- End Fundraise Up -->
</head>

<body id="top" <?php body_class($site_mobile_menu_type); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KRFJ3P5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php 
/*facebook share script*/
if ($facebook_app_id) : ?>
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
<?php endif; ?>
<div id="site-body">
	<a class="skip-to-content" href="#site-content">
		Skip to content
	</a>
<?php $site_header_sticky_class = (isset($site_sticky_header_option) && $site_sticky_header_option)?'site-header-sticky':'';?>

<?php
		// Global Home Alert
		$home_banner_alert_options = false;
		if (function_exists('get_field')) {
			$home_banner_alert_options = get_field('home_banner_alert_options', 'options');
		}
		if (is_front_page() && !empty($home_banner_alert_options['display'])) {
	?>
	<div class="header__alert">
		<?php if ($home_banner_alert_options['link']) { ?>
			<a href="<?php echo $home_banner_alert_options['link']['url']; ?>" target="<?php echo $home_banner_alert_options['link']['target']; ?>">
				<div class="container-fluid">
					<?php echo $home_banner_alert_options['text'] ?>
				</div>
			</a>
		<?php } else { ?>
			<div class="container-fluid">
				<?php echo $home_banner_alert_options['text'] ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<header id="site-header" class="<?php echo $site_header_sticky_class; ?>">

	<div class="header__main" role="navigation">

		<div class="container-lg">
			<div class="row">
				<div class="col-12 p-0">
					<?php
						if(has_nav_menu('mobile-global-menu')) {
							wp_nav_menu( array( 'theme_location' => 'mobile-global-menu', 'container_id' => 'mobile-global-navbar', 'container' => 'div', 'container_class' => 'header__global-mobile d-xl-none', 'menu_class'=>'navbar-nav d-flex d-lg-none justify-content-between flex-row','walker' => new BootstrapWalker()) );
						}
					?>
				</div>
				<div class="col-xl-5 header__main-wrapper">
					<div class="header__main-logo-wrapper d-flex align-items-center justify-content-between">
						<div class="header__main-logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="d-flex align-items-center justify-content-left">
							<?php if(isset($site_header_logo) && $site_header_logo) { ?>
								<img src="<?php echo $site_header_logo['url']; ?>" class="logo" alt="<?php echo get_bloginfo( 'name' ); ?>" width="107" height="99" />
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
						<div class="d-flex align-items-center d-xl-none">
							<?php
								if(has_nav_menu('mobile-donate-menu')) {
									wp_nav_menu( array( 'theme_location' => 'mobile-donate-menu', 'container_id' => 'mobile-donate-navbar', 'container' => 'div', 'container_class' => '', 'menu_class'=>'','walker' => new BootstrapWalker()) );
								}
							?>
							<button id="mobile-nav-btn" class="header__main-mobile navbar-toggle mmenu-toggle" aria-label="Menu Toggle">
								<div class="hamburger-container">
									<i class="fa-solid fa-bars"></i>
								</div>
							</button>
						</div>
					</div>
				</div>
				<div class="col-xl-7 d-none d-xl-flex justify-content-end align-items-end flex-column header__main-nav">
					<?php if( has_nav_menu('global-menu') || isset($site_social_media_option) && in_array('header', $site_social_media_option) || isset($site_search_options) && $site_search_options['display'] == 'global' ){ ?>
					<div class="header__global-nav navbar-expand-md justify-content-end align-items-center d-flex">
						<?php
							// Call Social Media
							if(isset($site_social_media_option) && in_array('header', $site_social_media_option)) {
								// see site_social_media.php
								echo do_shortcode('[social_media_bar]');
							}
							// Call Site Search
							if(isset($site_search_options) && $site_search_options['display'] == 'global') {
								if($site_search_options['type'] == 'icon') {
									// Call Navigation search icon - Search modal located in footer
									echo '<button type="button" class="header__global-search" id="search-btn" aria-label="Search"><i class="fa-regular fa-magnifying-glass"></i></button>';
									echo '<button type="submit" class="header__global-search" id="search-submit-btn" aria-label="Search"><i class="fa-regular fa-magnifying-glass"></i></button>';
									echo '<form role="search" method="get" class="header__global-searchform" action="' . home_url( '/' ) . '"><label for="header-search-form" class="sr-only">Search</label><input type="text" id="header-search-form" class="form-control" placeholder="Search" name="s" required></form>';
								} else if ($site_search_options['type'] == 'input') {
									// Call Navigation search input
									echo '<form role="search" method="get" class="header__global-searchform" action="' . home_url( '/' ) . '"><label for="header-search-form" class="sr-only">Search</label><input type="text" id="header-search-form" class="form-control" placeholder="Search" name="s" required></form>';
								}
							}
							// Call Global Navigation
							if(has_nav_menu('global-menu')) {
								wp_nav_menu( array( 'theme_location' => 'global-menu', 'container_id' => 'global-navbar', 'container' => 'div', 'container_class' => 'header__global-nav__menu', 'menu_class'=>'navbar-nav ml-auto','walker' => new BootstrapWalker()) );
							}							
						?>
					</div>
					<?php } ?>
					<div class="header__primary-nav navbar-expand-md justify-content-end align-items-center d-flex">
						<?php
							if(isset($site_search_options) && $site_search_options['display'] == 'main') {
								if($site_search_options['type'] == 'icon') {
									// Call Navigation search icon - Search modal located in footer
									echo '<a href="#" class="header__primary-search" data-toggle="modal" data-target="#searchModal"><i class="fa-regular fa-magnifying-glass"></i></a>';
								} else if ($site_search_options['type'] == 'input') {
									// Call Navigation search input
									echo '<form role="search" method="get" class="header__primary-searchform" action="' . home_url( '/' ) . '"><input type="text" class="form-control" placeholder="Search" name="s" required></form>';
								}
							}
							if(has_nav_menu( 'main-menu' )){
								wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'main-menu', 'container' => 'div', 'container_class' => 'header__primary-nav__menu', 'menu_class' => 'navbar-nav', 'walker' => new BootstrapWalker()) );
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

</header><!-- .header -->

<?php get_template_part('global-menu-mobile'); ?>

<div id="site-content" role="main">
