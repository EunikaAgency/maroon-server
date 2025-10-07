<?php

namespace WPFormsCoupons;

use WPForms\Forms\Fields\PaymentTotal;

/**
 * Coupons Field class.
 *
 * @since 1.0.0
 */
class Field extends \WPForms_Field {

	/**
	 * Define field type information.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Define field type information.
		$this->name     = esc_html__( 'Coupon', 'wpforms-coupons' );
		$this->keywords = esc_html__( 'discount, sale', 'wpforms-coupons' );
		$this->type     = 'payment-coupon';
		$this->icon     = 'fa-ticket';
		$this->order    = 100;
		$this->group    = 'payment';

		$this->hooks();
	}

	/**
	 * Define field hooks.
	 *
	 * @since 1.0.0
	 */
	private function hooks() {

		add_filter( 'wpforms_builder_field_button_attributes', [ $this, 'field_button_attributes' ], 9, 3 );
		add_filter( 'wpforms_field_new_display_duplicate_button', [ $this, 'field_display_duplicate_button' ], 10, 2 );
		add_filter( 'wpforms_field_preview_display_duplicate_button', [ $this, 'field_display_duplicate_button' ], 10, 2 );
		add_filter( 'wpforms_process_filter', [ $this, 'calculate_total_discount' ], 5, 3 );
		add_filter( 'wpforms_calculations_process_filter', [ $this, 'post_calculation_field_processing' ], 10, 3 );
		add_action( 'wp_ajax_wpforms_coupons_apply_coupon', [ $this, 'ajax_apply_coupon' ] );
		add_action( 'wp_ajax_nopriv_wpforms_coupons_apply_coupon', [ $this, 'ajax_apply_coupon' ] );
		add_filter( 'wpforms_payment_fields', [ $this, 'add_to_payment_fields' ] );
		add_action( 'wpforms_process_complete', [ $this, 'post_process' ], 10, 4 );
		add_action( 'wpforms_process_payment_saved', [ $this, 'process_payment_saved' ], 10, 3 );
		add_filter( 'wpforms_forms_submission_prepare_payment_data', [ $this, 'prepare_payment_data' ], 20, 3 );
		add_filter( 'wpforms_process_payment_saved', [ $this, 'prepare_payment_meta' ], 20, 3 );
		add_filter( 'wpforms_save_form_args', [ $this, 'save_form' ], 11, 3 );
		add_filter( 'wpforms_get_form_fields_allowed', [ $this, 'add_coupon_field' ] );
		add_filter( 'wpforms_get_conditional_logic_form_fields_supported', [ $this, 'add_coupon_field' ] );
		add_filter( 'wpforms_conditional_logic_core_get_text_based_fields', [ $this, 'add_coupon_field' ] );

		// Define additional field properties.
		add_filter( 'wpforms_field_properties_payment-coupon', [ $this, 'field_properties' ], 5, 3 );

		// Paypal compatibility.
		add_filter( 'wpforms_paypal_redirect_args', [ $this, 'add_discount_paypal_standard' ], 10, 4 );
		add_filter( 'wpforms_paypal_commerce_process_single_ajax_get_types', [ $this, 'exclude_coupon_type' ] );
		add_filter( 'wpforms_paypal_commerce_process_single_ajax_order_data', [ $this, 'add_discount_paypal_commerce' ], 10, 3 );

		// Square compatibility.
		add_filter( 'wpforms_square_process_get_order_items_types', [ $this, 'exclude_coupon_type' ] );
		add_filter( 'wpforms_square_process_get_payment_args_single', [ $this, 'add_discount_args' ], 10, 2 );

		// Stripe compatibility.
		add_filter( 'wpforms_integrations_stripe_process_additional_metadata', [ $this, 'add_coupons_metadata' ], 10, 4 );

		// Order summary compatibility.
		add_filter( 'wpforms_forms_fields_payment_total_field_order_summary_preview_foot', [ $this, 'add_order_summary_fields' ] );
		add_filter( 'wpforms_forms_fields_payment_total_field_builder_order_summary_preview_foot', [ $this, 'add_order_summary_builder_fields' ], 10, 2 );
		add_filter( 'wpforms_forms_fields_payment_total_field_builder_order_summary_preview_total', [ $this, 'filter_order_summary_builder_total' ] );
		add_filter( 'wpforms_forms_fields_payment_total_field_builder_order_summary_preview_total_width', [ $this, 'filter_order_summary_builder_total_width' ] );
		add_filter( 'wpforms_smart_tags_smart_tag_order_summary_coupon_amount', [ $this, 'filter_coupon_amount' ], 10, 2 );
	}

