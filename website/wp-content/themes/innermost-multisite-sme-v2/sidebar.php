<?php
/**
 * The Sidebar containing the main widget area
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @author radii
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="site-sidebar widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar -->
<?php endif; ?>