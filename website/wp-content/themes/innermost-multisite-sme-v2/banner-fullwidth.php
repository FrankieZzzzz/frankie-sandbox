<?php 
    global 
    $default_banner,
    $site_404_title,
    $site_404_image,
    $site_404_message;

    $banner_img = '';
    $banner_img_style = '';

    if (!is_search() && !is_home() && !is_archive() && !is_404() && get_the_post_thumbnail_url(null, 'full')) {
       $banner_img = get_the_post_thumbnail_url(null, 'full');
    } elseif (is_home() || is_archive()) {
        if (get_the_post_thumbnail_url(get_page_by_path('blog'), 'full')) {
            $banner_img = get_the_post_thumbnail_url(get_page_by_path('blog'), 'full');
        } else {
            $banner_img = $default_banner;
        }
    } elseif (is_404() && isset($site_404_image) && $site_404_image) {
       $banner_img = $site_404_image;
    } elseif (isset($default_banner) && $default_banner) {
       $banner_img = $default_banner;
    }

    if ($banner_img) {
        $banner_img_style = ' style="background-image: url(' . $banner_img . ')"';
    }

?>
<header class="banner" <?php echo $banner_img_style; ?>>
    <div class="container-fluid">
        <h1 class="banner__title">
            <?php 
                if (is_404() && isset($site_404_title) && $site_404_title) {
                    echo $site_404_title;
                } else if (is_day()) {
                    printf( __( 'Daily Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date() );
                } else if (is_month()) {
                    printf( __( 'Monthly Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date( __( 'F Y', 'monthly archive date format', "SITE_TEXT_DOMAIN" ) ) );
                } else if (is_year()) {
                    printf( __( 'Yearly Archive: %s', "SITE_TEXT_DOMAIN" ), get_the_date( __( 'Y', 'yearly archive date format', "SITE_TEXT_DOMAIN" ) ) );
                } else if (is_category() || is_tax()) {
                    echo __( 'Category: ', "SITE_TEXT_DOMAIN" ), single_cat_title( ' ', false );
                } else if (is_tag()) {
                    echo __( 'Tag: ', "SITE_TEXT_DOMAIN" ), single_tag_title( ' ', false );
                } else if (is_archive()) {
                    echo __( 'Archive', "SITE_TEXT_DOMAIN" );
                } else if (is_search()) {
                    echo __( 'Search', "SITE_TEXT_DOMAIN" );
                } else {
                    single_post_title();
                }
            ?>
        </h1>
    </div>
</header>
