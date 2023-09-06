<?php
if (! class_exists ( 'UltimateBookingProVcModules' )) {

	class UltimateBookingProVcModules {

		function __construct() {

			add_action( 'admin_enqueue_scripts', array ( $this, 'ultimate_booking_pro_vc_admin_scripts') );
			add_action( 'wp_enqueue_scripts', array ( $this, 'ultimate_booking_pro_wp_enqueue_scripts' ) );

			add_action( 'admin_init', array ( $this, 'ultimate_booking_pro_load_modules' ) , 1000 );
			add_action( 'init', array( $this, 'ultimate_booking_pro_load_shortcodes' ) );
		}

		function ultimate_booking_pro_vc_admin_scripts( $hook ) {

			if( $hook == "post.php" || $hook == "post-new.php" ) {
				wp_enqueue_style( 'wdt-ultimate-booking-vc-admin', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/style.css', array(), false, 'all' );
			}
		}

		function ultimate_booking_pro_wp_enqueue_scripts() {

			$themeData = wp_get_theme();
			$version = $themeData->get('Version');

			wp_enqueue_style( 'fontawesome-all', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/css/fontawesome-all.min.css' );
			wp_enqueue_style( 'dt-dropdown', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/css/dropdown.css', false, $version, 'all' );
			wp_enqueue_style( 'wedesigntech-ultimate-booking-addon', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/css/booking.css', false, $version, 'all' );

			wp_enqueue_script( 'dt-dropdown', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/js/dropdown.js', array('jquery'), false, true );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-ui-datepicker', 'https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css' );

			wp_enqueue_script( 'dt-reservation', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/js/reservation.js', array(), false, true );
			wp_enqueue_script( 'dt-cal-reservation', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/js/cal-reservation.js', array(), false, true );
            wp_localize_script( 'dt-cal-reservation', 'ultimateBookingProCal', array(
				'staffServiceEmpty' => esc_html__('Please select staff and service!', 'wedesigntech-ultimate-booking-addon')
			));
			wp_enqueue_script( 'jquery-validate', plugins_url ('wedesigntech-ultimate-booking-addon') . '/vc/js/jquery.validate.min.js', array(), false, true );
			wp_localize_script( 'dt-reservation', 'ultimateBookingPro', array(
				'ajaxurl'         => admin_url('admin-ajax.php'),
				'name'         => esc_html__('Name:', 'wedesigntech-ultimate-booking-addon'),
				'phone'         => esc_html__('Phone:', 'wedesigntech-ultimate-booking-addon'),
				'email'         => esc_html__('Email', 'wedesigntech-ultimate-booking-addon'),
				'address'         => esc_html__('Address', 'wedesigntech-ultimate-booking-addon'),
				'message'         => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
				'plugin_url'      => plugin_dir_url ( __FILE__ ),
				'eraptdatepicker' => esc_html__('Please Select Service and Date!', 'wedesigntech-ultimate-booking-addon'),
				'stripe_pub_api'  => cs_get_option('stripe-publishable-api-key')
			));

			$stripe = cs_get_option('enable-stripe');
			if( !empty($stripe) ):
				wp_enqueue_script ( 'stripe-js', 'https://js.stripe.com/v3/' );
			endif;
		}

		function ultimate_booking_pro_load_modules() {

			if( ! function_exists( 'vc_map' ) ) {
				return;
			}

			require_once 'modules/reservation_form.php';
			require_once 'modules/reserve_appointment.php';
			require_once 'modules/staff_item.php';
			require_once 'modules/service_item.php';
			require_once 'modules/service_list.php';
		}

		function ultimate_booking_pro_load_shortcodes() {

			require_once 'shortcodes/base.php';

			require_once 'shortcodes/reservation_form.php';
			require_once 'shortcodes/reserve_appointment.php';
			require_once 'shortcodes/staff_item.php';
			require_once 'shortcodes/service_item.php';
			require_once 'shortcodes/service_list.php';
			require_once 'shortcodes/view_reservations.php';
		}
	}
}