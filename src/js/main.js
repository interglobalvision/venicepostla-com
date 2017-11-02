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

    if (_this.images.length > 0) {
      Site.shuffleArray(_this.images);

      _this.requestFirstImages();
    }
  },

  requestFirstImages: function() {
    var _this = this;

    for (var i = 0; i < _this.numberOfFirstLoadImages; i++) {
      _this.$animation.append('<img src="' + _this.images[i] + '" id="animation-image-' + i + '" class="animation-image" />');

      $('#animation-image-' + i).bind('load', function() {
        $(this).addClass('animation-image-loaded');

        if (!_this.active) {
          $('.animation-image-loaded').first().addClass('active');

          _this.animate();
        }

        window.setTimeout(function() {
          _this.loadNextImage();
        }, _this.requestDelay);
      });

      _this.nextImage = i + 1;
    }
  },

  loadNextImage: function() {
    var _this = this;

    if (_this.images[_this.nextImage]) {
      _this.$animation.append('<img src="' + _this.images[_this.nextImage] + '" id="animation-image-' + _this.nextImage + '" class="animation-image" />');

      $('#animation-image-' + _this.nextImage).bind('load', function() {
        $(this).addClass('animation-image-loaded');

        window.setTimeout(function() {
          _this.loadNextImage();
        }, _this.requestDelay);
      });

      _this.nextImage++;
    } else {
      console.log('all loaded');
    }
  },

  animate: function() {
    var _this = this;

    _this.active = true;

    _this.animationInterval = setInterval(function() {
      var $active = $('.animation-image-loaded.active');
      var $next = $active.next('.animation-image-loaded');

      $active.removeClass('active');

      if ($next.length) {
        $next.addClass('active');
      } else {
        $('.animation-image-loaded').first().addClass('active');
      }
    }, _this.animationSpeed);

  },

  updateAnimation: function() {}
};

Site.init();