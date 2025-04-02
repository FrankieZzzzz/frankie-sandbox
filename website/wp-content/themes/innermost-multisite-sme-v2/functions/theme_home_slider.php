<?php // acf vars
	$value = get_field( "banner_slider_short_code" );
?>
<header id="banner-slider" class="container-fluid content-body__acf-slider">
	<!-- Home Banner wrapper start -->
	<div class="row">
		<div id="home-banner" class="col">
			<?php 
				// Call shortcode
				if( $value ) {	
					echo $value;
				} 
			?>
			<a href="#custom-arrow" aria-hidden="true"><div id="custom-arrow" class="arrow bounce"></div></a>
		</div>
	</div>
	<!-- Home Banner wrapper end -->
</header>