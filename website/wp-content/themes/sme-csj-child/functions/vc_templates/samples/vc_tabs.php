<?php

// Widget Init
add_shortcode('innermost_tabs', 'innermost_tabs_html');
add_shortcode('innermost_tabs_inner', 'innermost_tabs_inner_html');

add_action('init', 'innermost_tabs_init');
add_action('init', 'innermost_tabs_inner_init');

// Extend "container" content element WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_innermost_tabs extends WPBakeryShortCodesContainer {}
  class WPBakeryShortCode_innermost_tabs_inner extends WPBakeryShortCodesContainer {}
}

function innermost_tabs_init() {
  vc_map(array(
    'name' => __('Innermost Tabs', 'sme-starter'),
    'base' => 'innermost_tabs',
    'class' => '',
    'icon' => 'icon-wpb-call-to-action',
    'show_settings_on_create' => true,
    "is_container" => true,
    "content_element" => true,
    'category' => __('Content'),
    'as_parent' => array('only' => 'innermost_tabs_inner'),
    'params' => array(
      array(
        'type' => 'textfield',
        'heading' => __('Dropdown menu title', 'sme-starter'),
        'param_name' => 'dropdown_menu_title',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a dropdown menu title', 'sme-starter')
      ),      
      array(
        'type' => 'textfield',
        'heading' => __('Custom Class', 'sme-starter'),
        'param_name' => 'class',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a custom class', 'sme-starter')
      ),
    ),
    'js_view' => 'VcColumnView',
  ));
}

function innermost_tabs_inner_init() {
  vc_map(array(
    'name' => __('Innermost Tabs Section', 'sme-starter'),
    'base' => 'innermost_tabs_inner',
    'class' => '',
    'icon' => 'icon-wpb-call-to-action',
    'show_settings_on_create' => true,
    "is_container" => true,
    "content_element" => true,
    'as_child' => array('only' => 'innermost_tabs'),
    'params' => array(
      array(
        'type' => 'textfield',
        'holder' => 'span',
        'heading' => __('Tab Title', 'sme-starter'),
        'param_name' => 'title',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a title', 'sme-starter')
      ),
      array(
        'type' => 'textfield',
        'heading' => __('Tab Section ID', 'sme-starter'),
        'param_name' => 'tab_section_id',        
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a Tab Section ID, such as tab-title-name-here. <br><br>Important Note - Ensure to have the Tab Section ID filled in order for tab content to work. Leave empty ONLY if using external link field below.', 'sme-starter')
      ),
      array(
        'type' => 'vc_link',
        'heading' => __('Link to a page', 'sme-starter'),
        'param_name' => 'link',
        'description' => __('Select a link', 'sme-starter')
      ),         
      array(
        'type' => 'textfield',
        'heading' => __('Custom Class', 'sme-starter'),
        'param_name' => 'inner_class',
        'value' => __('', 'sme-starter'),
        'description' => __('Enter a custom class', 'sme-starter')
      ),
    ),
    'js_view' => 'VcColumnView',
  ));
}

function innermost_tabs_html($atts, $content = null) {
  extract(shortcode_atts(array(
    'dropdown_menu_title' => '',
    'class' => '',
  ), $atts));

  $inner_content = wpb_js_remove_wpautop($content, true);
  $tabs = '';

  preg_match_all('/title="([^"]+)" tab_section_id="([^"]+)"/', $content, $matches);
  preg_match_all('/title="([^"]+)" tab_section_id="([^"]+)" link="([^"]+)"/', $content, $link);

  foreach ($matches[1] as $key=>$value) {
    $has_link = false;

    foreach ($link[1] as $link_key=>$link_value) {
      // e.g. if 'limited-edition' === 'limited-edition' (tab with a link)
      if ($matches[2][$key] === $link[2][$link_key]) {
        $url = str_replace('url:', '', urldecode($link[3][$link_key]));
        $tabs .= "<a href='{$url}' class='tab-link' aria-selected='false'>{$link_value}</a>";  
        $has_link = true;
      }
    }

    // Renders default tab without a link
    if (!$has_link) {
      $tabs .= "<a href='#tabid-{$matches[2][$key]}' class='tab-link' id='tab-{$matches[2][$key]}' aria-controls='tabid-{$matches[2][$key]}' data-bs-toggle='tab' role='tab' aria-selected='false'>{$value}</a>";
    } 
  }

  $tabDesktopClass ='d-none d-md-block';
  $tabMobileClass =  'd-block d-md-none';

  $output .= "
    <div class='tabs-container {$class}'>
      <div class='tabs-nav'>
        <div class='tabs-list {$tabDesktopClass}' id='nav-tab' role='tablist'>
          {$tabs}
        </div>
        <div class='tabs-list tabs-list-mobile position-relative {$tabMobileClass}'>
          <span class='tab-label'>{$dropdown_menu_title}</span>
          <button class='nav-link dropdown-toggle' id='tab-dropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          </button>
          <div class='dropdown-menu' aria-labelledby='tab-dropdown'>
            {$tabs}
          </div>
        </div>
      </div>

      <div class='tab-content tabs-inner-container' id='nav-tabContent'>
      {$inner_content}
      </div>
    </div>

    <script>
    jQuery(document).ready(function ($) {
      $('.tab-pane').first().addClass('active show ');
      $('.tab-link').first().addClass('active show ');
      $('.tab-link').first().attr('aria-selected', 'true');

      const firstId = $('.tabs-list .dropdown-menu a').first().attr('id');
      const firstText = $('.tabs-list .dropdown-menu a').first().text();

      $('#tab-dropdown').attr('dataid', firstId);
      $('#tab-dropdown').text(firstText);
      $('.tabs-list .dropdown-menu a').first().addClass('active');

      // Desktop tab menu handler
      $('#nav-tab a[href*=#]').click(function() {
        $('.tabs-list a').removeClass('active show');
        $('.tab-pane').removeClass('active show');
        $('.tab-link').attr('aria-selected', 'false');

        $(this).addClass('active show');
        $(this).attr('aria-selected', 'true');

        // Desktop content pane
        $('[aria-labelledby=' + $(this).attr('id') + ']').addClass('active show');

        // Targets mobile dropdown
        $('#tab-dropdown').attr('dataid', $(this).attr('id'));
        $('#tab-dropdown').text($(this).text());
        $('.tabs-list .dropdown-menu a#' + $(this).attr('id')).addClass('active');
      });

      // Mobile dropdown menu handler
      $('.tabs-list .dropdown-menu a[href*=#]').click(function() {
        $('.tabs-list .dropdown-menu a').removeClass('active');
        $('#nav-tab a').removeClass('active');
        $('#nav-tab a#' + $(this).attr('id')).addClass('active');
        $('#tab-dropdown').attr('dataid', $(this).attr('id'));
        $('#tab-dropdown').text($(this).text());

        $('[aria-labelledby]').removeClass('active show');
        $('[aria-labelledby=' + $(this).attr('id') + ']').addClass('active show');
      });
    });
    </script>
  ";

  return $output;
}

function innermost_tabs_inner_html($atts, $content = null) {
  extract(shortcode_atts(array(
    'title' => '',
    'tab_section_id' => '',
    'inner_class' => '',
  ), $atts));

  $content = wpb_js_remove_wpautop($content, true);

  $output .= "
    <div class='tab-pane fade {$inner_class}' id='tabid-{$tab_section_id}' aria-labelledby='tab-{$tab_section_id}' role='tabpanel'>
      $content
    </div>
  ";

  return $output;
}