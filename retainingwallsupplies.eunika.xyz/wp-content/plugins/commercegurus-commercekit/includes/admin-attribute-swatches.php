<?php
/**
 * Admin Attributes Swatches
 *
 * @author   CommerceGurus
 * @package  Attributes_Swatches
 * @since    1.0.0
 */

/**
 * Get product attributes swatches admin tab.
 *
 * @param string $tabs admin product tabs.
 */
function commercegurus_get_attribute_swatches_tab( $tabs ) {
	$tabs['commercekit_swatches'] = array(
		'label'    => esc_html__( 'Attribute Swatches', 'commercegurus-commercekit' ),
		'target'   => 'cgkit_attr_swatches',
		'class'    => array( 'commercekit-attributes-swatches', 'show_if_variable' ),
		'priority' => 62,
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'commercegurus_get_attribute_swatches_tab' );

/**
 * Get product attributes swatches admin panel.
 */
function commercegurus_get_attribute_swatches_panel() {
	global $post;
	$product_id = $post->ID;
	$product_id = intval( $product_id );
	$product    = wc_get_product_object( 'variable', $product_id );
	$attributes = commercegurus_attribute_swatches_load_attributes( $product );

	$attribute_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
	require_once dirname( __FILE__ ) . '/templates/admin-attribute-swatches.php';
}
add_filter( 'woocommerce_product_data_panels', 'commercegurus_get_attribute_swatches_panel' );

/**
 * Add admin CSS and JS scripts
 */
function commercegurus_attribute_swatches_admin_scripts() {
	$screen = get_current_screen();
	if ( 'product' === $screen->post_type && 'post' === $screen->base ) {
		wp_enqueue_style( 'commercekit-admin-attribute-swatches-style', CKIT_URI . 'assets/css/admin-attribute-swatches.css', array(), CGKIT_CSS_JS_VER );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'commercekit-admin-attribute-swatches-script', CKIT_URI . 'assets/js/admin-attribute-swatches.js', array( 'wp-color-picker' ), CGKIT_CSS_JS_VER, true );
	}
}

add_action( 'admin_enqueue_scripts', 'commercegurus_attribute_swatches_admin_scripts' );

/**
 * Load selected attributes
 *
 * @param string $product admin product.
 */
function commercegurus_attribute_swatches_load_attributes( $product ) {
	$attributes = array();

	if ( $product ) {
		foreach ( $product->get_attributes( 'edit' ) as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}
			$attr_slug = sanitize_title( $attribute->get_name() );
			if ( $attr_slug ) {
				if ( $attribute->is_taxonomy() ) {
					$tax = $attribute->get_taxonomy_object();

					$attributes[ $attr_slug ] = array(
						'id'    => $attribute->get_id(),
						'slug'  => $attr_slug,
						'name'  => $tax ? $tax->attribute_label : '',
						'terms' => $attribute->get_terms(),
					);
				} else {
					$_options  = $attribute->get_options();
					$tax_terms = array();
					if ( count( $_options ) ) {
						foreach ( $_options as $_option ) {
							$tax_terms[] = (object) array(
								'name'    => $_option,
								'slug'    => sanitize_title( $_option ),
								'term_id' => $_option,
							);
						}
					}
					$attributes[ $attr_slug ] = array(
						'id'    => $attr_slug,
						'slug'  => $attr_slug,
						'name'  => $attribute->get_name(),
						'terms' => $tax_terms,
					);
				}
			}
		}
	}

	return $attributes;
}

/**
 * Save product attributes gallery
 *
 * @param string $post_id post ID.
 * @param string $post post.
 */
function commercegurus_save_product_attribute_swatches( $post_id, $post ) {
	if ( 'product' !== $post->post_type ) {
		return;
	}
	$cgkit_swatches_nonce = isset( $_POST['cgkit_swatches_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cgkit_swatches_nonce'] ) ) : '';
	if ( $cgkit_swatches_nonce && wp_verify_nonce( $cgkit_swatches_nonce, 'cgkit_swatches_nonce' ) ) {
		if ( $post_id ) {
			$attribute_swatches = isset( $_POST['commercekit_attribute_swatches'] ) ? map_deep( wp_unslash( $_POST['commercekit_attribute_swatches'] ), 'sanitize_textarea_field' ) : array();
			if ( ! isset( $attribute_swatches['enable_loop'] ) ) {
				$attribute_swatches['enable_loop'] = 0;
			}
			if ( ! isset( $attribute_swatches['enable_product'] ) ) {
				$attribute_swatches['enable_product'] = 0;
			}
			update_post_meta( $post_id, 'commercekit_attribute_swatches', $attribute_swatches );
		}
	}
}
add_action( 'woocommerce_process_product_meta', 'commercegurus_save_product_attribute_swatches', 10, 2 );

