<?php
add_action( 'wp_ajax_ultimate_booking_pro_fill_staffs', 'ultimate_booking_pro_fill_staffs' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_fill_staffs','ultimate_booking_pro_fill_staffs'); # For logged-out users
function ultimate_booking_pro_fill_staffs() {
	if( isset($_REQUEST['service_id']) ){

		$service_id = ultimate_booking_pro_sanitization($_REQUEST['service_id']);

		if( ultimate_booking_pro_check_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
			global $sitepress;

			$default_lang = $sitepress->get_default_language();
			$current_lang = ICL_LANGUAGE_CODE;

			if( $default_lang != $current_lang ) {
				$service_id =  icl_object_id(  $service_id ,'dt_service', true ,$sitepress->get_default_language());
			}
		}

		$mata_query = array( array(
				'key'     => '_ultimate_booking_pro_staff_services',
				'value'   => $service_id,
				'compare' => 'LIKE' ) );

		$wp_query = new WP_Query();
		$staffs = array(
			'post_type' => 'dt_staff',
			'posts_per_page' => '-1',
			'meta_query' => $mata_query );

		$wp_query->query( $staffs );
		echo "<option value=''></option>";
		if( $wp_query->have_posts() ):
			while( $wp_query->have_posts() ):
				$wp_query->the_post();
				$id = get_the_ID();

				$pmeta = get_post_meta($id, '_custom_settings', true);
				$pmeta = is_array ( $pmeta ) ? $pmeta : array ();

				$pcost = '';
				if( array_key_exists('staff-price', $pmeta) ):
					$pcost = ' - '.ultimate_booking_pro_get_formatted_price( $pmeta['staff-price'] );
				endif;

				$title = get_the_title($id);

				if( has_post_thumbnail( $id ) ) {
					$post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'dt-bm-dropdown-staff', false );
					$image = $post_thumb[0];
				} else {
					$image = $popup = 'https://via.placeholder.com/60X60.jpg&text='.get_the_title( $id );
				}

				echo '<option value="'.$id.'" style="background-image:url(\''.$image.'\');">'.$title.$pcost.'</option>';
			endwhile;
		endif;
	}
	die( '' );
}

