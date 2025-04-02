<?php
/**
 * The default template for displaying content
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */
?>
<?php if ( is_search() ) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<?php truncate_post(); ?>
	</article><!-- #post-## -->
<?php else : ?>
	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', "SITE_TEXT_DOMAIN" ) ); ?>
<?php endif; ?>