<?php 
	global 
    $default_banner;

	// ACF banner fields
	$news_banner = get_field('news_banner', 'option');
    if(isset($news_banner['background_image'])){
        $background_image = $news_banner['background_image']['url'];
    }
?>

<style>
  .banner-image {
    background-image: url(<?php echo $background_image; ?>);
  }
</style>

<?php
if ( isset($news_banner['text_colour']) && isset($news_banner['overlay_for_image']) ) {
    $image_overlay = $news_banner['overlay_for_image'];
    $text_color = $news_banner['text_colour'];
    echo '<div class="banner banner-minimal banner-image '.$image_overlay.' '.$text_color.'">';
}
?>
  <div class="container-lg">
    <div class="vc_row wpb_row vc_row-fluid vc_row-flex">
      <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner">
			<h1 class="banner-title">
				<?php 
					if ($news_banner['title']) {
						echo $news_banner['title'];
					} else {
						echo 'News';
					}
				?>
			</h1>
            <p class="banner-headline">
                <?php if (isset($news_banner['intro_text']) && $news_banner['intro_text']) {
                echo $news_banner['intro_text'];
            } ?>
            </p>
        </div>
      </div>
    </div>
  </div>
</div>