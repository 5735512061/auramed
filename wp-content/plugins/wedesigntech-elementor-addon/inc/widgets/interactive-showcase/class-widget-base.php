<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Interactive_Showcase {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_content_position;
	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Options
			$options_group = array( 'default', 'template' );
			$options['default'] = array(
				'icon'           => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'          => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'    => esc_html__( 'Description', 'wdt-elementor-addon'),
				'image'          => esc_html__( 'Image', 'wdt-elementor-addon'),
				'link'           => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'         => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$options['template'] = array(
				'icon'           => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'          => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'    => esc_html__( 'Description', 'wdt-elementor-addon'),
				'image'          => esc_html__( 'Image', 'wdt-elementor-addon'),
				'link'           => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'         => esc_html__( 'Button', 'wdt-elementor-addon')
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'image'           => esc_html__( 'Image', 'wdt-elementor-addon'),
				'icon'            => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 1 - Element Group content positions
			$group1_element_group_content_position_elements = array(
				'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
				'link'            => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$group1_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);

		// Group 2 content positions
			$group2_content_position_elements = array();
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Group 2 - Element Group content positions
			$group2_element_group_content_position_elements = array();
			$group2_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group1_element_group_content_position_elements, $group2_content_position_elements, $group2_element_group_content_position_elements);

		// Module defaults
			$option_defaults = array(
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sed lectus mi. Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros. Nam porttitor massa ac leo porta congue nec at leo. Maecenas rutrum, neque bibendum vestibulum imperdiet, ex tellus molestie ante, at semper justo neque vel nisi. In tellus felis, suscipit pellentesque imperdiet sit amet, posuere nec sem. Sed at fringilla justo. Fusce dictum condimentum turpis vitae interdum.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				),
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros. Nam porttitor massa ac leo porta congue nec at leo. Maecenas rutrum, neque bibendum vestibulum imperdiet, ex tellus molestie ante, at semper justo neque vel nisi. In tellus felis, suscipit pellentesque imperdiet sit amet, posuere nec sem. Sed at fringilla justo. Fusce dictum condimentum turpis vitae interdum.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				)
			);

		// Module Details
			$module_details = array (
				'content_positions' => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group'),
				'group1_title'    => esc_html__( 'Image Group', 'wdt-elementor-addon'),
				'group2_title'    => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'    => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label' => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'          => 'wdtRepeaterInteractiveShowcaseContent',
				'title'           => esc_html__( 'Items', 'wdt-elementor-addon' ),
				'description'     => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_content_position = new WeDesignTech_Common_Controls_Content_Position($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-interactive-showcase';
	}

	public function title() {
		return esc_html__( 'Interactive Showcase', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$this->cc_repeater_contents->get_controls($elementor_object);

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

			$elementor_object->add_control(
				'icon_show',
				array(
					'label'              => esc_html__( 'Show Icon', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			$elementor_object->add_control(
				'image_show',
				array(
					'label'              => esc_html__( 'Show Image', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			$elementor_object->add_control(
				'hover_and_click',
				array(
					'label'              => esc_html__( 'Show Content on Click', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'false',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

		$elementor_object->end_controls_section();


	// Item Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_item_content',
			'title' => esc_html__( 'Item Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:before' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover / Active', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:before, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

	// Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element',
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a:before' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper ul.wdt-interactive-showcase-list li',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper ul.wdt-interactive-showcase-list li' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover / Active', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element::before, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element::after, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li a.wdt-interactive-showcase-element:before' => 'background-color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element:after, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list a.wdt-interactive-showcase-element::after' => 'background: transparent;'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list:before, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list li.wdt-interactive-showcase-active a.wdt-interactive-showcase-element, {{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-list-wrapper .wdt-interactive-showcase-list li a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));


	// Tab Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_content',
			'title' => esc_html__( 'Tab Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'vertical_align' => array (
					'field_type' => 'vertical_align',
					'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
					'options' => array (
						'start' => array (
							'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-middle',
						),
						'end' => array (
							'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						)
					),
					'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'align-items: {{VALUE}};'
					),
					'condition' => array (
						'layout' => 'vertical'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper',
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-container .wdt-interactive-showcase-content-wrapper',
					'condition' => array ()
				)
			)
		));

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['item_contents'] ) > 0 ):

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'interactive-showcase';

			$output .= '<div class="wdt-interactive-showcase-container" data-click="'. esc_js($settings['hover_and_click']) .'">';
				$output .= '<div class="wdt-interactive-showcase-list-wrapper">';
					$output .= '<ul class="wdt-interactive-showcase-list">';
						foreach( $settings['item_contents'] as $key => $item ) {
							$output .= '<li id="wdt-interactive-showcase-'.esc_attr($key).'">';
								$output .= '<a href="javascript:void(0);" class="wdt-interactive-showcase-element">';

								if( $item['item_type'] == 'template' ) {
									$output .= '<div class="wdt-interactive-showcase-content-group">';
										$output .= '<div class="wdt-interactive-showcase-media-group">';
											if($settings['icon_show'] == 'true') {
												$output .= $this->cc_repeater_contents->render_template_icon($key, $item, $widget_object);
											}
											if($settings['image_show'] == 'true') {
												$link_start = '<a href="'.esc_url( $item['item_link_template']['url'] ).'">';
												$link_end = '</a>';
												$output .= $this->render_image($item, $link_start, $link_end);
											}										
										$output .= '</div>';

										$output .= '<div class="wdt-interactive-showcase-content-group">';
											
											if( !empty($item['item_title']) ) {
												$output .= '<div class="wdt-content-title">'.esc_html($item['item_title']).'</div>';
											}
											if( !empty($item['item_description_template']) ) {
												$output .= '<div class="wdt-content-description">'.esc_html($item['item_description_template']).'</div>';
											}
											if( isset($item['item_link_template']['url']) && !empty($item['item_link_template']['url']) ) {
												$output .= '<div class="wdt-interactive-showcase-button">';
													$target = ( $item['item_link_template']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
													$nofollow = ( $item['item_link_template']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
													$output .= '<a href="'.esc_url( $item['item_link_template']['url'] ).'"'. $target . $nofollow.'><div class="wdt-interactive-showcase-button-link"><span>'. esc_html__($item['item_button_text_template']) .'</span>';
													$output .= '</div></a>';
												$output .= '</div>';
											}									
										$output .= '</div>';

									$output .= '</div>';
								} else {
									
									$output .= '<div class="wdt-interactive-showcase-content-group">';
										if( !empty($item['item_title']) ) {
											$output .= '<div class="wdt-content-title">'.esc_html($item['item_title']).'</div>';
										}
										if($settings['icon_show'] == 'true') {
											$output .= $this->render_icon($item['media_icon']);
										}								
									$output .= '</div>';

								}
							$output .= '</a></li>';
						}
					$output .= '</ul>';
				$output .= '</div>';
				$output .= '<div class="wdt-interactive-showcase-content-wrapper">';
					foreach( $settings['item_contents'] as $key => $item ) {
						$output .= '<div id="wdt-interactive-showcase-'.esc_attr($key).'">';

						if( $item['item_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $item['item_template'], true );
						} else {
							$output .= '<div class="wdt-interactive-showcase-media-group">';
								if($settings['image_show'] == 'true') {
									$output .= $this->cc_repeater_contents->render_image($item, '', '');
								}
								$output .= '<div class="wdt-interactive-showcase-content">';								
									if( !empty($item['item_description']) ) {
										$output .= '<div class="wdt-content-description">'.esc_html($item['item_description']).'</div>';
									}
									if( isset($item['item_link']['url']) && !empty($item['item_link']['url']) ) {
										$output .= '<div class="wdt-interactive-showcase-button">';
											$target = ( $item['item_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
											$nofollow = ( $item['item_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
											$output .= '<a href="'.esc_url( $item['item_link']['url'] ).'"'. $target . $nofollow.'><div class="wdt-interactive-showcase-button-link"><span>'. esc_html__($item['item_button_text']) .'</span>';
											$output .= '</div></a>';
										$output .= '</div>';
									}
								$output .= '</div>';
							$output .= '</div>';
						}

						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';

		else:
			$output .= '<div class="wdt-interactive-showcase-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

	public function render_icon($icon) {
		$output = '';
		if(!empty($icon['value'])):

			$output .= ($icon['library'] === 'svg') ? '<i>' : '';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
				$output .= ob_get_clean();
			$output .= ($icon['library'] === 'svg') ? '</i>' : '';

		endif;
		return $output;
	}

	public function render_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['media_image_template']['url'] ) ) :
			$class = '';
			$output .= '<div class="wdt-content-image-wrapper '.esc_attr($class).'">';
				$output .= '<div class="wdt-content-image">';

					$media_image_setting = array ();
					$media_image_setting['image'] = $item['media_image_template'];
					$media_image_setting['image_size'] = 'full';
					$media_image_setting['image_custom_dimension'] = isset($item['media_image_template_custom_dimension']) ? $item['media_image_custom_dimension'] : array ();

					$output .=  ($link_start != '') ? $link_start : '<span>';
						$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
					$output .=  ($link_end != '') ? $link_end : '</span>';

				$output .= '</div>';
			$output .= '</div>';

		endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_interactive_showcase' ) ) {
    function wedesigntech_widget_base_interactive_showcase() {
        return WeDesignTech_Widget_Base_Interactive_Showcase::instance();
    }
}