<?php
if (! class_exists ( 'DTBookingServiceItem' ) ) {

    class DTBookingServiceItem extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'dt_sc_service_item', array( $this, 'dt_sc_service_item' ) );
        }

		function dt_sc_service_item($attrs, $content = null ){
			extract( shortcode_atts( array(
				'service_id'     => '',
				'type'           => 'type1',
				'excerpt'        => 'no',
				'excerpt_length' => 12,
				'meta'           => 'no',
				'button_text'    => esc_html__('View procedure details', 'wedesigntech-ultimate-booking-addon')
			), $attrs ) );

			$out = '';

			#Performing query...
			$args = array('post_type' => 'dt_service' );
			if($service_id != '') {
				$args['post__in'] = explode(',', $service_id);
			}

			$the_query = new WP_Query($args);
			if($the_query->have_posts()):

				while($the_query->have_posts()): $the_query->the_post();
					$PID = get_the_ID();

					#Meta...
					$service_settings = get_post_meta($PID, '_custom_settings', true);
					$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

					$out .= '<div class="dt-sc-service-item '.$type.'">';
						$out .= '<div class="image">';
								if(has_post_thumbnail()):
									$attr = array('title' => get_the_title(), 'alt' => get_the_title());
									$img_size = 'full';

									if( $type == 'type2' ) {
										$img_size = 'dt-bm-service-type2';
									}
									$out .= get_the_post_thumbnail($PID, $img_size, $attr);
								else:
									$img_pros = '615x560';

									if( $type == 'type2' ) {
										$img_pros = '205x205';
									}
									$out .= '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'" />';
								endif;
						$out .= '</div>';

						$out .= '<div class="service-details">';
							$out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';
							if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
								$out .= '<h6>'.esc_html__('Duration : ', 'wedesigntech-ultimate-booking-addon').ultimate_booking_pro_duration_to_string($service_settings['service-duration']).'</h6>';
							endif;

							if( array_key_exists('service-price', $service_settings) ):
								$out .= '<span class="dt-sc-service-price">'.ultimate_booking_pro_get_currency_symbol().$service_settings['service-price'].'</span>';
							endif;

							if( $excerpt == 'yes' && $excerpt_length > 0 ):
								$out .= ultimate_booking_pro_post_excerpt($excerpt_length);
							endif;

							if( array_key_exists('service_opt_flds', $service_settings) && $meta == 'yes' ):
								$out .= '<div class="dt-sc-service-meta">';
									$out .= '<ul>';
										for($i = 1; $i <= (sizeof($service_settings['service_opt_flds']) / 2); $i++):

											$title = $service_settings['service_opt_flds']['service_opt_flds_title_'.$i];
											$value = $service_settings['service_opt_flds']['service_opt_flds_value_'.$i];

											if( !empty($value) ):
												$out .= '<li>';
													$out .= '<h6>'.esc_html($title).'</h6>';
													$out .= '<span>'.esc_html($value).'</span>';
												$out .= '</li>';
											endif;
										endfor;
									$out .= '</ul>';
								$out .= '</div>';
							endif;

							$out .= '<a class="dt-sc-button medium bordered" href="'.get_permalink().'" title="'.get_the_title().'">'.esc_html($button_text).'</a>';

						$out .= '</div>';
					$out .= '</div>';
				endwhile;

				wp_reset_postdata();

			else:
				$out .= '<h2>'.esc_html__("Nothing Found.", "wdt-ultimate-booking").'</h2>';
				$out .= '<p>'.esc_html__("Apologies, but no results were found for the requested archive.", "wdt-ultimate-booking").'</p>';
			endif;

			return $out;
		}
    }
}

new DTBookingServiceItem();