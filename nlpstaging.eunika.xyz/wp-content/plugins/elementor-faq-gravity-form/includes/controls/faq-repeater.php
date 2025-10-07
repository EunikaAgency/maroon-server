<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_FAQ_Gravity_Form_Widget extends \Elementor\Control_Repeater {

    public function get_type() {
        return 'faq_repeater';
    }

    protected function get_default_settings() {
        return [
            'fields' => [],
            'title_field' => '{{{ faq_title }}}',
            'prevent_empty' => false,
            'is_repeater' => true,
        ];
    }

    public function content_template() {
        ?>
        <label class="elementor-control-title">{{{ data.label }}}</label>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <div class="elementor-repeater-fields-wrapper"></div>
        <# if ( itemActions.add ) { #>
            <div class="elementor-button-wrapper">
                <button class="elementor-button elementor-button-default elementor-repeater-add" type="button">
                    <i class="eicon-plus" aria-hidden="true"></i>
                    <?php echo esc_html__('Add FAQ Item', 'elementor-faq-gravity-form'); ?>
                </button>
            </div>
        <# } #>
        <?php
    }

    protected function get_control_uid($input_name = '') {
        return 'elementor-control-' . $input_name . '_{{ data._cid }}';
    }

    protected function get_default_child_fields($item_index) {
        return [
            [
                'name' => 'faq_title',
                'label' => __('Title', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('FAQ Title', 'elementor-faq-gravity-form'),
                'dynamic' => [
                    'active' => true,
                ],
            ],
            [
                'name' => 'faq_content',
                'label' => __('Content', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('FAQ Content', 'elementor-faq-gravity-form'),
                'dynamic' => [
                    'active' => true,
                ],
            ],
            [
                'name' => 'faq_icon_normal',
                'label' => __('Normal State Icon', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon icon-down-arrow1',
                    'library' => 'elementskit',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-down',
                        'angle-down',
                        'caret-down',
                    ],
                    'fa-regular' => [
                        'arrow-alt-circle-down',
                    ],
                ],
            ],
            [
                'name' => 'faq_icon_active',
                'label' => __('Active State Icon', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon icon-up-arrow',
                    'library' => 'elementskit',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-up',
                        'angle-up',
                        'caret-up',
                    ],
                    'fa-regular' => [
                        'arrow-alt-circle-up',
                    ],
                ],
            ],
        ];
    }

    protected function get_child_fields(array $item, $item_index) {
        $controls = $this->get_default_child_fields($item_index);

        $controls = apply_filters('elementor/faq_repeater/controls', $controls, $item, $item_index);

        return $controls;
    }
}