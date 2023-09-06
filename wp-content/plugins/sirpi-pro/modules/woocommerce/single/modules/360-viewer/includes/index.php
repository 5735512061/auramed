<?php

/*
 * Product single image - Additional Labels
 */

if( ! function_exists( 'sirpi_shop_woo_loop_product_additional_360_viewer_label' ) ) {

	function sirpi_shop_woo_loop_product_additional_360_viewer_label( $single_template ) {

		$settings = sirpi_woo_single_core()->woo_default_settings();
		extract($settings);

		if($product_show_360_viewer) {
			echo do_shortcode('[sirpi_shop_product_images_360viewer product_id="" enable_popup_viewer="true" source="single-product" class="" /]');
		}

	}

	add_action('sirpi_woo_loop_product_additional_labels', 'sirpi_shop_woo_loop_product_additional_360_viewer_label', 10);

}