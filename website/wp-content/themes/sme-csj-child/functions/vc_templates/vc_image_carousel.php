<?php
	
	// Custom Testimonial Slider

	// Render Shortcodes
	add_shortcode('vc_carousel_container', 'vc_carousel_container_html');
	add_shortcode('vc_image_carousel', 'vc_image_carousel_html');

	// Initialize vc widget
	add_action('init', 'vc_carousel_container_func');
	add_action('init', 'vc_image_carousel_func');
	
	// Enqueue flickity scripts
	add_action('get_footer', 'flickity_scripts');

	// Extend "container" content element WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_vc_carousel_container extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_vc_image_carousel extends WPBakeryShortCode {}
	}

	// Slider Wrapper Mapping
	function vc_carousel_container_func() {
		
		vc_map( array(
			"name" => __("Carousel"),
			"base" => "vc_carousel_container",
			"as_parent" => array('only' => 'vc_image_carousel'), // Register "container" content element to hold all inner (child) content elements. Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"icon" => "icon-wpb-call-to-action",
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Carouselr Heading"),
					"param_name" => "carousel_head",
					"value" => __(""),
					"description" => __("Enter a heading")
				),
				// array(
				// 	"type" => "attach_images",
				// 	"holder" => "div", 
				// 	"class" => "vc_admin_label",
				// 	"heading" => __("Upload Images"),
				// 	"param_name" => "image_carousel",
				// 	"value" => __(""),
				// 	"description" => __("Select multiple images to display in the slider.")
				// ),
                // array(
				// 	"type" => "textarea",
				// 	"holder" => "span", 
				// 	"class" => "vc_admin_label",
				// 	"heading" => __("Carousel Intro"),
				// 	"param_name" => "carousel_intro",
				// 	"value" => __(""),
				// 	"description" => __("Enter the intro copy")
				// ),
				// array(
				// 	"type" => "dropdown",
				// 	"heading" => __("Carousel Image Size"),
				// 	"param_name" => "carousel_size",
				// 	"value" => array(
                //         __("Thumbnail", "text-domain") => "thumbnail",
                //         __("Medium", "text-domain") => "medium",
                //         __("Large", "text-domain") => "large",
                //         __("Full Size", "text-domain") => "full"
				// 	),
				// 	"description" => __("Choose the image size to be used for the carousel images.")
				// ),
                array(
					"type" => "dropdown",
					"heading" => __("Carousel Theme"),
					"param_name" => "carousel_theme",
					"value" => array(
						__( 'Default Theme' ) => 'default-theme',
					),
					"description" => __("Select a colour theme")
				),
                array(
					"type" => "textfield",
					"heading" => __("Custom Class"),
					"param_name" => "class",
					"value" => __(""),
					"description" => __("Enter a custom class")
				),
			),
			"js_view" => 'VcColumnView'
		) );
	}

	// Single Slide Wrapper Mapping
	function vc_image_carousel_func() {
		vc_map( array(
			"name" => __("Carousel Image"),
			"base" => "vc_image_carousel",
			"icon" => "icon-wpb-single-image",
			"content_element" => true,
			"as_child" => array('only' => 'vc_carousel_container'), // Register "child" content element. Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Carousel Image"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library")
				),
				array(
					"type" => "textfield",
					"heading" => __("Image Caption"),
					"param_name" => "image_caption",
					"value" => __(""),
					"description" => __("Enter caption")
				),
				// array(
				// 	"type" => "textarea_html",
				// 	"holder" => "div",
				// 	"heading" => __("Carousel Content"),
				// 	"param_name" => "content",
				// 	"value" => __(""),
				// ),
				// array(
				// 	"type" => "textfield",
				// 	"holder" => "span", 
				// 	"class" => "vc_admin_label",
				// 	"heading" => __("Author Name"),
				// 	"param_name" => "carousel_author",
				// 	"value" => __(""),
				// 	"description" => __("Enter author name")
				// ),
				// array(
				// 	"type" => "textfield",
				// 	"holder" => "span", 
				// 	"heading" => __("Author Title"),
				// 	"param_name" => "carousel_author_title",
				// 	"value" => __(""),
				// 	"description" => __("Enter author job title")
				// ),
				// array(
				// 	"type" => "vc_link",
				// 	"heading" => __("Button Link"),
				// 	'param_name' => 'link',
				// 	"description" => __("Select a link")
				// ),
				array(
					"type" => "textfield",
					"heading" => __("Custom Class"),
					"param_name" => "class",
					"value" => __(""),
					"description" => __("Enter a custom class")
		        ),
			)
		) );
	}

	// Slider Wrapper HTML
	function vc_carousel_container_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'carousel_head' => '',
		  	// 'carousel_intro' => '',
	        'carousel_theme' => 'default-theme',
	        'class' => '',
	   ), $atts ) );
		
		$content = wpb_js_remove_wpautop($content, true);
		if ( $carousel_head ) {
			$carousel_head = "<h2 class='slider__title'>" . $carousel_head . "</h2>";
		}
		if ( $carousel_intro ) {
			$carousel_intro = "<div class='slider__intro'>" . $carousel_intro . "</div>";
		}

		return "
	    	<div class='wpb_content_element vc_image_carousel {$class}'>
	    		<div class='carousel__wrapper {$carousel_theme}'>
		    		<div class='carousel__content'>
		    			{$carousel_head}
		    			<div class='carousel slides' data-flickity='{ \"contain\": true, \"wrapAround\": true, \"lazyLoad\": 2, \"hash\": true, \"autoPlay\": 6000}'>
		    				{$content}
		    			</div>
		    		</div>
	    		</div>
	    	</div>
	    ";
	}

	// Single Slide HTML
	function vc_image_carousel_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'image_caption' => '',
			// 'carousel_author' => '',
			// 'carousel_author_title' => '',
			// 'link' => '',
	      'class' => '',
	    ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true);

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
			$imgBlock = "<img class='carousel__img' style='background-image: url(".$img[0].");'>";
		} else {
			$imgBlock = "";
		}

		if ($image_caption) {
			$image_caption = "<span class='carousel__img-caption'>".$image_caption."</span>";
		}else {
			$image_caption = "";
		}
		

		// if ($carousel_author_title) {
		// 	$carousel_author_title = ", <span class='slide__author-title'>".$carousel_author_title."</span>";
		// }

		// $link_arr = vc_build_link( $link );
		// $link = createLink($link_arr);

		return "
	    	<div class='carousel-image slide {$class}'>
		    	<div class='carousel__wrapper'>
		    		{$imgBlock}
					<div class='carousel__content'>
						<div class='carousel__txt'>
							{$content}
						</div>
						{$image_caption}
					</div>
	    		</div>
	    	</div>
	    ";
	}

?>