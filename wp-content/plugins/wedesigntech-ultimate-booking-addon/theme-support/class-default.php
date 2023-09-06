<?php
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'UltimateBookingProDefault' ) ) {

	class UltimateBookingProDefault {

		function __construct() {

			add_filter( 'body_class', array( $this, 'ultimate_booking_pro_default_body_class' ), 20 );

			add_filter( 'ultimate_booking_pro_template_metabox_options', array( $this, 'ultimate_booking_pro_default_template_metabox_options'), 10, 1);

			add_action( 'wp_enqueue_scripts', array( $this, 'ultimate_booking_pro_default_enqueue_styles' ), 104 );

			add_action( 'ultimate_booking_pro_before_main_content', array( $this, 'ultimate_booking_pro_default_before_main_content' ), 10 );
			add_action( 'ultimate_booking_pro_after_main_content', array( $this, 'ultimate_booking_pro_default_after_main_content' ), 10 );

			add_action( 'ultimate_booking_pro_before_content', array( $this, 'ultimate_booking_pro_default_before_content' ), 10 );
			add_action( 'ultimate_booking_pro_after_content', array( $this, 'ultimate_booking_pro_default_after_content' ), 10 );
		}

		function ultimate_booking_pro_default_body_class( $classes ) {

			return $classes;

		}

		function ultimate_booking_pro_default_template_metabox_options($options) {

			return $options;

		}

		function ultimate_booking_pro_default_enqueue_styles() {

			wp_enqueue_style ( 'wdt-ultimate-booking-default', plugins_url ('wedesigntech-ultimate-booking-addon') . '/css/default.css' );

		} 

		function ultimate_booking_pro_default_before_main_content() {	

			echo '';

		}

		function ultimate_booking_pro_default_after_main_content() {

			echo '';

		}

		function ultimate_booking_pro_default_before_content() {

			$additional_cls = '';
			if (is_singular( 'dt_service' )) {
				$additional_cls = 'dt_service-single';
			} elseif (is_singular( 'dt_staff' )) {
				$additional_cls = 'dt_staff-single';
			}

			global $post;
			echo '<article id="post-'.$post->ID.'" class="'.implode(' ', get_post_class($additional_cls)).'">';

		}

		function ultimate_booking_pro_default_after_content() {
			echo '</article>';
		}

	}

	new UltimateBookingProDefault();
}