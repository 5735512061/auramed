<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusSkinQuaternaryColor' ) ) {
    class SirpiPlusSkinQuaternaryColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'sirpi_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'sirpi_quaternary_color_css_var', array( $this, 'quaternary_color_var' ) );
            add_filter( 'sirpi_quaternary_rgb_color_css_var', array( $this, 'quaternary_rgb_color_var' ) );
            add_filter( 'sirpi_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('sirpi_theme_defaults') ? sirpi_theme_defaults() : array ();
            $option['quaternary_color'] = $theme_defaults['quaternary_color'];
            return $option;
        }

        function register( $wp_customize ) {

                /**
                 * Option : quaternary Color
                 */
                $wp_customize->add_setting(
                    SIRPI_CUSTOMISER_VAL . '[quaternary_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Sirpi_Customize_Control_Color(
                        $wp_customize, SIRPI_CUSTOMISER_VAL . '[quaternary_color]', array(
                            'section' => 'site-skin-main-section',
                            'label'   => esc_html__( 'Quaternary Color', 'sirpi-plus' ),
                        )
                    )
                );

        }

        function quaternary_color_var( $var ) {
            $quaternary_color = sirpi_customizer_settings( 'quaternary_color' );
            if( !empty( $quaternary_color ) ) {
                $var = '--wdtquaternaryColor:'.esc_attr($quaternary_color).';';
            }

            return $var;
        }

        function quaternary_rgb_color_var( $var ) {
            $quaternary_color = sirpi_customizer_settings( 'quaternary_color' );
            if( !empty( $quaternary_color ) ) {
                $var = '--wdtquaternaryColorRgb:'.sirpi_hex2rgba($quaternary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'sirpi_quaternary_color_style', $style );

            return $style;
        }
    }
}

SirpiPlusSkinQuaternaryColor::instance();