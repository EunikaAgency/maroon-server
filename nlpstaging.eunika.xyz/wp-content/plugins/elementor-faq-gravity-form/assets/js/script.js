jQuery(document).ready(function($) {
    // Initialize Bootstrap accordion
    $('.accordion').each(function() {
        var $accordion = $(this);
        $accordion.find('.accordion-collapse').on('shown.bs.collapse', function() {
            $accordion.find('.accordion-button').removeClass('active');
            $(this).prev('.accordion-header').find('.accordion-button').addClass('active');
        });
    });
    
    // Draw underline animation
    $('.highlight-underline path').each(function() {
        var length = this.getTotalLength();
        $(this).css({
            'stroke-dasharray': length,
            'stroke-dashoffset': length
        }).animate({
            'stroke-dashoffset': 0
        }, 1000);
    });
});