jQuery(document).ready(function() {
    jQuery('.has-submenu').click(function(event) {
        event.preventDefault();

        // Toggle the visibility of the clicked submenu and its children
        var clickedSubmenu = jQuery(this).next('.sub-menu.layer-1');

        jQuery('.sub-menu.layer-1').not(clickedSubmenu).removeClass('show');
        jQuery('.has-submenu').not(this).removeClass('expanded');

        clickedSubmenu.toggleClass('show');
        jQuery(this).toggleClass('expanded');

        // Show all children submenus and their items
        clickedSubmenu.find('.sub-menu').addClass('show');
    });

    // Hide .layer-1 submenu when clicking outside of it
    jQuery(document).click(function(event) {
        if (!jQuery(event.target).closest('.layer-1, .has-submenu').length) {
            jQuery('.sub-menu.layer-1').removeClass('show');
            jQuery('.has-submenu').removeClass('expanded');
        }
    });

    // Hide .layer-1 submenu when the mouse hovers outside for more than 5 seconds
    var hideTimeout;
    jQuery('.layer-1').hover(
        function() {
            clearTimeout(hideTimeout);
        },
        function() {
            hideTimeout = setTimeout(function() {
                jQuery('.sub-menu.layer-1').removeClass('show');
                jQuery('.has-submenu').removeClass('expanded');
            }, 5000);
        }
    );
});
