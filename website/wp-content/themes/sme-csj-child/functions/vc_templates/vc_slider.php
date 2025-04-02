<?php
	
	// Custom Innermost Advance Slider

	// Render Shortcodes
	add_shortcode('innermost_slider', 'innermost_slider_html');
	add_shortcode('innermost_slide', 'innermost_slide_html');

	// Initialize vc widget
	add_action('init', 'innermost_slider_func');
	add_action('init', 'innermost_slide_func');
	
	// Enqueue flickity scripts
	add_action('get_footer', 'flickity_scripts');

	// Extend "container" content element WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_innermost_slider extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_innermost_slide extends WPBakeryShortCode {}
	}

	// Slider Wrapper Mapping
	function innermost_slider_func() {
		
		vc_map( array(
			"name" => __("Advance Slider", "collectorsquest"),
			"base" => "innermost_slider",
			"as_parent" => array('only' => 'innermost_slide'), // Register "container" content element to hold all inner (child) content elements. Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"icon" => "icon-wpb-images-carousel",
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"params" => array(
				array(
					"type" => "textarea",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __( "Slider Heading", "sme-starter" ),
					"param_name" => "slider_head",
					"value" => __( "", "sme-starter" ),
					"description" => __( "Enter a heading", "sme-starter" )
				),
				array(
					"type" => "dropdown",
					"heading" => __("Slider Style", "sme-starter"),
					"param_name" => "slider_style",
					"value" => array(
						__( 'History Slider' ) => 'history-slider',
					),
					"description" => __("Show dotted rule at the end", "sme-starter")
				),
				array(
					"type" => "textfield",
					"heading" => __( "Custom Class", "sme-starter" ),
					"param_name" => "class",
					"value" => __( "", "sme-starter" ),
					"description" => __( "Enter a custom class", "sme-starter" )
		        ),
			),
			"js_view" => 'VcColumnView'
		) );
	}

	// Single Slide Wrapper Mapping
	function innermost_slide_func() {
		vc_map( array(
			"name" => __("Slide", "sme-starter"),
			"base" => "innermost_slide",
			"icon" => "icon-wpb-single-image",
			"content_element" => true,
			"as_child" => array('only' => 'innermost_slider'), // Register "child" content element. Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Slide Image", "js_composer"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library", "js_composer")
				),
				array(
					"type" => "textarea",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __( "Slide Heading", "sme-starter" ),
					"param_name" => "slide_head",
					"value" => __( "", "sme-starter" ),
					"description" => __( "Enter a heading", "sme-starter" )
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"heading" => __( "Slide Content", "sme-starter" ),
					"param_name" => "content",
					"value" => __( "", "sme-starter" ),
				),
				array(
					"type" => "textfield",
					"heading" => __( "Custom Class", "sme-starter" ),
					"param_name" => "class",
					"value" => __( "", "sme-starter" ),
					"description" => __( "Enter a custom class", "sme-starter" )
		        ),
			)
		) );
	}

	// Slider Wrapper HTML
	function innermost_slider_html($atts, $content = null) {
		extract( shortcode_atts( array(
		  'slider_head' => '',
	      'slider_style' => 'history-slider',
	      'class' => '',
	    ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true);

    $flickity_options = '{ 
			"contain": true, 
			"wrapAround": true,
			"hash": true,
			"lazyLoad": 2,
			"percentPosition": false,
			"pageDots": false
		}';

		if (!empty(($slider_head))) {
			$slider_head_html = "<h3 class='slider__title'>{$slider_head}</h3>";
		}

		return "
	    	<div class='wpb_content_element {$class}'>
	    		<div class='slider__wrapper {$slider_style}'>
		    		<div class='slider__content'>
						$slider_head_html
		    			<div class='carousel slides' data-flickity='{$flickity_options}'>
		    				{$content}
		    			</div>
		    		</div>
	    		</div>
	    	</div>
	    ";
	}

	// Single Slide HTML
	function innermost_slide_html($atts, $content = null) {
		extract( shortcode_atts( array(
		  'slide_head' => '',
	      'class' => '',
	    ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true);

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
		  $imgBlock = "<img src='" . $img[0] . "'" . " alt='" . $imgAltTxt . "' />";
		} else {
		  $imgBlock = "";
		}

		return "
	    	<div class='carousel-content slide {$class}'>
		    	<div class='slide__content'>
		    		<div class='slide__img'>
		    			{$imgBlock}
		    		</div>
		    		<div class='slide__content_inner'>
						<h3 class='slide__title'>{$slide_head}</h3>
							<div class='slide__txt'>
								{$content}
							</div>
						</div>
	    		</div>
	    	</div>
	    ";
	}

?>