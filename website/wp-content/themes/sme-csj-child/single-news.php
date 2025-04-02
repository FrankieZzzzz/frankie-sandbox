<?php
/**
 * The Template for displaying all single posts
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */

get_header(); 

if (!is_front_page()) {
    get_template_part('banner');
}

?>

<div id="main-content" class="container-lg">
	<div class="row">
        <div class="col-12 col-lg-10 offset-lg-1">
            <div id="content_single">
                <div id="content_single_wrapper">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="entry-social-share">
                                <ul class='social-share'>
                                    <li><a href='#' data-post-url='<?php echo get_permalink(); ?>' data-post-title='<?php echo the_title(); ?>' data-share-option='facebook' class='facebook-link'><i class='fa-brands fa-facebook-f'></i></a></li>
                                    <li><a href='#' data-post-url='<?php echo get_permalink(); ?>' data-post-title='<?php echo the_title(); ?>' data-share-option='linkedin' class='linkedin-link'><i class='fa-brands fa-linkedin-in'></i></a></li>
                                    <li><a href='#' data-post-url='<?php echo get_permalink(); ?>' data-post-title='<?php echo the_title(); ?>' data-share-option='x' class='x-link'><i class='fab fa-x-twitter'></i></a></li>
                                    <li><a href='#' data-post-url='<?php echo get_permalink(); ?>' data-post-title='<?php echo the_title(); ?>' data-share-option='copy' class='copy-link'><i class='far fa-link'></i></a></li>
                                    <li><a href='#' data-post-url='<?php echo get_permalink(); ?>' data-post-title='<?php echo the_title(); ?>' data-share-option='email' class='email-link'><i class='fa-regular fa-envelope'></i></a></li>
                                </ul>
                            </div>
                            <?php // Start the Loop

                                // Get feature image
                                if ( has_post_thumbnail() ) {
                                    echo '<div class="entry-img">';
                                    the_post_thumbnail('full');
                                    echo '</div>';
                                }

                                // Get content
                                the_content();

                                $news_tag = get_the_terms(get_the_ID(), 'news_tag');

                                ?>
                                <div class="entry-tags">
                                    <?php 
                                    if (!empty($news_tag)) {
                                        foreach ($news_tag as $tag) { 
                                    ?>
                                    <div><?php echo $tag->name; ?></div>
                                    <?php }} ?>
                                </div>
                        <?php endwhile; ?>
                    <?php else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );

                        endif;
                    ?>
                    <div class="post-cta">
                        <div class="post-cta-icon">
                            <i class="fa-sharp fa-regular fa-hand-holding-heart"></i>
                        </div>
                        <div class="post-cta-content">
                            <span><?php _e('Support the cause', 'als'); ?></span>
                            <h3>
                                <?php 
                                    if (get_current_language() === 'en') {
                                        _e('You can make a  <strong><span class="text-purple">difference.</span></strong>', 'als');
                                    } else {
                                        _e('FR - You can make a  <strong><span class="text-purple">difference.</span></strong>', 'als');
                                    }
                                ?>
                            </h3>
                            <p><?php _e('Donations allow people living with ALS to receive one-on-one guidance and in-home assistance, access to life-enhancing equipment, and have compassionate community support.', 'als'); ?></p>
                            <div>
                                <a href="<?php echo constant('DONATE_URL'); ?>" class="btn btn-text-sm btn-color-purple_button"><?php _e('Donate today', 'als'); ?></a>
                            </div>
                        </div>
                    </div>
                </div><!-- #content_single_wrapper -->
            </div><!-- #content_single -->
		</div>
        <div class="col-12 col-lg-10 offset-lg-1">
            <?php
                // Previous/next post navigation.
                PostsHelper::theme_post_nav();
            ?>
        </div>
	</div>
</div>

<div class="related-posts">
    <div class="container-lg">
        <div class="row">
            <div class="col-10">
                <div class="related-posts-title">
                    <h4>
                        <?php 
                            if (get_current_language() === 'en') {
                                _e('Explore more <strong><span class="text-purple">news</span></strong> from ALS Canada.', 'als');
                            } else {
                                _e('FR - Explore more <strong><span class="text-purple">news</span></strong> from ALS Canada.', 'als');
                            }
                        ?>                
                    </h4>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="related-posts-subtitle">
                <?php $post_type_landing_page_url = constant(strtoupper(get_post_type()) . "_LANDING_PAGE_URL_" . strtoupper(get_current_language())); ?>
                    <a href="<?php echo $post_type_landing_page_url; ?>">
                        <?php _e('View all', 'als'); ?><i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php
                $related = get_posts( array( 
                    'news_topic' => $current_topic, 
                    'numberposts' => 3, 
                    'post_type' => 'news', 
                    'post__not_in' => array($post->ID),
                    'suppress_filters' => false
                ) );
                if( $related ) foreach( $related as $post ) {
                setup_postdata($post); ?>
                        <div class="col-lg-4">
                            <a href="<?php the_permalink() ?>" class="related-post-single" rel="bookmark">
                                <h3><?php echo the_title(); ?></h3>
                                <div class="mt-auto"><p class="related-post-cta"><?php _e('Read news article', 'als'); ?><i class="fa-solid fa-arrow-right"></i></p></div>
                            </a>
                        </div>
                <?php }
                wp_reset_postdata(); 
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>