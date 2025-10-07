jQuery(function($) {
    let $form = $('.variations_form');
    let $customizable = $('.product_type_customizable');

    $customizable.hide();

    $form.on('woocommerce_variation_has_changed', function() {
        let variation = $form.find('input.variation_id').val();

        if (variation && variation !== '0') {
            $customizable.show();
        } else {
            $customizable.hide();
        }
    });
});

jQuery(function($) {
    $('form.cart').on('submit', function(e) {
        e.preventDefault(); // block default submit

        const $form = $(this);
        const productID = $form.find('input[name="product_id"]').val();
        const variationID = $form.find('input[name="variation_id"]').val();

        // variable product but no variation selected
        if (variationID !== undefined && variationID === '') {
            return; // do nothing
        }

        // redirect with product-id param
        window.location.href = '/mockup?product_id=' + (variationID || productID);
    });
});
