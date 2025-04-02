<?php
/**
 * The Template for displaying all single posts
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header(); ?>

<div id="main-content" class="container-lg">
	<div class="row">

        <div id="content_single" class="col-9 has-sidebar">

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="entry-title">
                        <h2><?php the_title(); ?></h2>
                    </div>
                    
    				<?php // Start the Loop

                        the_date('l, F j, Y', '<div class="entry-date"><p>', '</p></div>');

                        the_tags( '<div class="entry-tags"><i class="fa fa-tags fa-before"></i><span class="entry-tags_link">', ', ', '</span></div>' );

                        // Get feature image
                        if ( has_post_thumbnail() ) {
                            echo '<div class="entry-img">';
                            the_post_thumbnail('full');
                            echo '</div>';
                        }

                        // Get content
                        the_content();

    					// Previous/next post navigation.
    					PostsHelper::theme_post_nav();

    					// If comments are open or we have at least one comment, load up the comment template.
    					if ( comments_open() || get_comments_number() ) {
    						comments_template();
    					}
    					
    				?>
                
                <?php endwhile; ?>

            <?php else :
                // If no content, include the "No posts found" template.
                get_template_part( 'content', 'none' );

                endif;
            ?>

		</div><!-- #content-primary -->

        <div id="content_sidebar" class="col-3">
            <?php 
                if (is_active_sidebar('sidebar-blog')) {
                    dynamic_sidebar('sidebar-blog');
                } 
            ?>
        </div>
		
	</div>
</div>

<?php
get_footer();
?>