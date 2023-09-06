<?php
if (! class_exists ( 'DTBooking_Cs_Sc_ServiceItem' ) ) {

    class DTBooking_Cs_Sc_ServiceItem {

        function DTBooking_sc_ServiceItem() {

			$plural_name = '';
			if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
				$plural_name	=	ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
			endif;

			$options = array(
			  'name'      => 'dt_sc_service_item',
			  'title'     => $plural_name,
			  'fields'    => array(

				array(
				  'id'    => 'service_id',
				  'type'  => 'text',
				  'title' => esc_html__( 'Enter Service ID', 'wedesigntech-ultimate-booking-addon' ),
				  'after' => '<div class="cs-text-muted">'.esc_html__('Enter IDs of services to display. More than one ids with comma(,) seperated.', 'wedesigntech-ultimate-booking-addon').'</div>',
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
				  'info'      => esc_html__('Choose type of services to display.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'        => 'excerpt',
				  'type'      => 'select',
				  'title'     => esc_html__('Show Excerpt?', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'yes'   => esc_html__('Yes', 'wedesigntech-ultimate-booking-addon'),
					'no'    => esc_html__('No', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'no',
				  'info'      => esc_html__('Choose "Yes" to show excerpt.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'    => 'excerpt_length',
				  'type'  => 'text',
				  'title' => esc_html__( 'Excerpt Length', 'wedesigntech-ultimate-booking-addon' ),
				  'default' => 12
				),
				array(
				  'id'        => 'meta',
				  'type'      => 'select',
				  'title'     => esc_html__('Show Meta?', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'yes'   => esc_html__('Yes', 'wedesigntech-ultimate-booking-addon'),
					'no'    => esc_html__('No', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'no',
				  'info'      => esc_html__('Choose "Yes" to show meta.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'    => 'button_text',
				  'type'  => 'text',
				  'title' => esc_html__( 'Button Text', 'wedesigntech-ultimate-booking-addon' ),
				  'default' => esc_html__('View procedure details', 'wedesigntech-ultimate-booking-addon'),
				  'info'  => esc_html__( 'Enter button text.', 'wedesigntech-ultimate-booking-addon' )
				)
			  ),
			);

			return $options;
		}
	}				
}