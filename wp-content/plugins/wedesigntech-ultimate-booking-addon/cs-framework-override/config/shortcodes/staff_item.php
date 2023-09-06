<?php
if (! class_exists ( 'DTBooking_Cs_Sc_StaffItem' ) ) {

    class DTBooking_Cs_Sc_StaffItem {

        function DTBooking_sc_StaffItem() {

			$plural_name = '';
			if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
				$plural_name	=	ultimate_booking_pro_cs_get_option( 'singular-staff-text', esc_html__('Staff', 'wedesigntech-ultimate-booking-addon') );
			endif;

			$options = array(
			  'name'      => 'dt_sc_staff_item',
			  'title'     => $plural_name,
			  'fields'    => array(

				array(
				  'id'    => 'staff_id',
				  'type'  => 'text',
				  'title' => esc_html__( 'Enter Staff ID', 'wedesigntech-ultimate-booking-addon' ),
				  'after' => '<div class="cs-text-muted">'.esc_html__('Enter ID of staff to display. More than one ids with comma(,) seperated.', 'wedesigntech-ultimate-booking-addon').'</div>',
				),
				array(
				  'id'        => 'type',
				  'type'      => 'select',
				  'title'     => esc_html__('Type', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'type1'    => esc_html__('Type - 1', 'wedesigntech-ultimate-booking-addon'),
					'type2'    => esc_html__('Type - 2', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'desc',
				  'info'      => esc_html__('Choose type of staffs to display.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'        => 'show_button',
				  'type'      => 'select',
				  'title'     => esc_html__('Show button?', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'yes'   => esc_html__('Yes', 'wedesigntech-ultimate-booking-addon'),
					'no'    => esc_html__('No', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'no',
				  'info'      => esc_html__('Choose "Yes" to show button.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'    => 'button_text',
				  'type'  => 'text',
				  'title' => esc_html__( 'Button Text', 'wedesigntech-ultimate-booking-addon' ),
				  'default' => esc_html__('Book an appointment', 'wedesigntech-ultimate-booking-addon'),
				  'info'  => esc_html__( 'Enter button text.', 'wedesigntech-ultimate-booking-addon' )
				)
			  ),
			);

			return $options;
		}
	}				
}