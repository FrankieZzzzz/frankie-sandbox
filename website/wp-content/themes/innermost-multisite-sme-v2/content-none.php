<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */
?>
<?php if ( is_search() ) : ?>

<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', "SITE_TEXT_DOMAIN" ); ?></p>
<?php get_search_form(); ?>

<?php else : ?>

<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', "SITE_TEXT_DOMAIN" ); ?></p>
<?php get_search_form(); ?>

<?php endif; ?>