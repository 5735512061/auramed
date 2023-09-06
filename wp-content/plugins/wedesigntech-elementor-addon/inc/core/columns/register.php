<?php

if (! class_exists ( 'WeDesignTechElementorColumn' )) {

	class WeDesignTechElementorColumn {

		public $load_core_scripts = false;
		public $load_sticky_scripts = false;

		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'after_section_end' ), 10, 2 );
			add_action( 'elementor/frontend/column/before_render', array( $this, 'column_before_render' ) );
			add_action( 'elementor/frontend/element/before_render', array( $this, 'column_before_render' ) );
			add_action( 'elementor/frontend/before_enqueue_scripts',  array( $this, 'enqueue_scripts' ), 10 );

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

			$elementor_object->add_control(
				'wdt_sticky_column',
				array(
					'label'        => esc_html__( 'Sticky Column', 'wdt-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
					'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
					'return_value' => 'yes',
				)
			);

			$elementor_object->add_control(
				'wdt_sticky_top_spacing',
				array(
					'label'   => esc_html__( 'Top Spacing', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => 0,
					'max'     => 500,
					'step'    => 1,
					'condition' => array(
						'wdt_sticky_column' => 'yes',
					),
				)
			);

			$elementor_object->add_control(
				'wdt_sticky_bottom_spacing',
				array(
					'label'   => esc_html__( 'Bottom Spacing', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => 0,
					'max'     => 500,
					'step'    => 1,
					'condition' => array(
						'wdt_sticky_column' => 'yes',
					),
				)
			);

			$elementor_object->add_control(
				'wdt_sticky_on_devices',
				array(
					'label'       => esc_html__( 'Sticky On Devices', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => 'true',
					'default'     => array(
						'desktop',
						'tablet',
					),
					'condition' => array(
						'wdt_sticky_column' => 'yes',
					),
					'options' => $breakpoints_list,
				)
			);

            $elementor_object->add_control(
                'wdt_overflow_hidden',
                array(
                    'label'   => esc_html__( 'Apply Overflow Hidden', 'wdt-elementor-addon' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'default'      => '',
                    'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
                    'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
                    'return_value' => 'true',
                    'frontend_available' => true
                )
            );

			$elementor_object->end_controls_section();

		}

		public function column_before_render( $element ) {

			$data     = $element->get_data();
			$type     = (isset($data['elType']) && !empty($data['elType'])) ? $data['elType'] : 'column';

			if('column' !== $type) {
				return false;
			}

			$settings = $data['settings'];

			$sticky = isset($settings['wdt_sticky_column']) ? filter_var($settings['wdt_sticky_column'], FILTER_VALIDATE_BOOLEAN) : false;

			if($sticky) {

				$column_settings = array(
					'id'            => $data['id'],
					'sticky'        => $sticky,
					'topSpacing'    => isset($settings['wdt_sticky_top_spacing']) ? $settings['wdt_sticky_top_spacing'] : 50,
					'bottomSpacing' => isset($settings['wdt_sticky_bottom_spacing']) ? $settings['wdt_sticky_bottom_spacing'] : 50,
					'stickyOn'      => isset($settings['wdt_sticky_on_devices']) ? $settings['wdt_sticky_on_devices'] : array( 'desktop', 'tablet' ),
					'overflowHidden' => isset($settings['wdt_overflow_hidden']) ? filter_var($settings['wdt_overflow_hidden'], FILTER_VALIDATE_BOOLEAN) : false
				);

				$element->add_render_attribute( '_wrapper', array(
					'class'         => 'wdt-sticky-column',
					'data-wdt-settings' => wp_json_encode($column_settings),
				) );

				$this->load_core_scripts = true;
				$this->load_sticky_scripts = true;

			}

            $overflowHidden = isset($settings['wdt_overflow_hidden']) ? filter_var($settings['wdt_overflow_hidden'], FILTER_VALIDATE_BOOLEAN) : false;

            if($overflowHidden) {

				$element->add_render_attribute( '_wrapper', array(
					'class' => 'wdt-overflow-hidden'
				) );

                $this->load_core_scripts = true;

			}


		}

		public function enqueue_scripts() {

			if(\Elementor\Plugin::$instance->preview->is_preview_mode() || $this->load_core_scripts) {

				wp_enqueue_style( 'wdt-elementor-columns', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/css/style.css', false, WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all');

                if($this->load_sticky_scripts) {
                    wp_enqueue_script( 'wdt-resize-sensor', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/js/ResizeSensor.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
                    wp_enqueue_script( 'wdt-sticky-sidebar', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/js/sticky-sidebar.min.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
                    wp_enqueue_script( 'wdt-elementor-columns', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/js/script.js', array ('jquery', 'elementor-frontend', 'wdt-sticky-sidebar'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
                }

			}

		}


	}

}


if( !function_exists('wedesigntech_elementor_column') ) {
	function wedesigntech_elementor_column() {
		return WeDesignTechElementorColumn::instance();
	}
}

wedesigntech_elementor_column();
?>