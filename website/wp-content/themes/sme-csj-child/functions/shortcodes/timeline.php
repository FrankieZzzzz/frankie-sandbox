<?php 

	// The shortcode function
	function timeline_shortcode() { 
	  
		// global $post;

	  	// $timeline_query = new WP_Query(array(
		// 	'pagename' => 'history',
		// 	'post_status' => 'publish', 
		// 	//'posts_per_page' => -1,
		// ));

		// echo '<pre>';
		// print_r($timeline_query);
		// echo '</pre>';

		$output = '';
		$output .= '<div class="timeline">';
		$output .= '<div class="t_slide"><div class="t_events_wrap">';

		// if ( $timeline_query->have_posts() ) :
		// 	while ( $timeline_query->have_posts() ) : 
		// 		$timeline_query->the_post();

				if( function_exists('get_field') && have_rows('timeline_event') ):

					// Loop through rows.
					while( have_rows('timeline_event') ) : the_row();

						// Load sub field value.
						$icon = get_sub_field('icon');
						$year = get_sub_field('year');
						$head = get_sub_field('heading');
						$desc = get_sub_field('desc');
						$img = get_sub_field('img');
						$link_1 = get_sub_field('link_1');
						$link_2 = get_sub_field('link_2');
                    

						//$output .= '<div tabindex="0" class="t_event" data-bg="'.$img.'">';

						$output .= '<div tabindex="0" class="t_event">';

                            $output .= '<div class="t_node">'; 
                            $output .= '<div class="t_yr">'.$year.'</div>';
                            $output .= '<div class="t_icon"><i class="fa-regular fa-'.$icon.'"></i></div>';
                            $output .= '<div class="t_marker"></div>';
                            $output .= '</div>'; // close t_node

                            $output .= '<div class="t_info">';
                            //$output .= '<p class="t_yr">'.$year.'</p>';
                            $output .= '<div class="t_left"><p class="t_title">'.$head.'</p>';
                            $output .= '<p class="t_desc">'.$desc.'</p>';
                            if ($link_1) {
                                $output .= '<div><a href="'.$link_1['url'].'" class="t_desc" target="'.$link_1['target'].'">'.$link_1['title'].' </a></div>';
                            }
                            if ($link_2) {
                                $output .= '<div><a href="'.$link_2['url'].'" class="t_desc" target="'.$link_2['target'].'">'.$link_2['title'].' </a></div>';
                            }
                            $output .= '</div>'; // close t_left
                            // $output .= '<div class="t_right"><img src="'.$img.'" class="t_img" /></div></div>'; // close t_right and t_info
                            if ($img) {
                                $output .= '<div class="t_right"><img src="'.$img.'" class="t_img" /></div></div>';
                            }else{
                                $output .= '<div class="t_right no-timeline-img"><img class="no-timeline-img" /></div></div>';
                            }
                        $output .= '</div>'; // close t_event

					// End loop.
					endwhile;
				endif;

		// 	endwhile;
		// 	wp_reset_postdata();
		// endif;
		
		$output .= '</div>'; // close .t_events_wrap

		$output .= '<div class="t_nav"><a class="t_prev" href="#" tabindex="0" role="button" aria-hidden="false"><i class="fa-solid fa-arrow-left"></i></a><a class="t_next" href="#" tabindex="0" role="button" aria-hidden="false"><i class="fa-solid fa-arrow-right"></i></a></div>';

		$output .= '</div></div>';
		
		return $output;
		
	}
	// Register shortcode
	add_shortcode('csj_timeline', 'timeline_shortcode'); 
 ?>

