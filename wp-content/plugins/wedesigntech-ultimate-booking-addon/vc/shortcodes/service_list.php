<?php
if (! class_exists ( 'DTBookingServiceList' ) ) {

    class DTBookingServiceList extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'dt_sc_service_list', array( $this, 'dt_sc_service_list' ) );

			add_filter( 'vc_autocomplete_dt_sc_service_list_terms_callback', array ( $this, 'ultimate_booking_pro_service_list_vc_autocomplete_terms_field_search' ), 10, 1 );
			add_filter( 'vc_autocomplete_dt_sc_service_list_terms_render', array ( $this, 'ultimate_booking_pro_service_list_vc_autocomplete_terms_field_render' ), 10, 1 );
        }

		function dt_sc_service_list($attrs, $content = null ){
			extract( shortcode_atts( array(
				'terms'          => '',
				'posts_per_page' => '',
				'orderby'        => 'date',
				'order'          => 'desc',
				'el_class'       => ''
			), $attrs ) );

			$out = '';

			$categories = isset($terms) ? array_filter( explode(",", $terms) ) : array();

			$query_args = array();
			if( empty($categories) ):
				$query_args = array( 'posts_per_page' => $posts_per_page, 'orderby' => $orderby, 'order' => $order, 'post_status' => 'publish', 'post_type' => 'dt_service');
			else:
				$query_args = array(
					'post_type'           => 'dt_service',
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page,
					'orderby'             => $orderby,
					'order'               => $order,
					'tax_query' => array(
						array(
							'taxonomy' => 'dt_service_category',
							'field'    => 'term_id',
							'operator' => 'IN',
							'terms'    => $categories
						)
					)
				);
			endif;

			$the_query = new WP_Query($query_args);
			if ( $the_query->have_posts() ) :

				$out .= '<div class="dt-services-list '.esc_attr($el_class).'">';

					while ( $the_query->have_posts() ) : $the_query->the_post();
						$PID = get_the_ID();

						#Meta...
						$service_settings = get_post_meta($PID, '_custom_settings', true);
						$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

						$out .= '<div class="dt-sc-service-item dt-sc-one-column column">';
							$out .= '<div class="image">';
								if(has_post_thumbnail()):
									$attr = array('title' => get_the_title(), 'alt' => get_the_title());
									$out .= get_the_post_thumbnail($PID, 'dt-bm-service-type2', $attr);
								else:
									$out .= '<img src="https://place-hold.it/205x205&text='.get_the_title().'" alt="'.get_the_title().'" />';
								endif;
							$out .= '</div>';

							$out .= '<div class="service-details">';
								$out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';

								if( array_key_exists('service_opt_flds', $service_settings) ):
									$out .= '<div class="dt-sc-service-meta">';
										$out .= '<ul>';
											for($i = 1; $i <= (sizeof($service_settings['service_opt_flds']) / 2); $i++):

												$title = $service_settings['service_opt_flds']['service_opt_flds_title_'.$i];
												$value = $service_settings['service_opt_flds']['service_opt_flds_value_'.$i];

												if( !empty($value) ):
													$out .= '<li>'.esc_html($value).' '.esc_html($title).'</li>';
												endif;
											endfor;
										$out .= '</ul>';
									$out .= '</div>';
								endif;

								if( array_key_exists('service-price', $service_settings) && $service_settings['service-price'] != '' ):
									$out .= '<span class="dt-sc-service-price">'.ultimate_booking_pro_get_currency_symbol().$service_settings['service-price'].'</span>';
								endif;
							$out .= '</div>';

						$out .= '</div>';
					endwhile;

				$out .= '</div>';

				wp_reset_postdata();

			else:
				$out .= '<h2>'.esc_html__("Nothing Found.", "wdt-ultimate-booking").'</h2>';
				$out .= '<p>'.esc_html__("Apologies, but no results were found for the requested archive.", "wdt-ultimate-booking").'</p>';
			endif;

			return $out;
		}
    }
}

new DTBookingServiceList();