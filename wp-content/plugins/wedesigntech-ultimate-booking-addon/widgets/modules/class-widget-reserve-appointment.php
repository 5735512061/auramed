<?php
use UltimateBookingPro\Widgets\UltimateBookingProWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Reserve_Appointment extends UltimateBookingProWidgetBase {

    public function get_name() {
        return 'dt-reserve-appointment';
    }

    public function get_title() {
        return esc_html__('Reserve Appointment', 'wedesigntech-ultimate-booking-addon');
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
                'default' => esc_html__('Make an Appointment', 'wedesigntech-ultimate-booking-addon')
            ) );

            $this->add_control( 'type', array(
                'label' => esc_html__( 'Type', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => array(
                    'type1' => esc_html__( 'Type - I', 'wedesigntech-ultimate-booking-addon' ),
                    'type2' => esc_html__( 'Type - II', 'wedesigntech-ultimate-booking-addon' ),
                    'type3' => esc_html__( 'Type - III', 'wedesigntech-ultimate-booking-addon' )
                )
            ));

            $this->add_control( 'el_class', array(
                'type' => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'wedesigntech-ultimate-booking-addon'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'wedesigntech-ultimate-booking-addon')
            ) );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        extract( $settings );

        $template = apply_filters( 'booking_appointment_template', "reservation/{$type}.php" );
        $template_args['title'] = $title;
        $template_args['class'] = $el_class;

        ob_start();
        ultimate_booking_pro_get_template( $template, $template_args );

        echo ob_get_clean();
    }

    protected function _content_template() {
    }
}