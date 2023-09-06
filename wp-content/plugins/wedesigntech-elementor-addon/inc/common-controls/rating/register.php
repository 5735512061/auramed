<?php

class WeDesignTech_Common_Controls_Rating {

    function __construct() {
    }

    public function init_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function get_controls($elementor_object, $condition) {

		$elementor_object->add_control( 'rating', array(
			'label'          => esc_html__( 'Rating', 'wdt-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '',
			'options'        => array(
				'' => esc_html__( 'None', 'wdt-elementor-addon' ),
				1 => esc_html__( '1', 'wdt-elementor-addon' ),
				2 => esc_html__( '2', 'wdt-elementor-addon' ),
				3 => esc_html__( '3', 'wdt-elementor-addon' ),
				4 => esc_html__( '4', 'wdt-elementor-addon' ),
				5 => esc_html__( '5', 'wdt-elementor-addon' )
			),
			'condition' => $condition
		) );

	}

    public function render_html($rating) {

        $output = '';

        if(isset($rating) && !empty($rating)) {
			$output .= '<div class="wdt-rating-container">';
				$output .= '<ul class="wdt-rating">';
				for($i = 1; $i <= 5; $i++) {
					if($i <= $rating) {
						$output .= '<li><span class="fas fa-star" data-value="'.esc_attr($i).'"></span></li>';
					}
					if($i > $rating) {
						$output .= '<li><span class="far fa-star" data-value="'.esc_attr($i).'"></span></li>';
					}
				}
				$output .= '</ul>';
			$output .= '</div>';
        }

        return $output;

    }

}