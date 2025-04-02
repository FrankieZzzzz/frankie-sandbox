<?php
	$menu = 'main-menu';
	if( has_nav_menu('mobile-menu') ){
		$menu = 'mobile-menu';
	}
	if( has_nav_menu('main-menu') || has_nav_menu('mobile-menu') ){
		wp_nav_menu( array( 'theme_location' => $menu, 'container' => 'nav', 'container_class' => 'mobile-menu d-md-none', 'container_id' => 'mobile-menu', 'menu_class' => 'navbar-nav', 'container_aria_label' => 'Mobile Menu', 'items_wrap' => '<div class="navbar-head"><button class="mm-close" aria-label="Close Menu"><i class="far fa-xmark"></i></button></div><ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new MobileMenuWalker() ) );
	}
?>