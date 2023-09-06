<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Sirpi WordPress theme
 */

function sirpi_tgmpa_plugins_register() {

	// Get array of recommended plugins.
	$plugins_list = array(
        array(
            'name'               => esc_html__('Sirpi Plus', 'sirpi'),
            'slug'               => 'sirpi-plus',
            'source'             => SIRPI_MODULE_DIR . '/plugins/sirpi-plus.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Sirpi Pro', 'sirpi'),
            'slug'               => 'sirpi-pro',
            'source'             => SIRPI_MODULE_DIR . '/plugins/sirpi-pro.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'sirpi'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Elementor Addon', 'sirpi'),
            'slug'               => 'wedesigntech-elementor-addon',
            'source'             => SIRPI_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Ultimate Booking Addon', 'sirpi'),
            'slug'               => 'wedesigntech-ultimate-booking-addon',
            'source'             => SIRPI_MODULE_DIR . '/plugins/wedesigntech-ultimate-booking-addon.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('WooCommerce', 'sirpi'),
            'slug'     => 'woocommerce',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('Sirpi Shop', 'sirpi'),
            'slug'               => 'sirpi-shop',
            'source'             => SIRPI_MODULE_DIR . '/plugins/sirpi-shop.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Variation Swatches for WooCommerce', 'sirpi'),
            'slug'     => 'woo-variation-swatches',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('YITH WooCommerce Wishlist', 'sirpi'),
            'slug'     => 'yith-woocommerce-wishlist',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('YITH WooCommerce Compare', 'sirpi'),
            'slug'     => 'yith-woocommerce-compare',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'sirpi'),
            'slug'     => 'contact-form-7',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('Date Time Picker for Contact Form 7', 'sirpi'),
            'slug'     => 'date-time-picker-for-contact-form-7',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('Unyson', 'sirpi'),
            'slug'     => 'unyson',
            'required' => true,
        )
	);

	$plugins = apply_filters('sirpi_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'sirpi_theme',
		'domain'       => 'sirpi',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'sirpi_tgmpa_plugins_register' );