<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Single_Metabox_Options' ) ) {
    class Sirpi_Shop_Single_Metabox_Options {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'sirpi_shop_product_custom_settings', array( $this, 'sirpi_shop_product_custom_settings' ), 20 );
        }

        function sirpi_shop_product_custom_settings( $options ) {

			$product_options = array(

				# Product New Label
					array(
						'id'         => 'product-new-label',
						'type'       => 'switcher',
						'title'      => esc_html__('Add "New" label', 'sirpi-shop'),
					),

					array(
						'id'         => 'product-notes',
						'type'       => 'textarea',
						'title'      => esc_html__('Product Notes', 'sirpi-shop')
					)

			);

			$options = array_merge( $options, $product_options );

			return $options;

        }

    }
}

Sirpi_Shop_Single_Metabox_Options::instance();