//appointment type2
add_action( 'wp_ajax_ultimate_booking_pro_generate_schedule', 'ultimate_booking_pro_generate_schedule' );
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_generate_schedule','ultimate_booking_pro_generate_schedule');
function ultimate_booking_pro_generate_schedule() {

	$seldate      = ultimate_booking_pro_sanitization($_REQUEST['datepicker']);
	$staffid      = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
	$staff        = get_the_title($staffid);
	$staffids_str = ultimate_booking_pro_sanitization($_REQUEST['staffids']);
	$serviceid    = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);
	$service      = get_the_title($serviceid);
	$staffs_arr   = array();

	if( empty( $staffid ) ) {
		$wp_query = new WP_Query();
		$staffs   = array( 'post_type' => 'dt_staff', 'orderby'=>'ID', 'order'=>'DESC', 'posts_per_page' => '-1', 'meta_query'=>array());

		if($staffids_str != '') {
			$staffids = explode(',', $staffids_str);
			$staffs['post__in'] = $staffids;
		}

		$staffs['meta_query'][] = array( 'key' => '_ultimate_booking_pro_staff_services', 'value' => $serviceid, 'compare' => 'LIKE');
		$wp_query->query( $staffs );
		if( $wp_query->have_posts() ):
			while( $wp_query->have_posts() ):
				$wp_query->the_post();

				$staffid     = get_the_ID();
				$staff       = get_the_title( $staffid );

				$staff_meta  = get_post_meta( $staffid, '_custom_settings', true);
				$staff_meta  = is_array($staff_meta) ? $staff_meta : array();
				$staff_price = array_key_exists('staff-price', $staff_meta) ? $staff_meta['staff-price'] : '';

				$staff = '<span class="name">'.$staff.'</span>';
				$staff = $staff.'<span class="price">'.ultimate_booking_pro_get_currency_symbol().$staff_price.'</span>';

				$staffs_arr[$staffid] = $staff;
			endwhile;
		endif;
		wp_reset_postdata();
	} else {
		$staff_meta  = get_post_meta( $staffid, '_custom_settings', true);
		$staff_meta  = is_array($staff_meta) ? $staff_meta : array();
		$staff_price = array_key_exists('staff-price', $staff_meta) ? $staff_meta['staff-price'] : '';

		$staff = '<span class="name">'.$staff.'</span>';
		$staff = $staff.'<span class="price">'.ultimate_booking_pro_get_currency_symbol().$staff_price.'</span>';

		$staffs_arr = array( $staffid => $staff );
	}

	$serviceinfo      = get_post_meta( $serviceid, '_custom_settings', true);
	$serviceinfo      = is_array($serviceinfo) ? $serviceinfo : array();
	$service_duration = array_key_exists('service-duration', $serviceinfo) ? $serviceinfo['service-duration'] :  1800;

    $slot_str = '';
	$out = '';
	$out .= '<h2>'.esc_html__('Select Time','wedesigntech-ultimate-booking-addon').'</h2><div class="dt-sc-single-border-separator"></div><div class="dt-sc-hr-invisible-small"></div>';
	$out .= '<div class="available-times">';

	$seldate = new DateTime($seldate);
	$seldate = $seldate->format('Y-m-d');

	foreach( $staffs_arr as $sid => $sname ) {

		#1. Get Staff Schedule Time
		$timer      = array();
		$meta_times = get_post_meta( $sid, '_custom_settings', true);
		$timer      = array_merge($meta_times['appointment_fs1'], $meta_times['appointment_fs2'], $meta_times['appointment_fs3'], $meta_times['appointment_fs4'], $meta_times['appointment_fs5'], $meta_times['appointment_fs6'], $meta_times['appointment_fs7']);
		$timer      = array_filter($timer);
		$timer      = array_diff( $timer, array('00:00'));

		$working_hours = array();

		foreach ( array('monday','tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') as $day ):
			if(  array_key_exists("ultimate_booking_pro_{$day}_start",$timer)  ):
				$working_hours[$day] = array( 'start' => $timer["ultimate_booking_pro_{$day}_start"] , 'end' => $timer["ultimate_booking_pro_{$day}_end"]);
			endif;
		endforeach;

		#Staff existing bookings
		$bookings = array();
		global $wpdb;
		$q = "SELECT option_value FROM $wpdb->options WHERE option_name LIKE '_dt_reservation_mid_{$sid}%' ORDER BY option_id ASC";
		//$rows = $wpdb->get_results( $wpdb->prepare($q) );
		$rows = $wpdb->get_results( $q );
		if( $rows ){
			foreach ($rows as $row ) {
				if( is_serialized($row->option_value ) ) {
					$data = unserialize($row->option_value);
					$data = $data['start'];
					$data = explode("(", $data);
					$data = new DateTime($data[0]);
					$data = $data->format("Y-m-d G:i:s");
					$bookings[] = $data;
				}
			}
		}
		#Staff existing bookings

		$slots = array();

		if( count($working_hours) ){
			$slot = ultimate_booking_pro_findTimeSlot2( $working_hours, $bookings, $seldate, $service_duration );
			if( !empty($slot) ){
				$slots[] = $slot;
			}
		}

		if( !empty($slots) ) {

			$sinfo = get_post_meta( $sid , "_info",true);
			$sinfo = is_array($sinfo) ? $sinfo : array();

			$slot_str .= '<ul class="time-table">';
			foreach( $slots as $slot ){

				if( is_array($slot) ){
					foreach( $slot as $date => $s  ){
						$slot_str .= '<li>';

						$slot_str .= '<div class="dt-sc-title"><h3 class="staff-name">';
							$slot_str .= "{$sname}";
						$slot_str .= '</h3></div>';

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
									$slot_str .= "<a href='#' data-staffid='{$sid}' data-staffname='{$sname}' data-serviceid='{$serviceid}' data-start='{$start}' data-end='{$end}' data-date='{$date}' data-time='{$time->hours}' data-daydate='{$daydate}' class='time-slot'>";
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
	} #Staffs loops end

	$out .= $slot_str;
	$out .= '</div>';

    if( empty($slot_str) ) {
		echo '<p class="dt-sc-info-box">'.sprintf( esc_html__( 'No Time slots available on the date you have chosen. %1$s to find slot in next day.', 'wedesigntech-ultimate-booking-addon' ), '<strong><a href="#" class="show-time-next">'. esc_html__('Click here', 'wedesigntech-ultimate-booking-addon') .'</a></strong>' ).'</p>';
    } else {
		echo "{$out}";
    }

	die();

}
//appointment type2

add_action( 'wp_ajax_ultimate_booking_pro_available_times', 'ultimate_booking_pro_available_times' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_available_times', 'ultimate_booking_pro_available_times' ); # For logged-out users
function ultimate_booking_pro_available_times(){

	$date      = ultimate_booking_pro_sanitization($_REQUEST['date']);
	$stime     = ultimate_booking_pro_sanitization($_REQUEST['stime']);
	$etime     = ultimate_booking_pro_sanitization($_REQUEST['etime']);
	$staff     = ultimate_booking_pro_sanitization($_REQUEST['staff']);
	$staffid   = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
	$service   = ultimate_booking_pro_sanitization($_REQUEST['service']);
	$serviceid = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);
	$mgs       = array();

	if( empty( $staffid ) ) {
		#Staff
		$wp_query               = new WP_Query();
		$staffs                 = array( 'post_type'=>'dt_staff', 'orderby'=>'ID','order'=>'DESC', 'posts_per_page'=>'-1', 'meta_query'=>array());
		$staffs['meta_query'][] = array( 'key' => '_ultimate_booking_pro_staff_services', 'value' => $serviceid ,'compare' => 'LIKE');

		$wp_query->query( $staffs );
		if( $wp_query->have_posts() ):
			while( $wp_query->have_posts() ):
				$wp_query->the_post();

				$staffid       = get_the_ID();
				$staff         = get_the_title( $staffid );

				// Append staff price here...
				$staff_meta  = get_post_meta( $staffid, '_custom_settings', true);
				$staff_meta  = is_array($staff_meta) ? $staff_meta : array();
				$staff_price = array_key_exists('staff-price', $staff_meta) ? $staff_meta['staff-price'] : '';

				$staff = '<span class="name">'.$staff.'</span>';
				$staff = $staff.'<span class="price">'.ultimate_booking_pro_get_currency_symbol().$staff_price.'</span>';

				$mgs[$staffid] = $staff;
			endwhile;
		endif;
		#Staff
	} else {
		$staff = explode( ' - ', $staff );
		$staff = '<span class="name">'.$staff[0].'</span>'.'<span class="price">'.$staff[1].'</span>';
		$mgs   = array( $staffid => $staff );
	}

	$info             = get_post_meta( $serviceid, '_custom_settings', true);
	$info             = is_array($info) ? $info : array();
	$service_duration = array_key_exists('service-duration', $info) ? $info['service-duration'] :  1800;

	$bookings = $working_hours = array();
	$out      = '';

	foreach( $mgs as $sid => $sname ) {

		#1. Get Staff Schedule Time
		$timer 		= array();
		$meta_times = get_post_meta( $sid, '_custom_settings', true);
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

		$q    = "SELECT option_value FROM $wpdb->options WHERE option_name LIKE '_dt_reservation_mid_{$sid}%' ORDER BY option_id ASC";
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
						$breakTime  = $i->format('Y-m-d H:i:s');
						$bookings[] = $breakTime;
					}
				}
			}
		} #Staff existing bookings

		$slots = array();

		if( count($working_hours) ) {
			$loop = 7;
			$i    = 0;

			while( $i < $loop ) {
				$slot = ultimate_booking_pro_findTimeSlot( $working_hours, $bookings, $break_hours, $date , $service_duration );
				if( !empty($slot) ){
					$slots[] = $slot;
				}
				$date = new DateTime($date);
				$date->modify("+1 day");
				$date = $date->format('Y-m-d');
				$i++;
			}
		}

		if( !empty($slots) ) {
			$out .= "<div class='dt-sc-title'><h3>";
			$out .= "{$sname}";
			$out .= "</h3></div>";
			$out .= "<div class='time-table-wrap'><ul class='time-table'>";
			foreach( $slots as $slot ){
				if( is_array($slot) ){
					foreach( $slot as $date => $s  ){
						$out .= "<li> <div class='time-head'> {$sname} {$date} </div>";
						if(is_array($s)){
							$out .= "<ul class='time-slots' >";
							foreach( $s as $time ){
								$start = new DateTime($time->start);
								$start = $start->format( 'm/d/Y H:i');

								$end = new DateTime($time->end);
								$end = $end->format( 'm/d/Y H:i');

								$date =  new DateTime($time->date);
								$date = $date->format( 'm/d/Y');

								$out .= '<li>';
								$out .= "<a href='#' data-sid='{$sid}' data-start='{$start}' data-end='{$end}' data-date='{$date}' data-time='{$time->hours}' class='time-slot'>";
								$out .= $time->label;
								$out .= '</a>';
								$out .= '</li>';
							}
							$out .= '</ul>';
						}
						$out .= '</li>';
					}
				}
			}
			$out .= "</ul></div>";
		}
	} #Staffs loops end

	if( empty($out) ) {
		echo '<p class="dt-sc-info-box">'.sprintf( esc_html__( 'No Time slots available for next 7 days from the date you have chosen. %1$s to find slots in next week.', 'wedesigntech-ultimate-booking-addon' ), '<strong><a href="#" class="show-time-next">'. esc_html__('Click here', 'wedesigntech-ultimate-booking-addon') .'</a></strong>' ).'</p>';
    } else {
        echo '<p class="dt-sc-info-box">'.esc_html__('Showing result for next 7 days from the date you have chosen.','wedesigntech-ultimate-booking-addon').'</p>';
		echo "{$out}";
    }

	die('');
}

add_action( 'wp_ajax_ultimate_booking_pro_total_cost', 'ultimate_booking_pro_total_cost' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_total_cost', 'ultimate_booking_pro_total_cost' ); # For logged-out users
function ultimate_booking_pro_total_cost() {

	$staffid   = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
	$serviceid = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);

	$info           = get_post_meta( $serviceid, '_custom_settings', true );
	$info           = is_array( $info ) ? $info : array();
	$service_price 	= array_key_exists('service-price', $info) ? $info['service-price'] : 0;

	$info           = get_post_meta( $staffid, '_custom_settings', true );
	$info           = is_array( $info ) ? $info : array();
	$staff_price 	= array_key_exists('staff-price', $info) ? $info['staff-price'] : 0;

	echo '<i>'.esc_html__('Total:', 'wedesigntech-ultimate-booking-addon').'</i><i>'.ultimate_booking_pro_get_currency_symbol().' '.sprintf( "%.2f", ($service_price + $staff_price) ).'</i>';

	die('');
}

