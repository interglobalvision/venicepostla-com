/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Site, WP */

Site = {
  mobileThreshold: 601,
  init: function() {
    var _this = this;

    $(window).resize(function(){
      _this.onResize();
    });

    $(document).ready(function () {

    });

    _this.HomeAnimation.init();
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
  nextImage: 0,
  numberOfFirstLoadImages: 6,
  requestDelay: 250,
  animationSpeed: 250,

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
    _this.$animation.append('<img src="' + _this.images[imageIndex]['1800'] + '" srcset="' + srcset + '" id="animation-image-' + imageIndex + '" class="animation-image" />');

    // bind to load event of inserted image
    $('#animation-image-' + imageIndex).bind('load', function() {
      // on loaded set loaded class
      $(this).addClass('animation-image-loaded');

      // set max image size with cached sizes
      _this.setMaxImageSize();

      // if animation isn't active trigger animation
      if (!_this.active) {
        $('.animation-image-loaded').first().addClass('active');

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
      var $active = $('.animation-image-loaded.active');
      var $next = $active.next('.animation-image-loaded');

      // hid current image
      $active.removeClass('active');

      if ($next.length) {
        // if next show it
        $next.addClass('active');
      } else {
        // otherwise restart loop
        $('.animation-image-loaded').first().addClass('active');
      }
    }, _this.animationSpeed);

  },

  getAndSetMaxImageSize: function() {
    var _this = this;

    // get max height and width for images based on header elems

    // get logo padding-top and convert to integer
    var padding = parseInt(_this.headerLogoTop.css('padding-top'));

    // offset from viewport, plus dimension, plus padding. x2 for both items
    var logoHeight = (_this.headerLogoTop.offset().top + _this.headerLogoTop.height() + padding) * 2;
    var navWidth = (_this.headerNavLeft.offset().left + _this.headerNavLeft.width() + padding) * 2;

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
    var _this = this;
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

Site.init();
