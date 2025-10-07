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
        
        $template = $settings['layout_style'] === 'default' 
            ? get_option('ega_selected_template', 'template-1') 
            : $settings['layout_style'];

        $css_file = $template === 'template-1'
            ? EGA_PLUGIN_PATH . 'assets/css/gallery-style-a.css'
            : EGA_PLUGIN_PATH . 'assets/css/gallery.css';

        $css_url = $template === 'template-1'
            ? EGA_PLUGIN_URL . 'assets/css/gallery-style-a.css'
            : EGA_PLUGIN_URL . 'assets/css/gallery.css';

        wp_enqueue_style("ega-gallery-style", $css_url, [], file_exists($css_file) ? filemtime($css_file) : null);

        include EGA_PLUGIN_PATH . "templates/{$template}.php";

        // Output Custom CSS if defined
        if (!empty($settings['custom_css'])) {
            echo '<style>' . $settings['custom_css'] . '</style>';
        }
    }
}
