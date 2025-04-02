<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group">
		<input type="text" class="form-control"  placeholder="<?php echo __('Search', "SITE_TEXT_DOMAIN") ?>" name="s" required aria-label="<?php _e('Search', "SITE_TEXT_DOMAIN") ?>" />
		<div class="input-group-append">
			<button class="btn btn-primary" id="searchsubmit" type="submit"><?php echo __('Search', "SITE_TEXT_DOMAIN") ?> <i class="far fa-search"></i></button>
		</div>
	</div>
</form>