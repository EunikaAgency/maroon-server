<?php
/**
 *
 * Attribute swatches module
 *
 * @package CommerceKit
 * @subpackage Shoptimizer
 */

/**
 * Attribute swatches options html.
 *
 * @param string $html HTML of dropdowns.
 * @param array  $args other arguments.
 */
function commercekit_attribute_swatches_options_html( $html, $args ) {
	global $product;

	if ( commercegurus_as_is_wc_composite_product() ) {
		return $html;
	}

	if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
		return $html;
	}

	if ( empty( $args['options'] ) ) {
		return $html;
	}

	$arg_product = isset( $args['product'] ) ? $args['product'] : $product;
	$product_id  = $arg_product->get_id();

	$attribute_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
	if ( ! is_array( $attribute_swatches ) ) {
		$attribute_swatches = array();
	}
	if ( isset( $attribute_swatches['enable_product'] ) && 0 === (int) $attribute_swatches['enable_product'] ) {
		return $html;
	}
	$commercekit_options = get_option( 'commercekit', array() );

	$attribute_raw  = sanitize_title( $args['attribute'] );
	$attribute_name = commercekit_as_get_attribute_slug( $attribute_raw, true );

	$is_taxonomy = true;
	$attr_terms  = wc_get_product_terms(
		$product->get_id(),
		$args['attribute'],
		array(
			'fields' => 'all',
		)
	);
	if ( ! count( $attr_terms ) ) {
		$_options = $args['options'];
		if ( count( $_options ) ) {
			$is_taxonomy = false;
			foreach ( $_options as $_option ) {
				$attr_terms[] = (object) array(
					'name'    => $_option,
					'slug'    => sanitize_title( $_option ),
					'term_id' => $_option,
				);
			}
		}
	}
	if ( ! count( $attr_terms ) ) {
		return $html;
	}

	$attribute_id = $is_taxonomy ? wc_attribute_taxonomy_id_by_name( $args['attribute'] ) : sanitize_title( $args['attribute'] );
	$swatch_type  = isset( $attribute_swatches[ $attribute_id ]['cgkit_type'] ) ? $attribute_swatches[ $attribute_id ]['cgkit_type'] : 'button';
	if ( empty( $swatch_type ) ) {
		return $html;
	}
	$as_quickadd_txt = isset( $commercekit_options['as_quickadd_txt'] ) && ! empty( $commercekit_options['as_quickadd_txt'] ) ? commercekit_get_multilingual_string( stripslashes_deep( $commercekit_options['as_quickadd_txt'] ) ) : commercekit_get_default_settings( 'as_quickadd_txt' );
	$as_more_opt_txt = isset( $commercekit_options['as_more_opt_txt'] ) && ! empty( $commercekit_options['as_more_opt_txt'] ) ? commercekit_get_multilingual_string( stripslashes_deep( $commercekit_options['as_more_opt_txt'] ) ) : commercekit_get_default_settings( 'as_more_opt_txt' );
	$as_activate_atc = isset( $commercekit_options['as_activate_atc'] ) && 1 === (int) $commercekit_options['as_activate_atc'] ? true : false;
	$as_button_style = isset( $commercekit_options['as_button_style'] ) && 1 === (int) $commercekit_options['as_button_style'] ? true : false;
	$attr_count      = isset( $args['attr_count'] ) ? (int) $args['attr_count'] : 2;
	$attr_index      = isset( $args['attr_index'] ) ? (int) $args['attr_index'] : 1;
	if ( 2 < $attr_count || ! $as_activate_atc ) {
		$as_quickadd_txt = $as_more_opt_txt;
	}

	$single_attribute = false;
	$single_attr_oos  = array();

	$_variations = array();
	$_variations = array();
	$_var_images = array();
	$_gal_images = array();
	$any_attrib  = false;
	$variations  = $product->get_available_variations();
	if ( is_array( $variations ) && count( $variations ) ) {
		foreach ( $variations as $variation ) {
			if ( isset( $variation['attributes'] ) && count( $variation['attributes'] ) ) {
				$variation_img_id = get_post_thumbnail_id( $variation['variation_id'] );
				foreach ( $variation['attributes'] as $a_key => $a_value ) {
					$a_key = str_ireplace( 'attribute_', '', $a_key );

					$_variations[ $a_key ][] = $a_value;
					if ( $variation_img_id ) {
						$_var_images[ $a_key ][ $a_value ] = $variation_img_id;
					}
					if ( '' === $a_value ) {
						$any_attrib = true;
					} else {
						if ( 1 === count( $variation['attributes'] ) ) {
							$single_attribute = true;
							if ( isset( $variation['is_in_stock'] ) && 1 !== (int) $variation['is_in_stock'] ) {
								$single_attr_oos[ $a_key ][ $a_value ] = true;
							}
						}
					}
				}
			}
		}
		$cgkit_image_gallery = get_post_meta( $product_id, 'commercekit_image_gallery', true );
		if ( is_array( $cgkit_image_gallery ) ) {
			$cgkit_image_gallery = array_filter( $cgkit_image_gallery );
		}
		if ( is_array( $cgkit_image_gallery ) && count( $cgkit_image_gallery ) ) {
			foreach ( $cgkit_image_gallery as $slug => $image_gallery ) {
				if ( 'global_gallery' === $slug ) {
					continue;
				}
				$images = explode( ',', trim( $image_gallery ) );
				if ( isset( $images[0] ) && ! empty( $images[0] ) ) {
					$slugs = explode( '_cgkit_', $slug );
					if ( count( $slugs ) ) {
						foreach ( $slugs as $slg ) {
							$_gal_images[ $slg ] = $images[0];
						}
					}
				}
			}
		}
	} else {
		return $html;
	}
	$attribute_css  = isset( $args['css_class'] ) && ! empty( $args['css_class'] ) ? $args['css_class'] : 'cgkit-as-wrap';
	$item_class     = '';
	$item_wrp_class = '';
	$item_oos_text  = esc_html__( 'Out of stock', 'commercegurus-commercekit' );
	$swatches_html  = sprintf( '<div class="%s"><span class="cgkit-swatch-title">%s</span><ul class="cgkit-attribute-swatches %s" data-attribute="%s" data-no-selection="%s">', $attribute_css, $as_quickadd_txt, $item_wrp_class, $attribute_name, esc_html__( 'No selection', 'commercegurus-commercekit' ) );
	foreach ( $attr_terms as $item ) {
		if ( ! isset( $attribute_swatches[ $attribute_id ] ) ) {
			$attribute_swatches[ $attribute_id ] = array();
		}
		if ( ! isset( $attribute_swatches[ $attribute_id ][ $item->term_id ] ) ) {
			$attribute_swatches[ $attribute_id ][ $item->term_id ]['btn'] = $item->name;
		}
		if ( $is_taxonomy && ! in_array( $item->slug, $args['options'], true ) ) {
			continue;
		}
		if ( $is_taxonomy ) {
			if ( ! $any_attrib && ( ! isset( $_variations[ $attribute_raw ] ) || ! in_array( $item->slug, $_variations[ $attribute_raw ], true ) ) ) {
				continue;
			}
		} else {
			if ( ! $any_attrib && ( ! isset( $_variations[ $attribute_raw ] ) || ! in_array( $item->name, $_variations[ $attribute_raw ], true ) ) ) {
				continue;
			}
		}
		$item_attri_val = $is_taxonomy ? $item->slug : $item->name;
		$selected       = $args['selected'] === $item_attri_val ? 'cgkit-swatch-selected' : '';
		if ( $as_button_style && 'button' === $swatch_type ) {
			$selected .= ' button-fluid';
		}
		$swatch_html = commercekit_as_get_swatch_html( $swatch_type, $attribute_swatches[ $attribute_id ][ $item->term_id ], $item );
		$item_title  = 'button' === $swatch_type && isset( $attribute_swatches[ $attribute_id ][ $item->term_id ]['btn'] ) ? $attribute_swatches[ $attribute_id ][ $item->term_id ]['btn'] : $item->name;
		if ( isset( $single_attr_oos[ $attribute_raw ][ $item_attri_val ] ) && true === $single_attr_oos[ $attribute_raw ][ $item_attri_val ] ) {
			$selected  .= ' cgkit-as-outofstock';
			$item_title = $item_title . ' - ' . $item_oos_text;
		}
		if ( $single_attribute ) {
			$selected .= ' cgkit-as-single';
		}
		$item_tooltip = '';
		if ( in_array( $swatch_type, array( 'color', 'image' ), true ) ) {
			$item_tooltip = ' cgkit-tooltip="' . $item_title . '"';
		}
		$gal_img_slug   = is_numeric( $item->term_id ) ? $item->term_id : sanitize_title( $item->term_id );
		$item_gimg_id   = isset( $_gal_images[ $gal_img_slug ] ) ? $_gal_images[ $gal_img_slug ] : '';
		$swatches_html .= sprintf( '<li class="cgkit-attribute-swatch cgkit-%s %s" %s><button type="button" data-type="%s" data-attribute-value="%s" data-attribute-text="%s" aria-label="%s" data-oos-text="%s" title="%s" class="swatch cgkit-swatch %s" data-gimg_id="%s">%s</button></li>', $swatch_type, $item_class, $item_tooltip, $swatch_type, esc_attr( $item_attri_val ), esc_attr( $item->name ), esc_attr( $item_title ), $item_oos_text, esc_attr( $item_title ), $selected, $item_gimg_id, $swatch_html );
	}
	$swatches_html .= '</ul></div>';
	if ( isset( $args['css_class'] ) && 'cgkit-as-wrap-plp' === $args['css_class'] ) {
		$html = str_ireplace( ' id="', ' data-id="', $html );
	}
	$swatches_html .= sprintf( '<div style="display: none;">%s</div>', $html );

	return $swatches_html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'commercekit_attribute_swatches_options_html', 10, 2 );

