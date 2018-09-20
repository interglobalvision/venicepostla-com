/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Site, Ajaxy, WP, Howl */

Site = {
  animationSpeed: 50,
  mobileThreshold: 601,
  init: function() {
    var _this = this;

    $(window).resize(function(){
      _this.onResize();
    });

    $(document).ready(function () {

    });

    _this.HomeAnimation.init();

    if (WP.audio !== null) {
      _this.Audio.init();
    }
  },

  beforeAjax: function() {
    this.HomeAnimation.clearAnimation();
  },

  afterAjax: function() {
    this.HomeAnimation.init();
  },

  onResize: function() {
    var _this = this;

    if ($('.animation-image').length) {
      _this.HomeAnimation.getAndSetMaxImageSize();
    }
  },

  fixWidows: function() {
    // utility class mainly for use on headines to avoid widows [single words on a new line]
    $('.js-fix-widows').each(function(){
      var string = $(this).html();
      string = string.replace(/ ([^ ]*)$/,'&nbsp;$1');
      $(this).html(string);
    });
  },

  shuffleArray: function(array) {
    for (var i = array.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var temp = array[i];

      array[i] = array[j];
      array[j] = temp;
    }
  }
};

Site.HomeAnimation = {
  active: false,
  paused: false,
  nextImage: 0,
  numberOfFirstLoadImages: 6,
  requestDelay: 250,
  animationSpeed: 250,
  minImages: 3,
  preloadedImages: 0,
  init: function() {
    var _this = this;

    _this.$animation = $('#home-animation');
    _this.images = WP.animationImages;
    _this.headerLogoTop = $('#header-item-venice');
    _this.headerNavLeft = $('#header-item-left');

    if (_this.images.length > 0) {
      // shuffle randomize array of images from enqueue
      Site.shuffleArray(_this.images);

      // trigger request of first images
      _this.requestFirstImages();

      // get & set image max height & width
      _this.getAndSetMaxImageSize();

    }
  },

  bindPauses: function() {
    var _this = this;

    $('.animation-image').off().on({
      'mouseover': function() {
        _this.paused = true;
      },
      'mouseout': function() {
        _this.paused = false;
      },
      'touchstart': function() {
        _this.paused = true;
      },
      'touchend': function() {
        _this.paused = false;
      }
    });
  },

  requestFirstImages: function() {
    var _this = this;

    // get the first x images in the array
    for (var i = 0; i < _this.numberOfFirstLoadImages; i++) {
      _this.addImage(i);
    }
  },

  loadNextImage: function() {
    var _this = this;

    // if there is an image at the nextImage index
    if (_this.images[_this.nextImage]) {
      _this.addImage(_this.nextImage);
    }
  },

  addImage: function(imageIndex) {
    var _this = this;
    var srcset = _this.generateSrcset(_this.images[imageIndex]);

    // append img tag for image
    _this.$animation.append('<img src="' + _this.images[imageIndex]['1000'] + '" srcset="' + srcset + '" id="animation-image-' + imageIndex + '" class="animation-image" />');

    // bind to load event of inserted image
    $('#animation-image-' + imageIndex).bind('load', function() {
      // on loaded set loaded class
      $(this).addClass('animation-image-loaded');

      _this.setMaxImageSize();

      _this.bindPauses();

      _this.preloadedImages++;

      // if animation isn't active trigger animation and more images and the min are loaded
      if (!_this.active && _this.preloadedImages >= _this.minImages) {

        // set max image size with cached sizes
        $('.animation-image-loaded').first().addClass('active');

        _this.bindPauses();

        _this.animate();
      }

      // set timeout to load next image after x delay
      window.setTimeout(function() {
        _this.loadNextImage();
      }, _this.requestDelay);
    });

    // set next image index to next image
    _this.nextImage++;
  },

  animate: function() {
    var _this = this;

    // set active state true
    _this.active = true;

    _this.animationInterval = setInterval(function() {
      if (!_this.paused) {
        var $active = $('.animation-image-loaded.active');
        var index = $active.index('.animation-image-loaded')
        var $next = $('.animation-image-loaded').eq(index + 1);

        // hid current image
        $active.removeClass('active');

        if ($next.length) {
          // if next show it
          $next.addClass('active');
        } else {
          // otherwise restart loop
          $('.animation-image-loaded').first().addClass('active');
        }
      }
    }, _this.animationSpeed);

  },

  clearAnimation: function() {
    var _this = this;

    _this.active = false;
    _this.paused = false;
    _this.nextImage =  0;

    if (_this.animationInterval) {
      window.clearInterval(_this.animationInterval);
    }
  },

  getAndSetMaxImageSize: function() {
    var _this = this;

    // get max height and width for images based on header elems

    // get logo padding-top and convert to integer
    var paddingTop = parseInt(_this.headerLogoTop.css('padding-top'));

    // get side padding value from left nav offset
    var paddingSide = _this.headerNavLeft.offset().left;

    // margin twice plus dimension. x2 for both items
    var logoHeight = (_this.headerLogoTop.height() + (paddingTop * 2)) * 2;
    var navWidth = (_this.headerNavLeft.width() + (paddingSide * 2)) * 2;

    _this.imageMaxHeight = $(window).height() - logoHeight;
    _this.imageMaxWidth = $(window).width() - navWidth;

    _this.setMaxImageSize();
  },

  setMaxImageSize: function() {
    var _this = this;

    // set max height and width for images
    $('.animation-image').css({
      'max-height': _this.imageMaxHeight + 'px',
      'max-width': _this.imageMaxWidth + 'px',
    });
  },

  generateSrcset: function(image) {
    var srcset = '';

    // for each key value pair generate srcset string
    for (var property in image) {
      if (image.hasOwnProperty(property)) {
        srcset += image[property] + ' ' + property + 'w, ';
      }
    }

    // trim last 2 characters which will be a comma and a space
    srcset = srcset.substr(0, srcset.length-2);

    return srcset;
  }
};

