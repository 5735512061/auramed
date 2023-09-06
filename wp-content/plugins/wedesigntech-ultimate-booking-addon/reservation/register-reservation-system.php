<?php
if ( !class_exists( 'UltimateBookingProReservationSystem' ) ) {

	class UltimateBookingProReservationSystem {

		function __construct() {

			// Register Calendar Menu
			require_once plugin_dir_path ( __FILE__ ) . '/dt-calendar-menu.php';
			if( class_exists('DTCalendarMenu')) {
				new DTCalendarMenu();
			}

			// Register Customers Custom Post
			require_once plugin_dir_path ( __FILE__ ) . '/dt-customer-post-type.php';
			if( class_exists('DTCustomerPostType') ){
				new DTCustomerPostType();
			}

			// Register Payments Menu
			require_once plugin_dir_path ( __FILE__ ) . '/dt-payment-post-type.php';
			if( class_exists('DTPaymentPostType') ){
				new DTPaymentPostType();
			}
		}
	}
}