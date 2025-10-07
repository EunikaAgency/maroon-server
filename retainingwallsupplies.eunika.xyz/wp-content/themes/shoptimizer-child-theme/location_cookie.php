<script>
    jQuery(document).ready(function($) {

        const user_location = getCookie('user_location');
        const user_change_location = getCookie('user_change_location');

        if (user_location && !user_change_location) {
            jQuery('#elementor-popup-modal-15252').addClass('d-none');
        }
        deleteCookie('user_change_location')                       

        // if (user_location) {
        //     debugger
        //     switch (user_location) {
        //         case 'VIC':
        //             jQuery('.menu-sydney').addClass('d-none')
        //             jQuery('.menu-brisbane').addClass('d-none')
        //             break

        //         case 'NSW':
        //             jQuery('.menu-melbourne').addClass('d-none')
        //             jQuery('.menu-brisbane').addClass('d-none')
        //             break

        //         case 'QLD':
        //             jQuery('.menu-melbourne').addClass('d-none')
        //             jQuery('.menu-sydney').addClass('d-none')
        //             break
        //     }
        // }

        $('.vic-btn a').on('click', function() {
            deleteCookie('user_location')
            setCookie('user_location', 'VIC', 30);
            // window.location.href = "/";
        });

        $('.nsw-btn a').on('click', function() {
            deleteCookie('user_location')
            setCookie('user_location', 'NSW', 30);
            // window.location.href = "/sydney/";
        });

        $('.qld-btn a').on('click', function() {
            deleteCookie('user_location')
            setCookie('user_location', 'QLD', 30);
            // window.location.href = "/brisbane/";
        });
    });
</script>