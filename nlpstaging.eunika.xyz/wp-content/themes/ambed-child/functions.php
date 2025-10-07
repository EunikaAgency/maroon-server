<?php
// Exit if accessed directly

use function ElementorDeps\DI\get;

if (!defined('ABSPATH')) exit;


/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function ambed_child_theme_setup() {
    load_child_theme_textdomain('ambed-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'ambed_child_theme_setup');

if (!function_exists('ambed_child_thm_parent_css')) :
    function ambed_child_thm_parent_css() {
        // loading parent styles
        wp_enqueue_style('ambed-parent-style', get_template_directory_uri() . '/style.css', array('ambed-fonts', 'ambed-icons', 'bootstrap', 'fontawesome'));

        // loading child style based on parent style
        wp_enqueue_style('ambed-style', get_stylesheet_directory_uri() . '/style.css', array('ambed-parent-style'));
    }

endif;
add_action('wp_enqueue_scripts', 'ambed_child_thm_parent_css');

// END ENQUEUE PARENT ACTION
require get_stylesheet_directory() . '/static/floating-google-reviews.php';



// //Google Review Fethcing
// function get_google_five_star_reviews()
// {
//     $apiKey = "2b90a677812a8cb13b3671b05b9bfa9364fc08fc";  // Replace with your actual API key
//     $placeId = "ChIJt3chYvI_1moRrTV7QW3pSiA";  // Replace with your business place ID

//     // Prepare API Request
//     $postData = ["placeId" => $placeId];

//     // Convert post data to JSON
//     $data = json_encode($postData);

//     // Set up HTTP headers
//     $options = [
//         'http' => [
//             'method' => 'POST',
//             'header' => [
//                 "X-API-KEY: $apiKey",
//                 'Content-Type: application/json'
//             ],
//             'content' => $data,
//             'timeout' => 10, // Timeout in seconds
//         ]
//     ];

//     // Create a stream context
//     $context = stream_context_create($options);

//     // Send the POST request and get the response
//     $response = file_get_contents('https://google.serper.dev/reviews', false, $context);

//     // Check for errors
//     if ($response === FALSE) {
//         die('Error occurred while sending request');
//     }

//     // Decode the JSON response into an associative array
//     $responseData = json_decode($response, true);

//     // Check if decoding was successful
//     if (json_last_error() !== JSON_ERROR_NONE) {
//         die('Error decoding JSON response');
//     }

//     // Output the response as JSON format
//     header('Content-Type: application/json');

//     return $responseData;
// }

// function insert_google_review()
// {
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'google_reviews'; // Adjust table name

//     // Get today's date in MySQL format (YYYY-MM-DD)
//     $today = date('Y-m-d');

//     // Check if a review is already inserted today
//     $existing_review = $wpdb->get_var($wpdb->prepare(
//         "SELECT COUNT(*) FROM $table_name WHERE DATE(created_at) = %s",
//         $today
//     ));

//     // If no review exists for today, insert the new data
//     if ($existing_review == 0) {
//         $data = get_google_five_star_reviews(); // Fetch reviews
//         $wpdb->insert(
//             $table_name,
//             [
//                 'data'       => maybe_serialize($data), // Convert array to string for DB
//                 'created_at' => current_time('mysql')  // Current timestamp
//             ],
//             [
//                 '%s', // Data as text
//                 '%s'  // DateTime format
//             ]
//         );
//     }
// }
// if (!wp_next_scheduled('insert_google_review_cron')) {
//     wp_schedule_event(time(), 'daily', 'insert_google_review_cron');
// }
// add_action('insert_google_review_cron', 'insert_google_review');

// // Google Review Json Read 
// function google_review_handler()
// {
//     if (isset($_POST['google_review']) && $_POST['google_review'] === 'get_googledata') {
//         // Fetch the 5-star reviews
//         $data = get_google_five_star_reviews();

//         // Return JSON response
//         wp_send_json_success(array(
//             'status' => 'success',
//             'data' => $data
//         ));
//     } else {
//         // Handle invalid requests
//         wp_send_json_error(array(
//             'status' => 'error',
//             'message' => 'Invalid request'
//         ));
//     }
// }
// add_action('wp_ajax_google_review', 'google_review_handler');
// add_action('wp_ajax_nopriv_google_review', 'google_review_handler');


function get_google_five_star_reviews() {
    $apiKey = "2b90a677812a8cb13b3671b05b9bfa9364fc08fc";  // Replace with your actual API key
    $placeId = "ChIJt3chYvI_1moRrTV7QW3pSiA";  // Replace with your business place ID

    // Prepare API Request
    $postData = ["placeId" => $placeId];

    // Convert post data to JSON
    $data = json_encode($postData);

    // Set up HTTP headers
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                "X-API-KEY: $apiKey",
                'Content-Type: application/json'
            ],
            'content' => $data,
            'timeout' => 10, // Timeout in seconds
        ]
    ];

    // Create a stream context
    $context = stream_context_create($options);

    // Send the POST request and get the response
    $response = file_get_contents('https://google.serper.dev/reviews', false, $context);

    // Check for errors
    if ($response === FALSE) {
        die('Error occurred while sending request');
    }

    // Decode the JSON response into an associative array
    $responseData = json_decode($response, true);

    // Check if decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response');
    }

    // Filter 5-star reviews
    $fiveStarReviews = array_filter($responseData['reviews'], function ($review) {
        return isset($review['rating']) && $review['rating'] == 5;
    });

    return $responseData;
}


