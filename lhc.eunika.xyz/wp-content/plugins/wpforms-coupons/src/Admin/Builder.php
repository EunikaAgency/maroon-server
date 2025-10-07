<?php

namespace WPFormsCoupons\Admin;

use WPFormsCoupons\Admin\Coupons\Edit;

/**
 * Coupons Builder class.
 *
 * @since 1.0.0
 */
class Builder {

	/**
	 * Define hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {

		add_action( 'wpforms_builder_enqueues', [ $this, 'enqueues' ] );
		add_action( 'wpforms_builder_strings', [ $this, 'strings' ], 10, 2 );
		add_action( 'wpforms_form_handler_duplicate_form', [ $this, 'duplicate_coupons' ], 10, 3 );
	}

	/**
	 * Enqueue builder assets.
	 *
	 * @since 1.0.0
	 */
	public function enqueues() {

		$min = wpforms_get_min_suffix();

		wp_enqueue_style(
			'wpforms-coupons-builder',
			WPFORMS_COUPONS_URL . "assets/css/builder{$min}.css",
			[ 'wpforms-builder' ],
			WPFORMS_COUPONS_VERSION
		);

		wp_enqueue_script(
			'wpforms-coupons-builder',
			WPFORMS_COUPONS_URL . "assets/js/builder{$min}.js",
			[ 'jquery' ],
			WPFORMS_COUPONS_VERSION
		);
	}

	/**
	 * Add builder strings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $strings Builder strings.
	 * @param array $form    Form data and settings.
	 *
	 * @return array
	 */
	public function strings( $strings, $form ) {

		$strings['coupons'] = [
			'button_text'        => esc_html__( 'Apply', 'wpforms-coupons' ),
			'no_coupons_title'   => esc_html__( 'No Coupons Exist', 'wpforms-coupons' ),
			'no_coupons_message' => esc_html__( 'Please create a new coupon to use the Coupon field on your form.', 'wpforms-coupons' ),
			'no_coupons_button'  => esc_html__( 'Get Started', 'wpforms-coupons' ),
			'add_new_coupon_url' => Edit::get_page_url(),
		];

		return $strings;
	}

	/**
	 * Duplicate coupons on form duplicate.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $id            Original form ID.
	 * @param int   $new_form_id   New form ID.
	 * @param array $new_form_data New form data.
	 */
	public function duplicate_coupons( $id, $new_form_id, $new_form_data ) {

		$form_coupons = wpforms_coupons()->get( 'repository' )->get_form_coupons( $id );

		if ( empty( $form_coupons ) ) {
			return;
		}

		wpforms_coupons()->get( 'repository' )->set_allowed_coupons( $new_form_id, $form_coupons );
	}
}
