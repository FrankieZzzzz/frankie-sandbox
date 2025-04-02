<?php // acf vars
	$vidSlide = get_field('vid_intro_banner');
	if ($vidSlide['video']):
?>
<header id="banner-vid" class="container-fluid content-body__acf-vid">
	<div class="row">
		<div id="home-banner" class="col">
			<div id="desktop-vid" class="home-banner__vid-container">
				<video id="home-video" class="video-js" preload="auto" muted="" playsinline="" poster="<?php echo $vidSlide['desktop_image']; ?>" data-setup='{  "controls": false, "autoplay": true, "loop": true }'>
					<source src="<?php echo $vidSlide['video']; ?>" type='video/mp4'>
					<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
				</video>
			</div>
			<?php if ($vidSlide['mobile_video']) : ?>
				<div id="mobile-vid" class="home-banner__vid-container">
					<video id="mobile-home-video" class="video-js" preload="auto" muted="" playsinline="" poster="<?php echo $vidSlide['mobile_image']; ?>" data-setup='{  "controls": false, "autoplay": true, "loop": true }'>
						<source src="<?php echo $vidSlide['mobile_video']; ?>" type='video/mp4'>
						<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
					</video>
				</div>
			<?php endif; ?>
			<div class="home-banner__vid-content row">
				<div class="container">
					<div class="col">
						<div class="intro-content">
							<h1><?php echo $vidSlide['title']; ?></h1>
							<p><?php echo $vidSlide['tagline']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<?php 
	if ($vidSlide['mobile_image']) {
		echo 
		"<style>
			@media screen and (max-width: 767px) {
				.home-banner__vid-container {
					display: none;
				}
				.home-banner__vid-content {
					background-image: url({$vidSlide['mobile_image']});
				}
			}
		</style>";
	}
	endif; // End desktop video url check
?>