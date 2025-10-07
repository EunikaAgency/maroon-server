<?php



foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
    require_once $file;
}

function enqueue_swiper_scripts() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', false, null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_swiper_scripts');











function use_custom_single_product_template($template) {

    if (is_singular('product')) {

        $custom_template = locate_template('woocommerce/custom-single-product.php');

        if ($custom_template) {

            return $custom_template;
        }
    }

    return $template;
}

add_filter('template_include', 'use_custom_single_product_template', 99);



function yourtheme_add_woocommerce_support() {

    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'yourtheme_add_woocommerce_support');



add_action('after_setup_theme', function () {

    add_theme_support('editor-color-palette', array(

        array(

            'name'  => __('Light Gray'),

            'slug'  => 'light-gray',

            'color' => '#ececd6',  // Closest W3Schools color name is LightGray

        ),

        array(

            'name'  => __('Light Gray'),

            'slug'  => 'light-gray',

            'color' => '#D3CFC3',  // Closest W3Schools color name is LightGray

        ),

        array(

            'name'  => __('Dim Gray'),

            'slug'  => 'dim-gray',

            'color' => '#405848',  // Closest W3Schools color name is DimGray

        ),

        array(

            'name'  => __('Dark Slate Gray'),

            'slug'  => 'dark-slate-gray',

            'color' => '#171a1c',  // Closest W3Schools color name is DarkSlateGray

        ),

        array(

            'name'  => __('Black'),

            'slug'  => 'black',

            'color' => '#150D03',  // Closest W3Schools color name is Black

        ),

        array(

            'name'  => __('Olive Drab'),

            'slug'  => 'olive-drab',

            'color' => '#6A7F40',  // Closest W3Schools color name is OliveDrab

        ),

        array(

            'name'  => __('Deep Teal'),

            'slug'  => 'deep-teal',

            'color' => '#004f59',  // Closest W3Schools color name is Teal

        ),

        array(

            'name'  => __('Teal Blue'),

            'slug'  => 'teal-blue',

            'color' => '#192E32',  // Closest W3Schools color name is TealBlue

        ),

        array(

            'name'  => __('Navy'),

            'slug'  => 'navy',

            'color' => '#2C3E50',  // Closest W3Schools color name is Navy

        ),

        array(

            'name'  => __('Tan'),

            'slug'  => 'tan',

            'color' => '#b2936d',  // Closest W3Schools color name is Tan

        ),

        array(

            'name'  => __('Chocolate'),

            'slug'  => 'chocolate',

            'color' => '#362524',  // Closest W3Schools color name is Chocolate

        ),

        array(

            'name'  => __('Rosy Brown'),

            'slug'  => 'rosy-brown',

            'color' => '#7c605f',  // Closest W3Schools color name is RosyBrown

        ),

        array(

            'name'  => __('Saddle Brown'),

            'slug'  => 'saddle-brown',

            'color' => '#421009',  // Closest W3Schools color name is SaddleBrown

        ),

        array(

            'name'  => __('Maroon'),

            'slug'  => 'maroon',

            'color' => '#4e0002',  // Closest W3Schools color name is DarkRed

        ),

        array(

            'name'  => __('Tomato'),

            'slug'  => 'tomato',

            'color' => '#C7632D',  // Closest W3Schools color name is Tomato

        ),

    ));
});







function add_lazy_loading_to_images($content) {

    return str_replace('<img', '<img loading="lazy"', $content);
}

add_filter('the_content', 'add_lazy_loading_to_images');





function my_custom_form_shortcode() {

    // Path to the custom form PHP file

    $file_path = get_template_directory() . '/shortcode/custom-form.php';



    // Check if the file exists before including it

    if (file_exists($file_path)) {

        ob_start(); // Start output buffering

        include $file_path; // Include the custom form PHP file

        return ob_get_clean(); // Return the buffered output

    } else {

        return 'Custom form file not found.';
    }
}



// Register the shortcode with WordPress

add_shortcode('custom_form', 'my_custom_form_shortcode');

