<?php
/**
 * Custom Quotation and Payment Information email template
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); 

?>

<?php 

	$payment_method = $order->get_payment_method();
	if(	$payment_method == "purchase_order"	):

?>

				<!--  -->

				<?php /* translators: %s: Customer first name */ ?>
				<p><?php printf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

				<p><?php esc_html_e( 'Thank you for reaching out to Retaining Wall Supplies. Below is the quotation you requested. Please review it carefully to ensure all details are accurate and meet your requirements.', 'woocommerce' ); ?></p>

				<hr>

				<?php

				do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

				/*
				* @hooked WC_Emails::order_meta() Shows order meta data.
				*/
				do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

				/*
				* @hooked WC_Emails::customer_details() Shows customer details
				* @hooked WC_Emails::email_address() Shows email address
				*/
				do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

				?>

				<hr>

				<p><?php esc_html_e( 'To proceed with your order successfully, kindly make an EFT payment to the following details:', 'woocommerce' ); ?></p>

				<p>
					<?php esc_html_e( 'Commonwealth Bank', 'woocommerce' ); ?><br>
					<?php esc_html_e( 'Account Name: Retaining Wall Supplies', 'woocommerce' ); ?><br>
					<?php esc_html_e( 'BSB: 062 692', 'woocommerce' ); ?><br>
					<?php esc_html_e( 'Account: 7413 5799', 'woocommerce' ); ?>
				</p>

				<p><?php esc_html_e( 'Here are the steps to complete your order:', 'woocommerce' ); ?></p>

				<ol>
					<li><?php esc_html_e( 'Confirm the accuracy of your order. Please contact us immediately if you notice any errors or wish to make changes before making payment.', 'woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Email us a remittance when paying via EFT.', 'woocommerce' ); ?></li>
					<li><?php esc_html_e( 'Avoid making product and delivery changes after payment.', 'woocommerce' ); ?></li>
				</ol>

				<p><?php esc_html_e( 'If you prefer to pay by credit card, please request an invoice with the credit card payment option. Note that a 1.8% fee will apply.', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'Upon receiving your payment, we will notify you of your collection or delivery date.', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'Please be aware that returning products will incur a 40% restocking and administration fee. Claims for incorrect or faulty goods must be reported within 14 days of delivery. Please note that product colors are for general guidance, and slight variations may occur. Retention of Title: All goods remain the property of Retaining Wall Supplies until full payment is received and cleared.', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'For a detailed overview of our Terms and Conditions, kindly visit our website.', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'If you have any further inquiries, feel free to contact us.', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'Best Regards,', 'woocommerce' ); ?></p>

				<p><?php esc_html_e( 'Retaining Wall Supplies', 'woocommerce' ); ?></p>


	<?php endif; ?>

	<?php if(	$payment_method != "purchase_order"	): ?>

						<?php /* translators: %s: Customer first name */ ?>
						<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
						<p><?php esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p>
						<?php

						/*
						* @hooked WC_Emails::order_details() Shows the order details table.
						* @hooked WC_Structured_Data::generate_order_data() Generates structured data.
						* @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
						* @since 2.5.0
						*/
						do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

						/*
						* @hooked WC_Emails::order_meta() Shows order meta data.
						*/
						do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

						/*
						* @hooked WC_Emails::customer_details() Shows customer details
						* @hooked WC_Emails::email_address() Shows email address
						*/
						do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

						/**
						 * Show user-defined additional content - this is set in each email's settings.
						 */
						if ( $additional_content ) {
							echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
						}

						
	 endif; 
	 ?>


<!--  -->
<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
