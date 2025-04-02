<?php

	// Widget Init
	add_shortcode('btnmodal', 'btnmodal_html');
	add_action('vc_before_init', 'btnmodal_mapping');

	function btnmodal_mapping() {
		global $vcBtnCustomColors;
		vc_map( array(
			"name" => __( "Modal Popup" ),
			"base" => "btnmodal",
			"icon" => "icon-wpb-ui-button",
			"wrapper_class" => "clearfix",
			"category" => __( "Content" ),
			"description" => __( "A button that launches a modal" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Button Label" ),
					"holder" => "span",
					"class" => "vc_admin_label admin_label_h2",
					"param_name" => "btnmodal_label",
					"value" => __( "" ),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Button Colour"),
					"param_name" => "btnmodal_colour",
					"value" => $vcBtnCustomColors,
					"description" => __("Select a colour.")
				),
				array(
				  "type" => "dropdown",
				  "heading" => __("Button Alignment"),
				  "param_name" => "btnmodal_align",
				  "value" => array(
					__( 'Left' ) => "align-left",
					__( 'Right' ) => "align-right",
					__( 'Center' ) => "align-center",
				  ),
				  "description" => __("Select text alignment.")
				),
				array(
					"type" => "textfield",
					"heading" => __( "Modal ID" ),
					"param_name" => "btnmodal_id",
					"value" => __( "" ),
					"description" => __( "Unique ID for modal without spaces or special characters" )
				),
				array(
					"type" => "textarea_html",
					"heading" => __( "Content" ),
					"param_name" => "content",
					"value" => __( "<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>" ),
				),
				array(
				   "type" => "textfield",
				   "heading" => __( "Extra class name" ),
				   "param_name" => "btnmodal_class",
				   "value" => __( "" ),
				   "description" => __( "Style particular content element differently - add a class name and refer to it in custom CSS." )
				),
			)
		) ); // End vc_map array
	} // End function

	function btnmodal_html($atts, $content = null) {
		extract( shortcode_atts( array(
			'btnmodal_align' => 'align-left',
			'btnmodal_colour' => 'dark_purple_button',
			'btnmodal_label' => '',
			'btnmodal_id' => '',
			'btnmodal_class' => '',
		), $atts ) );

		$modalWrapper = '';

		$btnColour = '';
		
		if ($btnmodal_colour) {
			$btnColour = 'vc_btn3-color-' . $btnmodal_colour;
		}

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		// $btnmodal_id = seo_friendly_url($btnmodal_id);

		if ($btnmodal_label && $content) {
			$modalWrapper .= '
			<div class="modal content-modal fade '.$btnmodal_class.'" id="'.$btnmodal_id.'" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">'.$content.'</div>
					</div>
				</div>
			</div>
			';
			return "<div class='btn-modal wpb_content_element {$btnmodal_align}'><button class='btn {$btnColour}  {$btnmodal_class}' data-bs-toggle='modal' data-bs-target='#{$btnmodal_id}'>{$btnmodal_label}</button></div>{$modalWrapper}";
		}

	} // End function

?>