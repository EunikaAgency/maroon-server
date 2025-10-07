<?php
/**
 * Customer invoice email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Executes the e-mail header.
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<?php if ( $order->needs_payment() ) { ?>
	<p>
	<?php
	printf(
		wp_kses(
			/* translators: %1$s Site title, %2$s Order pay link */
			__( 'An order has been created for you on %1$s. Your invoice is below, with a link to make payment when you’re ready: %2$s', 'woocommerce' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		esc_html( get_bloginfo( 'name', 'display' ) ),
		'<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'woocommerce' ) . '</a>'
	);
	?>
	</p>

<?php } else { ?>


   



<p>Thank you for your inquiry with Retaining Wall Supplies, we look forward to offering you exceptional service and high-quality concrete sleepers.</p>
<p>Please find attached your invoice as requested, please check all is correct and what is required.</p>



<p>
	<?php
	/* translators: %s Order date */
	printf( esc_html__( 'Here are the details of your order placed on %s:', 'woocommerce' ), esc_html( wc_format_datetime( $order->get_date_created() ) ) );
	?>
	</p>

    <?php   
    
    do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );  
    do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
    do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

    
    ?>






<p><strong>To complete your order successfully you can make an EFT payment to:</strong></p>

<ul style="list-style-type: none;">
  <li>Commonwealth Bank</li>
  <li>Account Name: Retaining Wall Supplies</li>
  <li>BSB: 062 692</li>
  <li>Account: 7413 5799</li>
</ul>

<p>1. Confirm the order is correct (Please contact us immediately if you notice an error or want to make a change before making payment)</p>
<p>2. Email us a remittance if paying by EFT.</p>
<p>3. Avoid making product and delivery changes once made payment.</p>
<p>If you prefer to pay by credit card, you'll need to receive an invoice with the credit card payment option, please be aware a 1.8% fee will apply.</p>
<p>Once payment has been received, we will notify you of either your collection or delivery date.</p>
<p>You can view our Terms and Conditions <a href="https://retainingwallsupplies.eunika.xyzterms-and-conditions/">HERE</a>.</p>
<p>Regards, </p>

























	<?php
}





/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/**
 * Executes the email footer.
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */
// do_action( 'woocommerce_email_footer', $email );
