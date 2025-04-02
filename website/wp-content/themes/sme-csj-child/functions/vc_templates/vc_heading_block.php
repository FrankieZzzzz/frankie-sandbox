<?php

// Widget Init
add_shortcode('headingblock', 'heading_block_func');
add_action('vc_before_init', 'heading_block_init');

function heading_block_init()
{
  vc_map(array(
    'name' => __('Heading Block', 'sme-starter'),
    'base' => 'headingblock',
    'icon' => 'icon-wpb-ui-custom_heading',
    'category' => __('Content'),
    'params' => array(
      array(
        'type' => 'textfield',
        'holder' => 'span',
        'class' => 'vc_admin_label admin_label_h2',
        'heading' => __('Heading Text', 'sme-starter'),
        'param_name' => 'banner_text',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a title', 'sme-starter')
      ),
      array(
        'type' => 'vc_link',
        'heading' => __('URL (Link)', 'sme-starter'),
        'param_name' => 'link',
        'description' => __('Link to heading.', 'sme-starter')
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Element Tag', 'sme-starter'),
        'param_name' => 'element_tag',
        'value' => array(
          'h1',
          'h2',
          'h3',
          'h4',
          'h5',
          'h6',
        ),
        'std'         => 'h2', // default value 
        'description' => __('Select an HTML element', 'sme-starter')
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
    //   array(
    //     'type' => 'dropdown',
    //     'heading' => __('Heading Size', 'sme-starter'),
    //     'param_name' => 'heading_size',
    //     'value' => array(
    //       __('Select'),
    //       __('h1') => 'h1',
    //       __('h2') => 'h2',
    //       __('h3') => 'h3',
    //       __('h4') => 'h4',
    //       __('h5') => 'h5',
    //       __('h6') => 'h6',
    //     ),
    //     'description' => __('Select a heading size.', 'sme-starter')
    //   ),      
      array(
        'type' => 'dropdown',
        'heading' => __('Heading Format', 'sme-starter'),
        'param_name' => 'text_transform_class',
        'value' => array(
          __('Select'),
          __('Uppercase') => 'text-uppercase',
          __('Lowercase') => 'text-lowercase',
          __('Capitalize') => 'text-capitalize',
        ),
        'description' => __('Select a text format.', 'sme-starter')
      ),
      array(
        'type' => 'dropdown',
        'heading' => __('Border', 'sme-starter'),
        'param_name' => 'border',
        'value' => array(
          __('Select'),
          __('Border Top') => 'border-top',
        ),
        'description' => __('Select a text format.', 'sme-starter')
      ),      
      array(
        'type' => 'dropdown',
        'heading' => __('Colour', 'sme-starter'),
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
        'param_name' => 'headingblock_class',
        'value' => __('', 'sme-starter'),
        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'sme-starter')
      ),
    )
  ));
}

function heading_block_func($atts) {
  extract(shortcode_atts(array(
    'banner_text' => '',
    'link' => '',
    'element_tag' => 'h2',
    'text_align' => 'align-left',
    'heading_size' => '',
    'text_transform_class' => '',
    'border' => '',
    'colour_class' => '',
    'margin_bottom' => '',
    'headingblock_class' => '',
  ), $atts));
  if (!empty($link)) {
    $link = vc_build_link($link);
    $text = '<a href="' . esc_attr($link['url']) . '"' . ($link['target'] ? ' target="' . esc_attr($link['target']) . '"' : '') . ($link['rel'] ? ' rel="' . esc_attr($link['rel']) . '"' : '') . '>' . $banner_text . '</a>';
  } else {
    $text = $banner_text;
  }

  return "<{$element_tag} class='section-heading {$heading_size} {$text_align} {$text_transform_class} {$border} {$colour_class} {$headingblock_class} {$margin_bottom}'>{$text}</{$element_tag}>";
}
