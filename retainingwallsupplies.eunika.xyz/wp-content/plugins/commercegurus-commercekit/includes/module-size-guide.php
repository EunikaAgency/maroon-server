<?php
/**
 *
 * Size Guides
 *
 * @package CommerceKit
 * @subpackage Shoptimizer
 */

/**
 * Create Size Guides post type.
 */
function commercekit_sg_create_post_type() {
	$options    = get_option( 'commercekit', array() );
	$exc_search = ( ( isset( $options['size_guide_search'] ) && 1 === (int) $options['size_guide_search'] ) || ( ! isset( $options['size_guide_search'] ) && 1 === (int) commercekit_get_default_settings( 'size_guide_search' ) ) ) ? false : true;
	$args       = array(
		'labels'            => array(
			'name'          => esc_html__( 'Size Guides', 'commercegurus-commercekit' ),
			'singular_name' => esc_html__( 'Size Guide', 'commercegurus-commercekit' ),
		),
		'public'            => true,
		'has_archive'       => true,
		'show_in_rest'      => false,
		'show_in_nav_menus' => true,
		'show_in_menu'      => true,
		'menu_icon'         => 'dashicons-media-spreadsheet',
		'show_in_rest'      => true,
		'supports'          => array( 'title', 'editor', 'page-attributes' ),
	);

	$args['exclude_from_search'] = $exc_search;
	register_post_type( 'ckit_size_guide', $args );
}
add_action( 'init', 'commercekit_sg_create_post_type' );

/**
 * Add admin CSS and JS scripts for Size Guide post type
 */
function commercekit_sg_admin_scripts() {
	$screen = get_current_screen();
	if ( 'ckit_size_guide' === $screen->post_type && 'post' === $screen->base ) {
		wp_enqueue_style( 'commercekit-sg-select2-style', CKIT_URI . 'assets/css/select2.css', array(), CGKIT_CSS_JS_VER );
		wp_enqueue_script( 'commercekit-sg-select2-script', CKIT_URI . 'assets/js/select2.js', array(), CGKIT_CSS_JS_VER, true );
		wp_enqueue_script( 'commercekit-sg-script', CKIT_URI . 'assets/js/admin-size-guide.js', array(), CGKIT_CSS_JS_VER, true );
	}
}
add_action( 'admin_enqueue_scripts', 'commercekit_sg_admin_scripts' );

/**
 * Admin meta box.
 */
function commercekit_sg_admin_meta_box() {
	add_meta_box( 'commercekit-sg-cat-meta-box', esc_html__( 'Product categories', 'commercegurus-commercekit' ), 'commercekit_sg_admin_categories_display', 'ckit_size_guide', 'side', 'low' );
	add_meta_box( 'commercekit-sg-prod-meta-box', esc_html__( 'Products', 'commercegurus-commercekit' ), 'commercekit_sg_admin_products_display', 'ckit_size_guide', 'side', 'low' );
}
add_action( 'admin_init', 'commercekit_sg_admin_meta_box' );

/**
 * Admin categories meta box display.
 *
 * @param string $post post object.
 */
function commercekit_sg_admin_categories_display( $post ) {
	$options = '';
	if ( isset( $post->ID ) && $post->ID ) {
		$categories = get_post_meta( $post->ID, 'commercekit_sg_cat', true );
		$categories = explode( ',', $categories );
		$categories = array_filter( $categories );
		if ( is_array( $categories ) && count( $categories ) ) {
			foreach ( $categories as $category ) {
				$nterm       = get_term_by( 'id', $category, 'product_cat' );
				$nterm->name = isset( $nterm->name ) ? $nterm->name : '';
				$options    .= '<option value="' . esc_attr( $category ) . '" selected="selected">#' . esc_attr( $category ) . ' - ' . esc_html( $nterm->name ) . '</option>';
			}
		}
	}
	echo '<div style="width: 100%; display: block; margin: 15px 0px 10px;"><label>' . esc_html__( 'Product categories:', 'commercegurus-commercekit' ) . '<br /><label><select name="commercekit_sg_cat[]" class="commercekit-select2" data-type="category" multiple="multiple" data-placeholder="' . esc_html__( 'Select category', 'commercegurus-commercekit' ) . '" style="width:100%;">' . $options . '</select></label></div>'; // phpcs:ignore
}

