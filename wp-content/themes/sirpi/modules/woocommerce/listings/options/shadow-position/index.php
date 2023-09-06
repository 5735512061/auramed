<?php
/**
 * Listing Options - Shadow Position
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Woo_Listing_Option_Shadow_Position' ) ) {

    class Sirpi_Woo_Listing_Option_Shadow_Position extends Sirpi_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-shadow-position';
            $this->option_name          = esc_html__('Shadow Position', 'sirpi');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = 'product-shadow-position-default';
            $this->option_value_prefix  = 'product-shadow-position-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'sirpi_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 55, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_common_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'common';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'product-shadow-position-default'      => esc_html__('Default', 'sirpi'),
                'product-shadow-position-top-left'     => esc_html__('Top Left', 'sirpi'),
                'product-shadow-position-top-right'    => esc_html__('Top Right', 'sirpi'),
                'product-shadow-position-bottom-left'  => esc_html__('Bottom Left', 'sirpi'),
                'product-shadow-position-bottom-right' => esc_html__('Bottom Right', 'sirpi')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('sirpi_woo_listing_option_shadow_position') ) {
	function sirpi_woo_listing_option_shadow_position() {
		return Sirpi_Woo_Listing_Option_Shadow_Position::instance();
	}
}

sirpi_woo_listing_option_shadow_position();