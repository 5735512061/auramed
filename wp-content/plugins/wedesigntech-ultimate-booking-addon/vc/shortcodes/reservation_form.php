<?php
if (! class_exists ( 'DTBookingReservationForm' ) ) {

    class DTBookingReservationForm extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'dt_sc_reservation_form', array( $this, 'dt_sc_reservation_form' ) );

			add_filter( 'vc_autocomplete_dt_sc_reservation_form_serviceids_callback', array ( $this, 'ultimate_booking_pro_vc_autocomplete_serviceids_field_search' ), 10, 1 );
			add_filter( 'vc_autocomplete_dt_sc_reservation_form_serviceids_render', array ( $this, 'ultimate_booking_pro_vc_autocomplete_serviceids_field_render' ), 10, 1 );

			add_filter( 'vc_autocomplete_dt_sc_reservation_form_staffids_callback', array ( $this, 'ultimate_booking_pro_vc_autocomplete_staffids_field_search' ), 10, 1 );
			add_filter( 'vc_autocomplete_dt_sc_reservation_form_staffids_render', array ( $this, 'ultimate_booking_pro_vc_autocomplete_staffids_field_render' ), 10, 1 );
        }

		function dt_sc_reservation_form($attrs, $content = null) {
			extract(shortcode_atts(array(
				'title'      => esc_html__('Appointment', 'wedesigntech-ultimate-booking-addon'),
				'serviceids' => '',
				'staffids'   => '',
			), $attrs));

			$out = '';

			$url = get_page_link( cs_get_option('appointment-pageid') );
			$url = isset($url) ? $url : '';

			if($url != '') {

				$out = '<div class="dt-sc-appointment-wrapper">';

					$out .= '<div class="dt-sc-title">';
						$out .= '<h2>'.$title.'</h2>';
					$out .= '</div>';

					$out .= '<form class="dt-sc-reservation-form dt-appointment-form" name="reservation-schedule-form" method="post" action="'.$url.'">';

					$out .= '<div class="dt-sc-one-column column">
								<div class="frm-group">
									<div class="placeholder">
	            						<label for="name">'.esc_html__('Name','wedesigntech-ultimate-booking-addon').'</label>
	          						</div>
									<input type="text" id="cli-name" name="cli-name" class="frm-control">
								</div>
							</div>';

					$out .= '<div class="dt-sc-one-column column">
								<div class="frm-group">
									<div class="placeholder">
	            						<label for="name">'.esc_html__('Email','wedesigntech-ultimate-booking-addon').'</label>
	          						</div>
									<input type="text" id="cli-email" name="cli-email" class="frm-control">
								</div>
							</div>';

					$out .= '<div class="dt-sc-one-column column">
								<div class="frm-group">
									<div class="placeholder">
	            						<label for="name">'.esc_html__('Type of Service','wedesigntech-ultimate-booking-addon').'</label>
	            						<span class="star">*</span>
	          						</div>
									<select name="services" id="services" class="dt-select-service frm-control" required>
									  	<option value=""></option>';
								  		if($serviceids != '') {
								  			$serviceids_arr = explode(',', $serviceids);
											$cp_services = get_posts( array('post_type'=>'dt_service', 'posts_per_page'=>'-1', 'post__in' => $serviceids_arr, 'suppress_filters' => false ));
									  	} else {
										  $cp_services = get_posts( array('post_type'=>'dt_service', 'posts_per_page'=>'-1', 'suppress_filters' => false ) );
									  	}

									  	if( $cp_services ) {
									  		foreach( $cp_services as $cp_service ){
									  			$id = $cp_service->ID;
											  	$title = $cp_service->post_title;

												$service_settings = get_post_meta($id, '_custom_settings', true);
												$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

											  	$out .= "<option value='{$id}'>{$title}";
											  		if( cs_get_option('enable-price-in-dropdown') && array_key_exists('service-price', $service_settings) ):
											  			$out .= ' - '.ultimate_booking_pro_get_formatted_price( $service_settings['service-price'] );
												  	endif;
											  	$out .= "</option>";
											}
										}
									$out .= '</select>
								</div>
							</div>';

					$out .= '<div class="dt-sc-one-column column">
								<div class="frm-group dt-appoint-date form-calendar-icon">
									<div class="placeholder">
	            						<label for="name">'.esc_html__('Preferred Date','wedesigntech-ultimate-booking-addon').'</label>
	            						<span class="star">*</span>
	          						</div>
									<input type="text" id="datepicker" name="date" class="frm-control" required>
								</div>
							 </div>';

					$out .= '<div class="dt-sc-one-column column">
								<div class="frm-group">
									<div class="placeholder">
	            						<label for="name">'.esc_html__('Name of Staff','wedesigntech-ultimate-booking-addon').'</label>
	            						<span class="star">*</span>
	          						</div>
									<select name="staff" id="staff" class="dt-select-staff frm-control" required>
										<option value=""></option>';
										if($staffids != '') {
											$staffids_arr = explode(',', $staffids);
											$cp_staffs = get_posts( array('post_type'=>'dt_staff', 'posts_per_page'=>'-1', 'post__in' => $staffids_arr ) );
										} else {
											$cp_staffs = get_posts( array('post_type'=>'dt_staff', 'posts_per_page'=>'-1' ) );
										}
										if( $cp_staffs ){
											foreach( $cp_staffs as $cp_staff ){
												$id = $cp_staff->ID;
												$title = $cp_staff->post_title;

												$staff_settings = get_post_meta($id, '_custom_settings', true);
												$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();

												$out .= '<option value="'.$id.'">'.$title;
													if( cs_get_option('enable-price-in-dropdown') && array_key_exists('staff-price', $staff_settings) ):
														$out .= ' - '.ultimate_booking_pro_get_formatted_price( $staff_settings['staff-price'] );
													endif;
												$out .= '</option>';
											}
										}
									$out .= '</select>
								</div>
							</div>';

					$out .= '<div class="dt-sc-one-column column">
								<div class="aligncenter">
									<input name="subschedule" class="dt-sc-button filled medium show-time-shortcode" value="'.esc_attr__('Fix an appointment', 'wedesigntech-ultimate-booking-addon').'" type="submit">
								</div>
							</div>';

					$out .= '<input type="hidden" id="staffids" name="staffids" value="'.$staffids.'" /><input type="hidden" id="serviceids" name="serviceids" value="'.$serviceids.'" />';

					$out .= '</form>';

				$out .= '</div>';
			} else {
				$out .= '<div class="dt-sc-info-box">'.esc_html__('Please create Reservation template page in order to make this shortcode work properly!', 'wedesigntech-ultimate-booking-addon').'</div>';
			}

			return $out;
		}
    }
}

new DTBookingReservationForm();