<?php
if (! class_exists ( 'DTBooking_Cs_Sc_ReservationForm' ) ) {

    class DTBooking_Cs_Sc_ReservationForm {

        function DTBooking_sc_ReservationForm() {

			$options = array(
			  'name'      => 'dt_sc_reservation_form',
			  'title'     => esc_html__('Reservaton Form', 'wedesigntech-ultimate-booking-addon'),
			  'fields'    => array(

				array(
				  'id'    => 'title',
				  'type'  => 'text',
				  'title' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' )
				),
				array(
				  'id'          => 'serviceids',
				  'type'        => 'select',
				  'title'       => esc_html__('Service IDs', 'wedesigntech-ultimate-booking-addon'),
				  'options'     => 'posts',
				  'query_args'  => array(
					'post_type'	=> 'dt_service'
				  ),
				  'attributes' => array(
					'multiple' 		   => 'only-key',
					'data-placeholder' => esc_html__('Select Some Services', 'wedesigntech-ultimate-booking-addon'),
					'style'            => 'width: 200px;'
				  ),
				  'class' 		=> 'chosen',
				  'desc'       => '<div class="cs-text-muted">'.esc_html__('Enter service name & pick.', 'wedesigntech-ultimate-booking-addon').'</div>',
				),
				array(
				  'id'          => 'staffids',
				  'type'        => 'select',
				  'title'       => esc_html__('Staff IDs', 'wedesigntech-ultimate-booking-addon'),
				  'options'     => 'posts',
				  'query_args'  => array(
					'post_type'	=> 'dt_staff'
				  ),
				  'attributes' => array(
					'multiple' 		   => 'only-key',
					'data-placeholder' => esc_html__('Select Some Staffs', 'wedesigntech-ultimate-booking-addon'),
					'style'            => 'width: 200px;'
				  ),
				  'class' 		=> 'chosen',
				  'desc'       => '<div class="cs-text-muted">'.esc_html__('Enter staff name & pick.', 'wedesigntech-ultimate-booking-addon').'</div>',
				),
			  ),
			);

			return $options;
		}
	}				
}