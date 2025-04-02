<?php

/**
 * The default template for displaying search page
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */
?>

<?php if ( is_search() ) : ?>

<p class="emphasis my-5"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', "SITE_TEXT_DOMAIN" ); ?></p>
<?php get_search_form(); ?>

<?php else : ?>

<p class="emphasis my-5"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', "SITE_TEXT_DOMAIN" ); ?></p>
<?php get_search_form(); ?>

<?php endif; ?>