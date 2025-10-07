<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit;

class FAQ_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-faq';
    }

    public function get_title() {
        return 'FAQ Accordion';
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        $css_file = EA_ADDONS_PATH . 'views/faq-view/faq-view.css';
        wp_register_style(
            'ea-faq-css',
            EA_ADDONS_URL . 'views/faq-view/faq-view.css',
            [],
            file_exists($css_file) ? filemtime($css_file) : '1.0.0'
        );
        return [ 'ea-faq-css' ];
    }

    public function get_script_depends() {
        $js_file = EA_ADDONS_PATH . 'views/faq-view/faq-view.js';
        wp_register_script(
            'ea-faq-js',
            EA_ADDONS_URL . 'views/faq-view/faq-view.js',
            [ 'jquery' ],
            file_exists($js_file) ? filemtime($js_file) : '1.0.0',
            true
        );
        return [ 'ea-faq-js' ];
    }


    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'faq_content',
            [ 'label' => 'FAQ Items' ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'faq_title',
            [
                'label' => 'Question',
                'type' => Controls_Manager::TEXT,
                'default' => 'Sample question?',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'faq_answer',
            [
                'label' => 'Answer',
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'This is a sample answer.',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'faqs',
            [
                'label' => 'FAQs',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ faq_title }}}',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Controls
         */
        // Question Style
        $this->start_controls_section(
            'faq_question_style',
            [
                'label' => 'Question',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'question_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'question_typography',
                'selector' => '{{WRAPPER}} .ea-faq-title',
            ]
        );

        $this->add_control(
            'question_bg',
            [
                'label' => 'Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-faq-question' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'question_border',
                'selector' => '{{WRAPPER}} .ea-faq-question',
            ]
        );

        $this->end_controls_section();

        // Answer Style
        $this->start_controls_section(
            'faq_answer_style',
            [
                'label' => 'Answer',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'answer_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-faq-answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'answer_typography',
                'selector' => '{{WRAPPER}} .ea-faq-answer',
            ]
        );

        $this->end_controls_section();

        // Icon Style
        $this->start_controls_section(
            'faq_icon_style',
            [
                'label' => 'Icon',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => 'Icon Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ea-faq-icon' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $faqs = $settings['faqs'];

        if ( ! empty( $faqs ) ) {
            include EA_ADDONS_PATH . 'views/faq-view/faq-view.php';
        }
    }

    // Live Preview inside Elementor
    protected function content_template() {
        ?>
        <# if ( settings.faqs.length ) { #>
        <div class="ea-faq-container">
            <# _.each( settings.faqs, function( faq, index ) { #>
                <div class="ea-faq-item">
                    <button class="ea-faq-question" aria-expanded="false">
                        <span class="ea-faq-number">{{{ index + 1 }}}</span>
                        <h4 class="ea-faq-title">{{{ faq.faq_title }}}</h4>
                        <svg class="ea-faq-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="ea-faq-answer">
                        <div>{{{ faq.faq_answer }}}</div>
                    </div>
                </div>
            <# }); #>
        </div>
        <# } #>
        <?php
    }
}
