<?php
/**
 * The default template for displaying content
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( is_search() ) : ?>
        <div class="post__entry-excerpt">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="post__entry">
            <?php 
                if ( has_post_thumbnail() ) {
                    echo '<a href="'.get_the_permalink().'" class="post__entry__feat-img"><div>'.get_the_post_thumbnail().'</div></a>';
                }
            ?>
            <a href="<?php the_permalink(); ?>" class="post__entry__title">
                <p><?php the_title(); ?></p>
            </a>
            <?php 
                echo '<div class="post__entry__date"><p>'.get_the_time('l, F j, Y').'</p></div>';
                echo '<div class="post__entry__excerpt"><p>'.get_the_excerpt().'</p></div>';
            ?>
            <a href="<?php the_permalink(); ?>" class="post__entry__link">
                <?php _e( 'READ MORE<i class="fa-solid fa-arrow-right"></i>', 'SITE_TEXT_DOMAIN' ); ?>
            </a>
            <?php the_tags( '<div class="post__entry__tags"><i class="fa fa-tags fa-before"></i><span class="post__entry__tags__link">', ', ', '</span></div>' ); ?>
        </div><!-- .post__entry -->
    <?php endif; ?>
</article><!-- #post-## -->
