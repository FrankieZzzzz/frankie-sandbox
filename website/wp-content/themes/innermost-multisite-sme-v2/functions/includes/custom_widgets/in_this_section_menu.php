<?php
// Author: DT

class in_this_section_menu extends WP_Widget {

    function __construct() {
        $widget_ops = array( 
            'classname' => 'in_this_section_menu',
            'description' => 'Display a list of child and / or grandchild pages associated to a page.',
        );
        parent::__construct( 'in_this_section_menu', 'In This Section Menu', $widget_ops );
    }

    // Widget Front-end output
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '' );;

        // This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $display = ( ! empty( $instance['display'] ) ) ? $instance['display'] : __( 'List of only child pages' );

        ?>

        <?php 
        global $post;
        $ancestors = get_ancestors( $post->ID, 'page', 'post_type' );
        $ancestorfirst = end($ancestors);

        if ($display == 'Full list of pages within a section') {
            if ( $ancestorfirst != '' ) {
                $children = wp_list_pages( array(
                    'title_li' => '',
                    'child_of' => $ancestorfirst,
                    'echo'     => 0
                ) );
            } else {
                $children = wp_list_pages( array(
                    'title_li' => '',
                    'child_of' => $post->ID,
                    'echo'     => 0
                ) );
            }
        } else {
            if ( $post->post_parent ) {
                $children = wp_list_pages( array(
                    'depth'    => 0,
                    'title_li' => '',
                    'child_of' => $post->ID,
                    'echo'     => 0
                ) );
            } else {
                $children = wp_list_pages( array(
                    'depth'    => 1,
                    'title_li' => '',
                    'child_of' => $post->ID,
                    'echo'     => 0
                ) );
            }
        }

        if ( $children ) : ?>

        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>
            <ul>
                <?php echo $children; ?>
            </ul>
            <?php if ($display == 'List of only child pages') { ?>
            <style>
                ul > li.page_item_has_children ul.children {display:none;}
            </style>
            <?php } ?>
        <?php echo $args['after_widget']; ?>

        <?php endif; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

    }
            
    // Widget Backend 
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $display = $instance['display'];
?>
        <p>Display a list of child and / or sibling and grandchild pages associated to a page. This widget will NOT appear on pages without child pages.</p>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Display: ' ); ?>
                <select class='widefat' id="<?php echo $this->get_field_id('display'); ?>"
                    name="<?php echo $this->get_field_name('display'); ?>" type="text">
                    <option value='List of only child pages'<?php echo ($display=='List of only child pages')?'selected':''; ?>>
                        List of only child pages
                    </option>
                    <option value='Full list of pages within a section'<?php echo ($display=='Full list of pages within a section')?'selected':''; ?>>
                        Full list of pages within a section
                    </option> 
                </select>
            </label>
        </p>

    <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['display'] = $new_instance['display'];
        return $instance;
    }

} // Class in_this_section_menu ends here

// Register and load the widget
function in_this_section_menu() {
    register_widget( 'in_this_section_menu' );
}
add_action( 'widgets_init', 'in_this_section_menu' );

?>