<?php

/**
 * The About Page
 *
 * @since 4.0
 */

namespace CustomFacebookFeed\Admin;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use CustomFacebookFeed\CFF_View;
use CustomFacebookFeed\CFF_Response;
use CustomFacebookFeed\Builder\CFF_Feed_Builder;

class CFF_About_Us {
    /**
	 * Admin menu page slug.
	 *
	 * @since 4.0
	 *
	 * @var string
	 */
	const SLUG = 'cff-about-us';

	/**
	 * Initializing the class
	 *
	 * @since 4.0
	 */
	public function __construct(){
		$this->init();
	}

    /**
	 * Determining if the user is viewing the our page, if so, party on.
	 *
	 * @since 4.0
	 */
	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', [ $this, 'register_menu' ] );
	}

	/**
	 * Register Menu.
	 *
	 * @since 4.0
	 */
	public function register_menu() {
        $cap = current_user_can( 'manage_custom_facebook_feed_options' ) ? 'manage_custom_facebook_feed_options' : 'manage_options';
        $cap = apply_filters( 'cff_settings_pages_capability', $cap );

       $about_us = add_submenu_page(
           'cff-top',
           __( 'About Us', 'custom-facebook-feed' ),
           __( 'About Us', 'custom-facebook-feed' ),
           $cap,
           self::SLUG,
           [$this, 'about_us'],
           4
       );
       add_action( 'load-' . $about_us, [$this,'about_us_enqueue_assets']);
   }

   	/**
	 * Enqueue About Us Page CSS & Script.
	 *
	 * Loads only for About Us page
	 *
	 * @since 4.0
	 */
    public function about_us_enqueue_assets(){
        if( ! get_current_screen() ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! 'facebook-feed_page_cff-about-us' === $screen->id ) {
            return;
		}

		wp_enqueue_style(
			'about-style',
			CFF_PLUGIN_URL . 'admin/assets/css/about.css',
			false,
			CFFVER
		);

	    wp_enqueue_script(
		    'sb-vue',
		    CFF_PLUGIN_URL . 'admin/assets/js/vue.min.js',
		    null,
		    '2.6.12',
		    true
	    );

		wp_enqueue_script(
			'about-app',
			CFF_PLUGIN_URL.'admin/assets/js/about.js',
			array( 'sb-vue' ),
			CFFVER,
			true
		);

		$cff_about = $this->page_data();

        wp_localize_script(
			'about-app',
			'cff_about',
			$cff_about
		);
    }

    /**
     * Page Data to use in front end
     *
     * @since 4.0
     *
     * @return array
     */
    public function page_data() {
        // get the WordPress's core list of installed plugins
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

		$license_key = null;
		if ( cff_main_pro()->cff_license_handler->get_license_key ) {
			$license_key = cff_main_pro()->cff_license_handler->get_license_key;
		}

        $installed_plugins = get_plugins();

        $images_url = CFF_PLUGIN_URL . 'admin/assets/img/about/';

	    $plugins_info = $this->get_plugins_info( $installed_plugins );

	    return [
		    'admin_url'           => admin_url(),
		    'supportPageUrl'      => admin_url( 'admin.php?page=cff-support' ),
		    'ajax_handler'        => admin_url( 'admin-ajax.php' ),
		    'links'               => \CustomFacebookFeed\Builder\CFF_Feed_Builder::get_links_with_utm(),
		    'nonce'               => wp_create_nonce( 'cff-admin' ),
		    'socialWallLinks'     => \CustomFacebookFeed\Builder\CFF_Feed_Builder::get_social_wall_links(),
		    'socialWallActivated' => is_plugin_active( 'social-wall/social-wall.php' ),
			'licenseKey'		=> $license_key,
			'cffLicenseInactiveState' => cff_license_inactive_state() ? true : false,
			'cffLicenseNoticeActive' =>  cff_license_notice_active() ? true : false,
			'svgIcons' => CFF_Feed_Builder::builder_svg_icons(),
		    'genericText'         => [
			    'help'         => __( 'Help', 'custom-facebook-feed' ),
			    'title'        => __( 'About Us', 'custom-facebook-feed' ),
			    'title2'       => __( 'Our Other Social Media Feed Plugins', 'custom-facebook-feed' ),
			    'title3'       => __( 'Plugins we recommend', 'custom-facebook-feed' ),
			    'description2' => __( 'We’re more than just a Facebook plugin! Check out our other plugins and add more content to your site.', 'custom-facebook-feed' ),
				'recheckLicense' => __( 'Recheck license', 'custom-facebook-feed' ),
				'licenseValid' => __( 'License valid', 'custom-facebook-feed' ),
				'licenseExpired' => __( 'License expired', 'custom-facebook-feed' ),
				'notification'	=> [
					'licenseActivated'   => array(
						'type' => 'success',
						'text' => __( 'License Successfully Activated', 'custom-facebook-feed' ),
					),
					'licenseError'   => array(
						'type' => 'error',
						'text' => __( 'Couldn\'t Activate License', 'custom-facebook-feed' ),
					),
				]
		    ],
		    'aboutBox'            => [
			    'atSmashBalloon' => __( 'At Smash Balloon, we build software that helps you create beautiful responsive social media feeds for your website in minutes.', 'custom-facebook-feed' ),
			    'weAreOn'        => __( 'We\'re on a mission to make it super simple to add social media feeds in WordPress. No more complicated setup steps, ugly iframe widgets, or negative page speed scores.', 'custom-facebook-feed' ),
			    'ourPlugins'     => __( 'Our plugins aren\'t just easy to use, but completely customizable, reliable, and fast! Which is why over 1.6 million awesome users, just like you, choose to use them on their site.', 'custom-facebook-feed' ),
			    'teamAvatar'     => CFF_PLUGIN_URL . 'admin/assets/img/team-avatar.png',
			    'teamImgAlt'     => __( 'Smash Balloon Team', 'custom-facebook-feed' ),
		    ],
		    'pluginsInfo'         => $plugins_info,
		    'social_wall'         => [
			    'plugin'      => 'social-wall/social-wall.php',
			    'title'       => __( 'Social Wall', 'custom-facebook-feed' ),
			    'description' => __( 'Combine feeds from all of our plugins into a single wall', 'custom-facebook-feed' ),
			    'graphic'     => CFF_PLUGIN_URL . 'admin/assets/img/social-wall-graphic.png',
			    'permalink'   => sprintf( 'https://smashballoon.com/social-wall/demo?license_key=%s&upgrade=true&utm_campaign=facebook-pro&utm_source=about&utm_medium=social-wall', $license_key ),
			    'installed'   => isset( $installed_plugins['social-wall/social-wall.php'] ),
			    'activated'   => is_plugin_active( 'social-wall/social-wall.php' ),
		    ],
		    'recommendedPlugins'  => [
			    'wpforms'         => [
				    'plugin'          => 'wpforms-lite/wpforms.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/wpforms-lite.zip',
				    'title'           => __( 'WPForms', 'custom-facebook-feed' ),
				    'description'     => __( 'The most beginner friendly drag & drop WordPress forms plugin allowing you to create beautiful contact forms, subscription forms, payment forms, and more in minutes, not hours!', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-wpforms.png',
				    'installed'       => isset( $installed_plugins['wpforms-lite/wpforms.php'] ),
				    'activated'       => is_plugin_active( 'wpforms-lite/wpforms.php' ),
			    ],
			    'monsterinsights' => [
				    'plugin'          => 'google-analytics-for-wordpress/googleanalytics.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/google-analytics-for-wordpress.zip',
				    'title'           => __( 'MonsterInsights', 'custom-facebook-feed' ),
				    'description'     => __( 'MonsterInsights makes it “effortless” to properly connect your WordPress site with Google Analytics, so you can start making data-driven decisions to grow your business.', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-mi.png',
				    'installed'       => isset( $installed_plugins['google-analytics-for-wordpress/googleanalytics.php'] ),
				    'activated'       => is_plugin_active( 'google-analytics-for-wordpress/googleanalytics.php' ),
			    ],
			    'optinmonster'    => [
				    'plugin'          => 'optinmonster/optin-monster-wp-api.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/optinmonster.zip',
				    'title'           => __( 'OptinMonster', 'custom-facebook-feed' ),
				    'description'     => __( 'Our high-converting optin forms like Exit-Intent® popups, Fullscreen Welcome Mats, and Scroll boxes help you dramatically boost conversions and get more email subscribers.', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-om.png',
				    'installed'       => isset( $installed_plugins['optinmonster/optin-monster-wp-api.php'] ),
				    'activated'       => is_plugin_active( 'optinmonster/optin-monster-wp-api.php' ),
			    ],
			    'wp_mail_smtp'    => [
				    'plugin'          => 'wp-mail-smtp/wp_mail_smtp.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/wp-mail-smtp.zip',
				    'title'           => __( 'WP Mail SMTP', 'custom-facebook-feed' ),
				    'description'     => __( 'Make sure your website\'s emails reach the inbox. Our goal is to make email deliverability easy and reliable. Trusted by over 1 million websites.', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-smtp.png',
				    'installed'       => isset( $installed_plugins['wp-mail-smtp/wp_mail_smtp.php'] ),
				    'activated'       => is_plugin_active( 'wp-mail-smtp/wp_mail_smtp.php' ),
			    ],
			    'rafflepress'     => [
				    'plugin'          => 'rafflepress/rafflepress.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/rafflepress.zip',
				    'title'           => __( 'RafflePress', 'custom-facebook-feed' ),
				    'description'     => __( 'Turn your visitors into brand ambassadors! Easily grow your email list, website traffic, and social media followers with powerful viral giveaways & contests.', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-rp.png',
				    'installed'       => isset( $installed_plugins['rafflepress/rafflepress.php'] ),
				    'activated'       => is_plugin_active( 'rafflepress/rafflepress.php' ),
			    ],
			    'aioseo'          => [
				    'plugin'          => 'all-in-one-seo-pack/all_in_one_seo_pack.php',
				    'download_plugin' => 'https://downloads.wordpress.org/plugin/all-in-one-seo-pack.zip',
				    'title'           => __( 'All in One SEO Pack', 'custom-facebook-feed' ),
				    'description'     => __( 'Out-of-the-box SEO for WordPress. Features like XML Sitemaps, SEO for custom post types, SEO for blogs, business sites, or ecommerce sites, and much more.', 'custom-facebook-feed' ),
				    'icon'            => $images_url . 'plugin-seo.png',
				    'installed'       => isset( $installed_plugins['all-in-one-seo-pack/all_in_one_seo_pack.php'] ),
				    'activated'       => is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ),
			    ]
		    ],
		    'buttons'             => [
			    'add'          => __( 'Add', 'custom-facebook-feed' ),
			    'viewDemo'     => __( 'View Demo', 'custom-facebook-feed' ),
			    'install'      => __( 'Install', 'custom-facebook-feed' ),
			    'installed'    => __( 'Installed', 'custom-facebook-feed' ),
			    'activate'     => __( 'Activate', 'custom-facebook-feed' ),
			    'deactivate'   => __( 'Deactivate', 'custom-facebook-feed' ),
			    'open'         => __( 'Open', 'custom-facebook-feed' ),
			    'upgradeToPro' => __( 'Upgrade to Pro', 'custom-facebook-feed' ),
		    ],
		    'icons'               => [
			    'plusIcon'     => '<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0832 6.83317H7.08317V11.8332H5.4165V6.83317H0.416504V5.1665H5.4165V0.166504H7.08317V5.1665H12.0832V6.83317Z" fill="white"/></svg>',
			    'loaderSVG'    => '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
			    'checkmarkSVG' => '<svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.13112 6.88917L11.4951 0.525204L12.9093 1.93942L5.13112 9.71759L0.888482 5.47495L2.3027 4.06074L5.13112 6.88917Z" fill="#8C8F9A"/></svg>',
			    'link'         => '<svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.333374 9.22668L7.39338 2.16668H3.00004V0.833344H9.66671V7.50001H8.33338V3.10668L1.27337 10.1667L0.333374 9.22668Z" fill="#141B38"/></svg>'
		    ],
	    ];
    }

	/**
	 * Get Plugins Info for about page.
	 *
	 * @since 4.1.2
	 *
	 * @return array
	 */
	public function get_plugins_info( $installed_plugins ) {
		$plugins_list = [
			'facebook'  => [
				'free' => 'custom-facebook-feed/custom-facebook-feed.php',
				'pro'  => 'custom-facebook-feed-pro/custom-facebook-feed.php',
				'link' => 'https://smashballoon.com/custom-facebook-feed/'
			],
			'instagram' => [
				'free' => 'instagram-feed/instagram-feed.php',
				'pro'  => 'instagram-feed-pro/instagram-feed.php',
				'link' => 'https://smashballoon.com/instagram-feed/'
			],
			'twitter'   => [
				'free' => 'custom-twitter-feeds/custom-twitter-feed.php',
				'pro'  => 'custom-twitter-feeds-pro/custom-twitter-feed.php',
				'link' => 'https://smashballoon.com/custom-twitter-feeds/'
			],
			'youtube'   => [
				'free' => 'feeds-for-youtube/youtube-feed.php',
				'pro'  => 'youtube-feed-pro/youtube-feed.php',
				'link' => 'https://smashballoon.com/youtube-feed/'
			]
		];

		foreach ( $plugins_list as $name => $plugin ) {
			$type      = 'none';
			$activated = 'none';
			if ( isset( $installed_plugins[ $plugin['free'] ] ) ) {
				$type      = 'free';
				$activated = is_plugin_active( $plugin['free'] );
			}
			if ( isset( $installed_plugins[ $plugin['pro'] ] ) ) {
				$type      = 'pro';
				$activated = is_plugin_active( $plugin['pro'] );
			}
			$plugins_list[ $name ]['activated'] = $activated;
			$plugins_list[ $name ]['type']      = $type;
		}

		return [
			'facebook'  => [
				'plugin'      => $plugins_list['facebook']['pro'],
				'link'        => $plugins_list['facebook']['link'],
				'title'       => __( 'Custom Facebook Feed', 'custom-facebook-feed' ),
				'description' => __( 'Add Facebook posts from your timeline, albums and much more.', 'custom-facebook-feed' ),
				'icon'        => CFF_PLUGIN_URL . 'admin/assets/img/fb-icon.svg',
				'activated'   => $plugins_list['facebook']['activated'],
				'type'        => $plugins_list['facebook']['type'],
			],
			'instagram' => [
				'plugin'          => $plugins_list['instagram']['pro'],
				'link'            => $plugins_list['instagram']['link'],
				'download_plugin' => 'https://downloads.wordpress.org/plugin/instagram-feed.zip',
				'title'           => __( 'Instagram Feed', 'custom-facebook-feed' ),
				'description'     => __( 'A quick and elegant way to add your Instagram posts to your website. ', 'custom-facebook-feed' ),
				'icon'            => CFF_PLUGIN_URL . 'admin/assets/img/insta-icon.svg',
				'activated'       => $plugins_list['instagram']['activated'],
				'type'            => $plugins_list['instagram']['type'],
			],
			'twitter'   => [
				'plugin'          => $plugins_list['twitter']['pro'],
				'link'            => $plugins_list['twitter']['link'],
				'download_plugin' => 'https://downloads.wordpress.org/plugin/custom-twitter-feeds.zip',
				'title'           => __( 'Custom Twitter Feeds', 'custom-facebook-feed' ),
				'description'     => __( 'A customizable way to display tweets from your Twitter account. ', 'custom-facebook-feed' ),
				'icon'            => CFF_PLUGIN_URL . 'admin/assets/img/twitter-icon.svg',
				'activated'       => $plugins_list['twitter']['activated'],
				'type'            => $plugins_list['twitter']['type'],
			],
			'youtube'   => [
				'plugin'          => $plugins_list['youtube']['pro'],
				'link'            => $plugins_list['youtube']['link'],
				'download_plugin' => 'https://downloads.wordpress.org/plugin/feeds-for-youtube.zip',
				'title'           => __( 'Feeds for YouTube', 'custom-facebook-feed' ),
				'description'     => __( 'A simple yet powerful way to display videos from YouTube. ', 'custom-facebook-feed' ),
				'icon'            => CFF_PLUGIN_URL . 'admin/assets/img/youtube-icon.svg',
				'activated'       => $plugins_list['youtube']['activated'],
				'type'            => $plugins_list['youtube']['type'],
			]
		];
	}

   	/**
	 * About Us Page View Template
	 *
	 * @since 4.0
	 */
	public function about_us(){
		CFF_View::render( 'about.index' );
	}
}
