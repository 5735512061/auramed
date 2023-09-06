<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Creative_Button {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function name() {
		return 'wdt-creative-button';
	}

	public function title() {
		return esc_html__( 'Creative Button', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/creative-button/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/creative-button/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_button_general', array(
			'label' => esc_html__( 'General', 'wdt-elementor-addon' ),
		) );

			$elementor_object->start_controls_tabs( 'tabs_button' );
				$elementor_object->start_controls_tab( 'tab_primary_button', array(
					'label' => esc_html__( 'Primary', 'wdt-elementor-addon')
				) );
					$elementor_object->add_control( 'primary_text', array(
						'label'       => esc_html__('Button Text', 'wdt-elementor-addon'),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => esc_html__('Click Here!', 'wdt-elementor-addon'),
						'placeholder' => esc_html__('Click Here!', 'wdt-elementor-addon'),
					) );

					$elementor_object->add_control( 'use_icon', array(
						'label'        => esc_html__('Use Icon', 'wdt-elementor-addon'),
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'prefix_class' => 'wdt-use-icon-',
						'default'      => 'yes'
					) );

					$elementor_object->add_control( 'icon_type', array(
						'label'     => esc_html__('Icon Type', 'wdt-elementor-addon'),
						'type'      => \Elementor\Controls_Manager::SELECT,
						'default'   => 'fontawesome',
						'condition' => array( 'use_icon' => 'yes' ),
						'options'   => array(
							'image'       => esc_html__('Image', 'wdt-elementor-addon'),
							'fontawesome' => esc_html__('FontAwesome', 'wdt-elementor-addon'),
							'icon_class'  => esc_html__('Custom Class', 'wdt-elementor-addon'),
						)
					) );

					$elementor_object->add_control( 'icon', array(
						'label'     => esc_html__( 'Icon', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::MEDIA,
						'default'   => array(),
						'condition' => array( 'use_icon' => 'yes', 'icon_type' => 'image' )
					) );

					$elementor_object->add_control( 'icon_font', array(
						'label'            => esc_html__( 'Icon', 'wdt-elementor-addon' ),
						'type'             => \Elementor\Controls_Manager::ICONS,
						'default'          => [ 'value' => 'fas fa-star', 'library' => 'fa-solid', ],
						'condition'        => array( 'use_icon' => 'yes', 'icon_type' => 'fontawesome' )
					) );

					$elementor_object->add_control( 'icon_class', array(
						'label'     => esc_html__('Icon Class', 'wdt-elementor-addon'),
						'type'      => \Elementor\Controls_Manager::TEXT,
						'condition' => array( 'use_icon' => 'yes', 'icon_type' => 'icon_class' )
					) );

					$elementor_object->add_control( 'icon_align', array(
						'label'        => esc_html__( 'Icon Position', 'wdt-elementor-addon' ),
						'type'         => \Elementor\Controls_Manager::SELECT,
						'default'      => 'left',
						'prefix_class' => 'wdt-icon-align-',
						'condition'    => array( 'use_icon' => 'yes' ),
						'options'      => array(
							'left'  => esc_html__( 'Before', 'wdt-elementor-addon' ),
							'right' => esc_html__( 'After', 'wdt-elementor-addon' ),
						)
					) );

					$elementor_object->add_control( 'icon_indent_left', array(
						'label'     => esc_html__( 'Icon Spacing', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::SLIDER,
						'range'     => array( 'px' => array( 'max' => 60 ) ),
						'condition' => array( 'use_icon' => 'yes', 'icon_align' => 'left' ),
						'selectors' => array( '{{WRAPPER}} ' => 'margin-left: {{SIZE}}px;' )
					) );

					$elementor_object->add_control( 'icon_indent_right', array(
						'label'     => esc_html__( 'Icon Spacing', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::SLIDER,
						'range'     => array( 'px' => array( 'max' => 60 ) ),
						'condition' => array( 'use_icon' => 'yes', 'icon_align' => 'right' ),
						'selectors' => array( '{{WRAPPER}} ' => 'margin-right: {{SIZE}}px;' )
					) );
				$elementor_object->end_controls_tab();

				$elementor_object->start_controls_tab( 'tab_secondary_button', array(
					'label' => esc_html__( 'Secondary', 'wdt-elementor-addon')
				) );
					$elementor_object->add_control( 'secondary_text', array(
						'label'       => esc_html__('Secondary Button Text', 'wdt-elementor-addon'),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => esc_html__('Go!', 'wdt-elementor-addon'),
						'placeholder' => esc_html__('Go!', 'wdt-elementor-addon'),
					) );
				$elementor_object->end_controls_tab();
			$elementor_object->end_controls_tabs();

			$elementor_object->add_control( 'link', array(
				'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'separator'   => 'before',
				'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
				'default'     => array( 'url' => '#' ),
			) );

			$elementor_object->add_control( 'size', array(
				'label'   => esc_html__('Size', 'wdt-elementor-addon'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'small',
				'options' => array(
					'xsmall' => esc_html__( 'Extra Small', 'wdt-elementor-addon' ),
					'small'  => esc_html__( 'Small', 'wdt-elementor-addon' ),
					'medium' => esc_html__( 'Medium', 'wdt-elementor-addon' ),
					'large'  => esc_html__( 'Large', 'wdt-elementor-addon' ),
					'xlarge' => esc_html__( 'Extra Large', 'wdt-elementor-addon' )
				),
			) );

			$elementor_object->add_control( 'effect', array(
				'label'     => esc_html__('Set Button Effect', 'wdt-elementor-addon'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'wdt-creative-button-effect-default',
				'options'   => array(
					'wdt-creative-button-effect-default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-winona'  => esc_html__( 'Winona', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-ujarak'  => esc_html__( 'Ujarak', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-wayra'   => esc_html__( 'Wayra', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-tamaya'  => esc_html__( 'Tamaya', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-rayen'   => esc_html__( 'Rayen', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-pipaluk' => esc_html__( 'Pipaluk', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-moema'   => esc_html__( 'Moema', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-wave'    => esc_html__( 'Wave', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-aylen'   => esc_html__( 'Aylen', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-saqui'   => esc_html__( 'Saqui', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-wapasha' => esc_html__( 'Wapasha', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-nuka'    => esc_html__( 'Nuka', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-antiman' => esc_html__( 'Antiman', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-quidel'  => esc_html__( 'Quidel', 'wdt-elementor-addon' ),
					'wdt-creative-button-effect-shikoba' => esc_html__( 'Shikoba', 'wdt-elementor-addon' ),
				),
			) );

		$elementor_object->end_controls_section();


		// Style Section

		$elementor_object->start_controls_section( 'wdt_button_style', array(
			'label' => esc_html__( 'Style', 'wdt-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		) );
			$elementor_object->start_controls_tabs( 'tabs_button_styles' );
				$elementor_object->start_controls_tab( 'tab_button_normal', array(
					'label' => esc_html__( 'Normal', 'wdt-elementor-addon')
				) );
					$elementor_object->add_responsive_control( 'text_size', array(
						'label'      => esc_html__( 'Text Size', 'wdt-elementor-addon'),
						'type'       => \Elementor\Controls_Manager::SLIDER,
						'size_units' => array( 'px' ),
						'range'      => array( 'px' => array( 'min' => 1, 'max' => 100 ) ),
						#'selectors'  => array( '{{WRAPPER}} i' =>'font-size: {{SIZE}}{{UNIT}}' )
					) );
					$elementor_object->add_control( 'color', array(
						'label'     => esc_html__( 'Color', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => array(),
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
						'name'      => 'background',
						#'selector' => '{{WRAPPER}} ',
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
						'name'        => 'border',
						'label'       => esc_html__( 'Border', 'wdt-elementor-addon' ),
						'placeholder' => '1px',
						#'selector'   => '{{WRAPPER}}',
					) );
					$elementor_object->add_responsive_control( 'border_radius', array(
						'label'      => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
						'type'       => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%' ),
						'selectors'  => array(
							#'{{WRAPPER}} ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
						'name'     => 'box_shadow',
						'selector' => '{{WRAPPER}}',
					) );
				$elementor_object->end_controls_tab();

				$elementor_object->start_controls_tab( 'tab_icon_hover', array(
					'label' => esc_html__( 'Hover', 'wdt-elementor-addon')
				) );
					$elementor_object->add_control( 'color_hover', array(
						'label'     => esc_html__( 'Color', 'wdt-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => array(),
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
						'name'      => 'background_hover',
						#'selector' => '{{WRAPPER}} ',
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
						'name'        => 'border_hover',
						'label'       => esc_html__( 'Border', 'wdt-elementor-addon' ),
						'placeholder' => '1px',
						#'selector'   => '{{WRAPPER}}',
					) );
					$elementor_object->add_responsive_control( 'border_radius_hover', array(
						'label'      => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
						'type'       => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%' ),
						'selectors'  => array(
							#'{{WRAPPER}} ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					) );
					$elementor_object->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
						'name'     => 'box_shadow_hover',
						'selector' => '{{WRAPPER}}',
					) );
				$elementor_object->end_controls_tab();
			$elementor_object->end_controls_tabs();

			$elementor_object->add_responsive_control( 'align', array(
				'label'        => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'separator'    => 'before',
				'default'      => '',
				'prefix_class' => 'wdt-%s-align-',
				'options'      => array(
					'left'    => array( 'title' => esc_html__( 'Left', 'wdt-elementor-addon' ), 'icon' => 'fa fa-align-left' ),
					'center'  => array( 'title' => esc_html__( 'Center', 'wdt-elementor-addon' ), 'icon' => 'fa fa-align-center' ),
					'right'   => array( 'title' => esc_html__( 'Right', 'wdt-elementor-addon' ), 'icon' => 'fa fa-align-right' ),
					'justify' => array( 'title' => esc_html__( 'Justified', 'wdt-elementor-addon' ), 'icon' => 'fa fa-align-justify' ),
				),
			) );

			$elementor_object->add_responsive_control( 'width', array(
				'label'      => esc_html__( 'Width', 'wdt-elementor-addon'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 500, 'step' => 1 ),
					'%'  => array( 'min' => 0, 'max' => 100 )
				),
				'selectors'  => array( '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};')
			) );

			$elementor_object->add_responsive_control( 'margin', array(
				'label'      => esc_html__( 'Margin', 'wdt-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					#'{{WRAPPER}} '  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			) );

			$elementor_object->add_responsive_control( 'padding', array(
				'label'      => esc_html__( 'Padding', 'wdt-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					#'{{WRAPPER}} '  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			) );

		$elementor_object->end_controls_section();



	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if ( ! empty( $settings['link']['url'] ) ) {

			$widget_object->add_render_attribute( 'wrapper', array(
				'id'    => 'wdt-creative-button-'.esc_attr( $widget_object->get_id() ),
				'class' => 'wdt-creative-button-wrapper'
			) );
			$widget_object->add_render_attribute( 'wrapper', 'class', $settings['size'] );
			$widget_object->add_render_attribute( 'wrapper', 'class', $settings['effect'] );

			$output .= '<div '.$widget_object->get_render_attribute_string( 'wrapper' ).'>';

				$widget_object->add_render_attribute( 'button', 'class', 'wdt-button' );
				$widget_object->add_render_attribute( 'button', 'href', $settings['link']['url'] );

				if ( $settings['link']['is_external'] ) {
					$widget_object->add_render_attribute( 'button', 'target', '_blank' );
				}

				if ( $settings['link']['nofollow'] ) {
					$widget_object->add_render_attribute( 'button', 'rel', 'nofollow' );
				}

				if( !empty( $settings['secondary_text'] ) ) {
					$widget_object->add_render_attribute( 'button', 'data-text', $settings['secondary_text'] );
				}

				$output .= '<a '.$widget_object->get_render_attribute_string( 'button' ).'>';
					if( $settings['use_icon'] == 'yes' && $settings['icon_align'] == 'left' ) {
						$output .= $this->icon_wrapper( $settings );
					}

					$output .= '<div class="wdt-label-wrapper">';
						$output .=  $settings['primary_text'];
					$output .= '</div>';

					if( $settings['use_icon'] == 'yes' && $settings['icon_align'] == 'right' ) {
						$output .= $this->icon_wrapper( $settings );
					}
				$output .= '</a>';
			$output .= '</div>';
		}

		return $output;

	}

	public function icon_wrapper( $settings ) {

		$output = '';

		$output .=  '<div class="wdt-icon-wrapper">';
			if( ( $settings['icon_type'] == 'image' ) && !empty( $settings['icon']['url'] ) ) {
				$output .=  '<img src="'.esc_url( $settings['icon']['url'] ).'" alt=""/>';
			}

			if( ( $settings['icon_type'] == 'fontawesome' ) && !empty( $settings['icon_font']['value'] ) ) {
				$output .=  '<i class="'.esc_attr( $settings['icon_font']['value'] ).'"></i>';
			}

			if( ( $settings['icon_type'] == 'icon_class' ) && !empty( $settings['icon_class'] ) ) {
				$output .=  '<i class="'.esc_attr( $settings['icon_class'] ).'"></i>';
			}
		$output .=  '</div>';

		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_creative_button' ) ) {
    function wedesigntech_widget_base_creative_button() {
        return WeDesignTech_Widget_Base_Creative_Button::instance();
    }
}