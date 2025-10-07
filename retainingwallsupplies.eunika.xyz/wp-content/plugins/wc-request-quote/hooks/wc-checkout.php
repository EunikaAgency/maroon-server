<?php

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields) {

  // Define the fields you want to display and which ones are required
  $custom_fields = array(
    'billing_abn' => array(
      'required'  => false,
      'class'     => array('form-row-wide'),
      'label'     => __('ABN Number', 'woocommerce')
    )
  );

  // Overwrite the fields
  foreach ($custom_fields as $key => $field) {
    $fields['billing'][$key] = $field;
  }

  // Set default values and make 'billing_city' and 'billing_address_1' invisible
  $fields['billing']['billing_city'] = array(
    'required'  => false,
    'class'     => array('form-row-wide', 'd-none'),
    'default'   => 'N/A'
  );
  
  $fields['billing']['billing_address_1'] = array(
    'required'  => false,
    'class'     => array('form-row-wide', 'd-none'),
    'default'   => 'N/A'
  );

  // List of fields to keep visible
  $visible_fields = array(
    'billing_first_name',
    'billing_last_name',
    'billing_email',
    'billing_phone',
    'billing_company', // Assuming you add this field
    'billing_abn', // Assuming you add this field
  );

  // Loop through all billing fields
  foreach ($fields['billing'] as $key => $field) {
    if (!in_array($key, $visible_fields)) {
      $fields['billing'][$key]['class'][] = 'd-none';
    }
  }

  // Adjust classes for specific fields
  $fields['billing']['billing_phone']['class'] = ['form-row', 'form-row-first'];
  $fields['billing']['billing_email']['class'] = ['form-row', 'form-row-last'];
  $fields['billing']['billing_company']['class'] = ['form-row', 'form-row-first'];
  $fields['billing']['billing_abn']['class'] = ['form-row', 'form-row-last'];

  // Make other address-related fields not required
  $fields['billing']['billing_address_2']['required'] = false; // Suburb
  $fields['billing']['billing_postcode']['required'] = false;  // Postcode
  $fields['billing']['billing_suburb']['required'] = false; // Additional suburb field

  // Check if state field exists and make it not required
  if( isset($fields['billing']['billing_state']) ){
    $fields['billing']['billing_state']['required'] = false;
  }

  return $fields;
}


// ------------------------------------------------------------------------------------------------------------

add_filter('woocommerce_checkout_fields', 'custom_add_billing_field');
function custom_add_billing_field($fields) {
  $fields['billing']['store_pickup'] = array(
    'type' => 'checkbox',
    'label' => __('Pickup at store: Select this option to pick up your order in person at our store.', 'woocommerce'),
    'required' => false,
    'class' => array('form-row-wide d-none'),
    'clear' => true
  );
  return $fields;
}



add_filter('woocommerce_checkout_fields', 'reorder_checkout_fields');

function reorder_checkout_fields($fields) {
  // Define the custom order and priorities
  $custom_order = array(
    'billing_first_name' => 10,
    'billing_last_name'  => 20,
    'billing_phone'      => 30,
    'billing_email'      => 40,

    'billing_company'    => 50,
    'billing_abn'        => 60,
    // 'store_pickup'       => 70
  );

  // Loop through the custom order and assign priorities
  foreach ($custom_order as $field => $priority) {
    if (isset($fields['billing'][$field])) {
      $fields['billing'][$field]['priority'] = $priority;
    }
  }

  return $fields;
}