/**
 * Attribute swatches attribute label.
 *
 * @param string $label attribute label.
 * @param string $name attribute name.
 */
function commercekit_attribute_swatches_attribute_label( $label, $name ) {
	global $product;
	if ( $product && method_exists( $product, 'is_type' ) && $product->is_type( 'variable' ) && is_product() ) {
		$attribute_swatches = get_post_meta( $product->get_id(), 'commercekit_attribute_swatches', true );
		if ( isset( $attribute_swatches['enable_product'] ) && 0 === (int) $attribute_swatches['enable_product'] ) {
			return $label;
		}
		$css_class = 'attribute_' . sanitize_title( $name );
		return sprintf( '<strong>%s</strong><span class="ckit-chosen-attribute_semicolon">:</span> <span class="cgkit-chosen-attribute %s no-selection">%s</span>', $label, $css_class, esc_html__( 'No selection', 'commercegurus-commercekit' ) );
	} else {
		return $label;
	}
}
add_filter( 'woocommerce_attribute_label', 'commercekit_attribute_swatches_attribute_label', 102, 2 );

/**
 * Attribute swatches get attribute slug.
 *
 * @param string $slug   slug of attribute.
 * @param bool   $prefix prefix of attribute.
 */
function commercekit_as_get_attribute_slug( $slug, $prefix = false ) {
	if ( ( 'pa_' !== substr( $slug, 0, 3 ) || $prefix ) && false === strpos( $slug, 'attribute_' ) ) {
		$slug = 'attribute_' . sanitize_title( $slug );
	}

	return $slug;
}

