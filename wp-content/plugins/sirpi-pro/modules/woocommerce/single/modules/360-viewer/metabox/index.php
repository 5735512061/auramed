<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Metabox_Single_360_Viewer' ) ) {
    class Sirpi_Shop_Metabox_Single_360_Viewer {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'product_options' ) );
        }

        function product_options( $options ) {

			$options[] = array(
				'id'        => '_360viewer_gallery',
				'title'     => esc_html__('Product 360 View Gallery','sirpi-pro'),
				'post_type' => 'product',
				'context'   => 'side',
				'priority'  => 'low',
				'sections'  => array(
							array(
							'name'   => '360view_section',
							'fields' =>  array(
											array (
												'id'          => 'product-360view-gallery',
												'type'        => 'gallery',
												'title'       => esc_html__('Gallery Images', 'sirpi-pro'),
												'desc'        => esc_html__('Simply add images to gallery items.', 'sirpi-pro'),
												'add_title'   => esc_html__('Add Images', 'sirpi-pro'),
												'edit_title'  => esc_html__('Edit Images', 'sirpi-pro'),
												'clear_title' => esc_html__('Remove Images', 'sirpi-pro'),
											)
										)
							)
							)
			);

			return $options;

		}

    }
}

Sirpi_Shop_Metabox_Single_360_Viewer::instance();