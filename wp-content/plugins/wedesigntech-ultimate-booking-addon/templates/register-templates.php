<?php
if (! class_exists ( 'UltimateBookingProTemplates' )) {

	class UltimateBookingProTemplates {

		function __construct() {

			add_action( 'init', array(
				$this,
				'ultimate_booking_pro_add_image_sizes'
			) );

			add_filter ( 'template_include', array (
				$this,
				'ultimate_booking_pro_template_include'
			) );
		}

		function ultimate_booking_pro_add_image_sizes() {

			$pwidth = ultimate_booking_pro_cs_get_option('staff-img-width', 205);
			$phight = ultimate_booking_pro_cs_get_option('staff-img-height', 205);

			$swidth = ultimate_booking_pro_cs_get_option('service-img-width', 205);
			$shight = ultimate_booking_pro_cs_get_option('service-img-height', 205);

			$apwidth = ultimate_booking_pro_cs_get_option('archive-staff-img-width', 650);
			$aphight = ultimate_booking_pro_cs_get_option('archive-staff-img-height', 650);

			add_image_size( 'dt-bm-staff-type2', $pwidth, $phight, array( 'center', 'top' ) );
			add_image_size( 'dt-bm-service-type2', $swidth, $shight, array( 'center', 'top' ) );
			add_image_size( 'dt-bm-archive-staff', $apwidth, $aphight, array( 'center', 'top' ) );
			add_image_size( 'dt-bm-dropdown-staff', 60, 60, array( 'center', 'top' ) );
		}

		function ultimate_booking_pro_template_include( $template ) {

			$post_type = get_post_type();

			$file = '';
			$find = array();

			if ( is_post_type_archive( 'dt_service' ) ) {
				$file = 'archive-service.php';
				$find[] = $file;
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
			} else if ( is_post_type_archive( 'dt_staff' ) ) {
				$file = 'archive-staff.php';
				$find[] = $file;
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
			} else if ( is_singular('dt_service') ) {
				$file = 'single-service.php';
				$find[] = $file;
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
			} else if ( is_singular('dt_staff') ) {
				$file = 'single-staff.php';
				$find[] = $file;
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
			} else if ( taxonomy_exists('dt_service_category') || taxonomy_exists('dt_staff_department') ) {
				if ( is_tax( 'dt_service_category' ) ) {
					$file = 'taxonomy-category.php';
				} else if ( is_tax( 'dt_staff_department' ) ) {
					$file = 'taxonomy-department.php';
				}
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
			}

			if ( $file ) {
				$find[] = ULTIMATEBOOKINGPRO_PATH . '/' . $file;
				$dt_template = untrailingslashit( ULTIMATEBOOKINGPRO_PATH ) . '/templates/' . $file;
				$template = locate_template( array_unique( $find ) );
				
				if ( !$template && file_exists( $dt_template ) ) {
					$template = $dt_template;
				}
			}

			return $template;
		}
	}
}