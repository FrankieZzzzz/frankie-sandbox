<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header(); ?>

<div class="row content-body">
    <div class="container">

    	<div class="row content-body__main">

			<?php if ( have_posts() ) : ?>
                
				<div class="col-xs-12 content-body__main__title">
					<h1><?php printf( __( 'Archives: %s', "SITE_TEXT_DOMAIN" ), single_month_title( ' ', false ) ); ?></h1>
				</div><!-- .archive-header -->
				
				<div id="content-primary" class="col-xs-12 col-sm-9 content-body__main__entries has-sidebar">

					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

						// Display template
						get_template_part( 'content-post', get_post_format() );

						endwhile;
						// Previous/next page navigation.
						PostsHelper::theme_paging_nav('array');

					else :
						// If no content, include the "No posts found" template.
						get_template_part( 'content', 'none' );

					endif;
					?>

				</div>

	            <div id="content-sidebar" class="col-xs-12 col-sm-3 content-body__main__sidebar">

	                <?php //get_sidebar(); ?>

	                <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
	                    <div id="primary-sidebar" class="content-body__main__sidebar__widgets">
	                        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
	                    </div>
	                <?php endif; ?>

	            </div>

			</div>

		</div><!-- .row -->
    		
    </div>
</div><!-- .content-body -->

<?php
get_footer();
?>