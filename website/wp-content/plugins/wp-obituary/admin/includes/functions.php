<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wp_obituary_textdomain() {
	
	$plugin_dir = basename(dirname( WP_OBITUARY_FILE ));
	load_plugin_textdomain( 'wp-obituary', false, $plugin_dir );
 
}
//** Add custom widget for the obituary single page sidebar
add_action( 'widgets_init', 'wp_obituary_sidebar_callback' );
function wp_obituary_sidebar_callback() {
    register_sidebar( array(
		'name' => __( 'Obituary Sidebar', 'wp-obituary' ),
		'id' => 'obituary',
		'description' => __( 'Widgets in this area will be shown on Obituary posts.', 'wp-obituary' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wp_obituary_archive_sidebar_callback' );
function wp_obituary_archive_sidebar_callback() {
    register_sidebar( array(
		'name' => __( 'Obituary Archive Sidebar', 'wp-obituary' ),
		'id' => 'obituary-archive',
		'description' => __( 'Widgets in this area will be shown on Obituary Archives.', 'wp-obituary' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );
}
//** Create term meta for the Obituary category
add_action( 'obituary_cat_add_form_fields', 'wp_obituary_archive_meta_fields', 10, 2 );
function wp_obituary_archive_meta_fields($taxonomy) {
    ?>
    <div class="form-field term-template">
        <p><?php _e('Select Archive Template', 'wp-obituary' ); ?></p>
        <ul id="select-layout" class="obituary">
            <li id="no-sidebar" class="template selected" >
                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/no-sidebar.jpg" alt="no-sidebar" />
                <input type="radio" name="obituary-archive-template" value="no-sidebar" checked="checked" />
            </li>
            <li id="right-sidebar" class="template">
                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/right-sidebar.jpg" alt="right-sidebar" />
                <input type="radio" name="obituary-archive-template" value="right-sidebar"/>
            </li>
            <li id="left-sidebar" class="template" >
                <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/left-sidebar.jpg" alt="left-sidebar" />
                <input type="radio" name="obituary-archive-template" value="left-sidebar"/>
            </li>
        </ul>
    </div>
	<?php
}
add_action( 'created_obituary_cat', 'save_wp_obituary_archive_metadata', 10, 2 );

function save_wp_obituary_archive_metadata( $term_id, $tt_id ){
    if( isset( $_POST['obituary-archive-template'] ) && '' !== $_POST['obituary-archive-template'] ){
        $archive_template = sanitize_title( $_POST['obituary-archive-template'] );
        add_term_meta( $term_id, 'obituary-archive-template', $archive_template, true );
    }
}
add_action( 'obituary_cat_edit_form_fields', 'edit_wp_obituary_archive_field', 10, 2 );

function edit_wp_obituary_archive_field( $term, $taxonomy ){
                
    $template_layout = ( get_term_meta( $term->term_id, 'obituary-archive-template', true ) ) ? get_term_meta( $term->term_id, 'obituary-archive-template', true ) : 'no-sidebar' ;
                
    ?><tr class="form-field term-group-template">
        <th scope="row"><?php _e( 'Select Archive Template', 'wp-obituary' ); ?></th>
        <td>
        	<ul id="select-layout" class="obituary">
                <li id="no-sidebar" class="template <?php echo ( $template_layout == 'no-sidebar' ) ? 'selected' : ''; ?>" >
                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/no-sidebar.jpg" alt="no-sidebar" />
                    <input type="radio" name="obituary-archive-template" value="no-sidebar" <?php checked( 'no-sidebar', $template_layout ); ?> />
                </li>
                <li id="right-sidebar" class="template <?php echo ( $template_layout == 'right-sidebar' ) ? 'selected' : ''; ?>" >
                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/right-sidebar.jpg" alt="right-sidebar" />
                    <input type="radio" name="obituary-archive-template" value="right-sidebar" <?php checked( 'right-sidebar', $template_layout ); ?> />
                </li>
                <li id="left-sidebar" class="template <?php echo ( $template_layout == 'left-sidebar' ) ? 'selected' : ''; ?>" >
                    <img src="<?php echo WP_OBITUARY_URL; ?>admin/assets/images/left-sidebar.jpg" alt="left-sidebar" />
                    <input type="radio" name="obituary-archive-template" value="left-sidebar" <?php checked( 'left-sidebar', $template_layout ); ?> />
                </li>
            </ul>
        </td>
    </tr><?php
}
add_action( 'edited_obituary_cat', 'update_wp_obituary_archive_metadata', 10, 2 );

function update_wp_obituary_archive_metadata( $term_id, $tt_id ){

    if( isset( $_POST['obituary-archive-template'] ) && '' !== $_POST['obituary-archive-template'] ){
        $archive_template = sanitize_title( $_POST['obituary-archive-template'] );
        update_term_meta( $term_id, 'obituary-archive-template', $archive_template );
    }
}