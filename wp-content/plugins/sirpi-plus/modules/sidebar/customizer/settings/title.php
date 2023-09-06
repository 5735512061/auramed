<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusWidgetTitleSettings' ) ) {
    class SirpiPlusWidgetTitleSettings {

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

        function register( $wp_customize ){

            /**
             * Title Section
             */
            $wp_customize->add_section(
                new Sirpi_Customize_Section(
                    $wp_customize,
                    'site-widgets-title-style-section',
                    array(
                        'title'    => esc_html__('Widget Title', 'sirpi-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 5,
                    )
                )
            );

            if ( ! defined( 'SIRPI_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Sirpi_Customize_Control_Separator(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[sirpi-plus-site-sidebar-title-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-widgets-title-style-section',
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

SirpiPlusWidgetTitleSettings::instance();