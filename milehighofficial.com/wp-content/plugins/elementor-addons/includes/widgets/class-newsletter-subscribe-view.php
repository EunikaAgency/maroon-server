<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Newsletter_Subscribe_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-newsletter-subscribe';
    }

    public function get_title() {
        return __( 'Newsletter Subscribe', 'ea-addons' );
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        $handle   = 'ea-newsletter-subscribe';
        $src      = EA_ADDONS_URL . 'views/newsletter-subscribe-view/newsletter-subscribe-view.css';
        $filepath = EA_ADDONS_PATH . 'views/newsletter-subscribe-view/newsletter-subscribe-view.css';
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_register_style($handle, $src, [], $ver);

        return [ $handle ];
    }

    public function get_script_depends() {
        $handle   = 'ea-newsletter-subscribe';
        $src      = EA_ADDONS_URL . 'views/newsletter-subscribe-view/newsletter-subscribe-view.js';
        $filepath = EA_ADDONS_PATH . 'views/newsletter-subscribe-view/newsletter-subscribe-view.js';
        $ver      = file_exists($filepath) ? filemtime($filepath) : false;

        wp_register_script($handle, $src, [ 'jquery' ], $ver, true);

        return [ $handle ];
    }

    protected function register_controls() {

        // Content section
        $this->start_controls_section(
            'content_section',
            [ 'label' => __( 'Newsletter Content', 'ea-addons' ) ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Heading', 'ea-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Subscribe to Our Newsletter', 'ea-addons' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'ea-addons' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Receive exclusive discounts for our releases and stay up to date with our services.', 'ea-addons' ),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __( 'Email Placeholder', 'ea-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Your Email', 'ea-addons' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'ea-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Subscribe', 'ea-addons' ),
            ]
        );

        $this->end_controls_section();

        // Style section for typography
        $this->start_controls_section(
            'style_section',
            [ 'label' => __( 'Typography', 'ea-addons' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );

        // Heading typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Heading Typography', 'ea-addons' ),
                'selector' => '{{WRAPPER}} .ea-newsletter-subscribe .nl-left h2',
            ]
        );

        // Description typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __( 'Description Typography', 'ea-addons' ),
                'selector' => '{{WRAPPER}} .ea-newsletter-subscribe .meta',
            ]
        );

        // Placeholder & Input typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'label' => __( 'Input Typography', 'ea-addons' ),
                'selector' => '{{WRAPPER}} .ea-newsletter-subscribe .email-input, {{WRAPPER}} .ea-newsletter-subscribe .email-input::placeholder',
            ]
        );

        // Button typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'ea-addons' ),
                'selector' => '{{WRAPPER}} .ea-newsletter-subscribe .btn',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include plugin_dir_path( __FILE__ ) . '../../views/newsletter-subscribe-view/newsletter-subscribe-view.php';
    }
}
