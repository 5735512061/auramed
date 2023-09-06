<?php if ( !class_exists( 'DTCalendarMenu' ) ) {

	class DTCalendarMenu {

		function __construct() {
			add_action( 'admin_menu', array(
				$this,
				'register_calendar_menu'
			) );

			// 1. List Reservations For Individual Members
			add_action( 'wp_ajax_dt_list_member_reservations' , array(
				$this,
				'dt_list_member_reservations'
			) );

			// 2. Get Reservation id - For Adding new reservation
			add_action( 'wp_ajax_dt_new_reservation_id', array(
				$this,
				'dt_new_reservation_id'
			) );

			// 3. Load Services based on Staff id
			add_action('wp_ajax_dt_load_services', array(
				$this,
				'dt_load_services'
			) );

			// 3.1  Load Customers
			add_action('wp_ajax_dt_set_customer', array(
				$this,
				'dt_set_customer'
			) );

			// 4. Add New Reservation
			add_action( 'wp_ajax_dt_add_new_reservation', array(
				$this,
				'dt_add_new_reservation'
			) );

			// 5. Update Reservation
			add_action( 'wp_ajax_dt_update_reservation',  array(
				$this,
				'dt_update_reservation'
			) );

			// 6. Delete Reservation
			add_action( 'wp_ajax_dt_delete_reservation', array(
				$this,
				'dt_delete_reservation'
			) );
		}

		function register_calendar_menu() {
			// Main menu page for calendar...
			$calendar_menu = add_menu_page( esc_html__('Calendar', 'wedesigntech-ultimate-booking-addon'), esc_html__('Calendar', 'wedesigntech-ultimate-booking-addon'), 'manage_options', 'dt_calendar', array( $this, 'calendar_menu' ), 'dashicons-calendar-alt', 9 );

			add_action( 'load-'.$calendar_menu , array(
				$this,
				'dt_load_js_css'
			), 9 );
		}

		function calendar_menu(){
			include_once plugin_dir_path ( __FILE__ ) . 'menu/calendar/calendar.php';
		}

		function dt_load_js_css(){
			wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'dt-weekcalendar-css', plugin_dir_url ( __FILE__ ).'menu/calendar/jquery.weekcalendar.css' );
			wp_enqueue_style( 'dt-custom-css', plugin_dir_url ( __FILE__ ).'menu/calendar/custom.css' );

			wp_enqueue_script('dt-date-js' , plugin_dir_url ( __FILE__ ).'menu/calendar/js/date.js', array(
				'jquery',
				'jquery-ui-widget',
				'jquery-ui-dialog',
				'jquery-ui-button',
				'jquery-ui-draggable',
				'jquery-ui-droppable',
				'jquery-ui-resizable'), false, true );
			wp_enqueue_script('dt-jquery-browser-js' , plugin_dir_url ( __FILE__ ).'menu/calendar/js/jquery.browser.min.js', array(), false, true );
			wp_enqueue_script('dt-weekcalendar-js' , plugin_dir_url ( __FILE__ ).'menu/calendar/js/jquery.weekcalendar.js', array(), false, true );
			wp_enqueue_script('dt-calendar-js' , plugin_dir_url ( __FILE__ ).'menu/calendar/js/dt-calendar.js', array(), false, true );
			wp_localize_script('dt-calendar-js', 'reservation', array(
				'new_event' => esc_html__('Add New Reservation','wedesigntech-ultimate-booking-addon'),
				'edit'      => esc_html__('Edit Reservation','wedesigntech-ultimate-booking-addon'),
			));
		}

		function dt_list_member_reservations(){
			if ( !empty($_REQUEST['id'] ) ) {

				$mid =ultimate_booking_pro_sanitization($_REQUEST['id']);
				$start =ultimate_booking_pro_sanitization($_REQUEST['start']);
				$end =ultimate_booking_pro_sanitization($_REQUEST['end']);

				$result = array( 'events' => array() , 'freebusys' => array());

				# To generate events
				global $wpdb;
				$q = "SELECT option_name FROM $wpdb->options WHERE option_name LIKE '_dt_reservation_mid_{$mid}%' ORDER BY option_id ASC";
				$rows = $wpdb->get_results( $q );
				if ( $rows ) {
					foreach ( $rows as $row ) {
						$result['events'][] = get_option( $row->option_name );
					}
				}

				# To generate freebusys
				$timer = array();
				$meta_times = get_post_meta( $mid, '_custom_settings', true);
				$timer = array_merge($meta_times['appointment_fs1'], $meta_times['appointment_fs2'], $meta_times['appointment_fs3'], $meta_times['appointment_fs4'], $meta_times['appointment_fs5'], $meta_times['appointment_fs6'], $meta_times['appointment_fs7']);

				$days = array();

				foreach ( array('monday','tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') as $day ):
					if( !empty($timer["ultimate_booking_pro_{$day}_start"]) ){
						$days[$day] = array( 'start' => $timer["ultimate_booking_pro_{$day}_start"], 'end' => $timer["ultimate_booking_pro_{$day}_end"]  );
					}
				endforeach;

				$working_days = ultimate_booking_pro_dates_range( $start, $end , array_keys($days));
				foreach ($working_days as $working_day ) {
					$date = date_i18n('Y-m-d', strtotime($working_day) );
					$wdate = new DateTime($date);
					$day = strtolower($wdate->format('l'));

					$s = new DateTime($date.' '. $timer["ultimate_booking_pro_{$day}_start"]);
					$s = $s->format( 'm/d/Y H:i');

					$e = new DateTime($date.' '. $timer["ultimate_booking_pro_{$day}_end"]);
					$e = $e->format( 'm/d/Y H:i');
					$result['freebusys'][] = array( "start" => $s , "end"=>$e, "free"=>true);
				}
				echo json_encode( $result );
			}
			die('');
		}

		function dt_new_reservation_id(){
			global $wpdb;
			$rs = $wpdb->get_var( "SELECT max(option_id) FROM $wpdb->options" );
			echo "{$rs}";
			die( '' );
		}

		function dt_load_services() {
			$out = "<option value=''>".esc_html__('Select Service','wedesigntech-ultimate-booking-addon')."</option>";
			$current = "";

			if( !empty($_REQUEST['option']) ){
				if( !get_option(ultimate_booking_pro_sanitization($_REQUEST['option'].'_agenda')) ){
					$option = get_option( ultimate_booking_pro_sanitization($_REQUEST['option']));
				}else{
					$option = get_option( ultimate_booking_pro_sanitization($_REQUEST['option'].'_agenda'));
				}

				$current = $option['service'];
			}

			if( !empty($_REQUEST['memberid']) ) {

				$services = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['memberid']) , '_custom_settings',true);
				$services = is_array($services) ? $services : array();

				if( !empty($services) ){
					$services = implode(",", $services['staff-services']);
					$cp_services = get_posts( array('post_type'=>'dt_service','posts_per_page'=>'-1','order'=> 'ASC', 'orderby' => 'title', 'include' => $services ) );
					foreach( $cp_services as $cp_service ){
						$id = $cp_service->ID;
						$title = $cp_service->post_title;

						$info = get_post_meta( $id, '_custom_settings', true);
						$info = is_array($info) ? $info : array();
						$duration = array_key_exists('service-duration', $info) ? ultimate_booking_pro_duration_to_string( $info['service-duration'] ) : "";
						$selected = ( $current == $id ) ? " selected='selected' " : '';
						$out .= "<option value='{$id}' {$selected}>{$title} ( {$duration} ) </option>";
					}
				}
			}
			echo "{$out}";
			die('');
		}

		function dt_add_new_reservation() {

			$now =  new DateTime( "now" );
			$start = new DateTime( ultimate_booking_pro_sanitization($_REQUEST['c_start']) );
			$readOnly =  ( $now < $start ) ? true : false;
			$data = array(
				'id'      => ultimate_booking_pro_sanitization($_REQUEST['id']),
				'title'   => ultimate_booking_pro_sanitization($_REQUEST['title']),
				'body'    => ultimate_booking_pro_sanitization($_REQUEST['body']),
				'start'   => ultimate_booking_pro_sanitization($_REQUEST['start']),
				'end'     => ultimate_booking_pro_sanitization($_REQUEST['end']),
				'user'    => ultimate_booking_pro_sanitization($_REQUEST['user']),
				'service' => ultimate_booking_pro_sanitization($_REQUEST['service']),
				'readOnly'=> $readOnly );

                if($_REQUEST['service'] != '' && $_REQUEST['service'] > 0) {
                    $service_settings = get_post_meta($_REQUEST['service'], '_custom_settings', true);
                    $service_settings = is_array ( $service_settings ) ? $service_settings : array ();

                    if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
                        $service_duration = $service_settings['service-duration'];
                        $altered_date = strtotime($data['start'])+$service_duration;
                        $altered_date = date('Y/n/j H:i', $altered_date);
                        $data['end'] = $altered_date;
                    endif;
                }

				update_option( $_REQUEST['option'], $data );

				# Sending Mail
				$staff_name = get_the_title(ultimate_booking_pro_sanitization($_REQUEST['memberid']));
				$service_name = get_the_title( ultimate_booking_pro_sanitization($_REQUEST['service']) );
				$info = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['memberid']), '_custom_settings', true);
				$info = is_array($info) ? $info : array();

				if( array_key_exists('staff-email', $info) ) {

					#Calculating Price
					$amount = "";
					$staff_price = array_key_exists("staff-price", $info) ? $info['staff-price'] : 0;
					if( !empty($_REQUEST['service']) ){

						$sinfo = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['service']) , '_custom_settings',true);
						$sinfo = is_array($sinfo) ? $sinfo : array();
						$service_price = array_key_exists('service-price', $sinfo) ? $sinfo['service-price'] : 0;
					}
					$price = floatval($staff_price) + floatval($service_price);
					$currency = ultimate_booking_pro_get_currency_symbol();
					$amount = $currency.' '.$price;
					#Calculating Price

					$client_name = $client_phone = $client_email = "";
					$client = $data['user'];
					if( !empty($client) ){
						$client_name = get_the_title($client);

						$cinfo = get_post_meta( $client, '_info',true);
						$cinfo = is_array($cinfo) ? $cinfo : array();

						$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
						$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";;
					}

					#Admin
					$user_info = get_userdata(1);
					$admin_name = $user_info->nickname;
					$admin_email = $user_info->user_email;

					$array = array(
						'admin_name' => $admin_name,
						'staff_name' => $staff_name,
						'service_name' => $service_name,
						'appointment_id' => $data['id'],
						'appointment_time' => ultimate_booking_pro_sanitization($_REQUEST['time']),
						'appointment_date' => ultimate_booking_pro_sanitization($_REQUEST['date']),
						'appointment_title' => $data['title'],
						'appointment_body' =>  $data['body'],
						'client_name' => $client_name,
						'client_phone' => $client_phone,
						'client_email' => $client_email,
						'amount' => $amount,
						'company_logo' => 'Company Logo',
						'company_name' => 'Company Name',
						'company_phone' => 'Company Phone',
						'company_address' => 'Company Address',
						'company_website' => 'Company Website');

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

					ultimate_booking_pro_send_mail( $info["staff-email"], $subject, $message);

					#Client Mail
					if( !empty($client_email) ) {
						$subject = cs_get_option('appointment_notification_to_client_subject');
						$subject = ultimate_booking_pro_replace( $subject, $array);

						$message = cs_get_option('appointment_notification_to_client_message' );
						$message = ultimate_booking_pro_replace( $message, $array);

						ultimate_booking_pro_send_mail( $client_email, $subject, $message);
					}
				}

                echo json_encode(array(
                    'data' => $data
                ));

				die( '' );
		}

		function dt_set_customer(){
			$out = "";
			if( !empty($_REQUEST['option']) ){
				if( !get_option($_REQUEST['option'].'_agenda') ){
					$option = get_option( ultimate_booking_pro_sanitization($_REQUEST['option']));
				}else{
					$option = get_option( ultimate_booking_pro_sanitization($_REQUEST['option']).'_agenda');
				}

				$out = $option['user'];
			}
			echo "{$out}";
			die();
		}

		function dt_update_reservation() {

			$now =  new DateTime( "now" );
			$start = new DateTime( $_REQUEST['c_start'] );
			$readOnly =  ( $now < $start ) ? true : false;

			$data = array(
				'id'       => ultimate_booking_pro_sanitization($_REQUEST['id']),
				'title'    => ultimate_booking_pro_sanitization($_REQUEST['title']),
				'body'     => ultimate_booking_pro_sanitization($_REQUEST['body']),
				'start'    => ultimate_booking_pro_sanitization($_REQUEST['start']),
				'end'      => ultimate_booking_pro_sanitization($_REQUEST['end']),
				'user'     => ultimate_booking_pro_sanitization($_REQUEST['user']),
				'service'  => ultimate_booking_pro_sanitization($_REQUEST['service']),
				'readOnly' => $readOnly );

            if($_REQUEST['service'] != '' && $_REQUEST['service'] > 0) {
                $service_settings = get_post_meta($_REQUEST['service'], '_custom_settings', true);
                $service_settings = is_array ( $service_settings ) ? $service_settings : array ();

                if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
                    $service_duration = $service_settings['service-duration'];
                    $altered_date = strtotime($data['start'])+$service_duration;
                    $altered_date = date('Y/n/j H:i', $altered_date);
                    $data['end'] = $altered_date;
                endif;
            }

			if ( !get_option(ultimate_booking_pro_sanitization($_REQUEST['option']).'_agenda') ) {
				update_option( ultimate_booking_pro_sanitization($_REQUEST['option']), $data );
			} else {
				update_option( ultimate_booking_pro_sanitization($_REQUEST['option']).'_agenda', $data );
			}

			#Send Mail To Staff
			$staff_name = get_the_title(ultimate_booking_pro_sanitization($_REQUEST['memberid']));
			$service_name = get_the_title( ultimate_booking_pro_sanitization($_REQUEST['service']) );
			$info = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['memberid']) , '_custom_settings', true);
			$info = is_array($info) ? $info : array();

			if( array_key_exists("staff-email", $info) ) {

				#Calculating Price
				$amount = "";
				$staff_price = array_key_exists("staff-price", $info) ? $info['staff-price'] : 0;

				if( !empty($_REQUEST['service']) ) {
					$sinfo = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['service']) , '_custom_settings', true);
					$sinfo = is_array($sinfo) ? $sinfo : array();
					$service_price = array_key_exists('service-price', $sinfo) ? $sinfo['service-price'] : 0;
				}

				$price = floatval($staff_price) + floatval($service_price);
				$currency = ultimate_booking_pro_get_currency_symbol();
				$amount = $currency.' '.$price;
				#Calculating Price

				$client_name = $client_phone = $client_email = "";
				$client = $data['user'];
				if( !empty($client) ){
					$client_name = get_the_title($client);
					$cinfo = get_post_meta( $client, '_info', true);
					$cinfo = is_array($cinfo) ? $cinfo : array();

					$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
					$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";;
				}

				#Admin
				$user_info = get_userdata(1);
				$admin_name = $user_info->nickname;
				$admin_email = $user_info->user_email;

				$array = array(
					'admin_name' => $admin_name,
					'staff_name' => $staff_name,
					'service_name' => $service_name,
					'appointment_id' => $data['id'],
					'appointment_time' => ultimate_booking_pro_sanitization($_REQUEST['time']),
					'appointment_date' => ultimate_booking_pro_sanitization($_REQUEST['date']),
					'appointment_title' => $data['title'],
					'appointment_body' =>  $data['body'],
					'client_name' => $client_name,
					'client_phone' => $client_phone,
					'client_email' => $client_email,
					'amount' => $amount,
					'company_logo' => 'Company Logo',
					'company_name' => 'Company Name',
					'company_phone' => 'Company Phone',
					'company_address' => 'Company Address',
					'company_website' => 'Company Website');

				#Admin Mail
				$subject =  cs_get_option('modified_appointment_notification_to_admin_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message =  cs_get_option('modified_appointment_notification_to_admin_message' );
				$message = ultimate_booking_pro_replace( $message, $array);

				ultimate_booking_pro_send_mail( $admin_email, $subject, $message);

				# Staff
				$subject = cs_get_option('modified_appointment_notification_to_staff_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('modified_appointment_notification_to_staff_message' );
				$message = ultimate_booking_pro_replace( $message, $array);
				ultimate_booking_pro_send_mail( $info["staff-email"], $subject, $message);

				if( !empty($client_email) ) {
					$subject = cs_get_option('modified_appointment_notification_to_client_subject');
					$subject = ultimate_booking_pro_replace( $subject, $array);

					$message = cs_get_option('modified_appointment_notification_to_client_message' );
					$message = ultimate_booking_pro_replace( $message, $array);
					ultimate_booking_pro_send_mail( $client_email, $subject, $message);
				}
			}
			#Send Mail

            echo json_encode(array(
                'data' => $data
            ));

			die('');
		}

		function dt_delete_reservation() {
			$options = array();

			if( get_option($_REQUEST['option']) ){
				$options = get_option(ultimate_booking_pro_sanitization($_REQUEST['option']));
			} else {
				$options = get_option( ultimate_booking_pro_sanitization($_REQUEST['option']).'_agenda');
			}

			if( !delete_option( $_REQUEST['option'] )){
				delete_option( ultimate_booking_pro_sanitization($_REQUEST['option']).'_agenda');
			}

			if( !empty($options) ) {

				$client_name = $client_phone = $client_email = "";

				#Staff
				$staff_name = get_the_title(ultimate_booking_pro_sanitization($_REQUEST['memberid']));
				$service_name = get_the_title( ultimate_booking_pro_sanitization($_REQUEST['service']) );
				$info = get_post_meta( ultimate_booking_pro_sanitization($_REQUEST['memberid']) , '_custom_settings', true);
				$info = is_array($info) ? $info : array();

				#Client
				$client =  array_key_exists('user', $options) ? $options['user'] : '';
				if( !empty($client) ) {

					$client_name = get_the_title($client);
					$cinfo = get_post_meta( $client, '_info', true);
					$cinfo = is_array($cinfo) ? $cinfo : array();

					$client_email = array_key_exists('emailid', $cinfo) ? $cinfo['emailid'] : "";
					$client_phone = array_key_exists('phone', $cinfo) ? $cinfo['phone'] : "";
				}

				#Admin
				$user_info = get_userdata(1);
				$admin_name = $user_info->nickname;
				$admin_email = $user_info->user_email;

				$array = array(
					'admin_name' => $admin_name,
					'staff_name' => $staff_name,
					'service_name' => $service_name,
					'appointment_id' => $options['id'],
					'appointment_time' => ultimate_booking_pro_sanitization($_REQUEST['time']),
					'appointment_date' => ultimate_booking_pro_sanitization($_REQUEST['date']),
					'appointment_title' => $options['title'],
					'appointment_body' =>  $options['body'],
					'client_name' => $client_name,
					'client_phone' => $client_phone,
					'client_email' => $client_email,
					'company_logo' => 'Company Logo',
					'company_name' => 'Company Name',
					'company_phone' => 'Company Phone',
					'company_address' => 'Company Address',
					'company_website' => 'Company Website');

				# Admin
				$subject = cs_get_option('deleted_appointment_notification_to_admin_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('deleted_appointment_notification_to_admin_message' );
				$message = ultimate_booking_pro_replace( $message, $array);
				ultimate_booking_pro_send_mail( $admin_email, $subject, $message);

				# Staff
				$subject = cs_get_option('deleted_appointment_notification_to_staff_subject');
				$subject = ultimate_booking_pro_replace( $subject, $array);

				$message = cs_get_option('deleted_appointment_notification_to_staff_message' );
				$message = ultimate_booking_pro_replace( $message, $array);
				ultimate_booking_pro_send_mail( $info["staff-email"], $subject, $message);

				if( !empty($client_email) ) {
					$subject = cs_get_option('deleted_appointment_notification_to_client_subject');
					$subject = ultimate_booking_pro_replace( $subject, $array);

					$message = cs_get_option('deleted_appointment_notification_to_client_message' );
					$message = ultimate_booking_pro_replace( $message, $array);
					ultimate_booking_pro_send_mail( $client_email, $subject, $message);
				}
			}
		}
	}
}