<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_options_csirpi_render' ) ) {
	function sirpi_shop_woo_single_summary_options_csirpi_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'sirpi-pro');
		return $options;

	}
	add_filter( 'sirpi_shop_woo_single_summary_options', 'sirpi_shop_woo_single_summary_options_csirpi_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_styles_csirpi_render' ) ) {
	function sirpi_shop_woo_single_summary_styles_csirpi_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'sirpi_shop_woo_single_summary_styles', 'sirpi_shop_woo_single_summary_styles_csirpi_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'sirpi_shop_woo_single_summary_scripts_csirpi_render' ) ) {
	function sirpi_shop_woo_single_summary_scripts_csirpi_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'sirpi_shop_woo_single_summary_scripts', 'sirpi_shop_woo_single_summary_scripts_csirpi_render', 10, 1 );

}