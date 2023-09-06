<?php
	vc_map( array(
		"name" => esc_html__( "Reserve Appointment", 'wedesigntech-ultimate-booking-addon' ),
		"base" => "dt_sc_reserve_appointment",
		"icon" => "dt_sc_reserve_appointment",
		"category" => esc_html__( 'Booking Manager', 'wedesigntech-ultimate-booking-addon' ),
		"description" => esc_html__("Show reserve appointment template.",'wedesigntech-ultimate-booking-addon'),
		"params" => array(

			// Title
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter title here.', 'wedesigntech-ultimate-booking-addon' ),
				'std' => esc_html__('Make an Appointment', 'wedesigntech-ultimate-booking-addon'),
				'admin_label' => true,
				'save_always' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','wedesigntech-ultimate-booking-addon'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type - I','wedesigntech-ultimate-booking-addon') => 'type1' ,
					esc_html__('Type - II','wedesigntech-ultimate-booking-addon') => 'type2',
					esc_html__('Type - III','wedesigntech-ultimate-booking-addon') => 'type3'
				),
				'std' => 'type1',
				'save_always' => true
			)
		)
	) );