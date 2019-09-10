$(document).ready(function () {

    $(".login-input").focusin(function () {
        $(this).find("span").animate({
            "opacity": "0"
        }, 200);
    });

    $(".login-input").focusout(function () {
        $(this).find("span").animate({
            "opacity": "1"
        }, 300);
    });
    
        /* ----------------------------------------------------------- */
        /* CARTBOX 
        /* ----------------------------------------------------------- */

    $('.aa-cartbox').click(function (e) {

        if ($('.aa-cartbox-summary').is(':visible')) {
            $('.aa-cartbox-summary').fadeOut();
        } else {
            $('.aa-cartbox-summary').fadeIn();
        }

        e.stopPropagation();

    });
    $(document).click(function (e) {

        if ($('.aa-cartbox-summary').is(':visible')) {
            $('.aa-cartbox-summary').fadeOut();
        }

        e.stopPropagation();

    });

    /** slider controll **/
    
    $('.service-slider').owlCarousel({
        autoPlay: 3000,
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 3],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        pagination: false,
        dots: false,
        lazyLoad: false,
        navigation: true,
        navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        loop:true,
        mouseDrag:false,
        touchDrag:false
    }); 
    
     $('.ad-carousel').owlCarousel({
        autoPlay: 3000,
        items: 1,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [768, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        pagination: false,
        dots: false,
        lazyLoad: false,
        navigation: true,
        navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        loop:true,
        mouseDrag:false,
        touchDrag:false
    });


});

jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})