<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusSiteLoaderThree' ) ) {
    class SirpiPlusSiteLoaderThree {

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

            if( $site_loader == 'loader-3' ) {

                add_action( 'sirpi_after_main_css', array( $this, 'enqueue_assets' ) );

                /**
                 * filter: sirpi_primary_color_style - to use primary color
                 * filter: sirpi_secondary_color_style - to use secondary color
                 * filter: sirpi_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'sirpi_primary_color_style', array( $this, 'primary_color_css' ) );
                add_filter( 'sirpi_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }

        }

        function add_option( $options ) {
            $options['loader-3'] = esc_html__('Loader 3', 'sirpi-plus');
            return $options;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-loader', SIRPI_PLUS_DIR_URL . 'modules/site-loader/layouts/loader-3/assets/css/loader-3.css', false, SIRPI_PLUS_VERSION, 'all' );
        }

        function primary_color_css( $style ) {
            $style .= ".loader3 { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }

        function tertiary_color_style( $style ) {
            $style .= ".loader3:before { background-color:var( --wdtTertiaryColor );}";
            return $style;
        }
    }
}

SirpiPlusSiteLoaderThree::instance();