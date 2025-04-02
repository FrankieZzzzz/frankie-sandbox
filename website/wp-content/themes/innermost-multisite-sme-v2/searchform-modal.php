<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
				  <div class="modal-title h4" id="searchModalLabel"><?php echo __('Search Site', "SITE_TEXT_DOMAIN") ?></div>
				  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      	</div>
	      	<div class="modal-body">
				<?php get_search_form();?>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-secondary closeBtn" data-bs-dismiss="modal"><?php echo __('Close', "SITE_TEXT_DOMAIN") ?></button>
	      	</div>
	    </div>
	 </div>
</div>