<?php

/**
 * WooCommerce - Recently Viewed Products Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Others_Recently_Viewed_Products' ) ) {

    class Sirpi_Shop_Others_Recently_Viewed_Products {

        private static $_instance = null;

        private $enable_recently_viewed_products;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Recently Viewed Products
                $settings = sirpi_woo_others()->woo_default_settings();
                extract($settings);
                $this->enable_recently_viewed_products = $enable_recently_viewed_products;


            // Js Variables
                add_filter( 'sirpi_woo_objects', array ( $this, 'woo_objects' ), 10, 1 );

            // Enqueue CSS
                add_action( 'sirpi_before_woo_css', array ( $this, 'before_woo_css' ), 10 );

            // Enqueue JS
                add_action( 'sirpi_before_woo_js', array ( $this, 'before_woo_js' ), 10 );

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_DIR . '/woocommerce/others/recently-viewed-products/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( sirpi_is_file_in_theme( __FILE__ ) ) {
                    return SIRPI_MODULE_URI . '/woocommerce/others/recently-viewed-products/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                // Includes
                    include_once $this->module_dir_path(). 'includes/index.php';

                if( function_exists( 'sirpi_pro' ) ) {

                    // Customizer
                        include_once $this->module_dir_path(). 'customizer/index.php';

                }

            }

        /*
        Js Variables
        */

            function woo_objects( $woo_objects ) {

                $woo_objects['enable_recently_viewed_products'] = esc_js($this->enable_recently_viewed_products);

                return $woo_objects;

            }

        /*
        Enqueue CSS
        */
            function before_woo_css() {

                if($this->enable_recently_viewed_products) {

                    wp_enqueue_style('swiper', $this->module_dir_url() . 'assets/css/swiper.min.css');
                    wp_enqueue_style('rvp-style', $this->module_dir_url() . 'assets/css/style.css');

                }

            }

        /*
        Enqueue JS
        */
            function before_woo_js() {

                if($this->enable_recently_viewed_products) {

                    wp_enqueue_script('jquery-swiper', $this->module_dir_url() . 'assets/js/swiper.min.js', array('jquery'), false, true);
                    wp_enqueue_script('rvp-scripts', $this->module_dir_url() . 'assets/js/scripts.js', array('jquery'), false, true);
                    $woo_objects = array (
                        'enable_recently_viewed_products' => esc_js( $this->enable_recently_viewed_products )
                    );
                    wp_localize_script('rvp-scripts', 'dtrvpObjects', $woo_objects);

                }

            }

    }

}

if( !function_exists('sirpi_shop_others_recently_viewed_products') ) {
	function sirpi_shop_others_recently_viewed_products() {
        $reflection = new ReflectionClass('Sirpi_Shop_Others_Recently_Viewed_Products');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Sirpi_Shop_Others_Recently_Viewed_Products::instance();