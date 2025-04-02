<?php
	
	// Custom Timeline Slider

	// Render Shortcodes
	add_shortcode('timeline_slider', 'timeline_slider_html');
	add_shortcode('timeline_slide', 'timeline_slide_html');

	// Initialize vc widget
	add_action('init', 'timeline_slider_func');
	add_action('init', 'timeline_slide_func');
	
	// Enqueue flickity scripts
	add_action('get_footer', 'flickity_scripts');

	// Extend "container" content element WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_timeline_slider extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_timeline_slide extends WPBakeryShortCode {}
	}

	// Slider Wrapper Mapping
	function timeline_slider_func() {
		
		vc_map( array(
			"name" => __("Timeline Slider"),
			"base" => "timeline_slider",
			"as_parent" => array('only' => 'timeline_slide'), // Register "container" content element to hold all inner (child) content elements. Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
	function timeline_slide_func() {
		vc_map( array(
			"name" => __("Slide"),
			"base" => "timeline_slide",
			"icon" => "icon-wpb-single-image",
			"content_element" => true,
			"as_child" => array('only' => 'timeline_slider'), // Register "child" content element. Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Slide Image"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library")
				),
				array(
					"type" => "attach_image",
					"heading" => __("Unique Icon"),
					"param_name" => "icon_url",
					"description" => __("Select an icon from media library")
				),
				array(
					"type" => "textfield",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Slide Year"),
					"param_name" => "slide_year",
					"value" => __(""),
					"description" => __("Enter a year")
				),
				array(
					"type" => "textarea",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Slide Partner Milestone"),
					"param_name" => "slide_partner_head",
					"value" => __(""),
					"description" => __("Enter a partner milestone")
				),
				array(
					"type" => "textarea",
					"holder" => "span", 
					"class" => "vc_admin_label",
					"heading" => __("Slide Heading"),
					"param_name" => "slide_head",
					"value" => __(""),
					"description" => __("Enter a heading")
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
					"heading" => __("Custom Class"),
					"param_name" => "class",
					"value" => __(""),
					"description" => __("Enter a custom class")
		        ),
			)
		) );
	}

	// Slider Wrapper HTML
	function timeline_slider_html($atts, $content = null) {
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
	    	<div class='wpb_content_element vc-slider timeline {$class}'>
	    		<div class='slider__wrapper {$slider_theme}'>
		    		<div class='slider__content'>
		    			{$slider_head}
						{$slider_intro}
		    			<div class='carousel slides' data-flickity='{ \"contain\": true, \"wrapAround\": true, \"lazyLoad\": 2, \"hash\": true}'>
		    				{$content}
		    			</div>
		    		</div>
	    		</div>
	    	</div>
	    ";
	}

	// Single Slide HTML
	function timeline_slide_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'slide_year' => '',
			'slide_head' => '',
			'slide_partner_head' => '',
	      'class' => '',
	    ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true);

		// Get image
		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
		  $imgBlock = "<div class='slide__img'><img src='" . $img[0] . "'" . " alt='" . $imgAltTxt . "' /></div>";
		} else {
		  $imgBlock = "";
		}

		// Get unique icon
		$iconlink = shortcode_atts(array(
			'icon_url' => 'icon_url',
		), $atts);
		$iconAltTxt = get_post_meta( $iconlink["icon_url"], '_wp_attachment_image_alt', true);
		$icon = wp_get_attachment_image_src($iconlink["icon_url"], "full");
		if ($icon[0]) {
		  $iconBlock = "<div class='slide__icon'><img src='" . $icon[0] . "'" . " alt='" . $iconAltTxt . "' /></div>";
		} else {
		  $iconBlock = "";
		}

		// Get partner milestone
		if ($slide_partner_head) {
			$slide_partner_head = '<div class="slide__partner-title">'.$slide_partner_head.'</div>';
		}

		return "
	    	<div class='carousel-image slide {$class}'>
		    	<div class='slide__wrapper'>
		    		{$imgBlock}
					<div class='slide__content'>
						<h3 class='slide__year beta'>{$slide_year}</h3>
						{$slide_partner_head}
						<div class='slide__title'>{$slide_head}</div>
						<div class='slide__txt'>
							{$content}
						</div>
						{$iconBlock}
					</div>
	    		</div>
	    	</div>
	    ";
	}

?>