/**
 * Admin products meta box display.
 *
 * @param string $post post object.
 */
function commercekit_sg_admin_products_display( $post ) {
	$options = '';
	if ( isset( $post->ID ) && $post->ID ) {
		$products = get_post_meta( $post->ID, 'commercekit_sg_prod', true );
		$products = explode( ',', $products );
		$products = array_filter( $products );
		if ( is_array( $products ) && count( $products ) ) {
			foreach ( $products as $product_id ) {
				$options .= '<option value="' . esc_attr( $product_id ) . '" selected="selected">#' . esc_attr( $product_id ) . ' - ' . esc_html( commercekit_limit_title( get_the_title( $product_id ) ) ) . '</option>';
			}
		}
	}
	echo '<div style="width: 100%; display: block; margin: 15px 0px 10px;"><label>' . esc_html__( 'Products:', 'commercegurus-commercekit' ) . '<br /><label><select name="commercekit_sg_prod[]" class="commercekit-select2" data-type="product" data-placeholder="' . esc_html__( 'Select product', 'commercegurus-commercekit' ) . '" multiple="multiple" style="width:100%;">' . $options . '</select></label></div>'; // phpcs:ignore
}

/**
 * Admin meta box save.
 *
 * @param string $post_id post id.
 * @param string $post post object.
 */
function commercekit_sg_admin_meta_save( $post_id, $post ) {
	if ( 'ckit_size_guide' === $post->post_type ) {
		$categories = isset( $_POST['commercekit_sg_cat'] ) ? map_deep( wp_unslash( $_POST['commercekit_sg_cat'] ), 'sanitize_text_field' ) : array(); // phpcs:ignore
		$products   = isset( $_POST['commercekit_sg_prod'] ) ? map_deep( wp_unslash( $_POST['commercekit_sg_prod'] ), 'sanitize_text_field' ) : array(); // phpcs:ignore
		$categories = implode( ',', array_filter( $categories ) );
		$products   = implode( ',', array_filter( $products ) );
		update_post_meta( $post->ID, 'commercekit_sg_cat', $categories );
		update_post_meta( $post->ID, 'commercekit_sg_prod', $products );
	}
}
add_action( 'save_post', 'commercekit_sg_admin_meta_save', 10, 2 );

/**
 * Get products or categories IDs
 */
