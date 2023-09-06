<?php
if (! class_exists ( 'DTBooking_Cs_Sc_ReserveAppointment' ) ) {

    class DTBooking_Cs_Sc_ReserveAppointment {

        function DTBooking_sc_ReserveAppointment() {

			$options = array(
			  'name'      => 'dt_sc_reserve_appointment',
			  'title'     => esc_html__('Reserve Appointment', 'wedesigntech-ultimate-booking-addon'),
			  'fields'    => array(

				array(
				  'id'    => 'title',
				  'type'  => 'text',
				  'title' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' )
				),
				array(
				  'id'           => 'type',
				  'type'         => 'select',
				  'title'        => esc_html__('Type', 'wedesigntech-ultimate-booking-addon'),
				  'options'      => array(
					'type1'      => esc_html__('Type - I', 'wedesigntech-ultimate-booking-addon'),
					'type2'      => esc_html__('Type - II', 'wedesigntech-ultimate-booking-addon'),
				  ),
				  'class'        => 'chosen',
				  'default'      => 'type1',
				  'info'         => esc_html__('Choose type of reservation to display.', 'wedesigntech-ultimate-booking-addon')
				),
			  ),
			);

			return $options;
		}
	}				
}