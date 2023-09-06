<?php
	$plural_name = '';
	if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
		$plural_name	=	ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
	endif;

	vc_map( array(
		"name" => $plural_name.esc_html__(' List', 'wedesigntech-ultimate-booking-addon'),
		"base" => "dt_sc_service_list",
		"icon" => "dt_sc_service_list",
		"category" => esc_html__( 'Booking Manager', 'wedesigntech-ultimate-booking-addon' ),
		"params" => array(

			# Terms
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Terms', 'wedesigntech-ultimate-booking-addon' ),
				'param_name' => 'terms',
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
				'description' => esc_html__( 'Enter service category & pick.', 'wedesigntech-ultimate-booking-addon' )
			),

			# Count
			array (
				"type" => "textfield",
				"heading" => esc_html__( "Products Per Page", 'wedesigntech-ultimate-booking-addon' ),
				"param_name" => "posts_per_page",
				"value" => 3,
				"save_always" => true
			),
			
			# Order By
			array (
				"type" => "dropdown",
				"heading" => esc_html__( "Order by", 'wedesigntech-ultimate-booking-addon' ),
				"param_name" => "orderby",
				'save_always' => true,
				"value" => array (
					esc_html__('ID','wedesigntech-ultimate-booking-addon') => 'ID',
					esc_html__('Title','wedesigntech-ultimate-booking-addon') => 'title',
					esc_html__('Name','wedesigntech-ultimate-booking-addon') => 'name',
					esc_html__('Type','wedesigntech-ultimate-booking-addon') => 'type',
					esc_html__('Date','wedesigntech-ultimate-booking-addon') => 'date',
					esc_html__('Random','wedesigntech-ultimate-booking-addon') => 'rand'
				)
			),

			# Order
			array (
				"type" => "dropdown",
				"heading" => esc_html__( "Sort order", 'wedesigntech-ultimate-booking-addon' ),
				"param_name" => "order",
				'save_always' => true,
				"value" => array (
					esc_html__( 'Descending', 'wedesigntech-ultimate-booking-addon' ) => 'desc',
					esc_html__( 'Ascending', 'wedesigntech-ultimate-booking-addon' ) => 'asc'
				)
			),

			# Class
			array (
				"type" => "textfield",
				"heading" => esc_html__( 'Extra class name', 'wedesigntech-ultimate-booking-addon' ),
				"param_name" => "el_class",
				"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wedesigntech-ultimate-booking-addon' )
			)
	     )
	) );