/**
 * Get ajax product gallery
 */
function commercegurus_get_ajax_attribute_swatches() {
	$ajax           = array();
	$ajax['status'] = 0;
	$ajax['html']   = '';

	$product_id = isset( $_GET['product_id'] ) ? (int) $_GET['product_id'] : 0; // phpcs:ignore
	if ( $product_id ) {
		ob_start();
		$product_id   = intval( $product_id );
		$product      = wc_get_product_object( 'variable', $product_id );
		$attributes   = commercegurus_attribute_swatches_load_attributes( $product );
		$without_wrap = true;

		$attribute_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
		require_once dirname( __FILE__ ) . '/templates/admin-attribute-swatches.php';

		$ajax['status'] = 1;
		$ajax['html']   = ob_get_contents();
		ob_clean();
	}

	wp_send_json( $ajax );
}

add_action( 'wp_ajax_commercekit_get_ajax_attribute_swatches', 'commercegurus_get_ajax_attribute_swatches' );

/**
 * Update ajax product gallery
 */
function commercegurus_update_ajax_attribute_swatches() {
	$ajax           = array();
	$ajax['status'] = 0;
	$ajax['html']   = '';

	$product_id = isset( $_GET['product_id'] ) ? (int) $_GET['product_id'] : 0; // phpcs:ignore
	if ( $product_id ) {
		$post = get_post( $product_id );
		commercegurus_save_product_attribute_swatches( $product_id, $post );
		$ajax['status'] = 1;
	}

	wp_send_json( $ajax );
}

add_action( 'wp_ajax_commercekit_update_ajax_attribute_swatches', 'commercegurus_update_ajax_attribute_swatches' );

/**
 * Build product swatch cache
 *
 * @param string $product product object.
 * @param string $return return HTML.
 * @param string $suffix logger suffix text.
 */
