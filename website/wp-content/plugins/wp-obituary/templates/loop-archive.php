<?php

global $wp_query;

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php

		$condolence_count = get_comments_number( get_the_ID() );

		$condolence_label = ( $condolence_count > 1 ) ? $condolence_count.' '.__('Condolences', 'wp-obituary') : $condolence_count.' '.__('Condolence', 'wp-obituary') ;

        global $wp_query;
	var_dump($wp_query->query_vars['post_type']);
    echo 'testtest';

	?>


    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    	<?php do_action('wp_obituary_archive_before_title'); ?>

        <header class="entry-header" >

        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

            <div class="entry-meta">

                    <?php wp_obituary_posted_on(); ?>

                    <span class="number-condolence"><?php echo $condolence_label; ?></span>

            </div><!-- .entry-meta -->

        </header><!-- .entry-header -->

        <?php do_action('wp_obituary_archive_after_title'); ?>

        <div class="entry-content">

            <div class="obituary-thumb">

            <?php

                $options = get_option( 'wp_obituray_options' );

                if( has_post_thumbnail() ){

                    the_post_thumbnail( array( 150, 200 ) );

                }elseif( $options['default_image_url'] ){

                    ?>

                    <img width="150" height="200" src="<?php echo $options['default_image_url']; ?>" class="attachment-medium size-medium wp-post-image" alt="pro-pic">

                    <?php

                }else{

                    ?>

                    <img width="150" height="200" src="<?php echo WP_OBITUARY_URL; ?>assets/images/obituary-thumbnail.jpg" class="attachment-medium size-medium wp-post-image" alt="pro-pic">

                    <?php

                }

            ?>

            </div>        

            <div class="obituary-content">

                <?php the_excerpt(); ?>

                <p><a href="<?php the_permalink(); ?>/#condolence-form">Offer Condolence for the family of <?php the_title(); ?></a></p>

            </div><!-- .entry-content -->

            <?php do_action('wp_obituary_archive_after_content'); ?>

        </div><!-- obituary-content -->

    </div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>

	<div id="obituary-pagination">

	<?php

    $big = 999999999; // need an unlikely integer

    $translated = __( 'Page', 'wp-obituary' ); // Supply translatable string

    echo paginate_links( array(

        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

        'format' => '?paged=%#%',

        'current' => max( 1, get_query_var('paged') ),

        'total' => $wp_query->max_num_pages,

        'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>',

		'prev_text'          => __('«'),

		'next_text'          => __('»'),

		'type'               => 'list',

    ) );

    ?>

    </div><!-- #obituary-pagination -->

<?php else : ?>

    <h2 class="center"><?php _e('No Obituary yet!', 'wp-obituary'); ?></h2>

<?php endif; ?>