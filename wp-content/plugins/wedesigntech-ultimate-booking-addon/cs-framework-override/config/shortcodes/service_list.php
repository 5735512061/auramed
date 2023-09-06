<?php
if (! class_exists ( 'DTBooking_Cs_Sc_ServiceList' ) ) {

    class DTBooking_Cs_Sc_ServiceList {

        function DTBooking_sc_ServiceList() {

			$plural_name = '';
			if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
				$plural_name	=	ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
			endif;

			$options = array(
			  'name'      => 'dt_sc_service_list',
			  'title'     => $plural_name.esc_html__(' List', 'wedesigntech-ultimate-booking-addon'),
			  'fields'    => array(

				array(
				  'id'          => 'terms',
				  'type'        => 'select',
				  'title'       => esc_html__('Terms', 'wedesigntech-ultimate-booking-addon'),
				  'options'     => 'categories',
				  'query_args'  => array(
					'type'      => 'dt_service',
					'taxonomy'  => 'dt_service_category'
				  ),
				  'attributes' => array(
					'multiple' 		   => 'only-key',
					'data-placeholder' => esc_html__('Select service category', 'wedesigntech-ultimate-booking-addon'),
					'style'            => 'width: 200px;'
				  ),
				  'class' 	   => 'chosen',
				  'desc'       => '<div class="cs-text-muted">'.esc_html__('Choose service as you want.', 'wedesigntech-ultimate-booking-addon').'</div>',
				),
				array(
				  'id'    => 'posts_per_page',
				  'type'  => 'text',
				  'title' => esc_html__( 'Products Per Page', 'wedesigntech-ultimate-booking-addon' ),
				  'default' => 3
				),
				array(
				  'id'        => 'orderby',
				  'type'      => 'select',
				  'title'     => esc_html__('Order by', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'ID'       => esc_html__('ID', 'wedesigntech-ultimate-booking-addon'),
					'title'    => esc_html__('Title', 'wedesigntech-ultimate-booking-addon'),
					'name'     => esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
					'type' 	   => esc_html__('Type', 'wedesigntech-ultimate-booking-addon'),
					'date'     => esc_html__('Date', 'wedesigntech-ultimate-booking-addon'),
					'rand'     => esc_html__('Random', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'ID',
				  'info'      => esc_html__('Choose orderby of services to display.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'        => 'order',
				  'type'      => 'select',
				  'title'     => esc_html__('Sort order', 'wedesigntech-ultimate-booking-addon'),
				  'options'   => array(
					'desc'    => esc_html__('Descending', 'wedesigntech-ultimate-booking-addon'),
					'asc'     => esc_html__('Ascending', 'wedesigntech-ultimate-booking-addon')
				  ),
				  'class'     => 'chosen',
				  'default'   => 'desc',
				  'info'      => esc_html__('Choose order of services to display.', 'wedesigntech-ultimate-booking-addon')
				),
				array(
				  'id'    => 'el_class',
				  'type'  => 'text',
				  'title' => esc_html__( 'Extra class name', 'wedesigntech-ultimate-booking-addon' ),
				  'after' => '<div class="cs-text-muted">'.esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wedesigntech-ultimate-booking-addon').'</div>',
				),
			  ),
			);

			return $options;
		}
	}				
}