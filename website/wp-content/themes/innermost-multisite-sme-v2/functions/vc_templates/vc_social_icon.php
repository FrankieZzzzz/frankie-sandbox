<?php

	// Widget Init
	add_shortcode( 'social_icon', 'social_icon_func' );
	add_action( 'vc_before_init', 'social_icon' );

	function social_icon() {
		vc_map( array(
			"name" => __( "Social Media Icon"),
			"base" => "social_icon",
			"class" => "",
			"icon" => "icon-wpb-vc_icon",
			"category" => __( "Content"),
			"params" => array(
			array(
                "type" => "dropdown",
				"holder" => "span", 
				"heading" => __("Icon"),
				"param_name" => "social_font",
				"value" => array(
                    "Twitter" => "fab fa-x-twitter",
				    "Facebook" => "fab fa-facebook-f",
				    "LinkedIn" => "fab fa-linkedin-in",
				    "Instagram" => "fab fa-instagram",
				    "YouTube" => "fab fa-youtube",
				    "Pinterest" => "fab fa-pinterest",
				    "TripAdvisor" => "fab fa-tripadvisor",
				    "Yelp" => "fab fa-yelp",
				    "Ebay" => "fab fa-ebay",
				    "Mail" => "fas fa-envelope",
				    "RSS" => "fas fa-rss",
				)
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __( "Custom Colour"),
                "param_name" => "social_color",
            ),
			array(
                "type" => "vc_link",
				"heading" => __("Link"),
				'param_name' => 'link',
			) )
		) );
	}

	function social_icon_func( $atts ) {
		extract( shortcode_atts( array(
            'social_font' => 'fab fa-x-twitter',
            'social_color' => '',
            'link' => '',
        ), $atts ) );

        $iconColour = "";

        if ($social_color) {
			$iconColour = " style='color:{$social_color}'";
		}

		$link_array = vc_build_link( $link );

		return "<a class='innermost-social-media-icon' href='{$link_array["url"]}' target='{$link_array["target"]}'{$iconColour}><i class=' {$social_font}'></i></a>";

	}

?>