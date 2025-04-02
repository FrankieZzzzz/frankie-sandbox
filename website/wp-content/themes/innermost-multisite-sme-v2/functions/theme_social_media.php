<?php
/* Function: showSocialMediaBar - function to display social media bar in header/footer */

// Social Media Bar Shortcode
function callSocialMediaBarShortcode() {
	global 
	$site_social_media_option,
	$site_social_media_border,
	$site_social_youtube_option,
	$site_social_vimeo_option,
	$site_social_facebook_option,
	$site_social_twitter_option,
	$site_social_linkedin_option,
	$site_social_instagram_option,
	$site_social_reddit_option,
	$site_social_tiktok_option,
	$site_social_pinterest_option,
	$site_social_flickr_option,
	$site_social_tripadvisor_option,
	$site_social_ebay_option,
	$site_social_news_option;
	$social_media = "";	
	if(isset($site_social_media_option) && $site_social_media_option) {
		// Youtube
		if (isset($site_social_media_option) && $site_social_youtube_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__youtube %s" target="_blank" aria-label="%s"><i class="fab fa-youtube"></i></a>', 
				$site_social_youtube_option,
				$site_social_media_border,
				__('Youtube Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Vimeo
		if (isset($site_social_media_option) && $site_social_vimeo_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__vimeo %s" target="_blank" aria-label="%s"><i class="fab fa-vimeo"></i></a>', 
				$site_social_vimeo_option,
				$site_social_media_border,
				__('Vimeo Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Facebook
		if (isset($site_social_media_option) && $site_social_facebook_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__facebook %s" target="_blank" aria-label="%s"><i class="fab fa-facebook-f"></i></a>', 
				$site_social_facebook_option,
				$site_social_media_border,
				__('Facebook Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Twitter
		if (isset($site_social_media_option) && $site_social_twitter_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__twitter %s" target="_blank" aria-label="%s"><i class="fab fa-x-twitter"></i></a>', 
				$site_social_twitter_option,
				$site_social_media_border,
				__('Twitter Link', "SITE_TEXT_DOMAIN")
			);
		}
		// LinkedIn
		if (isset($site_social_media_option) && $site_social_linkedin_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__linkedin %s" target="_blank" aria-label="%s"><i class="fab fa-linkedin-in"></i></a>', 
				$site_social_linkedin_option,
				$site_social_media_border,
				__('LinkedIn Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Instagram
		if (isset($site_social_media_option) && $site_social_instagram_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__instagram %s" target="_blank" aria-label="%s"><i class="fab fa-instagram"></i></a>', 
				$site_social_instagram_option,
				$site_social_media_border,
				__('Instagram Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Reddit
		if (isset($site_social_media_option) && $site_social_reddit_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__reddit %s" target="_blank" aria-label="%s"><i class="fab fa-reddit"></i></a>', 
				$site_social_reddit_option,
				$site_social_media_border,
				__('Reddit Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Tik Tok
		if (isset($site_social_media_option) && $site_social_tiktok_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__tiktok %s" target="_blank" aria-label="%s"><i class="fab fa-tiktok"></i></a>', 
				$site_social_tiktok_option,
				$site_social_media_border,
				__('Tik Tok Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Pinterest
		if (isset($site_social_media_option) && $site_social_pinterest_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__pinterest %s" target="_blank" aria-label="%s"><i class="fab fa-pinterest-p"></i></a>', 
				$site_social_pinterest_option,
				$site_social_media_border,
				__('Pinterest Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Flickr
		if (isset($site_social_media_option) && $site_social_flickr_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__flickr %s" target="_blank" aria-label="%s"><i class="fab fa-flickr"></i></a>', 
				$site_social_flickr_option,
				$site_social_media_border,
				__('Flickr Link', "SITE_TEXT_DOMAIN")
			);
		}
		// TripAdvisor
		if (isset($site_social_media_option) && $site_social_tripadvisor_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__tripadvisor %s" target="_blank" aria-label="%s"><i class="fab fa-tripadvisor"></i></a>', 
				$site_social_tripadvisor_option,
				$site_social_media_border,
				__('TripAdvisor Link', "SITE_TEXT_DOMAIN")
			);
		}
		// Ebay
		if (isset($site_social_media_option) && $site_social_ebay_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__ebay %s" target="_blank" aria-label="%s"><i class="fab fa-ebay"></i></a>', 
				$site_social_ebay_option,
				$site_social_media_border,
				__('Ebay Link', "SITE_TEXT_DOMAIN")
			);
		}
		// News
		if (isset($site_social_media_option) && $site_social_news_option) {
			$social_media .= sprintf('
				<a href="%s" class="social-media__news %s" target="_blank" aria-label="%s"><i class="far fa-envelope"></i></a>', 
				$site_social_news_option,
				$site_social_media_border,
				__('News Link', "SITE_TEXT_DOMAIN")
			);
		}
	}
	return "<div class='social-media'>{$social_media}</div>";
}
add_shortcode( 'social_media_bar', 'callSocialMediaBarShortcode' );

?>