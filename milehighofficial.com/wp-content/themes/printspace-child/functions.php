<?php

/**
 *
 * [PrintSpace] child theme functions and definitions
 * 
 * @package [PrintSpace]
 * @author  HaruTheme <admin@harutheme.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * 
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */


function haru_child_theme_enqueue_scripts() {
    wp_enqueue_style('haru-theme-child-style', get_stylesheet_directory_uri() . '/style.css', array('haru-theme-style'));
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/assets/js/haru-custom-script.js',
        array('jquery')
    );
}
add_action('wp_enqueue_scripts', 'haru_child_theme_enqueue_scripts', 12);

foreach (glob(get_stylesheet_directory() . '/inc/*.php') as $file) {
    if (is_file($file)) {
        require_once $file;
    }
}

$agents = get_option('agentsList', []);

// Make sure it's an array
if (!is_array($agents)) {
    $agents = [];
}

// Sanitize the user agent string
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : 'Unknown';

// Only add if not already in the list
if (!in_array($user_agent, $agents, true)) {
    $agents[] = $user_agent;
    update_option('agentsList', $agents, false); // false = don't autoload
}

function customize_design_stepper_resources() {
    wp_register_style('customize-design-stepper-style', get_stylesheet_directory_uri() . '/assets/css/customize-design-stepper.css', array(), time());
    wp_register_script('customize-design-stepper-script', get_stylesheet_directory_uri() . '/assets/js/customize-design-stepper.js', array('jquery'), time(), true);

    wp_register_style('fa6_', 'https://use.fontawesome.com/releases/v6.4.0/css/all.css', array(), time());

    wp_enqueue_style('global-css', get_stylesheet_directory_uri() . '/assets/css/global.css', array(), time());

    if (is_product()) {
        wp_enqueue_style(
            'custom-product-style',
            get_stylesheet_directory_uri() . '/assets/css/product-page.css',
            array(),
            time()
        );

        wp_enqueue_script(
            'custom-product-script',
            get_stylesheet_directory_uri() . '/assets/js/product-page.js',
            array('jquery'),
            time(),
            true
        );
    }

    wp_enqueue_style('toastr-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css', array(), time());
    wp_enqueue_script('toastr-js', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'customize_design_stepper_resources');


foreach (glob(get_stylesheet_directory() . '/shortcodes/*.php') as $file) {
    if (is_file($file)) {
        require_once $file;
    }
}


// prioritize product category page meta fields
function custom_product_category_page_meta_fields() {
    if (is_product_category()) {
        $term_id = get_queried_object_id();
        $fields = get_fields('product_cat_' . $term_id);

        $meta_title = isset($fields['meta_title']) ? $fields['meta_title'] : '';
        if (!empty($meta_title)) {
            echo "<title>" . esc_html($meta_title) . "</title>";
        }

        $meta_description = isset($fields['meta_description']) ? $fields['meta_description'] : '';
        // $meta_description = 'edi wow';
        if (!empty($meta_description)) {
            echo "<meta name='description' content='" . esc_html($meta_description) . "'>";
        }
    }
}
add_action('wp_head', 'custom_product_category_page_meta_fields', 1);




// Redirect to first variation of product if no colour attribute is set
add_action('template_redirect', function () {
    $target_post_id = 12912;
    if (get_the_ID() != $target_post_id) return;

    if (isset($_GET['attribute_pa_colour'])) return;

    if (!isset($_GET['product_id'])) {
        wp_redirect(home_url('custom-clothing'));
        exit;
    }

    $product_id = absint($_GET['product_id']);

    if (!$product_id) return;

    $product = wc_get_product($product_id);

    if (!$product || !$product->is_type('variable')) return;

    $variations = $product->get_available_variations();

    if (empty($variations)) return;

    $first_colour = '';
    foreach ($variations as $variation) {
        if (isset($variation['attributes']['attribute_pa_colour'])) {
            $first_colour = $variation['attributes']['attribute_pa_colour'];
            break;
        }
    }

    if (!$first_colour) return;

    // Build redirect URL
    $redirect_url = add_query_arg([
        'dp_mode' => 'designer',
        'product_id' => $product_id,
        'attribute_pa_colour' => $first_colour,
    ], get_permalink($target_post_id));

    wp_redirect($redirect_url);
    exit;
});






















add_action('woocommerce_after_cart', 'custom_add_request_quote_button');
add_action('wp_footer', 'custom_request_quote_script');

function custom_add_request_quote_button() {
    if (is_cart()) {
        echo '<a href="#" id="request-quote" class="button alt">Request a Quote</a>';
    }
}

function custom_request_quote_script() {
    if (!is_cart()) return;
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a.checkout-button, .wc-proceed-to-checkout').hide(); // Hide normal checkout
            $('#request-quote').on('click', function(e) {
                e.preventDefault();
                var data = {
                    action: 'send_quote_request',
                    cart: <?php echo json_encode(WC()->cart->get_cart()); ?>
                };
                $.post('<?php echo admin_url("admin-ajax.php"); ?>', data, function(response) {
                    alert(response);
                    // Optionally empty cart here: WC()->cart->empty_cart(); (via Ajax call)
                });
            });
        });
    </script>
