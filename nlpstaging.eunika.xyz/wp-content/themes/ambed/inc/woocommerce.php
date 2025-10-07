<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package ambed
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function ambed_woocommerce_setup()
{
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 270,
			'single_image_width'    => 570,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'ambed_woocommerce_setup');


/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function ambed_woocommerce_scripts()
{
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style('ambed-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'ambed_woocommerce_scripts');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function ambed_woocommerce_active_body_class($classes)
{
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'ambed_woocommerce_active_body_class');




/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */

add_filter('woocommerce_enqueue_styles', '__return_empty_array');


//shop page
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);



add_action('woocommerce_before_shop_loop_item_title', 'ambed_thumbnail_markup_open', 10);

add_action('woocommerce_before_shop_loop_item_title', 'ambed_template_loop_product_thumbnail', 10);

add_action('woocommerce_before_shop_loop_item_title', 'ambed_thumbnail_markup_end', 10);

add_action('woocommerce_shop_loop_item_title', 'ambed_product_title_markup_start', 10);

add_action('woocommerce_shop_loop_item_title', 'ambed_product_title', 10);

add_action('woocommerce_shop_loop_item_title', 'ambed_template_loop_price', 10);

add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
add_action('woocommerce_shop_loop_item_title', 'ambed_woocommerce_template_view_cart', 10);


add_action('woocommerce_after_shop_loop_item', 'ambed_product_title_markup_end', 10);

function ambed_thumbnail_markup_open()
{ ?>
	<div class="product__all-img">

	<?php }


function ambed_template_loop_product_thumbnail()
{
	global $product;
	if (function_exists('woocommerce_template_loop_product_thumbnail')) :
		woocommerce_template_loop_product_thumbnail();
	endif; ?>

	<?php
}

function ambed_thumbnail_markup_end()
{ ?>
	</div>
<?php }

function ambed_product_title_markup_start()
{ ?>
	<div class="product__all-content">
	<?php }

function ambed_product_title()
{ ?>
		<h4 class="product__all-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<?php }


function ambed_template_loop_price()
{
	global $product;
	?>
		<p class="product__all-price"><?php echo wp_kses($product->get_price_html(), 'ambed_allowed_tags'); ?></p><!-- /.product__all-price -->
	<?php }

function ambed_woocommerce_template_view_cart()
{ ?> <div class="product__add-to-cart">
			<?php
			global $product;
			$ambed_ajax_cart_class = (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' ? 'ambed_ajax' : '');
			if ($product->is_type('variable')) {

				echo sprintf(
					'<a href="%s" class="%s">%s</a>',
					esc_url($product->add_to_cart_url()),
					esc_attr(implode(' ', array_filter(array(
						'button', 'product_type_' . $product->get_type(),
						'thm-btn shop-one__cart add_to_cart_button'
					)))),
					esc_html($product->add_to_cart_text())
				);
			} else {
				echo sprintf(
					'<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
					esc_url($product->add_to_cart_url()),
					esc_attr(implode(' ', array_filter(array(
						'button', 'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports('ajax_add_to_cart') ? 'thm-btn shop-one__cart add_to_cart_button ajax_add_to_cart' : 'thm-btn shop-one__cart add_to_cart_button ',
						$ambed_ajax_cart_class
					)))),
					wc_implode_html_attributes(array(
						'data-product_id'  => $product->get_id(),
						'data-product_sku' => $product->get_sku(),
						'aria-label'       => $product->add_to_cart_description(),
						'rel'              => 'nofollow',
					)),
					esc_html($product->add_to_cart_text())
				);
			}
			?>
		</div>
	<?php }

function ambed_product_title_markup_end()
{ ?>
	</div>
	<div class="products__all-icon-boxes">
		<?php
		if (class_exists('WPCleverWoosw')) {
			echo do_shortcode('[woosw]');
		}
		?>

		<?php
		if (class_exists('WPCleverWoosq')) {
			echo do_shortcode('[woosq]');
		}
		?>
	</div>
<?php }


//single page

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);




add_action('woocommerce_single_product_summary', 'ambed_product_details_title_markup_start');
function ambed_product_details_title_markup_start()
{ ?>
	<div class="product-details__top">
	<?php
}

add_action('woocommerce_single_product_summary', 'ambed_template_single_title');
function ambed_template_single_title()
{
	global $product;
	?>
		<h3 class="product-details__title"><?php the_title(); ?><?php echo wp_kses($product->get_price_html(), 'ambed_allowed_tags'); ?></h3>
	<?php
}


add_action('woocommerce_single_product_summary', 'ambed_product_details_title_markup_end');
function ambed_product_details_title_markup_end()
{ ?>
	</div>
<?php
}




add_action('woocommerce_single_product_summary', 'ambed_template_single_rating');
function ambed_template_single_rating()
{
?>
	<div class="product-details__content__rating">
		<?php wc_get_template('single-product/rating.php'); ?>
	</div>

<?php
}

add_action('woocommerce_single_product_summary', 'ambed_template_single_excerpt');
function ambed_template_single_excerpt()
{
?>
	<div class="product-details__content__text">
		<?php wc_get_template('single-product/short-description.php'); ?>
	</div>

<?php
}


add_action('woocommerce_before_add_to_cart_quantity', 'ambed_add_to_cart_input_markup_start');

function ambed_add_to_cart_input_markup_start()
{ ?>
	<div class="product-details__quantity">
		<div class="product-details__quantity-title"><?php esc_html_e('Quantity', 'ambed'); ?></div>
		<!-- /.product-details__quantity -->
	<?php }

add_action('woocommerce_after_add_to_cart_quantity', 'ambed_add_to_cart_input_markup_end');

function ambed_add_to_cart_input_markup_end()
{ ?>
	</div>

<?php }
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');

add_action('woocommerce_after_add_to_cart_quantity', 'ambed_wishlist');
function ambed_wishlist()
{
	if (class_exists('WPCleverWoosw')) {
		echo do_shortcode('[woosw]');
	}
}

add_action('woocommerce_after_add_to_cart_quantity', 'ambed_after_add_to_cart_quantity');
function ambed_after_add_to_cart_quantity()
{ ?>
	<div class="product-details__buttons">
	<?php }

add_action('woocommerce_after_add_to_cart_button', 'ambed_after_add_to_cart_button');
function ambed_after_add_to_cart_button()
{
	?>
	</div>
<?php }
//social share
add_action('woocommerce_single_product_summary', 'ambed_product_details_social_share');
function ambed_product_details_social_share()
{
	global $post;
	//get current page url
	$ambed_url = urlencode_deep(get_permalink());
	//get current page title
	$ambed_title = str_replace(' ', '%20', get_the_title($post->ID));
	//get post thumbnail for pinterest
	$ambed_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

	//all social share link generate
	$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $ambed_url;
	$twitter_share_link = 'https://twitter.com/intent/tweet?text=' . $ambed_title . '&amp;url=' . $ambed_url . '&amp;via=Crunchify';;
	$linkedin_share_link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $ambed_url . '&amp;title=' . $ambed_title;;
	$pinterest_share_link = 'https://pinterest.com/pin/create/button/?url=' . $ambed_url . '&amp;media=' . $ambed_thumbnail[0] . '&amp;description=' . $ambed_title;

?>
	<div class="product-details__social">
		<div class="title">
			<h3><?php esc_html_e('Share with friends', 'ambed'); ?></h3>
		</div>
		<!-- /.product-details__social -->
		<div class="product-details__social-link">
			<a href="<?php echo esc_url($facebook_share_link); ?>"><span class="fab fa-twitter"></span></a>
			<a href="<?php echo esc_url($twitter_share_link); ?>"><span class="fab fa-facebook"></span></a>
			<a href="<?php echo esc_url($linkedin_share_link); ?>"><span class="fab fa-pinterest-p"></span></a>
			<a href="<?php echo esc_url($linkedin_share_link); ?>"><span class="fab fa-linkedin"></span></a>
		</div>
	</div>
<?php
}


add_action('woocommerce_after_single_product', 'ambed_product_content');

function ambed_product_content()
{ ?>
	<section class="product-content product-description">
		<h2 class="product-description__title"><?php esc_html_e('Description', 'ambed'); ?></h2><!-- /.product-description__title -->
		<?php the_content(); ?>
	</section><!-- /.product-content -->
<?php }

function ambed_register_fields()
{ ?>
	<p class="form-row form-row-first">
		<label for="reg_billing_first_name"><?php _e('First name', 'ambed'); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr($_POST['billing_first_name']); ?>" />
	</p>
	<p class="form-row form-row-last">
		<label for="reg_billing_last_name"><?php _e('Last name', 'ambed'); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr($_POST['billing_last_name']); ?>" />
	</p>
	<div class="clear"></div>
<?php
}
add_action('woocommerce_register_form_start', 'ambed_register_fields');

add_filter('woocommerce_checkout_fields', 'ambed_billing_checkout_fields', 20, 1);
function ambed_billing_checkout_fields($fields)
{
	$fields['billing']['billing_first_name']['placeholder'] = esc_html__('First Name', 'ambed');
	$fields['billing']['billing_last_name']['placeholder'] = esc_html__('Last Name', 'ambed');
	$fields['billing']['billing_company']['placeholder'] = esc_html__('Company name (optional)', 'ambed');
	$fields['billing']['billing_city']['placeholder'] = esc_html__('Town / City', 'ambed');
	$fields['billing']['billing_postcode']['placeholder'] = esc_html__('ZIP Code', 'ambed');
	$fields['billing']['billing_phone']['placeholder'] = esc_html__('Phone', 'ambed');
	$fields['billing']['billing_email']['placeholder'] = esc_html__('Email', 'ambed');
	return $fields;
}

add_filter('woocommerce_checkout_fields', 'ambed_shipping_checkout_fields', 20, 1);
function ambed_shipping_checkout_fields($fields)
{
	$fields['shipping']['shipping_first_name']['placeholder'] = esc_html__('First Name', 'ambed');
	$fields['shipping']['shipping_last_name']['placeholder'] = esc_html__('Last Name', 'ambed');
	$fields['shipping']['shipping_company']['placeholder'] = esc_html__('Company name (optional)', 'ambed');
	return $fields;
}


// WooCommerce Checkout Fields Hook
add_filter('woocommerce_checkout_fields', 'ambed_checkout_fields_no_label');

// Our hooked in function - $fields is passed via the filter!
// Action: remove label from $fields
function ambed_checkout_fields_no_label($fields)
{
	// loop by category
	foreach ($fields as $category => $value) {
		// loop by fields
		foreach ($fields[$category] as $field => $property) {
			// remove label property
			unset($fields[$category][$field]['label']);
		}
	}
	return $fields;
}
