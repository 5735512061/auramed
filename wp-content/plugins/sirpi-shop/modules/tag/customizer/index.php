<?php

/**
 * Listing Customizer - Tag Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Sirpi_Shop_Listing_Customizer_Tag' ) ) {

    class Sirpi_Shop_Listing_Customizer_Tag {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'sirpi_woo_tag_page_default_settings', array( $this, 'tag_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'sirpi_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function tag_page_default_settings( $settings ) {

            $disable_breadcrumb             = sirpi_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $show_sorter_on_header              = sirpi_customizer_settings('wdt-woo-tag-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = sirpi_customizer_settings('wdt-woo-tag-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = sirpi_customizer_settings('wdt-woo-tag-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = sirpi_customizer_settings('wdt-woo-tag-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'sirpi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-shop' ),
                                    'off' => esc_attr__( 'No', 'sirpi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'sirpi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-shop' ),
                                    'off' => esc_attr__( 'No', 'sirpi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Sirpi_Customize_Control_Sortable(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'sirpi-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'sirpi_tag_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'sirpi-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'sirpi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'sirpi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'sirpi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'sirpi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'sirpi-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'sirpi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-shop' ),
                                    'off' => esc_attr__( 'No', 'sirpi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Sirpi_Customize_Control_Sortable(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'sirpi-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'sirpi_tag_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'sirpi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'sirpi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'sirpi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'sirpi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'sirpi-shop' )
                            )),
                        )
                    ));

        }

        function woo_handle_product_breadcrumb() {

            if(is_product_tag() && sirpi_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' )) {
                remove_action('sirpi_breadcrumb', 'sirpi_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('sirpi_shop_listing_customizer_tag') ) {
	function sirpi_shop_listing_customizer_tag() {
		return Sirpi_Shop_Listing_Customizer_Tag::instance();
	}
}

sirpi_shop_listing_customizer_tag();