<?php
	
	// Custom Testimonial Slider

	// Render Shortcodes
	add_shortcode('testimonial_slider', 'testimonial_slider_html');
	add_shortcode('testimonial_slide', 'testimonial_slide_html');

	// Initialize vc widget
	add_action('init', 'testimonial_slider_func');
	add_action('init', 'testimonial_slide_func');
	
	// Enqueue flickity scripts
	add_action('get_footer', 'flickity_scripts');

	// Extend "container" content element WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_testimonial_slider extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_testimonial_slide extends WPBakeryShortCode {}
	}

	// Slider Wrapper Mapping
	function testimonial_slider_func() {
		
		vc_map( array(
			"name" => __("Testimonial Slider"),
			"base" => "testimonial_slider",
			"as_parent" => array('only' => 'testimonial_slide'), // Register "container" content element to hold all inner (child) content elements. Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"icon" => "icon-wpb-images-carousel",
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Slider Heading"),
					"param_name" => "slider_head",
					"value" => __(""),
					"description" => __("Enter a heading")
				),
				array(
					"type" => "textarea",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Slider Intro"),
					"param_name" => "slider_intro",
					"value" => __(""),
					"description" => __("Enter the intro copy")
				),
				array(
					"type" => "dropdown",
					"heading" => __("Slider Theme"),
					"param_name" => "slider_theme",
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
	function testimonial_slide_func() {
		vc_map( array(
			"name" => __("Slide"),
			"base" => "testimonial_slide",
			"icon" => "icon-wpb-single-image",
			"content_element" => true,
			"as_child" => array('only' => 'testimonial_slider'), // Register "child" content element. Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Slide Image"),
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
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"heading" => __("Slide Content"),
					"param_name" => "content",
					"value" => __(""),
				),
				array(
					"type" => "textfield",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Author Name"),
					"param_name" => "slide_author",
					"value" => __(""),
					"description" => __("Enter author name")
				),
				array(
					"type" => "textfield",
					"holder" => "span", 
					"heading" => __("Author Title"),
					"param_name" => "slide_author_title",
					"value" => __(""),
					"description" => __("Enter author job title")
				),
				array(
					"type" => "vc_link",
					"heading" => __("Button Link"),
					'param_name' => 'link',
					"description" => __("Select a link")
				),
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
	function testimonial_slider_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'slider_head' => '',
		  	'slider_intro' => '',
	      'slider_theme' => 'default-theme',
	      'class' => '',
	   ), $atts ) );
		
		$content = wpb_js_remove_wpautop($content, true);
		if ( $slider_head ) {
			$slider_head = "<h2 class='slider__title'>" . $slider_head . "</h2>";
		}
		if ( $slider_intro ) {
			$slider_intro = "<div class='slider__intro'>" . $slider_intro . "</div>";
		}

		return "
	    	<div class='wpb_content_element vc-slider testimonial {$class}'>
	    		<div class='slider__wrapper {$slider_theme}'>
		    		<div class='slider__content'>
		    			{$slider_head}
						{$slider_intro}
		    			<div class='carousel slides' data-flickity='{ \"contain\": true, \"wrapAround\": true, \"lazyLoad\": 2, \"hash\": true, \"autoPlay\": 6000}'>
		    				{$content}
		    			</div>
		    		</div>
	    		</div>
	    	</div>
	    ";
	}

	// Single Slide HTML
	function testimonial_slide_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'image_caption' => '',
			'slide_author' => '',
			'slide_author_title' => '',
			'link' => '',
	      'class' => '',
	    ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true);

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
			$imgBlock = "<div class='slide__img' style='background-image: url(".$img[0].");'></div>";
		} else {
			$imgBlock = "";
		}

		if ($image_caption) {
			$image_caption = "<span class='slide__img-caption'>".$image_caption."</span>";
		}
		

		if ($slide_author_title) {
			$slide_author_title = ", <span class='slide__author-title'>".$slide_author_title."</span>";
		}

		$link_arr = vc_build_link( $link );
		$link = createLink($link_arr);

		return "
	    	<div class='carousel-image slide {$class}'>
		    	<div class='slide__wrapper'>
		    		{$imgBlock}
					<div class='slide__content'>
						<div class='quote-sep'><i class='fas fa-quote-left'></i></div>
						<div class='slide__txt'>
							{$content}
						</div>
						<p class='slide__author'>
							{$slide_author}{$slide_author_title}
						</p>
						{$link}
						{$image_caption}
					</div>
	    		</div>
	    	</div>
	    ";
	}

?>