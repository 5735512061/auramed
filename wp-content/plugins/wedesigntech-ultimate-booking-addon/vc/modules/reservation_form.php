<?php
	vc_map( array(
		"name" => esc_html__( "Reservation Form", 'wedesigntech-ultimate-booking-addon' ),
		"base" => "dt_sc_reservation_form",
		"icon" => "dt_sc_reservation_form",
		"category" => esc_html__( 'Booking Manager', 'wedesigntech-ultimate-booking-addon' ),
		"description" => esc_html__("Show the reservation form.",'wedesigntech-ultimate-booking-addon'),
		"params" => array(

			// Title
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter title here.', 'wedesigntech-ultimate-booking-addon' ),
				'std' => esc_html__('Appointment', 'wedesigntech-ultimate-booking-addon'),
				'admin_label' => true,
				'save_always' => true
			),

			// Services
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Service IDs', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'serviceids',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => true,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 500,
					'auto_focus' => true,
				),
				'param_holder_class' => 'vc_not-for-custom',
				'description' => esc_html__( 'Enter service name & pick.', 'wedesigntech-ultimate-booking-addon' )
			),
			
			// Staffs
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Staff IDs', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'staffids',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => true,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 500,
					'auto_focus' => true,
				),
				'param_holder_class' => 'vc_not-for-custom',
				'description' => esc_html__( 'Enter staff name & pick.', 'wedesigntech-ultimate-booking-addon' )
			)
		)
	) );