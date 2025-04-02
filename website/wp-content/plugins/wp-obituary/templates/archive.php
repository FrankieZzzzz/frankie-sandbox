<?php
/**
 * Template for displaying Obituary Archive pages
 */
$term_id 			= get_queried_object()->term_id;
$template_layout 	= get_term_meta( $term_id, 'obituary-archive-template', true );
get_header(); ?>
<div id="container" class="container">
    <div id="obituary-main" class="site-main" role="main">
		<div id="article" class="archive <?php echo $template_layout; ?>">
		<?php
        if ( have_posts() )
        the_post();
        ?>
        <header class="page-header">	
            <h1 class="page-title">
            <?php if ( is_day() ) : ?>
                            <?php printf( __( 'Daily Archives: <span>%s</span>', 'wp-obituary' ), get_the_date() ); ?>
            <?php elseif ( is_month() ) : ?>
                            <?php printf( __( 'Monthly Archives: <span>%s</span>', 'wp-obituary' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wp-obituary' ) ) ); ?>
            <?php elseif ( is_year() ) : ?>
                            <?php printf( __( 'Yearly Archives: <span>%s</span>', 'wp-obituary' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wp-obituary' ) ) ); ?>
            <?php else : ?>
                            <?php _e( 'Obituary Archives', 'wp-obituary' ); ?>
            <?php endif; ?>
            </h1>
        </header>
        <?php
        rewind_posts();
        wp_obituary_get_template( 'loop-archive' );
        ?>

        </div><!-- #obituary-content -->
		<?php if( $template_layout != 'no-sidebar' ): ?>
        <aside id="obituary-sidebar" class="sidebar sidebar-primary archive <?php echo $template_layout; ?> widget-area" role="complementary" aria-label="Obituary Sidebar" itemscope="" itemtype="http://schema.org/WPSideBar" >
            <?php dynamic_sidebar( 'obituary-archive' ); ?> 
        </aside>
        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>