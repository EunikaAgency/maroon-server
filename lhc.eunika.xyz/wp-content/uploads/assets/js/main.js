jQuery(document).ready(function($) {

    // Get the header element
    const header = jQuery('header');

    // Initialize variables to track scroll position
    let lastScrollTop = 0;

    // Function to handle scroll event
    function handleScroll() {
        const scrollTop = jQuery(window).scrollTop();

        if (scrollTop === 0) {
            // Remove sticky header when scroll position is zero
            header.removeClass('sticky-header');
        } else {
            // Always add the sticky-header class when scrolling
            header.addClass('sticky-header');
        }

        // Update last scroll position
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }

    // Initial check to add/remove sticky header on page load
    handleScroll();

    // Add scroll event listener
    jQuery(window).scroll(handleScroll);
});
