<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusSiteTransitionOne' ) ) {
    class SirpiPlusSiteTransitionOne {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'sirpi_loader_layouts', array( $this, 'add_option' ) );

            $site_loader = sirpi_customizer_settings( 'site_loader' );

            if( $site_loader == 'transition-1' ) {
                add_filter( 'body_class', array( $this, 'apply_custom_class' ), 10, 1 );
                add_action( 'sirpi_after_main_css', array( $this, 'enqueue_css' ) );
                add_action( 'sirpi_after_enqueue_js', array( $this, 'enqueue_js' ) );
            }
        }

        function apply_custom_class( $classes ) {
           array_push($classes, 'wdt-fade');
            return $classes;
        }

        function add_option( $options ) {
            $options['transition-1'] = esc_html__('Transition 1', 'sirpi-plus');
            return $options;
        }

        function enqueue_css() {
            wp_enqueue_style( 'site-transition', SIRPI_PLUS_DIR_URL . 'modules/site-loader/layouts/transition-1/assets/css/transition-1.css', false, SIRPI_PLUS_VERSION, 'all' );
        }

        function enqueue_js() {
            wp_enqueue_script( 'site-transition', SIRPI_PLUS_DIR_URL . 'modules/site-loader/layouts/transition-1/assets/js/transition-1.js', array('jquery'), SIRPI_PLUS_VERSION, true );
        }

    }
}

SirpiPlusSiteTransitionOne::instance();