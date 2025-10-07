<div id="floating-cart-icon" class="position-fixed" style="bottom: 20px; right: 20px; z-index: 1000;">
    <img src="<?php echo plugins_url('../assets/image/wine-cart-outline.png', __FILE__); ?>" alt="Cart Icon" id="floating-cart-icon-img">
    <span id="floating-cart-count" class="badge badge-danger position-absolute" style="top: 0; right: 0;">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
</div>

<div id="floating-cart" class="position-fixed" style="bottom: 20px; right: 20px; z-index: 999; width: 300px;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="">My Wine Cart</span>
            <button id="minimize-cart" class="btn btn-sm btn-link text-dark">&minus;</button>
        </div>
        <div class="card-body" id="cart-items">
            <!-- Spinner -->
            <div id="loading-spinner" style="display:none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Items will be loaded here dynamically -->
        </div>
        <div class="card-footer text-right">
            <!-- <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-outline-deep-teal btn-block">Proceed to Checkout</a> -->
            <a href="<?php echo home_url('/shipping-details/'); ?>" class="btn btn-outline-deep-teal btn-block">Proceed to Checkout</a>

        </div>
    </div>
</div>
