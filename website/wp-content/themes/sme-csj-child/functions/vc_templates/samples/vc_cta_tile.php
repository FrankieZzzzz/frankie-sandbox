<?php

// Widget Init
add_shortcode('cta_tile', 'cta_tile_func');
add_action('vc_before_init', 'cta_tile');

function cta_tile() {
  vc_map(array(
    'name' => __('Tile CTA', 'sme-starter'),
    'base' => 'cta_tile',
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
        'type' => 'attach_image',
        'heading' => __('Image', 'js_composer'),
        'param_name' => 'image_url',
        'description' => __('Select image from media library', 'js_composer')
      ),
      array(
        'type' => 'vc_link',
        'heading' => __('Link to a page', 'sme-starter'),
        'param_name' => 'link',
        'description' => __('Select a link', 'sme-starter')
      ),
    )
  ));
}

function cta_tile_func($atts) {
  extract(shortcode_atts(array(
    'title' => '',
    'link' => '',
  ), $atts));

  $link_array = vc_build_link($link);
  $target_attr = '';
  $link_title = '';
  $link_icon = '<i class="fa-light fa-arrow-right-long"></i>';

  if ($link_array["target"]) {
    $target_attr = "target='{$link_array["target"]}'";
  }

  if ($link_array["title"]) {
    $link_title = $link_array["title"];

    if (strtolower($link_title) === 'download pdf') {
      $link_icon = '<i class="fa-light fa-download"></i>';
    }
  }

  $bg_image_attachment_id = shortcode_atts(array(
    'image_url' => 'image_url',
  ), $atts);


  $bg_img_src = wp_get_attachment_image_src($bg_image_attachment_id['image_url'], 'full');
  $banner_img_alt = get_post_meta($bg_image_attachment_id['image_url'], '_wp_attachment_image_alt', true);
  $image_html = '';
  $image_class = '';

  if (!empty($bg_img_src[0])) {
    $image_html = "
      <div class='tile-cta-image'>
        <img src='{$bg_img_src[0]}' alt='{$banner_img_alt}'/>
      </div>
    ";
    $image_class = 'tile-has-image';
  } else {
    $image_class = 'tile-no-image';
  }

  $output .= "
    <div class='tile-cta {$image_class}'>
      <div class='tile-cta-content'>
        <h3 class='tile-cta-title'>{$title}</h3>
        <a class='tile-cta-link btn btn-text' href='{$link_array["url"]}' $target_attr>
          {$link_title} {$link_icon}
        </a>
      </div>
      {$image_html}
    </div>
  ";

  return $output;
}
