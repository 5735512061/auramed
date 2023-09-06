<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_options_bn_render' ) ) {
	function sirpi_shop_woo_single_summary_options_bn_render( $options ) {

		$options['buy_now'] = esc_html__('Summary Buy Now', 'sirpi-pro');
		return $options;

	}
	add_filter( 'sirpi_shop_woo_single_summary_options', 'sirpi_shop_woo_single_summary_options_bn_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_styles_bn_render' ) ) {
	function sirpi_shop_woo_single_summary_styles_bn_render( $styles ) {

		array_push( $styles, 'wdt-shop-buy-now' );
		return $styles;

	}
	add_filter( 'sirpi_shop_woo_single_summary_styles', 'sirpi_shop_woo_single_summary_styles_bn_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_scripts_bn_render' ) ) {
	function sirpi_shop_woo_single_summary_scripts_bn_render( $scripts ) {

		array_push( $scripts, 'wdt-shop-buy-now' );
		return $scripts;

	}
	add_filter( 'sirpi_shop_woo_single_summary_scripts', 'sirpi_shop_woo_single_summary_scripts_bn_render', 10, 1 );

}