/*



function create_event_post_type() {

    $labels = array(

        'name'                  => _x('Events', 'Post Type General Name', 'textdomain'),

        'singular_name'         => _x('Event', 'Post Type Singular Name', 'textdomain'),

        'menu_name'             => __('Events', 'textdomain'),

        'name_admin_bar'        => __('Event', 'textdomain'),

        'archives'              => __('Event Archives', 'textdomain'),

        'attributes'            => __('Event Attributes', 'textdomain'),

        'parent_item_colon'     => __('Parent Event:', 'textdomain'),

        'all_items'             => __('All Events', 'textdomain'),

        'add_new_item'          => __('Add New Event', 'textdomain'),

        'add_new'               => __('Add New', 'textdomain'),

        'new_item'              => __('New Event', 'textdomain'),

        'edit_item'             => __('Edit Event', 'textdomain'),

        'update_item'           => __('Update Event', 'textdomain'),

        'view_item'             => __('View Event', 'textdomain'),

        'view_items'            => __('View Events', 'textdomain'),

        'search_items'          => __('Search Event', 'textdomain'),

        'not_found'             => __('Not found', 'textdomain'),

        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),

        'featured_image'        => __('Featured Image', 'textdomain'),

        'set_featured_image'    => __('Set featured image', 'textdomain'),

        'remove_featured_image' => __('Remove featured image', 'textdomain'),

        'use_featured_image'    => __('Use as featured image', 'textdomain'),

        'insert_into_item'      => __('Insert into event', 'textdomain'),

        'uploaded_to_this_item' => __('Uploaded to this event', 'textdomain'),

        'items_list'            => __('Events list', 'textdomain'),

        'items_list_navigation' => __('Events list navigation', 'textdomain'),

        'filter_items_list'     => __('Filter events list', 'textdomain'),

    );



    $args = array(

        'label'                 => __('Event', 'textdomain'),

        'description'           => __('Post type for events', 'textdomain'),

        'labels'                => $labels,

        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),

        'taxonomies'            => array('category', 'post_tag'),

        'hierarchical'          => false,

        'public'                => true,

        'show_ui'               => true,

        'show_in_menu'          => true,

        'menu_position'         => 5,

        'show_in_rest'          => true,

        'show_in_admin_bar'     => true,

        'show_in_nav_menus'     => true,

        'can_export'            => true,

        'has_archive'           => true,

        'exclude_from_search'   => false,

        'publicly_queryable'    => true,

        'capability_type'       => 'post',

        'rewrite'               => array('slug'=>'events','with_front' => false)

    );



    register_post_type('event', $args);

}







add_action('init', 'create_event_post_type', 0);

*/





// Function to enqueue the detection script in the header

function combined_detection_script_with_cookie() {

?>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            // Function to set a cookie

            function setCookie(name, value, days) {

                let expires = "";

                if (days) {

                    const date = new Date();

                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

                    expires = "; expires=" + date.toUTCString();

                }

                document.cookie = name + "=" + (value || "") + expires + "; path=/";

            }



            // Function to get a cookie

            function getCookie(name) {

                let nameEQ = name + "=";

                let ca = document.cookie.split(';');

                for (let i = 0; i < ca.length; i++) {

                    let c = ca[i];

                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);

                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);

                }

                return null;

            }



            // Check if the user has already been identified

            if (getCookie('user_identified')) {

                document.body.classList.add('identified');

                document.body.classList.remove('not-identified');

            } else {

                let isIdentified = false;



                // Function to detect interaction

                function detectInteraction() {

                    isIdentified = true;

                    document.body.classList.add('identified');

                    document.body.classList.remove('not-identified');

                    // Set a cookie so we don't check the user again in future sessions

                    setCookie('user_identified', 'true', 30); // Cookie lasts for 30 days

                }



                // Set a timer for 10 seconds to check for interaction

                setTimeout(function() {

                    if (!isIdentified) {

                        document.body.classList.add('not-identified');

                        document.body.classList.remove('identified');

                    }

                }, 1000); // 1 second timeout (adjustable)



                // Listen for interactions (mouse move, click, keypress)

                window.addEventListener('mousemove', detectInteraction);

                window.addEventListener('click', detectInteraction);

                window.addEventListener('keydown', detectInteraction);

            }

        });
    </script>

    <?php

}

add_action('wp_head', 'combined_detection_script_with_cookie');





function add_user_agent_class_to_body($classes) {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $keywords = array('bot', 'crawl', 'spider', 'slurp', 'curl', 'wget', 'python', 'headless', 'chrome-lighthouse'); // Add more known strings



    // Check if the user is a bot or not

    $is_bot = false;

    foreach ($keywords as $keyword) {

        if (stripos($user_agent, $keyword) !== false) {

            $is_bot = true;

            break;
        }
    }



    // Add appropriate class based on the result

    $classes[] = $is_bot ? 'not-identified' : 'identified';



    return $classes;
}

