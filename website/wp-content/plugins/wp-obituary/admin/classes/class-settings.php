<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Obituary_Settings{
	
	public $text_domain = 'wp-obituary';
	
	function __construct(){
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}
	
	function settings_menu(  ) { 
	
		add_submenu_page( 
			'edit.php?post_type=wp_obituary', 
			__( 'WP Obituary Settings ', $this->text_domain ), 
			__( 'Settings', $this->text_domain ), 
			'manage_options', 
			'wp-obituary-settings', 
			array( $this, 'settings_callback' )
		);
	
	}
	
	function settings_init(  ) { 
	
		register_setting( 'wp_obituary_settings', 'wp_obituray_options' );	
	
	}
	
	
	function settings_callback(  ) { 
		$options = get_option( 'wp_obituray_options' );
		$template_layout = isset( $options['obituary_layout'] ) ? $options['obituary_layout'] : 'no-sidebar' ;
		?>
        <div class="wrap">
			<?php do_action('wp_obituary_before_settings'); ?>
            <form action='options.php' method='post'>
                <h2><?php _e( 'WP Obituary Settings', $this->text_domain ); ?></h2>
                <?php settings_fields( 'wp_obituary_settings' ); ?>
                <?php do_settings_sections( 'wp_obituary_settings' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Obituary Default Layout', $this->text_domain ) ; ?></th>
                        <td>
                            <ul id="select-layout" class="obituary">
                                <li id="no-sidebar" class="template <?php echo ( $template_layout == 'no-sidebar' ) ? 'selected' : ''; ?>" >
                                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/no-sidebar.jpg" alt="no-sidebar" />
                                    <input type="radio" name="wp_obituray_options[obituary_layout]" value="no-sidebar" <?php checked( 'no-sidebar', $template_layout ); ?> />
                                </li>
                                <li id="right-sidebar" class="template <?php echo ( $template_layout == 'right-sidebar' ) ? 'selected' : ''; ?>" >
                                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/right-sidebar.jpg" alt="right-sidebar" />
                                    <input type="radio" name="wp_obituray_options[obituary_layout]" value="right-sidebar" <?php checked( 'right-sidebar', $template_layout ); ?> />
                                </li>
                                <li id="left-sidebar" class="template <?php echo ( $template_layout == 'left-sidebar' ) ? 'selected' : ''; ?>" >
                                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/left-sidebar.jpg" alt="left-sidebar" />
                                    <input type="radio" name="wp_obituray_options[obituary_layout]" value="left-sidebar" <?php checked( 'left-sidebar', $template_layout ); ?> />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Obituary Default Thumnail', $this->text_domain ) ; ?></th>
                        <td>
                            <input type="text" name="wp_obituray_options[default_image_url]" id="default_image_url" class="regular-text" value="<?php echo $options['default_image_url'];?>" >
                            <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
                        </td>
                    </tr>
                    <?php do_action('wp_obituary_after_settings_field'); ?>
               </table>
                <?php do_action('wp_obituary_after_settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
		<?php
	}

}
new WP_Obituary_Settings();