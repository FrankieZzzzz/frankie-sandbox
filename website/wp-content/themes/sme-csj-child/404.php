<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

  <section>
    <div class="container text-center page-404">
      <div class="row">
        <div class="col-lg-8 col-12 offset-lg-2">
          <!-- <i class="fal fa-exclamation-circle"></i> -->
         
          <i class="fa-solid fa-triangle-exclamation"></i>
          <p class="page-404-error">404 Error</p>
          <h2 class="page-404-title">Oops, it seems this page is lost, but we’re here to guide you back.</h2> 
          
        </div>
        <div class="col-lg-10 col-12 offset-lg-1">
		  <?php 
			if(has_nav_menu( 'error-404-menu' )) {
				$error_404_nav_array = array(
					'theme_location' => 'error-404-menu',
					'container' => 'nav',
					'container_class' => 'error-404-menu',
					'container_aria_label' => 'Error 404 Menu',
					'menu_class' => 'navbar-nav',
					'depth' => 1,
					'walker' => new BootstrapWalker()
				);
				wp_nav_menu( $error_404_nav_array );
			}
		  ?>
        </div>
      </div>
    </div>
  </section>

<?php get_footer(); ?>