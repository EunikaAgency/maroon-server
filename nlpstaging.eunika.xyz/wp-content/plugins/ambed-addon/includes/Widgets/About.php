<?php

namespace Layerdrops\Ambed\Widgets;


class About extends \Elementor\Widget_Base {
	public function get_name() {
		return 'ambed-about';
	}

	public function get_title() {
		return __('About', 'ambed-addon');
	}

	public function get_icon() {
		return 'eicon-cogs';
	}

	public function get_categories() {
		return ['ambed-category'];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'layout_section',
			[
				'label' => __('Layout', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_type',
			[
				'label' => __('Select Layout', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'layout_one',
				'options' => [
					'layout_one' => __('Layout One', 'ambed-addon'),
					'layout_two' => __('Layout Two', 'ambed-addon'),
					'layout_three' => __('Layout Three', 'ambed-addon'),
					'layout_four' => __('Layout Four', 'ambed-addon'),
					'layout_five' => __('Layout Five', 'ambed-addon'),
					'layout_six' => __('Layout Six', 'ambed-addon'),
				]
			]
		);

		$this->end_controls_section();

		//layout_one
		$this->start_controls_section(
			'content_one',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_one'
				]
			]
		);

		$this->add_control(
			'sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'highlighted_text',
			[
				'label' => __('Highlighted Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add highlighted text', 'ambed-addon'),
			]
		);

		$this->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);


