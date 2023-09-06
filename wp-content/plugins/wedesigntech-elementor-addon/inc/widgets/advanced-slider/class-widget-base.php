<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Advanced_Slider {

	private static $_instance = null;

	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
		$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
		$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-advanced-slider';
	}

	public function title() {
		return esc_html__( 'Advanced Slider', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/advanced-slider/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		if(!\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return array (
				$this->name() => $this->cc_layout->get_column_css()
			);
		}
		return array ();
	}

	public function init_scripts() {
		return array_merge(
			$this->cc_layout->init_scripts(),
			array ()
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		) );

		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control( 'enable_image', array(
			'label' => esc_html__( 'Enable Image', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'image', array (
			'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => array (
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
			'condition'   => array ( 'enable_image' => 'true' )
		) );

		$repeater->add_control( 'enable_icon', array(
			'label' => esc_html__( 'Enable Icon', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control('icon',array (
			'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::ICONS,
			'default' => array(
				'value' => 'far fa-paper-plane',
				'library' => 'fa-regular'
			),
			'condition'   => array ( 'enable_icon' => 'true' )
		) );
		$repeater->add_control( 'icon_link',array(
			'label'       => esc_html__( 'Icon Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_icon' => 'true' ),
		) );

		$repeater->add_control( 'enable_title', array(
			'label' => esc_html__( 'Enable Title', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'title', array(
			'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Title goes here', 'wdt-elementor-addon' ),
			'condition'   => array ( 'enable_title' => 'true' )
		) );
		
		$repeater->add_control( 'enable_sub_title', array(
			'label' => esc_html__( 'Enable Sub Title', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'sub_title', array(
			'label'       => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'placeholder' => esc_html__( 'Sub title goes here', 'wdt-elementor-addon' ),
			'condition'   => array ( 'enable_sub_title' => 'true' )
		) );

		$repeater->add_control( 'enable_description', array(
			'label' => esc_html__( 'Enable Description', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'description', array(
			'label'       => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'label_block' => true,
			'placeholder' => esc_html__( 'Item Description', 'wdt-elementor-addon' ),
			'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.', 'wdt-elementor-addon' ),
			'condition'   => array( 'enable_description' => 'true' )
		) );
		
		$repeater->add_control( 'enable_button_1', array(
			'label' => esc_html__( 'Enable Button 1', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'button_1_text',array(
			'label'       => esc_html__( 'Button 1 Text', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__('Click Here!', 'wdt-elementor-addon'),
			'placeholder' => esc_html__('Click Here!', 'wdt-elementor-addon'),
			'condition'   => array( 'enable_button_1' => 'true' )
		) );
		$repeater->add_control( 'button_1_link',array(
			'label'       => esc_html__( 'Button 1 Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_button_1' => 'true' ),
			'separator'   => 'after'
		) );

		$repeater->add_control( 'enable_button_2', array(
			'label' => esc_html__( 'Enable Button 2', 'wdt-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'frontend_available' => true,
			'default'            => '',
			'return_value'       => 'true'
		) );
		$repeater->add_control( 'button_2_text',array(
			'label'       => esc_html__( 'Button 2 Text', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__('Click Here!', 'wdt-elementor-addon'),
			'placeholder' => esc_html__('Click Here!', 'wdt-elementor-addon'),
			'condition'   => array( 'enable_button_2' => 'true' )
		) );
		$repeater->add_control( 'button_2_link',array(
			'label'       => esc_html__( 'Button 2 Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
			'condition'   => array( 'enable_button_2' => 'true' )
		) );

		$elementor_object->add_control( 'contents', array(
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'label'       => esc_html__('Contents', 'wdt-elementor-addon'),
			'description' => esc_html__('Contents', 'wdt-elementor-addon' ),
			'fields'      => $repeater->get_controls(),
			'default' => array (
				array (
					'title' => 'Title 1',
					'sub_title' => 'Sub title 1',
					'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
				),
				array (
					'title' => 'Title 2',
					'sub_title' => 'Sub title 2',
					'description' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
				),
				array (
					'title' => 'Title 3',
					'sub_title' => 'Sub title 3',
					'description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
				)
			)
		) );

		$elementor_object->end_controls_section();
		$this->cc_layout->get_controls($elementor_object);

		// Item
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'item',
			'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
                    'control_type' => 'responsive',
                    'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
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
										'{{WRAPPER}} .wdt-specification-block, {{WRAPPER}} .wdt-specification-block .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block .wdt-content-title h5 > a, {{WRAPPER}} .wdt-specification-block .wdt-content-subtitle, {{WRAPPER}} .wdt-specification-block .wdt-social-icons-list li a, {{WRAPPER}} .wdt-specification-block .wdt-rating li span, {{WRAPPER}} .wdt-specification-block ul li, {{WRAPPER}} .wdt-specification-block span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5 > a, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-subtitle, {{WRAPPER}} .wdt-specification-block:hover .wdt-social-icons-list li a, {{WRAPPER}} .wdt-specification-block:hover .wdt-rating li span, {{WRAPPER}} .wdt-specification-block:hover ul li, {{WRAPPER}} .wdt-specification-block:hover span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover',
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
			'slug' => 'title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-title h5',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					/* 'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-specification-block .wdt-content-detail-group, {{WRAPPER}} .wdt-content-item .wdt-specification-block div:not(.wdt-content-detail-group) .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ), */
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-specification-block .wdt-content-detail-group .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block .wdt-content-title h5 > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-title h5 > a:hover, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-elements-group:hover .wdt-content-title h5 > a:hover, .wdt-specification-block:hover .wdt-content-elements-group.wdt-media-image-cover > .wdt-media-image-cover-container > div h5 > a:hover, .wdt-specification-block:hover .wdt-content-elements-group.wdt-media-image-overlay > .wdt-media-image-overlay-container > div h5 > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Sub Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'subtitle',
			'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-subtitle',
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-subtitle' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-subtitle' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Image
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'image',
			'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a' => 'width: {{SIZE}}{{UNIT}};',

                        '{{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-side-image .wdt-specification-block .wdt-content-media-group .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-side-image .wdt-specification-block .wdt-content-media-group .wdt-content-image-wrapper .wdt-content-image, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-side-image .wdt-specification-block .wdt-content-media-group .wdt-content-image-wrapper .wdt-content-image > a, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-side-image .wdt-specification-block .wdt-content-media-group .wdt-content-image-wrapper .wdt-content-image > span,

						{{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-content .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-content .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-content .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image > a, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-content .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image > span,

						{{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-title .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-title .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-title .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image > a, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-title .wdt-specification-block .wdt-content-group .wdt-content-image-wrapper .wdt-content-image > span,

						{{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-icon .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-icon .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-icon .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image > a, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-aside-icon .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image > span,

						{{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-duotone .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-duotone .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-duotone .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image > a, {{WRAPPER}} .wdt-specifications-holder.wdt-rc-template-duotone .wdt-specification-block .wdt-content-media-group .wdt-content-elements-group.wdt-media-group .wdt-content-image-wrapper .wdt-content-image > span' => 'min-width: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'height' => array (
					'field_type' => 'height',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a' => 'height: {{SIZE}}{{UNIT}};',

                        '{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper .wdt-content-image > a,
						{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-elements-group.wdt-media-image-overlay .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-elements-group.wdt-media-image-overlay .wdt-content-image-wrapper .wdt-content-image > a' => 'height: {{SIZE}}{{UNIT}}; margin-top: auto; margin-bottom: auto;',

						'{{WRAPPER}} .wdt-rc-template-stage-over .wdt-specification-block .wdt-content-media-group .wdt-content-image-wrapper' => 'font-size: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > span, {{WRAPPER}} .wdt-specifications-holder .wdt-specification-block .wdt-content-image-wrapper .wdt-content-image > a',
					'condition' => array ()
				)
			)
		));

		// Description
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'description',
			'title' => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-description',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-description',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-description',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block .wdt-content-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-description',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-description' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-description',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-description',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-description',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Button
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'button',
			'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-content-button > a',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-content-button > a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Link
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'link',
			'title' => esc_html__( 'Link', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
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
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block .wdt-content-button-group .wdt-link-button > a',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:focus, {{WRAPPER}} .wdt-specification-block:hover .wdt-content-button-group .wdt-link-button > a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Arrow
		$this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

		// Carousel
        $this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}
		
		$output = '';
		$classes = array ();

        $settings['module_id'] = $widget_object->get_id();
        $settings['module_class'] = 'specifications';
        $settings['classes'] = $classes;
		$this->cc_layout->set_settings($settings);
        $module_layout_class = $this->cc_layout->get_item_class();

		if( count( $settings['contents'] ) > 0 ):
			$output .= $this->cc_layout->get_wrapper_start();
			foreach( $settings['contents'] as $key => $item ) {

				$output .= '<div class="'.esc_attr($module_layout_class).'">';
					$output .= '<div class="wdt-content-item">';
						$output .= '<div class="wdt-specification-block">';
							$output .= '<div class="wdt-image-icon-group">';
								$output .= '<div class="wdt-content-image-wrapper">';
									$output .= '<div class="wdt-content-image">';
									if( isset($item['enable_image']) && 'true' == $item['enable_image'] ) {
										if( (isset($item['image']['url']) && !empty($item['image']['url'])) ) {
											$image_setting = array ();
											$image_setting['image'] = $item['image'];
											$image_setting['image_size'] = 'full';
											$image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();
											$output .= '<a href="'.esc_url( $item['link']['url'] ).'" target="_blank" rel="nofollow">';
												$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );
											$output .= '</a>';
										}
									}
									$output .= '</div>';
								$output .= '</div>';

								$output .= '<div class="wdt-content-icon-wrapper ">';
									$output .= '<div class="wdt-content-icon">';
									if( isset($item['enable_icon']) && 'true' == $item['enable_icon'] ) {
										if( (isset($item['icon']['value']) && !empty($item['icon']['value'])) ) {
											$target = ( $item['icon_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
											$nofollow = ( $item['icon_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
											$output .= '<a href="'.esc_url( $item['icon_link']['url'] ).'"'. $target . $nofollow.' class="silde_pop_vid">';
												$output .= '<span>';
													$output .= ($item['library'] === 'svg') ? '<i>' : '';
														ob_start();
														\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
														$output .= ob_get_clean();
													$output .= ($item['library'] === 'svg') ? '</i>' : '';
												$output .= '</span>';
											$output .= '</a>';
										}
									}
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';

							$output .= '<div class="wdt-content-detail-group">';
								if( (isset($item['title']) && !empty($item['title'])) ):
									$output .= '<div class="wdt-content-title"><h5><a href="'.esc_url( $item['link']['url'] ).'">'.esc_html($item['title']).'</a></h5></div>';
								endif;
								if( (isset($item['sub_title']) && !empty($item['sub_title'])) ):
									$output .= '<div class="wdt-content-subtitle">'.esc_html($item['sub_title']).'</div>';
								endif;
								if( (isset($item['description']) && !empty($item['description'])) ):
									$output .= '<div class="wdt-content-description">'.esc_html($item['description']).'</div>';
								endif;

								$output .= '<div class="wdt-content-button-group">';
									
									if( !empty( $item['button_1_link']['url'] ) && !empty( $item['button_1_link'] ) ){
										$output .= '<div class="wdt-content-button wdt-button-clone">';
											$target = ( $item['button_1_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
											$nofollow = ( $item['button_1_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
											$output .= '<a href="'.esc_url( $item['button_1_link']['url'] ).'"'. $target . $nofollow.'><div class="wdt-button-text"><span>'. esc_html( $item['button_1_text'] ) .'</span>';
											$output .= '</div></a>';
										$output .= '</div>';
									}

									if( !empty( $item['button_2_link']['url'] ) && !empty( $item['button_2_link'] ) ){
										$output .= '<div class="wdt-content-button wdt-button-clone">';
											$target = ( $item['button_2_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
											$nofollow = ( $item['button_2_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
											$output .= '<a href="'.esc_url( $item['button_2_link']['url'] ).'"'. $target . $nofollow.'><div class="wdt-button-text"><span>'. esc_html( $item['button_2_text'] ) .'</span>';
											$output .= '</div></a>';
										$output .= '</div>';
									}

								$output .= '</div>';

							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';

			}

			$output .= $this->cc_layout->get_column_edit_mode_css();
            $output .= $this->cc_layout->get_wrapper_end();

		else:
			$output .= '<div class="wdt-specifications-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_advanced_slider' ) ) {
    function wedesigntech_widget_base_advanced_slider() {
        return WeDesignTech_Widget_Base_Advanced_Slider::instance();
    }
}