<?php get_header(); ?>

<div class="container-lg">

  	<div class="vc_section">

		<div class="row justify-content-center">

			<div id="content-primary" class="col-12 content-body__main__entries">

				<?php if (have_posts()) : ?>

					<?php while (have_posts()) : the_post(); ?>

						<?php 

							// get post
							$post_title = get_the_title();
							$post_cats = get_the_category();
							$post_tags = get_the_tags();
							// $post_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' ); 

							// get category
							$post_cat_html = '';
							if ( ! empty( $post_cats ) ) {
                                $post_cats_url = get_category_link($post_cats[0]->term_id);
								$post_cat_html = '<span class="category"><a href="'.esc_url($post_cats_url).'">'.esc_html($post_cats[0]->name).'</a></span>';
							}

							// get tags
							$post_tags_html = '';
							if ( $post_tags ) {
								$post_tags_html .= '<ul class="entry-tags">';
								foreach( $post_tags as $tag ) {
									$post_tags_html .= '<li>'.$tag->name.'</li>'; 
								}
								$post_tags_html .= '</ul>';
							}

							// ACF
							$news_single = get_field('news_single', 'option');

							// get related objects
							$related_cat = $post_cats[0]->slug;
							$related_cat_url = '/category/'.$related_cat;

							// echo '<pre>';
							// print_r($post_cats[0]);
							// echo '</pre>';

						?>

						<header class="entry-header">
							<div class="entry-categories"><?php echo $post_cat_html;?></div>
							<h1 class="entry-title"><?php echo $post_title; ?></h1>
							<div class="entry-date" datetime="<?php echo $post->post_date; ?>"><?php echo ucwords(get_the_date('d F Y', $post->ID)); ?></div>
						</header>
                        <hr>

						<div class="entry-content">
							<?php the_content(); ?>
						</div>

						<?php echo $post_tags_html; ?>

						<h2><?php echo $news_single['social_label']; ?></h2>
						<div class="entry-social-share">
							<?php // get social share template
								$social_share = get_stylesheet_directory() . '/functions/includes/social-share.php';
								if (file_exists($social_share)) {
									include_once($social_share); 
								}
							?>
						</div>
						
						<hr>
						
						<div class="related-posts">

							<?php // get related posts
								$related_cat = $post_cats[0]->term_taxonomy_id;
								// related cat post query
								$related = get_posts( array( 
									'post_type' => 'post',
									'category' => $related_cat,
									'post__not_in' => array($post->ID),
									'post_status' => 'publish',
									'numberposts' => 4,
									'suppress_filters' => false
								) );
								// if related cat obj exist
								if( $related ): 
							?>

								<h2>
									<div class="related-posts-label">
										<?php _e('Explore more', 'csj'); ?>
										<?php echo $news_single['related_label']; ?> <?php echo $post_cat_html;?> 
										<a href="<?php echo $related_cat_url; ?>"></a>
									</div>
									<div class="related-posts-btn">
										<a href="<?php echo esc_url($related_cat_url); ?>">
											<?php _e('View more', 'csj'); ?>
											<i class="fa-solid fa-arrow-right"></i>
										</a>
									</div>
								</h2>

								<div class="related-post-container">
									<?php // return posts with the same related cat
										foreach( $related as $post ) {
										setup_postdata($post); ?>
										<a href="<?php the_permalink() ?>" class="related-post" rel="internal">
											<div class="feat-img">
												<?php echo get_the_post_thumbnail(); ?>
											</div>
											<div class="feat-content">
												<div class="date"><?php echo get_the_date('d F Y', $post->ID); ?></div>
												<h3><?php echo get_the_title(); ?></h3>
												<div class="link"><?php _e('Read More', 'csj'); ?><i class="fa-solid fa-arrow-right"></i></div>
											</div>
										</a>
									<?php } ?>
								</div>

							<?php else: ?>

								<h2>
									<div class="related-posts-label">
										<?php _e('Explore all news', 'csj'); ?>
									</div>
									<div class="related-posts-btn">
										<a href="<?php echo '/news/' ?>">
											<?php _e('View more', 'csj'); ?>
											<i class="fa-solid fa-arrow-right"></i>
										</a>
									</div>
								</h2>

								<?php 
									// latest post query
									$latest = get_posts( array( 
										'post_type' => 'post',
										'post__not_in' => array($post->ID),
										'post_status' => 'publish',
										'numberposts' => 4,
										'orderby' => 'date',
										'order' => 'DESC'
									) );
								?>

								<div class="related-post-container">
									<?php // return latest posts
										foreach( $latest as $post ) {
										setup_postdata($post); ?>
										<a href="<?php the_permalink() ?>" class="related-post" rel="internal">
											<div class="feat-img">
												<?php echo get_the_post_thumbnail(); ?>
											</div>
											<div class="feat-content">
												<div class="date"><?php echo get_the_date('d F Y', $post->ID); ?></div>
												<h3><?php echo get_the_title(); ?></h3>
												<div class="link"><?php _e('Read More', 'csj'); ?><i class="fa-solid fa-arrow-right"></i></div>
											</div>
										</a>
									<?php } ?>
								</div>

							<?php endif; ?>
							
							<?php wp_reset_postdata(); ?>

						</div>

						<?php
							// Previous/next post navigation.
							// PostsHelper::theme_post_nav();
						?>

					<?php endwhile; ?>

				<?php else :
					// If no content, include the "No posts found" template.
					get_template_part('content', 'none');

					endif;
				?>

			</div>
			
			<!-- div id="content_sidebar" class="col-md-3">
				<?php // dynamic_sidebar('sidebar-blog'); ?>
			</div -->

		</div><!-- .row -->

	</div><!-- .vc_section -->

</div><!-- .content-body -->

<?php
get_footer();
?>