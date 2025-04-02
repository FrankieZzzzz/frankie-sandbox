<?php

if ( ! defined( 'WPINC' ) ) {

	die;

}



class WP_Obituary_Post_Type{

	

	public $text_domain = 'wp-obituary';

		

	function __construct(){

		add_action( 'init', array( $this, 'post_type' ) );

		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );

		add_action( 'save_post', array( $this,  'save_meta_box' ) );

	}

	

	// Register Custom Obituary

	function post_type() {

		

		$icon = WP_OBITUARY_URL.'admin/assets/images/obituary.png';

	

		$labels = array(

			'name'                  => _x( 'Obituaries', 'Obituary General Name', $this->text_domain ),

			'singular_name'         => _x( 'Obituary', 'Obituary Singular Name', $this->text_domain ),

			'menu_name'             => __( 'Obituaries', $this->text_domain ),

			'name_admin_bar'        => __( 'Obituary', $this->text_domain ),

			'archives'              => __( 'Obituary Archives', $this->text_domain ),

			'parent_item_colon'     => __( 'Parent Obituary:', $this->text_domain ),

			'all_items'             => __( 'All Obituaries', $this->text_domain ),

			'add_new_item'          => __( 'Add New Obituary', $this->text_domain ),

			'add_new'               => __( 'Add New', $this->text_domain ),

			'new_item'              => __( 'New Obituary', $this->text_domain ),

			'edit_item'             => __( 'Edit Obituary', $this->text_domain ),

			'update_item'           => __( 'Update Obituary', $this->text_domain ),

			'view_item'             => __( 'View Obituary', $this->text_domain ),

			'search_items'          => __( 'Search Obituary', $this->text_domain ),

			'not_found'             => __( 'Not found', $this->text_domain ),

			'not_found_in_trash'    => __( 'Not found in Trash', $this->text_domain ),

			'featured_image'        => __( 'Featured Image', $this->text_domain ),

			'set_featured_image'    => __( 'Set featured image', $this->text_domain ),

			'remove_featured_image' => __( 'Remove featured image', $this->text_domain ),

			'use_featured_image'    => __( 'Use as featured image', $this->text_domain ),

			'insert_into_item'      => __( 'Insert into obituary', $this->text_domain ),

			'uploaded_to_this_item' => __( 'Uploaded to this obituary', $this->text_domain ),

			'items_list'            => __( 'Obituaries list', $this->text_domain ),

			'items_list_navigation' => __( 'Obituaries list navigation', $this->text_domain ),

			'filter_items_list'     => __( 'Filter obituaries list', $this->text_domain ),

		);

		$wpobituary_supports = array( 'title', 'editor', 'author', 'thumbnail', 'comments' , 'revisions');

		$args = array(

			'label'                 => __( 'Obituary', $this->text_domain ),

			'description'           => __( 'Obituary Description', $this->text_domain ),

			'labels'                => $labels,

			'supports'              => $wpobituary_supports,

			'taxonomies'            => array( 'obituary_cat', 'obituary_tag' ),

			'hierarchical'          => false,

			'public'                => true,

			'show_ui'               => true,

			'show_in_menu'          => true,

			'menu_icon' 		  	=> $icon,

			'menu_position'         => 5,

			'show_in_admin_bar'     => true,

			'show_in_nav_menus'     => true,

			'can_export'            => true,

			'has_archive'           => true,		

			'exclude_from_search'   => false,

			'publicly_queryable'    => true,

			'capability_type'       => 'post',

			'rewrite'           	=> array( 'slug' => 'obituaries' ),

		);

		register_post_type( 'wp_obituary', $args );

		

		// Add new taxonomy, make it hierarchical (like categories)



		$labels = array(

			'name'              => _x( 'Obituary Category', 'Obituary Category' ),

			'singular_name'     => _x( 'Obituary', 'Obituary' ),

			'search_items'      => __( 'Search Obituaries', $this->text_domain ),

			'all_items'         => __( 'All Obituaries', $this->text_domain ),

			'parent_item'       => __( 'Parent Obituaries', $this->text_domain ),

			'parent_item_colon' => __( 'Parent Obituary:', $this->text_domain ),

			'edit_item'         => __( 'Edit Obituary Category', $this->text_domain ),

			'update_item'       => __( 'Update Obituary Category', $this->text_domain ),

			'add_new_item'      => __( 'Add New Obituary Category', $this->text_domain ),

			'new_item_name'     => __( 'New Obituary Name', $this->text_domain ),

			'menu_name'         => __( 'Category', $this->text_domain ),

		);

		$args = array(

			'hierarchical'      => true,

			'labels'            => $labels,

			'show_ui'           => true,

			'show_admin_column' => true,

			'query_var'         => true,

			'rewrite'           => array( 'slug' => 'obituaries' ),

		);

	

	

	

		register_taxonomy( 'obituary_cat', array( 'wp_obituary' ), $args );

	

	}

	

	/**

	 * Register meta box(es).

	 */

	function register_meta_boxes() {

		add_meta_box( 

			'obituary-layout', 

			__( 'Obituary Layout', $this->text_domain ), 

			array( $this, 'register_meta_boxes_callback' ), 

			'wp_obituary', 

			'side' );

	}

	

	 

	/**

	 * Meta box display callback.

	 *

	 * @param WP_Post $post Current post object.

	 */

	function register_meta_boxes_callback( $post ) {



		$options = get_option( 'wp_obituray_options' );

		$template_layout_setting = isset( $options['obituary_layout'] ) ? $options['obituary_layout'] : 'no-sidebar' ;

		// Display code/markup goes here. Don't forget to include nonces!

		$template_layout = ( get_post_meta( $post->ID, 'obituary-layout', TRUE ) ) ? get_post_meta( $post->ID, 'obituary-layout', TRUE ) : $template_layout_setting ;

		?>

        <ul id="select-layout" class="obituary">

            <li id="no-sidebar" class="template <?php echo ( $template_layout == 'no-sidebar' ) ? 'selected' : ''; ?>" >

                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/no-sidebar.jpg" alt="no-sidebar" />

                <input type="radio" name="obituary_layout" value="no-sidebar" <?php checked( 'no-sidebar', $template_layout ); ?> />

            </li>

            <li id="right-sidebar" class="template <?php echo ( $template_layout == 'right-sidebar' ) ? 'selected' : ''; ?>" >

                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/right-sidebar.jpg" alt="right-sidebar" />

                <input type="radio" name="obituary_layout" value="right-sidebar" <?php checked( 'right-sidebar', $template_layout ); ?> />

            </li>

            <li id="left-sidebar" class="template <?php echo ( $template_layout == 'left-sidebar' ) ? 'selected' : ''; ?>" >

                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/left-sidebar.jpg" alt="left-sidebar" />

                <input type="radio" name="obituary_layout" value="left-sidebar" <?php checked( 'left-sidebar', $template_layout ); ?> />

            </li>

        </ul>

        <p><a href="<?php echo admin_url('edit.php?post_type=wp_obituary&page=wp-obituary-settings'); ?>"><?php _e('Set Default Layout', $this->text_domain ); ?></a></p>

        <?php

	}

	 

	/**

	 * Save meta box content.

	 *

	 * @param int $post_id Post ID

	 */

	function save_meta_box( $post_id ) {

		// Save logic goes here. Don't forget to include nonce checks!

		$options = get_option( 'wp_obituray_options' );

		$template_layout_setting = isset( $options['obituary_layout'] ) ? $options['obituary_layout'] : 'no-sidebar' ;

		$obituary_layout  = isset( $_POST['obituary_layout'] ) ? $_POST['obituary_layout'] : $template_layout_setting;

		if ( !isset( $_POST['obituary_layout'] ) ) {

            return;

        }

		// Check if user has permissions to save data.

        if ( ! current_user_can( 'edit_post', $post_id ) ) {

            return;

        }

		// Check if not an autosave.

        if ( wp_is_post_autosave( $post_id ) ) {

            return;

        }

		// Check if not a revision.

        if ( wp_is_post_revision( $post_id ) ) {

            return;

        }

		

		update_post_meta( $post_id, 'obituary-layout', $obituary_layout );

		

	}

	



}

new WP_Obituary_Post_Type;