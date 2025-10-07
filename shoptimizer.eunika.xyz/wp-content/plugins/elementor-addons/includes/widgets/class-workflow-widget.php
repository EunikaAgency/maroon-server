<?php
namespace EA_Addons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Workflow_Widget extends Widget_Base {

    public function get_name() {
        return 'ea-workflow';
    }

    public function get_title() {
        return __( 'Text Slider', 'ea-addons' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        $handle = 'ea-workflow-css';
        $src = EA_ADDONS_URL . 'views/workflow-view/workflow-view.css';
        $filepath = EA_ADDONS_PATH . 'views/workflow-view/workflow-view.css';
        $ver = file_exists($filepath) ? filemtime($filepath) : '1.0.0';
        
        wp_register_style(
            $handle,
            $src,
            [],
            $ver
        );
        return [ $handle ];
    }

    public function get_script_depends() {
        $handle = 'ea-workflow-js';
        $src = EA_ADDONS_URL . 'views/workflow-view/workflow-view.js';
        $filepath = EA_ADDONS_PATH . 'views/workflow-view/workflow-view.js';
        $ver = file_exists($filepath) ? filemtime($filepath) : '1.0.0';
        
        wp_register_script(
            $handle,
            $src,
            [ ],
            $ver,
            true
        );
        return [ $handle ];
    }

    protected function register_controls() {
        /**
         * Content Section
         */
        $this->start_controls_section(
            'workflow_content',
            [ 'label' => __( 'Workflow Steps', 'ea-addons' ) ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'step_title',
            [
                'label' => __( 'Step Title', 'ea-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Step Title', 'ea-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'step_desc',
            [
                'label' => __( 'Step Description', 'ea-addons' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Step description here.', 'ea-addons' ),
            ]
        );

        $this->add_control(
            'steps',
            [
                'label' => __( 'Workflow Steps', 'ea-addons' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'step_title' => '1. Enquire', 'step_desc' => 'Reach out to us with your project idea.' ],
                    [ 'step_title' => '2. Designing', 'step_desc' => 'We collaborate to design your project.' ],
                    [ 'step_title' => '3. Approval', 'step_desc' => 'You approve the final plan before production.' ],
                    [ 'step_title' => '4. Production', 'step_desc' => 'We keep you updated as we produce.' ],
                ],
                'title_field' => '{{{ step_title }}}',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Section - Title
         */
        $this->start_controls_section(
            'workflow_style_title',
            [
                'label' => __( 'Step Title', 'ea-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'ea-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .workflow-step-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .workflow-step-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Spacing (Bottom Margin)', 'ea-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 10 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .workflow-step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Section - Description
         */
        $this->start_controls_section(
            'workflow_style_desc',
            [
                'label' => __( 'Step Description', 'ea-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => __( 'Color', 'ea-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .workflow-step-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .workflow-step-desc',
            ]
        );

        $this->add_responsive_control(
            'desc_spacing',
            [
                'label' => __( 'Spacing (Bottom Margin)', 'ea-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 10 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .workflow-step-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include plugin_dir_path( __FILE__ ) . '../../views/workflow-view/workflow-view.php';
    }
}
