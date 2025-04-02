<?php

// Widget Init
add_shortcode('vc_cta_events', 'cta_events_func');
add_action('vc_before_init', 'cta_events_init');

function cta_events_init() {
  vc_map(array(
    'name' => __('CTA Events', 'sme-starter'),
    'base' => 'vc_cta_events',
    'icon' => 'icon-wpb-call-to-action',
    'category' => __('Content'),
    'params' => array(
      array(
        'type' => 'textfield',
        'heading' => __('Title', 'sme-starter'),
        'param_name' => 'title',
        'value' => __('', "sme-starter"),
        'description' => __('Enter a description', 'sme-starter')
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

function cta_events_func($atts) {
  extract(shortcode_atts(array(
    'title' => '',
    'link' => '',
  ), $atts));

  $link_array = vc_build_link($link);
  $target_attr = '';

  if ($link_array["target"]) {
    $target_attr = "target='{$link_array["target"]}'";
  }

  $anchor_tag = "<a href='{$link_array["url"]}' $target_attr class='cta-card-button'>{$link_array["title"]} <i class='vc_btn3-icon fas fa-chevron-right'></i></a>";

  $args = array(
    'post_type' => 'post',
    'posts_per_page' => '2',
    'category_name' => 'events',
  );

  $events_query = new WP_Query($args);


  $output = '';

  $output .= "
    <div class='cta-card-container'>
      <div class='cta-card-content'>
        <h2 class='cta-card-title section-heading heading-border-left'>$title</h2>
        <div class='cta-card-post-container'>
  ";

  if ( $events_query->have_posts() ) {
    while ( $events_query->have_posts() ) : $events_query->the_post();
      $post_title = get_the_title();
      $permalink = get_post_permalink();

      $date = '';
      $start_date = get_field('start_date');
      $end_date = get_field('end_date');
      $location = get_field('location');

      if (!empty($start_date) && !empty($end_date)) {
        $start_date = explode(',', ($start_date))[0];
        $date .= "{$start_date} - {$end_date}";
      } else if (!empty($start_date) && empty($end_date)) {
        $date .= "{$start_date}";
      }  else if (!empty($end_date) && empty($start_date)) {
        $date .= "{$end_date}";
      }

      $output .= "
          <div class='cta-card-post'>
            <div class='cta-card-post-meta'>{$date} • {$location}</div>
            <h3 class='cta-card-post-title'>{$post_title}</h3> 
            <a href='{$permalink}' class='cta-card-post-button'>
              READ MORE <i class='vc_btn3-icon fas fa-chevron-right'></i>
            </a>
          </div>
      ";
    endwhile;
    wp_reset_query();
  }

  $output .= "</div></div>"; // cta-events-content / cta-events-post-container
  $output .= $anchor_tag;
  $output .= "</div>"; // cta-events-container

  return $output;
}