function commercekit_as_build_product_swatch_cache( $product, $return = false, $suffix = '' ) {
	global $cgkit_as_cached_keys;
	$product_id = $product ? $product->get_id() : 0;
	if ( ! $product_id ) {
		return;
	}
	$cache_key  = 'cgkit_swatch_loop_form_' . $product_id;
	$cache_key2 = 'cgkit_swatch_loop_form_data_' . $product_id;

	if ( isset( $cgkit_as_cached_keys[ $cache_key ] ) && $cgkit_as_cached_keys[ $cache_key ] ) {
		return;
	}

	if ( ! empty( $suffix ) ) {
		$suffix = ' ' . $suffix;
	}

	commercekit_as_log( 'building swatches cache for product id ' . $product_id . $suffix );
	$commercekit_options  = get_option( 'commercekit', array() );
	$get_variations       = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
	$available_variations = $get_variations ? $product->get_available_variations() : false;
	$cgkit_images         = array();
	$images_data          = array();
	if ( is_array( $available_variations ) && count( $available_variations ) ) {
		foreach ( $available_variations as $variation ) {
			if ( isset( $variation['attributes'] ) && count( $variation['attributes'] ) ) {
				$variation_img_id = get_post_thumbnail_id( $variation['variation_id'] );
				if ( $variation_img_id ) {
					$cgkit_images[] = $variation_img_id;
				}
			}
		}
	}
	$as_quickadd_txt     = isset( $commercekit_options['as_quickadd_txt'] ) && ! empty( $commercekit_options['as_quickadd_txt'] ) ? commercekit_get_multilingual_string( stripslashes_deep( $commercekit_options['as_quickadd_txt'] ) ) : commercekit_get_default_settings( 'as_quickadd_txt' );
	$cgkit_image_gallery = get_post_meta( $product_id, 'commercekit_image_gallery', true );
	if ( is_array( $cgkit_image_gallery ) ) {
		$cgkit_image_gallery = array_filter( $cgkit_image_gallery );
	}
	$attribute_swatches = get_post_meta( $product_id, 'commercekit_attribute_swatches', true );
	if ( is_array( $cgkit_image_gallery ) && count( $cgkit_image_gallery ) ) {
		foreach ( $cgkit_image_gallery as $slug => $image_gallery ) {
			if ( 'global_gallery' === $slug ) {
				continue;
			}
			$images = explode( ',', trim( $image_gallery ) );
			if ( isset( $images[0] ) && ! empty( $images[0] ) ) {
				$cgkit_images[] = $images[0];
			}
		}
	}
	$cgkit_images = array_unique( $cgkit_images );
	if ( count( $cgkit_images ) ) {
		foreach ( $cgkit_images as $image_id ) {
			$image_data = commercekit_as_get_loop_swatch_image( $image_id );
			if ( $image_data ) {
				$images_data[ 'img_' . $image_id ] = $image_data;
			}
		}
	}

	$attributes  = $product->get_variation_attributes();
	$nattributes = array_map( 'array_filter', $attributes );
	$nattributes = array_filter( $nattributes );
	if ( ! count( $nattributes ) ) {
		commercekit_as_log( 'no attributes founds - skipping setting a transient for product id ' . $product_id . $suffix );
		commercekit_as_log( 'swatch cache complete for product id ' . $product_id . $suffix );
		commercekit_update_swatches_cache_count( $product_id, 0 );
		$message = commercekit_get_as_totals_log_message();
		commercekit_as_log( $message . $suffix );

		$cgkit_as_cached_keys[ $cache_key ] = true;
		return;
	}
	$selected_attributes = $product->get_default_attributes();
	$attribute_keys      = array_keys( $attributes );
	$for_json_data       = array(
		'variations' => $available_variations,
		'images'     => $images_data,
	);
	$data_variations     = 'false';
	$data_images         = '[]';
	$data_form_class     = 'cgkit-no-actions';
	$variations_json     = wp_json_encode( $for_json_data );
	ob_start();
	require dirname( __FILE__ ) . '/templates/product-attribute-swatches.php';
	$swatches_html = ob_get_clean();
	if ( $swatches_html ) {
		set_transient( $cache_key, $swatches_html, 2 * DAY_IN_SECONDS );
		commercekit_as_log( 'setting transient ' . $cache_key . ' for product id ' . $product_id . $suffix );
		set_transient( $cache_key2, $variations_json, 2 * DAY_IN_SECONDS );
		commercekit_as_log( 'setting transient ' . $cache_key2 . ' for product id ' . $product_id . $suffix );
	}

	/* Noajax variations */
	$data_form_class = 'variations_form cart';
	$cache_key3      = 'cgkit_swatch_loop_full_' . $product_id;
	$variations_json = wp_json_encode( $available_variations );
	$data_variations = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
	$images_json     = wp_json_encode( $images_data );
	$data_images     = function_exists( 'wc_esc_json' ) ? wc_esc_json( $images_json ) : _wp_specialchars( $images_json, ENT_QUOTES, 'UTF-8', true );
	ob_start();
	require dirname( __FILE__ ) . '/templates/product-attribute-swatches.php';
	$swatches_html = ob_get_clean();
	if ( $swatches_html ) {
		set_transient( $cache_key3, $swatches_html, 2 * DAY_IN_SECONDS );
		commercekit_as_log( 'setting transient ' . $cache_key3 . ' for product id ' . $product_id . $suffix );
	}
	/* End Noajax variations */

	$cgkit_as_cached_keys[ $cache_key ] = true;
	commercekit_update_swatches_cache_count( $product_id );
	commercekit_as_log( 'swatch cache complete for product id ' . $product_id . $suffix );
	$message = commercekit_get_as_totals_log_message();
	commercekit_as_log( $message . $suffix );

	if ( $return ) {
		return $swatches_html;
	}
}

/**
 * Update product attribute swatches cache
 *
 * @param string $post_id post ID.
 * @param string $post post.
 */
function commercegurus_update_product_as_data( $post_id, $post ) {
	global $product;
	if ( 'product' !== $post->post_type ) {
		return;
	}
	$product = wc_get_product( $post_id );
	if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
		return;
	}
	commercekit_as_build_product_swatch_cache( $product, false, 'via update product' );
}
add_action( 'woocommerce_process_product_meta', 'commercegurus_update_product_as_data', 10, 2 );

/**
 * Update product attribute swatches cache on stock, variations updates
 *
 * @param string $product_id product ID.
 */
