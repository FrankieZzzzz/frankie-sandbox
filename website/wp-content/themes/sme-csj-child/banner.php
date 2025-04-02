<?php 
    if (!is_archive() && !is_search()) {

        if (function_exists('get_field') && get_field('header_banner')) {
            get_template_part('banner-templates/banner-minimal');
        }

        if (function_exists('get_field') && get_field('header_banner_home')) {
            get_template_part('banner-templates/banner-home');
        }
		
		if ( function_exists('get_field') && is_home() && !is_front_page() ) {
			get_template_part('banner-templates/banner-news');
		}

    }
    if(is_archive()){
        if (function_exists('get_field')){
            get_template_part('banner-templates/banner-minimal');
        }
    }else if(is_category()){
        if (function_exists('get_field')) {
            get_template_part('banner-templates/banner-minimal');
        }
    }
    
?>