function ultimate_booking_pro_findTimeSlot( $working_hours, $bookings, $break_hours, $date , $service_duration = 1800 ){

	$time_format = get_option('time_format');

	$timeslot  = $breakArr = array();
	$dayofweek = date('l',strtotime($date));
	$dayofweek = strtolower($dayofweek);

	$is_date_today = ($date == date( 'Y-m-d', current_time( 'timestamp' ) ) );
	$current_time  = date( 'H:i:s', ceil( current_time( 'timestamp' ) / 900 ) * 900 );

	$past = ( $date <  date('Y-m-d') ) ? true : false;

	if( array_key_exists($dayofweek, $working_hours)  && !$past ){

		$working_start_time = ($is_date_today && $current_time > $working_hours[ $dayofweek ][ 'start' ]) ? $current_time : $working_hours[ $dayofweek ][ 'start' ];
		$working_end_time   = $working_hours[ $dayofweek ][ 'end' ];

		$show = $is_date_today && ($current_time > $working_end_time) ? false : true;
		if( $show ) {

			$intersection = ultimate_booking_pro_findInterSec( $working_start_time, $working_hours[ $dayofweek ][ 'end' ],ultimate_booking_pro_sanitization($_REQUEST['stime']),ultimate_booking_pro_sanitization($_REQUEST['etime']));

			if( isset( $break_hours[$dayofweek]['start'] ) && $break_hours[$dayofweek]['start'] != '' ) {
				$sbreak = date_create_from_format( 'Y-m-d H:i', $date.' '.$break_hours[$dayofweek]['start'] );
				$sbreak = $sbreak->format('Y-m-d H:i:s');
				$sbreak = strtotime( $sbreak ) - $service_duration;

				$sbreak = gmdate("Y-m-d H:i:s", $sbreak);
				$sbreak = date_create_from_format( 'Y-m-d H:i:s', $sbreak );
				$ebreak = date_create_from_format( 'Y-m-d H:i', $date.' '.$break_hours[$dayofweek]['end'] );

				for ( $i = $sbreak; $i <= $ebreak; $i = $sbreak->modify('+15 minutes') ) {
					$breakTime  = $i->format('Y-m-d H:i:s');
					$breakArr[] = $breakTime;
				}
			}

			for( $time = ultimate_booking_pro_string_to_time($intersection['start']); $time <= ( ultimate_booking_pro_string_to_time($intersection['end']) - $service_duration ); $time += $service_duration ){

				$value = $date.' '.date('H:i:s', $time);
				$end   = $date.' '.date('H:i:s', ($time + $service_duration));

				if( !in_array($value, $bookings) && !in_array($value, $breakArr) ) { # if already booked in $time
					$object              = new stdClass();
					$object->label       = date( $time_format, $time );
					$object->date        = $date;
					$object->start       = $value;
					$object->hours       = date('g:i A', $time).' - '.date('g:i A', ($time + $service_duration));
					$object->end         = $end;
					$translatable_day    = ultimate_booking_pro_translatableDay( date('l',strtotime($date)) );
					$p                   = '<span>'.$date.'</span><span>('.$translatable_day.')</span>';
					$timeslot[$p][$time] = $object;
				}
			}
		}
	}

	return $timeslot;
}

