<?php

// Creating the widget 
class recent_posts_img_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'recent_posts_img_widget', 
        // Widget name will appear in UI
        __('Recent Post with Image')
        );
    }

    // Widget Front-end output
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

        // This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        // Filters the arguments for the Recent Posts widget

        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        if ($r->have_posts()) :
        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>
        <ul>
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <li>
                <?php if ( has_post_thumbnail($recent["ID"])) : ?>
                    <div class="rp-has-img">
                        <a href="<?php the_permalink(); ?>">
                            <div class="rp-thumb">
                                <?php echo get_the_post_thumbnail($recent["ID"], 'thumbnail');?>
                            </div>
                            <div class="rp-content">
                                <div class="rp-title">
                                    <?php get_the_title() ? the_title() : the_ID(); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="rp">
                        <a href="<?php the_permalink(); ?>">
                            <div class="rp-title"><?php get_the_title() ? the_title() : the_ID(); ?></div>
                        </a>
                        <!-- <a href="<?php //the_permalink(); ?>" class="btn basic-btn small">Read More</a> -->
                    </div>
                <?php endif; ?>
            
            </li>
        <?php endwhile; ?>
        </ul>
        <?php echo $args['after_widget']; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;
    }
            
    // Widget Backend 
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

    <?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

} // Class recent_posts_img_widget ends here

// Register and load the widget
function recent_posts_img_widget() {
    register_widget( 'recent_posts_img_widget' );
}
add_action( 'widgets_init', 'recent_posts_img_widget' );

?>