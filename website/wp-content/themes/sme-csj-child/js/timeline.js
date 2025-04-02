// Timeline vars
const ev_ctnr = "div.t_events_wrap";
var t_centre;

jQuery(document).ready(function ($) {
  // Button show and hide
  //   updateNavButtons();
  setTimeout(updateNavButtons, 50);
  // Timeline Init
  //t_base = $(ev_ctnr).offset();
  //select first
  let _first = $(".t_event:first");
  _first.addClass("selected");
  //t_event_base = _first.offset();
  t_centre = window.innerWidth / 2;
  //background Image
  //$('div.timeline').css('background-image', String.format('url({0})', $('.t_event:first').data('bg')));

  // Timeline event click
  $("div.t_event").on("click", function (e) {
    let _t = $(this);
    let _last = $("div.t_event.selected");

    // A.L. - Removed class check to allow in content links to work
    //if (_t.hasClass('selected')) return false;

    $(".t_event").removeClass("selected");
    _t.addClass("selected");

    //scroll
    let _container = $(ev_ctnr);
    //let _currScroll = _container.scrollLeft();
    let _lastLeft = _last.offset().left;
    let _tleft = _t.offset().left;
    let _offset = _tleft - _lastLeft;

    //calculate new center
    _offset = _tleft + _t.outerWidth() / 2 - t_centre;
    _container.animate({ scrollLeft: _container.scrollLeft() + _offset }, 200);

    //background Image
    // $('div.timeline').fadeTo(300, 0.6, function(){
    //     $('div.timeline').css('background-image', String.format('url({0})', _t.data('bg')));
    //     $('div.timeline').fadeTo(300, 1);
    // });
    updateNavButtons();
  });

  // Timeline nav btns
  $(".t_nav a").on("click", function (e) {
    let _current = $("div.t_event.selected");
    if ($(this).hasClass("t_prev")) {
      //current
      if ($("div.t_event:first").is(_current)) return;
      //get previous
      _current.prev(".t_event").click();
      return false;
    }
    if ($(this).hasClass("t_next")) {
      //current
      if ($("div.t_event:last").is(_current)) return;
      //get next
      _current.next(".t_event").click();
      return false;
    }
  });
  // addEventListener
  $(document).keydown(function (e) {
    if ($(ev_ctnr).isInViewport()) {
      let _current = $("div.t_event.selected");
      if ([37, 100].includes(e.which)) {
        if ($("div.t_event:first").is(_current)) return;
        _current.prev(".t_event").click();
        return false;
      }
      if ([39, 102].includes(e.which)) {
        // Right arrow
        if ($("div.t_event:last").is(_current)) return;
        _current.next(".t_event").click();
        return false;
      }
    }
  });

  //   update button states
  function updateNavButtons() {
    let _current = $("div.t_event.selected");
    let isFirst = $("div.t_event:first").is(_current);
    let isLast = $("div.t_event:last").is(_current);

    // t_prev hide/show
    if (isFirst) {
      $(".t_prev").fadeOut(200);
    } else {
      $(".t_prev").fadeIn(200);
    }

    // t_next hide/show
    if (isLast) {
      $(".t_next").fadeOut(200);
    } else {
      $(".t_next").fadeIn(200);
    }
  }
  $(window).on("load", updateNavButtons);

  $.fn.isInViewport = function () {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  // Timelime Arrows
  $(document).keydown(function (e) {
    if ($(ev_ctnr).isInViewport()) {
      var _arrRight = [39, 102]; //right arrow 39,102
      var _arrLeft = [37, 100]; //left arrow 37,100
      let _current = $("div.t_event.selected");

      if (_arrLeft.includes(e.which)) {
        //current
        if ($("div.t_event:first").is(_current)) return;
        //get previous
        _current.prev(".t_event").click();
        return false;
      }
      if (_arrRight.includes(e.which)) {
        //current
        if ($("div.t_event:last").is(_current)) return;
        //get next
        _current.next(".t_event").click();
        return false;
      }
    }
  });

  // Timeline Tabbing
  $(document).keyup(function (e) {
    if ($(ev_ctnr).isInViewport()) {
      if (e.which == 9) {
        //tab
        let _focus = $("div.t_event:focus");
        if (_focus.length > 0) {
          _focus.click();
        }
      }
    }
  });

  //timeline scroll
  let _tparent = document.querySelector(ev_ctnr);
  //var startX;
  let scrollLeft;
  //let isDown;

  _tparent.addEventListener("mousedown", (e) => mouseIsDown(e));
  _tparent.addEventListener("mouseup", (e) => mouseUp(e));
  //_tparent.addEventListener("mouseleave", (e) => mouseLeave(e));
  _tparent.addEventListener("touchstart", (e) => mouseIsDown(e));
  _tparent.addEventListener("touchend", (e) => mouseUp(e));
  //_tparent.addEventListener("mousemove", (e) => mouseMove(e));
  _tparent.addEventListener("wheel", (e) => wheelEvent(e));

  function mouseIsDown(e) {
    //isDown = true;
    //startX = e.pageX - _tparent.offsetLeft;
    scrollLeft = _tparent.scrollLeft;
  }
  function mouseUp(e) {
    //isDown = false;
    //no scroll happened
    if (scrollLeft == _tparent.scrollLeft) return;

    handleTimelineScroll(200);
    /* //find closest
        let _currScroll = $(ev_ctnr).scrollLeft();
        let _currMid = _currScroll + t_centre;
        var _diff = -1, _offset, _closest;
        $('div.t_event').each(function(index){
            let _t = $(this);
            let _tleft = _t.offset().left;
            let _tmid = _currScroll + _tleft + _t.outerWidth()/2;
            let _d = _currMid - _tmid;
            if(_diff < 0 || Math.abs(_d) < _diff){
                _diff = Math.abs(_d);
                _offset = _tmid-_currMid;
                _closest = _t;
            }
        });

        //snap
        let _container = $(ev_ctnr);
        _container.animate({scrollLeft: _container.scrollLeft() + _offset }, 200, function(){
        });
        if (_closest.hasClass('selected')) return false;
        setTimeout(function(){$('.t_event').removeClass('selected');_closest.addClass('selected');},200);

        //background Image
        $('div.timeline').fadeTo(300, 0.6, function(){
            $('div.timeline').css('background-image', String.format('url({0})', _closest.data('bg')));
            $('div.timeline').fadeTo(300, 1);
        }); */
  }

  var handleTimelineScroll = function (delay) {
    //find closest
    let _currScroll = $(ev_ctnr).scrollLeft();
    let _currMid = _currScroll + t_centre;
    var _diff = -1,
      _offset,
      _closest;
    $("div.t_event").each(function (index) {
      let _t = $(this);
      let _tleft = _t.offset().left;
      let _tmid = _currScroll + _tleft + _t.outerWidth() / 2;
      let _d = _currMid - _tmid;
      if (_diff < 0 || Math.abs(_d) < _diff) {
        _diff = Math.abs(_d);
        _offset = _tmid - _currMid;
        _closest = _t;
      }
    });

    //snap
    let _container = $(ev_ctnr);
    _container.animate({ scrollLeft: _container.scrollLeft() + _offset }, delay, function () {});
    if (_closest.hasClass("selected")) return false;
    setTimeout(() => {
      $(".t_event").removeClass("selected");
      _closest.addClass("selected");
    }, 200);

    //background Image
    $("div.timeline").fadeTo(300, 0.6, () => {
      $("div.timeline").css("background-image", String.format("url({0})", _closest.data("bg")));
      $("div.timeline").fadeTo(300, 1);
    });
  };

  var timelineWheelEventEnd = null;
  function wheelEvent(e) {
    clearTimeout(timelineWheelEventEnd);
    timelineWheelEventEnd = setTimeout(() => {
      handleTimelineScroll(150);
    }, 100);
  }
});
