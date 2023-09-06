<?php
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'UltimateBookingProTwentySeventeen' ) ) {

	class UltimateBookingProTwentySeventeen {

		function __construct() {

			add_filter( 'body_class', array( $this, 'ultimate_booking_pro_ts_body_class' ), 20 );

			add_filter( 'ultimate_booking_pro_template_metabox_options', array( $this, 'ultimate_booking_pro_ts_template_metabox_options'), 10, 1);

			add_action( 'wp_enqueue_scripts', array( $this, 'ultimate_booking_pro_ts_enqueue_styles' ), 104 );

			add_action( 'ultimate_booking_pro_before_main_content', array( $this, 'ultimate_booking_pro_ts_before_main_content' ), 10 );
			add_action( 'ultimate_booking_pro_after_main_content', array( $this, 'ultimate_booking_pro_ts_after_main_content' ), 10 );

			add_action( 'ultimate_booking_pro_before_content', array( $this, 'ultimate_booking_pro_ts_before_content' ), 10 );
			add_action( 'ultimate_booking_pro_after_content', array( $this, 'ultimate_booking_pro_ts_after_content' ), 10 );
		}

		function ultimate_booking_pro_ts_body_class( $classes ) {

			if ( is_singular( 'dt_service' ) || is_post_type_archive('dt_service') || is_tax ( 'dt_service_category' ) || is_singular( 'dt_staff' ) || is_post_type_archive('dt_staff') || is_tax ( 'dt_staff_department' ) ) {

				$classes = array_diff( $classes, array( 'has-sidebar', 'page-one-column', 'page-two-column' ) );
				$page_layout = get_theme_mod( 'page_layout' );
				if ( 'one-column' === $page_layout ) {
					$classes[] = 'page page-one-column';
				}
			}

			return $classes;
		}		

		function ultimate_booking_pro_ts_template_metabox_options( $options ) {

			foreach($options as $option_key => $option) {

				if($option['id'] == '_custom_page_options') {
					unset( $options[0] );
				}

				if($option['id'] == '_custom_page_side_options') {
					unset( $options[1] );
				}

				if($option['id'] == '_custom_post_options') {
					unset( $options[2] );
				}
			}

			return $options;
		}

		function ultimate_booking_pro_ts_enqueue_styles() {

			wp_enqueue_style ( 'wdt-ultimate-booking-twentyseventeen', plugins_url ('wedesigntech-ultimate-booking-addon') . '/css/twenty-seventeen.css' );

		}

		function ultimate_booking_pro_ts_before_main_content() {	

			echo '<div class="wrap">';
			echo '	<div id="primary" class="content-area twentyseventeen">';
			echo '		<main id="main" class="site-main" role="main">';
		}

		function ultimate_booking_pro_ts_after_main_content() {

			echo '		</main>';
			echo '	</div>';
			echo '</div>';
		}

		function ultimate_booking_pro_ts_before_content() { ?>

			<header class="entry-header"><?php
				if ( is_singular( 'dt_service' ) || is_singular( 'dt_staff' ) ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
					twentyseventeen_edit_link( get_the_ID() );				
				} else if ( is_tax ( 'dt_service_category' ) || is_tax ( 'dt_staff_department' ) || is_post_type_archive('dt_service') || is_post_type_archive('dt_staff')  ) {
					the_archive_title( '<h1 class="page-title">', '</h1>' );
				} ?>
			</header><?php

			$additional_cls = '';
			if (is_singular( 'dt_service' )) {
				$additional_cls = 'dt_service-single';
			} elseif (is_singular( 'dt_staff' )) {
				$additional_cls = 'dt_staff-single';
			}

			global $post;
			echo '<article id="post-'.$post->ID.'" class="'.implode(' ', get_post_class($additional_cls)).'">';
		}

		function ultimate_booking_pro_ts_after_content() {
			echo '</article>';
		}

	}

	new UltimateBookingProTwentySeventeen();
}