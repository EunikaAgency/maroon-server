<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( defined('EA_ADDONS_PATH') ) {
    require_once EA_ADDONS_PATH . 'includes/class-threads-nav-walker.php';
}

class Threads_Header_Widget extends Widget_Base {

    public function get_name() {
        return 'threads-header';
    }

    public function get_title() {
        return 'Threads Header';
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        $handle   = 'threads-header-css';
        $src      = EA_ADDONS_URL . 'views/threads-header-view/threads-header-view.css';
        $filepath = EA_ADDONS_PATH . 'views/threads-header-view/threads-header-view.css';
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_register_style($handle, $src, [], $ver);
        return [ $handle ];
    }

    public function get_script_depends() {
        $handle   = 'threads-header-js';
        $src      = EA_ADDONS_URL . 'views/threads-header-view/threads-header-view.js';
        $filepath = EA_ADDONS_PATH . 'views/threads-header-view/threads-header-view.js';
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        // Register script first
        wp_register_script($handle, $src, [], $ver, true);

        // Localize *to the same handle*
        wp_localize_script($handle, 'threadsSearch', [
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);

        return [ $handle ];
    }

    private function get_elementor_templates() {
        $templates = [];
        $posts = get_posts([
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        if ($posts) {
            foreach ($posts as $post) {
                $templates[$post->ID] = $post->post_title;
            }
        }

        return $templates;
    }

    protected function register_controls() {

        // ----------------------------
        // CONTENT SECTION
        // ----------------------------
        $this->start_controls_section(
            'general_content',
            ['label' => 'Content']
        );

        $this->add_control(
            'announcement_text',
            [
                'label' => 'Announcement Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'NO MINIMUM ORDER REQUIREMENTS FOR PRINTING',
            ]
        );

        // WP Nav Menu selector
        $menus = wp_get_nav_menus();
        $menu_options = [];
        if($menus){
            foreach($menus as $menu){
                $menu_options[$menu->term_id] = $menu->name;
            }
        }

        $this->add_control(
            'menu',
            [
                'label' => 'Select Menu',
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'description' => 'Choose a WordPress menu to display',
            ]
        );

        // Logo uploader
        $this->add_control(
            'logo',
            [
                'label' => 'Logo',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => EA_ADDONS_URL . 'assets/images/2kthreads-logo.png',
                ],
            ]
        );

        // Cart Configuration Section
        $this->add_control(
            'cart_section_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'cart_type',
            [
                'label' => 'Cart Type',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => 'Default WooCommerce Cart',
                    'shoptimizer' => 'Shoptimizer Cart',
                    'elementor_template' => 'Custom Elementor Template',
                    'custom_html' => 'Custom HTML/Shortcode',
                ],
                'default' => 'default',
                'description' => 'Choose how to display the cart functionality',
            ]
        );

        $this->add_control(
            'cart_template',
            [
                'label' => 'Cart Template',
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_elementor_templates(),
                'description' => 'Choose an Elementor template for custom cart display',
                'condition' => [
                    'cart_type' => 'elementor_template',
                ],
            ]
        );

        $this->add_control(
            'custom_cart_html',
            [
                'label' => 'Custom Cart HTML/Shortcode',
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => 'Enter custom HTML or shortcodes like [woocommerce_cart] or [custom_cart_shortcode]',
                'description' => 'You can use HTML, shortcodes, or PHP snippets here',
                'condition' => [
                    'cart_type' => 'custom_html',
                ],
            ]
        );

        $this->add_control(
            'show_cart_count',
            [
                'label' => 'Show Cart Count',
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => 'Display item count badge on cart icon',
            ]
        );

        $this->add_control(
            'cart_url_override',
            [
                'label' => 'Custom Cart URL',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://yoursite.com/custom-cart',
                'description' => 'Override the default cart URL (leave empty for WooCommerce default)',
                'condition' => [
                    'cart_type' => ['default', 'custom_html'],
                ],
            ]
        );

        // Right Nav: Elementor Template selector (keeping for backward compatibility)
        $this->add_control(
            'nav_right_template',
            [
                'label'       => 'Additional Right Nav Template',
                'type'        => Controls_Manager::SELECT,
                'options'     => $this->get_elementor_templates(),
                'description' => 'Choose an additional Elementor template for extra content in the right navigation area.',
            ]
        );

        $this->end_controls_section();

        // ----------------------------
        // STYLE: Announcement
        // ----------------------------
        $this->start_controls_section(
            'announcement_style',
            [
                'label' => 'Announcement',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'announcement_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-bar' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'announcement_typography',
                'label' => 'Typography',
                'selector' => '{{WRAPPER}} .top-bar',
            ]
        );

        $this->add_responsive_control(
            'announcement_padding',
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .top-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ----------------------------
        // STYLE: Navigation
        // ----------------------------
        $this->start_controls_section(
            'nav_style',
            [
                'label' => 'Navigation',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => 'Link Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nav-left a.item, {{WRAPPER}} .subnav a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_color',
            [
                'label' => 'Link Hover Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nav-left a.item:hover, {{WRAPPER}} .subnav a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nav_typography',
                'label' => 'Typography',
                'selector' => '{{WRAPPER}} .nav-left a, {{WRAPPER}} .subnav a',
            ]
        );

        $this->end_controls_section();

        // ----------------------------
        // STYLE: Logo
        // ----------------------------
        $this->start_controls_section(
            'logo_style',
            [
                'label' => 'Logo',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => 'Logo Width',
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min'=>20,'max'=>300],
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_alignment',
            [
                'label' => 'Alignment',
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => 'Left', 'icon'=>'eicon-h-align-left'],
                    'center' => ['title' => 'Center', 'icon'=>'eicon-h-align-center'],
                    'right' => ['title' => 'Right', 'icon'=>'eicon-h-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo-wrap' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->end_controls_section();

        // ----------------------------
        // STYLE: Cart
        // ----------------------------
        $this->start_controls_section(
            'cart_style',
            [
                'label' => 'Cart',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cart_icon_color',
            [
                'label' => 'Cart Icon Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-slot .icon svg' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .cart-slot .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_count_bg_color',
            [
                'label' => 'Cart Count Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-count' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_cart_count' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cart_count_text_color',
            [
                'label' => 'Cart Count Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-count' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_cart_count' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include EA_ADDONS_PATH . '/views/threads-header-view/threads-header-view.php';
    }
}