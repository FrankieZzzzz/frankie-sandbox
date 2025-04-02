<?php
/**
 * The loop that displays a Obituary single post
 *
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php
				$condolence_count = get_comments_number( get_the_ID() );
				$condolence_label = ( $condolence_count > 1 ) ? $condolence_count.' '.__('Condolences', 'wp-obituary') : $condolence_count.' '.__('Condolence', 'wp-obituary') ;
			?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<header class="entry-header" >
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                            <?php wp_obituary_posted_on(); ?>
                            <span class="number-condolence"><?php echo $condolence_label; ?></span>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->
                <?php do_action('wp_obituary_single_after_title' ); ?>
                <div class="entry-content">
                	<div class="obituary-thumb">
                	<?php
						$options = get_option( 'wp_obituray_options' );
						if( has_post_thumbnail() ){
							the_post_thumbnail( array(150, 200) );
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
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-obituary' ), 'after' => '</div>' ) ); ?>
                        <p><a href="<?php the_permalink(); ?>/#condolence-form">Offer Condolence for the family of <?php the_title(); ?></a></p>
                    </div><!-- .entry-content -->
                    <div class="obituary-utility">
                        <?php do_action('wp_obituary_single_before_utility' ); ?>
                        <?php edit_post_link( __( 'Edit', 'wp-obituary' ), '<span class="edit-link">', '</span>' ); ?>
                    </div><!-- .entry-utility -->
                </div><!-- obituary-content -->
                <?php do_action('wp_obituary_single_after_content' ); ?>
                <?php if ( comments_open( get_the_ID() )) : ?>
					<?php wp_obituary_get_template( 'comments' ); ?>
                <?php endif; ?>
            </div><!-- #post-## -->
<?php endwhile; // end of the loop. ?>
