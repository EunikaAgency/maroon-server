jQuery(document).ready(function(jQuery) {
    jQuery('body').on('submit', 'form.cart', function(e) {
        e.preventDefault();

        var form = jQuery(this);
        var formData = form.serialize();

        jQuery.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: formData,
            success: function(response) {

                // Trigger event so themes can refresh other areas.
                // jQuery('#product_cart_modal').modal('show');
                jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, form]);

                jQuery(".cart-click").click();
            },
            dataType: 'json'
        });

        return false;
    });
});
