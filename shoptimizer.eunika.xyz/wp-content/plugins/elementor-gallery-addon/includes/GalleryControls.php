<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

trait GalleryControls {

    public function register_gallery_controls() {

        // Layout & Display Section
        $this->start_controls_section('layout_section', [
            'label' => __('Layout & Display', 'ega'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('gallery_layout', [
            'label'   => __('Layout', 'ega'),
            'type'    => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                ''                => __('Slider — Single Row', 'ega'),
                'swiper-grid'     => __('Slider — Multi-Row Grid', 'ega'),
                'grid-layout'     => __('Static Grid — No Slider', 'ega'),
            ],
        ]);

        $this->add_control('slide_border_radius', [
            'label'   => __('Corners', 'ega'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => [
                'none'   => __('Square', 'ega'),
                'medium' => __('Rounded', 'ega'),
                'large'  => __('Pill-Shaped', 'ega'),
            ],
        ]);

        $this->add_control('slide_spacing', [
            'label'   => __('Spacing Between Slides', 'ega'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => [
                'none' => __('No Gaps', 'ega'),
                'thin' => __('Small Gaps', 'ega'),
                'large' => __('Wide Gaps', 'ega'),
            ],
        ]);

        $this->end_controls_section(); // End Layout & Display Section

        // Caption Styling Section
        $this->start_controls_section('caption_styling_section', [
            'label' => __('Caption Styling', 'ega'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_caption', [
            'label'        => __('Show Captions', 'ega'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Show', 'ega'),
            'label_off'    => __('Hide', 'ega'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('caption_style', [
            'label'     => __('Caption Position', 'ega'),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'below',
            'options'   => [
                'below'   => __('Below Image', 'ega'),
                'overlay' => __('Over Image', 'ega'),
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_position', [
            'label'     => __('Overlay Text Alignment', 'ega'),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'bottom',
            'options'   => [
                'bottom' => __('Bottom', 'ega'),
                'top'    => __('Top', 'ega'),
                'center' => __('Centre', 'ega'),
            ],
            'condition' => [
                'show_caption'  => 'yes',
                'caption_style' => 'overlay',
            ],
        ]);

        $this->add_control('overlay_color', [
            'label'     => __('Overlay Background Color', 'ega'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.5)',
            'selectors' => [
                '{{WRAPPER}} .caption-overlay' => 'background: {{VALUE}};',
            ],
            'condition' => [
                'show_caption'  => 'yes',
                'caption_style' => 'overlay',
            ],
        ]);

        $this->add_responsive_control('overlay_hover_only', [
            'label'     => __('Hover to Show Caption', 'ega'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Hover Only', 'ega'),
            'label_off' => __('Always Visible', 'ega'),
            'return_value' => 'yes',
            'default'      => '',
            'condition'    => [
                'show_caption'  => 'yes',
                'caption_style' => 'overlay',
            ],
        ]);

        $this->add_control('caption_title_size', [
            'label'   => __('Title Font Size (px)', 'ega'),
            'type'    => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'   => ['px' => ['min' => 10, 'max' => 60]],
            'default' => ['size' => 18, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .caption .title'         => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .caption-overlay .title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_title_weight', [
            'label'   => __('Title Font Weight', 'ega'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'bold',
            'options' => [
                'normal' => __('Normal', 'ega'),
                'bold'   => __('Bold', 'ega'),
                'lighter' => __('Lighter', 'ega'),
                'bolder' => __('Bolder', 'ega'),
                '100' => '100',
                '200' => '200',
                '300' => '300',
                '400' => '400',
                '500' => '500',
                '600' => '600',
                '700' => '700',
                '800' => '800',
                '900' => '900',
            ],
            'selectors' => [
                '{{WRAPPER}} .caption .title'         => 'font-weight: {{VALUE}};',
                '{{WRAPPER}} .caption-overlay .title' => 'font-weight: {{VALUE}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_title_color', [
            'label'   => __('Title Color', 'ega'),
            'type'    => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .caption .title'         => 'color: {{VALUE}};',
                '{{WRAPPER}} .caption-overlay .title' => 'color: {{VALUE}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_desc_size', [
            'label'   => __('Description Font Size (px)', 'ega'),
            'type'    => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'   => ['px' => ['min' => 10, 'max' => 40]],
            'default' => ['size' => 14, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .caption .description'         => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .caption-overlay .description' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_desc_weight', [
            'label'   => __('Description Font Weight', 'ega'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'normal',
            'options' => [
                'normal' => __('Normal', 'ega'),
                'bold'   => __('Bold', 'ega'),
                'lighter' => __('Lighter', 'ega'),
                'bolder' => __('Bolder', 'ega'),
                '100' => '100',
                '200' => '200',
                '300' => '300',
                '400' => '400',
                '500' => '500',
                '600' => '600',
                '700' => '700',
                '800' => '800',
                '900' => '900',
            ],
            'selectors' => [
                '{{WRAPPER}} .caption .description'         => 'font-weight: {{VALUE}};',
                '{{WRAPPER}} .caption-overlay .description' => 'font-weight: {{VALUE}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_desc_color', [
            'label'   => __('Description Color', 'ega'),
            'type'    => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .caption .description'         => 'color: {{VALUE}};',
                '{{WRAPPER}} .caption-overlay .description' => 'color: {{VALUE}};',
            ],
            'condition' => ['show_caption' => 'yes'],
        ]);

        $this->add_control('caption_bg_color', [
            'label'     => __('Caption Background Color', 'ega'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .caption' => 'background: {{VALUE}};',
            ],
            'condition' => [
                'show_caption'  => 'yes',
                'caption_style' => 'below',
            ],
        ]);

        // Padding for Overlay Captions - Over Image Layout Only
        $this->add_control('overlay_padding', [
            'label'     => __('Overlay Padding (px)', 'ega'),
            'type'      => Controls_Manager::SLIDER,
            'size_units'=> ['px'],
            'range'     => ['px' => ['min' => 0, 'max' => 200]],
            'default'   => ['size' => 80, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .caption-overlay' => 'padding: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_caption'  => 'yes',
                'caption_style' => 'overlay',
            ],
        ]);

        // Padding for Below Image Captions - Below Layout Only
        $this->add_control('caption_padding', [
            'label'     => __('Caption Padding (px)', 'ega'),
            'type'      => Controls_Manager::SLIDER,
            'size_units'=> ['px'],
            'range'     => ['px' => ['min' => 0, 'max' => 100]],
            'default'   => ['size' => 12, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .caption' => 'padding: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_caption'  => 'yes',
                'caption_style' => 'below',
            ],
        ]);

        $this->end_controls_section();

        // Gallery Items
        $this->start_controls_section('items_section', [
            'label' => __('Images & Details', 'ega'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);

        $repeater = new Repeater();

        $repeater->add_control('image', [
            'label'   => __('Image', 'ega'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => ''],
        ]);

        $repeater->add_control('title', [
            'label'   => __('Title', 'ega'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Material Title', 'ega'),
        ]);

        $repeater->add_control('title_tag', [
            'label'   => __('Title HTML Tag', 'ega'),
            'type'    => Controls_Manager::SELECT,
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
            'label'   => __('Description', 'ega'),
            'type'    => Controls_Manager::WYSIWYG,
            'default' => __('Material description goes here.', 'ega'),
        ]);

        $repeater->add_control('url', [
            'label'       => __('Slide Link URL', 'ega'),
            'type'        => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'description' => __('Optional. If provided, the entire slide becomes clickable.', 'ega'),
            'show_external' => true,
        ]);

        $this->add_control('items', [
            'label'   => __('Gallery Items', 'ega'),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [],
        ]);

        // Widget-level image size (applies to all repeater images)
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumb',        // creates thumb_size & thumb_custom_dimension
                'default' => 'full',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section(); // End Gallery Items

        // Responsive Settings
        $this->start_controls_section('responsive_section', [
            'label' => __('Responsive Settings', 'ega'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_responsive_control('slide_height', [
            'label'   => __('Slide Height (px)', 'ega'),
            'type'    => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'   => ['px' => ['min' => 100, 'max' => 1200]],
            'default' => ['unit' => 'px', 'size' => 500],
            'selectors' => [
                '{{WRAPPER}} .gallery-container .swiper-slide' => 'height: {{SIZE}}{{UNIT}} !important;',
                '{{WRAPPER}} .gallery-container .swiper-slide .image-container' => 'height: 100% !important;',
                '{{WRAPPER}} .gallery-container .swiper-slide img' => 'height: 100% !important; object-fit: cover;',
                '{{WRAPPER}} .gallery-container .grid-item' => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .gallery-container .grid-item .image-container' => 'height: 100%;',
                '{{WRAPPER}} .gallery-container .grid-item img' => 'height: 100%; object-fit: cover;',
            ],
        ]);

        $this->add_control('slides_desktop', [
            'label' => __('Slides on Desktop', 'ega'),
            'type'  => Controls_Manager::NUMBER,
            'min'   => 1,
            'max'   => 10,
            'default' => 4,
        ]);

        $this->add_control('slides_tablet', [
            'label' => __('Slides on Tablet', 'ega'),
            'type'  => Controls_Manager::NUMBER,
            'min'   => 1,
            'max'   => 10,
            'default' => 2,
        ]);

        $this->add_control('slides_mobile', [
            'label' => __('Slides on Mobile', 'ega'),
            'type'  => Controls_Manager::NUMBER,
            'min'   => 1,
            'max'   => 10,
            'default' => 1,
        ]);

        $this->end_controls_section(); // End Responsive Settings

        // Navigation & Autoplay
        $this->start_controls_section('nav_autoplay_section', [
            'label' => __('Navigation & Autoplay', 'ega'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('show_arrows', [
            'label'        => __('Show Navigation Arrows', 'ega'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Show', 'ega'),
            'label_off'    => __('Hide', 'ega'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('autoplay', [
            'label'        => __('Autoplay', 'ega'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'ega'),
            'label_off'    => __('No', 'ega'),
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control('autoplay_interval', [
            'label'     => __('Autoplay Interval (seconds)', 'ega'),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 1,
            'default'   => 5,
            'condition' => ['autoplay' => 'yes'],
        ]);

        $this->end_controls_section(); // End Navigation & Autoplay

        // Custom CSS
        $this->start_controls_section('custom_css_section', [
            'label' => __('Custom CSS', 'ega'),
            'tab'   => Controls_Manager::TAB_ADVANCED
        ]);

        $this->add_control('custom_css', [
            'label'       => __('Custom CSS', 'ega'),
            'type'        => Controls_Manager::CODE,
            'language'    => 'css',
            'rows'        => 10,
            'default'     => '',
            'description' => __('Add custom CSS specific to this widget.', 'ega'),
        ]);

        $this->end_controls_section();
    }
}
