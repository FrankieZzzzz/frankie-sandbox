<?php

	// Element Init
	add_shortcode('cta_card_sm', 'cta_card_sm_html');
	add_action('init', 'cta_card_sm_mapping');

	function cta_card_sm_mapping() {
		global $vcTxtColors, $vcBgColors;
		vc_map( array(
			"name" => __("Card - Vertical Small"),
			"base" => "cta_card_sm",
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
					"type" => "textarea_html",
					"heading" => __("Short Description"),
					"param_name" => "content",
					"value" => __(""),
					"description" => __("Enter a short description")
				),
                array(
					"type" => "attach_image",
					"heading" => __("Image"),
					"param_name" => "image_url",
					"description" => __("Select an image from media library")
				),
				array(
					'type' => 'vc_link',
					'heading' => __('Link to a page', 'sme-starter'),
					'param_name' => 'link',
					'description' => __('Select a link', 'sme-starter')
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

	function cta_card_sm_html($atts, $content = null) {
		extract( shortcode_atts( array(
	        'cta_head' => '',
			'link' => '',
            'class' => '',
	    ), $atts ) );

		$link_array = vc_build_link($link);
		$btn_1 = createButton($link_array, 'btn-color-green_link');

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
		 	$imgUrl =  $img[0];
		 	$imgBlock = "<div class='cta__img'><img src='" . $img[0] . "'" . " alt='" . $imgAltTxt . "' ></div>";
		} else {
		 	$imgUrl = "";
		 	$imgBlock = "";
		}

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
        // {$btn_1}

		return "
			<div class='wpb_content_element cta cta__card__sm {$class}'>
				<div class='cta__wrapper'>
					{$imgBlock}
					<div class='cta__content'>
						<h4 class='cta__head'>{$cta_head}</h4>
						<div class='cta__desc'>{$content}</div>	
						<div class='cta__btn'>{$btn_1}</div>	
					</div>
				</div>
			</div>";

	} // End function

?>