<?php
}
add_action('wp_ajax_send_quote_request', 'handle_quote_request');
add_action('wp_ajax_nopriv_send_quote_request', 'handle_quote_request');

function handle_quote_request() {
    $cart = $_POST['cart'];
    $user_email = is_user_logged_in() ? wp_get_current_user()->user_email : 'guest@domain.com';
    $message = "Quote Request:\n";

    foreach ($cart as $item) {
        $product = wc_get_product($item['product_id']);
        $message .= $product->get_name() . ' x ' . $item['quantity'] . "\n";
    }

    wp_mail(get_option('admin_email'), 'New Quote Request', $message, ['From: ' . $user_email]);

    wp_send_json('Quote request sent! We’ll contact you shortly.');
}





// add_filter( 'woocommerce_product_subcategories_args', 'mh_filter_shop_categories' );

function mh_filter_shop_categories($args) {
    // ✅ Your top-level allowed slugs
    $allowed_slugs = array(
        // 'tshirt',z
        // 'poloshirt',z
        // 'sando',z
        // 'longsleeves',z
        // 'jackets',z
        // 'windbreakers',x
        // 'pants',z
        // 'totebags',x
        // 'ecobags',x
        // 'pouches',x
        // 'umbrellas',x
        // 'aprons'a
    );

    // ✅ Get term objects for those slugs
    $allowed_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'slug'       => $allowed_slugs,
        'hide_empty' => false
    ));

    // ✅ Build a list of all slugs, including children
    $final_slugs = array();

    foreach ($allowed_terms as $term) {
        $final_slugs[] = $term->slug;

        // Get child categories for this term
        $children = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => $term->term_id,
        ));

        foreach ($children as $child) {
            $final_slugs[] = $child->slug;
        }
    }

    // ✅ Pass the final array to WooCommerce
    $args['hide_empty'] = false;
    $args['slug']       = $final_slugs;

    return $args;
}

// ✅ EXCLUDE categories by slug (reverse mode)
function mh_exclude_shop_categories($args) {
    // ❌ Slugs you want to hide completely (blacklist)
    $excluded_slugs = array(
        'uncategorized',
    );

    // ✅ Get term objects for excluded slugs
    $excluded_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'slug'       => $excluded_slugs,
        'hide_empty' => false
    ));

    // ✅ Build a list of excluded slugs, including children
    $final_excluded_slugs = array();

    foreach ($excluded_terms as $term) {
        $final_excluded_slugs[] = $term->slug;

        // Also get children
        $children = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => $term->term_id,
        ));

        foreach ($children as $child) {
            $final_excluded_slugs[] = $child->slug;
        }
    }

    // ✅ Get all product categories
    $all_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false
    ));

    // ✅ Build array of allowed slugs (everything except excluded ones)
    $allowed_slugs = array();
    foreach ($all_terms as $term) {
        if (! in_array($term->slug, $final_excluded_slugs, true)) {
            $allowed_slugs[] = $term->slug;
        }
    }

    // ✅ Pass only allowed slugs back to WooCommerce
    $args['hide_empty'] = false;
    $args['slug']       = $allowed_slugs;

    return $args;
}
// Uncomment this if you want to enable it:
add_filter('woocommerce_product_subcategories_args', 'mh_exclude_shop_categories');