add_filter('body_class', 'add_user_agent_class_to_body');




add_action('save_post_event', function ($post_id) {
    // Skip during autosave or if not an 'event' post
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $event_date = get_post_meta($post_id, 'event_date', true);
    $event_time = get_post_meta($post_id, 'event_time', true);

    if ($event_date && $event_time) {
        $datetime_string = $event_date . ' ' . $event_time;
        $event_timestamp = strtotime($datetime_string);
        if ($event_timestamp) {
            update_post_meta($post_id, 'event_datetime', $event_timestamp);
        }
    }
});



// ------------------------------------------------------

function events_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'sort' => 'upcoming'
    ), $atts);

    $sort = strtolower($atts['sort']);
    $output = '<div class="row">';
    $schema_events = array();
    $now = time();

    // Helper to render each card
    if (!function_exists('render_event_card')) {
        function render_event_card($thumbnail, $title, $permalink, $date, $time, $location, $status = '') {
            return '
            <div class="col-md-4 mb-4">
                <div class="card h-100 position-relative">
                    <img src="' . esc_url($thumbnail) . '" class="card-img-top" alt="' . esc_attr($title) . '">
                    <div class="card-body">
                        <h5 class="card-title"><a href="' . esc_url($permalink) . '">' . esc_html($title) . '</a></h5>
                        <p class="card-text d-flex justify-content-between">
                            <strong>' . esc_html($date) . '</strong>
                            <strong>' . esc_html($time) . '</strong>
                        </p>
                        <p class="card-text text-muted">' . esc_html($location) . '</p>
                    </div>
                    ' . $status . '
                </div>
            </div>';
        }
    }

    // 1. Query all upcoming events
    $upcoming_query = new WP_Query(array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => 'event_datetime',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_datetime',
                'value' => $now,
                'compare' => '>=',
                'type' => 'NUMERIC'
            )
        )
    ));

    if ($upcoming_query->have_posts()) {
        while ($upcoming_query->have_posts()) {
            $upcoming_query->the_post();
            $event_id = get_the_ID();

            $event_date = get_post_meta($event_id, 'event_date', true);
            $event_time = get_post_meta($event_id, 'event_time', true);
            $event_location = get_post_meta($event_id, 'event_location', true);
            $event_title = get_post_meta($event_id, 'event_title', true);
            $formatted_event_date = get_post_meta($event_id, 'formatted_event_date', true);
            $event_datetime = strtotime($event_date . ' ' . $event_time);
            $event_time_display = date('g:i A', strtotime($event_time));
            $event_thumbnail = get_the_post_thumbnail_url($event_id, 'medium') ?: 'https://via.placeholder.com/300x200';

            $schema_events[] = array(
                "@context" => "https://schema.org",
                "@type" => "Event",
                "name" => $event_title,
                "startDate" => date('c', $event_datetime),
                "endDate" => date('c', $event_datetime),
                "eventStatus" => "https://schema.org/EventScheduled",
                "eventAttendanceMode" => "https://schema.org/OfflineEventAttendanceMode",
                "location" => array(
                    "@type" => "Place",
                    "name" => $event_location,
                    "address" => array(
                        "@type" => "PostalAddress",
                        "streetAddress" => $event_location,
                        "addressCountry" => "US"
                    )
                ),
                "image" => $event_thumbnail,
                "description" => get_the_excerpt(),
                "performer" => array("@type" => "Organization", "name" => "Red Brick Winery"),
                "organizer" => array("@type" => "Organization", "name" => "Red Brick Winery"),
                "url" => get_permalink()
            );

            $output .= render_event_card($event_thumbnail, $event_title, get_permalink(), $formatted_event_date, $event_time_display, $event_location);
        }
    } else {
        $output .= '<p>No upcoming events found.</p>';
    }

    wp_reset_postdata();

    // 2. Query past events only if sort is 'upcoming'
    if ($sort === 'upcoming') {
        $past_query = new WP_Query(array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key' => 'event_datetime',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'event_datetime',
                    'value' => $now,
                    'compare' => '<',
                    'type' => 'NUMERIC'
                )
            )
        ));

        if ($past_query->have_posts()) {
            $output .= '<h4 class="col-12 mt-4">Past Events</h4>';
            while ($past_query->have_posts()) {
                $past_query->the_post();
                $event_id = get_the_ID();

                $event_date = get_post_meta($event_id, 'event_date', true);
                $event_time = get_post_meta($event_id, 'event_time', true);
                $event_location = get_post_meta($event_id, 'event_location', true);
                $event_title = get_post_meta($event_id, 'event_title', true);
                $formatted_event_date = get_post_meta($event_id, 'formatted_event_date', true);
                $event_datetime = strtotime($event_date . ' ' . $event_time);
                $event_time_display = date('g:i A', strtotime($event_time));
                $event_thumbnail = get_the_post_thumbnail_url($event_id, 'medium') ?: 'https://via.placeholder.com/300x200';

                $output .= render_event_card($event_thumbnail, $event_title, get_permalink(), $formatted_event_date, $event_time_display, $event_location, '<div class="badge badge-danger position-absolute" style="top:10px; right:10px;">Event Ended</div>');
            }
        }

        wp_reset_postdata();
    }

    $output .= '</div>';
    $output .= '<script type="application/ld+json">' . json_encode($schema_events, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';

    return $output;
}
add_shortcode('events_gallery', 'events_gallery_shortcode');



