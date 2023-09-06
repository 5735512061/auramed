<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusCustomizerSidebar' ) ) {
    class SirpiPlusCustomizerSidebar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {

            /**
             * Main Panel
             */
            $wp_customize->add_panel(
                new Sirpi_Customize_Panel(
                    $wp_customize,
                    'site-widget-main-panel',
                    array(
                        'title'    => esc_html__('Site Sidebar', 'sirpi-plus'),
                        'priority' => sirpi_customizer_panel_priority( 'sidebar' )
                    )
                )
            );

                /**
                 * Settings Panel
                 */
                $wp_customize->add_panel(
                    new Sirpi_Customize_Panel(
                        $wp_customize,
                        'site-widget-settings-panel',
                        array(
                            'title'    => esc_html__('Settings', 'sirpi-plus'),
                            'panel'    => 'site-widget-main-panel',
                            'priority' => 10
                        )
                    )
                );

                /**
                 * Widget Area Panel
                 */
                $wp_customize->add_panel(
                    new Sirpi_Customize_Panel(
                        $wp_customize,
                        'widgets',
                        array(
                            'title'       => esc_html__('Widget Areas', 'sirpi-plus'),
                            'panel'       => 'site-widget-main-panel',
                            'description' => esc_html__( 'Widgets are independent sections of content that can be placed into widgetized areas provided by your theme (commonly lled sidebars).', 'sirpi-plus' ),
                            'priority'    => 15,
                        )
                    )
                );

        }

        function load_modules() {
            foreach( glob( SIRPI_PLUS_DIR_PATH. 'modules/sidebar/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

SirpiPlusCustomizerSidebar::instance();