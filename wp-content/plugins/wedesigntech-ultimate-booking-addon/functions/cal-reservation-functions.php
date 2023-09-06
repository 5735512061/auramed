<?php

if(!function_exists('ultimate_booking_pro_month_available_times')) {
    function ultimate_booking_pro_month_available_times(){

        $staff     = ultimate_booking_pro_sanitization($_REQUEST['staff']);
        $staffid   = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
        $service   = ultimate_booking_pro_sanitization($_REQUEST['service']);
        $serviceid = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);
        $monthyear = ultimate_booking_pro_sanitization($_REQUEST['monthyear']);


        // Service Details
        $info             = get_post_meta( $serviceid, '_custom_settings', true);
        $info             = is_array($info) ? $info : array();
        $service_duration = array_key_exists('service-duration', $info) ? $info['service-duration'] :  1800;

        // Staff Details
        $meta_times = get_post_meta( $staffid, '_custom_settings', true);
		$timer 		= array_merge($meta_times['appointment_fs1'], $meta_times['appointment_fs2'], $meta_times['appointment_fs3'], $meta_times['appointment_fs4'], $meta_times['appointment_fs5'], $meta_times['appointment_fs6'], $meta_times['appointment_fs7']);
		$timer 		= array_filter($timer);
		$timer 		= array_diff( $timer, array('00:00'));

        $working_hours = $break_hours = array();
		foreach ( array('monday','tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') as $day ):
			if(  array_key_exists("ultimate_booking_pro_{$day}_start",$timer)  ):
				$working_hours[$day] = array(
					'start' => $timer["ultimate_booking_pro_{$day}_start"],
					'end'   => $timer["ultimate_booking_pro_{$day}_end"]
				);

				$break_hours[$day]   = array(
					'start' => $timer["ultimate_booking_pro_{$day}_break_start"],
					'end'   => $timer["ultimate_booking_pro_{$day}_break_end"]
				);
			endif;
		endforeach;

        // Staff existing bookings
		global $wpdb;

        $bookings = array();
		$q    = "SELECT option_value FROM $wpdb->options WHERE option_name LIKE '_dt_reservation_mid_{$staffid}%' ORDER BY option_id ASC";
		$rows = $wpdb->get_results( $q );
		if( $rows ) {
			foreach ($rows as $row ) {
				if( is_serialized($row->option_value ) ) {
					$data       = unserialize($row->option_value);

					$begintime  = $data['start'];
					$begintime  = explode("(", $begintime);

					$closetime  = $data['end'];
					$closetime  = explode("(", $closetime);

					$begintime  = new DateTime($begintime[0]);
					$closetime  = new DateTime($closetime[0]);
					$smins = ( $service_duration / 60 );

					for ( $i = $begintime; $i < $closetime; $i = $begintime->modify('+'.$smins.' minutes') ) {
						$breakTime  = $i->format('Y-m-d G:i:s');
						$bookings[] = $breakTime;
					}
				}
			}
		}

        // Find available dates
        $monthyear_split = explode('-', $monthyear);
        $month = $monthyear_split[1];
        $year = $monthyear_split[2];
        $no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $slots = array();
        if( count($working_hours) ){
            for($i = 1; $i <= $no_of_days; $i++) {

                $loopDate = $i.'-'.$month.'-'.$year;
                $date = new DateTime($loopDate);
				$date = $date->format('Y-m-d');

                $slot = ultimate_booking_pro_find_month_timeslot( $working_hours, $bookings, $date, $service_duration );
                if( $slot != '' ){
                    $slots[] = $slot;
                }

            }
		}

        echo json_encode(array(
            'availableDates' => $slots
        ));

        wp_die();

    }
    add_action( 'wp_ajax_ultimate_booking_pro_month_available_times', 'ultimate_booking_pro_month_available_times' );
    add_action( 'wp_ajax_nopriv_ultimate_booking_pro_month_available_times', 'ultimate_booking_pro_month_available_times' );
}

