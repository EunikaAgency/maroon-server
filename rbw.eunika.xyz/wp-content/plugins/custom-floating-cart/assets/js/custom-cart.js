jQuery(document).ready(function($) {
    function showLoading() {
        $('#cart-items').fadeTo('fast', 0.5);
    }

    function hideLoading() {
        $('#cart-items').fadeTo('fast', 1);
    }

    function loadFloatingCart() {
        showLoading();
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: { action: 'get_floating_cart_items' },
            success: function(response) {
                if (response != '') {
                    $('#cart-items').html(response);
                    $('#floating-cart').removeClass('d-none');
                    $('body').removeClass('minimized');  // Show cart, hide icon
                } else {
                    $('#floating-cart').addClass('d-none');
                    $('body').addClass('minimized');  // Hide cart, show icon
                }
                updateCartCount();
                hideLoading();
            }
        });
    }

    function updateCartCount() {
        var cartCount = $('#cart-items .cart-item').length;
        $('#floating-cart-count').text(cartCount);
    }

    // Initial load
    loadFloatingCart();

    // Show cart, hide icon
    $('#floating-cart-icon').on('click', function() {
        $('#floating-cart').show();
        $(this).hide();
        $('body').removeClass('minimized'); // Show cart, hide icon
    });

    // Minimize cart, show icon
    $('#minimize-cart').on('click', function() {
        $('#floating-cart').hide();
        $('#floating-cart-icon').show();
        $('body').addClass('minimized'); // Hide cart, show icon
    });

    // Refresh cart on cart events
    $(document.body).on('added_to_cart removed_from_cart updated_cart', function() {
        loadFloatingCart();
    });

    // Handle quantity change
    $(document).on('click', '.cart-item-qty-btn', function(e) {
        e.preventDefault();
        showLoading();
        var cart_item_key = $(this).data('item-key');
        var qty_change = $(this).data('qty-change');

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'update_cart_item_quantity',
                cart_item_key: cart_item_key,
                qty_change: qty_change
            },
            success: function(response) {
                if (response === 'success') {
                    $(document.body).trigger('updated_cart');
                }
                hideLoading();
            }
        });
    });

    // Handle item removal
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault();
        showLoading();
        var cart_item_key = $(this).data('item-key');

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'remove_cart_item',
                cart_item_key: cart_item_key
            },
            success: function(response) {
                if (response === 'success') {
                    $(document.body).trigger('removed_from_cart');
                }
                hideLoading();
            }
        });
    });
});
