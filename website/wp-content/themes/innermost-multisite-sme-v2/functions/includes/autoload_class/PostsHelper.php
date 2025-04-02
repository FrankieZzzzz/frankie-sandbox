<?php

Class PostsHelper{

	/* Empty Constructor */
	public function __construct() { }

	/* Function: theme_post_nav - Display navigation to next/previous post when applicable. */
	public static function theme_post_nav( $theme_post_nav_title = false, $in_same_term = false )
	{
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation" aria-label="<?php echo __( 'Navigation', "SITE_TEXT_DOMAIN" ); ?>">
			<div class="nav-links">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', "SITE_TEXT_DOMAIN" ), $in_same_term );
				else :
					previous_post_link( '%link', '<span class="meta-nav"><i class="fa fa-angle-left"></i></span> ' . __( 'Previous'), $in_same_term );
					next_post_link( '%link', __( 'Next') . ' <span class="meta-nav"><i class="fa fa-angle-right"></i></span>', $in_same_term );
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}

	/* Function: theme_paging_nav - Display navigation to next/previous set of posts when applicable. */
	public static function theme_paging_nav( $links_type = 'plain', $pagination_title = false )
	{
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'type'	   => $links_type,
		'prev_text' => __( '&larr; Previous', "SITE_TEXT_DOMAIN" ),
		'next_text' => __( 'Next &rarr;', "SITE_TEXT_DOMAIN" ),
		) );

		if ( $links ) :
		?>
		<nav class="navigation paging-navigation" role="navigation" aria-label="<?php echo __( 'Navigation', "SITE_TEXT_DOMAIN" ); ?>">
			<?php
			if($links_type == 'plain' || $links_type == 'list'){
			?>
			<div class="pagination">
				<?php echo $links; ?>
			</div><!-- .pagination in div -->
			<?php
			} else if($links_type == 'array'){ //use bootstrap pagination class to handle array ouput
			?>
			<ul class="pagination">
				<?php foreach($links as $each_link){ ?>
				<li><?php echo $each_link;?></li>
				<?php } ?>
			</ul><!-- .pagination in ul -->
			<?php } ?>
		</nav><!-- .navigation -->
		<?php
		endif;
	}

	/* Function: theme_post_thumbnail - Display an optional post thumbnail. */
	public static function theme_post_thumbnail ()
	{
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('large'); ?>
		</a>
	<?php 
	} 
} 
?>