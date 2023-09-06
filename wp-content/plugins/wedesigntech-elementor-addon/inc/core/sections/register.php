<?php

if (! class_exists ( 'WeDesignTechElementorSection' )) {

	class WeDesignTechElementorSection {

		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_action( 'elementor/element/section/section_layout/after_section_end', array( $this, 'after_section_end' ), 10, 2 );
            add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );
			add_action( 'elementor/frontend/before_enqueue_scripts',  array( $this, 'enqueue_scripts' ) );

		}

		public function after_section_end( $elementor_object, $args ) {

			if ( \Elementor\Plugin::$instance->breakpoints && method_exists( \Elementor\Plugin::$instance->breakpoints, 'get_active_breakpoints') ) {
				$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
				$breakpoints_list   = array();

				foreach ($active_breakpoints as $key => $value) {
					$breakpoints_list[$key] = $value->get_label();
				}

				$breakpoints_list['desktop'] = esc_html__( 'Desktop', 'wdt-elementor-addon' );
				$breakpoints_list            = array_reverse($breakpoints_list);
			} else {
				$breakpoints_list = array(
					'desktop' => esc_html__( 'Desktop', 'wdt-elementor-addon' ),
					'tablet'  => esc_html__( 'Tablet', 'wdt-elementor-addon' ),
					'mobile'  => esc_html__( 'Mobile', 'wdt-elementor-addon' )
				);
			}


			$elementor_object->start_controls_section(
				'wdt_section_options',
				array(
					'label' => esc_html__( 'WeDesignTech Options', 'wdt-elementor-addon' ),
					'tab'   => Elementor\Controls_Manager::TAB_LAYOUT,
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_bg_image',
				array (
					'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => array (),
					'condition' => array()
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_bg_position',
				array(
					'label'   => esc_html__( 'Position', 'wdt-elementor-addon' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'center center',
					'options' => array(
						'center center' => esc_html__( 'Center Center', 'wdt-elementor-addon' ),
						'center left' => esc_html__( 'Center Left', 'wdt-elementor-addon' ),
						'center right' => esc_html__( 'Center Right', 'wdt-elementor-addon' ),
						'top center' => esc_html__( 'Top Center', 'wdt-elementor-addon' ),
						'top left' => esc_html__( 'Top Left', 'wdt-elementor-addon' ),
						'top right' => esc_html__( 'Top Right', 'wdt-elementor-addon' ),
						'bottom center' => esc_html__( 'Bottom Center', 'wdt-elementor-addon' ),
						'bottom left' => esc_html__( 'Bottom Left', 'wdt-elementor-addon' ),
						'bottom right' => esc_html__( 'Bottom Right', 'wdt-elementor-addon' )
					),
					'separator' => 'before',
					'frontend_available' => true
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_bg_size',
				array(
					'label'   => esc_html__( 'Size', 'wdt-elementor-addon' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						'' => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'auto' => esc_html__( 'Auto', 'wdt-elementor-addon' ),
						'cover' => esc_html__( 'Cover', 'wdt-elementor-addon' ),
						'contain' => esc_html__( 'Contain', 'wdt-elementor-addon' ),
					),
					'frontend_available' => true
				)
			);

			$elementor_object->add_control(
				'wdt_animation_effect',
				array(
					'label'   => esc_html__( 'Effects', 'wdt-elementor-addon' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'none',
					'options' => array(
						'none'      => esc_html__( 'None', 'wdt-elementor-addon' ),
						'mouse-move' => esc_html__( 'Mouse Move', 'wdt-elementor-addon' ),
						'scroll'   => esc_html__( 'Scroll', 'wdt-elementor-addon' )
					),
					'separator' => 'before',
					'frontend_available' => true
				)
			);

			// Mouse Move - Effect

			$elementor_object->add_responsive_control(
				'wdt_mme_speed',
				array(
					'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'ms' ),
					'default' => array (
						'unit' => 'ms',
						'size' => 0.1,
					),
					'range' => array (
                        'ms' => array (
                            'min' => 0.1,
                            'max' => 1,
                            'step' => 0.1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'mouse-move',
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_mme_depth',
				array(
					'label' => esc_html__( 'Depth', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'dpt' ),
					'default' => array (
						'unit' => 'dpt',
						'size' => 1,
					),
					'range' => array (
                        'dpt' => array (
                            'min' => 0,
                            'max' => 5,
                            'step' => 0.1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'mouse-move',
					)
				)
			);

			$elementor_object->add_control(
				'wdt_mme_move_along',
				array(
					'label'   => esc_html__( 'Movement', 'wdt-elementor-addon' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'both',
					'options' => array(
						'x-axis' => esc_html__( 'X Axis', 'wdt-elementor-addon' ),
						'y-axis' => esc_html__( 'Y Axis', 'wdt-elementor-addon' ),
						'both'   => esc_html__( 'Both', 'wdt-elementor-addon' )
					),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'mouse-move',
					)
				)
			);

			$elementor_object->add_control(
				'wdt_mme_invert_movement',
				array(
					'label'        => esc_html__( 'Invert Movement', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'mouse-move',
					)
				)
			);

			// Scroll - Effect

			$elementor_object->add_control(
				'wdt_sle_parallax_x_direction',
				array(
					'label'        => esc_html__( 'Horizontal Direction', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll'
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_sle_parallax_x_depth',
				array(
					'label' => esc_html__( 'Horizontal Depth', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'dpt' ),
					'default' => array (
						'unit' => 'dpt',
						'size' => 50,
					),
					'range' => array (
                        'dpt' => array (
                            'min' => 0,
                            'max' => 250,
                            'step' => 1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll',
						'wdt_sle_parallax_x_direction' => 'true'
					)
				)
			);

			$elementor_object->add_control(
				'wdt_sle_parallax_y_direction',
				array(
					'label'        => esc_html__( 'Vertical Direction', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll'
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_sle_parallax_y_depth',
				array(
					'label' => esc_html__( 'Vertical Depth', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'dpt' ),
					'default' => array (
						'unit' => 'dpt',
						'size' => 50,
					),
					'range' => array (
                        'dpt' => array (
                            'min' => 0,
                            'max' => 250,
                            'step' => 1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll',
						'wdt_sle_parallax_y_direction' => 'true'
					)
				)
			);

			$elementor_object->add_control(
				'wdt_sle_scale',
				array(
					'label'        => esc_html__( 'Scale', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll'
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_sle_scale_value',
				array(
					'label' => esc_html__( 'Scale Value', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'value' ),
					'default' => array (
						'unit' => 'value',
						'size' => 1,
					),
					'range' => array (
                        'value' => array (
                            'min' => 0.5,
                            'max' => 1.5,
                            'step' => 0.1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll',
						'wdt_sle_scale' => 'true'
					)
				)
			);

			$elementor_object->add_control(
				'wdt_sle_blur',
				array(
					'label'        => esc_html__( 'Blur', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll'
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_sle_blur_value',
				array(
					'label' => esc_html__( 'Blur Value', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'value' ),
					'default' => array (
						'unit' => 'value',
						'size' => 0,
					),
					'range' => array (
                        'value' => array (
                            'min' => 0,
                            'max' => 2,
                            'step' => 0.1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll',
						'wdt_sle_blur' => 'true'
					)
				)
			);

			$elementor_object->add_control(
				'wdt_sle_opacity',
				array(
					'label'        => esc_html__( 'Opacity', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'true',
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll'
					)
				)
			);

			$elementor_object->add_responsive_control(
				'wdt_sle_opacity_value',
				array(
					'label' => esc_html__( 'Opacity Value', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => array ( 'value' ),
					'default' => array (
						'unit' => 'value',
						'size' => 1,
					),
					'range' => array (
                        'value' => array (
                            'min' => 0,
                            'max' => 1,
                            'step' => 0.1
                        )
                    ),
					'frontend_available' => true,
					'condition' => array(
						'wdt_animation_effect' => 'scroll',
						'wdt_sle_opacity' => 'true'
					)
				)
			);



            $elementor_object->add_control(
                'wdt_wrap_columns',
                array(
                    'label'   => esc_html__( 'Wrap Columns', 'wdt-elementor-addon' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'default'      => '',
                    'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
                    'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
                    'return_value' => 'true',
                    'separator' => 'before',
                    'frontend_available' => true
                )
            );

			$elementor_object->end_controls_section();

		}


		public function enqueue_scripts() {

			wp_enqueue_style( 'wdt-elementor-sections', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/sections/assets/css/style.css', false, WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all');

			wp_enqueue_script( 'wdt-elementor-sections', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/sections/assets/js/script.js', array ('jquery', 'elementor-frontend'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );

		}

		public function section_before_render( $element ) {

			$data     = $element->get_data();
			$type     = (isset($data['elType']) && !empty($data['elType'])) ? $data['elType'] : 'section';

			if('section' !== $type) {
				return false;
			}

			$settings = $data['settings'];

            $wrapColumns = isset($settings['wdt_wrap_columns']) ? filter_var($settings['wdt_wrap_columns'], FILTER_VALIDATE_BOOLEAN) : false;

            if($wrapColumns) {
				$element->add_render_attribute( '_wrapper', array(
					'class' => 'wdt-wrap-columns'
				) );
			}

		}

	}

}


if( !function_exists('wedesigntech_elementor_section') ) {
	function wedesigntech_elementor_section() {
		return WeDesignTechElementorSection::instance();
	}
}

wedesigntech_elementor_section();
?>