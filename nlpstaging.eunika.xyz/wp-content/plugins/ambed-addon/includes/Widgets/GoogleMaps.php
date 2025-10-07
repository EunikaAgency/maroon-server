<?php

namespace Layerdrops\Ambed\Widgets;

use Elementor\Modules\DynamicTags\Module as TagsModule;

class GoogleMaps extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'ambed-google-maps';
	}

	public function get_title()
	{
		return __('Google Maps', 'ambed-addon');
	}

	public function get_icon()
	{
		return 'eicon-cogs';
	}

	public function get_categories()
	{
		return ['ambed-category'];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__('Map', 'ambed-addon'),
			]
		);

		if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$api_key = get_option('elementor_google_maps_api_key');

			if (!$api_key) {
				$this->add_control(
					'api_key_notification',
					[
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => sprintf(
							/* translators: 1: Integration settings link open tag, 2: Create API key link open tag, 3: Link close tag. */
							esc_html__('Set your Google Maps API Key in Elementor\'s %1$sIntegrations Settings%3$s page. Create your key %2$shere.%3$s', 'ambed-addon'),
							'<a href="' . \Elementor\Settings::get_url() . '#tab-integrations" target="_blank">',
							'<a href="https://developers.google.com/maps/documentation/embed/get-api-key" target="_blank">',
							'</a>'
						),
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					]
				);
			}
		}

		$default_address = esc_html__('London Eye, London, United Kingdom', 'ambed-addon');
		$this->add_control(
			'address',
			[
				'label' => esc_html__('Location', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
					],
				],
				'placeholder' => $default_address,
				'default' => $default_address,
				'label_block' => true,
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => esc_html__('Zoom', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__('Height', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 1440,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px', 'vh'],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__('View', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_map_style',
			[
				'label' => esc_html__('Map', 'ambed-addon'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('map_filter');

		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__('Normal', 'ambed-addon'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} iframe',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__('Hover', 'ambed-addon'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover iframe',
			]
		);

		$this->add_control(
			'hover_transition',
			[
				'label' => esc_html__('Transition Duration', 'ambed-addon'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'transition-duration: {{SIZE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include ambed_get_template('google-map-one.php');
	}
}
