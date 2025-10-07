<?php

/**
 * ambed functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ambed
 */

if (!defined('AMBED_VERSION')) {
    // Replace the version number of the theme on each release.
    define('AMBED_VERSION', '1.0');
}

if (!function_exists('ambed_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function ambed_setup() {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ambed, use a find and replace
		 * to change 'ambed' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('ambed', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        // Set post thumbnail size.
        set_post_thumbnail_size(770, 430, true);

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'ambed'),
            )
        );

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );


        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
endif;
add_action('after_setup_theme', 'ambed_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ambed_content_width() {
    $GLOBALS['content_width'] = apply_filters('ambed_content_width', 640);
}
add_action('after_setup_theme', 'ambed_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ambed_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'ambed'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'ambed'),
            'before_widget' => '<section id="%1$s" class="widget %2$s sidebar__single">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="sidebar__title widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Shop Sidebar', 'ambed'),
            'id'            => 'shop',
            'description'   => esc_html__('Add widgets here.', 'ambed'),
            'before_widget' => '<section id="%1$s" class="shop-category product__sidebar-single widget sidebar__single %2$s"><div class="widget-inner">',
            'after_widget'  => '</div></section>',
            'before_title'  => '<h3 class="product__sidebar-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'ambed_widgets_init');

// google font process

function ambed_fonts_url() {
    $font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ('off' !== _x('on', 'Google font: on or off', 'ambed')) {
        $font_url = add_query_arg('family', urlencode('Rubik:400,400i,500,500i,700,700i,900,900i&subset=latin,latin-ext'), "//fonts.googleapis.com/css");
    }

    return esc_url_raw($font_url);
}


/**
 * Enqueue scripts and styles.
 */
function ambed_scripts() {
    wp_enqueue_style('ambed-fonts', ambed_fonts_url(), array(), null);
    wp_enqueue_style('ambed-icons', get_template_directory_uri() . '/assets/vendors/ambed-icons/style.css', array(), '1.0');
    wp_enqueue_style('flaticons', get_template_directory_uri() . '/assets/vendors/flaticons/css/flaticon.css', array(), '1.1');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/css/bootstrap.min.css', array(), '5.0.0');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/vendors/fontawesome/css/all.min.css', array(), '5.15.1');
    wp_enqueue_style('ambed-style', get_stylesheet_uri(), array(), time());
    wp_style_add_data('ambed-style', 'rtl', 'replace');

    $ambed_get_dark_mode_status = get_theme_mod('ambed_dark_mode', false);

    if (is_page()) {
        $ambed_get_dark_mode_status = get_post_meta(get_the_ID(), 'ambed_enable_dark_mode', true);
    }
    $ambed_dynamic_dark_mode_status = isset($_GET['dark_mode']) ? $_GET['dark_mode'] : $ambed_get_dark_mode_status;
    if ('yes' == $ambed_dynamic_dark_mode_status) {
        wp_enqueue_style('ambed-dark-mode', get_template_directory_uri() . '/assets/css/modes/ambed-dark.css', array(), time());
    }

    $ambed_get_rtl_mode_status = get_theme_mod('ambed_rtl_mode', false);

    if (is_page()) {
        $ambed_rtl_mode_status = get_post_meta(get_the_ID(), 'ambed_enable_rtl_mode', true);

        $ambed_get_rtl_mode_status = empty($ambed_rtl_mode_status) ? $ambed_get_rtl_mode_status : $ambed_rtl_mode_status;
    }

    $ambed_dynamic_rtl_mode_status = isset($_GET['rtl_mode']) ? $_GET['rtl_mode'] : $ambed_get_rtl_mode_status;
    if ('yes' == $ambed_dynamic_rtl_mode_status || true == is_rtl()) {
        wp_enqueue_style('ambed-custom-rtl', get_template_directory_uri() . '/assets/css/ambed-rtl.css', array(), time());
    }

    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/js/bootstrap.min.js', array('jquery'), '5.0.0', true);
    wp_enqueue_script('ambed-theme', get_template_directory_uri() . '/assets/js/ambed-theme.js', array('jquery'), time(), true);



    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ambed_scripts');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Implement the customizer feature.
 */
if (class_exists('Layerdrops\Ambed\Customizer')) {
    require get_template_directory() . '/inc/theme-customizer-styles.php';
}

/**
 * TGMPA Activation.
 */
require get_template_directory() . '/inc/plugins.php';