//appointment type2
function ultimate_booking_pro_findTimeSlot2( $working_hours, $bookings, $date , $service_duration = 1800 ){

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
//appointment type2

function ultimate_booking_pro_translatableDay( $day ) {

	switch( $day ):
		case 'Sunday':
			$day = esc_html__('Sunday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Monday':
			$day = esc_html__('Monday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Tuesday':
			$day = esc_html__('Tuesday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Wednesday':
			$day = esc_html__('Wednesday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Thursday':
			$day = esc_html__('Thursday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Friday':
			$day = esc_html__('Friday','wedesigntech-ultimate-booking-addon');
		break;

		case 'Saturday':
			$day = esc_html__('Saturday','wedesigntech-ultimate-booking-addon');
		break;
	endswitch;

	return $day;
}

function ultimate_booking_pro_findInterSec( $p1_start, $p1_end, $p2_start, $p2_end ) {

	$result = false;
	if ( $p1_start <= $p2_start && $p1_end >= $p2_start && $p1_end <= $p2_end ) {
		$result = array( 'start' => $p2_start, 'end' => $p1_end );
	} else if ( $p1_start <= $p2_start && $p1_end >= $p2_end ) {
		$result = array( 'start' => $p2_start, 'end' => $p2_end );
	} else if ( $p1_start >= $p2_start && $p1_start <= $p2_end && $p1_end >= $p2_end ) {
		$result = array( 'start' => $p1_start, 'end' => $p2_end );
	} else if ( $p1_start >= $p2_start && $p1_end <= $p2_end ) {
		$result = array( 'start' => $p1_start, 'end' => $p1_end );
    }
	return $result;
}

#Front End - tpl-reservation ajax
function ultimate_booking_pro_customer( $userid, $name, $lname, $address, $country, $city, $state, $pincode, $phone, $email, $notes ) {

	// Existing Customer
	if( is_user_logged_in() && $userid != '' ) {

		$args = array(
		    'post_type'  => 'dt_customers',
		    'order'      => 'ASC',
		    'meta_query' => array(
		    	'relation' => 'AND',
		    	array(
		    		'relation' => 'OR',
			        array(
			            'key'     => '_info',
			            'value'   => serialize( strval( $userid ) ), // "s:1:"2";"
			            'compare' => 'LIKE',
			        ),
			        array(
			            'key'     => '_info',
			            'value'   => serialize( intval( $userid ) ), // "i:"2";"
			            'compare' => 'LIKE',
			        ),
		    	),
		        array(
		            'key'     => '_info',
		            'value'   => serialize( strval( $email ) ),
		            'compare' => 'LIKE',
		        ),
		    ),
		);

		$query = new WP_Query( $args );
		if( $query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();

				$ID          = get_the_ID();
				$customer_id = $ID;
			}
		} else {

			$post_id = wp_insert_post( array('post_title' => $name.' '.$lname, 'post_type' => 'dt_customers', 'post_status' => 'publish') );
			if( $post_id > 0 ) {

				$info['firstname']        = $name;
				$info['lastname']         = $lname;
				$info['address']          = $address;
				$info['country']          = $country;
				$info['city']             = $city;
				$info['state']            = $state;
				$info['pincode']          = $pincode;
				$info['phone']            = $phone;
				$info['emailid']          = $email;
				$info['aboutyourproject'] = $notes;
				$info['customer_id']      = $userid;

				$customer_id       		  = $post_id;

				update_post_meta ( $post_id, '_info', $info );
			}
		}
		wp_reset_postdata($query);

	  // New Customer
	} elseif( ! is_user_logged_in() ) {

		$user_data = array(
			'user_login' => strtolower($name).'.'.strtolower($lname),
			'user_email' => $email,
			'first_name' => $name,
			'last_name'  => $lname,
			'role' 		 => 'subscriber'
		);

		$user_id = wp_insert_user( wp_slash( $user_data ) );
		if ( ! is_wp_error( $user_id ) ) {

			$user_info['address'] = $address;
			$user_info['country'] = $country;
			$user_info['city']    = $city;
			$user_info['state']   = $state;
			$user_info['pincode'] = $pincode;
			$user_info['phone']   = $phone;

			wp_update_user( array ('ID' => $user_id, 'role' => 'subscriber') ) ;
			update_user_meta( $user_id, 'user_info', $user_info );

            wp_clear_auth_cookie();
            wp_set_current_user ( $user_id );
            wp_set_auth_cookie ( $user_id );
		} else {
			$user    = get_user_by( 'email', $email );
			$user_id = $user->ID;

            wp_clear_auth_cookie();
            wp_set_current_user ( $user_id );
            wp_set_auth_cookie ( $user_id );
		}

		$post_id = wp_insert_post( array('post_title' => $name.' '.$lname, 'post_type' => 'dt_customers', 'post_status' => 'publish') );
		if( $post_id > 0 ) {

			$info['firstname']        = $name;
			$info['lastname']         = $lname;
			$info['address']          = $address;
			$info['country']          = $country;
			$info['city']             = $city;
			$info['state']            = $state;
			$info['pincode']          = $pincode;
			$info['phone']            = $phone;
			$info['emailid']          = $email;
			$info['aboutyourproject'] = $notes;
			$info['customer_id']      = ! is_wp_error( $user_id ) ? $user_id : '';

			$customer_id        	  = $post_id;

			update_post_meta ( $post_id, '_info', $info );
		}
	}

	return $customer_id;
}

//appointment type2
function ultimate_booking_pro_customer2( $customer ){

	$user = $customer;
	$users = array();

	$wp_query = new WP_Query();
	$customers = array('post_type'=>'dt_customers','posts_per_page'=>-1,'order_by'=>'published');

		$wp_query->query($customers);
		if( $wp_query->have_posts() ):
			while( $wp_query->have_posts() ):
				$wp_query->the_post();
				$the_id = get_the_ID();
				$title = get_the_title($the_id);

				$info = get_post_meta ( $the_id, "_info",true);
				$info = is_array($info) ? $info : array();
				$info['name'] = $title;
				$users[$the_id] = $info;
			endwhile;
		endif;

	$uid = array_search( $user, $users);

	if( $uid  ){
		$uid = $uid;
	} else {
		#Insert new customer
		$post_id = wp_insert_post( array('post_title' => $user['firstname'].' '.$user['lastname'], 'post_type' => 'dt_customers', 'post_status' => 'publish'));
		if( $post_id > 0 ) {
			$info['firstname'] = $user['firstname'];
			$info['lastname'] = $user['lastname'];
			$info['phone'] = $user['phone'];
			$info['emailid'] = $user['emailid'];
			$info['address'] = $user['address'];
			$info['aboutyourproject'] = $user['aboutyourproject'];
			update_post_meta ($post_id, "_info", $info);
			$uid = $post_id;
		}
	}
	return $uid;
}
//appointment type2

add_action( 'wp_ajax_ultimate_booking_pro_returnurl_request', 'ultimate_booking_pro_returnurl_request' );
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_returnurl_request', 'ultimate_booking_pro_returnurl_request' );
function ultimate_booking_pro_returnurl_request(){

	$return_url = add_query_arg( array(
		'services'   => ultimate_booking_pro_sanitization($_REQUEST['service']),
		'staff'      => ultimate_booking_pro_sanitization($_REQUEST['staff']),
		'date'       => ultimate_booking_pro_sanitization($_REQUEST['date']),
		'start-time' => ultimate_booking_pro_sanitization($_REQUEST['start']),
		'end-time'   => ultimate_booking_pro_sanitization($_REQUEST['end']),
    ), ultimate_booking_pro_sanitization($_REQUEST['url']) );

	echo "{$return_url}";
	die('');
}

add_action( 'wp_ajax_ultimate_booking_pro_new_reservation', 'ultimate_booking_pro_new_reservation' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_new_reservation','ultimate_booking_pro_new_reservation'); # For logged-out users
function ultimate_booking_pro_new_reservation(){
	global $wpdb;

	#New Customer
	$userid  = ultimate_booking_pro_sanitization($_REQUEST['userid']);
	$name    = ultimate_booking_pro_sanitization($_REQUEST['name']);
	$lname   = ultimate_booking_pro_sanitization($_REQUEST['lname']);
	$address = ultimate_booking_pro_sanitization($_REQUEST['address']);
	$country = ultimate_booking_pro_sanitization($_REQUEST['country']);
	$city    = ultimate_booking_pro_sanitization($_REQUEST['city']);
	$state   = ultimate_booking_pro_sanitization($_REQUEST['state']);
	$pincode = ultimate_booking_pro_sanitization($_REQUEST['pincode']);
	$phone   = ultimate_booking_pro_sanitization($_REQUEST['phone']);
	$email   = ultimate_booking_pro_sanitization($_REQUEST['email']);
	$body    = ultimate_booking_pro_sanitization($_REQUEST['body']);

	$customer = ultimate_booking_pro_customer( $userid, $name, $lname, $address, $country, $city, $state, $pincode, $phone, $email, $body );

	$id    = $wpdb->get_var("SELECT max(option_id) FROM $wpdb->options");
	$title = esc_html__("New Reservation By ",'wedesigntech-ultimate-booking-addon').$name;

	$staff   = ultimate_booking_pro_sanitization($_REQUEST['staff']);
	$service = ultimate_booking_pro_sanitization($_REQUEST['service']);
	if( ultimate_booking_pro_check_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
		global $sitepress;

		$default_lang = $sitepress->get_default_language();
		$current_lang = ICL_LANGUAGE_CODE;

		if( $default_lang != $current_lang ) {
			$service =  icl_object_id(  $service ,'dt_services', true ,$sitepress->get_default_language());
		}
	}

	$start = ultimate_booking_pro_sanitization($_REQUEST['start']);
	$end   = ultimate_booking_pro_sanitization($_REQUEST['end']);

	$option = "_dt_reservation_mid_{$staff}_id_{$id}";
	$data = array( 'id' => $id, 'title' => $title, 'body' => $body, 'start'=> $start, 'end'=>$end, 'service'=>$service, 'user'=>$customer, 'readOnly'=>true );

	#Sending Mail
	$client_name = $client_phone = $client_email = $amount = "";

	#Staff
	$staff_name   = get_the_title($staff);
	$service_name = get_the_title($service);

	$sinfo       = get_post_meta( $staff , '_custom_settings', true);
	$sinfo       = is_array($sinfo) ? $sinfo : array();
	$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
	$staff_price = floatval($staff_price);

	#Service Price
	if( !empty( $data['service']) ){
		$serviceinfo   = get_post_meta($data['service'], '_custom_settings', true );
		$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
		$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
		$service_price = floatval($service_price);
	}

	$amount = ( ($staff_price+$service_price) > 0 ) ? ultimate_booking_pro_get_currency_symbol().' '.( $staff_price + $service_price ) : $amount;

	#Client
	if( !empty($data['user']) ){
		$client_name  = get_the_title($data['user']);
		$cinfo        = get_post_meta( $data['user'], "_info",true);
		$cinfo        = is_array($cinfo) ? $cinfo : array();
		$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
		$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";;
	}

	#Admin
	$user_info   = get_userdata(1);
	$admin_name  = $user_info->nickname;
	$admin_email = $user_info->user_email;

	$array = array(
		'admin_name'        => $admin_name,
		'staff_name'        => $staff_name,
		'service_name'      => $service_name,
		'appointment_id'    => $data['id'],
		'appointment_time'  => ultimate_booking_pro_sanitization($_POST['time']),
		'appointment_date'  => ultimate_booking_pro_sanitization($_POST['date']),
		'appointment_title' => $data['title'],
		'appointment_body'  => $data['body'],
		'client_name'       => $client_name,
		'client_phone'      => $client_phone,
		'client_email'      => $client_email,
		'amount'            => $amount,
		'company_logo'      => 'Company Logo',
		'company_name'      => 'Company Name',
		'company_phone'     => 'Company Phone',
		'company_address'   => 'Company Address',
		'company_website'   => 'Company Website');

	#Admin Mail
	$subject = cs_get_option('appointment_notification_to_admin_subject');
	$subject = ultimate_booking_pro_replace( $subject, $array);

	$message = cs_get_option('appointment_notification_to_admin_message' );
	$message = ultimate_booking_pro_replace( $message, $array);
	ultimate_booking_pro_send_mail( $admin_email, $subject, $message);

	#Staff Mail
	$subject = cs_get_option('appointment_notification_to_staff_subject');
	$subject = ultimate_booking_pro_replace( $subject, $array);

	$message = cs_get_option('appointment_notification_to_staff_message');
	$message = ultimate_booking_pro_replace( $message, $array);
	ultimate_booking_pro_send_mail( $sinfo['staff-email'], $subject, $message);

	#Client Mail
	if( !empty($client_email) ) {
		$subject = cs_get_option('appointment_notification_to_client_subject');
		$subject = ultimate_booking_pro_replace( $subject, $array);

		$message = cs_get_option('appointment_notification_to_client_message');
		$message = ultimate_booking_pro_replace( $message, $array);

		ultimate_booking_pro_send_mail( $client_email, $subject, $message);
	}

	#Sending Mail
	if( update_option( $option, $data ) ){

		$post_id = wp_insert_post( array('post_title' => 'Pay #'.$id, 'post_type' => 'dt_payments', 'post_status' => 'publish') );
		if( $post_id > 0 ) {

			$info['order_date']       = date('Y-m-d H:i:s');
			$info['order_type']       = 'local';
			$info['order_service']    = get_the_title($data['service']);
			$info['order_amount']     = $amount;

			$info['firstname']        = $name;
			$info['lastname']         = $lname;
			$info['address']          = $address;
			$info['country']          = $country;
			$info['city']             = $city;
			$info['state']            = $state;
			$info['pincode']          = $pincode;
			$info['phone']            = $phone;
			$info['emailid']          = $email;
			$info['aboutyourproject'] = $body;
			$info['customer_id']      = $data['user'];

			update_post_meta ( $post_id, '_info', $info );
		}

		$url           = !empty( cs_get_option('appointment-pageid') ) ? get_page_link( cs_get_option('appointment-pageid') ) : home_url();
		$url           = add_query_arg( array('action'=>'success'), $url );
		$result['url'] =  $url;
		echo json_encode( $result );
	} else {
		echo "Failed";
	}
	die('');
}

add_action( 'wp_ajax_ultimate_booking_pro_paypal_request', 'ultimate_booking_pro_paypal_request' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_paypal_request','ultimate_booking_pro_paypal_request'); # For logged-out users
function ultimate_booking_pro_paypal_request() {
	global $wpdb;

	#New Customer
	$userid  = ultimate_booking_pro_sanitization($_REQUEST['userid']);
	$name    = ultimate_booking_pro_sanitization($_REQUEST['name']);
	$lname   = ultimate_booking_pro_sanitization($_REQUEST['lname']);
	$address = ultimate_booking_pro_sanitization($_REQUEST['address']);
	$country = ultimate_booking_pro_sanitization($_REQUEST['country']);
	$city    = ultimate_booking_pro_sanitization($_REQUEST['city']);
	$state   = ultimate_booking_pro_sanitization($_REQUEST['state']);
	$pincode = ultimate_booking_pro_sanitization($_REQUEST['pincode']);
	$phone   = ultimate_booking_pro_sanitization($_REQUEST['phone']);
	$email   = ultimate_booking_pro_sanitization($_REQUEST['email']);
	$body    = ultimate_booking_pro_sanitization($_REQUEST['body']);

	$customer = ultimate_booking_pro_customer( $userid, $name, $lname, $address, $country, $city, $state, $pincode, $phone, $email, $body );

	$id    = $wpdb->get_var("SELECT max(option_id) FROM $wpdb->options");
	$title = esc_html__("New Reservation By ",'wedesigntech-ultimate-booking-addon').$name;

	$staff   = ultimate_booking_pro_sanitization($_REQUEST['staff']);
	$service = ultimate_booking_pro_sanitization($_REQUEST['service']);
	if( ultimate_booking_pro_check_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
		global $sitepress;

		$default_lang = $sitepress->get_default_language();
		$current_lang = ICL_LANGUAGE_CODE;

		if( $default_lang != $current_lang ) {
			$service =  icl_object_id(  $service ,'dt_services', true ,$sitepress->get_default_language());
		}
	}
	$start   = ultimate_booking_pro_sanitization($_REQUEST['start']);
	$end     = ultimate_booking_pro_sanitization($_REQUEST['end']);

	$option = "_dt_reservation_mid_{$staff}_id_{$id}";
	$data 	= array( 'id' => $id, 'title' => $title, 'body' => $body, 'start'=> $start, 'end'=>$end, 'service'=>$service, 'user'=>$customer, 'readOnly'=>true );

	$data['firstname']        = $name;
	$data['lastname']         = $lname;
	$data['address']          = $address;
	$data['country']          = $country;
	$data['city']             = $city;
	$data['state']            = $state;
	$data['pincode']          = $pincode;
	$data['phone']            = $phone;
	$data['emailid']          = $email;

	#Amount Calculation
	$sinfo       = get_post_meta( $staff , '_custom_settings', true);
	$sinfo       = is_array($sinfo) ? $sinfo : array();
	$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
	$staff_price = floatval($staff_price);

	$serviceinfo   = get_post_meta($data['service'], '_custom_settings', true );
	$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
	$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
	$service_price = floatval($service_price);
	$amount        = ($staff_price+$service_price);
	#Amount Calculation

	#Paypal
	if( update_option( $option, $data ) ) {

		$mode          = cs_get_option('enable-paypal-live') ? "" : ".sandbox";
		$uname         = cs_get_option('paypal-username');
		$currency_code = cs_get_option('book-currency');

		$url = add_query_arg( array(
			'cmd'           => '_xclick',
			'item_name'     => esc_html__("Service :",'wedesigntech-ultimate-booking-addon').' '.get_the_title($service).' - '. esc_html__("Time :",'wedesigntech-ultimate-booking-addon').ultimate_booking_pro_sanitization($_REQUEST['date']).'('.ultimate_booking_pro_sanitization($_REQUEST['time']).')',
			'item_number'   => $option,
			'business'      => $uname,
			'currency_code' => $currency_code,
			'amount'        => $amount,
			'return'        => add_query_arg( array( 'action'=>'dt_paypal_return', 'res'=>$option ), home_url('/') ),
			'cancel_return' => add_query_arg( array( 'action'=>'dt_paypal_cancel', 'res'=>$option ), home_url('/') )

		), 'https://www'.$mode.'.paypal.com/cgi-bin/webscr' );

		$result['url'] = $url;
		echo json_encode( $result );
	}

	die('');
}
#Paypal Express Checkout End

add_action( 'wp_loaded', 'ultimate_booking_pro_paypal_listener' ); # Paypal ExpressCheckout redirect
function ultimate_booking_pro_paypal_listener() {

	if( isset( $_GET['action'] ) ) {
		switch ( $_GET['action'] ) {

			case 'dt_paypal_cancel':
				$args = array('action','res');
				delete_option(ultimate_booking_pro_sanitization($_GET['res']));
				$url  = get_page_link( cs_get_option('appointment-pageid') );
				$url  = add_query_arg( array( 'action' => 'error' ) , $url );
				wp_safe_redirect($url);
				exit;
			break;

			case 'dt_paypal_return':
				#if( isset( $_REQUEST['st'] ) && ( $_REQUEST['st'] == 'Completed' ) ) {
					$reservation  = get_option(ultimate_booking_pro_sanitization($_REQUEST['item_number']));

					$staff        = explode("_",ultimate_booking_pro_sanitization($_REQUEST['item_number']));
					$staff_name   = get_the_title($staff[4]);
					$service_name = get_the_title($reservation['service']);
					$start        = new DateTime($reservation['start']);
					$end          = new DateTime($reservation['end']);
					$date         = date_format($start, "Y/m/d");
					$time         = date_format($start,"g:i a").' - '.date_format($end,"g:i a");

					$client_name  = get_the_title($reservation['user']);
					$cinfo        = get_post_meta( $reservation['user'], "_info",true);
					$cinfo        = is_array($cinfo) ? $cinfo : array();
					$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
					$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";

					#Staff Price
					$sinfo       = get_post_meta( $staff[4] , '_custom_settings', true);
					$sinfo       = is_array($sinfo) ? $sinfo : array();
					$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
					$staff_price = floatval($staff_price);

					#Service Price
					$serviceinfo   = get_post_meta($reservation['service'],'_custom_settings',true );
					$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
					$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
					$service_price = floatval($service_price);

					$amount = ( ($staff_price+$service_price) > 0 ) ? ( $staff_price+$service_price ) : "";

					$currency_code = cs_get_option('book-currency');
					$amount        = !empty( $amount ) ? $currency_code . $amount.' ['.ultimate_booking_pro_sanitization($_REQUEST['st']).']' : '';

					#Admin
					$user_info   = get_userdata(1);
					$admin_name  = $user_info->nickname;
					$admin_email = $user_info->user_email;

					$array = array(
						'admin_name'        => $admin_name,
						'admin_email'       => $admin_email,
						'staff_name'        => $staff_name,
						'service_name'      => $service_name,
						'appointment_id'    => $reservation['id'],
						'appointment_time'  => $time,
						'appointment_date'  => $date,
						'appointment_title' => $reservation['title'],
						'appointment_body'  => $reservation['body'],
						'client_name'       => $client_name,
						'client_phone'      => $client_phone,
						'client_email'      => $client_email,
						'amount'            => $amount,
						'company_logo'      => 'Company Logo',
						'company_name'      => 'Company Name',
						'company_phone'     => 'Company Phone',
						'company_address'   => 'Company Address',
						'company_website'   => 'Company Website');

					#Admin Mail
					$subject = cs_get_option('appointment_notification_to_admin_subject');
					$subject = ultimate_booking_pro_replace( $subject, $array);

					$message = cs_get_option('appointment_notification_to_admin_message' );
					$message = ultimate_booking_pro_replace( $message, $array);

					ultimate_booking_pro_send_mail( $admin_email, $subject, $message);

					#Staff Mail
					$subject = cs_get_option('appointment_notification_to_staff_subject');
					$subject = ultimate_booking_pro_replace( $subject, $array);

					$message = cs_get_option('appointment_notification_to_staff_message' );
					$message = ultimate_booking_pro_replace( $message, $array);

					ultimate_booking_pro_send_mail( $sinfo['staff-email'], $subject, $message);

					#Customer Mail
					$subject = cs_get_option('appointment_notification_to_client_subject');
					$subject = ultimate_booking_pro_replace( $subject, $array);

					$message = cs_get_option('appointment_notification_to_client_message' );
					$message = ultimate_booking_pro_replace( $message, $array);

					ultimate_booking_pro_send_mail( $client_email, $subject, $message);

					#Add Payment Details to options table
					$order   = explode('_', ultimate_booking_pro_sanitization($_REQUEST['item_number']));
					$post_id = wp_insert_post( array('post_title' => 'Pay #'.$order[6], 'post_type' => 'dt_payments', 'post_status' => 'publish') );
					if( $post_id > 0 ) {

						$info['order_date']       = date('Y-m-d H:i:s');
						$info['order_type']       = 'paypal';
						$info['order_service']    = get_the_title($reservation['service']);
						$info['order_amount']     = ultimate_booking_pro_get_currency_symbol().' '.urldecode( ultimate_booking_pro_sanitization($_REQUEST['amt']));
						$info['order_status']     = ultimate_booking_pro_sanitization($_REQUEST['st']);
						$info['order_transid']    = ultimate_booking_pro_sanitization($_REQUEST['tx']);

						$info['firstname']        = $reservation['firstname'];
						$info['lastname']         = $reservation['lastname'];
						$info['address']          = $reservation['address'];
						$info['country']          = $reservation['country'];
						$info['city']             = $reservation['city'];
						$info['state']            = $reservation['state'];
						$info['pincode']          = $reservation['pincode'];
						$info['phone']            = $reservation['phone'];
						$info['emailid']          = $reservation['emailid'];
						$info['aboutyourproject'] = $reservation['body'];
						$info['customer_id']      = $reservation['user'];

						update_post_meta ( $post_id, '_info', $info );
					}

					$url = !empty( cs_get_option('appointment-pageid') ) ? get_page_link( cs_get_option('appointment-pageid') ) : home_url();
					$url = add_query_arg( array( 'action' => 'success' ) , $url );

					wp_safe_redirect($url);
					exit();
				#} # st == Completed
			break;
		}
	}
}

add_action( 'wp_ajax_ultimate_booking_pro_stripe_request', 'ultimate_booking_pro_stripe_request' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_stripe_request','ultimate_booking_pro_stripe_request'); # For logged-out users
function ultimate_booking_pro_stripe_request() {
	global $wpdb;

	require_once( ultimate_booking_pro()->plugin_path( 'reservation/payments/stripe-php/init.php' ) );

	\Stripe\Stripe::setAppInfo( 'Ultimate Booking Pro', '1.1.0', 'https://ultimatebm.wpengine.com/' );
	\Stripe\Stripe::setApiVersion( '2020-03-20' );

	#New Customer
	$userid  = ultimate_booking_pro_sanitization($_REQUEST['userid']);
	$name    = ultimate_booking_pro_sanitization($_REQUEST['name']);
	$lname   = ultimate_booking_pro_sanitization($_REQUEST['lname']);
	$address = ultimate_booking_pro_sanitization($_REQUEST['address']);
	$country = ultimate_booking_pro_sanitization($_REQUEST['country']);
	$city    = ultimate_booking_pro_sanitization($_REQUEST['city']);
	$state   = ultimate_booking_pro_sanitization($_REQUEST['state']);
	$pincode = ultimate_booking_pro_sanitization($_REQUEST['pincode']);
	$phone   = ultimate_booking_pro_sanitization($_REQUEST['phone']);
	$email   = ultimate_booking_pro_sanitization($_REQUEST['email']);
	$body    = ultimate_booking_pro_sanitization($_REQUEST['body']);

	$customer = ultimate_booking_pro_customer( $userid, $name, $lname, $address, $country, $city, $state, $pincode, $phone, $email, $body );

	$id    = $wpdb->get_var("SELECT max(option_id) FROM $wpdb->options");
	$title = esc_html__("New Reservation By ",'wedesigntech-ultimate-booking-addon').$name;

	$staff   = ultimate_booking_pro_sanitization($_REQUEST['staff']);
	$service = ultimate_booking_pro_sanitization($_REQUEST['service']);
	if( ultimate_booking_pro_check_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
		global $sitepress;

		$default_lang = $sitepress->get_default_language();
		$current_lang = ICL_LANGUAGE_CODE;

		if( $default_lang != $current_lang ) {
			$service =  icl_object_id(  $service ,'dt_services', true ,$sitepress->get_default_language());
		}
	}
	$start   = ultimate_booking_pro_sanitization($_REQUEST['start']);
	$end     = ultimate_booking_pro_sanitization($_REQUEST['end']);

	$option = "_dt_reservation_mid_{$staff}_id_{$id}";
	$data 	= array( 'id' => $id, 'title' => $title, 'body' => $body, 'start'=> $start, 'end'=>$end, 'service'=>$service, 'user'=>$customer, 'readOnly'=>true );

	$data['firstname']        = $name;
	$data['lastname']         = $lname;
	$data['address']          = $address;
	$data['country']          = $country;
	$data['city']             = $city;
	$data['state']            = $state;
	$data['pincode']          = $pincode;
	$data['phone']            = $phone;
	$data['emailid']          = $email;

	#Amount Calculation
	$sinfo       = get_post_meta( $staff , '_custom_settings', true);
	$sinfo       = is_array($sinfo) ? $sinfo : array();
	$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
	$staff_price = floatval($staff_price);

	$serviceinfo   = get_post_meta($data['service'], '_custom_settings', true );
	$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
	$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
	$service_price = floatval($service_price);
	$amount        = floatval( $staff_price + $service_price );
	#Amount Calculation

	$secret_key = cs_get_option( 'stripe-secret-api-key' );
	\Stripe\Stripe::setApiKey($secret_key);
	$currency_code = cs_get_option('book-currency');

	#Stripe
	if( update_option( $option, $data ) ) :

		$checkout_session = \Stripe\Checkout\Session::create([
		    'payment_method_types' => ['card'],
		    'customer_email' => $email,
		    'line_items' => [[
		      'price_data' => [
		        'currency' => $currency_code,
		        'product_data' => [
		          'name' => $option,
		        ],
		        'unit_amount' => ( $amount * 100),
		      ],
		      'quantity' => 1,
		    ]],
		    'mode' => 'payment',
		    'success_url' => home_url('/')."?action=dt_stripe_return&session_id={CHECKOUT_SESSION_ID}&res=".$option,
		    'cancel_url' => add_query_arg( array( 'action'=>'dt_stripe_cancel', 'res'=>$option ), home_url('/') ),
		]);

	    echo json_encode($checkout_session);

	endif;

    die('');
}

add_action( 'wp_loaded', 'ultimate_booking_pro_stripe_listener' ); # Stripe Checkout redirect
function ultimate_booking_pro_stripe_listener() {

	if( isset( $_GET['action'] ) ) {
		switch ( $_GET['action'] ) {

			case 'dt_stripe_cancel':
				$args = array('action','res');
				delete_option(ultimate_booking_pro_sanitization($_GET['res']));
				$url  = get_page_link( cs_get_option('appointment-pageid') );
				$url  = add_query_arg( array( 'action' => 'error' ) , $url );
				wp_safe_redirect($url);
				exit;
			break;

			case 'dt_stripe_return':
				$session_id = ultimate_booking_pro_sanitization($_GET["session_id"]);

				require_once( ultimate_booking_pro()->plugin_path( 'reservation/payments/stripe-php/init.php' ) );

				\Stripe\Stripe::setAppInfo( 'Ultimate Booking Pro', '1.1.0', 'https://ultimatebm.wpengine.com/' );
				\Stripe\Stripe::setApiVersion( '2020-03-20' );

				$secret_key = cs_get_option( 'stripe-secret-api-key' );
				\Stripe\Stripe::setApiKey($secret_key);

				$session = \Stripe\Checkout\Session::retrieve($session_id);
  				$customer = \Stripe\Customer::retrieve($session->customer);

				$reservation  = get_option(ultimate_booking_pro_sanitization($_REQUEST['res']));

				$staff        = explode("_",ultimate_booking_pro_sanitization($_REQUEST['res']));
				$staff_name   = get_the_title($staff[4]);
				$service_name = get_the_title($reservation['service']);
				$start        = new DateTime($reservation['start']);
				$end          = new DateTime($reservation['end']);
				$date         = date_format($start, "Y/m/d");
				$time         = date_format($start,"g:i a").' - '.date_format($end,"g:i a");

				$client_name  = get_the_title($reservation['user']);
				$cinfo        = get_post_meta( $reservation['user'], "_info",true);
				$cinfo        = is_array($cinfo) ? $cinfo : array();
				$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
				$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";

				#Staff Price
				$sinfo       = get_post_meta( $staff[4] , '_custom_settings', true);
				$sinfo       = is_array($sinfo) ? $sinfo : array();
				$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
				$staff_price = floatval($staff_price);

				#Service Price
				$serviceinfo   = get_post_meta($reservation['service'],'_custom_settings',true );
				$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
				$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
				$service_price = floatval($service_price);

				$amount = ( ($staff_price+$service_price) > 0 ) ? ( $staff_price+$service_price ) : "";

				$currency_code = cs_get_option('book-currency');
				$amount        = !empty( $amount ) ? $currency_code . $amount.' ['.$session->payment_status.']' : '';

				#Admin
				$user_info   = get_userdata(1);
				$admin_name  = $user_info->nickname;
				$admin_email = $user_info->user_email;

				$array = array(
					'admin_name'        => $admin_name,
					'admin_email'       => $admin_email,
					'staff_name'        => $staff_name,
					'service_name'      => $service_name,
					'appointment_id'    => $reservation['id'],
					'appointment_time'  => $time,
					'appointment_date'  => $date,
					'appointment_title' => $reservation['title'],
					'appointment_body'  => $reservation['body'],
					'client_name'       => $client_name,
					'client_phone'      => $client_phone,
					'client_email'      => $client_email,
					'amount'            => $amount,
					'company_logo'      => 'Company Logo',
					'company_name'      => 'Company Name',
					'company_phone'     => 'Company Phone',
					'company_address'   => 'Company Address',
					'company_website'   => 'Company Website');

				#Admin Mail
				$subject = cs_get_option('appointment_notification_to_admin_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('appointment_notification_to_admin_message' );
				$message = ultimate_booking_pro_replace( $message, $array);

				ultimate_booking_pro_send_mail( $admin_email, $subject, $message);

				#Staff Mail
				$subject = cs_get_option('appointment_notification_to_staff_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('appointment_notification_to_staff_message' );
				$message = ultimate_booking_pro_replace( $message, $array);

				ultimate_booking_pro_send_mail( $sinfo['staff-email'], $subject, $message);

				#Customer Mail
				$subject = cs_get_option('appointment_notification_to_client_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('appointment_notification_to_client_message' );
				$message = ultimate_booking_pro_replace( $message, $array);

				ultimate_booking_pro_send_mail( $client_email, $subject, $message);

				#Add Payment Details to options table
				$order   = explode('_', ultimate_booking_pro_sanitization($_REQUEST['res']));
				$post_id = wp_insert_post( array('post_title' => 'Pay #'.$order[6], 'post_type' => 'dt_payments', 'post_status' => 'publish') );
				if( $post_id > 0 ) {

					$info['order_date']       = date('Y-m-d H:i:s');
					$info['order_type']       = 'stripe';
					$info['order_service']    = get_the_title($reservation['service']);
					$info['order_amount']     = ultimate_booking_pro_get_currency_symbol().' '.sprintf("%.2f", ( $session->amount_total / 100 ) );
					$info['order_status']     = $session->payment_status;
					$info['order_transid']    = $session->payment_intent;

					$info['firstname']        = $reservation['firstname'];
					$info['lastname']         = $reservation['lastname'];
					$info['address']          = $reservation['address'];
					$info['country']          = $reservation['country'];
					$info['city']             = $reservation['city'];
					$info['state']            = $reservation['state'];
					$info['pincode']          = $reservation['pincode'];
					$info['phone']            = $reservation['phone'];
					$info['emailid']          = $reservation['emailid'];
					$info['aboutyourproject'] = $reservation['body'];
					$info['customer_id']      = $reservation['user'];

					update_post_meta ( $post_id, '_info', $info );
				}

				$url = !empty( cs_get_option('appointment-pageid') ) ? get_page_link( cs_get_option('appointment-pageid') ) : home_url();
				$url = add_query_arg( array( 'action' => 'success' ) , $url );

				wp_safe_redirect($url);
				exit();
			break;
		}
	}
}

//appointment type2
add_action( 'wp_ajax_ultimate_booking_pro_new_reservation2', 'ultimate_booking_pro_new_reservation2' ); # For logged-in users
add_action( 'wp_ajax_nopriv_ultimate_booking_pro_new_reservation2','ultimate_booking_pro_new_reservation2'); # For logged-out users
function ultimate_booking_pro_new_reservation2(){
	global $wpdb;

	#New Customer
	$userid  = ultimate_booking_pro_sanitization($_REQUEST['userid']);
	$name    = ultimate_booking_pro_sanitization($_REQUEST['firstname']);
	$lname   = ultimate_booking_pro_sanitization($_REQUEST['lastname']);
	$address = ultimate_booking_pro_sanitization($_REQUEST['address']);
	$city    = ultimate_booking_pro_sanitization($_REQUEST['city']);
	$state   = ultimate_booking_pro_sanitization($_REQUEST['state']);
	$pincode = ultimate_booking_pro_sanitization($_REQUEST['pincode']);
	$country = ultimate_booking_pro_sanitization($_REQUEST['country']);
	$phone   = ultimate_booking_pro_sanitization($_REQUEST['phone']);
	$email   = ultimate_booking_pro_sanitization($_REQUEST['emailid']);
	$body    = ultimate_booking_pro_sanitization($_REQUEST['aboutyourproject']);

	$customer = ultimate_booking_pro_customer( $userid, $name, $lname, $address, $country, $city, $state, $pincode, $phone, $email, $body );

	$id    = $wpdb->get_var("SELECT max(option_id) FROM $wpdb->options");
	$title = esc_html__("New Reservation By ",'wedesigntech-ultimate-booking-addon').$name;

	$staffid   = ultimate_booking_pro_sanitization($_REQUEST['staffid']);
	$serviceid = ultimate_booking_pro_sanitization($_REQUEST['serviceid']);
	if( ultimate_booking_pro_check_plugin_active('sitepress-multilingual-cms/sitepress.php') ) {
		global $sitepress;
		$default_lang = $sitepress->get_default_language();
		$current_lang = ICL_LANGUAGE_CODE;
		if( $default_lang != $current_lang ) {
			$serviceid =  icl_object_id(  $serviceid ,'dt_services', true ,$sitepress->get_default_language());
		}
	}

	$start = ultimate_booking_pro_sanitization($_REQUEST['start']);
	$end   = ultimate_booking_pro_sanitization($_REQUEST['end']);

	$option = "_dt_reservation_mid_{$staffid}_id_{$id}";
	$data   = array( 'id' => $id, 'title'=>$title, 'body'=>$body, 'start'=>$start, 'end'=>$end, 'service'=>$serviceid, 'user'=>$customer, 'readOnly'=>true );

	#Sending Mail
	$client_name = $client_phone = $client_email = $client_address = $amount = '';

	#Staff
	$staff_name   = get_the_title($staffid);
	$service_name = get_the_title($serviceid);

	$sinfo       = get_post_meta( $staffid , '_custom_settings',true);
	$sinfo       = is_array($sinfo) ? $sinfo : array();
	$staff_price = array_key_exists('staff-price', $sinfo) ? $sinfo['staff-price'] : 0;
	$staff_price = floatval($staff_price);

	#Service Price
	if( !empty( $data['service']) ){
		$serviceinfo   = get_post_meta($data['service'],'_custom_settings',true );
		$serviceinfo   = is_array( $serviceinfo ) ? $serviceinfo : array();
		$service_price = array_key_exists('service-price', $serviceinfo) ? $serviceinfo['service-price'] : 0;
		$service_price = floatval($service_price);
	}

	$amount = ( ($staff_price+$service_price) > 0 ) ?  ultimate_booking_pro_get_currency_symbol().' '.( $staff_price+$service_price ) : $amount;

	#Client
	if( !empty($data['user']) ){
		$client_name = get_the_title($data['user']);
		$cinfo       = get_post_meta( $data['user'], "_info",true);
		$cinfo       = is_array($cinfo) ? $cinfo : array();

		$client_email   = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
		$client_phone   = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";
		$client_address = array_key_exists('address', $cinfo) ? $cinfo['address'] : "";
	}

	#Admin
	$user_info   = get_userdata(1);
	$admin_name  = $user_info->nickname;
	$admin_email = $user_info->user_email;

	$array = array(
		'staff_name'        => $staff_name,
		'service_name'      => $service_name,
		'appointment_id'    => $data['id'],
		'appointment_time'  => ultimate_booking_pro_sanitization($_REQUEST['time']),
		'appointment_date'  => ultimate_booking_pro_sanitization($_REQUEST['date']),
		'appointment_title' => $data['title'],
		'appointment_body'  => $data['body'],
		'client_name'       => $client_name,
		'client_phone'      => $client_phone,
		'client_email'      => $client_email,
		'client_address'    => $client_address,
		'amount'            => $amount,
		'admin_name'        => $admin_name,
		'admin_email'       => $admin_email,
		'company_logo'      => 'Company Logo',
		'company_name'      => 'Company Name',
		'company_phone'     => 'Company Phone',
		'company_address'   => 'Company Address',
		'company_website'   => 'Company Website');

	$subject = cs_get_option('appointment_notification_to_staff_subject');
	$subject = ultimate_booking_pro_replace( $subject, $array);

	$message = cs_get_option('appointment_notification_to_staff_message');
	$message = ultimate_booking_pro_replace( $message, $array);

	#Staff Mail
	ultimate_booking_pro_send_mail( $sinfo['staff-email'], $subject, $message);

	#Client Mail
	if( !empty($client_email) ) {
		$subject = cs_get_option('appointment_notification_to_client_subject');
		$subject = ultimate_booking_pro_replace( $subject, $array);

		$message = cs_get_option('appointment_notification_to_client_message');
		$message = ultimate_booking_pro_replace( $message, $array);

		ultimate_booking_pro_send_mail( $client_email, $subject, $message);
	}

	#Admin Mail
	if( !empty($admin_email) ) {
		$subject = cs_get_option('appointment_notification_to_admin_subject');
		$subject = ultimate_booking_pro_replace( $subject, $array);

		$message = cs_get_option('appointment_notification_to_admin_message');
		$message = ultimate_booking_pro_replace( $message, $array);

		ultimate_booking_pro_send_mail( $admin_email, $subject, $message);
	}

	#Sending Mail
	if( update_option( $option, $data ) ) {
		$post_id = wp_insert_post( array('post_title' => 'Pay #'.$id, 'post_type' => 'dt_payments', 'post_status' => 'publish') );
		if( $post_id > 0 ) {

			$info['order_date']       = date('Y-m-d H:i:s');
			$info['order_type']       = 'local';
			$info['order_service']    = get_the_title($data['service']);
			$info['order_amount']     = $amount;

			$info['firstname']        = $name;
			$info['lastname']         = $lname;
			$info['address']          = $address;
			$info['country']          = $country;
			$info['city']             = $city;
			$info['state']            = $state;
			$info['pincode']          = $pincode;
			$info['phone']            = $phone;
			$info['emailid']          = $email;
			$info['aboutyourproject'] = $body;
			$info['customer_id']      = $data['user'];

			update_post_meta ( $post_id, '_info', $info );

			echo json_encode('Success');
		} else {
			echo json_encode('Failed');
		}
	}
	die('');
}