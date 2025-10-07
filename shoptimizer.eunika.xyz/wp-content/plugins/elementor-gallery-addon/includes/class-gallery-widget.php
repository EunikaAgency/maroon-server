<?php
use Elementor\Widget_Base;

require_once EGA_PLUGIN_PATH . 'includes/GalleryControls.php';

class Elementor_Gallery_Widget extends Widget_Base {
    use GalleryControls;

    public function get_name() {
        return 'gallery_widget';
    }

    public function get_title() {
        return 'Gallery Slider';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['general'];
    }

    public function register_controls() {
        $this->register_gallery_controls();
    }

    public function render() {
        $settings = $this->get_settings_for_display();

        // Determine layout to decide if Swiper is needed
        $layout = isset($settings['gallery_layout']) ? $settings['gallery_layout'] : '';
        $is_static_grid = ($layout === 'grid-layout');

        // Always enqueue core gallery CSS (lightweight)
        $css_file = EGA_PLUGIN_PATH . 'assets/css/gallery.css';
        $css_url  = EGA_PLUGIN_URL . 'assets/css/gallery.css';
        wp_enqueue_style(
            'ega-gallery-style',
            $css_url,
            [],
            file_exists($css_file) ? filemtime($css_file) : null
        );

        // In the Elementor editor: show placeholder + load editor CSS (not on public frontend)
        if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) {
            $editor_css_path = EGA_PLUGIN_PATH . 'assets/css/gallery-editor.css';
            $editor_css_url  = EGA_PLUGIN_URL . 'assets/css/gallery-editor.css';
            wp_enqueue_style('ega-gallery-editor', $editor_css_url, [], file_exists($editor_css_path) ? filemtime($editor_css_path) : null);

            $this->render_editor_placeholder($settings);
            return;
        }

        // Only enqueue Swiper and our gallery JS if NOT the static grid (slider layouts only)
        if (!$is_static_grid) {
            // Swiper CSS/JS from CDN
            wp_enqueue_style(
                'swiper',
                'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
                [],
                null
            );
            wp_enqueue_script(
                'swiper',
                'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
                [],
                null,
                true
            );

            // Our gallery initializer (lazy via IntersectionObserver)
            $gallery_js_path = EGA_PLUGIN_PATH . 'assets/js/gallery.js';
            $gallery_js_url  = EGA_PLUGIN_URL . 'assets/js/gallery.js';
            wp_enqueue_script(
                'ega-gallery-script',
                $gallery_js_url,
                ['swiper'],
                file_exists($gallery_js_path) ? filemtime($gallery_js_path) : null,
                true
            );
        }

        // Frontend Gallery Output
        include EGA_PLUGIN_PATH . "templates/template.php";

        // Custom CSS per widget
        if (!empty($settings['custom_css'])) {
            echo '<style>' . $settings['custom_css'] . '</style>';
        }
    }

    private function render_editor_placeholder($settings) {
        echo '<div class="gallery-editor-placeholder">';
        echo '<strong>Elementor Gallery Addon</strong>';
        echo '<em>Preview disabled in editor. View on live page.</em>';
        echo '<em>Images used:</em>';

        if (!empty($settings['items'])) {
            echo '<ul class="gallery-image-list">';
            foreach ($settings['items'] as $item) {
                if (!empty($item['image']['url'])) {
                    $img_url = esc_url($item['image']['url']);
                    echo "<li><img src=\"{$img_url}\" alt=\"Thumbnail\" /></li>";
                }
            }
            echo '</ul>';
        } else {
            echo '<p>No images added yet.</p>';
        }

        echo '</div>';
    }
}
