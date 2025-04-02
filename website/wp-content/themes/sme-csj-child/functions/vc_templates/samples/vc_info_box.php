<?php

// Widget Init
add_shortcode('info_box', 'info_box_func');
add_action('vc_before_init', 'info_box_init');

function info_box_init() {
  vc_map(array(
    'name' => __('Info Box', 'sme-starter'),
    'base' => 'info_box',
    'class' => '',
    'icon' => 'icon-wpb-call-to-action',
    'category' => __('Content'),
    'params' => array(
      array(
        'type' => 'textfield',
        'holder' => 'span',
        'heading' => __('Title', 'sme-starter'),
        'param_name' => 'title',
        'value' => __('', "sme-starter"),
        'description' => __('Enter a title', 'sme-starter')
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

function info_box_func($atts, $content = null) {
  extract(shortcode_atts(array(
    'title' => '',
  ), $atts));

  $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

  $output .= "
    <div class='info-box'>
      <h2 class='info-box-title'>{$title}</h2>
      <div class='info-box-content'>{$content}</div>
    </div>
  ";

  return $output;
}