/**
 * Attribute swatches get swatch html.
 *
 * @param string $swatch_type type of swatch.
 * @param string $data data of attribute.
 * @param string $item data of term.
 */
function commercekit_as_get_swatch_html( $swatch_type, $data, $item ) {
	$swatch_html = '';

	if ( 'image' === $swatch_type ) {
		$image = null;
		if ( isset( $data['img'] ) && ! empty( $data['img'] ) ) {
			commercekit_as_generate_attachment_size( $data['img'], 'cgkit_image_swatch' );
			$image = wp_get_attachment_image_src( $data['img'], 'cgkit_image_swatch' );
		}
		if ( $image ) {
			$swatch_html = '<span class="cross">&nbsp;</span><img alt="' . esc_attr( $item->name ) . '" width="' . esc_attr( $image[1] ) . '" height="' . esc_attr( $image[2] ) . '" src="' . esc_url( $image[0] ) . '" />';
		} else {
			$swatch_html = '<span class="cross">&nbsp;</span>';
		}
	} elseif ( 'color' === $swatch_type ) {
		if ( isset( $data['clr'] ) && ! empty( $data['clr'] ) ) {
			$swatch_html = '<span class="cross">&nbsp;</span><span class="color-div" style="background-color: ' . esc_attr( $data['clr'] ) . ';" data-color="' . esc_attr( $data['clr'] ) . '" aria-hidden="true">&nbsp;' . esc_attr( $item->name ) . '</span>';
		} else {
			$swatch_html = '<span class="cross">&nbsp;</span><span class="color-div" style="" data-color="" aria-hidden="true">&nbsp;' . esc_attr( $item->name ) . '</span>';
		}
	} elseif ( 'button' === $swatch_type ) {
		if ( isset( $data['btn'] ) && ! empty( $data['btn'] ) ) {
			$swatch_html = '<span class="cross">&nbsp;</span>' . esc_attr( $data['btn'] );
		} else {
			$swatch_html = '<span class="cross">&nbsp;</span>';
		}
	}

	return $swatch_html;
}

