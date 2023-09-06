<?php
use UltimateBookingPro\Widgets\UltimateBookingProWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_View_Reservations extends UltimateBookingProWidgetBase {

    public function get_name() {
        return 'dt-view-reservations';
    }

    public function get_title() {
        return esc_html__('View Reservations', 'wedesigntech-ultimate-booking-addon');
    }

    public function get_icon() {
		return 'eicon-apps';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'wedesigntech-ultimate-booking-addon'),
        ) );

			$this->add_control( 'title', array(
				'label' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Appointment', 'wedesigntech-ultimate-booking-addon'),
			) );

			$this->add_control(	'el_class', array(
				'type' => Controls_Manager::TEXT,
				'label'       => esc_html__('Extra class name', 'wedesigntech-ultimate-booking-addon'),
				'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'wedesigntech-ultimate-booking-addon')
			) );

		$this->end_controls_section();
	}

    protected function render() {

		$settings = $this->get_settings();
		extract( $settings );

		$out = '';

		echo "{$out}";
	}

	protected function _content_template() {
    }
}