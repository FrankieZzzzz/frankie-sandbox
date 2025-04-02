<?php
/**
 * Template Name: Page - History Timeline
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

add_action( 'wp_enqueue_scripts',
	function(){
		$_useMin = parse_url( get_site_url(), PHP_URL_HOST ) == 'csj-to.ca';
		$args = array('in_footer' => 'true' );
		wp_enqueue_script('csj-timeline', get_stylesheet_directory_uri() . ($_useMin ?  '/js/timeline.min.js' : '/js/timeline.js'), array('jquery'), microtime(true) * 10000,$args);//microtime(true)  * 10000
	}
);

get_header(); ?>

<?php
$childBanner = get_stylesheet_directory() . '/banner.php';
if (file_exists($childBanner)) {
    include_once($childBanner); 
} else {
    include_once(dirname(__DIR__) . '/banner.php'); 
}
?>

<div id="main-content" class="container-lg" role="main">
    <?php
        // Start the Loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'content', get_post_format() );

        endwhile;
    ?>
</div>

<?php
get_footer();
?>