/**
 * Add attribute swatches to product loop
 */
function commercekit_as_product_loop() {
	global $product;
	if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
		return;
	}
	$options       = get_option( 'commercekit', array() );
	$as_active_plp = isset( $options['attribute_swatches_plp'] ) && 1 === (int) $options['attribute_swatches_plp'] ? true : false;
	if ( ! $as_active_plp ) {
		return;
	}

	$product_id = $product ? $product->get_id() : 0;
	if ( ! $product_id ) {
		return;
	}

	$as_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
	if ( isset( $as_swatches['enable_product'] ) && 0 === (int) $as_swatches['enable_product'] ) {
		return;
	}

	$out_of_stock = get_post_meta( $product_id, '_stock_status', true );
	if ( 'outofstock' === $out_of_stock ) {
		return;
	}

	$enable_loop = ( isset( $as_swatches['enable_loop'] ) && 1 === (int) $as_swatches['enable_loop'] ) || ! isset( $as_swatches['enable_loop'] ) ? true : false;
	if ( ! $enable_loop ) {
		return;
	}
	wp_enqueue_script( 'wc-add-to-cart-variation' );

	if ( defined( 'COMMERCEKIT_SWATCHES_AJAX' ) && true === COMMERCEKIT_SWATCHES_AJAX ) {
		$cache_key     = 'cgkit_swatch_loop_form_' . $product_id;
		$swatches_html = get_transient( $cache_key );
		if ( ! isset( $_GET['cgkit-nocache'] ) && false !== $swatches_html ) { // phpcs:ignore
			echo apply_filters( 'cgkit_loop_swatches_ajax', $swatches_html, $product ); // phpcs:ignore
			return;
		}
		$swatches_html = commercekit_as_build_product_swatch_cache( $product, true, 'via PLP page' );
		echo apply_filters( 'cgkit_loop_swatches_ajax', $swatches_html, $product ); // phpcs:ignore
	} else {
		$cache_key3    = 'cgkit_swatch_loop_full_' . $product_id;
		$swatches_html = get_transient( $cache_key3 );
		if ( ! isset( $_GET['cgkit-nocache'] ) && false !== $swatches_html ) { // phpcs:ignore
			echo apply_filters( 'cgkit_loop_swatches', $swatches_html, $product ); // phpcs:ignore
			return;
		}
		$swatches_html = commercekit_as_build_product_swatch_cache( $product, true, 'via PLP page' );
		echo apply_filters( 'cgkit_loop_swatches', $swatches_html, $product ); // phpcs:ignore
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'commercekit_as_product_loop', 10 );

/**
 * Attribute swatches get loop swatch image.
 *
 * @param string $attachment_id image ID.
 */
function commercekit_as_get_loop_swatch_image( $attachment_id ) {
	$image_size = 'woocommerce_thumbnail';
	$swatch_img = wp_get_attachment_image_src( $attachment_id, $image_size );
	if ( ! $swatch_img ) {
		return false;
	}
	$swatch_image = array();
	$image_srcset = wp_get_attachment_image_srcset( $attachment_id, $image_size );
	$image_sizes  = wp_get_attachment_image_sizes( $attachment_id, $image_size );

	$swatch_image['src']    = isset( $swatch_img[0] ) ? $swatch_img[0] : '';
	$swatch_image['srcset'] = '';
	$swatch_image['sizes']  = '';
	if ( $image_srcset ) {
		$swatch_image['srcset'] = $image_srcset;
	}
	if ( $image_sizes ) {
		$swatch_image['sizes'] = $image_sizes;
	}
	return $swatch_image;
}

/**
 * Attribute swatches add image size.
 */
function commercekit_as_add_image_size() {
	add_image_size( 'cgkit_image_swatch', 100, 100, true );
}
add_action( 'init', 'commercekit_as_add_image_size' );

