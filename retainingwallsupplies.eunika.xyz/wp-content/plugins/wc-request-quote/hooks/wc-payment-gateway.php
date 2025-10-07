<?php

add_action('plugins_loaded', 'purchase_order_init');
function purchase_order_init() {
  class Purchase_Order_Gateway extends WC_Payment_Gateway {
    public function __construct() {
      $this->id                 = 'purchase_order';
      $this->icon               = apply_filters('woocommerce_po_icon', '');
      $this->method_title       = __('Request a Quote', 'purchase-order');
      $this->method_description = __('Allows customers to submit an order without making a payment.', 'purchase-order');
      $this->has_fields         = false;

      // Load the settings.
      $this->init_form_fields();
      $this->init_settings();

      // Define user set variables.
      $this->title       = $this->get_option('title');
      $this->description = $this->get_option('description');

      // Actions.
      add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
      add_action('woocommerce_thankyou_purchase_order', array($this, 'thankyou_page'));

      // Customer Emails.
      add_action('woocommerce_email_before_order_table', array($this, 'email_instructions'), 10, 3);
    }

    public function init_form_fields() {
      $this->form_fields = array(
        'enabled' => array(
          'title'   => __('Enable/Disable', 'purchase-order'),
          'type'    => 'checkbox',
          'label'   => __('Enable Request a Quote', 'purchase-order'),
          'default' => 'yes',
        ),
        'title' => array(
          'title'       => __('Title', 'purchase-order'),
          'type'        => 'text',
          'description' => __('This controls the title which the user sees during checkout.', 'purchase-order'),
          'default'     => __('Request a Quote', 'purchase-order'),
          'desc_tip'    => true,
        ),
        'description' => array(
          'title'       => __('Description', 'purchase-order'),
          'type'        => 'textarea',
          'description' => __('Payment method description that the customer will see on your checkout.', 'purchase-order'),
          'default'     => __('This is a request for quotation. No credit card required.', 'purchase-order'),
          'desc_tip'    => true,
        ),
      );
    }

    public function thankyou_page() {
      if ($this->get_description()) {
        echo wpautop(wptexturize($this->get_description()));
      }
    }

    public function email_instructions($order, $sent_to_admin, $plain_text = false) {
      if ($this->get_description()) {
        echo wpautop(wptexturize($this->get_description())) . PHP_EOL;
      }
    }

    public function process_payment($order_id) {
      $order = wc_get_order($order_id);
      $order->update_status('completed', __('Payment to be made by purchase order.', 'purchase-order'));
      WC()->cart->empty_cart();
      return array(
        'result'   => 'success',
        'redirect' => $this->get_return_url($order),
      );
    }
  }

  add_filter('woocommerce_payment_gateways', 'add_purchase_order_gateway');
  function add_purchase_order_gateway($methods) {
    $methods[] = 'Purchase_Order_Gateway';
    return $methods;
  }

  // Change Add to Cart button label
  // add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' ); 
  // add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );   
  function woo_custom_cart_button_text() {
    return __('Add to Quote', 'woocommerce');
  }

  // add_action( 'woocommerce_single_product_summary', 'custom_button_after_product_summary', 30 );
  function custom_button_after_product_summary() {
    global $product;
    var_dump($product->id);
    echo "<a class='single_add_to_cart_button button alt wp-element-button' href='https://staging.retainingwallsupplies.eunika.xyzcart/?add-to-cart=" . $product->id . "'>Add to Quote</a>";
  }
}


add_filter( 'woocommerce_available_payment_gateways', 'set_default_payment_method' );

function set_default_payment_method( $available_gateways ) {
    // Check if we're not in admin
    if ( is_admin() ) {
        return $available_gateways;
    }

    // Set your default gateway here. This is the ID of the gateway.
    $default_gateway_id = 'purchase_order'; // Replace 'stripe' with the ID of your default gateway

    // Check if your default gateway is available. If it's not, do nothing
    if (!isset($available_gateways[$default_gateway_id])) {
        return $available_gateways;
    }

    // Set the default gateway
    foreach ($available_gateways as $gateway_id => $gateway) {
        
        if ($gateway_id == $default_gateway_id) {


          // $available_gateways[$gateway_id]->chosen = true;
          $available_gateways[$gateway_id]->chosen = false;
          $available_gateways[$gateway_id]->order_button_text = "Send Quote";
          
        }
    }

    return $available_gateways;
}
