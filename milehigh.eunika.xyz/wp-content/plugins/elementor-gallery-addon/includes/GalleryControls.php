<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

trait GalleryControls {
    public function register_gallery_controls() {

        // SECTION: Layout & Display
        $this->start_controls_section('layout_section', [
            'label' => __('Layout & Display', 'ega'),
            'tab' => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('gallery_layout', [
            'label' => __('Gallery Layout Mode', 'ega'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => __('Default Swiper Layout', 'ega'),
                'grid-layout' => __('Grid Layout', 'ega'),
            ],
        ]);

        $this->add_control('layout_style', [
            'label' => __('Gallery Layout Style', 'ega'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default'     => 'Use Global Setting',
                'template-1'  => 'Clean Edge – No Gaps',
                'template-2'  => 'Modern Card – Rounded with Spacing',
            ],
        ]);

        $this->add_control('show_caption', [
            'label' => __('Show Captions', 'ega'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'ega'),
            'label_off' => __('Hide', 'ega'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('caption_style', [
            'label' => __('Caption Display Style', 'ega'),
            'type' => Controls_Manager::SELECT,
            'default' => 'below',
            'options' => [
                'below' => __('Below Image', 'ega'),
                'overlay' => __('Overlay Inside Image', 'ega'),
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_position', [
            'label' => __('Overlay Caption Position', 'ega'),
            'type' => Controls_Manager::SELECT,
            'default' => 'bottom',
            'options' => [
                'bottom' => __('Bottom', 'ega'),
                'top'    => __('Top', 'ega'),
                'center' => __('Center', 'ega'),
            ],
            'condition' => [
                'show_caption' => 'yes',
                'caption_style' => 'overlay',
            ],
        ]);

        $this->add_control('overlay_color', [
            'label' => __('Overlay Background Color', 'ega'),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(0,0,0,0.5)',
            'condition' => [
                'show_caption' => 'yes',
                'caption_style' => 'overlay',
            ],
            'selectors' => [
                '{{WRAPPER}} .caption-overlay' => 'background: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // SECTION: Gallery Items
        $this->start_controls_section('items_section', [
            'label' => __('Gallery Items', 'ega'),
            'tab' => Controls_Manager::TAB_CONTENT
        ]);

        $repeater = new Repeater();

        $repeater->add_control('image', [
            'label' => __('Image', 'ega'),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => ''],
        ]);

        $repeater->add_control('title', [
            'label' => __('Title', 'ega'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Material Title', 'ega'),
        ]);

        $repeater->add_control('title_tag', [
            'label' => __('Title HTML Tag', 'ega'),
            'type' => Controls_Manager::SELECT,
            'default' => 'div',
            'options' => [
                'div'  => 'div',
                'p'    => 'p',
                'span' => 'span',
                'h1'   => 'h1',
                'h2'   => 'h2',
                'h3'   => 'h3',
                'h4'   => 'h4',
                'h5'   => 'h5',
                'h6'   => 'h6',
            ],
        ]);

        $repeater->add_control('description', [
            'label' => __('Description', 'ega'),
            'type' => Controls_Manager::WYSIWYG,
            'default' => __('Material description goes here.', 'ega'),
        ]);

        $repeater->add_control('url', [
            'label' => __('Slide Link URL', 'ega'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'description' => __('Optional. If provided, the entire slide becomes clickable.', 'ega'),
            'show_external' => true,
        ]);

        $this->add_control('items', [
            'label' => __('Gallery Items', 'ega'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
        ]);

        $this->end_controls_section();

        // SECTION: Responsive Settings
        $this->start_controls_section('responsive_section', [
            'label' => __('Responsive Settings', 'ega'),
            'tab' => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_responsive_control('image_height', [
            'label' => __('Image Height (px)', 'ega'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 100, 'max' => 1200],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 700,
            ],
            'selectors' => [
                '{{WRAPPER}} .gallery-container .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('slides_desktop', [
            'label' => __('Slides on Desktop', 'ega'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'default' => 4,
        ]);

        $this->add_control('slides_tablet', [
            'label' => __('Slides on Tablet', 'ega'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'default' => 2,
        ]);

        $this->add_control('slides_mobile', [
            'label' => __('Slides on Mobile', 'ega'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'default' => 1,
        ]);

        $this->end_controls_section();

        // SECTION: Navigation & Autoplay
        $this->start_controls_section('nav_autoplay_section', [
            'label' => __('Navigation & Autoplay', 'ega'),
            'tab' => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('show_arrows', [
            'label' => __('Show Navigation Arrows', 'ega'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'ega'),
            'label_off' => __('Hide', 'ega'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('autoplay', [
            'label' => __('Autoplay', 'ega'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'ega'),
            'label_off' => __('No', 'ega'),
            'return_value' => 'yes',
            'default' => '',
        ]);

        $this->add_control('autoplay_interval', [
            'label' => __('Autoplay Interval (seconds)', 'ega'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'default' => 5,
            'condition' => ['autoplay' => 'yes'],
        ]);

        $this->end_controls_section();

        // SECTION: Custom CSS
        $this->start_controls_section('custom_css_section', [
            'label' => __('Custom CSS', 'ega'),
            'tab' => Controls_Manager::TAB_ADVANCED
        ]);

        $this->add_control('custom_css', [
            'label' => __('Custom CSS', 'ega'),
            'type' => Controls_Manager::CODE,
            'language' => 'css',
            'rows' => 10,
            'default' => '',
            'description' => __('Add custom CSS specific to this widget.', 'ega'),
        ]);

        $this->end_controls_section();
    }
}
?>
