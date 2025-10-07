<?php

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class FAQ_With_Form_Widget extends Widget_Base {

    public function get_name() {
        return 'faq_with_form_widget';
    }

    public function get_title() {
        return __('FAQ with Form', 'textdomain');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Section Settings
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Section Settings', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://nlpstaging.eunika.xyz/wp-content/uploads/2025/05/men-painting-interior-of-home.jpg',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __('Overlay Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(38, 38, 38, 0.83)',
                'selectors' => [
                    '{{WRAPPER}} .main-container::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'main_heading',
            [
                'label' => __('Main Heading', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Melbourne\'s Trusted Painters', 'textdomain'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label' => __('Introduction Text', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Our professional house painting services in Melbourne offer exceptional quality and transparent pricing. Hire our expert painters - get a free instant quote today!', 'textdomain'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'faq_link_text',
            [
                'label' => __('FAQ Link Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('See all FAQ\'s', 'textdomain'),
            ]
        );

        $this->add_control(
            'faq_link_url',
            [
                'label' => __('FAQ Link URL', 'textdomain'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'textdomain'),
                'default' => [
                    'url' => '/faqs/',
                ],
            ]
        );

        $this->end_controls_section();

        // FAQ Items
        $this->start_controls_section(
            'faq_items_section',
            [
                'label' => __('FAQ Items', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'faq_title',
            [
                'label' => __('Title', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Free colour consultation', 'textdomain'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'faq_content',
            [
                'label' => __('Content', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Finding the perfect colour combination for your home can be difficult. Costing up to $400, we provide this service free of charge for all customers.', 'textdomain'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label' => __('FAQ Items', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'faq_title' => __('Free colour consultation', 'textdomain'),
                        'faq_content' => __('Finding the perfect colour combination for your home can be difficult. Costing up to $400, we provide this service free of charge for all customers.', 'textdomain'),
                    ],
                    [
                        'faq_title' => __('7 year guarantee', 'textdomain'),
                        'faq_content' => __('Quality and service are our bread and butter. If paint failure appears, we\'ll fix it up at no cost.', 'textdomain'),
                    ],
                    [
                        'faq_title' => __('Transparent and accurate prices', 'textdomain'),
                        'faq_content' => __('After confirming all your details are accurate, our online quote will reflect the final price with no hidden surprises', 'textdomain'),
                    ],
                    [
                        'faq_title' => __('Clean and tidy up after painting', 'textdomain'),
                        'faq_content' => __('After the painting is completed we will tidy and clean up dust and paint, removing paint cans and rubbish.', 'textdomain'),
                    ],
                    [
                        'faq_title' => __('House Painting Services in South Melbourne', 'textdomain'),
                        'faq_content' => __('Transparent prices and first-class service for your next house paint. Getting your home painted has never been this easy What you can expect when you work with us: Free colour consultation 7 year guarantee Transparent and accurate prices Clean and tidy up after painting Over 100 years combined experience Our painters have over 100 years combined experience in all areas of residential and commercial painting.', 'textdomain'),
                    ],
                    [
                        'faq_title' => __('House key concierge service', 'textdomain'),
                        'faq_content' => __('After confirming the job, we can pick up the keys from your workplace to make life just a little easier for you.', 'textdomain'),
                    ],
                ],
                'title_field' => '{{{ faq_title }}}',
            ]
        );

        $this->end_controls_section();

        // Form Section
        $this->start_controls_section(
            'form_section',
            [
                'label' => __('Form Settings', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_heading_part1',
            [
                'label' => __('Form Heading Part 1', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Get an', 'textdomain'),
            ]
        );

        $this->add_control(
            'form_highlight_text',
            [
                'label' => __('Highlighted Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Instant Quote', 'textdomain'),
            ]
        );

        $this->add_control(
            'form_heading_part2',
            [
                'label' => __('Form Heading Part 2', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('for your next House Paint', 'textdomain'),
            ]
        );

        $this->add_control(
            'form_shortcode',
            [
                'label' => __('Form Shortcode', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => '[gravityform id="6" title="false" description="false" ajax="true"]',
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'textdomain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_image = $settings['background_image']['url'];
        ?>
        
        <style>
            .faq-form-section {
                background-image: url("<?php echo esc_url($bg_image); ?>");
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                padding: 100px 0;
                width: 100%;
            }
            .faq-form-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #262626D4;
            }

            .faq-form-container {
                position: relative;
                max-width: 1140px;
                margin: 0 auto;
                padding: 0 15px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 50px;
            }

            .faq-form-heading {
                color: white;
                text-align: center;
                font-size: 50px;
                margin-bottom: 50px;
                font-weight: 400;
                grid-column: 1 / -1;
                position: relative;
                z-index: 1;
            }

            .main-container {
                background-image: url("<?php echo esc_url($bg_image); ?>");
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                padding: 100px 0;
            }
            {{WRAPPER}} .main-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                background-color: #262626D4;
            }
    
            .container-inner {
                position: relative;
                z-index: 1;
                max-width: 1140px;
                margin: auto;
                padding: 0 15px;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 50px;
                align-items: start; /* Changed from default to align items at the top */
            }
            .main-heading {
                color: white;
                text-align: center;
                font-size: 50px;
                margin-bottom: 50px;
                font-weight: 400;
            }
            .intro-paragraph {
                color: white;
                font-size: 25px;
                font-weight: 300;
                text-align: center;
                margin-bottom: 2rem;
            }
            #main-accordion .accordion-item {
                background: transparent;
                border: 1px solid rgba(255,255,255);
                margin-bottom: 10px;
            }
            #main-accordion .accordion-button {
                background-color: transparent;
                color: white;
                font-size: 1rem;
                font-weight: 400;
                padding: 1rem 1.25rem;
                border: none;
                display: flex;
                justify-content: space-between;
                position: relative;
            }
            #main-accordion .accordion-button:focus {
                box-shadow: none;
            }
            #main-accordion .accordion-button::after {
                display: none;
            }
            #main-accordion .accordion-body {
                color: white;
                padding: 1.25rem;
                font-size: 0.95rem;
            }
            .accordion-icons {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
            }
            .accordion-icon-active {
                display: none;
            }
            .accordion-button:not(.collapsed) .accordion-icon-normal {
                display: none;
            }
            .accordion-button:not(.collapsed) .accordion-icon-active {
                display: block;
            }
            .faq-link {
                text-align: center;
                margin-top: 30px;
            }
            .faq-link a {
                color: white;
                font-size: 18px;
                text-decoration: underline;
            }
            .faq-link a:hover {
                color: #D51C0B;
            }
            .cta-container {
                background-color: white;
                padding: 2rem;
                text-align: center;
                position: sticky;
                top: 20px; /* Adjust this value as needed */
                align-self: start; /* Align to top of grid cell */
                height: auto; /* Let content determine height */
            }
            .animated-headline {
                font-size: 30px;
                color: #262626;
                font-weight: 500;
            }
            .headline-highlight {
                position: relative;
                display: inline-block;
                padding-bottom: 15px;
            }
            .highlight-underline {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 2.5em;
            }
            .highlight-underline path {
                stroke: #D51C0B;
                stroke-width: 8;
                fill: none;
                stroke-dasharray: 1000;
                stroke-dashoffset: 1000;
                animation: drawUnderline 1s ease forwards;
            }
            .gfield_description {
                display: flex !important;
            }
            @keyframes drawUnderline {
                to {
                    stroke-dashoffset: 0;
                }
            }
            .icon {
                font-family: elementskit !important;
                speak: none;
                font-style: normal;
                font-weight: 400;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .icon-up-arrow::before { content: "\e9c3"; }
            .icon-down-arrow1::before { content: "\e994"; }

            @media (max-width: 768px) {
                .container-inner {
                    grid-template-columns: 1fr;
                    padding: 0px 50px 0px 50px;
                }
                
                /* Reverse the order of columns */
                .container-inner > div:first-child {
                    order: 2;
                }

                .cta-container {
                    order: 1;
                    margin-bottom: 30px;
                    position: static; /* Reset sticky positioning on mobile */
                    margin-top: 0;
                }
                
                .container-inner > div:last-child {
                    order: 1;
                    margin-bottom: 30px; /* Add spacing between reversed columns */
                }
                .intro-paragraph { font-size: 20px; }
                .animated-headline { font-size: 24px; }
                .accordion-button { font-size: 1rem; padding-right: 3rem; }
                .container-inner {
                    grid-template-columns: 1fr;
                }
            }
            @media (max-width:450px){
                .container-inner {
                    padding: 0px 20px 0px 20px;
                }
                .accordion {
                    display:none;
                }
            }
        </style>

        <main class="faq-form-section">
            <h1 class="faq-form-heading"><?php echo esc_html($settings['main_heading']); ?></h1>
            
            <div class="faq-form-container">
                <!-- FAQ Column -->
                <div>
                    <p class="intro-paragraph">
                        <?php echo esc_html($settings['intro_text']); ?>
                    </p>

                    <div class="accordion" id="main-accordion">
                        <?php foreach ($settings['faq_items'] as $index => $item): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $index; ?>">
                                        <span><?php echo esc_html($item['faq_title']); ?></span>
                                        <span class="accordion-icons">
                                            <i class="icon icon-down-arrow1 accordion-icon-normal"></i>
                                            <i class="icon icon-up-arrow accordion-icon-active"></i>
                                        </span>
                                    </button>
                                </h2>
                                <div id="faq-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#main-accordion">
                                    <div class="accordion-body">
                                        <p><?php echo wp_kses_post($item['faq_content']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <p class="faq-link">
                        <a href="<?php echo esc_url($settings['faq_link_url']['url']); ?>">
                            <?php echo esc_html($settings['faq_link_text']); ?>
                        </a>
                    </p>
                </div>

                <!-- Form Column -->
                <div class="cta-container">
                    <h2 class="animated-headline">
                        <span><?php echo esc_html($settings['form_heading_part1']); ?></span>
                        <span class="headline-highlight">
                            <?php echo esc_html($settings['form_highlight_text']); ?>
                            <svg class="highlight-underline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>
                        </span>
                        <span><?php echo esc_html($settings['form_heading_part2']); ?></span>
                    </h2>
                    <?php echo do_shortcode($settings['form_shortcode']); ?>
                </div>
            </div>
        </main>
        <?php
    }
}
