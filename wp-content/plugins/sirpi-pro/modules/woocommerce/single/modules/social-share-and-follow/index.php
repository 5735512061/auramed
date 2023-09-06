<?php

/**
 * WooCommerce - Single - Module - Social Share And Follow
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Single_Module_Social_Share_And_Follow' ) ) {

    class Sirpi_Shop_Single_Module_Social_Share_And_Follow {

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
                    return SIRPI_MODULE_DIR . '/woocommerce/single/modules/social-share-and-follow/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_URI . '/woocommerce/single/modules/social-share-and-follow/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }


        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'sirpi_pro' ) ) {

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Elementor
                            include_once $this->module_dir_path() . 'elementor/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }

    }

}

if( !function_exists('sirpi_shop_single_module_social_share_and_follow') ) {
	function sirpi_shop_single_module_social_share_and_follow() {
        return Sirpi_Shop_Single_Module_Social_Share_And_Follow::instance();
	}
}

if( class_exists( 'Sirpi_Shop_Single_Module_Custom_template' ) ) {
    sirpi_shop_single_module_social_share_and_follow();
}