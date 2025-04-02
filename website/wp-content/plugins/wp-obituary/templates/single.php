<?php
/**
 * Template for displaying all Obituary single posts
 *
 */
$template_layout = get_post_meta( get_the_ID(), 'obituary-layout', TRUE );
get_header(); ?>
    <div id="container" class="container">
        <div id="obituary-main">
        	<div id="article" class="single <?php echo $template_layout; ?>">
				<?php wp_obituary_get_template( 'loop-single' ); ?>
            </div><!-- #obituary -->
			<?php if( $template_layout != 'no-sidebar' ): ?>
            <aside id="obituary-sidebar" class="sidebar sidebar-primary <?php echo $template_layout; ?> widget-area" role="complementary" aria-label="Obituary Sidebar" itemscope="" itemtype="http://schema.org/WPSideBar" >
                <?php dynamic_sidebar( 'obituary' ); ?> 
            </aside>
            <?php endif; ?>
        </div><!-- #content -->
    </div><!-- container -->
<?php get_footer(); ?>