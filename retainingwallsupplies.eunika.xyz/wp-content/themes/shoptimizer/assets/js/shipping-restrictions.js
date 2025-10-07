jQuery(document).ready(function($) {
    function checkShippingRestrictions() {
        var address = $('#shipping_address_1').val() + ', ' + $('#shipping_postcode').val();
        
        $.post(shippingRestrictions.ajax_url, {
            action: 'check_shipping_restrictions',
            address: address
        }, function(response) {
            if (response.status === 'restricted') {
                let message = 'Some products cannot be shipped to your address:\n' + response.products.join(', ');
                $('#restriction-message').text(message);
                $('#shipping-restriction-popup').show();
                $('.woocommerce-checkout-button').prop('disabled', true); // Disable checkout button
            } else {
                $('#shipping-restriction-popup').hide();
                $('.woocommerce-checkout-button').prop('disabled', false); // Enable checkout button
            }
        });
    }

    // Listen to WooCommerce AJAX update order review event
    $(document.body).on('updated_checkout', function() {
        checkShippingRestrictions();
    });

    // Close popup
    $('#close-popup').click(function() {
        $('#shipping-restriction-popup').hide();
    });
});
