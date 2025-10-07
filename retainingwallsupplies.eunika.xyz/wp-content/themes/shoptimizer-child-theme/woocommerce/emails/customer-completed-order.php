<?php
/**
 * Customer Completed Order Email Template
 * 
 * Override this template by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 * 
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// Check if the payment method includes 'request'.
if ( strpos( strtolower( $order->get_payment_method_title() ), 'request' ) !== false ) {

	do_action( 'woocommerce_email_header', "Thank you for your enquiry", $email );
    echo '
        <p>Thank you for your enquiry with Retaining Wall Supplies.</p>
        <p>Please see quotation below as requested, please check all is correct and what is required.</p>';


		do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
		do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
		do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );



	echo '<p>To complete your order successfully you can make EFT payment to:</p>
			<ul>
				<li>Bank: Commonwealth Bank</li>
				<li>Account Name: Retaining Wall Supplies</li>
				<li>BSB: 062 692</li>
				<li>Account: 7413 5799</li>
			</ul>
			<p>Please follow these steps:</p>
			<ol>
				<li>Confirm the order is correct (Please contact us immediately if you notice an error or want to make a change before making payment)</li>
				<li>Email us a remittance if paying by EFT.</li>
				<li>Avoid making product and delivery changes once payment has been made.</li>
			</ol>
			<p>If you prefer to pay by credit card, you\'ll need to receive an invoice with the credit card payment option, please be aware a 1.8% fee will apply.</p>
			<p>Once payment has been received, we will notify you of either your collection or delivery date.</p>
			<p class="footer">All products returned will incur a 40% restocking and administration fee. Any claim for incorrect or faulty goods must be made within 14 days of receipt of delivery. Please note: Product colours are for general guidance only and slight colour variations may occur. Retention of Title: All goods remain the property of Retaining Wall Supplies until such time as full payment has been received and cleared.</p>
			<p>You can view ALL our Terms and Conditions <a href="https://retainingwallsupplies.eunika.xyzterms-and-conditions/" class="highlight">HERE</a>.</p>
			<p>Regards,</p>
			<p>Retaining Wall Supplies</p>
    ';


    // Output the email footer.
    do_action( 'woocommerce_email_footer', $email );

} else {

	// Output the email header.
	do_action( 'woocommerce_email_header', $email_heading, $email );

	// Greet the customer.
	printf( '<p>' . esc_html__( 'Hi %s,', 'woocommerce' ) . '</p>', esc_html( $order->get_billing_first_name() ) );
	echo '<p>' . esc_html__( 'We have finished processing your order.', 'woocommerce' ) . '</p>';

    // Show order details, meta, customer details, and structured data.
    do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
    do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
    do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

    // Display user-defined additional content.
    if ( $additional_content ) {
        echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
    }

    // Output the email footer.
    do_action( 'woocommerce_email_footer', $email );
}
?>
