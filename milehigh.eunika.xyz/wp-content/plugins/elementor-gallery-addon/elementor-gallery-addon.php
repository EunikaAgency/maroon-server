<?php
/**
 * Plugin Name: Elementor Gallery Addon
 * Description: Swiper-based gallery widget for Elementor with dynamic template selection and flexible theming options.
 * Version: 1.0
 * Author: Eunika Agency
 */

if (!defined('ABSPATH')) exit;

define('EGA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EGA_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Frontend Assets
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
    wp_enqueue_script('ega-gallery-script', EGA_PLUGIN_URL . 'assets/js/gallery.js', ['swiper'], null, true);
});

// Elementor Widget Registration
add_action('elementor/widgets/register', function ($widgets_manager) {
    require_once EGA_PLUGIN_PATH . 'includes/class-gallery-widget.php';
    $widgets_manager->register(new \Elementor_Gallery_Widget());
});

// Admin Settings Page
add_action('admin_menu', function () {
    add_options_page('Gallery Addon Settings', 'Gallery Addon', 'manage_options', 'ega-settings', function () {
        
        // Save template setting
        if (isset($_POST['ega_template'])) {
            update_option('ega_selected_template', sanitize_text_field($_POST['ega_template']));
            echo '<div class="updated"><p>Template updated successfully!</p></div>';
        }

        $selected = get_option('ega_selected_template', 'template-1');
        ?>
        <div class="wrap">
            <h1>Gallery Addon Settings</h1>

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row">Default Template</th>
                        <td>
                            <select name="ega_template">
                                <option value="template-1" <?php selected($selected, 'template-1'); ?>>Clean Edge – No Gaps</option>
                                <option value="template-2" <?php selected($selected, 'template-2'); ?>>Modern Card – Rounded with Spacing</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button('Save Settings'); ?>
            </form>

            <hr>

            <h2>Theming Guide</h2>
            <p>You can customise the gallery appearance using the following:</p>
            <ul>
                <li>Edit <code>assets/css/gallery.css</code> for general gallery styling.</li>
                <li>Edit <code>assets/css/gallery-style-a.css</code> for template-specific styling.</li>
                <li>Useful CSS classes:
                    <ul>
                        <li><code>.gallery-container</code> – Outer container</li>
                        <li><code>.swiper-slide</code> – Each slide</li>
                        <li><code>.caption-overlay</code> – Full-slide captions</li>
                        <li><code>.caption</code> – Captions below image</li>
                        <li><code>.overlay-top</code>, <code>.overlay-center</code>, <code>.overlay-bottom</code> – Overlay positioning</li>
                    </ul>
                </li>
                <li>Per-widget <strong>Custom CSS</strong> can be applied via Elementor's editor under "Advanced > Custom CSS".</li>
            </ul>
            <p>For advanced customisation, copy the templates in <code>templates/</code> and modify as needed.</p>
        </div>
        <?php
    });
});