function insert_google_review() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'google_reviews';

    // Fetch the latest created_at timestamp
    $date = $wpdb->get_var("SELECT created_at FROM $table_name ORDER BY created_at DESC LIMIT 1");

    error_log("Last entry timestamp: " . ($date ?: 'No previous entry')); // Debugging

    // If no previous entry, allow insertion
    if ($date) {
        $last_entry_time = strtotime($date); // Convert to timestamp

        if (!$last_entry_time) {
            error_log('Invalid timestamp from database.');
            return;
        }

        $current_time = time(); // Current timestamp

        if (($current_time - $last_entry_time) < 86400) { // 86400 seconds = 24 hours
            error_log('Skipping insert: Last entry is less than 24 hours old.');
            return;
        }
    }

    // Fetch new 5-star reviews
    $data = get_google_five_star_reviews();

    if (empty($data) || !isset($data['reviews'])) {
        error_log('No valid review data received.');
        return;
    }

    // Insert new review data into the database
    $inserted = $wpdb->insert(
        $table_name,
        [
            'data'       => wp_json_encode($data), // Encode JSON for storage
            'created_at' => current_time('mysql')
        ],
        ['%s', '%s']
    );

    if ($inserted === false) {
        error_log('Database insert failed: ' . $wpdb->last_error);
    } else {
        error_log('Data successfully inserted.');
    }
}

do_action('insert_google_review_cron');


// Google Review Json Read
function google_review_handler() {
    if (isset($_POST['google_review']) && $_POST['google_review'] === 'get_googledata') {
        // Fetch the 5-star reviews
        $data = get_google_five_star_reviews();

        // Return JSON response
        wp_send_json_success(array(
            'status' => 'success',
            'data' => $data
        ));
    } else {
        // Handle invalid requests
        wp_send_json_error(array(
            'status' => 'error',
            'message' => 'Invalid request'
        ));
    }
}
add_action('wp_ajax_google_review', 'google_review_handler');
add_action('wp_ajax_nopriv_google_review', 'google_review_handler');



add_action('wp_head', function () {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
});


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('custom-google-forms-css', get_stylesheet_directory_uri() . '/css/gravity-form.css', array(), time());
}, PHP_INT_MAX);






// --------------

/**
 * Hide elements until user interaction (scroll, click, mouse move) to optimize LCP.
 * Usage: Add class "display-on-interaction" to elements you want to delay.
 */
