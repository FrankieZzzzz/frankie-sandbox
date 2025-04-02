<?php

 function sme_register_cpt($singular_name = '', $plura_name = '', $slug = '') {
  $labels = array(
    'name' => $plura_name,
    'singular_name' => $singular_name,
    'add_new' => 'Add New ' . $singular_name,
    'add_new_item' => 'Add New ' . $singular_name,
    'edit_item' => 'Edit ' . $singular_name,
    'new_item' => 'New ' . $singular_name,
    'all_items' => 'All ' . $plura_name,
    'view_item' => 'View ' . $singular_name,
    'search_items' => 'Search ' . $plura_name,
    'not_found' =>  'No ' . $plura_name . ' Found',
    'not_found_in_trash' => 'No ' . $plura_name . ' found in Trash',
    'parent_item_colon' => '',
    'menu_name' => $plura_name,
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'rewrite' => array('slug' => $slug),
    'query_var' => true,
    'menu_icon' => 'dashicons-edit',
    'supports' => array(
      'title',
      'editor',
      'excerpt',
      'trackbacks',
      'custom-fields',
      'revisions',
      'thumbnail',
      'author',
      'page-attributes'
    )
  );

  $post_type_name = str_replace(' ', '_', strtolower($singular_name));

  register_post_type($post_type_name, $args);
  register_taxonomy($post_type_name . '_category', $slug, array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array('slug' => $slug . '-category')));
}

/**
 * Current Custom Post Types
 * - Live Lot
 * - Silent Lot
 * - Limited Edition
 */

// sme_register_cpt('Live Lot', 'Live Lots', 'live-lots');
// sme_register_cpt('Silent Lot', 'Silent Lots', 'silent-lots');
// sme_register_cpt('Limited Edition', 'Limited Editions', 'limited-editions');
