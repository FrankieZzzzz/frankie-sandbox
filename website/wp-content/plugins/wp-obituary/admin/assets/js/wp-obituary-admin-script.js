jQuery(document).ready(function($) {
	
	$('#select-layout.obituary li img').on('click', function( e ){
		var parentId = $( this ).parent().attr('id');
		$( '#'+parentId+' input[type="radio"]' ).prop('checked', true);
		$("#select-layout.obituary>li").removeClass("selected");
		$( '#'+parentId ).addClass('selected' );
	});
    
});