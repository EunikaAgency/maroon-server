<?php
namespace ElementorFAQGF;

// Add this check at the top of widget.php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Check if Elementor is loaded
if (!class_exists('Elementor\Widget_Base')) {
    return;
}


use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_FAQ_Gravity_Form_Widget extends Widget_Base {
    public function get_name() {
        return 'faq_gravity_form';
    }

    public function get_title() {
        return __('FAQ with Gravity Form', 'elementor-faq-gravity-form');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        // Background Section
        $this->start_controls_section(
            'background_section',
            [
                'label' => __('Background', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://nlpstaging.eunika.xyz/wp-content/uploads/2025/05/men-painting-interior-of-home.jpg',
                ],
            ]
        );

        $this->add_control(
            'background_overlay',
            [
                'label' => __('Background Overlay', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(38, 38, 38, 0.83)',
                'selectors' => [
                    '{{WRAPPER}} .main-container::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Heading Section
        $this->start_controls_section(
            'heading_section',
            [
                'label' => __('Heading', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading_text',
            [
                'label' => __('Heading Text', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Melbourne\'s Trusted Painters', 'elementor-faq-gravity-form'),
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Text Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .main-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __('Typography', 'elementor-faq-gravity-form'),
                'selector' => '{{WRAPPER}} .main-heading',
            ]
        );

        $this->end_controls_section();

        // Intro Paragraph Section
        $this->start_controls_section(
            'intro_section',
            [
                'label' => __('Intro Paragraph', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label' => __('Intro Text', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Our professional house painting services in Melbourne offer exceptional quality and transparent pricing. Hire our expert painters - get a free instant quote today!', 'elementor-faq-gravity-form'),
            ]
        );

        $this->add_control(
            'intro_color',
            [
                'label' => __('Text Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .intro-paragraph' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'intro_typography',
                'label' => __('Typography', 'elementor-faq-gravity-form'),
                'selector' => '{{WRAPPER}} .intro-paragraph',
            ]
        );

        $this->end_controls_section();

        // FAQ Section
        $this->start_controls_section(
            'faq_section',
            [
                'label' => __('FAQs', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'faq_title',
            [
                'label' => __('Title', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('FAQ Title', 'elementor-faq-gravity-form'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'faq_content',
            [
                'label' => __('Content', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('FAQ Content', 'elementor-faq-gravity-form'),
                'show_label' => false,
            ]
        );

        $this->add_control(
            'faq_list',
            [
                'label' => __('FAQ Items', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'faq_title' => __('Free colour consultation', 'elementor-faq-gravity-form'),
                        'faq_content' => __('Finding the perfect colour combination for your home can be difficult. Costing up to $400, we provide this service free of charge for all customers.', 'elementor-faq-gravity-form'),
                    ],
                    [
                        'faq_title' => __('7 year guarantee', 'elementor-faq-gravity-form'),
                        'faq_content' => __('Quality and service are our bread and butter. If paint failure appears, we\'ll fix it up at no cost.', 'elementor-faq-gravity-form'),
                    ],
                ],
                'title_field' => '{{{ faq_title }}}',
            ]
        );

        $this->end_controls_section();

        // FAQ Link Section
        $this->start_controls_section(
            'faq_link_section',
            [
                'label' => __('FAQ Link', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'faq_link_text',
            [
                'label' => __('Link Text', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('See all FAQ\'s', 'elementor-faq-gravity-form'),
            ]
        );

        $this->add_control(
            'faq_link_url',
            [
                'label' => __('Link URL', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'elementor-faq-gravity-form'),
                'default' => [
                    'url' => '/faqs/',
                ],
            ]
        );

        $this->add_control(
            'faq_link_color',
            [
                'label' => __('Link Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .faq-link a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'faq_link_hover_color',
            [
                'label' => __('Link Hover Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#D51C0B',
                'selectors' => [
                    '{{WRAPPER}} .faq-link a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // CTA Section
        $this->start_controls_section(
            'cta_section',
            [
                'label' => __('Call to Action', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cta_heading',
            [
                'label' => __('Heading', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Get an <span class="headline-highlight">Instant Quote</span> for your next House Paint', 'elementor-faq-gravity-form'),
            ]
        );

        $this->add_control(
            'cta_background',
            [
                'label' => __('Background Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .cta-container' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cta_text_color',
            [
                'label' => __('Text Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#262626',
                'selectors' => [
                    '{{WRAPPER}} .animated-headline' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label' => __('Highlight Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#D51C0B',
                'selectors' => [
                    '{{WRAPPER}} .highlight-underline path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Gravity Form Section
        $this->start_controls_section(
            'gravity_form_section',
            [
                'label' => __('Gravity Form', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        if (class_exists('GFAPI')) {
            $forms = \GFAPI::get_forms();
            $form_options = ['0' => __('Select a Form', 'elementor-faq-gravity-form')];
            
            foreach ($forms as $form) {
                $form_options[$form['id']] = $form['title'];
            }

            $this->add_control(
                'gravity_form_id',
                [
                    'label' => __('Select Form', 'elementor-faq-gravity-form'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => $form_options,
                    'default' => '0',
                ]
            );

            $this->add_control(
                'gravity_form_title',
                [
                    'label' => __('Display Form Title', 'elementor-faq-gravity-form'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'false',
                    'label_on' => __('Yes', 'elementor-faq-gravity-form'),
                    'label_off' => __('No', 'elementor-faq-gravity-form'),
                ]
            );

            $this->add_control(
                'gravity_form_description',
                [
                    'label' => __('Display Form Description', 'elementor-faq-gravity-form'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'false',
                    'label_on' => __('Yes', 'elementor-faq-gravity-form'),
                    'label_off' => __('No', 'elementor-faq-gravity-form'),
                ]
            );

            $this->add_control(
                'gravity_form_ajax',
                [
                    'label' => __('Enable AJAX', 'elementor-faq-gravity-form'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'true',
                    'label_on' => __('Yes', 'elementor-faq-gravity-form'),
                    'label_off' => __('No', 'elementor-faq-gravity-form'),
                ]
            );
        } else {
            $this->add_control(
                'gravity_form_notice',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('<strong>Gravity Forms is not installed.</strong> Please install and activate Gravity Forms to use this feature.', 'elementor-faq-gravity-form'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                ]
            );
        }

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'elementor-faq-gravity-form'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'accordion_border_color',
            [
                'label' => __('Accordion Border Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,1)',
                'selectors' => [
                    '{{WRAPPER}} .accordion-item' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'accordion_title_color',
            [
                'label' => __('Accordion Title Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .accordion-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'accordion_content_color',
            [
                'label' => __('Accordion Content Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .accordion-body' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'accordion_icon_color',
            [
                'label' => __('Accordion Icon Color', 'elementor-faq-gravity-form'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .accordion-icons i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'accordion_title_typography',
                'label' => __('Accordion Title Typography', 'elementor-faq-gravity-form'),
                'selector' => '{{WRAPPER}} .accordion-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'accordion_content_typography',
                'label' => __('Accordion Content Typography', 'elementor-faq-gravity-form'),
                'selector' => '{{WRAPPER}} .accordion-body',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $unique_id = uniqid('accordion-');

        // Background image
        $background_image = '';
        if (!empty($settings['background_image']['url'])) {
            $background_image = 'style="background-image: url(' . esc_url($settings['background_image']['url']) . ')"';
        }

        // FAQ link
        $faq_link = '';
        if (!empty($settings['faq_link_url']['url'])) {
            $this->add_link_attributes('faq_link', $settings['faq_link_url']);
            $faq_link = '<p class="faq-link"><a ' . $this->get_render_attribute_string('faq_link') . '>' . esc_html($settings['faq_link_text']) . '</a></p>';
        }

        // Gravity Form
        $gravity_form = '';
        if (class_exists('GFAPI') && !empty($settings['gravity_form_id'])) {
            $form_id = absint($settings['gravity_form_id']);
            $title = $settings['gravity_form_title'] === 'yes' ? 'true' : 'false';
            $description = $settings['gravity_form_description'] === 'yes' ? 'true' : 'false';
            $ajax = $settings['gravity_form_ajax'] === 'yes' ? 'true' : 'false';
            
            $gravity_form = do_shortcode('[gravityform id="' . $form_id . '" title="' . $title . '" description="' . $description . '" ajax="' . $ajax . '"]');
        }
        ?>
        
        <div class="main-container" <?php echo $background_image; ?>>
            <div class="container-inner">
                <div class="heading-widget">
                    <h1 class="main-heading"><?php echo esc_html($settings['heading_text']); ?></h1>
                </div>
                <div class="grid-container">
                    <div class="content-container">
                        <div class="paragraph-widget">
                            <p class="intro-paragraph"><?php echo esc_html($settings['intro_text']); ?></p>
                        </div>
                        <div class="accordion-widget">
                            <div class="accordion-container">
                                <div class="accordion" id="<?php echo esc_attr($unique_id); ?>">
                                    <?php foreach ($settings['faq_list'] as $index => $item): 
                                        $collapsed = $index === 0 ? '' : 'collapsed';
                                        $aria_expanded = $index === 0 ? 'true' : 'false';
                                        $show = $index === 0 ? 'show' : '';
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button <?php echo esc_attr($collapsed); ?>" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse-<?php echo esc_attr($unique_id . '-' . $index); ?>" 
                                                aria-expanded="<?php echo esc_attr($aria_expanded); ?>" 
                                                aria-controls="collapse-<?php echo esc_attr($unique_id . '-' . $index); ?>">
                                                <span class="accordion-title"><?php echo esc_html($item['faq_title']); ?></span>
                                                <div class="accordion-icons">
                                                    <div class="accordion-icon-normal">
                                                        <i class="icon icon-down-arrow1"></i>
                                                    </div>
                                                    <div class="accordion-icon-active">
                                                        <i class="icon icon-up-arrow"></i>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?php echo esc_attr($unique_id . '-' . $index); ?>" 
                                            class="accordion-collapse collapse <?php echo esc_attr($show); ?>" 
                                            data-bs-parent="#<?php echo esc_attr($unique_id); ?>">
                                            <div class="accordion-body">
                                                <?php echo wp_kses_post($item['faq_content']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $faq_link; ?>
                    </div>
                    <div class="cta-container">
                        <div class="animated-headline-widget">
                            <div class="headline-container">
                                <h2 class="animated-headline">
                                    <?php echo wp_kses_post($settings['cta_heading']); ?>
                                    <svg class="highlight-underline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 30" preserveAspectRatio="none">
                                        <path d="M5,25 C100,5 400,5 495,25" />
                                    </svg>
                                </h2>
                            </div>
                        </div>
                        <div class="gravityform-container">
                            <?php echo $gravity_form; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <#
        var unique_id = 'accordion-' + Math.random().toString(36).substr(2, 9);
        var background_image = '';
        if (settings.background_image.url) {
            background_image = 'style="background-image: url(' + settings.background_image.url + ')"';
        }
        
        var faq_link = '';
        if (settings.faq_link_url && settings.faq_link_url.url) {
            var link_attributes = 'href="' + settings.faq_link_url.url + '"';
            
            if (settings.faq_link_url.is_external) {
                link_attributes += ' target="_blank"';
            }
            
            if (settings.faq_link_url.nofollow) {
                link_attributes += ' rel="nofollow"';
            }
            
            faq_link = '<p class="faq-link"><a ' + link_attributes + '>' + settings.faq_link_text + '</a></p>';
        }
        
        var gravity_form = '';
        if (settings.gravity_form_id && settings.gravity_form_id !== '0') {
            var title = settings.gravity_form_title === 'yes' ? 'true' : 'false';
            var description = settings.gravity_form_description === 'yes' ? 'true' : 'false';
            var ajax = settings.gravity_form_ajax === 'yes' ? 'true' : 'false';
            
            gravity_form = '[gravityform id="' + settings.gravity_form_id + '" title="' + title + '" description="' + description + '" ajax="' + ajax + '"]';
        }
        #>
        
        <div class="main-container" {{{ background_image }}}>
            <div class="container-inner">
                <div class="heading-widget">
                    <h1 class="main-heading">{{{ settings.heading_text }}}</h1>
                </div>
                <div class="grid-container">
                    <div class="content-container">
                        <div class="paragraph-widget">
                            <p class="intro-paragraph">{{{ settings.intro_text }}}</p>
                        </div>
                        <div class="accordion-widget">
                            <div class="accordion-container">
                                <div class="accordion" id="{{{ unique_id }}}">
                                    <# _.each(settings.faq_list, function(item, index) { 
                                        var collapsed = index === 0 ? '' : 'collapsed';
                                        var aria_expanded = index === 0 ? 'true' : 'false';
                                        var show = index === 0 ? 'show' : '';
                                    #>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{{ collapsed }}}" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse-{{{ unique_id }}}-{{{ index }}}" 
                                                aria-expanded="{{{ aria_expanded }}}" 
                                                aria-controls="collapse-{{{ unique_id }}}-{{{ index }}}">
                                                <span class="accordion-title">{{{ item.faq_title }}}</span>
                                                <div class="accordion-icons">
                                                    <div class="accordion-icon-normal">
                                                        <i class="icon icon-down-arrow1"></i>
                                                    </div>
                                                    <div class="accordion-icon-active">
                                                        <i class="icon icon-up-arrow"></i>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-{{{ unique_id }}}-{{{ index }}}" 
                                            class="accordion-collapse collapse {{{ show }}}" 
                                            data-bs-parent="#{{{ unique_id }}}">
                                            <div class="accordion-body">
                                                {{{ item.faq_content }}}
                                            </div>
                                        </div>
                                    </div>
                                    <# }); #>
                                </div>
                            </div>
                        </div>
                        {{{ faq_link }}}
                    </div>
                    <div class="cta-container">
                        <div class="animated-headline-widget">
                            <div class="headline-container">
                                <h2 class="animated-headline">
                                    {{{ settings.cta_heading }}}
                                    <svg class="highlight-underline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 30" preserveAspectRatio="none">
                                        <path d="M5,25 C100,5 400,5 495,25" />
                                    </svg>
                                </h2>
                            </div>
                        </div>
                        <div class="gravityform-container">
                            {{{ gravity_form }}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}