function optimize_lcp_loading() {
    // CSS: Hide elements initially and fade them in after interaction
    echo '<style id="lcp-optimization-css">
        .display-on-interaction {
            opacity: 0 hidden !important;
            visibility: hidden !important;
            display: none  !important;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        body.user-active .display-on-interaction {
            opacity: 1  !important;
            visibility: visible  !important;
            display: inherit  !important;
        }
    </style>';

    // JavaScript: Add 'user-active' class on any user interaction
    echo '<script>
    (function() {
        var userInteracted = false;
        var interactionEvents = [
            "scroll", "mousedown", "mousemove", "touchstart", 
            "click", "keydown", "wheel"
        ];
        
        function handleInteraction() {
            if (!userInteracted) {
                userInteracted = true;
                document.body.classList.add("user-active");
                // Remove event listeners after first interaction
                interactionEvents.forEach(function(event) {
                    window.removeEventListener(event, handleInteraction);
                });
            }
        }
        
        // Set up event listeners for all interaction types
        interactionEvents.forEach(function(event) {
            window.addEventListener(event, handleInteraction, { 
                passive: true,
                capture: true
            });
        });
        
        // Fallback in case of no interaction (show after 5 seconds)
        setTimeout(function() {
            if (!userInteracted) {
                document.body.classList.add("user-active");
            }
        }, 10000);
    })();
    </script>';
}
add_action('wp_head', 'optimize_lcp_loading', 1);


function deregister_jquery_migrate_on_quote_page() {
    // Check if we're on the quote page
    if (is_page('quote')) { // If 'quote' is the page slug
        // Alternative check if needed:
        // if (strpos($_SERVER['REQUEST_URI'], '/quote/') !== false) {


        // wp_deregister_script('jquery-migrate');
    }
}
add_action('wp_enqueue_scripts', 'deregister_jquery_migrate_on_quote_page', 100);


function exclude_gravityforms_scripts_from_cache($exclude) {
    // Array of scripts to exclude from caching
    $gravityforms_scripts = array(
        'jquery.json.min.js',
        'gravityforms.min.js',
        'conditional_logic.min.js',
        'placeholders.jquery.min.js',
        'utils.min.js',
        'vendor-theme.min.js',
        'scripts-theme.min.js'
    );
    
    foreach ($gravityforms_scripts as $script) {
        if (strpos($_SERVER['REQUEST_URI'], $script) !== false) {
            $exclude = true;
            break;
        }
    }
    
    return $exclude;
}
add_filter('w3tc_should_cache_request', 'exclude_gravityforms_scripts_from_cache');



// -----------------
/**
 * Register custom API endpoints for image upload from URL
 */
function register_image_upload_endpoints() {
    // POST endpoint (recommended)
    register_rest_route('custom/v1', '/upload-image/', array(
        'methods' => 'POST',
        'callback' => 'handle_image_upload_from_url',
        'permission_callback' => function () {
            return current_user_can('upload_files');
        },
        'args' => array(
            'image_url' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return filter_var($param, FILTER_VALIDATE_URL);
                }
            ),
            'title' => array(
                'required' => false,
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'alt_text' => array(
                'required' => false,
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field'
            )
        )
    ));

    // GET endpoint (added for convenience)
    register_rest_route('custom/v1', '/upload-image/', array(
        'methods' => 'GET',
        'callback' => 'handle_image_upload_from_url',
        'permission_callback' => function () {
            return current_user_can('upload_files');
        },
        'args' => array(
            'image_url' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return filter_var($param, FILTER_VALIDATE_URL);
                }
            ),
            'title' => array(
                'required' => false,
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'alt_text' => array(
                'required' => false,
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field'
            )
        )
    ));
}
add_action('rest_api_init', 'register_image_upload_endpoints');

/**
 * Handle image upload from URL (works for both GET and POST)
 */
function handle_image_upload_from_url(WP_REST_Request $request) {
    $image_url = $request->get_param('image_url');
    $title = $request->get_param('title');
    $alt_text = $request->get_param('alt_text');

    // Check if the URL is valid
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        return new WP_Error('invalid_url', 'Invalid image URL provided', array('status' => 400));
    }

    // Check if the URL points to an image
    $file_headers = @get_headers($image_url);
    if (!$file_headers || strpos($file_headers[0], '200') === false) {
        return new WP_Error('invalid_image', 'The URL does not point to a valid image', array('status' => 400));
    }

    // Upload the image
    $upload = upload_image_from_url($image_url, $title, $alt_text);

    if (is_wp_error($upload)) {
        return $upload;
    }

    return new WP_REST_Response(array(
        'success' => true,
        'data' => array(
            'id' => $upload['attachment_id'],
            'url' => $upload['url'],
            'title' => $title,
            'alt_text' => $alt_text
        )
    ), 200);
}

/**
 * Upload image from URL to WordPress media library
 */
function upload_image_from_url($image_url, $title = '', $alt_text = '') {
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Download the image to a temporary file
    $tmp = download_url($image_url);
    if (is_wp_error($tmp)) {
        return $tmp;
    }

    // Get the file name from the URL
    $file_name = basename(parse_url($image_url, PHP_URL_PATH));
    
    // If title is empty, use the filename without extension as title
    if (empty($title)) {
        $title = preg_replace('/\.[^.]+$/', '', $file_name);
    }

    // Prepare the file array
    $file_array = array(
        'name' => $file_name,
        'tmp_name' => $tmp
    );

    // Upload the image
    $attachment_id = media_handle_sideload($file_array, 0, $title);

    // Clean up temporary file
    @unlink($tmp);

    if (is_wp_error($attachment_id)) {
        return $attachment_id;
    }

    // Update alt text if provided
    if (!empty($alt_text)) {
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
    }

    // Get the attachment URL
    $attachment_url = wp_get_attachment_url($attachment_id);

    return array(
        'attachment_id' => $attachment_id,
        'url' => $attachment_url
    );
}