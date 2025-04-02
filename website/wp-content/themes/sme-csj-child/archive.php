<?php
/**
 * The Template for displaying blog listing page.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author innermost digital
 */

get_header(); ?>

<?php
if (!is_front_page()) {
	$childBanner = get_stylesheet_directory() . '/banner.php';
	if (file_exists($childBanner)) {
		include_once($childBanner); 
	} else {
		include_once('banner.php'); 
	}
}
?>

<div id="main-content" class="container-lg" role="main">
	<div class="row">

		<?php if ( have_posts() ) : ?>
			
			<div id="content_primary" class="col-lg-9">
                
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

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

            <div id="content_sidebar" class="col-lg-3">
                <?php 
                	if (is_active_sidebar('sidebar-blog')) {
                		dynamic_sidebar('sidebar-blog');
                	} 
                ?>
            </div>

		</div>

	</div>
</div>

<?php
get_footer();
?>