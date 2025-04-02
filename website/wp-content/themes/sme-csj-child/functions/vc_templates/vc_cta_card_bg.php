<?php

	// Element Init
	add_shortcode('cta_card_bg', 'cta_card_bg_html');
	add_action('init', 'cta_card_bg_mapping');

	function cta_card_bg_mapping() {
		global $vcTxtColors, $vcBgColors;
		vc_map( array(
			"name" => __("Card - With BG Image"),
			"base" => "cta_card_bg",
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

	function cta_card_bg_html($atts, $content = null) {
		extract( shortcode_atts( array(
	        'cta_head' => '',
            'link' => '',
            'class' => '',
	    ), $atts ) );

		$link_array = vc_build_link($link);
		$link_url = $link_array['url'];
		$link_title = $link_array['title'];
		$link_target = $link_array['target'];
		$link_rel = $link_array['rel'];
		$btn_tag = ($link_url) ? 'a' : 'div';
		$btn_url = ($link_url) ? 'href="'.$link_url.'"' : '';
		$btn_title = ($link_title) ? '<div class="link">'.$link_title.'</div>' : '';
		$btn_target = ($link_target) ? 'target="'.$link_target.'"' : '';
		$btn_rel = ($link_rel) ? 'rel="'.$link_rel.'"' : '';

		$imglink = shortcode_atts(array(
			'image_url' => 'image_url',
		), $atts);
		$img = wp_get_attachment_image_src($imglink["image_url"], "full");
		if ($img) {
		  $imgBlock = $img[0];
		} else {
		  $imgBlock = "";
		}

        // if(!empty($content)){
        //     $content = wpb_js_remove_wpautop($content, true);

        //     if(str_word_count(strip_tags($content)) > 30){
        //         $content = wp_trim_words($content, 30, '...');
        //     }
        // }
		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


		$output = "<{$btn_tag} {$btn_url} class='wpb_content_element cta cta__card__bg {$class}' style='background-image: url({$imgBlock});' {$btn_target} {$btn_rel}>
				<div class='cta__wrapper'>
					<div class='cta__content'>
						<h4 class='cta__head'>{$cta_head}</h4>
						<div class='cta__desc'>{$content}</div>
						{$btn_title}
					</div>
				</div>
			</{$btn_tag}>";
		
		return $output;

	} // End function

?>