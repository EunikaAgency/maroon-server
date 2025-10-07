<?php
global $product;

// Get cross-sell and upsell IDs
$cross_sell_ids = $product->get_cross_sell_ids();
$upsell_ids = $product->get_upsell_ids();

// Initialize an array to store the selected IDs
$selected_ids = [];

// Check if there are cross-sell products
if (!empty($cross_sell_ids)) {
    // Check if there are at least 4 cross-sell products
    if (count($cross_sell_ids) >= 4) {
        // Randomly pick 4 unique IDs from the cross-sell IDs
        $random_keys = array_rand($cross_sell_ids, 4);
        $selected_ids = array_intersect_key($cross_sell_ids, array_flip($random_keys));
    } else {
        // If less than 4, use all available cross-sell IDs
        $selected_ids = $cross_sell_ids;
    }
} elseif (!empty($upsell_ids)) {
    // If no cross-sell products, check if there are upsell products
    if (count($upsell_ids) >= 4) {
        // Randomly pick 4 unique IDs from the upsell IDs
        $random_keys = array_rand($upsell_ids, 4);
        $selected_ids = array_intersect_key($upsell_ids, array_flip($random_keys));
    } else {
        // If less than 4, use all available upsell IDs
        $selected_ids = $upsell_ids;
    }
}

// Implode the selected IDs into a string
$selected_ids_string = implode(', ', $selected_ids);

// Creating the shortcode with the selected IDs
$shortcode = "[products id='$selected_ids_string' columns=4 limit=4]";

?>

<link rel="stylesheet" href="<?php echo e(WCRQ_ASSETS_URL . 'css/product-cart-modal.css?ver=' . time()); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
    integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="modal fade" id="product_cart_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-5" role="document">
        <div class="modal-content">

            <div class="modal-body">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="<?php echo e(home_url('checkout')); ?>"
                        class="btn btn-xs btn-md btn-electric_pink font-weight-bold mr-1">
                        <i class="fas fa-receipt mr-2"></i>
                        View Quote
                    </a>

                    <button type="button" class="btn btn-xs btn-outline-dark" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                
                <h5>Customers also bought...</h5>


                <?php echo do_shortcode($shortcode); ?>


            </div>

        </div>
    </div>
</div>

