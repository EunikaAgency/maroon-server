jQuery(document).ready(function($) {








    // Function to update the h1 text based on the selected payment method
    function updatePaymentDescription() {
        var paymentMethod = $('.wc_payment_methods input[type=radio][name=payment_method]:checked').val();
        var descriptionText = '';

        // Assign text based on the payment method selected
        if (paymentMethod === 'woocommerce_payments') {
            descriptionText = 'Checkout';
        } else if (paymentMethod === 'purchase_order') {
            descriptionText = 'Send A Quote';
        }

        // Update the h1 element with the appropriate description
        $('.woocommerce-billing-fields h3').text(descriptionText);
    }

    // Call the function on page load
    updatePaymentDescription();

    // Set up the event listener for changes
    $('body').on('change', '.wc_payment_methods input[type=radio][name=payment_method]', updatePaymentDescription);

 




  $('.ship-to-different-address').click(function() {
      $('#ship_to_different_address_input').val('1');
      $('#store_pickup_input').val('0');
      $('.ship-to-different-address').removeClass('btn-outline-electric_pink').addClass('btn-electric_pink');
      $('.store-pickup').removeClass('btn-electric_pink').addClass('btn-outline-electric_pink');

      $(".shipping_address").show();
      $("#billing_state[name='billing_state']").attr("required", "required");

      // additions....
      $("#billing_city_field").hide();
      $("#billing_address_1_field").hide();

      // Trigger AJAX request to update order review
      jQuery(document.body).trigger("update_checkout")
  });

  $('.store-pickup').click(function() {
      $('#ship_to_different_address_input').val('0');
      $('#store_pickup_input').val('1');
      $('.ship-to-different-address').removeClass('btn-electric_pink').addClass('btn-outline-electric_pink');
      $('.store-pickup').removeClass('btn-outline-electric_pink').addClass('btn-electric_pink');

      $(".shipping_address").hide();
      $("#billing_state[name='billing_state']").removeAttr("required");

      // additions....
      $("#billing_city_field").hide();
      $("#billing_address_1_field").hide();

      



      // Trigger AJAX request to update order review
      jQuery(document.body).trigger("update_checkout")
  });


});
