<link rel="stylesheet" href="<?php echo e(WCRQ_ASSETS_URL . 'css/wc-form-shipping.css?ver=' . time()); ?>">
<script src="<?php echo e(WCRQ_ASSETS_URL . 'js/wc-form-shipping.js?ver=' . time()); ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const deliveryBtn = document.querySelector('.ship-to-different-address');
  const pickupBtn = document.querySelector('.store-pickup');

  const deliveryDesc = document.querySelector('.delivery-desc');
  const pickupDesc = document.querySelector('.pickup-desc');

  const updateIcons = () => {
    const deliveryIcon = deliveryBtn.querySelector('i');
    const pickupIcon = pickupBtn.querySelector('i');

    if (deliveryBtn.classList.contains('btn-electric_pink')) {
      deliveryIcon.classList.remove('fas', 'fa-square');
      deliveryIcon.classList.add('fas', 'fa-check-square');
      deliveryDesc.classList.remove('text-muted');
      deliveryDesc.classList.add('active-desc');
    } else {
      deliveryIcon.classList.remove('fas', 'fa-check-square');
      deliveryIcon.classList.add('fas', 'fa-square');
      deliveryDesc.classList.remove('active-desc');
      deliveryDesc.classList.add('text-muted');
    }

    if (pickupBtn.classList.contains('btn-electric_pink')) {
      pickupIcon.classList.remove('fas', 'fa-square');
      pickupIcon.classList.add('fas', 'fa-check-square');
      pickupDesc.classList.remove('text-muted');
      pickupDesc.classList.add('active-desc');
    } else {
      pickupIcon.classList.remove('fas', 'fa-check-square');
      pickupIcon.classList.add('fas', 'fa-square');
      pickupDesc.classList.remove('active-desc');
      pickupDesc.classList.add('text-muted');
    }
  };

  const toggleButtons = (clickedBtn) => {
    if (clickedBtn === deliveryBtn) {
      deliveryBtn.classList.add('btn-electric_pink');
      deliveryBtn.classList.remove('btn-outline-electric_pink');
      pickupBtn.classList.remove('btn-electric_pink');
      pickupBtn.classList.add('btn-outline-electric_pink');
    } else {
      pickupBtn.classList.add('btn-electric_pink');
      pickupBtn.classList.remove('btn-outline-electric_pink');
      deliveryBtn.classList.remove('btn-electric_pink');
      deliveryBtn.classList.add('btn-outline-electric_pink');
    }
    updateIcons();
  };

  deliveryBtn.addEventListener('click', () => toggleButtons(deliveryBtn));
  pickupBtn.addEventListener('click', () => toggleButtons(pickupBtn));

  updateIcons(); // Initial state
});
</script>
<style>
.shipping-desc.active-desc {
  color: #000000 !important;
}

</style>





<div class="woocommerce-shipping-fields">
  <h5 class="mb-4">Choose your shipping option</h5>

  <div class="shipping-options text-center d-flex justify-content-around align-items-center">

    <div class="form-group col-md-6">
      <input type="hidden" name="ship_to_different_address" id="ship_to_different_address_input" value="<?php echo e(WC()->cart->needs_shipping_address()); ?>">
      <button type="button" class="btn btn-electric_pink ship-to-different-address w-100">
        <i class="fas fa-check-square"></i> Delivery
      </button>
      <small class="shipping-desc delivery-desc mt-2 d-block">
        Delivery will include a shipping fee based on your address.
      </small>
    </div>

    <div class="form-group col-md-6">
      <input type="hidden" name="store_pickup" id="store_pickup_input" value="<?php echo e(! WC()->cart->needs_shipping_address()); ?>">
      <button type="button" class="btn btn-outline-electric_pink store-pickup w-100">
        <i class="far fa-square"></i> Store Pickup
      </button>
      <small class="shipping-desc pickup-desc text-muted mt-2 d-block">
        Store Pickup has no shipping fee—just drop by and collect your items.
      </small>
    </div>

  </div>
</div>








<div class="shipping_address">

    <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>


    <?php



        
            
            
    
    
    ?>

    <div class="woocommerce-shipping-fields__field-wrapper">
        <?php
            $fields = $checkout->get_checkout_fields('shipping');

      

            foreach ($fields as $key => $field) {
                woocommerce_form_field($key, $field, $checkout->get_value($key));
            }
        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

</div>







<div class="woocommerce-additional-fields">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if(apply_filters(
            'woocommerce_enable_order_notes_field',
            'yes' === get_option('woocommerce_enable_order_comments', 'yes'))): ?>

        <?php if(!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()): ?>
            <h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>
        <?php endif; ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php $__currentLoopData = $checkout->get_checkout_fields('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