function commercegurus_update_product_as_cache( $product_id ) {
	global $product;
	$product = wc_get_product( $product_id );
	if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
		return;
	}
	commercekit_as_build_product_swatch_cache( $product, false, 'via save variations' );
}
add_action( 'woocommerce_updated_product_stock', 'commercegurus_update_product_as_cache', 10, 1 );
add_action( 'woocommerce_save_product_variation', 'commercegurus_update_product_as_cache', 10, 1 );
add_action( 'woocommerce_ajax_save_product_variations', 'commercegurus_update_product_as_cache', 10, 1 );

/**
 * Update product attribute swatches cache on quick edit updates
 *
 * @param string $product_id product ID.
 */
function commercegurus_quick_edit_update_product_as_cache( $product_id ) {
	global $product, $post;
	if ( isset( $post ) && 'product' === $post->post_type ) {
		$product = wc_get_product( $product_id );
		if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
			return;
		}
		commercekit_as_build_product_swatch_cache( $product, false, 'via update product' );
	}
}
add_action( 'save_post', 'commercegurus_quick_edit_update_product_as_cache', 10, 1 );

/**
 * Update product attribute swatches cache on stock updates
 *
 * @param string $product_obj product object.
 */
function commercegurus_update_product_as_cache_stock_updates( $product_obj ) {
	global $product;
	if ( $product_obj->is_type( 'variation' ) ) {
		$product_id = $product_obj->get_parent_id();
		$product    = wc_get_product( $product_id );
	} else {
		$product = $product_obj;
	}
	if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
		return;
	}
	commercekit_as_build_product_swatch_cache( $product, false, 'via stock update' );
}
add_action( 'woocommerce_product_set_stock', 'commercegurus_update_product_as_cache_stock_updates', 10, 1 );
add_action( 'woocommerce_variation_set_stock', 'commercegurus_update_product_as_cache_stock_updates', 10, 1 );

/**
 * Update product attribute swatches cache on delete variation
 *
 * @param string $postid variation ID.
 * @param string $post variation post.
 */
function commercegurus_update_product_as_cache_delete_variation( $postid, $post ) {
	global $product;
	if ( $post && 'product_variation' === $post->post_type ) {
		$product_id = $post->post_parent;
		$product    = wc_get_product( $product_id );
		if ( ! $product || ( method_exists( $product, 'is_type' ) && ! $product->is_type( 'variable' ) ) ) {
			return;
		}
		commercekit_as_build_product_swatch_cache( $product, false, 'via delete variation' );
	}
}
add_action( 'deleted_post', 'commercegurus_update_product_as_cache_delete_variation', 10, 2 );

/**
 * Prepare action scheduler for attribute swatches all cache
 */
function commercekit_as_prepare_action_scheduler() {
	global $wpdb;
	$options   = get_option( 'commercekit', array() );
	$as_active = isset( $options['attribute_swatches'] ) && 1 === (int) $options['attribute_swatches'] ? true : false;
	if ( ! $as_active ) {
		return;
	}
	$as_scheduled = isset( $options['commercekit_as_scheduled'] ) && 1 === (int) $options['commercekit_as_scheduled'] ? true : false;
	if ( $as_scheduled ) {
		return;
	}
	$build_clear = isset( $options['commercekit_as_scheduled_clear'] ) ? $options['commercekit_as_scheduled_clear'] : 0;
	if ( 0 < $build_clear && ( ( $build_clear + 5 ) > time() ) ) {
		return;
	}

	commercekit_as_log( 'running commercekit_as_prepare_action_scheduler - preparing action scheduler for caching' );
	$args = array(
		'hook'     => 'commercekit_attribute_swatch_build_cache_list',
		'per_page' => -1,
		'group'    => 'commercekit',
		'status'   => ActionScheduler_Store::STATUS_PENDING,
	);

	$action_ids = as_get_scheduled_actions( $args, 'ids' );
	if ( ! count( $action_ids ) ) {
		as_schedule_single_action( time() + 5, 'commercekit_attribute_swatch_build_cache_list', array(), 'commercekit' );
		commercekit_as_log( 'REBUILDING CACHE: creating single action for commercekit_attribute_swatch_build_cache_list hook' );
	}

	$args2 = array(
		'hook'     => 'commercekit_attribute_swatch_build_cache_missing',
		'per_page' => -1,
		'group'    => 'commercekit',
	);

	$action_ids2 = as_get_scheduled_actions( $args2, 'ids' );
	if ( ! count( $action_ids2 ) ) {
		as_schedule_recurring_action( time() + 5, 15 * MINUTE_IN_SECONDS, 'commercekit_attribute_swatch_build_cache_missing', array(), 'commercekit' );
	}

	$options['commercekit_as_scheduled'] = 1;
	commercekit_as_log( 'updating commercekit_as_scheduled to 1' );
	$options['commercekit_as_scheduled_status'] = 'created';
	$options['commercekit_as_scheduled_clear']  = 0;
	commercekit_as_log( 'updating commercekit_as_scheduled_clear to 0' );
	update_option( 'commercekit', $options, false );
}
add_action( 'init', 'commercekit_as_prepare_action_scheduler' );

