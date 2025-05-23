<?php

/**
 * CFF Widget.
 *
 * @since 4.0
 */
namespace CustomFacebookFeed;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use CustomFacebookFeed\Builder\CFF_Db;

class CFF_Widget extends \WP_Widget
{
    public function __construct() {
        add_action( 'widgets_init', array( $this, 'cff_feed_widget' ) );
        add_filter( 'widget_text', 'do_shortcode' );

        parent::__construct(
            'cff-feed-widget',
            __( 'Facebook Feed', 'custom-facebook-feed' ),
            array(
                'classname' => 'cff-feed-widget',
                'description' => __( 'Display your facebook feed', 'custom-facebook-feed' ),
            )
        );

        add_action( 'admin_footer', [ $this, 'feed_widget_tooltip'] );
    }

    /**
     * CFF Load Feed Widget
     *
     * @since 4.0
     */
    public function cff_feed_widget() {
	    register_widget( 'CustomFacebookFeed\CFF_Widget' );
    }

	/**
	 * Feed Widget Tooltip
	 *
	 * @since 4.0
	 */
    public function feed_widget_tooltip() {
        if( ! get_current_screen() ) {
			return;
		}
		$screen = get_current_screen();
        if ( 'widgets' !== $screen->id ) {
            return;
		}

		if ( !isset( $_GET['cff_feed_id'] ) ) {
			return;
		}

		$feed_id = sanitize_text_field( wp_unslash( $_GET['cff_feed_id'] ) );

		?>
			<script>
				let html = '<div class="cff-feed-widget-tooltip" id="cff-fw-tooltip"><div class="cff-fwt-content">';
				html += '<h3><?php _e('Add Facebook Feed Widget', 'custom-facebook-feed'); ?></h3>';
				html += '<p><?php _e('Drag this widget to embed the Smash Balloon Facebook feed. ', 'custom-facebook-feed'); ?></p>';
				html += '<button type="buttom" class="cff-done-tooltip">Done</button></div>';
				html += '<button class="cff-close-tooltip"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8346 1.3415L10.6596 0.166504L6.0013 4.82484L1.34297 0.166504L0.167969 1.3415L4.8263 5.99984L0.167969 10.6582L1.34297 11.8332L6.0013 7.17484L10.6596 11.8332L11.8346 10.6582L7.1763 5.99984L11.8346 1.3415Z" fill="#141B38"/></svg></button></div>';

				// jQuery("#widget-list").append( html );
				jQuery("#widgets-left div[id*='cff-feed-widget']").append( html );

				jQuery(document).on('click', '.cff-close-tooltip, .cff-done-tooltip', function() {
					jQuery('#cff-fw-tooltip').remove();
				})
			</script>

			<style>
				.cff-feed-widget-tooltip {
					position: absolute;
					top: 60px;
    				left: 25px;
					background: #fff;
					width: 334px;
					height: 160px;
					border-radius: 2px;
					padding: 20px 44px 16px 24px;
					box-sizing: border-box;
					z-index: 9999;
					box-shadow: -7px 7px 40px rgba(0,0,0,.18);
					/* box-shadow: -7px ​7px 39px rgba(0,0,0,0.18); */
				}
				.cff-feed-widget-tooltip:before {
					content: '';
					position: absolute;
					top: -10px;
					left: 25px;
					width: 0;
					height: 0;
					border-left: 10px solid transparent;
					border-right: 10px solid transparent;
					border-bottom: 10px solid #fff;
				}
				.cff-feed-widget-tooltip h3 {
					margin: 0px 0 3px;
					font-weight: 600;
					font-size: 16px;
					line-height: 26px;
					color: #141B38;
				}
				.cff-feed-widget-tooltip p {
					margin: 0;
					font-size: 14px;
					line-height: 22px;
					color: #434960;
				}
				.cff-feed-widget-tooltip .cff-done-tooltip {
					background: #F3F4F5;
					border: 1px solid #DCDDE1;
					box-sizing: border-box;
					border-radius: 2px;
					width: 97px;
					height: 32px;
					font-weight: 600;
					font-size: 12px;
					line-height: 19px;
					color: #141B38;
					margin-top: 20px;
					cursor: pointer;
					transition: all 0.3s ease;
				}
				.cff-feed-widget-tooltip .cff-done-tooltip:hover {
					background: #fff;
				}
				.cff-feed-widget-tooltip .cff-close-tooltip {
					position: absolute;
					top: 12px;
					right: 12px;
					color: #141B38;
					background: none;
					border: none;
					padding: 0px;
					cursor: pointer;
				}
			</style>
		<?php

    }

    /**
	 * Output the HTML for this widget.
	 *
	 * @since 4.0
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $feed_id = isset( $instance['feed_id'] ) ? strip_tags( $instance['feed_id'] ) : null;

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        if ( $feed_id !== null ) {
        	$feed = sprintf( '[custom-facebook-feed feed=%s]', $feed_id );
        	echo do_shortcode( $feed );
        }

        echo $args['after_widget'];
	}

	/**
	 * Deal with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 *
	 * @since 4.0
	 *
	 * @param array $new_instance An array of new settings as submitted by the admin.
	 * @param array $old_instance An array of the previous settings.
	 *
	 * @return array The validated and (if necessary) amended settings
	 */
	public function update( $new_instance, $old_instance ) {

		$new_instance['title']      = wp_strip_all_tags( $new_instance['title'] );
		$new_instance['feed_id']    = ! empty( $new_instance['feed_id'] ) ? (int) $new_instance['feed_id'] : 0;
		$new_instance['show_title'] = isset( $new_instance['show_title'] ) ? '1' : false;
		$new_instance['show_desc']  = isset( $new_instance['show_desc'] ) ? '1' : false;

		return $new_instance;
	}

	/**
	 * Display the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @since 4.0
	 *
	 * @param array $instance An array of the current settings for this widget.
	 */
	public function form( $instance ) {
        $exported_feeds = CFF_Db::all_feeds_query();
		$feeds = array();
		foreach( $exported_feeds as $feed_id => $feed ) {
			$feeds[] = array(
				'id' => $feed['id'],
				'name' => $feed['feed_name']
			);
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html( _x( 'Title:', 'Widget', 'custom-facebook-feed' ) ); ?>
			</label>
			<input type="text"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : ''; ?>" class="widefat"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'feed_id' ) ); ?>">
				<?php echo esc_html( _x( 'Feed:', 'Widget', 'custom-facebook-feed' ) ); ?>
			</label>
			<select class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'feed_id' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'feed_id' ) ); ?>">
				<?php
				if ( ! empty( $feeds ) ) {
					echo '<option value="" selected disabled>' . esc_html_x( 'Select your feed', 'Widget', 'custom-facebook-feed' ) . '</option>';
					foreach ( $feeds as $feed ) {
						$feed_id = isset( $feed['id'] ) ? $feed['id'] : '';
						$selected = isset( $instance['feed_id'] ) ? selected( $instance['feed_id'], $feed_id, false ) : '';
						echo '<option value="' . esc_attr( $feed_id ) . '" ' . $selected . '>' . esc_html( $feed['name'] ) . '</option>';
					}
				} else {
					echo '<option value="">' . esc_html_x( 'No feeds', 'Widget', 'custom-facebook-feed' ) . '</option>';
				}
				?>
			</select>
		</p>
		<?php
	}
}