<?php 
	global 
    $default_banner,
    $site_404_title,
    $site_404_image,
    $site_404_message;

    // ACF banner fields
	$banner_content = get_field('header_banner');

    $banner_img_other = '';
    $banner_img_other_style = '';
    $image_path = '/wp-content/themes/sme-csj-child/images/';
    $banner_img_category = $image_path . 'Page_Banner_News-Category.jpg';
    $banner_img_archive = $image_path . 'Page_Banner_News-Archive.jpg';
    // image for category and archive
    if(is_category()){
        $banner_img_other = $banner_img_category;
    }else if(is_archive()){
        $banner_img_other = $banner_img_archive;
    }
    
    if($banner_img_other){
        $banner_img_other_style = 'background-image: url(' . $banner_img_other . ')';
    }
    // image for all pages
    $background_image_style = '';
    if (isset($banner_content['background_image'])) {
        $background_image = $banner_content['background_image']['url'];
        $background_image_style = 'background-image: url(' . $background_image . ')';
    }

    $final_style = $background_image_style ? $background_image_style : $banner_img_style;
    $div_start = '';

    if (is_category() || is_archive()) {
        // For category and archive pages, display fixed image only
        $div_start = '<div class="banner banner-minimal banner-image" style="' . $banner_img_other_style . '">';
    }else if (isset($banner_content['text_colour']) && isset($banner_content['overlay_for_image'])) {
        // For other pages, use overlay and text color settings
        $image_overlay = $banner_content['overlay_for_image'];
        $text_color = $banner_content['text_colour'];
        
        // Combine the dynamic classes only if they are set
        $extra_classes = trim($image_overlay . ' ' . $text_color);
        
        // Corrected <div> tag with style attribute
        $div_start = '<div class="banner banner-minimal banner-image ' . $extra_classes . '" style="' . $final_style . '">';
    }
    echo $div_start;
?>

  <div class="container-lg">
    <div class="vc_row wpb_row vc_row-fluid vc_row-flex">
      <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner">
        <h1 class="banner-title">
          <?php 
            if (is_404() && isset($site_404_title) && $site_404_title) {
                echo $site_404_title;
            } else if (isset($banner_content['title']) && $banner_content['title']) {
                echo $banner_content['title'];
            } else if (is_day()) {
                printf( __( 'Daily Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date() );
            } else if (is_month()) {
                printf( __( 'Monthly Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date( __( 'F Y', 'monthly archive date format', "SITE_TEXT_DOMAIN" ) ) );
            } else if (is_year()) {
                printf( __( 'Yearly Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date( __( 'Y', 'yearly archive date format', "SITE_TEXT_DOMAIN" ) ) );
            } else if (is_category() || is_tax()) {
                echo single_cat_title( '', false );
            } else if (is_tag()) {
                echo __( 'Tag: ', "SITE_TEXT_DOMAIN" ), single_tag_title( ' ', false );
            } else if (is_archive()) {
                echo __( 'Archive', "SITE_TEXT_DOMAIN" );
            } else if (is_search()) {
                printf( __( 'Search Results', "SITE_TEXT_DOMAIN" ), get_search_query(), $wp_query->found_posts );
            } else {
                single_post_title();
            }
          ?>
        </h1>
		<p class="banner-headline">
			<?php if (isset($banner_content['banner_headline']) && $banner_content['banner_headline']) {
                echo $banner_content['banner_headline'];
            } ?>
		</p>
        </div>
      </div>
    </div>
  </div>
</div>