	/**
	 * Add to payment fields list.
	 *
	 * @since 1.0.0
	 *
	 * @param array $payment_fields Payment fields.
	 *
	 * @return array
	 */
	public function add_to_payment_fields( $payment_fields ) {

		$payment_fields[] = $this->type;

		return $payment_fields;
	}

	/**
	 * Disallow field preview "Duplicate" button.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $display Display switch.
	 * @param array $field   Field settings.
	 *
	 * @return bool
	 */
	public function field_display_duplicate_button( $display, $field ) {

		return $field['type'] === $this->type ? false : $display;
	}

	/**
	 * Define additional field options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field data and settings.
	 */
	public function field_options( $field ) {

		$this->field_option( 'basic-options', $field, [ 'markup' => 'open' ] );

		$this->field_option( 'label', $field );

		$this->field_option( 'description', $field );

		$coupons      = wpforms_coupons()->get( 'repository' )->get_coupons(
			[
				'limit'  => -1,
				'fields' => 'id=>name',
			]
		);
		$form_coupons = wpforms_coupons()->get( 'repository' )->get_form_coupons( $this->get_form_id() );

		$warning             = sprintf(
			'<p class="wpforms-alert wpforms-alert-warning%1$s">%2$s</p>',
			empty( $form_coupons ) ? '' : ' wpforms-hidden',
			esc_html__( 'You haven\'t selected any coupons that can be used with this form. Please choose at least one coupon.', 'wpforms-coupons' )
		);
		$coupons_field_label = $this->field_element(
			'label',
			$field,
			[
				'slug'    => 'allowed_coupons',
				'value'   => esc_html__( 'Allowed Coupons', 'wpforms-coupons' ),
				'tooltip' => esc_html__( 'Choose coupons that can be used in the field.', 'wpforms-coupons' ),
			],
			false
		);
		$coupons_field       = $this->get_allowed_coupons_field( $coupons, $form_coupons, $field );
		$allowed_forms_json  = sprintf(
			'<input type="hidden" name="fields[%1$s][allowed_coupons_json]" class="wpforms-coupons-allowed_coupons_json" value="%2$s">',
			$field['id'],
			wp_json_encode( $form_coupons )
		);

		$this->field_element(
			'row',
			$field,
			[
				'slug'    => 'allowed_coupons',
				'content' => $coupons_field_label . $coupons_field . $allowed_forms_json . $warning,
			]
		);
		$this->field_option( 'required', $field );

		$this->field_option( 'basic-options', $field, [ 'markup' => 'close' ] );

		$this->field_option( 'advanced-options', $field, [ 'markup' => 'open' ] );

		$this->field_option( 'button_text', $field );

		$button_text_label = $this->field_element(
			'label',
			$field,
			[
				'slug'    => 'button_text',
				'value'   => esc_html__( 'Button Text', 'wpforms-coupons' ),
				'tooltip' => esc_html__( 'Change button text.', 'wpforms-coupons' ),
			],
			false
		);
		$button_text_field = $this->field_element(
			'text',
			$field,
			[
				'slug'  => 'button_text',
				'value' => isset( $field['button_text'] ) && ! wpforms_is_empty_string( $field['button_text'] )
					? $field['button_text']
					: esc_html__( 'Apply', 'wpforms-coupons' ),
			],
			false
		);

		$this->field_element(
			'row',
			$field,
			[
				'slug'    => 'button_text',
				'content' => $button_text_label . $button_text_field,
			]
		);
		$this->field_option( 'css', $field );
		$this->field_option( 'label_hide', $field );
		$this->field_option( 'advanced-options', $field, [ 'markup' => 'close' ] );
	}

