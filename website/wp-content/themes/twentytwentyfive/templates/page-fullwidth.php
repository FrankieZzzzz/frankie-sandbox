<?php
/**
 * Template Name: Page - Full Width
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header(); ?>

<?php
$childBanner = get_stylesheet_directory() . '/banner-fullwidth.php';
if (file_exists($childBanner)) {
    include_once($childBanner); 
} else {
    include_once(dirname(__DIR__) . '/banner-fullwidth.php'); 
}
?>

<div id="main-content" class="container-fluid" role="main">
	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
	?>
</div>

<?php
get_footer();
?>