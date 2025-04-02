<?php

// Widget Init
add_shortcode('innermost_modal', 'innermost_modal_func');
add_action('vc_before_init', 'innermost_modal_init');

function innermost_modal_init() {
  vc_map(array(
    'name' => __('Modal', 'sme-starter'),
    'base' => 'innermost_modal',
    'class' => '',
    'icon' => 'icon-wpb-call-to-action',
    'category' => __('Content'),
    'params' => array(
      array(
        'type' => 'textfield',
        'heading' => __('Modal ID', 'sme-starter'),
        'param_name' => 'modal_id',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a unique modal ID such as `modal-youtube`. Note - Ensure to have this filled', 'sme-starter')
      ),
      array(
        'type' => 'textarea_html',
        'holder' => 'div',
        'heading' => __('Content', 'sme-starter'),
        'param_name' => 'content',
        'value' => __('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', "sme-starter"),
      ),      
    )
  ));
}

function innermost_modal_func($atts, $content = null) {
  extract(shortcode_atts(array(
    'modal_id' => '',
  ), $atts));

  $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

  $modalTriggerRef = "{$modal_id}";

  $output .= "
    <div class='modal fade' id='{$modalTriggerRef}' tabindex='-1' role='dialog' aria-labelledby='${modalTriggerRef}' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
          <div class='modal-header justify-content-end'>
            <div class='modal-close-btn'><button type='button' class='btn btn-white' data-bs-dismiss='modal'>Close</button></div>
          </div>
          {$content}
        </div>
      </div>
    </div>
  ";

  return $output;
}
