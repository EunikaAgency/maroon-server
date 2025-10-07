// jQuery(document).ready(function($) {
//     // Replace add to cart button behavior for simple products
//     $('body').on('click', '.add_to_cart_button:not(.product_type_variable, .product_type_grouped, .product_type_external)', function(e) {
//         e.preventDefault();
        
//         // Get product ID from data attribute
//         var productId = $(this).data('product_id');
        
//         // If not found in data attribute, try to get from form
//         if (!productId && $(this).closest('form').length) {
//             productId = $(this).closest('form').find('[name="add-to-cart"]').val();
//         }
        
//         if (productId) {
//             window.location.href = '/mockup?product_id=' + productId;
//         }
//     });
    
//     // Handle variable products - redirect after variation selection
//     $('body').on('click', '.single_add_to_cart_button', function(e) {
//         // Check if it's a variable product form
//         var $form = $(this).closest('form.variations_form');
//         if ($form.length) {
//             e.preventDefault();
            
//             // Get selected variation ID
//             var variationId = $form.find('input[name="variation_id"]').val();
//             if (variationId) {
//                 window.location.href = '/mockup?product_id=' + variationId;
//             } else {
//                 // If no variation selected, trigger WooCommerce's validation
//                 $form.trigger('submit');
//             }
//         }
//     });
// });

jQuery(document).ready(function($) {
    if (typeof $ === 'undefined') return;

    function parseProductIdFromHref(href){
        if (!href) return null;
        var match = href.match(/[?&]product_id=(\d+)/);
        return match ? match[1] : null;
    }

    // Loop products (simple)
    $('body').on('click', '.add_to_cart_button:not(.product_type_variable, .product_type_grouped, .product_type_external)', function(e) {
        var $btn = $(this);
        e.preventDefault();

        if ($btn.is('[disabled]') || $btn.hasClass('disabled') || $btn.attr('aria-disabled') === 'true') {
            return;
        }

        var productId = $btn.data('product_id') || $btn.attr('data-product_id') || parseProductIdFromHref($btn.attr('href'));
        if (productId) {
            var base = (window.quote_redirect_vars && quote_redirect_vars.mockup_url) ? quote_redirect_vars.mockup_url : '/mockup';
            window.location.href = base + '?product_id=' + productId;
        }
    });

    // Single product / variable product
    $('body').on('click', '.single_add_to_cart_button', function(e) {
        var $btn = $(this);
        e.preventDefault();

        if ($btn.is('[disabled]') || $btn.hasClass('disabled') || $btn.attr('aria-disabled') === 'true') {
            return;
        }

        var $form = $btn.closest('form.variations_form');
        if ($form.length) {
            var variationId = $form.find('input[name="variation_id"]').val();
            if (variationId && parseInt(variationId) > 0) {
                var base = (window.quote_redirect_vars && quote_redirect_vars.mockup_url) ? quote_redirect_vars.mockup_url : '/mockup';
                window.location.href = base + '?product_id=' + variationId;
            } else {
                $form.trigger('submit');
            }
        } else {
            var productId = $btn.data('product_id') || $btn.attr('data-product_id') || $btn.closest('form').find('[name="add-to-cart"]').val();
            if (productId) {
                var base = (window.quote_redirect_vars && quote_redirect_vars.mockup_url) ? quote_redirect_vars.mockup_url : '/mockup';
                window.location.href = base + '?product_id=' + productId;
            }
        }
    });
});
