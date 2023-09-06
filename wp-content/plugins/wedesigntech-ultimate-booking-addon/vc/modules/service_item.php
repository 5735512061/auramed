<?php
	$plural_name = '';
	if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
		$plural_name	=	ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
	endif;

	vc_map( array(
		"name" => $plural_name,
		"base" => "dt_sc_service_item",
		"icon" => "dt_sc_service_item",
		"category" => esc_html__( 'Booking Manager', 'wedesigntech-ultimate-booking-addon' ),
		"params" => array(

			# ID
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Enter Service ID", "wdt-ultimate-booking" ),
				"param_name" => "service_id",
				"value" => '',
				"description" => esc_html__( 'Enter IDs of services to display. More than one ids with comma(,) seperated. Leave empty to display all items.', 'wedesigntech-ultimate-booking-addon' ),
			),

			# Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','wedesigntech-ultimate-booking-addon'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type - 1','wedesigntech-ultimate-booking-addon') => 'type1',
					esc_html__('Type - 2','wedesigntech-ultimate-booking-addon') => 'type2'
				)
			),

			# Excerpt?
			array(
				'type' => 'dropdown',
				'param_name' => 'excerpt',
				'value' => array(
					esc_html__('Yes','wedesigntech-ultimate-booking-addon') => 'yes',
					esc_html__('No','wedesigntech-ultimate-booking-addon') => 'no'
				),
				'heading' => esc_html__( 'Show Excerpt?', 'wedesigntech-ultimate-booking-addon' ),
				'std' => 'no'
			),

			# Excerpt Length
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Excerpt Length', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'excerpt_length',
				'value' => 12
			),

			# Meta?
			array(
				'type' => 'dropdown',
				'param_name' => 'meta',
				'value' => array(
					esc_html__('Yes','wedesigntech-ultimate-booking-addon') => 'yes',
					esc_html__('No','wedesigntech-ultimate-booking-addon') => 'no'
				),
				'heading' => esc_html__( 'Show Meta?', 'wedesigntech-ultimate-booking-addon' ),
				'std' => 'no'
			),

			# Button Text
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Button Text", "wdt-ultimate-booking" ),
				"param_name" => "button_text",
				"value" => esc_html__('View procedure details', 'wedesigntech-ultimate-booking-addon'),
				"description" => esc_html__( 'Enter button text.', 'wedesigntech-ultimate-booking-addon' ),
			)
	     )
	) );