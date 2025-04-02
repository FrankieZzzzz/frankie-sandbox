jQuery(document).ready(function ($) {
  function openMMenu(e) {
    e.preventDefault();
    menuApi.open();
  }

  function openPanel(e) {
    e.preventDefault();
    const href = e.target.getAttribute("href");
    const panel = document.querySelector(href);
    menuApi.openPanel(panel);
  }
  
  function handleHref(e) {
    e.preventDefault();
    const href = e.target.getAttribute("href");
    window.location = href;
  }

  const menuOptions = {
    navbars: [
      {
        position: "top",
        content: ["close"],
      },
    ],
  };
  const menu = new Mmenu("#mobile-menu", menuOptions);
  const menuApi = menu.API;

  $("#mobile-nav-btn").on("click touchstart", openMMenu);
  $(".mm-btn_next").on("click touchstart", openPanel);
  $(".skip-to-content").on("click", handleHref);

  const searchBtn = $("#search-btn");
  const searchBtnSubmit = $("#search-submit-btn");
  const searchForm = $(".header__global-searchform");
  const searchInput = $(".header__global-nav input");

  searchBtn.on("click", () => {
    searchBtn.addClass("search-hidden");
    searchBtnSubmit.addClass("search-visible");
    searchForm.addClass("search-visible");
    searchInput.focus();
  });

  searchBtnSubmit.on("mousedown touchstart", (e) => {
    e.preventDefault();
    window.location.replace(window.location.origin + "/?s=" + searchInput.val());
  });

  searchInput.on("focusout", () => {
    searchBtn.removeClass("search-hidden");
    searchBtnSubmit.removeClass("search-visible");
    searchForm.removeClass("search-visible");
  });

  // Need to add role attr Max Mega Menu for accessibility purposes
  $(".mega-indicator").attr("role", "presentation");

  // Modify Gravity Forms recaptcha label for accessibility purposes
  $(".ginput_recaptcha").siblings("label").attr("for", "g-recaptcha-response");

  
  // Add Bootstrap data toggle html attributes
  const modal = $('a[href*=#modal]');

  if (modal) {
    modal.each(function() {
      $(this).attr('data-bs-toggle', 'modal');
      $(this).attr('data-target', $(this)[0]['hash']);
    });
  }

  // Setup year in footer
  $('#super-footer__year').append(new Date().getFullYear());

	if ($.cookie('csj-privacy') == null) {
		// If no cookie, show popup
		$('#privacy-popup').show();
	}
	$('button#privacy-btn').on('click', function (e) {
		e.preventDefault();
		// set cookie expiration
		$.cookie('csj-privacy', 'yes', { expires: 30, path: '/' });
		$('#privacy-popup').hide();
	});

});
