<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusCustomizerSite404' ) ) {
    class SirpiPlusCustomizerSite404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {

            /**
             * 404 Page
             */
            $wp_customize->add_section(
                new Sirpi_Customize_Section(
                    $wp_customize,
                    'site-404-page-section',
                    array(
                        'title'    => esc_html__('404 Page', 'sirpi-plus'),
                        'priority' => sirpi_customizer_panel_priority( '404' )
                    )
                )
            );

            if ( ! defined( 'SIRPI_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Sirpi_Customize_Control_Separator(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[sirpi-plus-site-404-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-404-page-section',
                            'settings'    => array(),
                            'caption'     => SIRPI_PLUS_REQ_CAPTION,
                            'description' => SIRPI_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

SirpiPlusCustomizerSite404::instance();