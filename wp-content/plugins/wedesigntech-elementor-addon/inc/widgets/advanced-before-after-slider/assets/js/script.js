(function ($) {

  const wdtAdvancedBeforeAfterSlideWidgetHandlers = function($scope, $) {

    var element_scope = $scope.find('.wdt-before-after-slider-container');

    $(window).load(function() {
      $.each(element_scope, function() {
        var element   = $(this),
          original  = element.find('.wdt-foreground-img'),
          img_width = element.find('.wdt-foreground-img img').width(),
          init_split= Math.round(img_width/2);

          original.stop().animate({
            width: init_split
          },1000);
      });
    });
    
    $.each(element_scope, function() {
      var element   = $(this),
          original  = element.find('.wdt-foreground-img'),
          holder    = element.find('#wdt-slider-button'),
          img_width = element.find('.wdt-foreground-img img').width(),
          init_split= Math.round(img_width/2);

      element_scope.mousemove(function(e) {
        var offX  = (e.offsetX || e.clientX - original.offset().left);
        original.width(offX);
        holder.css( "left", offX);
      });
    
      element_scope.mouseleave(function() {
        original.stop().animate({
          width: init_split
        },1000);
      
        holder.stop().animate({
            left: init_split
        },1000);
      });

    });

    return  wdtAdvancedBeforeAfterSlideWidgetHandlers;
  }

  $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-before-after-slider.default', wdtAdvancedBeforeAfterSlideWidgetHandlers);
  });

})(jQuery);