/**
 * Run action scheduler list for attribute swatches cache
 *
 * @param  array $params array of arguments.
 */
function commercekit_as_run_action_scheduler_list( $params = array() ) {
	global $wpdb;
	$options = get_option( 'commercekit', array() );

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'order'          => 'DESC',
		'orderby'        => 'ID',
		'fields'         => 'ids',
		'tax_query'      => array( // phpcs:ignore
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'variable',
			),
		),
	);

	$query = new WP_Query( $args );
	$total = (int) $query->found_posts;
	if ( $total ) {
		commercekit_as_log( 'CREATING SWATCHES CACHE EVENTS: executing the commercekit_attribute_swatch_build_cache_list hook' );
		$product_ids = wp_parse_id_list( $query->posts );
		foreach ( $product_ids as $product_id ) {
			$args2 = array(
				'hook'   => 'commercekit_attribute_swatch_build_cache',
				'args'   => array( 'product_id' => $product_id ),
				'group'  => 'commercekit',
				'status' => ActionScheduler_Store::STATUS_PENDING,
			);

			$action_ids2 = as_get_scheduled_actions( $args2, 'ids' );
			if ( count( $action_ids2 ) ) {
				commercekit_as_log( 'skip creating single action to create commercekit_attribute_swatch_build_cache for product id ' . $product_id . ' due to pending action' );
				continue;
			} else {
				as_schedule_single_action( time(), 'commercekit_attribute_swatch_build_cache', array( 'product_id' => $product_id ), 'commercekit' );
				commercekit_as_log( 'creating single action to create commercekit_attribute_swatch_build_cache for product id ' . $product_id );
			}
		}

		$options['commercekit_as_scheduled_status'] = 'created';
		update_option( 'commercekit', $options, false );
	}
}
add_action( 'commercekit_attribute_swatch_build_cache_list', 'commercekit_as_run_action_scheduler_list', 10, 1 );

/**
 * Run action scheduler for missing attribute swatches cache
 *
 * @param  array $params array of arguments.
 */
function commercekit_as_run_action_scheduler_missing( $params = array() ) {
	global $wpdb;
	$options   = get_option( 'commercekit', array() );
	$as_status = isset( $options['commercekit_as_scheduled_status'] ) ? $options['commercekit_as_scheduled_status'] : '';
	if ( 'completed' === $as_status ) {
		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'order'          => 'DESC',
			'orderby'        => 'ID',
			'fields'         => 'ids',
			'tax_query'      => array( // phpcs:ignore
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'variable',
				),
			),
		);

		$query = new WP_Query( $args );
		$total = (int) $query->found_posts;
		if ( $total ) {
			$table = $wpdb->prefix . 'commercekit_swatches_cache_count';
			$sql   = 'SELECT COUNT(*) FROM ' . $table;
			$count = (int) $wpdb->get_var( $sql ); // phpcs:ignore
			if ( $total !== $count ) {
				$product_ids  = wp_parse_id_list( $query->posts );
				$sql2         = 'SELECT product_id FROM ' . $table;
				$product_ids2 = $wpdb->get_col( $sql2 ); // phpcs:ignore
				$product_ids3 = array_diff( $product_ids, $product_ids2 );
				if ( count( $product_ids3 ) ) {
					commercekit_as_log( 'CREATING SWATCHES CACHE EVENTS: executing the commercekit_attribute_swatch_build_cache_missing hook' );
					foreach ( $product_ids3 as $product_id ) {
						$args2 = array(
							'hook'   => 'commercekit_attribute_swatch_build_cache',
							'args'   => array( 'product_id' => $product_id ),
							'group'  => 'commercekit',
							'status' => ActionScheduler_Store::STATUS_PENDING,
						);

						$action_ids2 = as_get_scheduled_actions( $args2, 'ids' );
						if ( count( $action_ids2 ) ) {
							commercekit_as_log( 'skip creating single action to create commercekit_attribute_swatch_build_cache for missing product id ' . $product_id . ' due to pending action' );
							continue;
						} else {
							as_schedule_single_action( time(), 'commercekit_attribute_swatch_build_cache', array( 'product_id' => $product_id ), 'commercekit' );
							commercekit_as_log( 'creating single action to create commercekit_attribute_swatch_build_cache for missing product id ' . $product_id );
						}
					}
				}
			}
		}
	}
}
add_action( 'commercekit_attribute_swatch_build_cache_missing', 'commercekit_as_run_action_scheduler_missing', 10, 1 );

