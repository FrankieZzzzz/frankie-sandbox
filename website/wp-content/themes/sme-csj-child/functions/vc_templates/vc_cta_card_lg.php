<?php

	// Element Init
	add_shortcode('cta_card_lg', 'cta_card_lg_html');
	add_action('init', 'cta_card_lg_mapping');

	function cta_card_lg_mapping() {
		global $vcTxtColors, $vcBgColors;
		vc_map( array(
			"name" => __("Card - Image on left"),
			"base" => "cta_card_lg",
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
					'type' => 'vc_link',
					'heading' => __('Second link to a page'),
					'param_name' => 'link2',
					'description' => __('Select a link')
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

	function cta_card_lg_html($atts, $content = null) {
		extract( shortcode_atts( array(
	        'cta_head' => '',
			'link' => '',
			'link2' => '',
            'class' => '',
	    ), $atts ) );

		$link_array = vc_build_link($link);
		$btn_1 = createButton($link_array, 'btn-color-green_outline_button');

		$link_array = vc_build_link($link2);
		$btn_2 = createButton($link_array, 'btn-color-dgrey_button');

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$imgAltTxt = get_post_meta( $imglink["image_url"], '_wp_attachment_image_alt', true);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img[0]) {
		 	$imgUrl =  $img[0];
		 	$imgBlock = "<img src='" . $img[0] . "'" . " alt='" . $imgAltTxt . "' >";
		} else {
		 	$imgUrl = "";
		 	$imgBlock = "";
		}
		
		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		return "
			<div class='wpb_content_element cta cta__card-lg {$class}'>
				<div class='cta__wrapper'>
					<div class='cta__img'>
						{$imgBlock}
					</div>
					<div class='cta__content'>
						<h3 class='cta__head'>{$cta_head}</h3>
						<div class='cta__desc'>{$content}</div>
                        <div class='cta__btn'>{$btn_1}{$btn_2}</div>
					</div>
				</div>
			</div>";

	} // End function

?>