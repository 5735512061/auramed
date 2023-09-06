<?php

/* Product Tabs Exploaded - Shortcodes */

if(!function_exists('sirpi_shop_product_tabs_exploded_html')) {
	function sirpi_shop_product_tabs_exploded_html($attrs, $content = null) {

		$attrs = shortcode_atts ( array (
			'product_id'    => '',
			'tab'           => '',
			'hide_title'    => '',
			'apply_scroll'  => '',
			'scroll_height' => '',
			'class'         => ''
		), $attrs, 'sirpi_shop_product_tabs_exploded' );

		$out = sirpi_shop_product_tabs_exploded_render_html($attrs);

		return $out;

	}
	add_shortcode( 'sirpi_shop_product_tabs_exploded', 'sirpi_shop_product_tabs_exploded_html' );
}


if(!function_exists('sirpi_shop_product_tabs_exploded_render_html')) {
	function sirpi_shop_product_tabs_exploded_render_html($settings) {

		$output = '';

		if(is_singular('product') && (!isset($settings['product_id']) || $settings['product_id'] == '')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] && $settings['product_id'] != '') {

			$hide_title_class = '';
			if($settings['hide_title'] == 'true') {
				$hide_title_class = 'wdt-product-hide-tab-title';
			}

			$scroll_class = $scroll_height_style_attr = '';
			if($settings['apply_scroll'] == 'true') {
				$scroll_class             = 'wdt-content-scroll';
				$scroll_height            = ($settings['scroll_height'] != '') ? $settings['scroll_height'] : 400;
				$scroll_height_style_attr = 'style = "height:'.esc_attr($scroll_height).'px"';
			}

			$output .= '<div class="wdt-product-tabs wdt-product-tabs-exploded '.$settings['class'].' '.$hide_title_class.' '.$scroll_class.'" '.$scroll_height_style_attr.'>';

				if($settings['tab'] == 'description') {

					ob_start();
					woocommerce_product_description_tab();
					$output .= ob_get_clean();

				}

				if($settings['tab'] == 'review') {

					ob_start();
					comments_template();
					$output .= ob_get_clean();

				}

				if($settings['tab'] == 'additional_information') {

					ob_start();
					woocommerce_product_additional_information_tab();
					$output .= ob_get_clean();

				}

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'sirpi-pro');

		}

		return $output;

	}
}


if(!function_exists('yith_wcbr_image_size_single_product_brads_render')){
    function yith_wcbr_image_size_single_product_brads_render($html, $thumbnail_id) {
        return wp_get_attachment_image( $thumbnail_id, 'full' );
    }
    add_filter( 'yith_wcbr_image_size_single_product_brads', 'yith_wcbr_image_size_single_product_brads_render', 10, 2 );
}