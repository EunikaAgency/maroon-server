jQuery(document).ready(function($) {
    var previousScroll = 0;
    var header = $('.sticky-header');

    $(window).on('scroll', function() {
        var currentScroll = $(this).scrollTop();
        
        if (currentScroll > previousScroll && currentScroll > 100) {
            // User is scrolling down and past 100px from top
            header.addClass('visible');
        } else {
            // User is scrolling up
            header.removeClass('visible');
        }
        
        previousScroll = currentScroll;
    });
});