/*
* one click deomon import
*/
if (class_exists('OCDI_Plugin')) {
    require get_template_directory() . '/inc/demo-import.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}






/**
 * Load Form file.
 */
add_shortcode('forms', function ($attr) {
    if (isset($attr['name'])) {
        // Build the path to the template file in your forms folder
        $template_path = get_template_directory() . '/forms/' . $attr['name'] . '.php';
        if (file_exists($template_path)) {
            ob_start();
            include $template_path;
            return ob_get_clean();
        }
    }
    return '';
});

/**
 * Load Form ajax submit.
 */
function unified_form_submit_handler() {
    $forms = [
        'instant_quote_form' => [
            'title' => 'New Instant Quote Request for House Painting',
            'subheading' => 'A new request for an instant quote has been submitted through the website. Please review the details below:',
            'subject_prefix' => 'New Instant Quote Submission',
        ],
        'quote_form' => [
            'title' => 'New Quote Request Received',
            'subheading' => 'A new quote request has been submitted through the website. Please review the details below:',
            'subject_prefix' => 'New Quote Submission',
        ],
        'contact_form' => [
            'title' => 'New Contact Submission',
            'subheading' => 'A new contact form submission has been received through the website. Please review the details below:',
            'subject_prefix' => 'New Contact Submission',
        ],
        'subscribe_form' => [
            'title' => 'New Subscribe Submission',
            'subheading' => 'A new subscription has been received through the website. Please review the details below:',
            'subject_prefix' => 'New Subscribe Submission',
        ],
    ];


    foreach ($forms as $form_key => $form_data) {
        if (isset($_POST[$form_key])) {
            parse_str(wp_unslash($_POST[$form_key]), $form_values);

            // 🔗 Send to Integromat
            $make_response = wp_remote_post('https://hook.eu2.make.com/a4tmcx7orl8un3xuwgcxrfg72qjwabwb', [
                'method'  => 'POST',
                'headers' => ['Content-Type' => 'application/json'],
                'body'    => wp_json_encode([
                    'form_type' => $form_key,
                    'form_data' => $form_values
                ])
            ]);

            if (is_wp_error($make_response)) {
                error_log('Make/Integromat Error: ' . $make_response->get_error_message());
            }

            // 🔗 Send to Zapier
            $zapier_response = wp_remote_post('https://hooks.zapier.com/hooks/catch/2383614/cfue05/', [
                'method'  => 'POST',
                'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
                'body'    => wp_json_encode([
                    'form_type' => $form_key,
                    'form_data' => $form_values,
                ]),
                'data_format' => 'body'
            ]);
            if (is_wp_error($zapier_response)) {
                error_log('Zapier Error: ' . $zapier_response->get_error_message());
            }




            // 🔗 Send to Pipedrive
            $api_token = '2a6f6bdeeb4b9618d0afc4af7c105f6ee04e8276';

            // Prepare data
            $name   = $form_values['name'] ?? 'Anonymous';
            $email  = $form_values['email'] ?? '';
            $phone  = $form_values['mobile_number'] ?? '';
            $price  = $form_values['estimated_price'] ?? 0;
            $label  = ucwords(str_replace('_', ' ', $form_key));
            $stage_id = 5; // ✅ Use actual working stage ID (e.g., "New lead")

            // STEP 1: Create Person
            $person_res = wp_remote_post("https://api.pipedrive.com/v1/persons?api_token=$api_token", [
                'headers' => ['Content-Type' => 'application/json'],
                'body'    => wp_json_encode([
                    'name'       => $name,
                    'email'      => [['value' => $email, 'primary' => true]],
                    'phone'      => [['value' => $phone, 'primary' => true]],
                    'visible_to' => 3
                ])
            ]);

            // Check for person error
            if (!is_wp_error($person_res)) {
                $person_data = json_decode(wp_remote_retrieve_body($person_res), true);
                $person_id = $person_data['data']['id'] ?? null;

                if ($person_id) {
                    // STEP 2: Create Deal
                    $deal_res = wp_remote_post("https://api.pipedrive.com/v1/deals?api_token=$api_token", [
                        'headers' => ['Content-Type' => 'application/json'],
                        'body'    => wp_json_encode([
                            'title'      => $label . ' - ' . $name,
                            'stage_id'   => $stage_id,
                            'status'     => 'open',
                            'value'      => $price,
                            'currency'   => 'USD',
                            'visible_to' => 3,
                            'person_id'  => $person_id
                        ])
                    ]);

                    if (is_wp_error($deal_res)) {
                        error_log('❌ Pipedrive Deal Error: ' . $deal_res->get_error_message());
                    } else {
                        error_log('✅ Pipedrive Deal Created: ' . wp_remote_retrieve_body($deal_res));
                    }
                } else {
                    error_log('❌ Pipedrive Person Creation Failed: ' . wp_remote_retrieve_body($person_res));
                }
            } else {
                error_log('❌ Pipedrive Person Error: ' . $person_res->get_error_message());
            }




            // Email Logic
            $logo = wp_get_attachment_image_url(379, 'full');
            $email_body_header = [
                'title' => $form_data['title'],
                'subheading' => $form_data['subheading'],
            ];
            $admin_email = 'support@newlinepainting.com.au';
            // $admin_email = 'info@eunika.agency';

            ob_start();
            extract([
                'logo' => $logo,
                'email_body_header' => $email_body_header,
                $form_key => $form_values,
                'admin_email' => $admin_email
            ]);
            include('forms/email/email-notification.php');
            $message = ob_get_clean();

            $subject = 'NewLine Painting "' . $form_data['subject_prefix'] . ' [' . ($form_key === 'subscribe_form' ? $form_values['email'] : $form_values['name']) . ']"';
            $headers = ['Content-Type: text/html; charset=UTF-8'];

            $admin_email_sent = wp_mail($admin_email, $subject, $message, $headers);
            // $admin_email_sent = true;

            if ($admin_email_sent) {
                wp_send_json_success(['status' => 'success']);
            } else {
                wp_send_json_error(['message' => 'Failed to send the email.']);
            }
        }
    }

    wp_send_json_error(['message' => 'No form data received.']);
}

add_action('wp_ajax_unified_form_submit', 'unified_form_submit_handler');
add_action('wp_ajax_nopriv_unified_form_submit', 'unified_form_submit_handler');



add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('swiper-bundle', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], time(), false);
});