/**
 * Attribute swatches generate attachment size if not exist.
 *
 * @param string $attachment_id image ID.
 * @param string $size image size.
 */
function commercekit_as_generate_attachment_size( $attachment_id, $size ) {
	if ( ! function_exists( 'wp_crop_image' ) ) {
		include ABSPATH . 'wp-admin/includes/image.php';
	}

	$old_metadata = wp_get_attachment_metadata( $attachment_id );
	if ( isset( $old_metadata['sizes'][ $size ] ) ) {
		return;
	}

	$fullsizepath = get_attached_file( $attachment_id );
	if ( false === $fullsizepath || is_wp_error( $fullsizepath ) || ! file_exists( $fullsizepath ) ) {
		return;
	}

	$new_metadata = wp_generate_attachment_metadata( $attachment_id, $fullsizepath );
	if ( is_wp_error( $new_metadata ) || empty( $new_metadata ) ) {
		return;
	}

	wp_update_attachment_metadata( $attachment_id, $new_metadata );
}

/**
 * Get ajax products variations
 */
function commercegurus_get_ajax_as_variations() {
	$commercekit_nonce  = isset( $_POST['commercekit_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['commercekit_nonce'] ) ) : '';
	$verify_nonce       = wp_verify_nonce( $commercekit_nonce, 'commercekit_nonce' );
	$product_ids        = isset( $_POST['product_ids'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ) ) : '';
	$ajax               = array();
	$ajax['status']     = 1;
	$ajax['variations'] = array();
	$ajax['images']     = array();
	$product_ids        = explode( ',', $product_ids );
	$product_ids        = array_unique( $product_ids );
	if ( count( $product_ids ) ) {
		foreach ( $product_ids as $product_id ) {
			$cache_key2    = 'cgkit_swatch_loop_form_data_' . $product_id;
			$swatches_html = get_transient( $cache_key2 );
			if ( false !== $swatches_html ) {
				$swatches_data = json_decode( $swatches_html, true );

				$ajax['variations'][ $product_id ] = isset( $swatches_data['variations'] ) ? wp_json_encode( $swatches_data['variations'] ) : '';
				$ajax['images'][ $product_id ]     = isset( $swatches_data['images'] ) ? wp_json_encode( $swatches_data['images'] ) : '';
			} else {
				$ajax['variations'][ $product_id ] = '';
				$ajax['images'][ $product_id ]     = '';
			}
		}
	}
	wp_send_json( $ajax );
}
add_action( 'wp_ajax_commercekit_get_ajax_as_variations', 'commercegurus_get_ajax_as_variations' );
add_action( 'wp_ajax_nopriv_commercekit_get_ajax_as_variations', 'commercegurus_get_ajax_as_variations' );

/**
 * Ajax add to cart.
 */
function commercegurus_ajax_as_add_to_cart() {
	$ajax            = array();
	$ajax['status']  = 0;
	$ajax['notices'] = '';
	$ajax['message'] = esc_html__( 'Error on adding to cart.', 'commercegurus-commercekit' );

	$nonce        = wp_verify_nonce( 'commercekit_nonce', 'commercekit_nonce' );
	$product_id   = isset( $_POST['product_id'] ) ? (int) sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : 0;
	$variation_id = isset( $_POST['variation_id'] ) ? (int) sanitize_text_field( wp_unslash( $_POST['variation_id'] ) ) : 0;
	$variations   = isset( $_POST['variations'] ) ? $_POST['variations'] : array(); // phpcs:ignore
	if ( $product_id && $variation_id ) {
		if ( WC()->cart->add_to_cart( $product_id, 1, $variation_id, $variations ) ) {
			$ajax['status']  = 1;
			$ajax['message'] = esc_html__( 'Sucessfully added to cart.', 'commercegurus-commercekit' );

			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();

			$ajax['fragments'] = apply_filters(
				'woocommerce_add_to_cart_fragments',
				array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
				)
			);
			$ajax['cart_hash'] = WC()->cart->get_cart_hash();
		} else {
			ob_start();
			wc_print_notices();
			$notices = ob_get_clean();

			$ajax['notices'] = $notices;
		}
	}

	wp_send_json( $ajax );
}
add_action( 'wp_ajax_commercekit_ajax_as_add_to_cart', 'commercegurus_ajax_as_add_to_cart' );
add_action( 'wp_ajax_nopriv_commercekit_ajax_as_add_to_cart', 'commercegurus_ajax_as_add_to_cart' );

/**
 * Attribute swatches loop add to cart link.
 *
 * @param string $html    link html.
 * @param string $product product object.
 */
function commercegurus_as_loop_add_to_cart_link( $html, $product ) {
	$options       = get_option( 'commercekit', array() );
	$as_active_plp = isset( $options['attribute_swatches_plp'] ) && 1 === (int) $options['attribute_swatches_plp'] ? true : false;
	if ( ! $as_active_plp ) {
		return $html;
	}
	$hide_button = true;
	if ( $hide_button && $product && ( method_exists( $product, 'is_type' ) && $product->is_type( 'variable' ) ) ) {
		$product_id   = $product ? $product->get_id() : 0;
		$out_of_stock = get_post_meta( $product_id, '_stock_status', true );
		if ( 'outofstock' === $out_of_stock ) {
			return $html;
		}
		$as_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
		if ( isset( $as_swatches['enable_product'] ) && 0 === (int) $as_swatches['enable_product'] ) {
			return $html;
		}
		$enable_loop = ( isset( $as_swatches['enable_loop'] ) && 1 === (int) $as_swatches['enable_loop'] ) || ! isset( $as_swatches['enable_loop'] ) ? true : false;
		if ( ! $enable_loop ) {
			return $html;
		}
		$as_activate_atc  = isset( $options['as_activate_atc'] ) && 1 === (int) $options['as_activate_atc'] ? true : false;
		$single_attribute = false;
		$variations       = $product->get_available_variations();
		if ( is_array( $variations ) && count( $variations ) ) {
			foreach ( $variations as $variation ) {
				if ( isset( $variation['attributes'] ) && 1 === count( $variation['attributes'] ) ) {
					$single_attribute = true;
				}
				break;
			}
		}
		if ( ! $as_activate_atc && $single_attribute ) {
			return '<div class="cgkit-as-single-atc-wrap">' . $html . '</div>'; // phpcs:ignore
		}
		if ( $as_activate_atc && $single_attribute ) {
			return '<div class="cgkit-as-single-atc-wrap"><a href="' . esc_url( $product->add_to_cart_url() ) . '" class="button cgkit-as-single-atc">' . esc_html__( 'Add to cart', 'commercegurus-commercekit' ) . '</a><input type="hidden" class="cgkit-as-single-atc-clk" value="0" /></div>'; // phpcs:ignore
		}

		return '';
	}

	return $html;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'commercegurus_as_loop_add_to_cart_link', 99, 2 );

/**
 * Product gallery options
 *
 * @param string $options module options.
 */
function commercekit_get_as_options( $options ) {
	$commercekit_as = array();

	$commercekit_as['as_activate_atc'] = isset( $options['as_activate_atc'] ) && 1 === (int) $options['as_activate_atc'] ? 1 : 0;
	$commercekit_as['cgkit_attr_gal']  = isset( $options['pdp_attributes_gallery'] ) && 1 === (int) $options['pdp_attributes_gallery'] ? 1 : 0;

	$commercekit_as['as_enable_tooltips'] = ( ( isset( $options['as_enable_tooltips'] ) && 1 === (int) $options['as_enable_tooltips'] ) || ! isset( $options['as_enable_tooltips'] ) ) ? 1 : 0;

	$swatches_ajax = 0;
	if ( defined( 'COMMERCEKIT_SWATCHES_AJAX' ) && true === COMMERCEKIT_SWATCHES_AJAX ) {
		$swatches_ajax = 1;
	}
	$commercekit_as['swatches_ajax'] = $swatches_ajax;
	return $commercekit_as;
}

/**
 * Product loop class
 *
 * @param array  $classes array of classes.
 * @param string $product product object.
 */
function commercegurus_as_loop_class( $classes, $product ) {
	$options     = get_option( 'commercekit', array() );
	$disable_atc = isset( $options['as_activate_atc'] ) && 1 === (int) $options['as_activate_atc'] ? false : true;
	if ( $product && ( method_exists( $product, 'is_type' ) && $product->is_type( 'variable' ) ) ) {
		$hide_button = true;
		if ( $hide_button ) {
			$can_hide     = true;
			$product_id   = $product ? $product->get_id() : 0;
			$out_of_stock = get_post_meta( $product_id, '_stock_status', true );
			if ( 'outofstock' === $out_of_stock ) {
				$can_hide = false;
			}
			$as_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
			if ( isset( $as_swatches['enable_product'] ) && 0 === (int) $as_swatches['enable_product'] ) {
				return $classes;
			}
			$enable_loop = ( isset( $as_swatches['enable_loop'] ) && 1 === (int) $as_swatches['enable_loop'] ) || ! isset( $as_swatches['enable_loop'] ) ? true : false;
			if ( ! $enable_loop ) {
				$can_hide = false;
			}
			if ( $can_hide ) {
				$classes[] = 'ckit-hide-cta';
			}
		}
		$classes[] = 'cgkit-swatch-hover';
		if ( $disable_atc ) {
			$classes[] = 'cgkit-disable-atc';
		}
	}

	return $classes;
}
add_filter( 'woocommerce_post_class', 'commercegurus_as_loop_class', 10, 2 );

/**
 * Remove shoptimizer gallery image.
 */
function commercegurus_as_remove_shoptimizer_gallery_image() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'shoptimizer_gallery_image', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'commercegurus_as_add_shoptimizer_gallery_image', 10 );
}
add_action( 'init', 'commercegurus_as_remove_shoptimizer_gallery_image' );