		$this->add_control(
			'button_label',
			[
				'label' => __('Button Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Read More About', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_url',
			[
				'label' => __('Button Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);

		$layout_one_features_list = new \Elementor\Repeater();

		$layout_one_features_list->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);


		$layout_one_features_list->add_control(
			'icon',
			[
				'label' => __('Check Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-wallpaper',
					'library' => 'custom-icon',
				],
			]
		);


		$this->add_control(
			'layout_one_features_list',
			[
				'label' => __('Feature Lists', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_one_features_list->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'layout_one_call_text',
			[
				'label' => __('Call Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Call anytime', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_one_call_number',
			[
				'label' => __('Call Number', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('+ 98 (000) - 9630', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_one_call_url',
			[
				'label' => __('Call Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_one_call_icon',
			[
				'label' => __('Call Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-phone-call',
					'library' => 'custom-icon',
				],
			]
		);


		$this->end_controls_section();

		//images
		$this->start_controls_section(
			'section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_one'
				]
			]
		);


		$this->add_control(
			'image',
			[
				'label' => __('Large Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image_two',
			[
				'label' => __('Small Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_one_image_caption',
			[
				'label' => __('Image Caption', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Successful Project', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_one_image_count',
			[
				'label' => __('Count Number', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('3690', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_one_image_icon',
			[
				'label' => __('Image Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-wallpaper-1',
					'library' => 'custom-icon',
				],
			]
		);

		$this->add_control(
			'layout_one_shape_one',
			[
				'label' => __('Shape One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_one_shape_two',
			[
				'label' => __('Shape Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'image_link',
			[
				'label' => __('Link', 'ambed'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __(home_url(), 'ambed-addon'),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
					'custom_attributes' => '',
				],
				'show_external' => true,
				'show_label' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);


		$this->end_controls_section();


		//layout_two_content
		$this->start_controls_section(
			'layout_two_content',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_two'
				]
			]
		);

		$this->add_control(
			'layout_two_sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_two_sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_two_highlighted_text',
			[
				'label' => __('Highlighted Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add highlighted text', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_two_summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);

		$layout_two_features_list = new \Elementor\Repeater();

		$layout_two_features_list->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$layout_two_features_list->add_control(
			'icon',
			[
				'label' => __('Check Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-image-gallery1',
					'library' => 'custom-icon',
				],
			]
		);


		$this->add_control(
			'layout_two_features_list',
			[
				'label' => __('Feature Lists', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_two_features_list->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$layout_two_progressbar_items = new \Elementor\Repeater();

		$layout_two_progressbar_items->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Add title', 'ambed-addon'),
				'default'	  => __('Fund Raised', 'ambed-addon')
			]
		);


		$layout_two_progressbar_items->add_control(
			'count',
			[
				'label' => __('Count', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['count'],
				'range' => [
					'count' => [
						'min' => 0,
						'max' => 85,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'count',
					'size' => 6,
				],
			]
		);



		$this->add_control(
			'layout_two_progressbar_items',
			[
				'label' => __('Progressbar', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_two_progressbar_items->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'layout_two_video_caption',
			[
				'label' => __('Video Caption', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('NEW COLLECTION 2022.', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_two_video_url',
			[
				'label' => __('Video Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
			]
		);

		$this->end_controls_section();

		//layout_two_images
		$this->start_controls_section(
			'layout_two_section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_two'
				]
			]
		);


		$this->add_control(
			'layout_two_large_image',
			[
				'label' => __('Large Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'layout_two_small_image',
			[
				'label' => __('Small Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_two_shapes',
			[
				'label' => esc_html__('Shapes', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);


		$this->end_controls_section();

		//layout_three_content
		$this->start_controls_section(
			'layout_three_content',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_three'
				]
			]
		);

		$this->add_control(
			'layout_three_sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
				'default' => __('Default Title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_three_sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
				'default' => __('Default Sub Title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_three_summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);

		$layout_three_checklist = new \Elementor\Repeater();

		$layout_three_checklist->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Add title', 'ambed-addon'),
				'default'	  => __('Nsectetur cing elit.', 'ambed-addon')
			]
		);

		$this->add_control(
			'layout_three_checklist',
			[
				'label' => __('Check List', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_three_checklist->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'layout_three_author_name',
			[
				'label' => __('Author Name', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Add Author Name', 'ambed-addon'),
				'default' => __('Kevin Martin', 'ambed-addon')
			]
		);

		$this->add_control(
			'layout_three_author_image',
			[
				'label' => __('Author Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->end_controls_section();

		//layout_three_images
		$this->start_controls_section(
			'layout_three_section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_three'
				]
			]
		);


		$this->add_control(
			'layout_three_image_one',
			[
				'label' => __('Image One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'layout_three_image_two',
			[
				'label' => __('Image Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'layout_three_image_caption_count',
			[
				'label' => __('Image Caption Count', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default'	  => __('30', 'ambed-addon')
			]
		);

		$this->add_control(
			'layout_three_image_caption',
			[
				'label' => __('Image Caption', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add image caption', 'ambed-addon'),
				'default'	  => __('Default Caption', 'ambed-addon')
			]
		);

		$this->add_control(
			'layout_three_shape_one',
			[
				'label' => __('Shape One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);


		$this->add_control(
			'layout_three_shape_two',
			[
				'label' => __('Shape Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->end_controls_section();

		//layout_four
		$this->start_controls_section(
			'layout_four_content',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_four'
				]
			]
		);

		$this->add_control(
			'layout_four_sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_four_sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_four_summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);

		$layout_four_faq = new \Elementor\Repeater();

		$layout_four_faq->add_control(
			'question',
			[
				'label' => __('Question', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add Question', 'ambed-addon'),
				'default' => __('Default Question', 'ambed-addon')
			]
		);

		$layout_four_faq->add_control(
			'answer',
			[
				'label' => __('Default Answer', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add Answer', 'ambed-addon'),
				'default' => __('Default Answer', 'ambed-addon')
			]
		);

		$layout_four_faq->add_control(
			'active_status',
			[
				'label' => __('Is active?', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'ambed-addon'),
				'label_off' => __('No', 'ambed-addon'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'layout_four_faq',
			[
				'label' => __('Faq', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_four_faq->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ question }}}',
			]
		);

		$this->end_controls_section();

		//layout_four_images
		$this->start_controls_section(
			'layout_four_section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_four'
				]
			]
		);


		$this->add_control(
			'layout_four_image_one',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_four_image_one_caption',
			[
				'label' => __('Image One Caption', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('If you are going passage.', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_four_image_two',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_four_image_two_caption',
			[
				'label' => __('Image Two Caption', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Lorem ipsum available.', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_four_shape',
			[
				'label' => __('Shape', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->end_controls_section();


		//layout_five
		$this->start_controls_section(
			'content_five',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_five'
				]
			]
		);

		$this->add_control(
			'layout_five_sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_five_sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);


		$this->add_control(
			'layout_five_button_label',
			[
				'label' => __('Button Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Discover More', 'ambed-addon'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'layout_five_button_url',
			[
				'label' => __('Button Url', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('#', 'ambed-addon'),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_label' => false,
			]
		);

		$layout_five_features_list = new \Elementor\Repeater();

		$layout_five_features_list->add_control(
			'title',
			[
				'label' => __('Title ', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$layout_five_features_list->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add Summary', 'ambed-addon'),
			]
		);


		$layout_five_features_list->add_control(
			'icon',
			[
				'label' => __('Check Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-checked',
					'library' => 'custom-icon',
				],
			]
		);

		$this->add_control(
			'layout_five_features_list',
			[
				'label' => __('Feature Lists', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_five_features_list->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		//layout_five_images
		$this->start_controls_section(
			'layout_five_section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_five'
				]
			]
		);

		$this->add_control(
			'layout_five_image',
			[
				'label' => __('Image', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_five_shape',
			[
				'label' => __('Shape', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->end_controls_section();

		//layout_six
		$this->start_controls_section(
			'content_six',
			[
				'label' => __('Content', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_six'
				]
			]
		);

		$this->add_control(
			'layout_six_sec_title',
			[
				'label' => __('Section Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_six_sec_sub_title',
			[
				'label' => __('Section Sub Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add sub title', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_six_highlighted_text',
			[
				'label' => __('Highlighted Text', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add highlighted text', 'ambed-addon'),
			]
		);

		$this->add_control(
			'layout_six_summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);


		$layout_six_features_list = new \Elementor\Repeater();

		$layout_six_features_list->add_control(
			'title',
			[
				'label' => __('Title', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add title', 'ambed-addon'),
			]
		);

		$layout_six_features_list->add_control(
			'summary',
			[
				'label' => __('Summary', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Add summary', 'ambed-addon'),
			]
		);

		$layout_six_features_list->add_control(
			'icon',
			[
				'label' => __('Check Icon', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-confirmation',
					'library' => 'custom-icon',
				],
			]
		);


		$this->add_control(
			'layout_six_features_list',
			[
				'label' => __('Feature Lists', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $layout_six_features_list->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		//layout_six_images
		$this->start_controls_section(
			'layout_six_section_image',
			[
				'label' => __('Images', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'layout_six'
				]
			]
		);


		$this->add_control(
			'layout_six_image_one',
			[
				'label' => __('Image One', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'layout_six_image_two',
			[
				'label' => __('Image Two', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'layout_six_image_shape',
			[
				'label' => __('Shape', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);


		$this->end_controls_section();


		//typos
		$this->start_controls_section(
			'style_options',
			[
				'label' => esc_html__('Style Options', 'ambed-addon'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		ambed_typo_and_color_options($this, 'Title', '{{WRAPPER}} .section-title__title', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five', 'layout_six']);
		ambed_typo_and_color_options($this, 'Sub Title', '{{WRAPPER}} .section-title__tagline', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_five', 'layout_six']);

		ambed_typo_and_color_options($this, 'Highlight Text', '{{WRAPPER}} .about-one__text-1, {{WRAPPER}} .quality-work__text-1, {{WRAPPER}} .about-two__text-1', ['layout_one', 'layout_two', 'layout_six']);
		ambed_typo_and_color_options($this, 'Summary Text', '{{WRAPPER}} .about-one__text-2,
		 {{WRAPPER}} .quality-work__text-2, {{WRAPPER}} .welcome-one__text, {{WRAPPER}} .benefits-one__text, {{WRAPPER}} .about-two__text-2', ['layout_one', 'layout_two', 'layout_three', 'layout_four', 'layout_six']);

		ambed_typo_and_color_options($this, 'Feature Title', '{{WRAPPER}} .about-one__points-text,
		{{WRAPPER}} .quality-work__feature li .text p,{{WRAPPER}} .why-choose-one__points li .text h4,{{WRAPPER}} .about-two__points li .text p', ['layout_one', 'layout_two', 'layout_five', 'layout_six']);
		ambed_typo_and_color_options($this, 'Feature Summary', '{{WRAPPER}} .why-choose-one__points p, {{WRAPPER}} .about-two__points-text', ['layout_five', 'layout_six']);

		ambed_typo_and_color_options($this, 'Progressbar Title', '{{WRAPPER}} .quality-work__progress-title', ['layout_two']);
		ambed_typo_and_color_options($this, 'Progressbar', '{{WRAPPER}} .quality-work__progress .bar-inner,{{WRAPPER}} .quality-work__progress .count-text', ['layout_two'], 'background-color', false);

		ambed_typo_and_color_options($this, 'Check List', '{{WRAPPER}} .welcome-one__points li .text p', ['layout_three']);

		ambed_typo_and_color_options($this, 'Author Name', '{{WRAPPER}} .welcome-one__person-name', ['layout_three']);

		ambed_typo_and_color_options($this, 'Button', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_five']);
		ambed_typo_and_color_options($this, 'Button Background', '{{WRAPPER}} .thm-btn', ['layout_one', 'layout_five'], 'background-color', false);

		ambed_typo_and_color_options($this, 'Image Caption Typography', '{{WRAPPER}} .about-one__project-text,
		 {{WRAPPER}} .welcome-one__experience-text,{{WRAPPER}} .benefits-one__points-list li .text p', ['layout_one', 'layout_three', 'layout_four']);
		ambed_typo_and_color_options($this, 'Image Caption Count', '{{WRAPPER}} .welcome-one__experience-year h3,{{WRAPPER}} .about-one__project-content h3', ['layout_one', 'layout_three']);

		ambed_typo_and_color_options($this, 'Call Text', '{{WRAPPER}} .about-one__call-text p', ['layout_one']);
		ambed_typo_and_color_options($this, 'Call Number', '{{WRAPPER}} .about-one__call-text a', ['layout_one']);


		ambed_typo_and_color_options($this, 'Faq Question', '{{WRAPPER}} .faq-one-accrodion .accrodion-title h4', ['layout_four']);
		ambed_typo_and_color_options($this, 'Faq Answer', '{{WRAPPER}} .faq-one-accrodion .accrodion-content p', ['layout_four']);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		include ambed_get_template('about-one.php');
		include ambed_get_template('about-two.php');
		include ambed_get_template('about-three.php');
		include ambed_get_template('about-four.php');
		include ambed_get_template('about-five.php');
		include ambed_get_template('about-six.php');
	}
}
