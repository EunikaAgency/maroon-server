jQuery(document).ready(function ($) {
    // Mobile dropdown toggle functionality
    $('.custom-nav .navbar-nav .submenu-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $toggle = $(this);
        var $parent = $toggle.closest('.menu-item');
        var $submenu = $parent.find('> .sub-menu');
        var isExpanded = $toggle.attr('aria-expanded') === 'true';
        
        // Toggle submenu
        $submenu.slideToggle(200);
        $toggle.attr('aria-expanded', !isExpanded);
        
        // Update toggle icon
        $toggle.find('.toggle-icon').text(isExpanded ? '+' : '-');
        
        // Close other open submenus at the same level
        $parent.siblings('.menu-item').find('> .sub-menu').slideUp(200);
        $parent.siblings('.menu-item').find('.submenu-toggle')
            .attr('aria-expanded', 'false')
            .find('.toggle-icon').text('+');
    });

    // Prevent clicks inside submenu from closing it
    $('.custom-nav .navbar-nav .sub-menu').on('click', function(e) {
        e.stopPropagation();
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.custom-nav .navbar-nav .menu-item').length) {
            $('.custom-nav .navbar-nav .sub-menu').slideUp(200);
            $('.custom-nav .navbar-nav .submenu-toggle')
                .attr('aria-expanded', 'false')
                .find('.toggle-icon').text('+');
        }
    });
    
    // Existing offcanvas code
    $(document).on('show.bs.offcanvas', function() {
        $('.offcanvas-backdrop').not(':last').remove();
    });
    
    if ($('.offcanvas-backdrop').length > 1) {
        $('.offcanvas-backdrop').not(':last').remove();
    }



    
});

jQuery(function($) {
    // Add jQuery UI easing for smoother animations (if not already included)
    jQuery.extend(jQuery.easing, {
        easeOutQuad: function(x, t, b, c, d) {
            return -c * (t /= d) * (t - 2) + b;
        }
    });

    const $customNav2 = $('.custom-nav2');
    let isAnimating = false;

    $(window).on('scroll', function() {
        if (isAnimating) return;
        
        const scrollTop = $(window).scrollTop();
        const triggerPoint = $(window).height() * 0.2;
        const shouldShow = scrollTop > triggerPoint;

        if (shouldShow !== $customNav2.is(':visible')) {
            isAnimating = true;
            
            if (shouldShow) {
                $customNav2.stop(true, true).slideDown({
                    duration: 400,
                    easing: 'easeOutQuad',
                    complete: function() {
                        $(this).css('display', 'flex');
                        isAnimating = false;
                    }
                });
            } else {
                $customNav2.stop(true, true).slideUp({
                    duration: 400,
                    easing: 'easeOutQuad',
                    complete: function() {
                        isAnimating = false;
                    }
                });
            }
        }
    });
});