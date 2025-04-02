<?php

// Widget Init
add_shortcode('contentblock', 'contentblock_func');
add_action('vc_before_init', 'contentblock_init');

function contentblock_init() {
  vc_map(array(
    'name' => __('Content Block', 'sme-starter'),
    'base' => 'contentblock',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => __('Content'),
    'description' => __('A block of text with WYSIWYG editor', 'sme-starter'),
    'params' => array(
      array(
        'type' => 'textarea_html',
        'holder' => 'div',
        'heading' => __('Content', 'sme-starter'),
        'param_name' => 'content',
        'value' => __('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', "sme-starter"),
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Text Align', 'sme-starter'),
        'param_name' => 'text_align',
        'value' => array(
          __('Left') => 'align-left',
          __('Right') => 'align-right',
          __('Center') => 'align-center',
        ),
        'description' => __('Select text alignment.', 'sme-starter')
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Text Style', 'sme-starter'),
        'param_name' => 'text_style',
        'value' => array(
          __('Select'),
          __('Emphasis') => 'emphasis',
          __('Small') => 'small',
        ),
        'std' => '', // default value
        'description' => __('Select text style.', 'sme-starter')
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Text Colour', 'sme-starter'),
        'param_name' => 'colour_class',
        'value' => array(
          __('Select'), 
          __('CSJ Prime Green') => 'txt-prime-green',
          __('CSJ Prime Dark Grey') => 'txt-prime-dark-grey',
          __('CSJ White') => 'txt-white',
          __('CSJ Charcoal Grey') => 'txt-charcoal-grey',
        ),
        'description' => __('Select a colour.', 'sme-starter')
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Margin Bottom', 'sme-starter'),
        'param_name' => 'margin_bottom',
        'value' => array(
          __('Select'),
          __('0px') => 'mb-0',
          __('2.5px') => 'mb-1',
          __('5px') => 'mb-2',
          __('10px') => 'mb-3',
          __('15px') => 'mb-4',
          __('30px') => 'mb-5',
        ),
        'description' => __('Select a colour.', 'sme-starter')
      ),      
      array(
        'type' => 'textfield',
        'heading' => __('Extra class name', 'sme-starter'),
        'param_name' => 'contentblock_class',
        'value' => __('', 'sme-starter'),
        "description" => __("Style particular content element differently - add a class name and refer to it in custom CSS.", "sme-starter")
      ),
    )
  ));
}

function contentblock_func($atts, $content = null) { // New function parameter $content is added!
  extract(shortcode_atts(array(
    'text_align' => 'align-left',
    'text_style' => '',
    'colour_class' => 'txt-black',
    'margin_bottom' => '',
    'contentblock_class' => '',
  ), $atts));

  $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

  return "<div class='section-content wpb_text_column wpb_content_element {$text_align} {$text_style} {$colour_class} {$contentblock_class} {$margin_bottom}'><div class='wpb_wrapper'>{$content}</div></div>";
}
