<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Woo_Listing_Option_Hover_Secondary_Image_Effect' ) ) {

    class Sirpi_Woo_Listing_Option_Hover_Secondary_Image_Effect extends Sirpi_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-hover-secondary-image-effect';
            $this->option_name          = esc_html__('Hover Secondary Image Effect', 'sirpi');
            $this->option_default_value = 'product-hover-secimage-fade';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-hover-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'sirpi_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
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
                'product-hover-secimage-fade'         => esc_html__('Fade', 'sirpi'),
                'product-hover-secimage-zoomin'       => esc_html__('Zoom In', 'sirpi'),
                'product-hover-secimage-zoomout'      => esc_html__('Zoom Out', 'sirpi'),
                'product-hover-secimage-zoomoutup'    => esc_html__('Zoom Out Up', 'sirpi'),
                'product-hover-secimage-zoomoutdown'  => esc_html__('Zoom Out Down', 'sirpi'),
                'product-hover-secimage-zoomoutleft'  => esc_html__('Zoom Out Left', 'sirpi'),
                'product-hover-secimage-zoomoutright' => esc_html__('Zoom Out Right', 'sirpi'),
                'product-hover-secimage-pushup'       => esc_html__('Push Up', 'sirpi'),
                'product-hover-secimage-pushdown'     => esc_html__('Push Down', 'sirpi'),
                'product-hover-secimage-pushleft'     => esc_html__('Push Left', 'sirpi'),
                'product-hover-secimage-pushright'    => esc_html__('Push Right', 'sirpi'),
                'product-hover-secimage-slideup'      => esc_html__('Slide Up', 'sirpi'),
                'product-hover-secimage-slidedown'    => esc_html__('Slide Down', 'sirpi'),
                'product-hover-secimage-slideleft'    => esc_html__('Slide Left', 'sirpi'),
                'product-hover-secimage-slideright'   => esc_html__('Slide Right', 'sirpi'),
                'product-hover-secimage-hingeup'      => esc_html__('Hinge Up', 'sirpi'),
                'product-hover-secimage-hingedown'    => esc_html__('Hinge Down', 'sirpi'),
                'product-hover-secimage-hingeleft'    => esc_html__('Hinge Left', 'sirpi'),
                'product-hover-secimage-hingeright'   => esc_html__('Hinge Right', 'sirpi'),
                'product-hover-secimage-foldup'       => esc_html__('Fold Up', 'sirpi'),
                'product-hover-secimage-folddown'     => esc_html__('Fold Down', 'sirpi'),
                'product-hover-secimage-foldleft'     => esc_html__('Fold Left', 'sirpi'),
                'product-hover-secimage-foldright'    => esc_html__('Fold Right', 'sirpi'),
                'product-hover-secimage-fliphoriz'    => esc_html__('Flip Horizontal', 'sirpi'),
                'product-hover-secimage-flipvert'     => esc_html__('Flip Vertical', 'sirpi')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('sirpi_woo_listing_option_hover_secondary_image_effect') ) {
	function sirpi_woo_listing_option_hover_secondary_image_effect() {
		return Sirpi_Woo_Listing_Option_Hover_Secondary_Image_Effect::instance();
	}
}

sirpi_woo_listing_option_hover_secondary_image_effect();