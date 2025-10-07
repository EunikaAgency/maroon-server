<?php
/**
 * Plugin Name: Lazy Load IMG Plugin with Cache
 * Description: A plugin to add lazy loading attributes to all <img> tags by caching content, cleaning the buffer, parsing the cached content, and dynamically applying lazy loading on page load.
 * Version: 1.3
 * Author: Your Name
 */

// Hook to modify the_content directly for lazy loading
add_filter('the_content', 'll_img_parse_output');

/**
 * Parses the content to add lazy loading to <img> tags.
 *
 * @param string $content The content of the post/page.
 * @return string Modified content with lazy loading added to <img> tags.
 */
function ll_img_parse_output($content) {
    // Find all <img> tags and add loading="lazy" attribute
    $content = preg_replace_callback(
        '/<img(.*?)>/i',
        'll_img_add_lazy_load',
        $content
    );
    
    return $content;
}

/**
 * Callback function to add lazy load attribute to <img> tag.
 *
 * @param array $matches The array of matched <img> tag.
 * @return string The modified <img> tag with loading="lazy".
 */
function ll_img_add_lazy_load($matches) {
    // Check if the image already has a loading attribute
    if (strpos($matches[1], 'loading=') === false) {
        return '<img' . $matches[1] . ' loading="lazy">';
    }
    return $matches[0];
}

/**
 * Capture full page output and apply lazy loading to images
 */
add_action('template_redirect', 'll_img_start_buffer');

function ll_img_start_buffer() {
    if (!is_admin()) {
        // Start output buffering
        ob_start('ll_img_parse_buffer_output');
    }
}

/**
 * Parse the full buffered output before sending it to the browser.
 *
 * @param string $content The full page content.
 * @return string The modified content with lazy loading applied to <img> tags.
 */
function ll_img_parse_buffer_output($content) {
    // Parse for lazy loading on all <img> tags
    return ll_img_parse_output($content);
}

add_action('shutdown', 'll_img_end_buffer', 100);

/**
 * End and flush the buffer after parsing.
 */
function ll_img_end_buffer() {
    if (ob_get_length()) {
        ob_end_flush();
    }
}

/**
 * Inject inline JavaScript to monitor and dynamically update <img> tags in the header
 */
function ll_add_inline_lazy_load_js() {
    if (!is_admin()) {
        // Inline JavaScript that monitors and adds lazy loading
        echo '<script type="text/javascript">
            (function() {
                // Start interval that runs every 10ms (100 times per second)
                var intervalId = setInterval(function() {
                    const images = document.querySelectorAll("img");
                    
                    images.forEach(function(img) {
                        if (!img.hasAttribute("loading")) {
                            img.setAttribute("loading", "lazy");
                        }
                    });
                }, 10); // Runs every 10ms

                // Stop the interval after 20 seconds (20000 milliseconds)
                setTimeout(function() {
                    clearInterval(intervalId);
                }, 20000); // 20000ms = 20 seconds
            })();
            </script>';
    }
}
add_action('wp_head', 'll_add_inline_lazy_load_js', 100);