/**
 * Run action scheduler for attribute swatches cache
 *
 * @param  array $args array of arguments.
 */
function commercekit_as_run_action_scheduler( $args ) {
	global $wpdb, $product;
	$options    = get_option( 'commercekit', array() );
	$product_id = 0;
	if ( is_numeric( $args ) ) {
		$product_id = (int) $args;
	} elseif ( is_array( $args ) ) {
		if ( isset( $args[0] ) && is_numeric( $args[0] ) ) {
			$product_id = (int) $args[0];
		} elseif ( isset( $args['product_id'] ) && is_numeric( $args['product_id'] ) ) {
			$product_id = (int) $args['product_id'];
		}
	}

	if ( $product_id ) {
		$table = $wpdb->prefix . 'commercekit_swatches_cache_count';
		$sql   = 'SELECT * FROM ' . $table . ' WHERE product_id = \'' . $product_id . '\'';
		$row   = $wpdb->get_row( $sql ); // phpcs:ignore
		if ( $row ) {
			return;
		}

		commercekit_as_log( 'CREATING SWATCHES CACHE EVENT FOR PRODUCT: executing commercekit_attribute_swatch_build_cache hook for product id ' . $product_id );
		$product = wc_get_product( $product_id );
		if ( $product && method_exists( $product, 'is_type' ) && $product->is_type( 'variable' ) ) {
			try {
				commercekit_as_build_product_swatch_cache( $product, false, 'via Action Scheduler' );
			} catch ( Exception $e ) {
				$product = null;
			}
		}

		$options['commercekit_as_scheduled_status'] = 'processing';
		$options['commercekit_as_scheduled_done']   = time();
		update_option( 'commercekit', $options, false );
	}
}
add_action( 'commercekit_attribute_swatch_build_cache', 'commercekit_as_run_action_scheduler', 10, 1 );

/**
 * Run action scheduler cancel for attribute swatches cache
 */
function commercekit_as_run_action_scheduler_cancel() {
	$ajax    = array();
	$options = get_option( 'commercekit', array() );

	$options['commercekit_as_scheduled_status'] = 'cancelled';
	update_option( 'commercekit', $options, false );

	$as_store = ActionScheduler::store();
	$as_store->cancel_actions_by_hook( 'commercekit_attribute_swatch_build_cache' );
	commercekit_as_log( 'The caching process has been cancelled.' );

	$ajax['status']  = 0;
	$ajax['message'] = esc_html__( 'The caching process has been cancelled.', 'commercegurus-commercekit' );

	wp_send_json( $ajax );
}
add_action( 'wp_ajax_commercekit_get_as_build_cancel', 'commercekit_as_run_action_scheduler_cancel', 10, 1 );

/**
 * Update swatches cache count
 *
 * @param string $product_id product ID.
 * @param string $cached whether cached or not.
 */
function commercekit_update_swatches_cache_count( $product_id, $cached = 1 ) {
	global $wpdb;
	$table = $wpdb->prefix . 'commercekit_swatches_cache_count';
	$sql   = 'SELECT * FROM ' . $table . ' WHERE product_id = \'' . $product_id . '\'';
	$row   = $wpdb->get_row( $sql ); // phpcs:ignore
	if ( $row ) {
		$data   = array(
			'cached'  => $cached,
			'updated' => time(),
		);
		$where  = array(
			'product_id' => $product_id,
		);
		$format = array( '%d', '%d' );
		$wpdb->update( $table, $data, $where, $format ); // db call ok; no-cache ok.
	} else {
		$data   = array(
			'product_id' => $product_id,
			'cached'     => $cached,
			'updated'    => time(),
		);
		$format = array( '%s', '%d', '%d' );
		$wpdb->insert( $table, $data, $format ); // db call ok; no-cache ok.
	}
}
