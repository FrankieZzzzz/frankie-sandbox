<?php 
  $banner_content = get_field('header_banner_home'); 
  
  if (isset($banner_content['background_image'])) {
    $background_image = $banner_content['background_image']['url'];
  }
?>
<style>
  .banner-image {
    background-image: url(<?php echo $background_image; ?>);
  }
</style>

<!-- <div class="banner banner-home banner-image"> -->
<?php
if ( isset($banner_content['text_colour']) && isset($banner_content['overlay_for_image']) ) {
    $image_overlay = $banner_content['overlay_for_image'];
    $text_color = $banner_content['text_colour'];
    echo '<div class="banner banner-home banner-image '.$image_overlay.' '.$text_color.'">';
}
?>
  <div class="container-lg">
    <div class="vc_row wpb_row vc_row-fluid vc_row-flex">
      <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner">
			<h1 class="banner-title">
				<?php // title
					if (isset($banner_content['title']) && $banner_content['title']) {
						echo $banner_content['title'];
					} else {
						the_title();
					}
				?>
			</h1>
			<?php // headline
				if (isset($banner_content['banner_headline']) && $banner_content['banner_headline']) {
					echo '<p class="banner-headline">'.$banner_content['banner_headline'].'</p>';
				} 
			?>
			<?php // buttons
        if(isset( $banner_content['btns']) && is_array( $banner_content['btns'])){
            $btns = $banner_content['btns'];
            if ( !empty($btns) ) {
                echo '<div class="btn-group">';
                foreach( $btns as $btn ) {
                    if ( isset($btn['btn']) && is_array($btn['btn']) && isset($btn['btn']['url'], $btn['btn']['title']) ) {
                        $btn_array = $btn['btn'];
                        $btn_style = isset($btn['style']) ? $btn['style'] : 'default'; 
                        $rel = isset($btn['target']) && $btn['target'] !== '_blank' ? 'internal' : 'external author';
                        echo '<a href="'.esc_url($btn_array['url']).'" class="vc_btn3 vc_btn3-color-'.$btn_style.'" target="'.esc_attr($btn_array['target']).'" rel="'.esc_attr($rel).'">'.esc_html($btn_array['title']).'</a>';
                    }
                }
                echo '</div>';
            }
        }
			?>
        </div>
      </div>
    </div>
  </div>
</div>