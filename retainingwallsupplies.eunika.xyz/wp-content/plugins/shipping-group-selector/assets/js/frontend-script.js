jQuery(document).ready(function($) {
  console.log('SGS: frontend-script.js loaded');

  const groups = window.cartShippingGroups || {};
  console.log('SGS: window.cartShippingGroups →', groups);

  const container = $('#shipping-group-options');

  // Count non-blank groups and check if 'blank' is present
  let groupCount = 0;
  let hasBlank = false;

  Object.keys(groups).forEach(key => {
      if (key === 'blank') {
          hasBlank = true;
      } else {
          groupCount++;
      }
  });

  // Show modal only if there's more than one group to choose from
  if (groupCount > 1 || (groupCount === 1 && hasBlank)) {
      console.log('SGS: Showing modal — Multiple shipping groups detected.');
      $('#shippingGroupOverlay').css('display', 'flex').hide().fadeIn();
  } else {
      console.log('SGS: Skipping modal — Only one group or blank group.');
      $('#shippingGroupOverlay').remove();
  }

  // Generate the group buttons inside the modal
  Object.entries(groups).forEach(([location, items]) => {
      const label = sgs_data.location_labels[location] || 
                   location.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      
      const btn = $('<button>')
          .addClass('sgs-group-btn')
          .html(`
              <strong>${label}</strong>
              <span class="sgs-item-count">${items.length} item${items.length !== 1 ? 's' : ''}</span>
              <small class="sgs-products">${getSampleProducts(items)}</small>
          `)
          .click(() => selectShippingGroup(location, items));
      
      container.append(btn);
  });

  // Helper function to show sample product names
  function getSampleProducts(items) {
      const maxProducts = 3;
      const productNames = items.slice(0, maxProducts).map(item => item.name);
      if (items.length > maxProducts) productNames.push('...');
      return productNames.join(', ');
  }

  // AJAX filter the cart by selected group
  function selectShippingGroup(location, items) {
      const keys = items.map(item => item.key);
      console.log(`SGS: Selected location "${location}" →`, keys);

      $.post({
          url: sgs_data.ajax_url,
          data: {
              action: 'filter_cart_by_shipping_group',
              keys: keys
          },
          success(response) {
              if (response.success) {
                  console.log('SGS: Cart filtered, reloading...');
                  $('#shippingGroupOverlay').fadeOut();
                  window.location.reload();
              } else {
                  alert(response.data.message || 'Error processing selection.');
              }
          },
          complete: function() {
            // Always refresh when the request is complete
            window.location.reload();
          },
          error(err) {
              console.error('SGS: AJAX error', err);
              alert('An error occurred while processing your selection.');
          }
      });
  }
});