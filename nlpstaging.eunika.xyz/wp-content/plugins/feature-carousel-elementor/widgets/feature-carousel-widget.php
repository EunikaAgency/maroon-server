<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Feature_Cards_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'feature_carousel';
    }

    public function get_title() {
        return __('Feature Carousel', 'feature-carousel-elementor');
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['hammerjs', 'feature-carousel'];
    }

    public function get_style_depends() {
        return ['feature-carousel'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'feature-carousel-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Icon control
        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        // Title control
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Feature Title', 'feature-carousel-elementor'),
                'label_block' => true,
            ]
        );

        // Description control
        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Feature description goes here', 'feature-carousel-elementor'),
                'label_block' => true,
            ]
        );

        // Link control
        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'feature-carousel-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => __('Features', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Experienced & Professional', 'feature-carousel-elementor'),
                        'description' => __('Trade qualified painters that are invested in your satisfaction.', 'feature-carousel-elementor'),
                    ],
                    [
                        'title' => __('End to end service', 'feature-carousel-elementor'),
                        'description' => __('We leave only after the paint is complete, your home is cleaned and furniture in place.', 'feature-carousel-elementor'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Icon
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __('Icon', 'feature-carousel-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_margin_bottom',
            [
                'label' => __('Margin Bottom', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Card
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card', 'feature-carousel-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_height',
            [
                'label' => __('Height', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Padding', 'feature-carousel-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nlp-feature-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '40',
                    'right' => '30',
                    'bottom' => '40',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <main class="nlp-feature-section">
            <nav class="nlp-carousel-container" aria-label="Feature Cards Carousel">
                <ul class="nlp-feature-list nlp-carousel-list">
                    <?php foreach ($settings['features'] as $index => $item) : ?>
                        <li class="nlp-feature-card">
                            <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => 'nlp-feature-icon', 'style' => 'font-size: 64px; color: #d21b09; ']); ?>
                            <h3 class="nlp-feature-title">
                                <?php if (!empty($item['link']['url'])) : ?>
                                    <a href="<?php echo esc_url($item['link']['url']); ?>" 
                                       target="<?php echo esc_attr($item['link']['is_external'] ? '_blank' : '_self'); ?>"
                                       <?php echo ($item['link']['nofollow'] ? 'rel="nofollow"' : ''); ?>>
                                        <?php echo esc_html($item['title']); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo esc_html($item['title']); ?>
                                <?php endif; ?>
                            </h3>
                            <p class="nlp-feature-text"><?php echo esc_html($item['description']); ?></p>
                            <div class="nlp-feature-arrow-container">
                                <?php if (!empty($item['link']['url'])) : ?>
                                    <a href="<?php echo esc_url($item['link']['url']); ?>" 
                                       class="nlp-feature-arrow"
                                       target="<?php echo esc_attr($item['link']['is_external'] ? '_blank' : '_self'); ?>"
                                       <?php echo ($item['link']['nofollow'] ? 'rel="nofollow"' : ''); ?>>→</a>
                                <?php else : ?>
                                    <span class="nlp-feature-arrow">→</span>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <footer class="nlp-pagination" aria-label="Carousel Pagination">
                <?php foreach ($settings['features'] as $index => $item) : ?>
                    <button class="nlp-pagination-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                            aria-label="<?php printf(__('Go to slide %d', 'feature-carousel-elementor'), $index + 1); ?>"></button>
                <?php endforeach; ?>
            </footer>
        </main>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var carouselId = 'nlp-carousel-' + view.getID();
        #>
        <main class="nlp-feature-section">
            <nav class="nlp-carousel-container" aria-label="Feature Cards Carousel">
                <ul class="nlp-feature-list nlp-carousel-list">
                    <# _.each(settings.features, function(item, index) { #>
                        <li class="nlp-feature-card">
                            <# if (item.icon) { #>
                                <div class="nlp-feature-icon elementor-icon">
                                    <i class="{{{ item.icon.value }}}"></i>
                                </div>
                            <# } #>
                            <h3 class="nlp-feature-title">
                                <# if (item.link && item.link.url) { #>
                                    <a href="{{ item.link.url }}" 
                                       target="{{ item.link.is_external ? '_blank' : '_self' }}"
                                       {{ item.link.nofollow ? 'rel="nofollow"' : '' }}>
                                        {{{ item.title }}}
                                    </a>
                                <# } else { #>
                                    {{{ item.title }}}
                                <# } #>
                            </h3>
                            <p class="nlp-feature-text">{{{ item.description }}}</p>
                            <div class="nlp-feature-arrow-container">
                                <# if (item.link && item.link.url) { #>
                                    <a href="{{ item.link.url }}" 
                                       class="nlp-feature-arrow"
                                       target="{{ item.link.is_external ? '_blank' : '_self' }}"
                                       {{ item.link.nofollow ? 'rel="nofollow"' : '' }}>→</a>
                                <# } else { #>
                                    <span class="nlp-feature-arrow">→</span>
                                <# } #>
                            </div>
                        </li>
                    <# }); #>
                </ul>
            </nav>

            <footer class="nlp-pagination" aria-label="Carousel Pagination">
                <# _.each(settings.features, function(item, index) { #>
                    <button class="nlp-pagination-dot <# if (index === 0) { #>active<# } #>" 
                            aria-label="<?php echo esc_attr__('Go to slide', 'feature-carousel-elementor'); ?> {{{ index + 1 }}}"></button>
                <# }); #>
            </footer>
        </main>
        <?php
    }
}