<?php

/**
 * WooCommerce - Single - Module - Ajax Add to Cart
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Single_Module_Ajax_Cart' ) ) {

    class Sirpi_Shop_Single_Module_Ajax_Cart {

        private static $_instance = null;

        private $product_enable_ajax_addtocart;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Ajax Cart
                $settings = sirpi_woo_single_core()->woo_default_settings();
                extract($settings);
                $this->product_enable_ajax_addtocart = $product_enable_ajax_addtocart;

            // Js Variables
                add_filter( 'sirpi_woo_objects', array ( $this, 'woo_objects' ), 10, 1 );

            // CSS
                add_filter( 'sirpi_woo_css', array( $this, 'woo_css'), 10, 1 );

            // JS
                add_filter( 'sirpi_woo_js', array( $this, 'woo_js'), 10, 1 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_DIR . '/woocommerce/single/modules/ajax-cart/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_URI . '/woocommerce/single/modules/ajax-cart/';
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

                    }

            }

        /*
        Js Variables
        */

            function woo_objects( $woo_objects ) {

                $woo_objects['enable_ajax_addtocart'] = esc_js($this->product_enable_ajax_addtocart);

                return $woo_objects;

            }

        /*
        CSS
        */
            function woo_css( $css ) {

                if($this->product_enable_ajax_addtocart) {

                    $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                    if( file_exists ( $css_file_path ) ) {

                        ob_start();
                        include( $css_file_path );
                        $css .= "\n\n".ob_get_clean();

                    }

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                if($this->product_enable_ajax_addtocart) {

                    $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                    if( file_exists ( $js_file_path ) ) {

                        ob_start();
                        include( $js_file_path );
                        $js .= "\n\n".ob_get_clean();

                    }

                }

                return $js;

            }

    }

}

if( !function_exists('sirpi_shop_single_module_ajax_cart') ) {
	function sirpi_shop_single_module_ajax_cart() {
		return Sirpi_Shop_Single_Module_Ajax_Cart::instance();
	}
}

sirpi_shop_single_module_ajax_cart();