// Register the shortcode with a 'sort' parameter

add_shortcode('events_gallery', 'events_gallery_shortcode');







function wine_product_shortcode($atts) {

    ob_start(); // Start output buffering



    // Set default attributes for the shortcode

    $atts = shortcode_atts(

        array(

            'posts_per_page' => 99,       // Default number of products to display

            'sort' => 'date',             // Default field to sort by

            'sort_order' => 'DESC',       // Default order direction

            'include_category' => '',     // Comma-separated category slugs to include

            'exclude_category' => '',     // Comma-separated category slugs to exclude

            'include_tag' => '',          // Comma-separated tag slugs to include

            'exclude_tag' => '',          // Comma-separated tag slugs to exclude

        ),

        $atts,

        'wine_product_display'

    );



    // Prepare the query arguments for WP_Query

    $args = array(

        'post_type' => 'product',

        'posts_per_page' => intval($atts['posts_per_page']),

        'post_status' => 'publish', // Only show published products

        'tax_query' => array(

            'relation' => 'AND',

        ),

    );



    // Handle SKU sorting if 'sort' is set to 'sku'

    if (!empty($atts['sort']) && $atts['sort'] === 'sku') {

        $args['meta_key'] = '_sku';  // SKU meta key

        $args['orderby'] = 'meta_value';

        $args['order'] = strtoupper($atts['sort_order']) === 'DESC' ? 'DESC' : 'ASC';
    } else {

        // Default to ordering by other fields if SKU is not specified

        $args['orderby'] = sanitize_text_field($atts['sort']);

        $args['order'] = sanitize_text_field($atts['sort_order']);
    }



    // Include specific categories if 'include_category' is provided

    if (!empty($atts['include_category'])) {

        $args['tax_query'][] = array(

            'taxonomy' => 'product_cat',

            'field' => 'slug', // Use 'slug' to target category slugs

            'terms' => explode(',', $atts['include_category']),

            'operator' => 'IN',

        );
    }



    // Exclude specific categories if 'exclude_category' is provided

    if (!empty($atts['exclude_category'])) {

        $args['tax_query'][] = array(

            'taxonomy' => 'product_cat',

            'field' => 'slug', // Use 'slug' to target category slugs

            'terms' => explode(',', $atts['exclude_category']),

            'operator' => 'NOT IN',

        );
    }



    // Include specific tags if 'include_tag' is provided

    if (!empty($atts['include_tag'])) {

        $args['tax_query'][] = array(

            'taxonomy' => 'product_tag',

            'field' => 'slug', // Use 'slug' to target tag slugs

            'terms' => explode(',', $atts['include_tag']),

            'operator' => 'IN',

        );
    }



    // Exclude specific tags if 'exclude_tag' is provided

    if (!empty($atts['exclude_tag'])) {

        $args['tax_query'][] = array(

            'taxonomy' => 'product_tag',

            'field' => 'slug', // Use 'slug' to target tag slugs

            'terms' => explode(',', $atts['exclude_tag']),

            'operator' => 'NOT IN',

        );
    }



    // Execute the query

    $products = new WP_Query($args);



    // Check if we have products

    if ($products->have_posts()) : ?>

        <div class="container my-5">

            <div class="wine-products row">

                <?php while ($products->have_posts()) : $products->the_post();

                    $product = wc_get_product(get_the_ID());



                    if ($product) {

                        $bottle_size = $product->get_attribute('Bottle Size');

                        $price = $product->get_price();

                ?>



                        <div class="col-md-4 col-sm-4 mb-4 card product-card" itemscope itemtype="http://schema.org/Product">

                            <a href="<?php the_permalink(); ?>" class="product-link" aria-label="<?php the_title(); ?>" itemprop="url">

                                <?php if (has_post_thumbnail()) : ?>

                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" class="card-img-top product-image lazy-load" alt="<?php the_title(); ?>" itemprop="image" loading="lazy">

                                <?php else : ?>

                                    <img src="https://via.placeholder.com/300" class="card-img-top product-image lazy-load" alt="Placeholder Image" itemprop="image" loading="lazy">

                                <?php endif; ?>

                            </a>

                            <div class="card-body product-details text-center">

                                <h3 class="card-title product-title" itemprop="name"><?php the_title(); ?></h3>



                                <!-- Offer Schema -->

                                <div class="price product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

                                    <meta itemprop="priceCurrency" content="USD">

                                    <span class="h4 product-price-amount">$<?php echo esc_html(number_format($price, 2)); ?></span>

                                    <meta itemprop="price" content="<?php echo esc_html($price); ?>">



                                    <?php if ($bottle_size) : ?>

                                        <span class="h6 product-bottle-size"> / <?php echo esc_html($bottle_size); ?></span>

                                    <?php endif; ?>

                                </div>



                                <meta itemprop="weight" content="<?php echo esc_html($product->get_weight()); ?>">



                                <div class="cart-button-container mt-3">

                                    <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">

                                        <button type="submit" class="button btn-flat-deep-teal btn-sm add-to-cart-btn"><?php echo esc_html($product->add_to_cart_text()); ?></button>

                                    </form>

                                </div>

                            </div>

                        </div>



                <?php }

                endwhile;

                wp_reset_postdata(); ?>



            </div>

        </div>

    <?php else : ?>

        <p class="no-products-message">No products found. Please add some products to display.</p>

    <?php endif;



    return ob_get_clean();
}

