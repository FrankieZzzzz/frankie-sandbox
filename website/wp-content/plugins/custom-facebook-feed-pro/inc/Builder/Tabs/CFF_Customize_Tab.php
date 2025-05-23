<?php
/**
 * Customizer Tab
 *
 *
 * @since 4.0
 */
namespace CustomFacebookFeed\Builder\Tabs;
use CustomFacebookFeed\Builder\CFF_Feed_Builder;
use CustomFacebookFeed\CFF_License_Tier;
if(!defined('ABSPATH'))	exit;


class CFF_Customize_Tab
{

	public static $should_disable_pro_features = false;
	public static $license_tier_features = false;

	/**
	 * Get Customize Tab Sections
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
			'settings_feedtemplate' => [
				'heading' 	=> __( 'Template', 'custom-facebook-feed' ),
				'icon' 		=> 'layout',
				'controls'	=> self::get_settings_feedtemplates_controls()
			],
			'settings_feedtheme' => [
				'heading' 	=> __( 'Theme', 'custom-facebook-feed' ),
				'icon' 		=> 'color_scheme',
				'controls'	=> self::get_settings_feedtheme_controls()
			],
			'settings_feedtype' => [
				'heading' 	=> __( 'Feed Type', 'custom-facebook-feed' ),
				'icon' 		=> 'article',
				'controls'	=> self::get_settings_feedtype_controls()
			],
			'customize_feedlayout' => [
				'heading' 	=> __( 'Feed Layout', 'custom-facebook-feed' ),
				'icon' 		=> 'feed_layout',
				'controls'	=> self::get_customize_feedlayout_controls()
			],
			'customize_colorscheme' => [
				'heading' 	=> __( 'Color Scheme', 'custom-facebook-feed' ),
				'icon' 		=> 'color_scheme',
				'controls'	=> self::get_customize_colorscheme_controls()
			],
			'customize_sections' => [
				'heading' 	=> __( 'Sections', 'custom-facebook-feed' ),
				'isHeader' 	=> true,
			],
			'customize_header' => [
				'heading' 	=> __( 'Header', 'custom-facebook-feed' ),
				'icon' 		=> 'header',
				'separator'	=> 'none',
				'controls'	=> self::get_customize_header_controls()
			],
			'customize_posts' => [
				'heading' 			=> __( 'Posts', 'custom-facebook-feed' ),
				'icon' 				=> 'article',
				'controls'			=> self::get_customize_posts_controls(),
				'condition'			=> ['feedtype' => ['timeline','reviews','events','videos','albums']],
				'separator'			=> 'none',
				'nested_sections' 	=> [
					'post_style' => [
						'heading' 			=> __( 'Post Style', 'custom-facebook-feed' ),
						'icon' 				=> 'color_scheme',
						'isNested'			=> 'true',
						'condition'			=> ['feedtype' => ['timeline','reviews','events','videos','albums']],
						'controls'			=> self::get_nested_post_style_controls(),
					],
					'individual_elements' => [
						'condition'			=> ['feedtype' => ['timeline','reviews','events']],
						'heading' 			=> __( 'Edit Individual Elements', 'custom-facebook-feed' ),
						'description' 		=> __( 'Hide or Show individual elements of a post or edit their options', 'custom-facebook-feed' ),
						'icon' 				=> 'text',
						'separator'			=> 'none',
						'isNested'			=> 'true',
						'controls'			=> self::get_nested_individual_elements_controls(),
					]

				]
			],
			'customize_likebox' => [
				'heading' 	=> __( 'Like Box', 'custom-facebook-feed' ),
				'icon' 		=> 'like_box',
				'separator'	=> 'none',
				'controls'	=> self::get_customize_likebox_controls()
			],
			'customize_loadmorebutton' => [
				'heading' 	=> __( 'Load More Button', 'custom-facebook-feed' ),
				'icon' 		=> 'load_more',
				'separator'	=> 'none',
				'proLabel'		=> !self::$should_disable_pro_features ? null : true,
				'controls'	=> self::get_customize_loadmorebutton_controls()
			],
			'customize_lightbox' => [
				'heading' 	=> __( 'Lightbox', 'custom-facebook-feed' ),
				'icon' 		=> 'lightbox',
				'separator'	=> 'none',
				'proLabel'		=> !self::$should_disable_pro_features ? null : true,
				'controls'	=> self::get_customize_lightbox_controls()
			]
		];
	}


	/**
	 * Get Settings Tab Feed Type Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_feedtype_controls(){
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'feedtype'
			]
		];
	}

	/**
	 * Get Settings Tab Feed Type Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_feedtemplates_controls() {
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'feedtemplate'
			]
		];
	}

	/**
	 * Get Settings Tab Feed Theme Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_settings_feedtheme_controls() {
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'feedtheme'
			]
		];
	}

	/**
	 * Get Customize Tab Feed Layout Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_feedlayout_controls(){
		$svg_rocket_icon = CFF_Feed_Builder::builder_svg_icons('rocketPremiumBlue');
		$is_carousel_active = \CustomFacebookFeed\CFF_FB_Settings::check_active_extension( 'carousel' );
		return [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'feedlayout',
				'heading' 	=> __( 'Layout', 'custom-facebook-feed' ),
				'separator'	=> 'bottom',
				'options'	=> [
					[
						'value' => 'list',
						'icon' => 'list',
						'label' => __( 'List', 'custom-facebook-feed' )
					],
					[
						'value' 		=> 'grid',
						'icon' 			=> 'grid',
						'condition'		=> ['feedtype' => ['photos','videos','albums','singlealbum']],
						'label' 		=> __( 'Grid', 'custom-facebook-feed' )
					],
					[
						'value' => 'masonry',
						'icon' => 'masonry',
						'label' => __( 'Masonry', 'custom-facebook-feed' )
					],
					[
						'value' 			=> 'carousel',
						'icon' 				=> 'carousel',
						'checkExtension'	=> 'carousel',
						'label' => cff_should_disable_pro() || !$is_carousel_active ? __( 'Carousel', 'custom-facebook-feed' ) . ' ' . $svg_rocket_icon : __( 'Carousel', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'height',
				'fieldSuffix' 		=> 'px',
				'separator'			=> 'bottom',
				'heading' 			=> __( 'Feed Height', 'custom-facebook-feed' ),
				'style'				=> ['.cff-feed-height' => 'height:{{value}}px;overflow:auto;'],
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Number of Posts', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'num',
				'icon' 				=> 'desktop',
				'layout' 			=> 'half',
				'ajaxAction'		=> 'feedFlyPreview',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Desktop', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'nummobile',
				'icon' 				=> 'mobile',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Mobile', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Columns', 'custom-facebook-feed' ),
				'condition'			=> ['feedlayout' => ['grid','masonry']],
				'conditionHide'		=> true,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'cols',
				'condition'			=> ['feedlayout' => ['grid','masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'desktop',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Desktop', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],

			[
				'type' 				=> 'select',
				'id' 				=> 'colstablet',
				'condition'			=> ['feedlayout' => ['grid','masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'tablet',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Tablet', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'colsmobile',
				'condition'			=> ['feedlayout' => ['grid','masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'mobile',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Mobile', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3'
				]
			],

			//Carousel Settings
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselheight',
				'condition'			=> ['feedlayout' => ['carousel']],
				'strongHeading'		=> 'false',
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'heading' 			=> __( 'Height of Carousel', 'custom-facebook-feed' ),
				'options'			=> [
					'tallest' => __( 'Always set to tallest post', 'custom-facebook-feed' ),
					'clickexpand' => __( 'Set to shortest post, button to expand', 'custom-facebook-feed' ),
					'autoexpand' => __( 'Automatically adjust height (forces 1 column)', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'carouseldesktop_cols',
				'condition'			=> ['feedlayout' => ['carousel']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'heading' 		=> __( 'Desktop Columns', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'carouselmobile_cols',
				'condition'			=> ['feedlayout' => ['carousel']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'heading' 		=> __( 'Mobile Columns', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselnavigation',
				'condition'			=> ['feedlayout' => ['carousel']],
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Navigation Arrows Style', 'custom-facebook-feed' ),
				'conditionHide'		=> true,
				'options'			=> [
					'none' => __( 'Hide arrows', 'custom-facebook-feed' ),
					'onhover' => __( 'Display on sides of feed on hover', 'custom-facebook-feed' ),
					'below' => __( 'Below feed, on sides of pagination', 'custom-facebook-feed' ),
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'carouselpagination',
				'heading' 			=> __( 'Show Pagination', 'custom-facebook-feed' ),
				'condition'			=> ['feedlayout' => ['carousel']],
				'stacked'			=> 'true',
				'conditionHide'		=> true,
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'carouselautoplay',
				'heading' 			=> __( 'Enable Autoplay', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'condition'			=> ['feedlayout' => ['carousel']],
				'conditionHide'		=> true,
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'carouselinterval',
				'condition'			=> ['feedlayout' => ['carousel']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'step'				=> 200,
				'prefix' 			=> __( 'Miliseconds', 'custom-facebook-feed' ),
				'heading' 		=> __( 'Interval Time', 'custom-facebook-feed' ),
			],

		];
	}

	/**
	 * Get Customize Tab Color Scheme Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_colorscheme_controls(){
		$color_scheme_array =
		[
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'colorpalette',
				'separator'	=> 'bottom',
				'options'	=> [
					[
						'value' => 'inherit',
						'label' => __( 'Inherit from Theme', 'custom-facebook-feed' )
					],
					[
						'value' => 'light',
						'icon' => 'sun',
						'label' => __( 'Light', 'custom-facebook-feed' )
					],
					[
						'value' => 'dark',
						'icon' => 'moon',
						'label' => __( 'Dark', 'custom-facebook-feed' )
					],
					[
						'value' => 'custom',
						'icon' => 'cog',
						'label' => __( 'Custom', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Custom Palette', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'custombgcolor1',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'The background color of the posts', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-ctn' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'custombgcolor2',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background 2', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'The secondary background color which is used for other elements in the feed', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-link-ctn[data-linkbox="off"],.cff-post-item-meta,.cff-post-item-comments-top,.cff-post-item-comments-list,.cff-preview-loadmore-btn' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'textcolor1',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Text', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'The primary text color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-content,.cff-post-comment-item,.cff-singlemedia-item-info p' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'textcolor2',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Text 2', 'custom-facebook-feed' ),
				'tooltip' 			=> __( 'The secondary text color used for ancillary elements in the feed', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-link-small,.cff-post-item-link-description,.cff-post-item-date' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customlinkcolor',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Link', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-author-name,.cff-post-item-text a,.cff-post-item-text-expand,.cff-post-item-action-txt,.cff-post-meta-txt,.cff-post-meta-link,.cff-preview-loadmore-btn,.cff-singlemedia-item-info h4 a,.cff-post-event-title a,.cff-post-item-link-a' => 'color:{{value}};'],
				'stacked'			=> 'true'
			]
		];

		$color_overrides = CFF_Feed_Builder::get_color_overrides();
		$color_overrides_array = $color_overrides_elements = [];
		foreach ($color_overrides as $cl_override) {
			array_push($color_overrides_array,
				[
					'type' 						=> 'heading',
					'overrideColorCondition' 	=> $cl_override['elements'],
					'heading' 					=> $cl_override['heading'] . '<svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.66656 0L0.726562 0.94L3.7799 4L0.726562 7.06L1.66656 8L5.66656 4L1.66656 0Z" fill="#141B38"/></svg>',
					'enableViewAction' 			=> isset($cl_override['enableViewAction']) ? $cl_override['enableViewAction'] : false
				]
			);

			foreach ($cl_override['controls'] as $cl_override_control) {
				array_push($color_overrides_elements, $cl_override_control['id']);
				array_push($color_overrides_array,
					[
						'type' 						=> 'coloroverride',
						'id' 						=> $cl_override_control['id'],
						'overrideColorCondition' 	=> [$cl_override_control['id']],
						'layout' 					=> 'half',
						'strongHeading'				=> 'false',
						'heading' 					=> $cl_override_control['heading'],
						'pickerType'				=> 'reset',
						'stacked'					=> 'true'
					]
				);
			}
		}
		array_push($color_scheme_array,
			[
				'type' 						=> 'separator',
				'overrideColorCondition' 	=> $color_overrides_elements,
				'conditionHide'				=> true,
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 						=> 'heading',
				'overrideColorCondition' 	=> $color_overrides_elements,
				'heading' 					=> __( 'Overrides', 'custom-facebook-feed' ),
				'description'				=> __( 'These colors have been set from the individual element properties and are overriding the global color scheme', 'custom-facebook-feed' ),
			]
		);
		return  array_merge($color_scheme_array,$color_overrides_array);

	}

	/**
	 * Get Customize Tab Header Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_header_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showheader',
				'label' 			=> __( 'Enable', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'headertype',
				'condition'	=> ['showheader' => ['on']],
				'heading' 	=> __( 'Header Type', 'custom-facebook-feed' ),
				'options'	=> [
					[
						'value' => 'visual',
						'icon' => 'visual',
						'label' => __( 'Visual', 'custom-facebook-feed' )
					],
					[
						'value' => 'text',
						'icon' => 'text',
						'label' => __( 'Text', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			//Visual Header Start
			[
				'type' 				=> 'heading',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Title Text', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'headertextsize',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['h3.cff-preview-header-name' => 'font-size:{{value}}px!important;'],
				'options'			=> CFF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'headertextcolor',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-header-name' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Bio Text', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'headerbiosize',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.cff-preview-header-bio' => 'font-size:{{value}}px!important;'],
				'options'			=> CFF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'headerbiocolor',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-header-bio' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'headercover',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Cover Photo', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'headercoverheight',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual'],'headercover'=> ['on']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'fieldSuffix' 		=> 'px',
				'style'				=> ['.cff-preview-header-cover' => 'height:{{value}}px!important;'],
				'child'				=> 'true',
				'description' 		=> __( 'Height', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'top' 				=> 15,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'headername',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Name and Avatar', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'headerbio',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'label' 			=> __( 'About (Bio and Likes)', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'headeroutside',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['visual']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['visual']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Display outside scrollable area', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			//Visual Header End
			//Text Header Start
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'top' 				=> 10,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'headericonenabled',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'label' 			=> __( 'Icon', 'custom-facebook-feed' ),
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'headericon',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text'],'headericonenabled'=>['on']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Icon Image', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'child'				=> 'true',
				'options'			=> CFF_Builder_Customizer_Tab::get_header_icons_options()
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'headericonsize',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text'],'headericonenabled'=>['on']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'full',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Icon Size', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'child'				=> 'true',
				'style'				=> ['.cff-header-text-icon' => 'font-size:{{value}}px!important;'],
				'options'			=> CFF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'headericoncolor',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text'],'headericonenabled'=>['on']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'child'				=> 'true',
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-header-text-icon' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'top' 				=> 15,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'textarea',
				'id' 				=> 'headertext',
				'heading' 			=> __( 'Text', 'custom-facebook-feed' ),
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'headertextsize',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'full',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.cff-header-text' => 'font-size:{{value}}px!important;'],
				'options'			=> CFF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'headertextcolor',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'full',
				'strongHeading'		=> 'false',
				'style'				=> ['.cff-header-text' => 'color:{{value}};'],
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'stacked'			=> 'true'
			],

			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'top' 				=> 15,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Background', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'headerbg',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-header-text-h' => 'background:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'headerpadding',
				'condition'			=> ['showheader' => ['on'],'headertype'=> ['text']],
				'conditionDimmed'	=> ['showheader' => ['off'],'headertype'=> ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'fieldSuffix'		=> 'px',
				'style'				=> ['.cff-preview-header-text-h' => 'padding:{{value}}px!important;'],
				'heading' 			=> __( 'Padding / Spacing', 'custom-facebook-feed' ),
			],

		];
	}

	/**
	 * Get Customize Tab Posts Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_posts_controls(){
		return [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'layout',
				'heading' 	=> __( 'Layout', 'custom-facebook-feed' ),
				'conditionHide'		=> true,
				'proLabel'		=> true,
				'condition'			=> ['feedtype' => ['timeline','reviews','events'], 'feedlayout' => ['list','carousel']],
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'postSettings',
				'checkExtensionPopup' 	=> !self::$should_disable_pro_features ? null : 'postSettings',
				'disabledInput' => !self::$should_disable_pro_features ? null :  'postSettings',
				'description' 	=> __( 'Get more layout options by upgrading to pro.', 'custom-facebook-feed' ),
				'options'	=> [
					[
						'value' => 'thumb',
						'icon' => 'thumbnail',
						'label' => __( 'Thumbnail', 'custom-facebook-feed' )
					],
					[
						'value' => 'half',
						'icon' => 'halfwidth',
						'label' => __( 'Half width', 'custom-facebook-feed' )
					],
					[
						'value' => 'full',
						'icon' => 'fullwidth',
						'label' => __( 'Full width', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'conditionHide'		=> true,
				'condition'			=> ['feedtype' => ['timeline','reviews','events'], 'feedlayout' => ['masonry']],
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'enablenarrow',
				'label' 			=> __( 'Use Full Width layout when post width is less than 500px', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'conditionHide'		=> true,
				'condition'			=> ['feedtype' => ['timeline','reviews','events']],
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'postSettings',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null :  'postSettings',
				'disabledInput' => !self::$should_disable_pro_features ? null :  'postSettings',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'conditionHide'		=> true,
				'condition'			=> ['feedtype' => ['timeline','reviews','events']],
				'bottom' 			=> -1,
			],

		];
	}

	/**
	 * Get Customize Tab Likebox Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_likebox_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showlikebox',
				'label' 			=> __( 'Enable', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'likeboxsmallheader',
				'condition'	=> ['showlikebox' => ['on']],
				'heading' 	=> __( 'Size', 'custom-facebook-feed' ),
				'separator'	=> 'on',
				'options'	=> [
					[
						'value' => 'on',
						'label' => __( 'Small', 'custom-facebook-feed' )
					],
					[
						'value' => 'off',
						'label' => __( 'Large', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'likeboxpos',
				'condition'			=> ['showlikebox' => ['on']],
				'heading' 			=> __( 'Position', 'custom-facebook-feed' ),
				'options'			=> [
					'top' => __( 'Top', 'custom-facebook-feed' ),
					'bottom' => __( 'Bottom', 'custom-facebook-feed' )
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],

			[
				'type' 				=> 'switcher',
				'id' 				=> 'likeboxcover',
				'condition'			=> ['showlikebox' => ['on']],
				'labelStrong'		=> 'true',
				'heading' 			=> __( 'Cover Photo', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'likeboxcustomwidth',
				'condition'			=> ['showlikebox' => ['on']],
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Custom Width', 'custom-facebook-feed' ),
				'description' 		=> __( 'By default this is set to auto', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'likeboxwidth',
				'condition'			=> ['showlikebox' => ['on'],'likeboxcustomwidth' => ['on']],
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'child'				=> 'true',
				'fieldSuffix'		=> 'px',
				'heading' 			=> __( 'Width', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'likeboxhidebtn',
				'condition'			=> ['showlikebox' => ['on']],
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Custom CTA', 'custom-facebook-feed' ),
				'description' 		=> __( 'This toggles the custom CTA like "Shop now" and "Contact"', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'likeboxfaces',
				'condition'			=> ['showlikebox' => ['on']],
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Show Fans', 'custom-facebook-feed' ),
				'description' 		=> __( 'Shows visitors which of their friends follow this Facebook page', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showlikebox' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'likeboxoutside',
				'condition'			=> ['showlikebox' => ['on']],
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Display outside scrollable area', 'custom-facebook-feed' ),
				'description' 		=> __( 'Make the Like Box fixed by moving it outside the scrollable area', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],

		];
	}

	/**
	 * Get Customize Tab Load More Button Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_loadmorebutton_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'loadmore',
				'label' 			=> __( 'Enable', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'loadMore',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'loadMore',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['loadmore' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'buttontext',
				'heading' 			=> __( 'Text', 'custom-facebook-feed' ),
				'condition'			=> ['loadmore' => ['on']],
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'loadMore',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'loadMore',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['loadmore' => ['on']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['loadmore' => ['on']],
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttoncolor',
				'condition'			=> ['loadmore' => ['on']],
				'layout' 			=> 'half',
				'icon' 				=> 'background',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'loadMore',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'loadMore',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Background', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-loadmore-btn' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttonhovercolor',
				'condition'			=> ['loadmore' => ['on']],
				'layout' 			=> 'half',
				'icon' 				=> 'cursor',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'loadMore',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'loadMore',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Hover State', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-loadmore-btn:hover' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttontextcolor',
				'condition'			=> ['loadmore' => ['on']],
				'layout' 			=> 'half',
				'icon' 				=> 'text',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'loadMore',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'loadMore',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Text', 'custom-facebook-feed' ),
				'style'				=> ['.cff-preview-loadmore-btn' => 'color:{{value}};'],
				'stacked'			=> 'true'
			],
		];
	}

	/**
	 * Get Customize Tab Lightbox Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_customize_lightbox_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'disablelightbox',
				'label' 			=> __( 'Enable', 'custom-facebook-feed' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'lightbox',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'lightbox',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'options'			=> [
					'enabled'	=> 'off',
					'disabled'	=> 'on'
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['disablelightbox' => ['off']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['disablelightbox' => ['off']],
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'lightboxbgcolor',
				'condition'			=> ['disablelightbox' => ['off']],
				'layout' 			=> 'half',
				'icon' 				=> 'background',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'lightbox',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'lightbox',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Background', 'custom-facebook-feed' ),
				'style'				=> ['.cff-lightbox-sidebar' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'

			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'lightboxtextcolor',
				'condition'			=> ['disablelightbox' => ['off']],
				'layout' 			=> 'half',
				'icon' 				=> 'text',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'lightbox',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'lightbox',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Text', 'custom-facebook-feed' ),
				'style'				=> ['.cff-lightbox-sidebar .cff-post-item-date,.cff-lightbox-cls,.cff-lightbox-sidebar .cff-post-item-text' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'

			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'lightboxlinkcolor',
				'condition'			=> ['disablelightbox' => ['off']],
				'layout' 			=> 'half',
				'icon' 				=> 'link',
				'strongHeading'		=> 'false',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'lightbox',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'lightbox',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Link', 'custom-facebook-feed' ),
				'style'				=> ['.cff-lightbox-sidebar .cff-post-item-author-name,.cff-lightbox-sidebar .cff-post-meta-link,.cff-lightbox-sidebar .cff-post-comment-item-author.cff-post-meta-link,.cff-lightbox-sidebar .cff-post-item-text a' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['disablelightbox' => ['off']],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'lightboxcomments',
				'condition'			=> ['disablelightbox' => ['off']],
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'lightbox',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'lightbox',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Show Comments', 'custom-facebook-feed' ),
				'description' 		=> __( 'For Timeline posts only', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				]
			],
		];
	}




	/*
		** NESTED SECTIONS
	*/
	/**
	 * Get Customize Tab Post Style Nested Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_nested_post_style_controls(){
		return [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'poststyle',
				'heading' 	=> __( 'Post Type', 'custom-facebook-feed' ),
				'condition' => ['feedtype' => ['timeline','reviews','events']],
				'conditionHide' => true,
				'options'	=> [
					[
						'value' => 'boxed',
						'icon' => 'boxed',
						'label' => __( 'Boxed', 'custom-facebook-feed' )
					],
					[
						'value' => 'regular',
						'icon' => 'thumbnail',
						'label' => __( 'Regular', 'custom-facebook-feed' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
				'condition' => ['feedtype' => ['timeline','reviews','events']],
				'conditionHide' => true,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['poststyle' => ['boxed'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Individual Properties', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'postbgcolor',
				'condition'			=> ['poststyle' => ['boxed'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'icon' 				=> 'background',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-ctn' => 'background:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'postcorners',
				'condition'			=> ['poststyle' => ['boxed'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'fieldSuffix' 		=> 'px',
				'layout' 			=> 'half',
				'icon' 				=> 'corner',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Border Radius', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-ctn' => 'border-radius:{{value}}px;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'condition'			=> ['poststyle' => ['boxed'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'bottom' 			=> 5,
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'boxshadow',
				'condition'			=> ['poststyle' => ['boxed'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Box Shadow', 'custom-facebook-feed' ),
				'options'			=> [
					'enabled'	=> 'on',
					'disabled'	=> 'off'
				],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['poststyle' => ['regular'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide' => true,
				'conditionHide'		=> true,
				'heading' 			=> __( 'Separating Line', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'sepcolor',
				'condition'			=> ['poststyle' => ['regular'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-ctn,.cff-preview-ctn.cff-outline .cff-preview-header-ctn' => 'border-bottom-color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'sepsize',
				'condition'			=> ['poststyle' => ['regular'], 'feedtype' => ['timeline','reviews','events']],
				'conditionHide'		=> true,
				'fieldSuffix' 		=> 'px',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Thickness', 'custom-facebook-feed' ),
				'style'				=> ['.cff-post-item-ctn' => 'border-bottom-width:{{value}}px;border-bottom-style:solid;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['feedtype' => ['albums']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Albums Elements', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showalbumtitle',
				'condition'			=> ['feedtype' => ['albums']],
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Show Album Title', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showalbumnum',
				'condition'			=> ['feedtype' => ['albums']],
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Number of posts in album', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],


			[
				'type' 				=> 'heading',
				'condition'			=> ['feedtype' => ['videos']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Videos Elements', 'custom-facebook-feed' ),
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showvideoname',
				'condition'			=> ['feedtype' => ['videos']],
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Show Video Title', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showvideodesc',
				'condition'			=> ['feedtype' => ['videos']],
				'conditionHide'		=> true,
				'layout'			=> 'half',
				'reverse'			=> 'true',
				'heading' 			=> __( 'Show Video Description', 'custom-facebook-feed' ),
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'options'			=> [
					'enabled'	=> 'true',
					'disabled'	=> 'false'
				]
			],

		];
	}

	/**
	 * Get Customize Tab Individual Elements Nested Section
	 * @since 4.0
	 * @return array
	*/
	public static function get_nested_individual_elements_controls(){
		$controls = [
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	 => 'author',
				'header' 	 => true,
				'label' 	=> __( 'Post Author', 'custom-facebook-feed' ),
				'separator'			=> 'bottom',
				'section' 	=> [
					'id' 				=> 'post_styling_author',
					'separator'			=> 'none',
					'heading' 			=> __( 'Post Author', 'custom-facebook-feed' ),
					'description' 		=> __( 'The author name and avatar image that\'s shown at the top of each timeline post', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_author(),
				]
			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'text',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Post Text', 'custom-facebook-feed' ),
				'section' 	=> [
					'id' 				=> 'post_styling_text',
					'separator'			=> 'none',
					'heading' 			=> __( 'Post Text', 'custom-facebook-feed' ),
					'description' 		=> __( 'The main text of the Facebook post', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_text(),
				]

			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'date',
				'separator'	=> 'bottom',
				'condition'	=> ['feedtype' => ['timeline','reviews']],
				'conditionHide'		=> true,
				'label' 	=> __( 'Date', 'custom-facebook-feed' ),
				'section' 	=> [
					'id' 				=> 'post_styling_date',
					'separator'			=> 'none',
					'heading' 			=> __( 'Post Date', 'custom-facebook-feed' ),
					'description' 		=> __( 'The date of the post', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_date(),
				]
			]
		];
		if ( !self::$should_disable_pro_features ) {
			$controls[] = [
					'type' 		=> 'checkboxsection',
					'id'		=> 'include',
					'value' 	=> 'media',
					'separator'	=> 'bottom',
					'label' 	=> __( 'Photos/Videos', 'custom-facebook-feed' ),
					'section' 	=> [
						'id' 				=> 'post_styling_media',
						'separator'			=> 'none',
						'heading' 			=> __( 'Photos/Videos', 'custom-facebook-feed' ),
						'description' 		=> __( 'Any photos or videos in your posts', 'custom-facebook-feed' ),
						'controls'			=> CFF_Styling_Tab::post_styling_media(),
					]
			];
			$controls[] = [
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'social',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Likes, Shares and Comments', 'custom-facebook-feed' ),
				'section' 	=> [
					'id' 				=> 'post_styling_social',
					'separator'			=> 'none',
					'heading' 			=> __( 'Likes, Shares and Comments Box', 'custom-facebook-feed' ),
					'description' 		=> __( 'The comments box displayed at thebottom of each timeline post', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_social( self::$license_tier_features  ),
				]
			];
		}

		$controls[] = [
			'type' 		=> 'checkboxsection',
			'id'		=> 'include',
			'value' 	=> 'eventtitle',
			'separator'	=> 'bottom',
			'label' 	=> __( 'Event Title', 'custom-facebook-feed' ),
			'section' 	=> [
				'id' 				=> 'post_styling_eventtitle',
				'separator'			=> 'none',
				'heading' 			=> __( 'Event Title', 'custom-facebook-feed' ),
				'description' 		=> __( 'The title of an event', 'custom-facebook-feed' ),
				'controls'			=> CFF_Styling_Tab::post_styling_eventtitle(),
			]
		];
		if ( !self::$should_disable_pro_features ) {
			$controls[] = [
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'eventdetails',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Event Details', 'custom-facebook-feed' ),
				'section' 	=> [
					'id' 				=> 'post_styling_eventdetails',
					'separator'			=> 'none',
					'heading' 			=> __( 'Event Details', 'custom-facebook-feed' ),
					'description' 		=> __( 'The information associated with an event', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_eventdetails(),
				]
			];
		}
		$controls[] = [
			'type' 		=> 'checkboxsection',
			'id'		=> 'include',
			'value' 	=> 'date',
			'separator'	=> 'bottom',
			'condition'	=> ['feedtype' => ['events']],
			'conditionHide'		=> true,
			'label' 	=> __( 'Event Date', 'custom-facebook-feed' ),
			'section' 	=> [
				'id' 				=> 'post_styling_date',
				'separator'			=> 'none',
				'heading' 			=> __( 'Event Date', 'custom-facebook-feed' ),
				'description' 		=> __( 'The date of the event', 'custom-facebook-feed' ),
				'controls'			=> CFF_Styling_Tab::event_styling_date(),
			]
		];
		$controls[] = [
			'type' 		=> 'checkboxsection',
			'id'		=> 'include',
			'value' 	=> 'link',
			'separator'	=> 'bottom',
			'label' 	=> __( 'Post Action Links', 'custom-facebook-feed' ),
			'section' 	=> [
				'id' 				=> 'post_styling_link',
				'separator'			=> 'none',
				'heading' 			=> __( 'Post Action Links', 'custom-facebook-feed' ),
				'description' 		=> __( 'The "View on Facebook" and "Share" links at the bottom of each post', 'custom-facebook-feed' ),
				'controls'			=> CFF_Styling_Tab::post_styling_link(),
			]
		];
		$controls[] = [
			'type' 		=> 'checkboxsection',
			'id'		=> 'include',
			'value' 	=> 'sharedlinks',
			'separator'	=> 'bottom',
			'label' 	=> __( 'Shared Link Box', 'custom-facebook-feed' ),
			'section' 	=> [
				'id' 				=> 'post_styling_sharedlinks',
				'separator'			=> 'none',
				'heading' 			=> __( 'Shared Link Box', 'custom-facebook-feed' ),
				'description' 		=> __( 'The link info box that\'s created when a link is shared in a Facebook post', 'custom-facebook-feed' ),
				'controls'			=> CFF_Styling_Tab::post_styling_sharedlinks(),
			]
		];

		if ( self::$should_disable_pro_features ) {
			$controls[] = [
				'type' 					=> 'heading',
				'heading' 				=> __( 'Advanced', 'custom-facebook-feed' ),
				'proLabel'				=> true,
				'checkExtensionPopupLeranMore' 	=> 'mediaComment',
				'description' 			=> __( 'These properties are available in the PRO version.', 'custom-facebook-feed' ),
			];
			$controls[] = [
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'media',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Photos/Videos', 'custom-facebook-feed' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'mediaComment',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'mediaComment',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'section' 	=> [
					'id' 				=> 'post_styling_media',
					'separator'			=> 'none',
					'heading' 			=> __( 'Photos/Videos', 'custom-facebook-feed' ),
					'description' 		=> __( 'Any photos or videos in your posts', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_media(),
				]
			];
			$controls[] = [
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'social',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Likes, Shares and Comments', 'custom-facebook-feed' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'mediaComment',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'mediaComment',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'section' 	=> [
					'id' 				=> 'post_styling_social',
					'separator'			=> 'none',
					'heading' 			=> __( 'Likes, Shares and Comments Box', 'custom-facebook-feed' ),
					'description' 		=> __( 'The comments box displayed at thebottom of each timeline post', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_social( self::$license_tier_features ),
				]
			];
			$controls[] = [
				'type' 		=> 'checkboxsection',
				'id'		=> 'include',
				'value' 	=> 'eventdetails',
				'separator'	=> 'bottom',
				'label' 	=> __( 'Event Details', 'custom-facebook-feed' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'events',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'events',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'section' 	=> [
					'id' 				=> 'post_styling_eventdetails',
					'separator'			=> 'none',
					'heading' 			=> __( 'Event Details', 'custom-facebook-feed' ),
					'description' 		=> __( 'The information associated with an event', 'custom-facebook-feed' ),
					'controls'			=> CFF_Styling_Tab::post_styling_eventdetails(),
				]
			];
		}

		return $controls;
	}

}