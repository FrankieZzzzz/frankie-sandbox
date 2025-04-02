<?php

// Widget Init
add_shortcode('testimonial', 'testimonial_func');
add_action('vc_before_init', 'testimonial_init');

function testimonial_init() {
  	vc_map(array(
		'name' => __('Testimonial', 'sme-starter'),
		'base' => 'testimonial',
		'class' => '',
		'icon' => 'icon-wpb-call-to-action',
		'category' => __('Content'),
		'params' => array(
			array(
				"type" => "textarea_html",
				"heading" => __("Short Description"),
				"param_name" => "content",
				"value" => __(""),
				"description" => __("Enter a short description")
			),
			array(
				'type' => 'textfield',
				'holder' => 'span',
				'heading' => __('Name', 'sme-starter'),
				'param_name' => 'name',
				'value' => __('', "sme-starter"),
				'description' => __('Enter a name.', 'sme-starter')
			),
			array(
				'type' => 'textfield',
				'heading' => __('Job Title', 'sme-starter'),
				'param_name' => 'job_title',
				'value' => __('', "sme-starter"),
				'description' => __('Enter a testimonial', 'sme-starter')
			),
			array(
				"type" => "attach_image",
				"heading" => __("Photo"),
				"param_name" => "image_url",
				"description" => __("Select an image from media library")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Photo alignment"),
				"param_name" => "img_align",
				'value' => array(
					'Left' => 'p_left',
					'right' => 'p_right',
				),
				"std" => "left", // default value
				"description" => __("Select a style")
			),
		)
	));
}

function testimonial_func($atts, $content = null) {
	extract(shortcode_atts(array(
		'name' => '',
		'job_title' => '',
		'img_align' => '',
	), $atts));

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

	 $output .= wp_kses_post("
        <div class='testimonial {$img_align}'>
            <div class='t_content'>
                <div class='t_quote'>{$content}</div>
                <p class='t_author'>
                    <span class='t_name'>{$name}</span>
                    <span class='t_title'>{$job_title}</span>
                </p>
            </div>
    ");

    if ($imgBlock !== "") {
        $output .= wp_kses_post("<div class='t_photo'>{$imgBlock}</div>");
    }

    $output .= wp_kses_post("</div>");

    return $output;
}
