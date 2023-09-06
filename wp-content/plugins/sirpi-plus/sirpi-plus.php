<?php
/**
 * Plugin Name:	Sirpi Plus
 * Description: Adds additional features for Sirpi Theme.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: sirpi-plus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlus' ) ) {
    class SirpiPlus {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'sirpi_plus_before_plugin_load' );

                add_action( 'plugins_loaded', array( $this, 'i18n' ) );
                add_filter( 'sirpi_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
                $this->define_constants();
                $this->load_helper();
                $this->load_elementor();
                $this->load_customizer();
                $this->load_modules();
                $this->load_post_types();
    			add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );


            /**
             * After Hook
             */
            do_action( 'sirpi_plus_after_plugin_load' );
        }

        function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'Unyson',
                    'slug'				=> 'unyson',
                    'required'			=> false,
                    'force_activation'	=> false,
                ),
                array(
                    'name'				=> 'Elementor',
                    'slug'				=> 'elementor',
                    'required'			=> false,
                    'force_activation'	=> false,
                ),
                array(
                    'name'				=> 'Contact Form 7',
                    'slug'				=> 'contact-form-7',
                    'required'			=> false,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

        function i18n() {
            load_plugin_textdomain( 'sirpi-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function define_constants() {

            define( 'SIRPI_PLUS_VERSION', '1.0.2' );
            define( 'SIRPI_PLUS_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'SIRPI_PLUS_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
            define( 'SIRPI_CUSTOMISER_VAL', 'sirpi-customiser-option');

            define( 'SIRPI_PLUS_REQ_CAPTION', esc_html__( 'Go Pro!', 'sirpi-plus' ) );
            define( 'SIRPI_PLUS_REQ_DESC', '<p>' . esc_html__( 'Avtivate Sirpi Pro plugin to avail additional features!', 'sirpi-plus' ) . '</p>' );

        }

        function load_helper() {
            require_once SIRPI_PLUS_DIR_PATH . 'functions.php';
        }

        function load_customizer() {
            require_once SIRPI_PLUS_DIR_PATH . 'customizer/customizer.php';
        }

        function load_elementor() {
            require_once SIRPI_PLUS_DIR_PATH . 'elementor/index.php';
        }

        function load_modules() {

            /**
             * Before Hook
             */
            do_action( 'sirpi_plus_before_load_modules' );

                foreach( glob( SIRPI_PLUS_DIR_PATH. 'modules/*/index.php'  ) as $module ) {
                    include_once $module;
                }

            /**
             * After Hook
             */
            do_action( 'sirpi_plus_after_load_modules' );
        }

        function load_post_types() {
            require_once SIRPI_PLUS_DIR_PATH . 'post-types/post-types.php';
        }

        function add_body_classes( $classes ) {
            $classes[] = 'sirpi-plus-'.SIRPI_PLUS_VERSION;
            return $classes;
        }


        function enqueue_assets() {
            wp_enqueue_style( 'sirpi-plus-common', SIRPI_PLUS_DIR_URL . 'assets/css/common.css', false, SIRPI_PLUS_VERSION, 'all');
        }

    }
}

if( !function_exists( 'sirpi_plus' ) ) {
    function sirpi_plus() {
        return SirpiPlus::instance();
    }
}

if (class_exists ( 'SirpiPlus' )) {
    sirpi_plus();
}

register_activation_hook( __FILE__, 'sirpi_plus_activation_hook' );
function sirpi_plus_activation_hook() {
    $settings = get_option( SIRPI_CUSTOMISER_VAL );
    if(empty($settings)) {
        update_option( constant( 'SIRPI_CUSTOMISER_VAL' ), apply_filters( 'sirpi_plus_customizer_default', array() ) );
    }
}