function ultimate_booking_pro_find_month_timeslot( $working_hours, $bookings, $date, $service_duration = 1800 ){

	$time_format = get_option('time_format');

	$timeslot = '';
	$dayofweek = date('l',strtotime($date));
	$dayofweek = strtolower($dayofweek);

	$is_date_today = ($date == date( 'Y-m-d', current_time( 'timestamp' ) ) );
	$current_time  = date( 'H:i:s', ceil( current_time( 'timestamp' ) / 900 ) * 900 );

	$past = ( $date <  date('Y-m-d') ) ? true : false;

	if( array_key_exists($dayofweek, $working_hours)  && !$past ){

		$working_start_time = ($is_date_today && $current_time > $working_hours[ $dayofweek ][ 'start' ]) ? $current_time : $working_hours[ $dayofweek ][ 'start' ];
		$working_end_time = $working_hours[ $dayofweek ][ 'end' ];

		$show = $is_date_today && ($current_time > $working_end_time) ? false : true;
		if( $show ) {

			$intersection = ultimate_booking_pro_findInterSec( $working_start_time,$working_hours[ $dayofweek ][ 'end' ],'00:00','23:59');

			for( $time = ultimate_booking_pro_string_to_time($intersection['start']); $time <= ( ultimate_booking_pro_string_to_time($intersection['end']) - $service_duration ); $time += $service_duration ){

				$value = $date.' '.date('G:i:s', $time);
				$end = $date.' '.date('G:i:s', ($time+$service_duration));

				if( !in_array($value, $bookings) ) { # if already booked in $time
                    $timeslot = $date;
				}
			}
		}
	}
	return $timeslot;
}


if(!function_exists('ultimate_booking_pro_cal_reserve_available_times')) {
    function ultimate_booking_pro_cal_reserve_available_times(){

        $date      = ultimate_booking_pro_sanitization($_REQUEST['date']);
        $staff     = ultimate_booking_pro_sanitization($_REQUEST['staff']);
        $staffid   = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
        $service   = ultimate_booking_pro_sanitization($_REQUEST['service']);
        $serviceid = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);

        $formatedDateStr = new DateTime($date);
        $formatedDate = $formatedDateStr->format('Y-m-d');

        $info             = get_post_meta( $serviceid, '_custom_settings', true);
        $info             = is_array($info) ? $info : array();
        $service_duration = array_key_exists('service-duration', $info) ? $info['service-duration'] :  1800;


		$meta_times = get_post_meta( $staffid, '_custom_settings', true);
		$timer 		= array_merge($meta_times['appointment_fs1'], $meta_times['appointment_fs2'], $meta_times['appointment_fs3'], $meta_times['appointment_fs4'], $meta_times['appointment_fs5'], $meta_times['appointment_fs6'], $meta_times['appointment_fs7']);
		$timer 		= array_filter($timer);
		$timer 		= array_diff( $timer, array('00:00'));

        $working_hours = $break_hours = array();
		foreach ( array('monday','tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') as $day ):
			if(  array_key_exists("ultimate_booking_pro_{$day}_start",$timer)  ):
				$working_hours[$day] = array(
					'start' => $timer["ultimate_booking_pro_{$day}_start"],
					'end'   => $timer["ultimate_booking_pro_{$day}_end"]
				);

				$break_hours[$day]   = array(
					'start' => $timer["ultimate_booking_pro_{$day}_break_start"],
					'end'   => $timer["ultimate_booking_pro_{$day}_break_end"]
				);
			endif;
		endforeach;

		#Staff existing bookings
		global $wpdb;

        $bookings = array();
		$q    = "SELECT option_value FROM $wpdb->options WHERE option_name LIKE '_dt_reservation_mid_{$staffid}%' ORDER BY option_id ASC";
		$rows = $wpdb->get_results( $q );
		if( $rows ) {
			foreach ($rows as $row ) {
				if( is_serialized($row->option_value ) ) {
					$data       = unserialize($row->option_value);

					$begintime  = $data['start'];
					$begintime  = explode("(", $begintime);

					$closetime  = $data['end'];
					$closetime  = explode("(", $closetime);

					$begintime  = new DateTime($begintime[0]);
					$closetime  = new DateTime($closetime[0]);
					$smins = ( $service_duration / 60 );

					for ( $i = $begintime; $i < $closetime; $i = $begintime->modify('+'.$smins.' minutes') ) {
						$breakTime  = $i->format('Y-m-d G:i:s');
						$bookings[] = $breakTime;
					}
				}
			}
		} #Staff existing bookings

        $slots = array();

        if( count($working_hours) ){
			$slot = ultimate_booking_pro_findTimeSlot2( $working_hours, $bookings, $formatedDate, $service_duration );
			if( !empty($slot) ){
				$slots[] = $slot;
			}
		}

        $slot_str = '';
        if( !empty($slots) ) {

			$sinfo = get_post_meta( $staffid , "_info",true);
			$sinfo = is_array($sinfo) ? $sinfo : array();

			$slot_str .= '<ul class="time-table">';
			foreach( $slots as $slot ){

				if( is_array($slot) ){
					foreach( $slot as $date => $s  ){
						$slot_str .= '<li>';

						$slot_str .= '<div class="dt-sc-title"><h5 class="staff-name">';
							$slot_str .= "{$staff}";
						$slot_str .= '</h5></div>';

						if(is_array($s)){
							$daydate = $date;
							$slot_str .= '<ul class="time-slots">';
							foreach( $s as $time ){
								$start = new DateTime($time->start);
								$start = $start->format( 'm/d/Y H:i');

								$end = new DateTime($time->end);
								$end = $end->format( 'm/d/Y H:i');

								$date =  new DateTime($time->date);
								$date = $date->format( 'm/d/Y');

								$slot_str .= '<li>';
									$slot_str .= "<a href='#' data-sid='{$staffid}' data-staffname='{$staff}' data-serviceid='{$serviceid}' data-start='{$start}' data-end='{$end}' data-date='{$date}' data-time='{$time->hours}' data-daydate='{$daydate}' class='time-slot'>";
										$slot_str .= $time->label;
									$slot_str .= '</a>';
								$slot_str .= '</li>';
							}
							$slot_str .= '</ul>';
						}
						$slot_str .= '</li>';
					}
				}
			}
			$slot_str .= "</ul>";
		}

        $out = '';
        $out .= '<h3>'.esc_html__('Available timings on ','wedesigntech-ultimate-booking-addon').$formatedDateStr->format('F d, Y').'</h3><div class="dt-sc-single-border-separator"></div><div class="dt-sc-hr-invisible-small"></div>';
        $out .= '<div class="available-times">';
        $out .= $slot_str;
        $out .= '</div>';

        echo $out;


        wp_die();

    }
    add_action( 'wp_ajax_ultimate_booking_pro_cal_reserve_available_times', 'ultimate_booking_pro_cal_reserve_available_times' );
    add_action( 'wp_ajax_nopriv_ultimate_booking_pro_cal_reserve_available_times', 'ultimate_booking_pro_cal_reserve_available_times' );
}


