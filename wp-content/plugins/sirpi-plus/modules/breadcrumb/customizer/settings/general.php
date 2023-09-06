<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusBreadCrumbGeneral' ) ) {
    class SirpiPlusBreadCrumbGeneral {

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
            add_filter( 'sirpi_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {
            $option['enable_breadcrumb']           = 1;
            $option['breadcrumb_source']           = 'default';
            $option['enable_dark_bg_breadcrumb']   = 0;
            $option['breadcrumb_style']            = '';
            $option['breadcrumb_position']         = 'header-top-absolute';
            $option['change_breadcrumb_delimiter'] = 0;
            $option['breadcrumb_delimiter']        = 'wdticon-angle-right';
            $option['hide_content']                = 0;

            return $option;
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new Sirpi_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-general-section',
                    array(
                        'title'    => esc_html__('General', 'sirpi-plus'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 5,
                    )
                )
            );

                /**
                 * Option : Enable Breadcrumb
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[enable_breadcrumb]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_breadcrumb]', array(
                                'type'        => 'wdt-switch',
                                'label'       => esc_html__( 'Enable Breadcrumb', 'sirpi-plus'),
                                'description' => esc_html__('YES! to enable Breadcrumb.', 'sirpi-plus'),
                                'section'     => 'site-breadcrumb-general-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                                    'off' => esc_attr__( 'No', 'sirpi-plus' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Breadcrumb Source
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[breadcrumb_source]', array(
                        'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_source]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Breadcrumb Source?', 'sirpi-plus' ),
                                'choices' => apply_filters( 'sirpi_breadcrumb_source', array(
                                    'default' => esc_html__('Default','sirpi-plus'),
                                ) )
                            )
                        )
                    );

                /**
                 * Option : Enable Dark BG for Breadcrumb
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[enable_dark_bg_breadcrumb]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_dark_bg_breadcrumb]', array(
                                'type'        => 'wdt-switch',
                                'label'       => esc_html__( 'Enable Dark Breadcrumb', 'sirpi-plus'),
                                'description' => esc_html__('YES! to enable dark Breadcrumb.', 'sirpi-plus'),
                                'section'     => 'site-breadcrumb-general-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                                    'off' => esc_attr__( 'No', 'sirpi-plus' )
                                )
                            )
                        )
                    );

                $breadcrumb_layouts = apply_filters( 'sirpi_plus_breadcrumb_layouts', array( 'default' => esc_html__('Default', 'sirpi-plus') ) );
                if( count( $breadcrumb_layouts ) > 1 ) {
                    /**
                     * Option : Breadcrumb Style
                     */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[breadcrumb_style]', array(
                        'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_style]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Style?', 'sirpi-plus' ),
                                'choices' => $breadcrumb_layouts
                            )
                        )
                    );
                }

                /**
                 * Option : Breadcrumb Position
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[breadcrumb_position]', array(
                        'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_position]', array(
                                'type'    => 'select',
                                'section' => 'site-breadcrumb-general-section',
                                'label'   => esc_html__( 'Position?', 'sirpi-plus' ),
                                'choices' => array(
                                    'header-top-absolute' => esc_html__('Behind the Header','sirpi-plus'),
                                    'header-top-relative' => esc_html__('Default','sirpi-plus'),
                                )
                            )
                        )
                    );


                /**
                 * Option : Change Breadcrumb Delimiter
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[change_breadcrumb_delimiter]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[change_breadcrumb_delimiter]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Change Breadcrumb Delimiter', 'sirpi-plus'),
                                'section' => 'site-breadcrumb-general-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                                    'off' => esc_attr__( 'No', 'sirpi-plus' )
                                ),
                                'dependency'   => array( 'breadcrumb_source', '==', 'default' )
                            )
                        )
                    );

                /**
                 * Option : Breadcrumb Delimiter
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[breadcrumb_delimiter]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Fontawesome(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[breadcrumb_delimiter]', array(
                                'type'       => 'wdt-fontawesome',
                                'section'    => 'site-breadcrumb-general-section',
                                'label'      => esc_html__( 'Breadcrumb Delimiter', 'sirpi-plus'),
                                'dependency' => array ( 'change_breadcrumb_delimiter', '==', '1' )
                            )
                        )
                    );

                /**
                 * Option : Hide Content
                 */
                    $wp_customize->add_setting(
                        SIRPI_CUSTOMISER_VAL . '[hide_content]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Sirpi_Customize_Control_Switch(
                            $wp_customize, SIRPI_CUSTOMISER_VAL . '[hide_content]', array(
                                'type'        => 'wdt-switch',
                                'label'       => esc_html__( 'Hide Content', 'sirpi-plus'),
                                'description' => esc_html__('YES! to hide title and breadcrumb.', 'sirpi-plus'),
                                'section'     => 'site-breadcrumb-general-section',
                                'choices'     => array(
                                    'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                                    'off' => esc_attr__( 'No', 'sirpi-plus' )
                                )
                            )
                        )
                    );

        }
    }
}

SirpiPlusBreadCrumbGeneral::instance();