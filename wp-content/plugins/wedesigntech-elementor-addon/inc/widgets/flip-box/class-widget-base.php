<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Flip_Box {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function name() {
		return 'wdt-flip-box';
	}

	public function title() {
		return esc_html__( 'Flip Box', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/flip-box/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/flip-box/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		// Front Section

			$elementor_object->start_controls_section(
				'wdt_front_section',
				array (
					'label' => esc_html__( 'Front', 'wdt-elementor-addon' ),
				)
			);

			$elementor_object->add_control(
				'graphic_element_front',
				array (
					'label' => esc_html__( 'Graphic Element', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array(
						'none' => array (
							'title' => esc_html__( 'None', 'wdt-elementor-addon' ),
							'icon' => 'eicon-ban',
						),
						'image' => array (
							'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
							'icon' => 'eicon-image',
						),
						'icon' => array (
							'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'icon' => 'eicon-star',
						)
					),
					'default' => 'icon',
				)
			);

			$elementor_object->add_control(
				'image_front',
				array (
					'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				array (
					'name' => 'image_front', // Actually its `image_size`
					'default' => 'thumbnail',
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'icon_front',
				array (
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'title_text_front',
				array (
					'label' => esc_html__( 'Title & Description', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'This is the heading', 'wdt-elementor-addon' ),
					'placeholder' => esc_html__( 'Enter your title', 'wdt-elementor-addon' ),
					'label_block' => true,
					'separator' => 'before',
				)
			);

			$elementor_object->add_control(
				'description_text_front',
				array (
					'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'wdt-elementor-addon' ),
					'placeholder' => esc_html__( 'Enter your description', 'wdt-elementor-addon' ),
					'separator' => 'none',
					'rows' => 10,
					'show_label' => false,
				)
			);

			$elementor_object->end_controls_section();


		// Back Section

			$elementor_object->start_controls_section(
				'wdt_back_section',
				array (
					'label' => esc_html__( 'Back', 'wdt-elementor-addon' ),
				)
			);

			$elementor_object->add_control(
				'graphic_element_back',
				array (
					'label' => esc_html__( 'Graphic Element', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'none' => array (
							'title' => esc_html__( 'None', 'wdt-elementor-addon' ),
							'icon' => 'eicon-ban',
						),
						'image' => array (
							'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
							'icon' => 'eicon-image',
						),
						'icon' => array (
							'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'icon' => 'eicon-star',
						)
					),
					'default' => 'icon',
				)
			);

			$elementor_object->add_control(
				'image_back',
				array (
					'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				array (
					'name' => 'image_back', // Actually its `image_size`
					'default' => 'thumbnail',
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'icon_back',
				array (
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'title_text_back',
				array (
					'label' => esc_html__( 'Title & Description', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'This is the heading', 'wdt-elementor-addon' ),
					'placeholder' => esc_html__( 'Enter your title', 'wdt-elementor-addon' ),
					'label_block' => true,
				)
			);

			$elementor_object->add_control(
				'description_text_back',
				array (
					'label'       => esc_html__( 'Description', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXTAREA,
					'default'     => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'wdt-elementor-addon' ),
					'placeholder' => esc_html__( 'Enter your description', 'wdt-elementor-addon' ),
					'separator'   => 'none',
					'rows'        => 10,
					'show_label'  => false,
				)
			);

			$elementor_object->add_control(
				'link_type_back',
				array (
					'label'      => esc_html__( 'Link Type', 'wdt-elementor-addon' ),
					'type'       => \Elementor\Controls_Manager::SELECT,
					'default'    => 'none',
					'options'    => array (
						'none'   => esc_html__( 'None', 'wdt-elementor-addon' ),
						'box'    => esc_html__( 'Box', 'wdt-elementor-addon' ),
						'title'  => esc_html__( 'Title', 'wdt-elementor-addon' ),
						'button' => esc_html__( 'Button', 'wdt-elementor-addon' ),
					),
				)
			);

			$elementor_object->add_control(
				'link_back',
				array (
					'label'                 => esc_html__( 'Link', 'wdt-elementor-addon' ),
					'type'                  => \Elementor\Controls_Manager::URL,
					'placeholder'           => 'https://www.your-link.com',
					'default'               => array (
						'url' => '#',
					),
					'condition'             => array (
						'link_type_back!'   => 'none',
					),
				)
			);

			$elementor_object->add_control(
				'button_text_back',
				array (
					'label'                 => esc_html__( 'Button Text', 'wdt-elementor-addon' ),
					'type'                  => \Elementor\Controls_Manager::TEXT,
					'dynamic'               => array (
						'active'   => true,
					),
					'default'               => esc_html__( 'Get Started', 'wdt-elementor-addon' ),
					'condition'             => array (
						'link_type_back'   => 'button',
					),
				)
			);

			$elementor_object->add_control(
				'button_icon_back',
				array (
					'label' => esc_html__( 'Button Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
					'condition' => array (
						'link_type_back'   => 'button',
					),
				)
			);

			$elementor_object->add_control(
				'button_icon_position_back',
				array (
					'label'                 => esc_html__( 'Icon Position', 'wdt-elementor-addon' ),
					'type'                  => \Elementor\Controls_Manager::SELECT,
					'default'               => 'after',
					'options'               => array (
						'after'     => esc_html__( 'After', 'wdt-elementor-addon' ),
						'before'    => esc_html__( 'Before', 'wdt-elementor-addon' ),
					),
					'condition'             => array (
						'link_type_back'     => 'button',
						'button_icon_back[value]!'  => '',
					),
				)
			);

			$elementor_object->end_controls_section();


		// Settings Section

			$elementor_object->start_controls_section(
				'wdt_settings_section',
				array (
					'label' => esc_html__( 'Settings', 'wdt-elementor-addon' ),
				)
			);

			$elementor_object->add_responsive_control(
				'height',
				array (
					'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 100,
							'max' => 1000,
						),
						'vh' => array (
							'min' => 10,
							'max' => 100,
						),
					),
					'size_units' => array ( 'px', 'vh' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$elementor_object->add_control(
				'border_radius',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'px', '%' ),
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 200,
						),
					),
					'separator' => 'after',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-layer, {{WRAPPER}} .wdt-flip-box-overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$elementor_object->add_control(
				'flip_effect',
				array (
					'label' => esc_html__( 'Flip Effect', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'flip',
					'options' => array (
						'flip' => 'Flip',
						'slide' => 'Slide',
						'push' => 'Push',
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'fade' => 'Fade',
					),
					'prefix_class' => 'wdt-flip-box-effect-',
				)
			);

			$elementor_object->add_control(
				'flip_direction',
				array (
					'label' => esc_html__( 'Flip Direction', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'up',
					'options' => array (
						'left' => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'right' => esc_html__( 'Right', 'wdt-elementor-addon' ),
						'up' => esc_html__( 'Up', 'wdt-elementor-addon' ),
						'down' => esc_html__( 'Down', 'wdt-elementor-addon' ),
					),
					'condition' => array (
						'flip_effect!' => array (
							'fade',
							'zoom-in',
							'zoom-out',
						),
					),
					'prefix_class' => 'wdt-flip-box-direction-',
				)
			);

			$elementor_object->add_control(
				'flip_3d',
				array (
					'label' => esc_html__( '3D Depth', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off' => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'wdt-flip-box-3d',
					'default' => '',
					'prefix_class' => '',
					'condition' => array (
						'flip_effect' => 'flip',
					),
				)
			);

			$elementor_object->end_controls_section();


		// Front Style Section

			$elementor_object->start_controls_section(
				'wdt_front_style_section',
				array (
					'label' => esc_html__( 'Front', 'wdt-elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$elementor_object->add_responsive_control(
				'padding_front',
				array (
					'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-front .wdt-flip-box-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$elementor_object->add_control(
				'alignment_front',
				array (
					'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'left' => array (
							'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-left',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-center',
						),
						'right' => array (
							'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-right',
						),
					),
					'default' => 'center',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-front .wdt-flip-box-inner' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
				)
			);

			$elementor_object->add_control(
				'vertical_position_front',
				array (
					'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'top' => array (
							'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'middle' => array (
							'title' => esc_html__( 'Middle', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-middle',
						),
						'bottom' => array (
							'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						),
					),
					'selectors_dictionary' => array (
						'top' => 'flex-start',
						'middle' => 'center',
						'bottom' => 'flex-end',
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-front .wdt-flip-box-inner' => 'justify-content: {{VALUE}}',
					)
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'border_front',
					'selector' => '{{WRAPPER}} .wdt-flip-box-front'
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array (
					'name' => 'background_front',
					'types' => array ( 'classic', 'gradient' ),
					'selector' => '{{WRAPPER}} .wdt-flip-box-front',
				)
			);

			$elementor_object->add_control(
				'background_overlay_front',
				array (
					'label' => esc_html__( 'Background Overlay', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-overlay' => 'background-color: {{VALUE}};',
					),
					'condition' => array (
						'background_front_image[id]!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'heading_image_style_front',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
					'separator' => 'before',
				)
			);

			$elementor_object->add_control(
				'image_spacing_front',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
                        '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-image' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'image_width_front',
				array (
					'label' => esc_html__( 'Size (%)', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( '%' ),
					'default' => array (
						'unit' => '%',
					),
					'range' => array (
						'%' => array (
							'min' => 5,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-image img' => 'width: {{SIZE}}{{UNIT}}',
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'image_opacity_front',
				array (
					'label' => esc_html__( 'Opacity', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => array (
						'size' => 1,
					),
					'range' => array (
						'px' => array (
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-image img' => 'opacity: {{SIZE}};',
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'image_border_front',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-image img',
					'condition' => array (
						'graphic_element_front' => 'image',
					)
				)
			);

			$elementor_object->add_control(
				'image_border_radius_front',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'heading_icon_style_front',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
					'separator' => 'before',
				)
			);

			$elementor_object->add_control(
				'icon_spacing_front',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_color_front',
				array (
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_background_color_front',
				array (
					'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'background-color: {{VALUE}};',
					),
				)
			);

			$elementor_object->add_control(
				'icon_size_front',
				array (
					'label' => esc_html__( 'Icon Size', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 6,
							'max' => 300,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon'
					),
				)
			);

            $elementor_object->add_control(
				'icon_width_front',
				array (
					'label' => esc_html__( 'Icon Width', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => 'px'
                    ),
                    'size_units' => array ( 'px' ),
					'range' => array (
						'px' => array (
							'min' => 1,
							'max' => 1000,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_height_front',
				array (
					'label' => esc_html__( 'Icon Height', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => 'px'
                    ),
                    'size_units' => array ( 'px' ),
					'range' => array (
						'px' => array (
							'min' => 1,
							'max' => 1000,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_rotate_front',
				array (
					'label' => esc_html__( 'Icon Rotate', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => array (
						'size' => 0,
						'unit' => 'deg',
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'transform: rotate({{SIZE}}{{UNIT}});',
					),
					'condition' => array (
						'graphic_element_front' => 'icon'
					),
				)
			);

            $elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'icon_border_front',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before',
                    'condition' => array (
						'graphic_element_front' => 'icon'
					)
				)
			);

			$elementor_object->add_control(
				'icon_border_radius_front',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-front .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_front' => 'icon'
					),
				)
			);

			$elementor_object->add_control(
				'heading_title_style_front',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array (
						'title_text_front!' => ''
					),
				)
			);

			$elementor_object->add_control(
				'title_spacing_front',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'description_text_front!' => '',
						'title_text_front!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'title_color_front',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-title, {{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-title a' => 'color: {{VALUE}}',

					),
					'condition' => array (
						'title_text_front!' => '',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'title_typography_front',
					'selector' => '{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-title',
					'condition' => array (
						'title_text_front!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'heading_description_style_front',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array (
						'description_text_front!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'description_color_front',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-description' => 'color: {{VALUE}}',

					),
					'condition' => array (
						'description_text_front!' => '',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'description_typography_front',
					'selector' => '{{WRAPPER}} .wdt-flip-box-front .wdt-flip-box-description',
					'condition' => array (
						'description_text_front!' => '',
					),
				)
			);

			$elementor_object->end_controls_section();



		// Back Style Section

			$elementor_object->start_controls_section(
				'wdt_back_style_section',
				array (
					'label' => esc_html__( 'Back', 'wdt-elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$elementor_object->add_responsive_control(
				'padding_back',
				array (
					'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-back .wdt-flip-box-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$elementor_object->add_control(
				'alignment_back',
				array (
					'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'left' => array (
							'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-left',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-center',
						),
						'right' => array (
							'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
							'icon' => 'fa fa-align-right',
						),
					),
					'default' => 'center',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-back .wdt-flip-box-inner' =>  'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
				)
			);

			$elementor_object->add_control(
				'vertical_position_back',
				array (
					'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'top' => array (
							'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'middle' => array (
							'title' => esc_html__( 'Middle', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-middle',
						),
						'bottom' => array (
							'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						),
					),
					'selectors_dictionary' => array (
						'top' => 'flex-start',
						'middle' => 'center',
						'bottom' => 'flex-end',
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-back .wdt-flip-box-inner' => 'justify-content: {{VALUE}}',
					)
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'border_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box-back'
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array (
					'name' => 'background_back',
					'types' => array ( 'classic', 'gradient' ),
					'selector' => '{{WRAPPER}} .wdt-flip-box-back',
				)
			);

			$elementor_object->add_control(
				'background_overlay_back',
				array (
					'label' => esc_html__( 'Background Overlay', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-overlay' => 'background-color: {{VALUE}};',
					),
					'condition' => array (
						'background_front_image[id]!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'heading_image_style_back',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
					'separator' => 'before',
				)
			);

			$elementor_object->add_control(
				'image_spacing_back',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'image_width_back',
				array (
					'label' => esc_html__( 'Size (%)', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( '%' ),
					'default' => array (
						'unit' => '%',
					),
					'range' => array (
						'%' => array (
							'min' => 5,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-image img' => 'width: {{SIZE}}{{UNIT}}',
					),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'image_opacity_back',
				array (
					'label' => esc_html__( 'Opacity', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => array (
						'size' => 1,
					),
					'range' => array (
						'px' => array (
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-image img' => 'opacity: {{SIZE}};',
					),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'image_border_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-image img',
					'condition' => array (
						'graphic_element_back' => 'image',
					)
				)
			);

			$elementor_object->add_control(
				'image_border_radius_back',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
					),
					'condition' => array (
						'graphic_element_back' => 'image',
					),
				)
			);

			$elementor_object->add_control(
				'heading_icon_style_back',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
					'separator' => 'before',
				)
			);

			$elementor_object->add_control(
				'icon_spacing_back',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_color_back',
				array (
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_background_color_back',
				array (
					'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'condition' => array (
						'graphic_element_back' => 'icon'
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'background-color: {{VALUE}};'
					),
				)
			);

			$elementor_object->add_control(
				'icon_size_back',
				array (
					'label' => esc_html__( 'Icon Size', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 6,
							'max' => 300,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_width_back',
				array (
					'label' => esc_html__( 'Icon Width', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => 'px'
                    ),
                    'size_units' => array ( 'px' ),
					'range' => array (
						'px' => array (
							'min' => 1,
							'max' => 1000,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_height_back',
				array (
					'label' => esc_html__( 'Icon Height', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => array (
                        'unit' => 'px'
                    ),
                    'size_units' => array ( 'px' ),
					'range' => array (
						'px' => array (
							'min' => 1,
							'max' => 1000,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

			$elementor_object->add_control(
				'icon_rotate_back',
				array (
					'label' => esc_html__( 'Icon Rotate', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => array (
						'size' => 0,
						'unit' => 'deg',
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span' => 'transform: rotate({{SIZE}}{{UNIT}});',
					),
					'condition' => array (
						'graphic_element_back' => 'icon',
					),
				)
			);

            $elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'icon_border_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before',
                    'condition' => array (
						'graphic_element_back' => 'icon',
					)
				)
			);

			$elementor_object->add_control(
				'icon_border_radius_back',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer.wdt-flip-box-back .wdt-flip-box-inner .wdt-flip-box-icon .wdt-content-icon-wrapper .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array (
						'graphic_element_back' => 'icon'
					),
				)
			);

			$elementor_object->add_control(
				'heading_title_style_back',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array (
						'title_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'title_spacing_back',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'title_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'title_color_back',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-title, {{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-title a' => 'color: {{VALUE}}',

					),
					'condition' => array (
						'title_text_back!' => '',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'title_typography_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-title',
					'condition' => array (
						'title_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'heading_description_style_back',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Description', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array (
						'description_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'description_spacing_back',
				array (
					'label' => esc_html__( 'Spacing', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'description_text_back!' => '',
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'description_color_back',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-description' => 'color: {{VALUE}}',

					),
					'condition' => array (
						'description_text_back!' => '',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'description_typography_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box-back .wdt-flip-box-description',
					'condition' => array (
						'description_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'heading_button',
				array (
					'type' => \Elementor\Controls_Manager::HEADING,
					'label' => esc_html__( 'Button', 'wdt-elementor-addon' ),
					'separator' => 'before',
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array (
					'name' => 'button_typography_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button',
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'button_border_radius_back',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => array (
						'px' => array (
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button' => 'border-radius: {{SIZE}}{{UNIT}};',
					),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->start_controls_tabs( 'button_tabs' );

			$elementor_object->start_controls_tab( 'button_tab_normal',
				array (
					'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'button_text_color_back',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button' => 'color: {{VALUE}};',
					),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'button_background_color_back',
				array (
					'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button' => 'background-color: {{VALUE}};',
					),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

            $elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'button_border_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button'
				)
			);

			$elementor_object->end_controls_tab();

			$elementor_object->start_controls_tab(
				'button_tab_hover',
				array (
					'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'button_hover_text_color_back',
				array (
					'label' => esc_html__( 'Text Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button:hover' => 'color: {{VALUE}};',
					),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

			$elementor_object->add_control(
				'button_hover_background_color_back',
				array (
					'label' => esc_html__( 'Background Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array (
						'{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button:hover' => 'background-color: {{VALUE}};',
					),
					'condition' => array (
						'button_text_back!' => '',
					),
				)
			);

            $elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array (
					'name' => 'button_hover_border_back',
					'selector' => '{{WRAPPER}} .wdt-flip-box .wdt-flip-box-layer .wdt-flip-box-inner .wdt-flip-box-button:hover'
				)
			);

			$elementor_object->end_controls_tab();

			$elementor_object->end_controls_tabs();

			$elementor_object->end_controls_section();


	}

	public function render_icon($icon) {
		$output = '';
		if(!empty($icon['value'])):

			$output .= '<div class="wdt-content-icon-wrapper">';
				$output .= '<div class="wdt-content-icon"><span>';
					$output .= ($icon['library'] === 'svg') ? '<i>' : '';
						ob_start();
						\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
						$output .= ob_get_clean();
					$output .= ($icon['library'] === 'svg') ? '</i>' : '';
				$output .= '</span></div>';
			$output .= '</div>';

		endif;
		return $output;
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		// Box

		$box_tag = 'div';
		$widget_object->add_render_attribute('wdt-flip-box-container', 'class', 'wdt-flip-box');

		if( $settings['link_type_back'] != 'none' ) {
			if( ! empty($settings['link_back']['url']) ) {
				if( $settings['link_type_back'] == 'box' ) {

					$box_tag = 'a';

					$widget_object->add_render_attribute( 'wdt-flip-box-container', 'href', esc_url($settings['link_back']['url']) );

					if( $settings['link_back']['is_external'] ) {
						$widget_object->add_render_attribute( 'wdt-flip-box-container', 'target', '_blank' );
					}

					if( $settings['link_back']['nofollow'] ) {
						$widget_object->add_render_attribute('wdt-flip-box-container', 'rel', 'nofollow');
					}

				} elseif( $settings['link_type_back'] == 'title' ) {

					$widget_object->add_render_attribute( 'wdt-flip-box-title-container', 'href', esc_url($settings['link_back']['url']) );

					if( $settings['link_back']['is_external'] ) {
						$widget_object->add_render_attribute('wdt-flip-box-title-container', 'target', '_blank');
					}

					if( $settings['link_back']['nofollow'] ) {
						$widget_object->add_render_attribute('wdt-flip-box-title-container', 'rel', 'nofollow');
					}

				} elseif( $settings['link_type_back'] == 'button' ) {

					$widget_object->add_render_attribute(
						'wdt-flip-box-button-container',
						array (
							'class'	=> 'wdt-flip-box-button',
							'href'	=> $settings['link_back']['url']
						)
					);

                    $class = '';
                    if($settings['button_icon_position_back'] == 'before') {
                        $class = 'wdt-button-icon-before';
                    } else if($settings['button_icon_position_back'] == 'after') {
                        $class = 'wdt-button-icon-after';
                    }

                    $widget_object->add_render_attribute( 'wdt-flip-box-button-container', 'class', $class );

					if($settings['link_back']['is_external']) {
						$widget_object->add_render_attribute('wdt-flip-box-button-container', 'target', '_blank' );
					}

					if($settings['link_back']['nofollow']) {
						$widget_object->add_render_attribute('wdt-flip-box-button-container', 'rel', 'nofollow' );
					}

				}
			}
		}

        $back_align_self = 'style="align-self:';
        if($settings['alignment_back'] == 'left') {
            $back_align_self .= 'flex-start';
        } else if($settings['alignment_back'] == 'right') {
            $back_align_self .= 'flex-end';
        } else if($settings['alignment_back'] == 'center') {
            $back_align_self .= 'center';
        }
        $back_align_self .= ';"';

		$output .= '<'.$box_tag.' '.$widget_object->get_render_attribute_string('wdt-flip-box-container').'>';

			$output .= '<div class="wdt-flip-box-layer wdt-flip-box-front">';
				$output .= '<div class="wdt-flip-box-inner">';

					if ( 'image' === $settings['graphic_element_front'] && ! empty( $settings['image_front']['url'] ) ) :
						$output .= '<div class="wdt-flip-box-image">';
							$image_front_setting = array ();
							$image_front_setting['image'] = $settings['image_front'];
							$image_front_setting['image_size'] = $settings['image_front_size'];
							$image_front_setting['image_custom_dimension'] = isset($settings['image_front_custom_dimension']) ? $settings['image_front_custom_dimension'] : array ();
							$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_front_setting );
						$output .= '</div>';
					elseif ( 'icon' === $settings['graphic_element_front'] && ! empty( $settings['icon_front']['value'] ) ) :
						$output .= '<div class="wdt-flip-box-icon">';
							$output .= $this->render_icon($settings['icon_front']);
						$output .= '</div>';
					endif;

					if ( ! empty( $settings['title_text_front'] ) ) :
						$output .= '<h3 class="wdt-flip-box-title">';
							$output .= $settings['title_text_front'];
						$output .= '</h3>';
					endif;

					if ( ! empty( $settings['description_text_front'] ) ) :
						$output .= '<div class="wdt-flip-box-description">';
							$output .= $settings['description_text_front'];
						$output .= '</div>';
					endif;

				$output .= '</div>';
				$output .= '<div class="wdt-flip-box-overlay">';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="wdt-flip-box-layer wdt-flip-box-back">';
				$output .= '<div class="wdt-flip-box-inner" '.$back_align_self.'>';

					if ( 'image' === $settings['graphic_element_back'] && ! empty( $settings['image_back']['url'] ) ) :
						$output .= '<div class="wdt-flip-box-image">';
							$image_back_setting = array ();
							$image_back_setting['image'] = $settings['image_back'];
							$image_back_setting['image_size'] = $settings['image_back_size'];
							$image_back_setting['image_custom_dimension'] = isset($settings['image_back_custom_dimension']) ? $settings['image_back_custom_dimension'] : array ();
							$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_back_setting );
						$output .= '</div>';
					elseif ( 'icon' === $settings['graphic_element_back'] && ! empty( $settings['icon_back']['value'] ) ) :
						$output .= '<div class="wdt-flip-box-icon">';
							$output .= $this->render_icon($settings['icon_back']);
						$output .= '</div>';
					endif;

					if ( ! empty( $settings['title_text_back'] ) ) :
						$output .= '<h3 class="wdt-flip-box-title">';
						    $output .= ($settings['link_type_back'] == 'title') ? '<a '.$widget_object->get_render_attribute_string('wdt-flip-box-title-container').'>' : '';
							    $output .= $settings['title_text_back'];
                            $output .= ($settings['link_type_back'] == 'title') ? '</a>' : '';
						$output .= '</h3>';
					endif;

					if ( ! empty( $settings['description_text_back'] ) ) :
						$output .= '<div class="wdt-flip-box-description">';
							$output .= $settings['description_text_back'];
						$output .= '</div>';
					endif;

					if( $settings['link_type_back'] == 'button' && ! empty($settings['button_text_back']) ) :
						$output .= '<a '.$widget_object->get_render_attribute_string('wdt-flip-box-button-container').'>';
							if( ! empty($settings['button_icon_back']['value']) && 'before' == $settings['button_icon_position_back'] ) :
								$output .= $this->render_icon($settings['button_icon_back']);
							endif;
							$output .= esc_attr($settings['button_text_back']);
							if( ! empty($settings['button_icon_back']['value']) && 'after' == $settings['button_icon_position_back'] ) :
								$output .= $this->render_icon($settings['button_icon_back']);
							endif;
						$output .= '</a>';
					endif;

				$output .= '</div>';
				$output .= '<div class="wdt-flip-box-overlay">';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</'.$box_tag.'>';



		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_flip_box' ) ) {
    function wedesigntech_widget_base_flip_box() {
        return WeDesignTech_Widget_Base_Flip_Box::instance();
    }
}