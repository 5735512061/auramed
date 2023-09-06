(function ($) {
  "use strict";

  var wdtRotateImageWidgetHandler = function($scope, $) {

    let $settings = $scope.find('.wdt-rotate-image-container').data('settings');
    let $rotation_direction = $settings['rotation_side'] ? $settings['rotation_side'] : 'anti-clock';

    window.addEventListener("scroll", function (event) {
      var scroll = this.scrollY;

      if( $rotation_direction == 'anti-clock' ) {
        document.querySelector('.wdt-rotate-image img').style.transform = "rotate(-"+scroll+"deg)";
      } else {
        document.querySelector('.wdt-rotate-image img').style.transform = "rotate("+scroll+"deg)";
      }

    });
  };

  $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-rotate-image.default', wdtRotateImageWidgetHandler);
  });

})(jQuery);
