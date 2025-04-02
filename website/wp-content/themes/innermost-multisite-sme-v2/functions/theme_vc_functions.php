<?php 

if(class_exists('WPBMap')) {

  /**
   * Add file picker shartcode param.
   *
   * @param array $settings   Array of param seetings.
   * @param int   $value      Param value.
   */
  function file_picker_settings_field( $settings, $value ) {
    $output = '';
    $select_file_class = '';
    $remove_file_class = ' hidden';
    $attachment_url = wp_get_attachment_url( $value );
    if ( $attachment_url ) {
      $select_file_class = ' hidden';
      $remove_file_class = '';
    }
    $output .= '<div class="file_picker_block">
                  <div class="' . esc_attr( $settings['type'] ) . '_display">' .
                    $attachment_url .
                  '</div>
                  <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
                  esc_attr( $settings['param_name'] ) . ' ' .
                  esc_attr( $settings['type'] ) . '_field" value="' . esc_attr( $value ) . '" />
                  <button class="button file-picker-button' . $select_file_class . '">Select File</button>
                  <button class="button file-remover-button' . $remove_file_class . '">Remove File</button>
                </div>
                ';
    return $output;
  }
  vc_add_shortcode_param( 'file_picker', 'file_picker_settings_field', get_template_directory_uri() . '/js/file_picker.min.js' );

  // Social media icon
  include_once "vc_templates/vc_social_icon.php";

}

?>