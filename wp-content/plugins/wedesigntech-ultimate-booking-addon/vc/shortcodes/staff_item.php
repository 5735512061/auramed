<?php
if (! class_exists ( 'DTBookingStaffItem' ) ) {

    class DTBookingStaffItem extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'dt_sc_staff_item', array( $this, 'dt_sc_staff_item' ) );
        }

		function dt_sc_staff_item($attrs, $content = null ){
			extract( shortcode_atts( array(
				'staff_id' => '',
				'type'  => 'type1',
				'show_button' => 'no',
				'button_text' => esc_html__('Book an appointment', 'wedesigntech-ultimate-booking-addon')
			), $attrs ) );
	
			$out = '';
	
			#Performing query...
			$args = array('post_type' => 'dt_staff', 'p' => $staff_id );
	
			$the_query = new WP_Query($args);
			if($the_query->have_posts()):
	
				while($the_query->have_posts()): $the_query->the_post();
					$PID = $staff_id;
	
					#Meta...
					$staff_settings = get_post_meta($PID, '_custom_settings', true);
					$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();
	
					$out .= '<div class="dt-sc-staff-item '.$type.'">';
						$out .= '<div class="image">';
								if(has_post_thumbnail()):
									$attr = array('title' => get_the_title(), 'alt' => get_the_title());
									$img_size = 'full';
	
									if( $type == 'type2' ) {
										$img_size = 'dt-bm-staff-type2';
									}
									$out .= get_the_post_thumbnail($PID, $img_size, $attr);
								else:
									$img_pros = '600x692';
	
									if( $type == 'type2' ) {
										$img_pros = '205x205';
									}
									$out .= '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'" />';
								endif;
	
								if( $show_button == 'yes' ):
									$out .= '<div class="dt-sc-staff-overlay">';
										$out .= '<a class="dt-sc-button white medium bordered" href="'.get_permalink().'" title="'.get_the_title().'">'.esc_html($button_text).'</a>';
									$out .= '</div>';
								endif;

								if( $type == 'type1' ) {
									if( array_key_exists('staff-social', $staff_settings) ):
										$socialicondr = do_shortcode($staff_settings['staff-social']);
                                        $out .= '<div class="socialicon">'.$socialicondr.'</div>';
									endif;
								}

						$out .= '</div>';
	
						$out .= '<div class="staff-details">';
							$out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';
							if( array_key_exists('staff-role', $staff_settings) ):
								$out .= '<h6>'.$staff_settings['staff-role'].'</h6>';
							endif;

							if( $type == 'type1' && $show_appoinment == 'yes') {
							if( array_key_exists('appointment_fs1', $staff_settings) && array_key_exists('appointment_fs5', $staff_settings) ):
								$out .= '<p>'.esc_html__('Monday to Friday : ', 'wedesigntech-ultimate-booking-addon').$staff_settings['appointment_fs1']['ultimate_booking_pro_monday_start'].' - '.$staff_settings['appointment_fs5']['ultimate_booking_pro_friday_end'].esc_html__(' hrs', 'wedesigntech-ultimate-booking-addon');
							endif;
							}
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

new DTBookingStaffItem();