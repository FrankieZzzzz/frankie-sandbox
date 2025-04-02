<?php
	$menu = 'main-menu';
	$menu_html = '';
	if( has_nav_menu('mobile-menu') ){
		$menu = 'mobile-menu';
		$social_html = '

        <div class="mobile-social-media-icons">
			<a href="https://www.facebook.com/csjto" target="_blank" aria-label="Facebook icon"><i class="fa-brands fa-facebook"></i></a>
			<a href="https://www.youtube.com/user/CSJTO" target="_blank" aria-label="Google icon"><i class="fa-brands fa-youtube"></i></a>
		</div>';
		
		$menu_html = '<ul id="%1$s" class="%2$s">%3$s';	
		$menu_html .= "{$social_html}";
		$menu_html .= '</ul>';
	}
	
	if( has_nav_menu('main-menu') || has_nav_menu('mobile-menu') ){
		// wp_nav_menu( array( 'theme_location' => $menu, 'container' => 'nav', 'container_class' => 'mobile-menu d-lg-none', 'container_id' => 'mobile-menu', 'menu_class' => 'navbar-nav', 'items_wrap' => '<div class="navbar-head"><button class="mm-close" aria-label="Close Menu"><span aria-hidden="true"><i class="fal fa-times"></i></span></button></div><ul id="%1$s" class="%2$s">%3$s</ul><div class="mobile-social-media-icons"><a href="https://www.facebook.com/Clarkson-Travel-194759743959/" target="_blank"><i class="fab fa-facebook"></i></a><a href="http://instagram.com/Clarksontravelartisans" target="_blank"><i class="fab fa-instagram"></i></a></div>', 'walker' => new MobileMenuWalker() ) );

		wp_nav_menu( array( 'theme_location' => $menu, 'container' => 'nav', 'container_class' => 'd-xl-none', 'container_id' => 'mobile-menu', 'menu_class' => 'mm-menu', 'items_wrap' => $menu_html , 'walker' => new MmenuMenuWalker() ) );		
	}
