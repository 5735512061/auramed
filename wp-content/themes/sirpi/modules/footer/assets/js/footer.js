// Window load event used just in case window height is dependant upon images
jQuery(window).bind("load", function() { 

    var footerHeight = 0,
        footerTop = 0,
        $footer = jQuery("#footer");
  
    positionFooter();

    function positionFooter() {
  
        footerHeight = $footer.height();
        footerTop = (jQuery(window).scrollTop()+jQuery(window).height()-footerHeight)+"px";

        if ( (jQuery(document.body).height()+footerHeight) < jQuery(window).height()) {
            $footer.css({
                    position: "absolute",
                    top: footerTop
            });
        } else {
            $footer.css({
                    position: "static"
            })
        }
  
    }
  
    jQuery(window)
            .scroll(positionFooter)
            .resize(positionFooter)

});