<?php
/**
 * Customizer Tab
 *
 *
 * @since 4.0
 */
namespace CustomFacebookFeed\Builder\Tabs;
use CustomFacebookFeed\Admin\Traits\CFF_Settings;
use CustomFacebookFeed\CFF_License_Tier;
if(!defined('ABSPATH'))	exit;


class CFF_Settings_Tab{

	use CFF_Settings;
	public static $should_disable_pro_features = false;
	public static $license_tier_features = false;


	/**
	 * Get Setting Tab Sections
	 *
	 *
	 * @since 4.0
	 * @access public
	 *
	 * @return array
	*/
	public static function get_sections()
    {
		self::$should_disable_pro_features = cff_main_pro()->cff_license_handler->should_disable_pro_features;
        $license_tier = new CFF_License_Tier();
        self::$license_tier_features = $license_tier->tier_features();

		return [
			'settings_sources' => [
				'heading' 	=> __( 'Sources', 'custom-facebook-feed' ),
				'icon' 		=> 'source',
				'separator'	=> 'none',
				'controls'	=> self::get_settings_sources_controls()
			],
			'settings_filters' => [
				'heading' 	=> __( 'Filters', 'custom-facebook-feed' ),
				'icon' 		=> 'filter',
				'separator'	=> 'none',
				'controls'	=> self::get_settings_filters_controls(self::$license_tier_features)
			],
			'empty_sections' => [
				'heading' 	=> '',
				'isHeader' 	=> true,
			],
			'settings_advanced' => [
				'heading' 	=> __( 'Advanced', 'custom-facebook-feed' ),
				'icon' 		=> 'cog',
				'controls'	=> self::get_settings_advanced_controls()
			]
		];
	}



