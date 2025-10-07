// Initialize Google Places Autocomplete for address fields
function initializeAutocomplete() {
    var inputs = document.querySelectorAll('.autocomplete-address');
    inputs.forEach(function (input) {
        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: { country: 'us' }
        });

        // Automatically fill in address components when user selects an address
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            var addressComponents = place.address_components;
            var city, state, postcode;
            
            addressComponents.forEach(function (component) {
                var types = component.types;
                if (types.includes('locality')) {
                    city = component.long_name;
                    document.querySelectorAll('.autocomplete-city').forEach(function (cityField) {
                        cityField.value = city;
                    });
                }
                if (types.includes('administrative_area_level_1')) {
                    state = component.short_name;
                    document.querySelectorAll('.autocomplete-state').forEach(function (stateField) {
                        stateField.value = state;
                    });
                }
                if (types.includes('postal_code')) {
                    postcode = component.long_name;
                    document.querySelectorAll('.autocomplete-zip').forEach(function (zipField) {
                        zipField.value = postcode;
                    });
                }
            });
        });
    });
}

// jQuery for form steps
jQuery(document).ready(function($) {
    // Enable "Next" button when all fields in Step 1 are filled
    $('#fillup-step-1 input').on('keyup change', function() {
        var allFilled = true;
        $('#fillup-step-1 input[required]').each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false;
            }
        });
        $('#next-step').prop('disabled', !allFilled);
    });

    // Move to Step 2 (Shipping Information)
    $('#next-step').on('click', function() {
        $('#fillup-step-1').hide(); // Hide Membership Information
        $('#fillup-step-2').show(); // Show Shipping Information
    });

    // Move back to Step 1 (Membership Information)
    $('#back-step').on('click', function() {
        $('#fillup-step-2').hide(); // Hide Shipping Information
        $('#fillup-step-1').show(); // Show Membership Information
    });

    // Handle form submission
    $('#billing-shipping-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        // Collect shipping details
        var shipping_data = {
            shipping_first_name: $('#shipping_first_name').val(),
            shipping_last_name: $('#shipping_last_name').val(),
            shipping_address_1: $('#shipping_address_1').val(),
            shipping_city: $('#shipping_city').val(),
            shipping_state: $('#shipping_state').val(),
            shipping_postcode: $('#shipping_postcode').val(),
            shipping_country: $('#shipping_country').val()
        };

        // Use shipping details for billing as well
        var billing_data = {
            billing_first_name: shipping_data.shipping_first_name,
            billing_last_name: shipping_data.shipping_last_name,
            billing_address_1: shipping_data.shipping_address_1,
            billing_city: shipping_data.shipping_city,
            billing_postcode: shipping_data.shipping_postcode,
            billing_state: shipping_data.shipping_state,
            billing_country: shipping_data.shipping_country,
            billing_email: $('#billing_email').val(), // Original email from Step 1
            billing_phone: $('#billing_phone').val()  // Original phone from Step 1
        };

        // Send an AJAX request to update WooCommerce customer data
        $.ajax({
            url: custom_wc_params.ajax_url, // Use the localized AJAX URL
            type: 'POST',
            data: {
                action: 'update_customer_details', // Custom action
                shipping_data: shipping_data,
                billing_data: billing_data,
            },
            success: function(response) {
                if (response.success) {
                    // Redirect to the checkout page after successful update
                    window.location.href = custom_wc_params.checkout_url; // Use the localized checkout URL
                } else {
                    alert('There was an error updating the details.');
                }
            },
            error: function() {
                alert('AJAX request failed.');
            }
        });
    });
});

google.maps.event.addDomListener(window, 'load', function () {
    initializeAutocomplete();
});
