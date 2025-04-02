<?php

	// Element Init
	add_shortcode('cta_card', 'cta_card_html');
	add_action('init', 'cta_card_mapping');

	function cta_card_mapping() {
		global $vcTxtColors, $vcBgColors;
		vc_map( array(
			"name" => __("CTA Card"),
			"base" => "cta_card",
			"class" => "",
			"icon" => "icon-wpb-call-to-action",
			"category" => __("Content"),
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "span", 
					"class" => "vc_admin_label admin_label_h2",
					"heading" => __("Heading"),
					"param_name" => "cta_head",
					"value" => __(""),
					"description" => __("Enter a heading")
				),
	            array(
					"type" => "textfield",
					"heading" => __("Sub Heading"),
					"param_name" => "cta_subhead",
					"value" => __(""),
					"description" => __("Enter a sub heading")
				),
				array(
					"type" => "textarea_html",
					"heading" => __("Short Description"),
					"param_name" => "content",
					"value" => __(""),
					"description" => __("Enter a short description")
				),
                array(
					"type" => "textfield",
					"heading" => __("Card Rotation (Degrees)"),
					"param_name" => "cta_rotate",
					"value" => __(""),
					"description" => __("Enter a degree to rotate the card")
				),
                array(
					"type" => "attach_image",
					"heading" => __("Background Image"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library")
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Class"),
					"param_name" => "class",
					"value" => __(""),
					"description" => __("Enter a custom class")
				),
	      )
	   ) ); // End vc_map array
	} // End function

	function cta_card_html($atts, $content = null) {
		extract( shortcode_atts( array(
	        'cta_head' => '',
		    'cta_subhead' => '',
            'cta_rotate' => '',
            'class' => '',
	    ), $atts ) );

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img) {
		  $imgBlock = $img[0];
		} else {
		  $imgBlock = "";
		}

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		return "
			<div class='wpb_content_element cta cta__card {$class}' style='background-image: url({$imgBlock}); transform: rotate({$cta_rotate}deg);'>
				<div class='cta__wrapper'>
					<div class='cta__content'>
						<h3 class='cta__head'>{$cta_head}</h3>
						<p class='cta__subhead'>{$cta_subhead}</p>
						<div class='cta__desc'>{$content}</div>
					</div>
				</div>
			</div>";

	} // End function

?>