/**
 * Load Forms Widget.
 */
// contact form widget
function register_contact_form_widget($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/contact-form-widget.php';
    $widgets_manager->register(new \Contact_Form_Widget());
}
add_action('elementor/widgets/register', 'register_contact_form_widget');

// quote form widget
function register_quote_form_widget($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/quote-form-widget.php';
    $widgets_manager->register(new \Quote_Form_Widget());
}
add_action('elementor/widgets/register', 'register_quote_form_widget');

// subscribe form widget
function register_subscribe_form_widget($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/subscribe-form-widget.php';
    $widgets_manager->register(new \Subscribe_Form_Widget());
}
add_action('elementor/widgets/register', 'register_subscribe_form_widget');


function register_custom_team_members($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/custom-team-members.php';
    $widgets_manager->register(new \Custom_Team_Members());
}
add_action('elementor/widgets/register', 'register_custom_team_members');

function register_custom_image_slide($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/custom-image-slider.php';
    $widgets_manager->register(new \Custom_Image_Slider());
}
add_action('elementor/widgets/register', 'register_custom_image_slide');

function register_custom_google_reviews($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/google-reviews.php';
    $widgets_manager->register(new \GoogleReviews());
}
add_action('elementor/widgets/register', 'register_custom_google_reviews');

function register_faq_with_form_widget($widgets_manager) {
    require_once get_template_directory() . '/forms-widget/faq-with-form-widget.php';
    $widgets_manager->register(new \FAQ_With_Form_Widget());
}
add_action('elementor/widgets/register', 'register_faq_with_form_widget');

// function register_feature_cards_widget($widgets_manager) {
//     require_once get_template_directory() . '/forms-widget/feature-cards-widget.php';
//     $widgets_manager->register(new \Feature_Cards_Widget_());
// }
// add_action('elementor/widgets/register', 'register_feature_cards_widget');












// Widget navbar
// function register_custom_navbar_widget($widgets_manager) {
//     require_once get_template_directory() . '/forms-widget/custom-navbar-widget.php';
//     $widgets_manager->register(new \Custom_Navbar_Widget());
// }
// add_action('elementor/widgets/register', 'register_custom_navbar_widget');
// class Simple_Hover_Dropdown_Walker extends Walker_Nav_Menu {
//     public function start_lvl(&$output, $depth = 0, $args = null) {
//         $output .= '<ul class="sub-menu">';
//     }

//     public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
//         $classes = empty($item->classes) ? array() : (array) $item->classes;
//         $classes[] = 'menu-item-' . $item->ID;
        
//         if ($depth === 0) {
//             $classes[] = 'nav-item';
//         }
        
//         if (in_array('menu-item-has-children', $classes)) {
//             $classes[] = 'menu-item-has-children';
//         }

//         $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
//         $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

//         $output .= '<li' . $class_names . '>';

//         $atts = array();
//         $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
//         $atts['target'] = !empty($item->target)     ? $item->target     : '';
//         $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
//         $atts['href']   = !empty($item->url)        ? $item->url        : '';
//         $atts['class']  = ($depth === 0) ? 'nav-link' : 'dropdown-item';

//         $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

//         $attributes = '';
//         foreach ($atts as $attr => $value) {
//             if (!empty($value)) {
//                 $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
//                 $attributes .= ' ' . $attr . '="' . $value . '"';
//             }
//         }

//         $item_output = $args->before;
//         $item_output .= '<a' . $attributes . '>';
//         $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
//         $item_output .= '</a>';
//         $item_output .= $args->after;

//         $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
//     }

//     public function end_el(&$output, $item, $depth = 0, $args = null) {
//         $output .= '</li>';
//     }

//     public function end_lvl(&$output, $depth = 0, $args = null) {
//         $output .= '</ul>';
//     }
// }

// Custom Footer Widget
// function register_custom_footer_widget($widgets_manager) {
//     require_once get_template_directory() . '/forms-widget/custom-footer-widget.php';
//     $widgets_manager->register(new \Custom_Footer_Widget());
// }
// add_action('elementor/widgets/register', 'register_custom_footer_widget');

// function register_footer_menus() {
//     register_nav_menus([
//         'footer_company_menu' => __('Footer Company Menu'),
//         'footer_areas_menu'   => __('Footer Areas Menu'),
//         'footer_services_menu' => __('Footer Services Menu'),
//         'footer_resources_menu' => __('Footer Resources Menu'),
//         'footer_partners_menu'  => __('Footer Partners Menu'),
//     ]);
// }
// add_action('init', 'register_footer_menus');
