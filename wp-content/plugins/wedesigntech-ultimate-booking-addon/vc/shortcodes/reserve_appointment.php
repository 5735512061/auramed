<?php
if (! class_exists ( 'DTBookingReserveAppointment' ) ) {

    class DTBookingReserveAppointment extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'dt_sc_reserve_appointment', array( $this, 'dt_sc_reserve_appointment' ) );
        }

		function dt_sc_reserve_appointment($attrs, $content = null ){
			extract( shortcode_atts( array(
				'title' => esc_html__('Make an Appointment', 'wedesigntech-ultimate-booking-addon'),
				'type'  => 'type1'
			), $attrs ) );

			$template = apply_filters( 'booking_appointment_template', "reservation/{$type}.php" );
			$template_args['title'] = $title;

			ob_start();
			ultimate_booking_pro_get_template( $template, $template_args );

			return ob_get_clean();
		}
    }
}

new DTBookingReserveAppointment();