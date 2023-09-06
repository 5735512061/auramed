<?php

namespace SirpiElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Sirpi_Shop_Widget_Product_Cat extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-cat';
	}

	public function get_title() {
		return esc_html__( 'Product Categories', 'sirpi-pro' );
	}

	public function get_style_depends() {
		return array ( 'wdt-shop-product-cat' );
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_cat_section', array(
			'label' => esc_html__( 'General', 'sirpi-pro' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'sirpi-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type that you like yo use.', 'sirpi-pro' ),
				'options'     => array(
					'type1' => esc_html__('Type 1', 'sirpi-pro'),
					'type2' => esc_html__('Type 2', 'sirpi-pro')
				),
				'default'     => 'type1',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'sirpi-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column', 'sirpi-pro'),
					2  => esc_html__('II Columns', 'sirpi-pro'),
					3  => esc_html__('III Columns', 'sirpi-pro')
				),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.', 'sirpi-pro' ),
				'default'      => 3,
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'sirpi-pro' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Category ids separated by comma.', 'sirpi-pro' ),
				'default' => ''
			) );

			$this->add_control( 'show_starting_price', array(
				'label'       => esc_html__( 'Show Starting Price', 'sirpi-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show starting price.', 'sirpi-pro' ),
				'options'     => array(
					'false' => esc_html__('False', 'sirpi-pro'),
					'true'  => esc_html__('True', 'sirpi-pro'),
				),
				'condition'   => array( 'type' => 'type1' ),
				'default'     => 'false',
	        ) );

			$this->add_control( 'show_button', array(
				'label'       => esc_html__( 'Show Button', 'sirpi-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show button.', 'sirpi-pro' ),
				'options'     => array(
					'false' => esc_html__('False', 'sirpi-pro'),
					'true'  => esc_html__('True', 'sirpi-pro'),
				),
				'default'     => 'false',
	        ) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'sirpi-pro' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'sirpi-pro' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

			if($settings['columns'] == 1) {
				$column_class = 'column wdt-one-column';
			} else if($settings['columns'] == 2) {
				$column_class = 'column wdt-one-half';
			} else {
				$column_class = 'column wdt-one-third';
			}

			$cat_args = array (
				'taxonomy'   => 'product_cat',
				'hide_empty' => 1
			);
			if($settings['include'] != '') {
				$cat_args['include'] = $settings['include'];
			}
			$categories = get_categories($cat_args);

			if( is_array($categories) && !empty($categories) ) {

				$i = 1;
				foreach( $categories as $category ) {

					if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
					if($i == $settings['columns']) { $i = 1; } else { $i = $i + 1; }

					$term_id = $category->term_id;
					$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
					$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
					$cat_image = $image_url ? $image_url[0] : false;

					$color_html = '';
					$sirpi_shop_cat_color = get_term_meta($term_id, 'sirpi_shop_cat_color', true);
					if($sirpi_shop_cat_color != '') {
						$color_html .= '<div class="wdt-shop-category-listing-color" style="background-color:'.$sirpi_shop_cat_color.';"></div>';
					}

					if($settings['type'] == 'type2') {

						$output .= '<div class="wdt-shop-category-listing-item '.$column_class.' '.$first_class.' '.$settings['type'].' '.$settings['class'].'">';
							$output .= '<div class="wdt-shop-category-listing-inner">';
								if($cat_image) {
									$output .= '<div class="wdt-shop-category-listing-image">';
										$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'sirpi-pro').'" title="'.esc_html__('Category Image', 'sirpi-pro').'" /></a>';
									$output .= '</div>';
								}
								$output .= '<div class="wdt-shop-category-meta-data">';
									$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
									$output .= '<div class="wdt-shop-category-total-items">('.sprintf( esc_html__('%1$s Items', 'sirpi-pro'), '<span>'.$category->count.'</span>' ).')</div>';
									if($settings['show_button'] == 'true') {
										$output .= '<a href="'.get_term_link($category->term_id).'" class="wdt-shop-cat-button button">'.esc_html__('View Details', 'sirpi-pro').'</a>';
									}
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

					} else {

						$output .= '<div class="wdt-shop-category-listing-item '.$column_class.' '.$first_class.' '.$settings['type'].' '.$settings['class'].'">';
							$output .= '<div class="wdt-shop-category-listing-inner">';
								if($cat_image){
									$output .= '<div class="wdt-shop-category-listing-image">';
										$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'sirpi-pro').'" title="'.esc_html__('Category Image', 'sirpi-pro').'" /></a>';
										$output .= $color_html;
									$output .= '</div>';
								}
								$output .= '<div class="wdt-shop-category-meta-data">';
									$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
									if($settings['show_starting_price'] == 'true') {

										$product_args = array (
											'posts_per_page' => -1,
											'post_type'      => 'product',
											'meta_query'     => array (),
											'tax_query'      => array (),
											'post_status'    => 'publish'
										);

										$product_args['tax_query'][] = array (
											'taxonomy' => 'product_cat',
											'field' => 'id',
											'terms' => $category,
											'operator' => 'IN'
										);

										$product_args['orderby']  = 'meta_value_num';
										$product_args['order']    = 'ASC';
										$product_args['meta_key'] = '_sale_price';
										$product_args['fields']   = 'ids';

										$product_ids = get_posts($product_args);
										$cat_product_id = $product_ids[0];

										$wc_product_object = wc_get_product( $cat_product_id );
										if($wc_product_object) {
											$woo_price_html = $wc_product_object->get_price_html();

											if($woo_price_html != '') {
												$output .= '<div class="wdt-shop-category-starting-price-html">'.sprintf(esc_html__('Starts from %1$s', 'sirpi-pro'), $woo_price_html).'</div>';
											}
										}

									}
									if($settings['show_button'] == 'true') {
										$output .= '<a href="'.get_term_link($category->term_id).'" class="wdt-shop-cat-button button">'.esc_html__('View Details', 'sirpi-pro').'</a>';
									}
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

					}

				}

			}

		echo sirpi_html_output($output);

	}

}