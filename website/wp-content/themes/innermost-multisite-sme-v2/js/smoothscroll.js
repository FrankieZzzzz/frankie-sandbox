// Smooth Scrolling for anchors
// Added by: AL
jQuery(document).ready(function ($) {

	// Var init
	var stickyHeader = $('header.site-header-sticky');
	var stickyHeaderOffset = 0;
	var headerHeight = 0;

	// Click event
	$('a[href*="#"]:not([href="#"],[href="#top"],[data-bs-toggle],[data-bs-slide],.skip-link,.wc-tab-link,[data-bs-vc-tabs],[data-bs-vc-accordion],.tabs>li>a,.gallery-thumb,.mm-btn)').click(function () {

		// Update offsets
		stickyHeaderOffset = Math.abs(stickyHeader[0].offsetTop);
		headerHeight = stickyHeader[0].offsetHeight - stickyHeaderOffset;

		// Animate offset
		if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html, body').animate({ scrollTop: target.offset().top - headerHeight }, 1000);
				return false;
			}
		}

	});

});