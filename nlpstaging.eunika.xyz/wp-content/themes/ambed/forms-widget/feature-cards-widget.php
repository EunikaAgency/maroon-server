    <?php
    /**
     * Feature Carousel Elementor Widget
     */
    class Feature_Cards_Widget_ extends \Elementor\Widget_Base {

        public function get_name() {
            return 'feature_carousel';
        }

        public function get_title() {
            return __('Feature Carousel', 'text-domain');
        }

        public function get_icon() {
            return 'eicon-carousel';
        }

        public function get_categories() {
            return ['general'];
        }

        protected function _register_controls() {
            // Content Tab
            $this->start_controls_section(
                'content_section',
                [
                    'label' => __('Content', 'text-domain'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $repeater = new \Elementor\Repeater();

            // Icon control
            $repeater->add_control(
                'icon',
                [
                    'label' => __('Icon', 'text-domain'),
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
                    'label' => __('Title', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Feature Title', 'text-domain'),
                    'label_block' => true,
                ]
            );

            // Description control
            $repeater->add_control(
                'description',
                [
                    'label' => __('Description', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => __('Feature description goes here', 'text-domain'),
                    'label_block' => true,
                ]
            );

            // Link control
            $repeater->add_control(
                'link',
                [
                    'label' => __('Link', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'text-domain'),
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
                    'label' => __('Features', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => __('Experienced & Professional', 'text-domain'),
                            'description' => __('Trade qualified painters that are invested in your satisfaction.', 'text-domain'),
                        ],
                        [
                            'title' => __('End to end service', 'text-domain'),
                            'description' => __('We leave only after the paint is complete, your home is cleaned and furniture in place.', 'text-domain'),
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
                    'label' => __('Icon', 'text-domain'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'icon_margin_bottom',
                [
                    'label' => __('Margin Bottom', 'text-domain'),
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
                    'label' => __('Card', 'text-domain'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'card_height',
                [
                    'label' => __('Height', 'text-domain'),
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
                    'label' => __('Padding', 'text-domain'),
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
                                aria-label="<?php printf(__('Go to slide %d', 'text-domain'), $index + 1); ?>"></button>
                    <?php endforeach; ?>
                </footer>
            </main>

            <style>
                .nlp-feature-section {
                    max-width: 1170px;
                    margin: 0 auto;
                    /* background: #f2f5f7; */
                    padding: 20px 0;
                }

                .nlp-feature-list {
                    display: flex;
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    align-items: stretch;
                }

                .nlp-feature-card {
                    padding: 40px 30px;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    background: #f2f5f7;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                }

                .nlp-feature-card::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    height: 0;
                    background: #d21b09;
                    transition: height 0.3s ease-in;
                    z-index: 1;
                }

                .nlp-feature-card:hover::before {
                    height: 100%;
                }

                .nlp-feature-card > * {
                    position: relative;
                    z-index: 2;
                    text-align: start;
                }

                .nlp-feature-card:hover .nlp-feature-title,
                .nlp-feature-card:hover .nlp-feature-text {
                    color: white;
                    transition: color 0.3s ease 0.2s;
                }

                .nlp-feature-icon {
                    margin-bottom: 20px;
                    transition: filter 0.3s ease 0.2s;
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                }
                
                .nlp-feature-card:hover .nlp-feature-icon {
                    filter: brightness(0) invert(1);
                }

                .nlp-feature-title {
                    font-size: 20px;
                    font-weight: 600;
                    margin-bottom: 12px;
                    color: #3c3531;
                    transition: color 0.3s ease;
                }

                .nlp-feature-title a {
                    text-decoration: none;
                    color: inherit;
                }

                .nlp-feature-text {
                    font-size: 16px;
                    color: #666;
                    font-weight: 400;
                    margin-bottom: 20px;
                    line-height: 1.6;
                    flex-grow: 1;
                    transition: color 0.3s ease;
                }

                .nlp-feature-arrow-container {
                    margin-top: auto;
                }

                .nlp-feature-arrow {
                    font-size: 20px;
                    font-weight: bold;
                    color: #d32f2f;
                    text-decoration: none;
                    background-color: white;
                    transition: all 0.3s ease 0.2s;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .nlp-feature-card:hover .nlp-feature-arrow {
                    background-color: #3c3531;
                    color: white;
                }

                .nlp-carousel-container {
                    overflow-x: auto;
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                    cursor: grab;
                    scroll-behavior: smooth;
                    padding-bottom: 15px;
                }

                .nlp-carousel-container::-webkit-scrollbar {
                    display: none;
                }

                .nlp-carousel-list {
                    display: flex;
                    flex-wrap: nowrap;
                    user-select: none;
                    cursor: grab;
                    min-width: 100%;
                }

                .nlp-grabbing {
                    cursor: grabbing;
                }

                .nlp-pagination {
                    display: flex;
                    justify-content: center;
                    margin-top: 15px;
                    gap: 10px;
                    padding: 0 15px;
                }

                .nlp-pagination-dot {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    background-color: #ccc;
                    border: none;
                    cursor: pointer;
                    transition: background 0.3s ease;
                    padding: 0;
                }

                .nlp-pagination-dot.active {
                    background-color: black;
                }

                /* Desktop styles */
                .nlp-feature-card:nth-child(2) {
                    border-left: 1px solid #3c353123;
                    border-right: 1px solid #3c353123;
                    box-sizing: border-box;
                }

                .nlp-feature-card:nth-child(3) {
                    border-right: 1px solid #3c353123;
                }

                /* Mobile styles */
                @media (max-width: 768px) {
                    .nlp-feature-section {
                        background: #f2f5f7;
                    }

                    .nlp-feature-list {
                        overflow-x: auto;
                        scroll-snap-type: x mandatory;
                        -webkit-overflow-scrolling: touch;
                        scrollbar-width: none;
                        gap: 15px;
                        padding: 0 15px 20px;
                    }

                    .nlp-feature-list::-webkit-scrollbar {
                        display: none;
                    }

                    .nlp-feature-card {
                        background: white;
                        scroll-snap-align: center;
                        flex: 0 0 calc(85% - 15px);
                        min-width: calc(100%);
                        margin-right: 0;
                        border: none !important;
                    }

                    .nlp-feature-section {
                        padding: 20px 0;
                    }

                    .nlp-carousel-container {
                        padding: 0;
                    }
                }

                @media screen and (min-width: 769px) {
                    .nlp-pagination {
                        display: none;
                    }
                }
            </style>

            <script>
                jQuery(document).ready(function($) {
                    const carousel = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-feature-list');
                    const container = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-carousel-container');
                    const dots = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-pagination-dot');
                    let isDragging = false;
                    let startX, scrollLeft;
                    let startPos, draggedDistance;

                    // Initialize Hammer.js for better touch support
                    if (typeof Hammer !== 'undefined') {
                        const hammer = new Hammer(container[0]);
                        hammer.get('pan').set({ direction: Hammer.DIRECTION_HORIZONTAL });
                        
                        hammer.on('panstart', function(e) {
                            isDragging = true;
                            carousel.addClass('nlp-grabbing');
                            startPos = e.center.x;
                            draggedDistance = 0;
                        });
                        
                        hammer.on('panmove', function(e) {
                            if (!isDragging) return;
                            draggedDistance = startPos - e.center.x;
                            carousel.scrollLeft(carousel.scrollLeft() + draggedDistance);
                            startPos = e.center.x;
                        });
                        
                        hammer.on('panend', function() {
                            isDragging = false;
                            carousel.removeClass('nlp-grabbing');
                            snapToNearestCard();
                        });
                    }

                    const endDrag = () => {
                        isDragging = false;
                        carousel.removeClass('nlp-grabbing');
                        snapToNearestCard();
                    };

                    carousel.on('mousedown', (e) => {
                        isDragging = true;
                        carousel.addClass('nlp-grabbing');
                        startX = e.pageX - carousel.offset().left;
                        scrollLeft = carousel.scrollLeft();
                    });

                    $(document).on('mousemove', (e) => {
                        if (!isDragging) return;
                        e.preventDefault();
                        const x = e.pageX - carousel.offset().left;
                        const walk = (x - startX) * 2;
                        carousel.scrollLeft(scrollLeft - walk);
                    });

                    $(document).on('mouseup', endDrag);
                    $(document).on('mouseleave', endDrag);

                    // Snap to nearest card function
                    function snapToNearestCard() {
                        if ($(window).width() > 768) return;
                        
                        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
                        const scrollPos = carousel.scrollLeft();
                        const activeIndex = Math.round(scrollPos / cardWidth);
                        
                        carousel.animate({ scrollLeft: activeIndex * cardWidth }, 200);
                        updatePagination(activeIndex);
                    }

                    // Update pagination dots
                    function updatePagination(activeIndex) {
                        dots.removeClass('active').eq(activeIndex).addClass('active');
                    }

                    // Handle scroll events
                    carousel.on('scroll', () => {
                        if (isDragging) return;
                        
                        const scrollPosition = carousel.scrollLeft();
                        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
                        const activeIndex = Math.round(scrollPosition / cardWidth);
                        
                        updatePagination(activeIndex);
                    });

                    // Handle pagination dot clicks
                    dots.on('click', function() {
                        const index = $(this).index();
                        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
                        carousel.animate({ scrollLeft: index * cardWidth }, 300);
                    });

                    // Handle window resize
                    $(window).on('resize', function() {
                        if ($(window).width() <= 768) {
                            const activeDot = $('.nlp-pagination-dot.active');
                            if (activeDot.length) {
                                const index = activeDot.index();
                                const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
                                carousel.scrollLeft(index * cardWidth);
                            }
                        }
                    });
                });
            </script>
            <?php
        }

        protected function _content_template() {
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
                                aria-label="<?php echo esc_attr__('Go to slide', 'text-domain'); ?> {{{ index + 1 }}}"></button>
                    <# }); #>
                </footer>
            </main>

                    <style>
                .nlp-feature-section {
                    max-width: 1140px;
                    margin: 0 auto;
                    background: #f2f5f7;
                    padding: 20px 0;
                }

                .nlp-feature-list {
                    display: flex;
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    align-items: stretch;
                }

                .nlp-feature-card {
                    padding: 40px 30px;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    background: white;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                }

                .nlp-feature-card::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    height: 0;
                    background: #d21b09;
                    transition: height 0.3s ease-in;
                    z-index: 1;
                }

                .nlp-feature-card:hover::before {
                    height: 100%;
                }

                .nlp-feature-card > * {
                    position: relative;
                    z-index: 2;
                    text-align: start;
                }

                .nlp-feature-card:hover .nlp-feature-title,
                .nlp-feature-card:hover .nlp-feature-text {
                    color: white;
                    transition: color 0.3s ease 0.2s;
                }

                .nlp-feature-icon {
                    margin-bottom: 20px;
                    transition: filter 0.3s ease 0.2s;
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                }
                
                .nlp-feature-card:hover .nlp-feature-icon {
                    filter: brightness(0) invert(1);
                }

                .nlp-feature-title {
                    font-size: 20px;
                    font-weight: 600;
                    margin-bottom: 12px;
                    color: #3c3531;
                    transition: color 0.3s ease;
                }

                .nlp-feature-title a {
                    text-decoration: none;
                    color: inherit;
                }

                .nlp-feature-text {
                    font-size: 16px;
                    color: #666;
                    font-weight: 400;
                    margin-bottom: 20px;
                    line-height: 1.6;
                    flex-grow: 1;
                    transition: color 0.3s ease;
                }

                .nlp-feature-arrow-container {
                    margin-top: auto;
                }

                .nlp-feature-arrow {
                    font-size: 20px;
                    font-weight: bold;
                    color: #d32f2f;
                    text-decoration: none;
                    background-color: white;
                    transition: all 0.3s ease 0.2s;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                }

                .nlp-feature-card:hover .nlp-feature-arrow {
                    background-color: #3c3531;
                    color: white;
                }

                .nlp-carousel-container {
                    overflow-x: auto;
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                    cursor: grab;
                    scroll-behavior: smooth;
                    padding-bottom: 15px;
                }

                .nlp-carousel-container::-webkit-scrollbar {
                    display: none;
                }

                .nlp-carousel-list {
                    display: flex;
                    flex-wrap: nowrap;
                    user-select: none;
                    cursor: grab;
                    min-width: 100%;
                }

                .nlp-grabbing {
                    cursor: grabbing;
                }

                .nlp-pagination {
                    display: flex;
                    justify-content: center;
                    margin-top: 15px;
                    gap: 10px;
                    padding: 0 15px;
                }

                .nlp-pagination-dot {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    background-color: #ccc;
                    border: none;
                    cursor: pointer;
                    transition: background 0.3s ease;
                    padding: 0;
                }

                .nlp-pagination-dot.active {
                    background-color: black;
                }

                /* Desktop styles */
                .nlp-feature-card:nth-child(2) {
                    border-left: 1px solid #3c353123;
                    border-right: 1px solid #3c353123;
                    box-sizing: border-box;
                }

                .nlp-feature-card:nth-child(3) {
                    border-right: 1px solid #3c353123;
                }

                /* Mobile styles */
                @media (max-width: 768px) {
                    .nlp-feature-list {
                        overflow-x: auto;
                        scroll-snap-type: x mandatory;
                        -webkit-overflow-scrolling: touch;
                        scrollbar-width: none;
                        gap: 15px;
                        padding: 0 15px 20px;
                    }

                    .nlp-feature-list::-webkit-scrollbar {
                        display: none;
                    }

                    .nlp-feature-card {
                        scroll-snap-align: center;
                        flex: 0 0 calc(85% - 15px);
                        min-width: calc(85% - 15px);
                        margin-right: 0;
                        border: none !important;
                    }

                    .nlp-feature-section {
                        padding: 20px 0;
                    }

                    .nlp-carousel-container {
                        padding: 0;
                    }
                }

                @media screen and (min-width: 769px) {
                    .nlp-pagination {
                        display: none;
                    }
                }
            </style>
            <?php
        }
    }