add_shortcode('wine_product_display', 'wine_product_shortcode');






function handle_direct_add_to_cart() {

    if (isset($_GET['join-club'])) {

        global $woocommerce;



        // Get the product slug from the URL

        $product_slug = sanitize_text_field($_GET['join-club']);



        // Get the product ID by its slug

        $product = get_page_by_path($product_slug, OBJECT, 'product');



        if ($product) {

            $product_id = $product->ID;



            // Clear the current cart

            $woocommerce->cart->empty_cart();



            // Add the product to the cart with a quantity of 1

            $woocommerce->cart->add_to_cart($product_id, 1); // Quantity is explicitly set to 1



            // Ensure that the cart contains exactly one product with quantity of 1

            $cart_contents = $woocommerce->cart->get_cart();



            // Loop through the cart to make sure only one item exists

            foreach ($cart_contents as $cart_item_key => $cart_item) {

                // If the cart contains more than one product or the quantity is not 1, reset it

                if (count($cart_contents) > 1 || $cart_item['quantity'] != 1) {

                    $woocommerce->cart->empty_cart(); // Clear the cart again to be safe

                    $woocommerce->cart->add_to_cart($product_id, 1); // Add the correct product with quantity 1

                    break;
                }
            }







            // Redirect to the checkout page with extra validation parameter

            //  wp_redirect(wc_get_checkout_url() . '?verify_cart=' . $product_id);



            wp_redirect("/subscribe-to-wine-club");

            exit;
        }
    }
}

add_action('template_redirect', 'handle_direct_add_to_cart');







// ----------

function recheck_cart_on_checkout() {

    if (is_checkout() && isset($_GET['verify_cart'])) {

        global $woocommerce;



        // Get the product ID from the URL parameter

        $product_id_to_keep = intval($_GET['verify_cart']);



        // Get the current cart contents

        $cart_contents = $woocommerce->cart->get_cart();



        // Flag to track if the product we want to keep is found

        $found_product = false;



        // Loop through the cart and remove products that are not the one with the given product ID

        foreach ($cart_contents as $cart_item_key => $cart_item) {

            if ($cart_item['product_id'] != $product_id_to_keep) {

                // Remove items that are not the product we want

                $woocommerce->cart->remove_cart_item($cart_item_key);
            } else {

                // If we find the correct product, ensure the quantity is set to 1

                $woocommerce->cart->set_quantity($cart_item_key, 1);

                $found_product = true;
            }
        }



        // If the product we want to keep was not found, clear the cart to avoid issues

        if (!$found_product) {

            $woocommerce->cart->empty_cart();

            wp_redirect(wc_get_cart_url()); // Redirect to cart if something goes wrong

            exit;
        }
    }
}

