<?php
namespace UltimateBookingPro\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class UltimateBookingProWidgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 * 
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );

		add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_styles') );

		add_filter( 'elementor/editor/localize_settings', array( $this, 'localize_settings' )  );
	}

	/**
	 * Register bookingmanager widgets
	 */
	public function register_widgets( $widgets_manager ) {

		require ultimate_booking_pro()->plugin_path( 'widgets/class-common-widget-base.php' );

		#Reservation Form
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-reservation-form.php');
		$widgets_manager->register_widget_type( new \Elementor_Reservation_Form() );

		#Reserve Appointment
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-reserve-appointment.php');
		$widgets_manager->register_widget_type( new \Elementor_Reserve_Appointment() );

		#Service Item
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-service-item.php');
		$widgets_manager->register_widget_type( new \Elementor_Service_Item() );

		#Service List
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-service-list.php');
		$widgets_manager->register_widget_type( new \Elementor_Service_List() );

		#Staff Item
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-staff-item.php');
		$widgets_manager->register_widget_type( new \Elementor_Staff_Item() );

		#View Reservations
		require ultimate_booking_pro()->plugin_path( 'widgets/modules/class-widget-view-reservations.php');
		$widgets_manager->register_widget_type( new \Elementor_View_Reservations() );
	}

	/**
	 * Register bookingmanager widgets styles
	 */
	public function register_widget_styles() {}

	/**
	 * Register bookingmanager widgets scripts
	 */
	public function register_widget_scripts() {}

	/**
	 *  Editor Preview Style
	 */
	public function preview_styles() {}

	/**
	 * Enqueue localized texts
	 */
	public function localize_settings( $settings ) { return $settings; }

	/**
	 * Register admin scripts
	 */
	public function register_admin_scripts() {}
}

UltimateBookingProWidgets::instance();