/**
 * Add shoptimizer gallery image.
 */
function commercegurus_as_add_shoptimizer_gallery_image() {
	global $product;
	if ( $product && method_exists( $product, 'is_type' ) && $product->is_type( 'variable' ) ) {
		$options       = get_option( 'commercekit', array() );
		$product_id    = $product ? $product->get_id() : 0;
		$cache_key2    = 'cgkit_swatch_loop_form_data_' . $product_id;
		$swatches_html = get_transient( $cache_key2 );
		$as_swatches   = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
		$show_swatches = isset( $as_swatches['enable_product'] ) && 0 === (int) $as_swatches['enable_product'] ? false : true;
		$enable_loop   = isset( $as_swatches['enable_loop'] ) && 0 === (int) $as_swatches['enable_loop'] ? false : true;
		$as_active_plp = isset( $options['attribute_swatches_plp'] ) && 1 === (int) $options['attribute_swatches_plp'] ? true : false;
		$out_of_stock  = get_post_meta( $product_id, '_stock_status', true );
		if ( 'outofstock' === $out_of_stock || ! $as_active_plp ) {
			$enable_loop = false;
		}
		$attributes_gallery = isset( $options['pdp_attributes_gallery'] ) && 1 === (int) $options['pdp_attributes_gallery'] ? true : false;
		if ( $attributes_gallery ) {
			$enable_plp_gallery  = false;
			$cgkit_image_gallery = get_post_meta( $product_id, 'commercekit_image_gallery', true );
			if ( is_array( $cgkit_image_gallery ) && count( $cgkit_image_gallery ) ) {
				foreach ( $cgkit_image_gallery as $slug => $image_gallery ) {
					if ( 'global_gallery' === $slug ) {
						continue;
					}
					$images = explode( ',', trim( $image_gallery ) );
					if ( isset( $images[0] ) && ! empty( $images[0] ) ) {
						$enable_plp_gallery = true;
						break;
					}
				}
			}
			if ( ! $enable_plp_gallery ) {
				$attributes_gallery = false;
			}
		}
		if ( $show_swatches && $enable_loop && $attributes_gallery && false !== $swatches_html ) {
			$swatches_data = json_decode( $swatches_html, true );

			$images = isset( $swatches_data['images'] ) ? $swatches_data['images'] : array();
			if ( is_array( $images ) && count( $images ) ) {
				return;
			}
		}
	}
	if ( function_exists( 'shoptimizer_gallery_image' ) ) {
		shoptimizer_gallery_image();
	}
}

/**
 * Check whether WooCommerce Composite product or not.
 */
function commercegurus_as_is_wc_composite_product() {
	global $cgkit_as_wc_cp;

	if ( true === $cgkit_as_wc_cp ) {
		return $cgkit_as_wc_cp;
	}

	$cgkit_wccp_actions = array( 'woocommerce_show_composited_product', 'woocommerce_show_component_options' );
	if ( isset( $_GET['wc-ajax'] ) && ! empty( $_GET['wc-ajax'] ) ) { // phpcs:ignore
		if ( isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $cgkit_wccp_actions, true ) ) { // phpcs:ignore
			$cgkit_as_wc_cp = true;
			return $cgkit_as_wc_cp;
		}
	}

	return false;
}
