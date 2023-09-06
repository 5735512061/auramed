<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Metabox_Single_Upsell_Related' ) ) {
    class Sirpi_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'sirpi_shop_product_custom_settings', array( $this, 'sirpi_shop_product_custom_settings' ), 10 );

		}

        function sirpi_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('sirpi_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'sirpi'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
							'true'         => esc_html__( 'Show', 'sirpi'),
							null           => esc_html__( 'Hide', 'sirpi'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'sirpi'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
						1              => esc_html__( 'One Column', 'sirpi' ),
						2              => esc_html__( 'Two Columns', 'sirpi' ),
						3              => esc_html__( 'Three Columns', 'sirpi' ),
						4              => esc_html__( 'Four Columns', 'sirpi' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'sirpi'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
						1              => esc_html__( 'One', 'sirpi' ),
						2              => esc_html__( 'Two', 'sirpi' ),
						3              => esc_html__( 'Three', 'sirpi' ),
						4              => esc_html__( 'Four', 'sirpi' ),
						5              => esc_html__( 'Five', 'sirpi' ),
						6              => esc_html__( 'Six', 'sirpi' ),
						7              => esc_html__( 'Seven', 'sirpi' ),
						8              => esc_html__( 'Eight', 'sirpi' ),
						9              => esc_html__( 'Nine', 'sirpi' ),
						10              => esc_html__( 'Ten', 'sirpi' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'sirpi'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
							'true'         => esc_html__( 'Show', 'sirpi'),
							null           => esc_html__( 'Hide', 'sirpi'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'sirpi'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
						2              => esc_html__( 'Two Columns', 'sirpi' ),
						3              => esc_html__( 'Three Columns', 'sirpi' ),
						4              => esc_html__( 'Four Columns', 'sirpi' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'sirpi'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'sirpi' ),
						1              => esc_html__( 'One', 'sirpi' ),
						2              => esc_html__( 'Two', 'sirpi' ),
						3              => esc_html__( 'Three', 'sirpi' ),
						4              => esc_html__( 'Four', 'sirpi' ),
						5              => esc_html__( 'Five', 'sirpi' ),
						6              => esc_html__( 'Six', 'sirpi' ),
						7              => esc_html__( 'Seven', 'sirpi' ),
						8              => esc_html__( 'Eight', 'sirpi' ),
						9              => esc_html__( 'Nine', 'sirpi' ),
						10              => esc_html__( 'Ten', 'sirpi' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Sirpi_Shop_Metabox_Single_Upsell_Related::instance();