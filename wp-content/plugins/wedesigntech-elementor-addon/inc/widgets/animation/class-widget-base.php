<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Animation {

	private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-animation';
	}

	public function title() {
		return esc_html__( 'Animation', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array (
				$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/animation/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

    public function init_scripts() {
		return array (
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/animation/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		) );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control( 'content_type', array(
				'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'image',
				'options' => array(
					'image' => esc_html__( 'Image', 'wdt-elementor-addon' ),
					'text' => esc_html__( 'Text', 'wdt-elementor-addon' )
				)
			) );

            $repeater->add_control( 'image', array (
                'label' => esc_html__( 'Image', 'wdt-elementor-addon' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array (
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'condition'   => array (
                    'content_type' =>'image'
                )
            ) );

            $repeater->add_control( 'text', array(
                'label'       => esc_html__( 'Text', 'wdt-elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'Title goes here', 'wdt-elementor-addon' ),
                'condition'   => array (
                    'content_type' =>'text'
                )
            ) );

            $repeater->add_control( 'link',array(
				'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
				'default'     => array( 'url' => '#' ),
			) );

            $elementor_object->add_control( 'contents', array(
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'label'       => esc_html__('Contents', 'wdt-elementor-addon'),
                'description' => esc_html__('Contents', 'wdt-elementor-addon' ),
                'fields'      => $repeater->get_controls(),
                'default' => array (
                    array (
                        'content_type' => 'text',
                        'text' => 'A'
                    ),
                    array (
                        'content_type' => 'text',
                        'text' => 'B'
                    ),
                    array (
                        'content_type' => 'text',
                        'text' => 'C'
                    )
                )
            ) );

		$elementor_object->end_controls_section();

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

            $elementor_object->add_control( 'wdt_mqa_direction', array(
                'label'   => esc_html__( 'Direction', 'wdt-elementor-addon' ),
                'type'    => Elementor\Controls_Manager::SELECT,
                'default' => 'left-to-right',
                'options' => array(
                    'left-to-right' => esc_html__( 'Left to Right', 'wdt-elementor-addon' ),
                    'right-to-left' => esc_html__( 'Right to Left', 'wdt-elementor-addon' )
                ),
                'frontend_available' => true
            ) );

            $elementor_object->add_control( 'wdt_mqa_bound_to', array(
                'label'   => esc_html__( 'Bound To', 'wdt-elementor-addon' ),
                'type'    => Elementor\Controls_Manager::SELECT,
                'default' => 'section',
                'options' => array(
                    'section' => esc_html__( 'Section', 'wdt-elementor-addon' ),
                    'column' => esc_html__( 'Column', 'wdt-elementor-addon' )
                ),
                'frontend_available' => true
            ) );

            $elementor_object->add_control( 'wdt_mqa_speed', array(
                'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array ( 'dpt' ),
                'default' => array (
                    'unit' => 'dpt',
                    'size' => 2,
                ),
                'range' => array (
                    'dpt' => array (
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.5
                    )
                ),
                'frontend_available' => true
            ) );

            $elementor_object->add_control( 'wdt_mqa_padding', array(
                'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array ( 'dpt' ),
                'default' => array (
                    'unit' => 'dpt',
                    'size' => 2,
                ),
                'range' => array (
                    'dpt' => array (
                        'min' => 0,
                        'max' => 50,
                        'step' => 1
                    )
                ),
                'frontend_available' => true
            ) );

		$elementor_object->end_controls_section();

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['contents'] ) > 0 ):

			$classes = array ();

            $animation_settings = array (
                'direction' => $settings['wdt_mqa_direction'],
                'bound_to' => $settings['wdt_mqa_bound_to'],
                'speed' => $settings['wdt_mqa_speed'],
                'padding' => $settings['wdt_mqa_padding'],
            );

			$output .= '<div class="wdt-animation-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-animation-'.esc_attr($widget_object->get_id()).'" data-settings="'.esc_js(wp_json_encode($animation_settings)).'">';
                $output .= '<div class="wdt-animation-wrapper">';

                    foreach( $settings['contents'] as $key => $item ) {
                        if( $item['content_type'] == 'image' ) {
                            if(isset($item['image']['url']) && !empty($item['image']['url']) && !empty( $item['link']['url'] )) {
                                $target = ( $item['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
								$nofollow = ( $item['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
                                $output .= '<div class="wdt-animation-item image-item">';

                                    $image_setting = array ();
                                    $image_setting['image'] = $item['image'];
                                    $image_setting['image_size'] = 'full';
                                    $image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();

                                    $output .= '<a href="'.esc_url( $item['link']['url'] ).'"'. $target . $nofollow.'>';
                                        $output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );
                                    $output .= '</a>';

                                $output .= '</div>';

                            }elseif(isset($item['image']['url']) && !empty($item['image']['url'])) {
                                $output .= '<div class="wdt-animation-item image-item">';

                                    $image_setting = array ();
                                    $image_setting['image'] = $item['image'];
                                    $image_setting['image_size'] = 'full';
                                    $image_setting['image_custom_dimension'] = isset($item['image_custom_dimension']) ? $item['image_custom_dimension'] : array ();

                                    $output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image_setting );

                                $output .= '</div>';
                            }
                        } else if( $item['content_type'] == 'text' ) {
                            if( !empty( $item['link']['url'] ) && $item['text'] != '' ){
                                $target = ( $item['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
								$nofollow = ( $item['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
                                $output .= '<div class="wdt-animation-item text-item">';
                                    $output .= '<div class="wdt-animation-text">';
								        $output .= '<a href="'.esc_url( $item['link']['url'] ).'"'. $target . $nofollow.'>';
                                            $output .= $item['text'];
								        $output .= '</a>';
                                    $output .= '</div>';
                                $output .= '</div>';
							} elseif($item['text'] != '') {
                                $output .= '<div class="wdt-animation-item text-item">';
                                    $output .= $item['text'];
                                $output .= '</div>';
                            }
                        }
                    }

                $output .= '</div>';
			$output .= '</div>';

		else:
			$output .= '<div class="wdt-animation-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_animation' ) ) {
    function wedesigntech_widget_base_animation() {
        return WeDesignTech_Widget_Base_Animation::instance();
    }
}