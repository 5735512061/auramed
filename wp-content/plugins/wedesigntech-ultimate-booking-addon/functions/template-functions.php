<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !function_exists( 'ultimate_booking_pro_template_path' ) ) {
	function ultimate_booking_pro_template_path() {
		return apply_filters( 'ultimate_booking_pro_template_path', 'wedesigntech-ultimate-booking-addon' );
	}
}

/**
 * get template part
 *
 * @param   string $slug
 * @param   string $name
 *
 * @return  string
 */
if ( !function_exists( 'ultimate_booking_pro_get_template_part' ) ) {

	function ultimate_booking_pro_get_template_part( $slug, $name = '' ) {
		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/wdt-ultimate-booking/slug-name.php
		if ( $name ) {
			$template = locate_template( array( "{$slug}-{$name}.php", ultimate_booking_pro_template_path() . "/{$slug}-{$name}.php" ) );
		}

		// Get default slug-name.php
		if ( !$template && $name && file_exists( ULTIMATEBOOKINGPRO_PATH . "/templates/{$slug}-{$name}.php" ) ) {
			$template = ULTIMATEBOOKINGPRO_PATH . "/templates/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wdt-ultimate-booking/slug.php
		if ( !$template ) {
			$template = locate_template( array( "{$slug}.php", ultimate_booking_pro_template_path() . "{$slug}.php" ) );
		}

		// Allow 3rd party plugin filter template file from their plugin
		if ( $template ) {
			$template = apply_filters( 'ultimate_booking_pro_get_template_part', $template, $slug, $name );
		}
		if ( $template && file_exists( $template ) ) {
			load_template( $template, false );
		}

		return $template;
	}
}

/**
 * Get other templates passing attributes and including the file.
 *
 * @param string $template_name
 * @param array  $args          (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return void
 */
if ( !function_exists( 'ultimate_booking_pro_get_template' ) ) {

	function ultimate_booking_pro_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		$located = ultimate_booking_pro_locate_template( $template_name, $template_path, $default_path );

		if ( !file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
			return;
		}
		// Allow 3rd party plugin filter template file from their plugin
		$located = apply_filters( 'ultimate_booking_pro_get_template', $located, $template_name, $args, $template_path, $default_path );

		do_action( 'ultimate_booking_pro_before_template_part', $template_name, $template_path, $located, $args );

		if ( $located && file_exists( $located ) ) {
			include( $located );
		}

		do_action( 'ultimate_booking_pro_after_template_part', $template_name, $template_path, $located, $args );
	}
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *        yourtheme        /    $template_path    /    $template_name
 *        yourtheme        /    $template_name
 *        $default_path    /    $template_name
 *
 * @access public
 *
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return string
 */
if ( !function_exists( 'ultimate_booking_pro_locate_template' ) ) {

	function ultimate_booking_pro_locate_template( $template_name, $template_path = '', $default_path = '' ) {

		if ( !$template_path ) {
			$template_path = ultimate_booking_pro_template_path();
		}

		if ( !$default_path ) {
			$default_path = ULTIMATEBOOKINGPRO_PATH . '/templates/';
		}

		$template = null;
		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name
			)
		);
		// Get default template
		if ( !$template ) {
			$template = $default_path . $template_name;
		}

		// Return what we found
		return apply_filters( 'ultimate_booking_pro_locate_template', $template, $template_name, $template_path );
	}
}

if ( !function_exists( 'ultimate_booking_pro_get_template_content' ) ) {

	function ultimate_booking_pro_get_template_content( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		ob_start();
		ultimate_booking_pro_get_template( $template_name, $args, $template_path, $default_path );
		return ob_get_clean();
	}
}

if( !function_exists( 'ultimate_booking_pro_get_page_id' ) ) {

	function ultimate_booking_pro_get_page_id( $name ) {

		$settings = cs_get_all_option();
		$page_id  = array_key_exists( $name, $settings ) ? $settings[$name] : 0;

		return apply_filters( 'ultimate_booking_pro_get_page_id', $page_id );
	}
}

add_filter( 'the_content', 'ultimate_booking_pro_setup_shortcode_page_content' );
if ( !function_exists( 'ultimate_booking_pro_setup_shortcode_page_content' ) ) {

	function ultimate_booking_pro_setup_shortcode_page_content( $content ) {
		global $post;

		$page_id = $post->ID;

		if ( !$page_id ) {
			return $content;
		}

		if ( ultimate_booking_pro_get_page_id( 'view-reservations-pageid' ) == $page_id ) {
			$content = '[' . apply_filters( 'ultimate_booking_pro_view_reservations_shortcode_tag', 'ubpro_view_reservations' ) . ']';
		}

		return do_shortcode( $content );
	}
}