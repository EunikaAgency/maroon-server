<?php
namespace CEW_Addons;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Repeater;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Custom_Banner extends Widget_Base {

    public function get_name() {
        return 'custom_banner';
    }

    public function get_title() {
        return __('FAQ with Form Widget', 'textdomain');
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
        require CEW_ADDONS_PATH . 'views/custom-banner/custom-banner.php';
    }
}