Site.Audio = {
  isLooped: false,
  isAutoplay: false,

  isPlaying: false,

  init: function() {
    var _this = this;

    if (WP.audio.audio_loop_boolean === 'on') {
      _this.isLooped = true;
    }

    if (WP.audio.audio_autoplay_boolean === 'on') {
      _this.isAutoplay = true;
    }

    _this.createPlayer();
  },

  createPlayer: function() {
    var _this = this;

    _this.player = new Howl({
      src: [WP.audio.audio_file],
      autoplay: _this.isAutoplay,
      loop: _this.isLooped,
      volume: 0.9,
      onload: function() {
        _this.isInitialized = true;
      },
      onplay: function() {
        _this.isPlaying = true;
      },
      onpause: function() {
        _this.isPlaying = false;
      }
    });
  }
};

Site.init();

Ajaxy = {
  ajaxyLinks: 'a',

  init: function() {
    var _this = this;

    _this.bind();

    // For back button
    window.onpopstate = function() {
      _this.ajaxLoad(document.location.origin + document.location.pathname);
    };
  },

  bind: function() {
    var _this = this;

    // Find all ajaxy links and bind ajax event
    $(_this.ajaxyLinks).click(function(event) {
      event.preventDefault();

      var url = event.currentTarget.href;

      $('#main-content').addClass('main-content-hidden');
      $('html, body').animate({scrollTop: 0,}, Site.animationSpeed);

      _this.ajaxLoad(url);
    });

  },

  ajaxLoad: function(url) {
    var _this = this;

    $.ajax(url, {
      beforeSend: function() {
        _this.ajaxBefore();
      },

      dataType: 'html',
      error: function(jqXHR, textStatus) {
        _this.ajaxErrorHandler(jqXHR, textStatus);
      },

      success: function(data) {
        _this.ajaxSuccess(data, url);
        $('#main-content').removeClass('main-content-hidden');
      },
    });
  },

  ajaxErrorHandler: function(jqXHR, textStatus) {
    alert(textStatus);
    console.log(jqXHR);
  },

  ajaxBefore: function() {
    $('#main-content').html('');
    Site.beforeAjax();
  },

  ajaxSuccess: function(data, url) {
    var _this = this;

    // Convert data into proper html to be able to fully parse thru jQuery
    _this.responseHtml = document.createElement('html');
    _this.responseHtml.innerHTML = data;

    // Unbind events
    $(window).off('resize');
    $(window).off('scroll');
    $(document).off('keydown');

    // Get changes: body classes, page title, main content, main content classes, header
    var bodyClasses = $('body', _this.responseHtml).attr('class');
    var title = $('title', _this.responseHtml).text();
    var $content = $('#main-content', _this.responseHtml);
    var contentClasses = $('#main-content', _this.responseHtml).attr('class');
    var $header = $('#header', _this.responseHtml);

    // Push new history state and update title
    history.pushState(null, title, url);
    document.title = title;

    // Update with new content and classes
    $('body').removeAttr('class').addClass(bodyClasses);
    $('#main-content').html($content.html()).removeAttr('class').addClass(contentClasses);
    $('#header').html($header.html());

    // After ajax site re-init
    Site.afterAjax();

    // Rebind after ajax for new <a> tags
    _this.bind();
  },
};

Ajaxy.init();