	/**
	 * Get Settings Tab Sources Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_sources_controls(){
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'sources'
			]
		];
	}



	/**
	 * Get Settings Tab Filters Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_filters_controls($license_tier_features){
		$controls = [
			[
				'type' 				=> 'select',
				'id' 				=> 'showpostsby',
				'heading' 			=> __( 'Display posts by', 'custom-facebook-feed' ),
				'condition'			=> ['feedtype' => ['timeline'],'pagetype' => ['page']],
				'conditionHide'		=> true,
				'ajaxAction' 		=> 'feedFlyPreview',
                'checkExtensionDimmed'  => in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
                'checkExtensionPopup'   => in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
                'disabledInput'         => in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'options'			=> [
					'me' 			=> __( 'Page Owner', 'custom-facebook-feed' ),
					'others' 		=> __( 'Page owner + Visitors', 'custom-facebook-feed' ),
					'onlyothers' 	=> __( 'Visitors', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],


			//****Reviews
			[
				'type' 				=> 'heading',
				'condition'			=> ['feedtype' => ['reviews']],
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'heading' 			=> __( 'Reviews', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'hidenegative',
				'condition'			=> ['feedtype' => ['reviews']],
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( 'Hide negative recommendations', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'reviewshidenotext',
				'condition'			=> ['feedtype' => ['reviews']],
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( 'Hide reviews with no text', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],

			[
				'type' 				=> 'heading',
				'condition'			=> ['feedtype' => ['reviews']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Only show reviews with a rating of', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'cff_reviews_rated_5',
				'condition'			=> ['feedtype' => ['reviews']],
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( '5 Stars', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'cff_reviews_rated_4',
				'condition'			=> ['feedtype' => ['reviews']],
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( '4 Stars', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'cff_reviews_rated_3',
				'condition'			=> ['feedtype' => ['reviews']],
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( '3 Stars', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'cff_reviews_rated_2',
				'condition'			=> ['feedtype' => ['reviews']],
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( '2 Stars', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'cff_reviews_rated_1',
				'condition'			=> ['feedtype' => ['reviews']],
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'label' 			=> __( '1 Stars', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
		];

		$pro_controls = [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'showpoststypes',
				'condition'	=> ['feedtype' => ['timeline']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'heading' 	=> __( 'Show', 'custom-facebook-feed' ),
				'options'	=> [
					[
						'value' => 'all',
						'label' => __( 'All posts', 'custom-facebook-feed' )
					],
					[
						'value' => 'custom',
						'label' => __( 'Only specified posts', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'heading' 			=> __( 'Display posts with', 'custom-facebook-feed' ),
			],
			/*
			&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				TO BE CHECKED
			&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			*/
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Only Text', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'statuses'
			],
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Shared Link', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'links'
			],
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Video', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'videos'
			],
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Single Photo', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'photos'
			],
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Multiple photos or an album', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'albums'
			],
			[
				'type' 				=> 'checkbox',
				'condition'			=> ['feedtype' => ['timeline'],'showpoststypes' => ['custom']],
				'conditionHide'		=> true,
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'label' 			=> __( 'Event', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'custom'			=> 'feedtype',
				'value'				=> 'events'
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'pastevents',
				'condition'			=> ['feedtype' => ['events']],
				'ajaxAction'		=> 'feedFlyPreview',
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'heading' 			=> __( 'Only Show Past Events', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			/*
			&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			*/
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'textarea',
				'id' 				=> 'filter',
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'heading' 			=> __( 'Only show posts containing', 'custom-facebook-feed' ),
				'tooltip' 			=> sprintf( __( 'Only display posts containing these text strings, separating multiple strings using commas. If only a few posts, or none at all, are displayed then you may need to increase the plugin\'s "API Post Limit" setting. See %s<a href="https://smashballoon.com/filtering-your-facebook-posts/" target="_blank">this FAQ%s to learn more about how filtering works.', 'custom-facebook-feed' ), '<a href="https://smashballoon.com/filtering-your-facebook-posts/" target="_blank">', '</a>'),
				'placeholder'		=> __( 'Add words here to only show posts containing these words', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],

			[
				'type' 				=> 'textarea',
				'id' 				=> 'exfilter',
				'ajaxAction' 		=> 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'checkExtensionPopup' => !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features) ? null : 'advancedFilter',
				'disabledInput'		=> !self::$should_disable_pro_features && in_array('filter_posts', $license_tier_features)  ? null : true,
				'heading' 			=> __( 'Do not show posts containing', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Remove any posts containing these text strings, separating multiple strings using commas.', 'custom-facebook-feed' ),
				'placeholder'		=> __( 'Add words here to hide any posts containing these words', 'custom-facebook-feed' ),
			],

			[
				'type' 				=> 'separator',
				#'checkExtension'	=> 'date_range',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			//Date Range
			[
				'type' 				=> 'switcher',
				'id' 				=> 'daterange',
				'checkExtensionDimmed'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'ajaxAction' 		=> 'feedFlyPreview',
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'disabledInput'		=>  !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Show posts within the date range', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			//Date Range From
			[
				'type' 				=> 'heading',
				'strongHeading'		=> 'true',
				'stacked'			=> 'true',
				#'checkExtension'	=> 'date_range',
				'checkExtensionDimmed'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'disabledInput'		=>  !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'From', 'custom-facebook-feed' ),
			],
			[
				'type' 		=> 'togglebutton',
				'id' 		=> 'daterangefromtype',
				'stacked'	=> 'true',
				'condition'	=> ['daterange' => ['on']],
				'conditionDimmed'	=> ['daterange' => ['off']],
				'disabledInput'		=>  !self::$should_disable_pro_features ? null : true,
				'checkExtensionPopup' => 'date_range',
				'options'	=> [
					[
						'value' => 'specific',
						'label' => __( 'Specific', 'custom-facebook-feed' )
					],
					[
						'value' => 'relative',
						'label' => __( 'Relative', 'custom-facebook-feed' )
					],

				]
			],
			[
				'type' 				=> 'datepicker',
				'id' 				=> 'daterangefromspecific',
				'condition'			=> ['daterange' => ['on'],'daterangefromtype' => 'specific'],
				'conditionDimmed'	=> ['daterange' => ['off'],'daterangefromtype'=> ['specific']],
				'conditionHide'		=> true,
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'stacked'			=> 'true',
				'placeholder' 		=> __( 'Select Specific Date', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'daterangefromrelative',
				'condition'			=> ['daterange' => ['on'],'daterangefromtype' => 'relative'],
				'conditionDimmed'	=> ['daterange' => ['off'],'daterangefromtype'=> ['relative']],
				'conditionHide'		=> true,
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'stacked'			=> 'true',
				'placeholder' 		=> __( 'eg: -1 days', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'hidden',
				'id' 				=> 'from',
				'checkExtensionPopup' => 'date_range',
				#'checkExtension'	=> 'date_range',
			],


			//To
			[
				'type' 				=> 'heading',
				'strongHeading'		=> 'true',
				'stacked'			=> 'true',
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'checkExtensionDimmed'	=> 'date_range',
				'heading' 			=> __( 'To', 'custom-facebook-feed' ),
			],
			[
				'type' 		=> 'togglebutton',
				'id' 		=> 'daterangeuntiltype',
				'stacked'	=> 'true',
				'condition'	=> ['daterange' => ['on']],
				'conditionDimmed'	=> ['daterange' => ['off']],
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'options'	=> [
					[
						'value' => 'specific',
						'label' => __( 'Specific', 'custom-facebook-feed' )
					],
					[
						'value' => 'relative',
						'label' => __( 'Relative', 'custom-facebook-feed' )
					],

				]
			],
			[
				'type' 				=> 'datepicker',
				'id' 				=> 'daterangeuntilspecific',
				'condition'			=> ['daterange' => ['on'],'daterangeuntiltype' => 'specific'],
				'conditionDimmed'	=> ['daterange' => ['off'],'daterangeuntiltype'=> ['specific']],
				'conditionHide'		=> true,
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'stacked'			=> 'true',
				'placeholder' 		=> __( 'Select Specific Date', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'daterangeuntilrelative',
				'condition'			=> ['daterange' => ['on'],'daterangeuntiltype' => 'relative'],
				'conditionDimmed'	=> ['daterange' => ['off'],'daterangeuntiltype'=> ['relative']],
				'conditionHide'		=> true,
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
				'stacked'			=> 'true',
				'placeholder' 		=> __( 'eg: now', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'hidden',
				'id' 				=> 'until',
				'ajaxAction' 		=> 'feedFlyPreview',
				#'checkExtension'	=> 'date_range',
				'checkExtensionPopup' => 'date_range',
			],
			[
				'type' 					=> 'heading',
				'underline' 			=> 'true',
				'tooltipAlign' 				=> 'left',
				'checkExtensionPopup' 	=> 'date_range',
				'heading' 				=> __( 'What are relative Dates?', 'custom-facebook-feed' ),
				'tooltip' 				=> __( 'Relative dates are dynamic dates which are based on the current date.<br/>
					<strong>Examples:</strong><br/>
					<ul>
						<li><strong>-1 days:</strong> show posts from 1 day before today</li>
						<li><strong>-12 hours:</strong> show posts from 12 hours before now</li>
						<li><strong>-3 months:</strong> show posts from the past 3 months</li>
					</ul>
					<strong><a class="sb-tltp-black-link" href="https://smashballoon.com/doc/how-to-use-the-date-range-extension-to-display-facebook-posts-from-a-specific-date-period/?facebook#relative" target="_blank">Learn More about Relative Dates</a></strong>
', 'custom-facebook-feed' ),
			],
		];

		$controls = array_merge( $controls, $pro_controls );

		return $controls;
	}

	/**
	 * Get Settings Tab Advanced Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_advanced_controls(){
		return [
            [
				'type' 				=> 'select',
				'id' 				=> 'albumordertype',
				'condition'			=> ['feedtype' => ['albums']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Album order', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Facebook sends the album posts in an order that is sometimes different than what is seen on the Facebook App. If your albums appear out of order, try changing this setting to see if this issue is corrected.', 'custom-facebook-feed' ),
				'options'			=> [
					'default' => __( 'Default from API', 'custom-facebook-feed' ),
					'date' => __( '"Updated on" date', 'custom-facebook-feed' )
				]
			],
            [
				'type' 				=> 'separator',
				'top' 				=> 10,
				'condition'			=> ['feedtype' => ['albums']],
				'conditionHide'		=> true,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'timelinepag',
				'heading' 			=> __( 'Timeline pagination method', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Whether to use the date/time of the last post or the API Paging URL to paginate to the next batch of posts. This should only be changed if advised by a member of the support team.', 'custom-facebook-feed' ),
				'condition'			=> ['feedtype' => ['timeline']],
				'conditionHide'		=> true,
				'options'			=> [
					'date' => __( 'Date', 'custom-facebook-feed' ),
					'paging' => __( 'API Paging', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'condition'			=> ['feedtype' => ['timeline']],
				'conditionHide'		=> true,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'gridpag',
				'condition'			=> ['feedtype' => ['photos','videos','albums','singlealbum']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Grid pagination method', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'The pagination method for photo, video, and album feeds. Whether to paginate through new posts by using the post offset or the API URL for the next set of posts. This should only be changed if advised by a member of the support team.', 'custom-facebook-feed' ),
				'options'			=> [
					'auto' => __( 'Auto', 'custom-facebook-feed' ),
					'cursor' => __( 'Cursor', 'custom-facebook-feed' ),
					'offset' => __( 'Offset', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'condition'			=> ['feedtype' => ['photos','videos','albums','singlealbum']],
				'conditionHide'		=> true,
				'bottom' 			=> 0,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'apipostlimit',
				'condition'			=> ['feedtype' => ['timeline','photos','videos','albums','events','singlealbum','reviews']],
				'ajaxAction'		=> 'feedFlyPreview',
				'conditionHide'		=> true,
				'heading' 			=> __( 'API Post Limit', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'This setting controls the number of posts retrieved from the Facebook API. If set to "Automatic" then the plugin will automatically get the right number of posts from the Facebook API. You can also use the "Manual" option to set this manually.
					If you are using the Multifeed extension then the post limit is the number of posts you retrieve from each Facebook page. Eg, you have 3 Facebook pages and set the limit to be 5 then 15 posts in total will be retrievd from Facebook - 5 for each page.', 'custom-facebook-feed' ),
				'options'			=> [
					'auto' => __( 'Automatic', 'custom-facebook-feed' ),
					'manual' => __( 'Manual', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'limit',
				'stacked'			=> 'true',
				'placeholder'		=> __( 'Enter API Post Limit', 'custom-facebook-feed' ),
				'ajaxAction'		=> 'feedFlyPreview',
				'condition'			=> ['apipostlimit' => ['manual'],'feedtype' => ['timeline','photos','videos','albums','events','singlealbum','reviews']],
				'max'				=> 100,
				'min'				=> 1
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'eventspostlimit',
				'stacked'			=> 'true',
				'heading'		=> __( 'Events Limit', 'custom-facebook-feed' ),
				'tooltip'		=> __( 'Enter the events post limit', 'custom-facebook-feed' ),
				'condition'			=> ['feedtype' => ['events']],
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 10,
				'conditionHide'		=> true,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'videoaction',
				'heading' 			=> __( 'Play Video Action', 'custom-facebook-feed' ),
				'condition'			=> ['feedtype' => ['timeline','videos']],
				'conditionHide'		=> true,
				'description'		=> __( 'What should happen when a video in the feed is clicked', 'custom-facebook-feed' ),
				'options'			=> [
					'post' => __( 'Play directly in the feed', 'custom-facebook-feed' ),
					'facebook' => __( 'Link to the video on Facebook', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'reviewsmethod',
				'condition'			=> ['feedtype' => ['reviews']],
				'checkExtension'	=> 'reviews',
				'conditionHide'		=> true,
				'heading' 			=> __( 'Reviews Retrieval Method', 'custom-facebook-feed' ),
				'description' 		=> __( 'Most users should leave this set as "Auto" and only change it if directed by a member of the support team.' ),
				'options'			=> [
					'auto' => __( 'Automatic', 'custom-facebook-feed' ),
					'all' => __( 'All', 'custom-facebook-feed' ),
				]
			],

			//API Bug Arrounds
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 20,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'API Bug Workarounds', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'loadcommentsjs',
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Load Comments with JavaScript', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Loads comments using JavaScript to workaround a Facebook "unknown error" bug caused by requesting comments in the API request', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'salesposts',
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Sales Posts Fix', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Removes the attachments description field to workaround a Facebook "Unsupported Get Request" bug caused by sales posts in a feed', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'storytags',
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Story Tags Fix', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'Removes the story_tags field in the API call to workaround a Facebook "Unknown Error" message returned for certain posts', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'locale',
				'heading' 			=> __( 'Localization', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'This controls the language of any predefined text strings provided by Facebook. For example, the descriptive text that accompanies some timeline posts (eg: Smash Balloon created an event) and the text in the \'Like Box\' widget. .', 'custom-facebook-feed' ),
				'options'			=> array_merge( [
					'' => __( 'Default', 'custom-facebook-feed' ),
				], CFF_Settings_Tab::locales() )
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'eventstimezoneoffset',
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'conditionHide'		=> true,
				'condition'			=> ['feedtype' => ['events']],
				'heading' 			=> __( 'Timezone Offset', 'custom-facebook-feed' ),
				'description' 			=> __( 'Due to a limitation on Facebook API, events might display time incorrectly for some users. You can fix it by enabling timezone offset.', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
		];
	}


}