	/**
	 * Get allowed coupons field.
	 *
	 * @since 1.0.0
	 *
	 * @param array $coupons      Coupons.
	 * @param array $form_coupons Form coupons.
	 * @param array $field        Field data.
	 *
	 * @return string
	 */
	private function get_allowed_coupons_field( $coupons, $form_coupons, $field ) {

		$output = sprintf( '<select id="wpforms-field-option-%1$d-%2$s" name="fields[%1$d][%2$s]" multiple>', $field['id'], 'allowed_coupons' );

		foreach ( $coupons as $arg_key => $arg_option ) {
			$selected = selected( true, in_array( $arg_key, $form_coupons, true ), false );
			$output  .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $arg_key ), $selected, $arg_option );
		}

		$output .= '</select>';

		return $output;
	}

	/**
	 * Field preview inside the builder.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field data.
	 */
	public function field_preview( $field ) {

		$this->field_preview_option( 'label', $field );
		$allowed_coupons = wpforms_coupons()->get( 'repository' )->get_form_coupons( $this->get_form_id() );

		printf(
			'<div class="wpforms-field-payment-coupon-wrapper">
				<input type="text" class="wpforms-field-payment-coupon-input">
				<button type="button" aria-live="assertive" class="wpforms-field-payment-coupon-button">%1$s</button>
				<i class="fa fa-exclamation-triangle%2$s"></i>
			</div>',
			esc_html( $this->get_button_text( $field ) ),
			empty( $allowed_coupons ) ? '' : ' wpforms-hidden'
		);

		$this->field_preview_option( 'description', $field );
	}

	/**
	 * Field display on the frontend.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field      Field data.
	 * @param array $field_atts Field attributes.
	 * @param array $form_data  Form data.
	 */
	public function field_display( $field, $field_atts, $form_data ) {

		$primary = $field['properties']['inputs']['primary'];

		$primary['class'][] = 'wpforms-field-payment-coupon-input';

		printf(
			'<div class="wpforms-field-payment-coupon-wrapper">
				<div class="wpforms-field-payment-coupon-input-wrapper">
					<input type="text" %1$s %2$s>
				</div>
				<button type="button" aria-live="assertive" class="wpforms-field-payment-coupon-button">%3$s</button>
			</div>
			<div class="wpforms-field-payment-coupon-applied-coupons"></div>',
			wpforms_html_attributes( $primary['id'], $primary['class'], $primary['data'], $primary['attr'] ),
			esc_attr( $primary['required'] ),
			esc_html( $this->get_button_text( $field ) )
		);
	}

	/**
	 * Get the apply button text.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field data.
	 *
	 * @return string
	 */
	private function get_button_text( $field ) {

		return isset( $field['button_text'] ) && ! wpforms_is_empty_string( $field['button_text'] )
			? $field['button_text']
			: __( 'Apply', 'wpforms-coupons' );
	}

	/**
	 * Define additional "Add Field" button attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes Add Field button attributes.
	 * @param array $field      Field settings.
	 * @param array $form_data  Form data and settings.
	 *
	 * @return array
	 */
	public function field_button_attributes( $attributes, $field, $form_data ) {

		if ( $field['type'] !== $this->type ) {
			return $attributes;
		}

		if ( ! wpforms_coupons()->get( 'repository' )->has_coupons( 'publish' ) ) {
			$attributes['class'][] = 'wpforms-add-fields-button-no-coupons';

			return $attributes;
		}

		if ( $this->has_field( $form_data ) ) {
			$attributes['class'][] = 'wpforms-add-fields-button-disabled';

			return $attributes;
		}

		return $attributes;
	}

	/**
	 * Check if the form has a coupon field.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form_data Form data and settings.
	 *
	 * @return bool
	 */
	private function has_field( $form_data ) {

		foreach ( $form_data['fields'] as $field ) {
			if ( $field['type'] === $this->type ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Apply coupon via AJAX.
	 *
	 * @since 1.0.0
	 */
	public function ajax_apply_coupon() {

		// phpcs:disable WordPress.Security.NonceVerification.Missing
		$form_id     = ! empty( $_POST['form_id'] ) ? absint( $_POST['form_id'] ) : 0;
		$coupon_code = ! empty( $_POST['coupon_code'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['coupon_code'] ) ) ) : 0;
		// phpcs:enable WordPress.Security.NonceVerification.Missing

		$coupon        = wpforms_coupons()->get( 'repository' )->get_coupon_by_code( $coupon_code );
		$error_message = wpforms_setting( 'coupon-invalid', esc_html__( 'This is not a valid coupon.', 'wpforms-coupons' ) );

		if ( empty( $form_id ) || empty( $coupon_code ) || $coupon === null ) {
			wp_send_json_error( $error_message, 400 );
		}

		if ( ! $coupon->is_valid( $form_id ) ) {
			wp_send_json_error( $error_message, 400 );
		}

		wp_send_json_success(
			[
				'formatted_code' => $coupon->get_code(),
				'value'          => $coupon->get_discount_amount(),
				'type'           => $coupon->get_discount_type(),
			]
		);
	}

	/**
	 * Validate field on form submit.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $field_id     Field ID.
	 * @param mixed $field_submit Field value that was submitted.
	 * @param array $form_data    Form data and settings.
	 */
	public function validate( $field_id, $field_submit, $form_data ) {

		// Check is the field required.
		parent::validate( $field_id, $field_submit, $form_data );

		if ( empty( $field_submit ) ) {
			return;
		}

		$form_id       = absint( $form_data['id'] );
		$coupon        = wpforms_coupons()->get( 'repository' )->get_coupon_by_code( $field_submit );
		$error_message = wpforms_setting( 'coupon-invalid', esc_html__( 'This is not a valid coupon.', 'wpforms-coupons' ) );

		if ( $coupon === null || ! $coupon->is_valid( $form_id ) ) {
			wpforms()->get( 'process' )->errors[ $form_id ][ $field_id ] = $error_message;
		}
	}

	/**
	 * Format and sanitize field.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $field_id     Field ID.
	 * @param mixed $field_submit Field value that was submitted.
	 * @param array $form_data    Form data and settings.
	 */
	public function format( $field_id, $field_submit, $form_data ) {

		// Define data.
		$name        = ! empty( $form_data['fields'][ $field_id ]['label'] ) ? $form_data['fields'][ $field_id ]['label'] : '';
		$coupon_code = sanitize_text_field( $field_submit );
		$coupon      = ! empty( $coupon_code ) ? wpforms_coupons()->get( 'repository' )->get_coupon_by_code( $coupon_code ) : null;

		wpforms()->get( 'process' )->fields[ $field_id ] = [
			'name'       => sanitize_text_field( $name ),
			'coupon_id'  => $coupon ? $coupon->get_id() : 0,
			'value'      => sanitize_text_field( $coupon_code ),
			// We calculate amount later when all fields are formatted.
			'amount'     => 0,
			'amount_raw' => 0,
			'id'         => absint( $field_id ),
			'type'       => $this->type,
		];
	}

	/**
	 * Do not trust the posted total since that relies on javascript.
	 * Instead, we re-calculate server side.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields    List of fields with their data.
	 * @param array $entry     Submitted form data.
	 * @param array $form_data Form data and settings.
	 *
	 * @return array
	 */
	public function calculate_total_discount( $fields, $entry, $form_data ) {

		$coupon_fields = $this->get_coupon_fields( $fields );

		// No coupon fields found. We can return early.
		if ( empty( $coupon_fields ) ) {
			return $fields;
		}

		// Calculate the total amount without coupons.
		// It is needed to be able to calculate the discount amount after executing other calculations.
		$fields_wo_coupons = array_diff_key( $fields, $coupon_fields );
		$total             = wpforms_get_total_payment( $fields_wo_coupons );

		foreach ( $coupon_fields as $field_id => $field ) {
			if ( empty( $field['coupon_id'] ) ) {
				continue;
			}

			$coupon = wpforms_coupons()->get( 'repository' )->get_coupon_by_id( $field['coupon_id'] );

			if ( $coupon === null ) {
				continue;
			}

			$type   = $coupon->get_discount_type();
			$amount = $coupon->get_discount_amount();

			if ( $type === 'flat' ) {
				$fields[ $field_id ]['amount']     = wpforms_format_amount( $amount * - 1 );
				$fields[ $field_id ]['amount_raw'] = $amount * - 1;

				continue;
			}

			$discount = wpforms_sanitize_amount( $amount * $total / 100 );

			$fields[ $field_id ]['amount']     = wpforms_format_amount( $discount * - 1 );
			$fields[ $field_id ]['amount_raw'] = $discount * - 1;
		}

		return $fields;
	}

	/**
	 * Re-calculate discount and total amount after calculations.
	 *
	 * @since 1.3.0
	 *
	 * @param array $fields    List of fields with their data.
	 * @param array $entry     Submitted form data.
	 * @param array $form_data Form data and settings.
	 *
	 * @return array
	 */
	public function post_calculation_field_processing( $fields, $entry, $form_data ): array {

		$fields = $this->calculate_total_discount( $fields, $entry, $form_data );
		$fields = PaymentTotal\Field::calculate_total_static( $fields, $entry, $form_data );

		return (array) $fields;
	}

	/**
	 * Run post-processing when entry and payment are created.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields    Fields data.
	 * @param array $entry     User submitted data.
	 * @param array $form_data Form data.
	 * @param int   $entry_id  Entry ID.
	 */
	public function post_process( $fields, $entry, $form_data, $entry_id ) {

		$coupon_fields = $this->get_coupon_fields( $fields );

		foreach ( $coupon_fields as $field ) {
			if ( empty( $field['coupon_id'] ) ) {
				continue;
			}

			$repository = wpforms_coupons()->get( 'repository' );
			$coupon     = $repository->get_coupon_by_id( $field['coupon_id'] );

			if ( $coupon === null ) {
				continue;
			}

			$repository->update_coupon_usage_count( $coupon->get_id(), $form_data['id'] );

			if ( $coupon->get_usage_limit() !== null && ( $coupon->get_usage_count() + 1 >= $coupon->get_usage_limit() ) ) {
				$repository->update(
					$coupon->get_id(),
					[
						'allowed_forms'       => array_keys( $coupon->get_allowed_forms() ),
						'is_global'           => $coupon->get_is_global(),
						'usage_limit_reached' => 1,
					]
				);
			}
		}
	}

	/**
	 * Run post-processing when payment is saved.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $payment_id Payment ID.
	 * @param array $fields     Fields data.
	 * @param array $form_data  Form data.
	 */
	public function process_payment_saved( $payment_id, $fields, $form_data ) {

		$coupon_fields = $this->get_coupon_fields( $fields );

		foreach ( $coupon_fields as $field ) {

			if ( empty( $field['coupon_id'] ) ) {
				continue;
			}

			$repository = wpforms_coupons()->get( 'repository' );
			$coupon     = $repository->get_coupon_by_id( $field['coupon_id'] );

			if ( $coupon === null ) {
				continue;
			}

			$repository->update_coupon_payment_count( $coupon->get_id(), $form_data['id'] );
		}
	}

	/**
	 * Add details to payment data.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data             Payment data args.
	 * @param array $submitted_fields Final/sanitized submitted field data.
	 * @param array $form_data        Form data and settings.
	 *
	 * @return array
	 */
	public function prepare_payment_data( $data, $submitted_fields, $form_data ) {

		$coupon_fields = $this->get_coupon_fields( $submitted_fields );

		if ( empty( $coupon_fields ) ) {
			return $data;
		}

		$non_coupon_fields = array_diff_key( $submitted_fields, $coupon_fields );
		$subtotal          = wpforms_get_total_payment( $non_coupon_fields );
		$total             = wpforms_sanitize_amount( $data['total_amount'] );
		$discount          = wpforms_sanitize_amount( $subtotal - $total );

		$data['subtotal_amount'] = $subtotal;
		$data['discount_amount'] = $discount;

		return $data;
	}

	/**
	 * Add meta for a successful payment.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $payment_id Payment ID.
	 * @param array $fields     Final/sanitized submitted field data.
	 * @param array $form_data  Form data and settings.
	 */
	public function prepare_payment_meta( $payment_id, $fields, $form_data ) {

		$coupon_fields = $this->get_coupon_fields( $fields );

		if ( empty( $coupon_fields ) ) {
			return;
		}

		$non_coupon_fields = array_diff_key( $fields, $coupon_fields );
		$subtotal          = wpforms_get_total_payment( $non_coupon_fields );

		foreach ( $coupon_fields as $field ) {

			if ( empty( $field['coupon_id'] ) ) {
				continue;
			}

			$coupon = wpforms_coupons()->get( 'repository' )->get_coupon_by_id( $field['coupon_id'] );

			if ( $coupon === null ) {
				continue;
			}

			wpforms()->get( 'payment_meta' )->add_log(
				$payment_id,
				sprintf( /* translators: %s - applied coupon code. */
					__( 'The %s coupon was applied', 'wpforms-coupons' ),
					$coupon->get_code()
				)
			);

			wpforms()->get( 'payment_meta' )->add(
				[
					'payment_id' => $payment_id,
					'meta_key'   => 'coupon_id',
					'meta_value' => $coupon->get_id(),
				]
			);

			wpforms()->get( 'payment_meta' )->add(
				[
					'payment_id' => $payment_id,
					'meta_key'   => 'coupon_info',
					'meta_value' => $coupon->get_payment_info( $subtotal ),
				]
			);

			wpforms()->get( 'payment_meta' )->add(
				[
					'payment_id' => $payment_id,
					'meta_key'   => 'coupon_value',
					'meta_value' => $coupon->get_formatted_amount(),
				]
			);
		}
	}

	/**
	 * Link selected coupons to the form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form Form array which is usable with `wp_update_post()`.
	 * @param array $data Data retrieved from $_POST and processed.
	 * @param array $args Empty by default, may contain custom data not intended to be saved, but used for processing.
	 *
	 * @return array
	 */
	public function save_form( $form, $data, $args ) {

		$form_data = json_decode( stripslashes( $form['post_content'] ), true );

		if ( empty( $form_data['fields'] ) ) {
			return $form;
		}

		$coupon_fields = $this->get_coupon_fields( $form_data['fields'] );

		foreach ( $coupon_fields as $key => $field ) {

			if ( ! isset( $field['allowed_coupons_json'] ) ) {
				continue;
			}

			$allowed_coupons = (array) json_decode( wp_unslash( $field['allowed_coupons_json'] ), true );
			$allowed_coupons = array_map( 'absint', $allowed_coupons );

			wpforms_coupons()->get( 'repository' )->set_allowed_coupons( $form_data['id'], $allowed_coupons );

			unset( $form_data['fields'][ $key ]['allowed_coupons'], $form_data['fields'][ $key ]['allowed_coupons_json'] );
		}

		$form['post_content'] = wpforms_encode( $form_data );

		return $form;
	}

	/**
	 * Add coupon field to the list.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields_supported Supported fields.
	 *
	 * @return array
	 */
	public function add_coupon_field( $fields_supported ) {

		$fields_supported[] = $this->type;

		return $fields_supported;
	}

	/**
	 * Get only coupon fields.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields Fields.
	 *
	 * @return array
	 */
	private function get_coupon_fields( $fields ) {

		$coupon_fields = [];

		foreach ( $fields as $key => $field ) {

			if ( empty( $field['type'] ) || $field['type'] !== $this->type ) {
				continue;
			}

			$coupon_fields[ $key ] = $field;
		}

		return $coupon_fields;
	}

	/**
	 * Add required class to the field.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties List field properties.
	 * @param array $field      Field data and settings.
	 * @param array $form_data  Form data and settings.
	 *
	 * @return array
	 */
	public function field_properties( $properties, $field, $form_data ) {

		if ( ! empty( $properties['inputs']['primary']['required'] ) ) {
			$properties['inputs']['primary']['class'][] = 'wpforms-field-required';
		}

		$properties['inputs']['primary']['data']['rule-coupon'] = true;

		return $properties;
	}

	/**
	 * Add discount for PayPal Standard.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args             PayPal Standard redirect URL arguments.
	 * @param array $submitted_fields Submitted fields.
	 * @param array $form_data        Form data and settings.
	 * @param int   $entry_id         Entry ID.
	 *
	 * @return array
	 */
	public function add_discount_paypal_standard( $args, $submitted_fields, $form_data, $entry_id ) {

		$coupon_fields = $this->get_coupon_fields( $form_data['fields'] );

		if ( empty( $coupon_fields ) ) {
			return $args;
		}

		foreach ( $coupon_fields as $field_id => $field ) {
			if ( empty( $submitted_fields[ $field_id ]['amount_raw'] ) ) {
				continue;
			}

			$args['discount_amount_cart'] = wpforms_sanitize_amount( $submitted_fields[ $field_id ]['amount_raw'] * - 1 );
		}

		return $args;
	}

	/**
	 * Add discount for PayPal Commerce.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $data      PayPal Commerce data.
	 * @param array  $form_data Form data and settings.
	 * @param string $amount    Total amount with discount.
	 *
	 * @return array
	 */
	public function add_discount_paypal_commerce( $data, $form_data, $amount ) {

		$coupon_fields = $this->get_coupon_fields( $form_data['fields'] );

		if ( empty( $coupon_fields ) ) {
			return $data;
		}

		if ( empty( $data['purchase_units'][0]['items'] ) ) {
			return $data;
		}

		$unit_amount = 0;

		// Calculate total amount of items.
		foreach ( $data['purchase_units'][0]['items'] as $item ) {
			$unit_amount += (float) wpforms_sanitize_amount( $item['unit_amount']['value'] ) * $item['quantity'];
		}

		$unit_amount = wpforms_sanitize_amount( $unit_amount );
		$unit_amount = max( 0, $unit_amount );

		if ( $unit_amount === $amount ) {
			return $data;
		}

		$discount = wpforms_sanitize_amount( $unit_amount - $amount );

		$data['purchase_units'][0]['amount']['breakdown']['item_total']['value']       = $unit_amount;
		$data['purchase_units'][0]['amount']['breakdown']['discount']['value']         = $discount;
		$data['purchase_units'][0]['amount']['breakdown']['discount']['currency_code'] = wpforms_get_currency();

		return $data;
	}

	/**
	 * Exclude a coupon type from the list.
	 *
	 * @since 1.0.0
	 *
	 * @param array $types List of field types.
	 *
	 * @return array
	 */
	public function exclude_coupon_type( $types ) {

		foreach ( $types as $key => $type ) {
			if ( $type === $this->type ) {
				unset( $types[ $key ] );
			}
		}

		return $types;
	}

	/**
	 * Add discount for Square.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args    Single payment arguments.
	 * @param object $process Square process object.
	 *
	 * @return array
	 */
	public function add_discount_args( $args, $process ) {

		$coupon_fields = $this->get_coupon_fields( $process->fields );

		if ( empty( $coupon_fields ) ) {
			return $args;
		}

		$discounts = [];

		foreach ( $coupon_fields as $coupon ) {
			$discounts[] = [
				'name'   => $coupon['name'],
				'amount' => wpforms_sanitize_amount( $coupon['amount_raw'] * - 100 ),
			];
		}

		$discounts = array_filter(
			$discounts,
			static function ( $discount ) {

				return ! empty( $discount['amount'] );
			}
		);

		if ( ! empty( $discounts ) ) {
			$args['discounts'] = $discounts;
		}

		return $args;
	}

	/**
	 * Add additional payment metadata to the Stripe payment.
	 *
	 * @since 1.0.0
	 *
	 * @param array $additional_meta Additional metadata.
	 * @param int   $payment_id      Payment ID.
	 * @param array $fields          Final/sanitized submitted field data.
	 * @param array $form_data       Form data and settings.
	 *
	 * @return array
	 */
	public function add_coupons_metadata( $additional_meta, $payment_id, $fields, $form_data ) {

		$coupon_fields = $this->get_coupon_fields( $fields );

		if ( empty( $coupon_fields ) ) {
			return $additional_meta;
		}

		$non_coupon_fields = array_diff_key( $fields, $coupon_fields );
		$subtotal          = wpforms_get_total_payment( $non_coupon_fields );

		foreach ( $coupon_fields as $field ) {

			if ( empty( $field['coupon_id'] ) ) {
				continue;
			}

			$coupon = wpforms_coupons()->get( 'repository' )->get_coupon_by_id( $field['coupon_id'] );

			if ( $coupon === null ) {
				continue;
			}

			$additional_meta[ 'payment_coupon_' . $field['coupon_id'] ] = $coupon->get_name() . "\n" . html_entity_decode( $coupon->get_payment_info( $subtotal ) );
		}

		return $additional_meta;

	}

	/**
	 * Get form ID. In AJAX requests the $form_id property doesn't exist.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|int
	 */
	private function get_form_id() {

		if ( $this->form_id ) {
			return $this->form_id;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$this->form_id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : false;

		return $this->form_id;
	}

	/**
	 * Add coupon fields into a footer of the order summary table.
	 *
	 * @since 1.2.0
	 *
	 * @param array $fields Fields data.
	 *
	 * @return array
	 */
	public function add_order_summary_fields( array $fields ): array {

		$fields[] = [
			'label'     => __( 'Subtotal', 'wpforms-coupons' ),
			'quantity'  => '',
			'amount'    => '',
			'is_hidden' => true,
			'class'     => [ 'wpforms-order-summary-preview-subtotal' ],
		];

		$fields[] = [
			'label'     => '',
			'quantity'  => '',
			'amount'    => '',
			'is_hidden' => true,
			'class'     => [ 'wpforms-order-summary-preview-coupon-total' ],
		];

		return $fields;
	}

	/**
	 * Add coupon fields into a footer of the order summary table (builder screen).
	 *
	 * @since 1.2.0
	 *
	 * @param array $foot  Items of the order summary footer.
	 * @param int   $total Fields total.
	 *
	 * @return array
	 */
	public function add_order_summary_builder_fields( array $foot, int $total ): array {

		$foot[] = [
			'label'    => __( 'Subtotal', 'wpforms-coupons' ),
			'quantity' => '',
			'amount'   => wpforms_format_amount( $total, true ),
			'class'    => 'wpforms-order-summary-preview-subtotal',
		];

		$foot[] = [
			'label'    => __( 'Coupon (EXAMPLE50)', 'wpforms-coupons' ),
			'quantity' => '',
			'amount'   => '-50% (' . wpforms_format_amount( $total / 2, true ) . ')',
			'class'    => 'wpforms-order-summary-preview-coupon-total',
		];

		return $foot;
	}

	/**
	 * Filter builder total amount.
	 *
	 * @since 1.2.0
	 *
	 * @param int $total Fields total.
	 *
	 * @return int
	 */
	public function filter_order_summary_builder_total( int $total ): int {

		return $total / 2; // phpcs:ignore WPForms.Formatting.EmptyLineBeforeReturn.RemoveEmptyLineBeforeReturnStatement
	}

	/**
	 * Filter builder total width.
	 *
	 * @since 1.2.0
	 *
	 * @param int $total_width Fields total width.
	 *
	 * @return int
	 */
	public function filter_order_summary_builder_total_width( int $total_width ): int {

		return $total_width + 4; // phpcs:ignore WPForms.Formatting.EmptyLineBeforeReturn.RemoveEmptyLineBeforeReturnStatement
	}

	/**
	 * Filter order summary coupon amount.
	 *
	 * @since 1.2.0
	 *
	 * @param string $coupon_amount Coupon amount.
	 * @param array  $coupon        Coupon data.
	 *
	 * @return string Formatted amount.
	 */
	public function filter_coupon_amount( string $coupon_amount, array $coupon ): string {

		$coupon_data = wpforms_coupons()->get( 'repository' )->get_coupon_by_id( $coupon['coupon_id'] );

		if ( empty( $coupon_data ) || $coupon_data->get_discount_type() !== 'percentage' ) {
			return $coupon_amount;
		}

		// Convert amount to positive for `percentage` type.
		$coupon_amount = wpforms_format_amount( abs( $coupon['amount_raw'] ), true );

		return '-' . $coupon_data->get_discount_amount() . '% (' . $coupon_amount . ')';
	}
}
