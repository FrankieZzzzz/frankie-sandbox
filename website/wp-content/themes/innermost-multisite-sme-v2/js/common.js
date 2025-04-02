jQuery(document).ready(function($){

	// Add a class for styles if is the wp activation page
	if ($('.wp-activate-container')[0]) {
		$('body').addClass('activation-page');
	}

    // WCAG WP Menu attr role tweaks
    var $menuRoles = $('ul[role="menu"].dropdown-menu');
    if ($menuRoles.length) {
        $menuRoles.children('li').attr('role', 'presentation');
        $menuRoles.children('li').find('a').attr('role', 'menuitem');
    }
    var $mobileMenuRoles = $('ul#menu-mobile-menu');
    if ($mobileMenuRoles.length) {
        $mobileMenuRoles.attr('role', 'menu');
        $mobileMenuRoles.children('li').attr('role', 'presentation');
        $mobileMenuRoles.children('li').find('a').attr('role', 'menuitem');
    }

	$(window).on('load', function(){
		var window_top_scroll = $(window).scrollTop();
		var siteHeader = $('#site-header:not(.sticky)');
		var siteHeaderHeight = siteHeader.outerHeight();
		var wpBarHeight = $('#wpadminbar').outerHeight();

		//sticky Header
		function setStickyHeader(scrollpos, ele) {
			if(scrollpos > ele){
				siteHeader.addClass('sticky');
			} else {
				siteHeader.removeClass('sticky');
			}
		}

		if($('#site-header').hasClass('site-header-sticky')){
			if(wpBarHeight){
				$('#site-header').css('top', wpBarHeight);
			}
			setStickyHeader(window_top_scroll, siteHeaderHeight);

			$(window).scroll(function() {
				window_top_scroll = $(window).scrollTop();
				setStickyHeader(window_top_scroll, siteHeaderHeight);
			});

			$(window).resize(function(){
				siteHeaderHeight = siteHeader.outerHeight();
				wpBarHeight = $('#wpadminbar').outerHeight();
				$('#site-header').css('top', wpBarHeight);
				setStickyHeader(window_top_scroll, siteHeaderHeight);
			});
		}

		// Custom show / hide back to top button
		if($('#back-to-top').hasClass('btn')){
			$(window).scroll(function() {
				var window_top_scroll = $(window).scrollTop();
				if(window_top_scroll > 150){
					$('#back-to-top').addClass('visible');
				} else {
					$('#back-to-top').removeClass('visible');
				}
			});
		}

		// table scroll
		function checkTableWidth(table) {
			if (table.outerWidth() > table.parent().outerWidth()) {
				table.data('scrollWrapper').addClass('has-scroll');
			} else if(table.data('scrollWrapper')) {
				table.data('scrollWrapper').removeClass('has-scroll');
			}
		}

		// responsive tables
		function responsiveTables() {
			$('table').each(function() {
				var element = $(this).filter(':visible');
				if(element.css('display') !== 'none' || typeof element.css('display') !== 'undefined') {
					// Create the wrapper element
					var scrollWrapper = $('<div />', {
						'class': 'scrollable',
						'html': '<div />' // The inner div is needed for styling
					}).insertBefore(element);

					// Store a reference to the wrapper element
					element.data('scrollWrapper', scrollWrapper);

					// Move the scrollable element inside the wrapper element
					element.appendTo(scrollWrapper.find('div'));

					// Check if the element is wider than its parent and thus needs to be scrollable
					checkTableWidth(element);

					// When the viewport size is changed, check again if the element needs to be scrollable
					$(window).on('resize orientationchange', function() {
						checkTableWidth(element);
					});
				}
			});
		}
		responsiveTables();
		// run responsive tables after accordion is displayed
		$(document).on("afterShow.vc.accordion", responsiveTables);

	});

	// tooltip
	$('[data-bs-toggle="tooltip"]').tooltip();

	// site search modal global popup
	$('.site-nav-search').click(function(){
		$('#searchModal').modal('show');
	});
	function focus_input(current_modal) {
		if (current_modal) {
			$(current_modal).find('input').focus();
		} else {
			$('#searchModal').find('input').focus();
		}
	}
	$('#searchModal').on('shown.bs.modal', function() {
		focus_input(this);
	});

	// dropdown-toggle click event handle to enable href redirect if href attr is valid
	$('a.dropdown-toggle').click(function(e){
		e.preventDefault();
		if( e.originalEvent !== undefined ) {
			// get url
			var link_url = $(this).attr('href');
			if (typeof link_url !== 'undefined' && link_url !== false) {
				location.href = link_url;
			}
		}
	});

	var shiftPressed = false;
	// check focusout event from li link under class navbar-nav
	$('.navbar-nav li a').focusout(function(){

		// force to display submenu
		if($(this).siblings('ul').hasClass('dropdown-menu') && shiftPressed === false) {
			$(this).siblings('ul').css('display', 'block');
		}
		// hide dropdown-menu
		if($(this).parent('li').parent('ul').hasClass('dropdown-menu') && $(this).parent('li').is('li:last-child') && shiftPressed === false ) {

			if(!$(this).siblings().hasClass('dropdown-menu')) {
				$(this).parent('li').parent('ul').removeAttr('style');

				if( $(this).parent('li').parent('ul').parent('li').parent('ul').hasClass('dropdown-menu') && $(this).parent('li').parent('ul').parent('li').is('li:last-child') ){
					$(this).parent('li').parent('ul').parent('li').parent('ul').removeAttr('style');
				}
			}
		}

		if($(this).siblings('ul').hasClass('dropdown-menu') && shiftPressed === true) {
			$(this).siblings('ul').removeAttr('style');
		}
	});

	$('.navbar-nav li a').on('keyup, keydown',function(e){
		shiftPressed = e.shiftKey;
	});

	// show modal on enter keypress
	$('#nav-search[data-bs-target="#searchModal"]').on('keyup, keydown',function(e){
		var key = e.which || e.keyCode;
		if (key === 13) {
			$('#searchModal').modal('show');
		}
	});

	// get rid of extra dropdown-menu style if clicking outside of .navbar-nav
	$(document).mouseup(function(e){
		var menuItem = $('.navbar-nav');

		// if the target of the click isn't the container nor a descendant of the container
		if (!menuItem.is(e.target) && menuItem.has(e.target).length === 0){
			$('.navbar-nav').siblings('ul').removeAttr('style');
		}
	});

	// mobile menu btn toggle
	$('.header__main-mobile').on('click touchstart', function(e){
		e.preventDefault();
		const btn = $(this);
		btn.toggleClass('is-active');
		$('body').toggleClass('mm-open');
		$('#mobile-menu').toggleClass('mm-open');
	});

	// mobile submenu dropdown toggle
	$('.mobile-menu').on('click touchstart', '.ddm-toggle', function(e) {
		e.preventDefault();
		const dropdownToggle = $(this);
		dropdownToggle.toggleClass('ddm-open');
		dropdownToggle.parent().next('.dropdown-menu').toggleClass('ddm-open');
	});

	// mobile menu close button
	$('.mm-close').on('click touchstart', function(e) {
		e.preventDefault();
		const closeBtn = $(this);
		$('body').removeClass('mm-open');
		closeBtn.closest('.mm-open').removeClass('mm-open');
	});

	// home page only
	if ($('body').hasClass('home') && $('.content-body__acf-vid').length) {

		$(window).on('load', function () {

			// home video banner bg
			var windowWidth = $(window).outerWidth();
			var homeVid = videojs('home-video');
			var mHome = $('#mobile-home-video');
			// get mobile vid
			if (mHome.length) {
				var mHomeVid = videojs('mobile-home-video');
			}
			// autoplay helper
			function autoPlay(target) {
				// trigger play
				var promise = target.play();
				if (promise !== undefined) {
					promise.then(function () {
						// Autoplay started!
					}).catch(function (error) {
						// Autoplay was prevented.
						return error;
					});
				}
			}
			// trigger autoplay based on window width
			if (windowWidth >= 768) {
				homeVid.ready(autoPlay(homeVid));
			} else if (windowWidth <= 767 && mHome.length ) {
				mHomeVid.ready(autoPlay(mHomeVid));
			}

		});

	}

	// Reset iframe video upon modal window close
	$('.modal').on('hidden.bs.modal', function (e) {
		let $target = e.target;
		let $iframe = $(e.target).find('iframe');
		if ($iframe.length) {
			let $iframeSrc = $iframe[0].attributes.src.value;
			//console.log($iframeSrc);
			$($target).find("iframe").attr("src", $iframeSrc);
		}
	});

    // WCAG: remove aria label from video player
    var $vidJs = $('div.video-js');
    if ($vidJs.length) {
        $vidJs.removeAttr('aria-label');
    }

	//social share
	//facebook	
	$('div#social_share').on('click', 'a.facebook-link', function(e){
		e.preventDefault();
		FB.ui({
			display: 'popup',
			method: 'share',
			hashtag: String.format('#{0}', social_share_object.shareTag),
			quote: social_share_object.share,
			href: window.location.href,
		}, function(response){});
	});
	//twitter	
	$('div#social_share').on('click', 'a.twitter-link', function(e){
		e.preventDefault();
		let _href = String.format(social_share_object.twitterURL, window.location.href, encodeURIComponent(social_share_object.share), social_share_object.shareTag, '', '');		
		window.open(_href);
	});
	//linkedin
	$('div#social_share').on('click', 'a.linkedin-link', function(e){
		e.preventDefault();
		let _href = String.format(social_share_object.linkedinURL, window.location.href);		
		window.open(_href);
	});
	//email
	$('div#social_share a.sharetoemail-link').attr('href', String.format(social_share_object.mailto, encodeURIComponent($('title').text()), encodeURI(window.location.href)));
	
});

String.format = function () {
    var s = arguments[0];
	var n = arguments.length - 1
    for (var i = 0; i < n; i++) {
        var reg = new RegExp("\\{" + i + "\\}", "gm");
        s = s.replace(reg, arguments[i + 1]);
    }
    return s;
};