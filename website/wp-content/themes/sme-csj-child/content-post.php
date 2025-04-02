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
            <?php // Get post image
                if ( has_post_thumbnail() ) {
                    echo '<a href="'.get_the_permalink().'" class="post__entry__feat-img"><div>'.get_the_post_thumbnail().'</div></a>';
                }
            ?>
            <div class="post__entry__content">
                <!-- <a href="" class="post__entry__head-link"> -->
                    <p class="post__entry__head-text">
                        <?php // Get the first category
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                // echo esc_html( $categories[0]->name );	
                                $cat_slug_var = get_category_link($categories[0]->term_id);
                                echo '<a href="'. esc_url( $cat_slug_var ) .'" class="post__entry__head-link">'.esc_html($categories[0]->name).'</a>';
                            }
                        ?>
                    </p>
                <!-- </a> -->
                <a href="<?php the_permalink(); ?>" class="post__entry__title">
                    <h2><?php the_title(); ?></h2>
                </a>
				<div class="post__entry__date"><?php echo get_the_time('d F Y');?></div>
				<div class="post__entry__excerpt"><p><?php truncate_post(100, '...'); ?></p></div>
                <a href="<?php the_permalink(); ?>" class="post__entry__link">
                    <?php _e( 'READ MORE<i class="fa-solid fa-arrow-right"></i>', 'SITE_TEXT_DOMAIN' ); ?>
                </a>
                <?php the_tags( '<div class="post__entry__tags"><i class="fa-solid fa-arrow-right"></i><span class="post__entry__tags__link">', ', ', '</span></div>' ); ?>
            </div>
        </div><!-- .post__entry -->
    <?php endif; ?>
</article><!-- #post-## -->