function ultimate_booking_pro_findTimeSlot3( $working_hours, $bookings, $date , $service_duration = 1800 ){

	$time_format = get_option('time_format');

	$timeslot= array();
	$dayofweek = date('l',strtotime($date));
	$dayofweek = strtolower($dayofweek);

	$is_date_today = ($date == date( 'Y-m-d', current_time( 'timestamp' ) ) );
	$current_time  = date( 'H:i:s', ceil( current_time( 'timestamp' ) / 900 ) * 900 );

	$past = ( $date <  date('Y-m-d') ) ? true : false;

	if( array_key_exists($dayofweek, $working_hours)  && !$past ){

		$working_start_time = ($is_date_today && $current_time > $working_hours[ $dayofweek ][ 'start' ]) ? $current_time : $working_hours[ $dayofweek ][ 'start' ];
		$working_end_time = $working_hours[ $dayofweek ][ 'end' ];

		$show = $is_date_today && ($current_time > $working_end_time) ? false : true;
		if( $show ) {

			$intersection = ultimate_booking_pro_findInterSec( $working_start_time,$working_hours[ $dayofweek ][ 'end' ],'00:00','23:59');

			for( $time = ultimate_booking_pro_string_to_time($intersection['start']); $time <= ( ultimate_booking_pro_string_to_time($intersection['end']) - $service_duration ); $time += $service_duration ){

				$value = $date.' '.date('G:i:s', $time);
				$end = $date.' '.date('G:i:s', ($time+$service_duration));

				if( !in_array($value, $bookings) ) { # if already booked in $time
					$object = new stdClass();
					$object->label = date( $time_format, $time );
					$object->date = $date;
					$object->start = $value;
					$object->hours = date('g:i A', $time).' - '.date('g:i A', ($time+$service_duration));
					$object->end = $end;
					$p = $date.' ('.date('l',strtotime($date)).')';
					$timeslot[$p][$time] = $object;
				}
			}
		}
	}
	return $timeslot;
}

?>