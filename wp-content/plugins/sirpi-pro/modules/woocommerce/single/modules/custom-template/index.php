<?php

/**
 * WooCommerce - Single - Module - Custom Template
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Single_Module_Custom_template' ) ) {

    class Sirpi_Shop_Single_Module_Custom_template {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_DIR . '/woocommerce/single/modules/custom-template/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_URI . '/woocommerce/single/modules/custom-template/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }


        /*
        Load Modules
        */

            function load_modules() {

                // Elementor Widgets
                    include_once $this->module_dir_path() . 'elementor/index.php';

                // Customizer
                    include_once $this->module_dir_path() . 'customizer/index.php';

                // Metabox
                    include_once $this->module_dir_path() . 'metabox/index.php';

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }

    }

}

if( !function_exists('sirpi_shop_single_module_custom_template') ) {
	function sirpi_shop_single_module_custom_template() {
		return Sirpi_Shop_Single_Module_Custom_template::instance();
	}
}

sirpi_shop_single_module_custom_template();