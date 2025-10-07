<?php
$shipping_groups = sgs_get_grouped_cart_items_by_shipping_class();
?>

<script>
window.cartShippingGroups = <?php echo json_encode($shipping_groups); ?>;
</script>

<div id="shippingGroupOverlay" class="sgs-modal-overlay" style="display: none;">
  <div class="sgs-close">&times;</div>
  <div class="sgs-modal">
    <h3>Let's Organise Your Order</h3>
    <p style="font-size: 14px; color: #4a5568; margin: 10px 0 20px;">
      Your order contains products shipping from different locations. 
      Please select one shipping group to proceed with checkout.
    </p>

    <div id="shipping-group-options"></div>
    
    <p style="font-size: 13px; color: #718096; margin-top: 20px;">
      <i class="dashicons dashicons-info"></i> 
      Need help? <a href="/contact" style="color: #3182ce;">Contact us</a> for assistance.
    </p>
  </div>
</div>