add_action('template_redirect', 'recheck_cart_on_checkout');







add_action('wp_enqueue_scripts', 'custom_checkout_script');



function custom_checkout_script() {

    // Only enqueue the script on the checkout page

    if (is_checkout()) {

    ?>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {

                // Check if the 'verify_cart' parameter is in the URL

                const urlParams = new URLSearchParams(window.location.search);

                if (urlParams.has('verify_cart')) {

                    // Change the button text

                    const button = document.querySelector('.wc-block-components-checkout-place-order-button');

                    const buttonText = button.querySelector('.wc-block-components-button__text');

                    if (buttonText) {

                        buttonText.textContent = 'Complete Your Membership';

                    }

                }

            });
        </script>

<?php

    }
}







// -------------------------------------------------------------------



add_filter('woocommerce_checkout_fields', 'prefill_checkout_fields_from_url');



function prefill_checkout_fields_from_url($fields) {

    // Pre-fill billing first name from URL

    if (isset($_GET['billing_first_name'])) {

        $fields['billing']['billing_first_name']['default'] = sanitize_text_field($_GET['billing_first_name']);
    }



    // Pre-fill billing last name from URL

    if (isset($_GET['billing_last_name'])) {

        $fields['billing']['billing_last_name']['default'] = sanitize_text_field($_GET['billing_last_name']);
    }



    // Pre-fill billing email from URL

    if (isset($_GET['billing_email'])) {

        $fields['billing']['billing_email']['default'] = sanitize_email($_GET['billing_email']);
    }



    // Pre-fill billing phone from URL

    if (isset($_GET['billing_phone'])) {

        $fields['billing']['billing_phone']['default'] = sanitize_text_field($_GET['billing_phone']);
    }



    // Pre-fill billing address 1 from URL

    if (isset($_GET['billing_address_1'])) {

        $fields['billing']['billing_address_1']['default'] = sanitize_text_field($_GET['billing_address_1']);
    }



    // Pre-fill billing city from URL

    if (isset($_GET['billing_city'])) {

        $fields['billing']['billing_city']['default'] = sanitize_text_field($_GET['billing_city']);
    }



    // Pre-fill billing postcode from URL

    if (isset($_GET['billing_postcode'])) {

        $fields['billing']['billing_postcode']['default'] = sanitize_text_field($_GET['billing_postcode']);
    }



    // Pre-fill billing state from URL

    if (isset($_GET['billing_state'])) {

        $fields['billing']['billing_state']['default'] = sanitize_text_field($_GET['billing_state']);
    }



    // Pre-fill billing country from URL

    if (isset($_GET['billing_country'])) {

        $fields['billing']['billing_country']['default'] = sanitize_text_field($_GET['billing_country']);
    }



    return $fields;
}





// -------------------



function enqueue_checkout_prefill_script() {

    if (is_checkout()) {

        wp_enqueue_script('checkout-prefill', get_template_directory_uri() . '/assets/js/checkout-prefill.js', array('jquery'), '1.0', true);
    }
}

add_action('wp_enqueue_scripts', 'enqueue_checkout_prefill_script');



add_filter('woocommerce_cart_shipping_method_full_label', 'custom_local_pickup_label', 10, 2);



function custom_local_pickup_label($label, $method) {

    if ('local_pickup' === $method->method_id) {

        $label = 'Choose Free Pickup Location';



        $pickup_locations = array(

            'Free Pickup from Napa, CA Location',

            'Free Pickup from Philadelphia (Center City)',

            'Free Pickup from Glen Mills, PA Location',

        );



        // Append each location as a selectable option

        foreach ($pickup_locations as $location) {

            $label .= '<br>' . esc_html($location);
        }
    }

    return $label;
}








function regenerate_event_datetime_meta() {
    $events = new WP_Query(array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    while ($events->have_posts()) {
        $events->the_post();
        $post_id = get_the_ID();

        $event_date = get_post_meta($post_id, 'event_date', true);
        $event_time = get_post_meta($post_id, 'event_time', true);

        if ($event_date && $event_time) {
            $datetime_string = $event_date . ' ' . $event_time;
            $event_timestamp = strtotime($datetime_string);
            if ($event_timestamp) {
                update_post_meta($post_id, 'event_datetime', $event_timestamp);
            }
        }
    }

    wp_reset_postdata();
}
regenerate_event_datetime_meta();