function commercekit_sg_get_pcids() {
	$return = array();
	$type   = isset( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : 'product'; // phpcs:ignore
	if ( 'product' === $type ) {
		$query = ! empty( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : ''; // phpcs:ignore
		$args  = array(
			's'              => $query,
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'post_type'      => 'product',
		);
		if ( is_numeric( $query ) ) {
			unset( $args['s'] );
			$args['post__in'] = array( $query );
		}
		$search_results = new WP_Query( $args );
		if ( $search_results->have_posts() ) {
			while ( $search_results->have_posts() ) {
				$search_results->the_post();
				$product = wc_get_product( $search_results->post->ID );
				if ( ! $product ) {
						continue;
				}
				$title    = commercekit_limit_title( $search_results->post->post_title );
				$title    = '#' . $search_results->post->ID . ' - ' . $title;
				$return[] = array( $search_results->post->ID, $title );
			}
		}
	} elseif ( 'category' === $type ) {
		$query = ! empty( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : ''; // phpcs:ignore
		$args  = array(
			'name__like' => $query,
			'hide_empty' => true,
			'number'     => 20,
		);
		if ( is_numeric( $query ) ) {
			$terms = array( get_term( $query, 'product_cat' ) );
		} else {
			$terms = get_terms( 'product_cat', $args );
		}
		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {
				if ( isset( $term->name ) ) {
					$term->name = '#' . $term->term_id . ' - ' . $term->name;
					$return[]   = array( $term->term_id, $term->name );
				}
			}
		}
	}

	wp_send_json( $return );
}
add_action( 'wp_ajax_commercekit_sg_get_pcids', 'commercekit_sg_get_pcids' );

/**
 * Display on single product placeholder.
 */
function commercekit_sg_single_product_placeholder() {
	global $wpdb, $product, $cgkit_sg_post;
	if ( ! $product ) {
		return;
	}

	$product_id = $product->get_id();
	$categories = array();
	$terms      = get_the_terms( $product_id, 'product_cat' );
	if ( is_array( $terms ) && count( $terms ) ) {
		foreach ( $terms as $term ) {
			$categories[] = $term->term_id;
			$all_parents  = get_ancestors( $term->term_id, 'product_cat' );
			$categories   = array_merge( $categories, $all_parents );
		}
	}
	$categories = array_unique( $categories );
	$sg_where   = array();
	$sg_where[] = '(pm1.meta_key = \'commercekit_sg_prod\' AND FIND_IN_SET(' . $product_id . ', pm1.meta_value))';
	if ( count( $categories ) ) {
		$or_qry = array();
		foreach ( $categories as $category_id ) {
			$or_qry[] = 'FIND_IN_SET(' . $category_id . ', pm2.meta_value)';
		}
		$sg_where[] = '(pm2.meta_key = \'commercekit_sg_cat\' AND ( ' . implode( ' OR ', $or_qry ) . ' ))';
	}

	$sg_sql = 'SELECT p.* FROM ' . $wpdb->prefix . 'posts AS p LEFT JOIN ' . $wpdb->prefix . 'postmeta AS pm1 ON pm1.post_id = p.ID LEFT JOIN ' . $wpdb->prefix . 'postmeta AS pm2 ON pm2.post_id = p.ID WHERE p.post_status = \'publish\' AND p.post_type = \'ckit_size_guide\' AND (' . implode( ' OR ', $sg_where ) . ') ORDER BY p.ID DESC LIMIT 0, 1';
	$row    = $wpdb->get_row( $sg_sql ); // phpcs:ignore
	if ( ! $row ) {
		$options = get_option( 'commercekit', array() );
		$def_sg  = isset( $options['default_size_guide'] ) && ! empty( $options['default_size_guide'] ) ? (int) $options['default_size_guide'] : 0;
		$sg_sql2 = 'SELECT p.* FROM ' . $wpdb->prefix . 'posts AS p WHERE p.post_status = \'publish\' AND p.post_type = \'ckit_size_guide\' AND p.ID = \'' . $def_sg . '\' ORDER BY p.ID DESC LIMIT 0, 1';
		$row     = $wpdb->get_row( $sg_sql2 ); // phpcs:ignore
	}
	if ( $row ) {
		$options  = get_option( 'commercekit', array() );
		$sg_label = isset( $options['size_guide_label'] ) && ! empty( $options['size_guide_label'] ) ? commercekit_get_multilingual_string( $options['size_guide_label'] ) : commercekit_get_default_settings( 'size_guide_label' );

		$cgkit_sg_post = $row;
		?>
<div class="commercekit-size-guide">
	<a href="#" class="commercekit-sg-label" title="<?php echo esc_attr( $sg_label ); ?>" aria-label="<?php echo esc_attr( $sg_label ); ?>">
		<svg aria-hidden="true" role="presentation" viewBox="0 0 64 64"><defs></defs><path class="a" d="M22.39 33.53c-7.46 0-13.5-3.9-13.5-8.72s6-8.72 13.5-8.72 13.5 3.9 13.5 8.72a12 12 0 0 1-.22 1.73"></path><ellipse cx="22.39" cy="24.81" rx="3.28" ry="2.12"></ellipse><path class="a" d="M8.89 24.81V38.5c0 7.9 6.4 9.41 14.3 9.41h31.92V33.53H22.39M46.78 33.53v7.44M38.65 33.53v7.44M30.52 33.53v7.44M22.39 33.53v7.44"></path></svg>
		<span><?php echo esc_attr( $sg_label ); ?></span>
	</a>
</div>
<div class="commercekit-sg-clr"></div>
		<?php
	}
}
add_action( 'woocommerce_single_product_summary', 'commercekit_sg_single_product_placeholder', 38 );

/**
 * Display on single product modal.
 */
function commercekit_sg_single_product_modal() {
	global $cgkit_sg_post;
	if ( ! isset( $cgkit_sg_post ) || ! $cgkit_sg_post ) {
		return;
	}
	$row = $cgkit_sg_post;
	if ( ! isset( $row->ID ) || ! $row->ID ) {
		return;
	}
	$content  = apply_filters( 'cgkit_the_content_filter', $row->post_content );
	$content  = str_replace( ']]>', ']]&gt;', $content );
	$sg_title = apply_filters( 'the_title', $row->post_title, $row->ID );
	?>
<div class="modal size-guide-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-header">
				<h3><?php echo $sg_title; // phpcs:ignore ?></h3>
				<button type="button" class="close-button size-guide-close-button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></span>
				</button>
		</div>
		<div class="modal-content">

			<div class="modal-body">
				<?php echo $content; // phpcs:ignore ?>
			</div>
		</div>
	</div>
</div>
<script>
	var sg_modal = document.querySelector( '.size-guide-modal' );
	var sg_body = document.querySelector( 'body' );
	document.addEventListener( 'click', function( e ) {
		var elemnt = e.target;
		var parent = elemnt.closest( '.commercekit-sg-label' );
		if ( elemnt.classList.contains( 'commercekit-sg-label' ) || parent ) {
			e.stopPropagation();
			e.preventDefault();
			sg_toggle_modal( true );
			return;
		}
		var parent = elemnt.closest( '.size-guide-close-button' );
		if ( elemnt.classList.contains( 'size-guide-close-button' ) || parent ) {
			e.stopPropagation();
			e.preventDefault();
			sg_toggle_modal( false );
			return;
		}
		if ( elemnt === sg_modal ) {
			sg_toggle_modal( false );
		}
	} );				
	function sg_toggle_modal( show ) {
		if ( show ) {
			sg_body.classList.add( 'cgkit-size-guide-active' );
			sg_modal.classList.add( 'show-modal' );
		} else {
			sg_body.classList.remove( 'cgkit-size-guide-active' );
			sg_modal.classList.remove( 'show-modal' );
		}
	}
	if ( sg_modal ) {
		sg_body.classList.add( 'cgkit-size-guide' );
	}
</script>
	<?php
	commercekit_sg_styles();
}
add_action( 'woocommerce_single_product_summary', 'commercekit_sg_single_product_modal', 81 );

/**
 * Size guide styles.
 */
function commercekit_sg_styles() {
	?>
<style type="text/css">
body.cgkit-size-guide-active { overflow: hidden; }
.commercekit-size-guide{margin-bottom: 15px; display: block;}
.commercekit-size-guide a.commercekit-sg-label { position: relative; padding-left: 28px; display: inline-block;}
.commercekit-size-guide .commercekit-sg-label svg {width:24px;height:24px; position: absolute; left: 0px; margin-top: -1px;}
.commercekit-size-guide svg path {stroke: #000; fill: none; stroke-width: 2px;}
.commercekit-sg-clr{clear:both;display:block;width:100%;height:0px;}
.size-guide-modal.modal { transform: none; }
.size-guide-modal.modal.show-modal { right: 0px; }
.size-guide-modal button.close-button { top: 19px; right: 36px; }
.size-guide-modal .modal-dialog { background: #fff; margin: 0; min-width: 0;}
.size-guide-modal .modal-content{overflow-y:auto; padding: 20px 40px 20px 40px;}
.size-guide-modal .modal-header{display: flex; align-items: center; height: 60px; padding:0px 40px; border-bottom: 1px solid #e2e2e2;}
.size-guide-modal .modal-header h3{padding:0px;margin:0px;letter-spacing: 0; text-align: left; overflow: hidden; padding-right: 50px; white-space: nowrap; text-overflow: ellipsis;}
.size-guide-modal .modal-header .close-button{width:26px;height:26px;}
.size-guide-modal.modal button.close-button, .size-guide-modal.modal button.close-button:hover { opacity: 1; }
.size-guide-modal .modal-body{padding:0px;max-height:100%;}
.size-guide-modal .modal-content { background-color: transparent; border-radius: 0; max-height: calc(100% - 60px); }
.size-guide-modal .modal-dialog {right: -850px; transition: 0.3s all;}
.size-guide-modal.modal.show-modal .modal-dialog {right: 0px;}
@media (min-width: 601px) {
	.admin-bar .modal.size-guide-modal {top: 32px;} .admin-bar .size-guide-modal .modal-content {max-height: calc(100vh - 60px - 32px);}
}
@media (min-width: 768px) {
	.size-guide-modal .modal-dialog {width: 850px;}
	.size-guide-modal .modal-body > .wp-block-columns {margin-top: 20px;}
}
.single-ckit_size_guide .entry-header .posted-on {display: none;}
.single-ckit_size_guide .entry-content > .wp-block-columns {
	margin-top: 30px;
}
.size-guide-modal.modal.show-modal {align-items: unset; justify-content: flex-end; }

.size-guide-modal p,
.single-ckit_size_guide .entry-content p {
	font-size: 15px;
}
.size-guide-modal table,
.single-ckit_size_guide .entry-content table {
	font-size: 14px;margin: 0;
}
.size-guide-modal table th,
.single-ckit_size_guide .entry-content table th {
	background: #111; color: #fff;
}
.size-guide-modal table th,
.size-guide-modal table td,
.single-ckit_size_guide .entry-content table th,
.single-ckit_size_guide .entry-content table td {
	padding: 0.8em 1.41575em;
}
.size-guide-modal table td,
.single-ckit_size_guide .entry-content table td {
	background: #f8f8f8;
}
.size-guide-modal table tbody tr:nth-child(2n) td,
.single-ckit_size_guide .entry-content table tbody tr:nth-child(2n) td {
	background: 0 0;
}
@media (max-width: 767px) {
	.size-guide-modal .modal-header, .size-guide-modal .modal-content {padding-left: 20px; padding-right: 20px;}
	.size-guide-modal button.close-button {right: 20px;}
	.size-guide-modal .modal-header h3 { font-size: 20px; }
	.size-guide-modal table, .single-ckit_size_guide .entry-content table { font-size: 13px; }
}
</style>
	<?php
}

/**
 * Custom the_content filter.
 *
 * @param string $content post content.
 */
function commercekit_sg_the_content_filter( $content ) {
	$content = function_exists( 'capital_P_dangit' ) ? capital_P_dangit( $content ) : $content;
	$content = function_exists( 'do_blocks' ) ? do_blocks( $content ) : $content;
	$content = function_exists( 'wptexturize' ) ? wptexturize( $content ) : $content;
	$content = function_exists( 'convert_smilies' ) ? convert_smilies( $content ) : $content;
	$content = function_exists( 'wpautop' ) ? wpautop( $content ) : $content;
	$content = function_exists( 'shortcode_unautop' ) ? shortcode_unautop( $content ) : $content;
	$content = function_exists( 'prepend_attachment' ) ? prepend_attachment( $content ) : $content;
	$content = function_exists( 'wp_filter_content_tags' ) ? wp_filter_content_tags( $content ) : $content;
	$content = function_exists( 'wp_replace_insecure_home_url' ) ? wp_replace_insecure_home_url( $content ) : $content;
	$content = function_exists( 'do_shortcode' ) ? do_shortcode( $content ) : $content;

	if ( class_exists( 'WP_Embed' ) ) {
		$embed   = new WP_Embed();
		$content = method_exists( $embed, 'run_shortcode' ) ? $embed->run_shortcode( $content ) : $content;
		$content = method_exists( $embed, 'autoembed' ) ? $embed->autoembed( $content ) : $content;
	}

	return $content;
}
add_filter( 'cgkit_the_content_filter', 'commercekit_sg_the_content_filter', 10, 1 );

/**
 * Single body class.
 *
 * @param string $classes body classes.
 */
function commercekit_sg_single_body_class( $classes ) {
	if ( is_single() && 'ckit_size_guide' === get_post_type() ) {
		$classes[] = 'cgkit-size-guide';
	}

	return $classes;
}
add_filter( 'body_class', 'commercekit_sg_single_body_class' );

/**
 * Footer styles.
 */
function commercekit_sg_footer_styles() {
	if ( is_single() && 'ckit_size_guide' === get_post_type() ) {
		commercekit_sg_styles();
	}
}
add_action( 'wp_footer', 'commercekit_sg_footer_styles' );
