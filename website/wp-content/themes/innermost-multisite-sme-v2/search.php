<?php
/**
 * The template for displaying Search Results pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header();

?>

<div class="row content-body">
	<div id="main-content" class="container" role="main">

		<div id="content-primary" class="col-xs-12 col-sm-offset-2 col-sm-8 content-body__main">
			<?php
			if (empty($_REQUEST['s']))
			{
				echo __('no search term entered', "SITE_TEXT_DOMAIN");
			}
			else {
				if ( have_posts()) { 
					global $wp_query;
				?>

				<div class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s (%s found)', "SITE_TEXT_DOMAIN" ), get_search_query(), $wp_query->found_posts ); ?></h1>
				</div><!-- .page-header -->

				<div id="content-searchresults">
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;

					// Previous/next post navigation.
					PostsHelper::theme_paging_nav('array');

				} else {

					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				}
			}
			?>
			</div>
		</div><!-- #content-primary -->

	</div><!-- .row -->

</div><!-- #main-content -->

<?php
get_footer();
?>
