<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProBreadCrumbTypo' ) ) {
    class SirpiProBreadCrumbTypo {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

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
             * Option :Breadcrumb Title Typo
             */
                $wp_customize->add_setting(
                    SIRPI_CUSTOMISER_VAL . '[breadcrumb_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Sirpi_Customize_Control_Typography(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_title_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-breadcrumb-typo-section',
                            'label'   => esc_html__( 'Title Typography', 'sirpi-pro'),
                        )
                    )
                );


            /**
             * Option :Breadcrumb Typo
             */
                $wp_customize->add_setting(
                    SIRPI_CUSTOMISER_VAL . '[breadcrumb_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Sirpi_Customize_Control_Typography(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-breadcrumb-typo-section',
                            'label'   => esc_html__( 'Breadcrumb Typography', 'sirpi-pro'),
                        )
                    )
                );

        }
    }
}

SirpiProBreadCrumbTypo::instance();