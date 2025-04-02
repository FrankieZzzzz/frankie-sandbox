<?php

	// Element Init
	add_shortcode('cta', 'cta_html');
	add_action('init', 'cta_mapping');

	function cta_mapping() {
		global $vcTxtColors, $vcBgColors;
		vc_map( array(
			"name" => __("Icon CTA"),
			"base" => "cta",
			"class" => "",
			"icon" => "icon-wpb-call-to-action",
			"category" => __("Content"),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Icon Image"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library")
				),
				array(
					"type" => "textarea_html",
					"holder" => "span", 
					"class" => "vc_admin_label admin_label_h2",
					"heading" => __("Heading"),
					"param_name" => "content",
					"value" => __(""),
					"description" => __("Enter a heading")
				),
	         array(
					"type" => "textfield",
					"heading" => __("Engagement Number"),
					"param_name" => "cta_num",
					"value" => __(""),
					"description" => __("Enter a number")
				),
				array(
					"type" => "textarea",
					"heading" => __("Short Description"),
					"param_name" => "cta_desc",
					"value" => __(""),
					"description" => __("Enter a short description (optional)")
				),
	         array(
				  "type" => "dropdown",
				  "heading" => __("Engagement Text Colour"),
				  "param_name" => "txt_colour",
				  "value" => $vcTxtColors,
				  "std" => "txt-blue", // default value
				  "description" => __("Select a text colour")
				),
				array(
					"type" => "dropdown",
					"heading" => __("Engagment BG Colour"),
					"param_name" => "bg_colour",
					"value" => $vcBgColors,
					"std" => "bg_yellow", // default value
					"description" => __("Select a bg colour")
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

	function cta_html($atts, $content = null) {
		extract( shortcode_atts( array(
	      'cta_head' => '',
			'cta_num' => '',
	      'cta_desc' => '',
	      'txt_colour' => 'txt-blue',
	      'bg_colour' => 'bg_yellow',
	      'class' => '',
	    ), $atts ) );

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
		  $imgBlock = "<img src='" . $img[0] . "'" . " alt='" . $imgAltTxt . "' class='cta__img'>";
		} else {
		  $imgBlock = "";
		}

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		return "
			<div tabindex='0' class='wpb_content_element cta-icon {$class}'>
				<div class='cta-icon__wrapper'>
					<div class='cta__content'>
						{$imgBlock}
						<h3 class='cta__title'>{$content}</h3>
						<p class='cta__num {$txt_colour} {$bg_colour}'>{$cta_num}</p>
						<p class='cta__desc'>{$cta_desc}</p>
					</div>
				</div>
			</div>";

	} // End function

?>