<?php
if (! class_exists ( 'UltimateBookingProCustomPostTypes' )) {

	class UltimateBookingProCustomPostTypes {

		function __construct() {

			// Required From Plugin
			define( 'CS_ACTIVE_FRAMEWORK', true );
			define( 'CS_ACTIVE_METABOX', true );
			define( 'CS_ACTIVE_TAXONOMY', true );
			define( 'CS_ACTIVE_SHORTCODE', true );

			// Can changeable in theme or other plugin uses Codestar
			define( 'CS_ACTIVE_CUSTOMIZE', false );
			define( 'CS_ACTIVE_LIGHT_THEME', false );

			add_filter ( 'cs_shortcode_options', array (
				$this,
				'ultimate_booking_pro_cs_shortcode_options'
			) );

			add_filter ( 'cs_framework_options', array (
				$this,
				'ultimate_booking_pro_cs_framework_options'
			) );

            add_filter ( 'cs_framework_options', array (
				$this,
				'ultimate_booking_pro_cs_framework_backup_options'
            ), 100 );

			add_filter ( 'cs_framework_settings', array (
				$this,
				'ultimate_booking_pro_cs_framework_settings'
			) );

			// Service custom post type
			require_once plugin_dir_path ( __FILE__ ) . '/dt-service-post-type.php';
			if (class_exists ( 'DTServicePostType' )) {
				new DTServicePostType();
			}

			// Staff custom post type
			require_once plugin_dir_path ( __FILE__ ) . '/dt-staff-post-type.php';
			if (class_exists ( 'DTStaffPostType' )) {
				new DTStaffPostType();
			}
		}

		function ultimate_booking_pro_cs_shortcode_options( $options ) {

			$codestar = ultimate_booking_pro_has_codestar();
			$options  =  ( $codestar ) ? $options : array();

			require_once plugin_dir_path( __DIR__ ) . 'cs-framework-override/config/shortcodes/base.php';
			$obj = new DTBooking_Cs_Sc_Base;
			$options = $obj->DTBooking_cs_sc_Combined();

			return $options;
		}

		/**
		 * Service framework options
		 */
		function ultimate_booking_pro_cs_framework_options( $options ) {

			global $timearray;
			$timearray = array( '' => 'OFF', '00:00' => '12:00 am', '00:15' => '12:15 am', '00:30' => '12:30 am', '00:45' => '12:45 am', '01:00' => '1:00 am', '01:15' => '1:15 am',
						   '01:30' => '1:30 am', '01:45' => '1:45 am', '02:00' => '2:00 am', '02:15' => '2:15 am', '02:30' => '2:30 am', '02:45' => '2:45 am', '03:00' => '3:00 am',
						   '03:15' => '3:15 am', '03:30' => '3:30 am', '03:45' => '3:45 am', '04:00' => '4:00 am', '04:15' => '4:15 am', '04:30' => '4:30 am', '04:45' => '4:45 am',
						   '05:00' => '5:00 am', '05:15' => '5:15 am', '05:30' => '5:30 am', '05:45' => '5:45 am', '06:00' => '6:00 am', '06:15' => '6:15 am', '06:30' => '6:30 am',
						   '06:45' => '6:45 am', '07:00' => '7:00 am', '07:15' => '7:15 am', '07:30' => '7:30 am', '07:45' => '7:45 am', '08:00' => '8:00 am', '08:15' => '8:15 am',
						   '08:30' => '8:30 am', '08:45' => '8:45 am', '09:00' => '9:00 am', '09:15' => '9:15 am', '09:30' => '9:30 am', '09:45' => '9:45 am', '10:00' => '10:00 am',
						   '10:15' => '10:15 am', '10:30' => '10:30 am', '10:45' => '10:45 am', '11:00' => '11:00 am', '11:15' => '11:15 am', '11:30' => '11:30 am', '11:45' => '11:45 am',
						   '12:00' => '12:00 pm', '12:15' => '12:15 pm', '12:30' => '12:30 pm', '12:45' => '12:45 pm', '13:00' => '1:00 pm', '13:15' => '1:15 pm', '13:30' => '1:30 pm',
						   '13:45' => '1:45 pm', '14:00' => '2:00 pm', '14:15' => '2:15 pm', '14:30' => '2:30 pm', '14:45' => '2:45 pm', '15:00' => '3:00 pm', '15:15' => '3:15 pm',
						   '15:30' => '3:30 pm', '15:45' => '3:45 pm', '16:00' => '4:00 pm', '16:15' => '4:15 pm', '16:30' => '4:30 pm', '16:45' => '4:45 pm', '17:00' => '5:00 pm',
						   '17:15' => '5:15 pm', '17:30' => '5:30 pm', '17:45' => '5:45 pm', '18:00' => '6:00 pm', '18:15' => '6:15 pm', '18:30' => '6:30 pm', '18:45' => '6:45 pm',
						   '19:00' => '7:00 pm', '19:15' => '7:15 pm', '19:30' => '7:30 pm', '19:45' => '7:45 pm', '20:00' => '8:00 pm', '20:15' => '8:15 pm', '20:30' => '8:30 pm',
						   '20:45' => '8:45 pm', '21:00' => '9:00 pm', '21:15' => '9:15 pm', '21:30' => '9:30 pm', '21:45' => '9:45 pm', '22:00' => '10:00 pm', '22:15' => '10:15 pm',
						   '22:30' => '10:30 pm', '22:45' => '10:45 pm', '23:00' => '11:00 pm', '23:15' => '11:15 pm', '23:30' => '11:30 pm', '23:45' => '11:45 pm' );

			$currencies = array();
			$currency_codes = ultimate_booking_pro_get_currencies();
			foreach( $currency_codes as $code => $value ){
				$currencies[$code] = $value . ' ('. ultimate_booking_pro_get_currency_symbol( $code ) .')';
			}

			$codestar = ultimate_booking_pro_has_codestar();
			$options  =  ( $codestar ) ? $options : array();

			$options['booking-manager'] = array(
			  'name'        => 'wedesigntech-ultimate-booking-addon',
			  'title'       => esc_html__('Booking Options', 'wedesigntech-ultimate-booking-addon'),
			  'icon'        => 'fa fa-calendar',
			  'sections'	=> array(

				  // -----------------------------------------
				  // General Options
				  // -----------------------------------------
				  array(
					'name'	=> 'general_options',
					'title' => esc_html__('General Options', 'wedesigntech-ultimate-booking-addon'),
					'icon'  => 'fa fa-gear',

					  'fields'	=> array(

						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( 'General Options', 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'id'  	=> 'enable-service-taxonomy',
						  'type'  	=> 'switcher',
						  'title' 	=> esc_html__("Enable Service's Categories", "wdt-ultimate-booking"),
						  'label'	=> esc_html__("YES! to enable service's taxonomy", "wdt-ultimate-booking")
						),

						array(
						  'id'  	=> 'enable-staff-taxonomy',
						  'type'  	=> 'switcher',
						  'title' 	=> esc_html__("Enable Staff's Departments", "wdt-ultimate-booking"),
						  'label'	=> esc_html__("YES! to enable staff's taxonomy", "wdt-ultimate-booking")
						),

						array(
							'id'  	=> 'enable-price-in-dropdown',
							'type'  	=> 'switcher',
							'title' 	=> esc_html__("Enable Price in Staff & Service dropdown", "wdt-ultimate-booking"),
							'label'	=> esc_html__("YES! to enable price in Staff & Service dropdown", "wdt-ultimate-booking")
						  ),

						array(
						  'id'           => 'appointment-pageid',
						  'type'         => 'select',
						  'title'        => esc_html__('Appointment Page', 'wedesigntech-ultimate-booking-addon'),
						  'options'      => 'pages',
						  'class'        => 'chosen',
						  'default_option' => esc_html__('Choose the page', 'wedesigntech-ultimate-booking-addon'),
						  'info'       	 => esc_html__('Choose the page for reserve appointment.', 'wedesigntech-ultimate-booking-addon')
						),

						array(
						  'id'           => 'view-reservations-pageid',
						  'type'         => 'select',
						  'title'        => esc_html__('View Reservations Page', 'wedesigntech-ultimate-booking-addon'),
						  'options'      => 'pages',
						  'class'        => 'chosen',
						  'default_option' => esc_html__('Choose the page', 'wedesigntech-ultimate-booking-addon'),
						  'info'       	 => esc_html__('Choose the page for view reservations.', 'wedesigntech-ultimate-booking-addon')
						),
					  ),
				  ),

				  // -----------------------------
				  // Time Schedule
				  // -----------------------------
				  array(
					'name'      => 'appointment_options',
					'title'     => esc_html__('Time Schedule', 'wedesigntech-ultimate-booking-addon'),
					'icon'      => 'fa fa-clock-o',

					  'fields'      => array(

						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Business Hour's Settings", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'id'        => 'appointment_fs1',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Monday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_monday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_monday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_monday_start'  => '08:00',
							'ultimate_booking_pro_monday_end' 	 => '17:00',
						  )
						),

						array(
						  'id'        => 'appointment_fs2',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Tuesday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_tuesday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_tuesday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_tuesday_start'  => '08:00',
							'ultimate_booking_pro_tuesday_end'    => '17:00',
						  )
						),

						array(
						  'id'        => 'appointment_fs3',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Wednesday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_wednesday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_wednesday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_wednesday_start'  => '08:00',
							'ultimate_booking_pro_wednesday_end'    => '17:00',
						  )
						),

						array(
						  'id'        => 'appointment_fs4',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Thursday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_thursday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_thursday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_thursday_start'  => '08:00',
							'ultimate_booking_pro_thursday_end'    => '17:00',
						  )
						),

						array(
						  'id'        => 'appointment_fs5',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Friday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_friday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_friday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_friday_start'  => '08:00',
							'ultimate_booking_pro_friday_end'    => '17:00',
						  )
						),

						array(
						  'id'        => 'appointment_fs6',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Saturday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_saturday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_saturday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_saturday_start'  => '',
							'ultimate_booking_pro_saturday_end'    => '',
						  )
						),

						array(
						  'id'        => 'appointment_fs7',
						  'type'      => 'fieldset',
						  'title'     => esc_html__('Sunday', 'wedesigntech-ultimate-booking-addon'),
						  'fields'    => array(

							array(
							  'id'    => 'ultimate_booking_pro_sunday_start',
							  'type'  => 'select',
							  'title'        => esc_html__('From:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
							array(
							  'id'    => 'ultimate_booking_pro_sunday_end',
							  'type'  => 'select',
							  'title'        => esc_html__('To:', 'wedesigntech-ultimate-booking-addon'),
							  'options'      => $timearray,
							  'class'        => 'chosen',
							),
						  ),
						  'default'   => array(
							'ultimate_booking_pro_sunday_start'  => '',
							'ultimate_booking_pro_sunday_end'    => '',
						  )
						),
					  ),
				  ),

				  // -----------------------------
				  // Appointment Payment
				  // -----------------------------
				  array(
					'name'      => 'appointment_payments',
					'title'     => esc_html__('Payments', 'wedesigntech-ultimate-booking-addon'),
					'icon'      => 'fa fa-money',

					  'fields'      => array(

						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Payment Settings", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'id'         => 'book-currency',
						  'type'       => 'select',
						  'title'      => esc_html__('Currency', 'wedesigntech-ultimate-booking-addon'),
						  'options'    => $currencies,
						  'class'      => 'chosen',
						  'default'    => 'USD',
						),

						array(
						  'id'           => 'currency-pos',
						  'type'         => 'select',
						  'title'        => esc_html__('Currency Position', 'wedesigntech-ultimate-booking-addon'),
						  'options'      => array(
							'left' 			   => esc_html__('Left ( $36.55 )', 'wedesigntech-ultimate-booking-addon'),
							'right'      	   => esc_html__('Right ( 36.55$ )', 'wedesigntech-ultimate-booking-addon'),
							'left-with-space'  => esc_html__('Left with space ( $ 36.55 )', 'wedesigntech-ultimate-booking-addon'),
							'right-with-space' => esc_html__('Right with space ( 36.55 $ )', 'wedesigntech-ultimate-booking-addon'),
						  ),
						  'class'        => 'chosen',
						),

						array(
						  'id'  	    => 'price-decimal',
						  'type'  	    => 'number',
						  'title' 	    => esc_html__('Number of decimal', 'wedesigntech-ultimate-booking-addon'),
						  'after'		=> '<span class="cs-text-desc">&nbsp;'.esc_html__('No.of decimals in price', 'wedesigntech-ultimate-booking-addon').'</span>',
						  'default' 	=> 1,
						),

						array(
						  'id'  	   => 'enable-guest-checkout',
						  'type'  	   => 'switcher',
						  'title' 	   => esc_html__('Enable Guest Checkout', 'wedesigntech-ultimate-booking-addon'),
						  'info'	   => esc_html__('You can enable guest checkout, without creating account.', 'wedesigntech-ultimate-booking-addon'),
						),

						array(
						  'id'  	   => 'enable-pay-at-arrival',
						  'type'  	   => 'switcher',
						  'title' 	   => esc_html__('Enable Pay at Arrival', 'wedesigntech-ultimate-booking-addon'),
						  'info'	   => esc_html__('You can enable pay at arrival option to pay locally', 'wedesigntech-ultimate-booking-addon'),
						),

						array(
						  'id'  	   => 'enable-paypal',
						  'type'  	   => 'switcher',
						  'title' 	   => esc_html__('Enable PayPal', 'wedesigntech-ultimate-booking-addon'),
						  'info'	   => esc_html__('You can enable paypal express checkout', 'wedesigntech-ultimate-booking-addon'),
						),

						array(
						  'id'  	   => 'paypal-username',
						  'type'  	   => 'text',
						  'title' 	   => esc_html__('Business Account Username', 'wedesigntech-ultimate-booking-addon'),
						  'info'	   => esc_html__('Enter a valid Merchant account ID or PayPal account email address. All payments will go to this account.', 'wedesigntech-ultimate-booking-addon'),
						  'dependency' => array( 'enable-paypal', '==', 'true' ),
						),

						array(
						  'id'  	   => 'enable-paypal-live',
						  'type'  	   => 'switcher',
						  'title' 	   => esc_html__('Enable Live', 'wedesigntech-ultimate-booking-addon'),
						  'info'	   => esc_html__('You can enable live paypal express checkout.', 'wedesigntech-ultimate-booking-addon'),
						  'dependency' => array( 'enable-paypal', '==', 'true' ),
						),

					  ),
				  ),

				  // ----------------------------------
				  // begin: appointment notifications -
				  // ----------------------------------
				  array(
					'name'      => 'appointment_notifications',
					'title'     => esc_html__('Notifications', 'wedesigntech-ultimate-booking-addon'),
					'icon'      => 'fa fa-envelope-o',

					  'fields'      => array(

						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Notification Settings", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'id'  	 => 'notification_sender_name',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Sender Name', 'wedesigntech-ultimate-booking-addon'),
						  'default'	 => get_option( 'blogname' ),
						),

						array(
						  'id'  	 => 'notification_sender_email',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Sender Email ID', 'wedesigntech-ultimate-booking-addon'),
						  'default'	 => get_option( 'admin_email' ),
						),

						array(
						  'type'    => 'notice',
						  'class'   => 'info',
						  'content' => esc_html__('To send scheduled agenda please execute following script with your cron,', 'wedesigntech-ultimate-booking-addon').' <b>'.WP_PLUGIN_DIR.'/wdt-ultimate-booking/reservation/cron/send_agenda_cron.sh'.'</b>',
						),

						// ------------------------------------------
						// a option sub section for admin template  -
						// ------------------------------------------
						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Admin Email Template", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the admin about new Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'appointment_notification_to_admin_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [ADMIN_NAME] , New booking information ( Booking id: [APPOINTMENT_ID] )',
						),

						array(
						  'id'  	 => 'appointment_notification_to_admin_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [ADMIN_NAME], </p>
			  <p> New Booking id : [APPOINTMENT_ID] </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>Client Amount to pay : [AMOUNT]</p>
			  <p>Staff Name: [STAFF_NAME]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the admin regarding modified Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_admin_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [ADMIN_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Modified',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_admin_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [ADMIN_NAME], </p>
			  <p> New Booking id : [APPOINTMENT_ID] </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>Client Amount to pay : [AMOUNT]</p>
			  <p>Staff Name: [STAFF_NAME]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the admin regarding Deleted / Declined Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_admin_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [ADMIN_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Deleted / Declined',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_admin_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [ADMIN_NAME], </p>
			  <p> New Booking id : [APPOINTMENT_ID] </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>Client Amount to pay : [AMOUNT]</p>
			  <p>Staff Name: [STAFF_NAME]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						// ------------------------------------------
						// a option sub section for staff template  -
						// ------------------------------------------
						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Staff Email Template", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('New Appoinment Notification:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'appointment_notification_to_staff_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [STAFF_NAME] , New booking information ( Booking id: [APPOINTMENT_ID] )',
						),

						array(
						  'id'  	 => 'appointment_notification_to_staff_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [STAFF_NAME], </p>
			  <p> Your new Booking id : [APPOINTMENT_ID] </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the staff regarding modified Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_staff_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [STAFF_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Modified',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_staff_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [STAFF_NAME], </p>
			  <p> Your Booking id : [APPOINTMENT_ID]  was modified </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the staff regarding Deleted / Declined Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_staff_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [STAFF_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Deleted / Declined',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_staff_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [STAFF_NAME], </p>
			  <p> Booking id : [APPOINTMENT_ID]  was Deleted / Declined </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>Client Name: [CLIENT_NAME]</p>
			  <p>Client Phone: [CLIENT_PHONE]</p>
			  <p>Client Email: [CLIENT_EMAIL]</p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Evening notification with the next day agenda to Staff Member:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'agenda_to_staff_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [STAFF_NAME] , Your Agenda for [TOMORROW]',
						),

						array(
						  'id'  	 => 'agenda_to_staff_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 2,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [STAFF_NAME], </p><p>Your agenda for tomorrow is </p><p>[TOMORROW_AGENDA]</p>',
						),

						// --------------------------------------------
						// a option sub section for cusomer template  -
						// --------------------------------------------
						array(
						  'type'    => 'subheading',
						  'content' => esc_html__( "Customer Email Template", 'wedesigntech-ultimate-booking-addon' ),
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the client about new Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'appointment_notification_to_client_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [CLIENT_NAME] , New booking information ( Booking id: [APPOINTMENT_ID] )',
						),

						array(
						  'id'  	 => 'appointment_notification_to_client_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [CLIENT_NAME], </p>
			  <p> Your new Booking id : [APPOINTMENT_ID] </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p> Amount to pay : [AMOUNT]</p>
			  <p>[APPOINTMENT_BODY]</p>
			  <p>Thank you for choosing our company.</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the client regarding modified Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_client_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [CLIENT_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Modified',
						),

						array(
						  'id'  	 => 'modified_appointment_notification_to_client_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [CLIENT_NAME], </p>
			  <p> Your Booking id : [APPOINTMENT_ID]  was modified </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p> Amount to pay : [AMOUNT]</p>
			  <p>[APPOINTMENT_BODY]</p>
			  <p>Thank you for choosing our company.</p>',
						),

						array(
						  'type'    => 'content',
						  'content' => '<b>'.esc_html__('Notification to the client regarding Deleted / Declined Appointment:', 'wedesigntech-ultimate-booking-addon').'</b>',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_client_subject',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Subject', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => 'Hi [CLIENT_NAME] , ( Booking id: [APPOINTMENT_ID] ) - Deleted / Declined',
						),

						array(
						  'id'  	 => 'deleted_appointment_notification_to_client_message',
						  'type'  	 => 'wysiwyg',
						  'title' 	 => esc_html__('Message', 'wedesigntech-ultimate-booking-addon'),
						  'settings' => array(
							'textarea_rows' => 5,
							'tinymce'       => false,
							'media_buttons' => false,
						  ),
						  'default'	 => '<p> Hello [CLIENT_NAME], </p>
			  <p> Your Booking id : [APPOINTMENT_ID]  was Deleted / Declined </p>
			  <p> Service: [SERVICE]</p>
			  <p> Date & Time: [APPOINTMENT_DATE] - [APPOINTMENT_TIME] </p>
			  <p>[APPOINTMENT_BODY]</p>',
						),

						array(
						  'id'  	 => 'success_message',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Success Message', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => esc_html__('Success. You got a appointment to experience our excellent service.', 'wedesigntech-ultimate-booking-addon'),
						),

						array(
						  'id'  	 => 'error_message',
						  'type'  	 => 'text',
						  'title' 	 => esc_html__('Error Message', 'wedesigntech-ultimate-booking-addon'),
						  'attributes' => array(
							'style'    => 'width: 100%;'
						  ),
						  'default'	 => esc_html__('Oops! You have cancelled the payment process :', 'wedesigntech-ultimate-booking-addon')
						),

					  ),
				  ),
			  ),
			);

			return $options;
		}

        function ultimate_booking_pro_cs_framework_backup_options( $options ) {

            $options['booking-backup']   = array(
                'name'     => 'backup_section',
                'title'    => esc_html__('Backup', 'wedesigntech-ultimate-booking-addon'),
                'icon'     => 'fa fa-shield',
                'fields'   => array(

                  array(
                    'type'    => 'notice',
                    'class'   => 'warning',
                    'content' => esc_html__('You can save your current options. Download a Backup and Import.', 'wedesigntech-ultimate-booking-addon')
                  ),

                  array(
                    'type'    => 'backup',
                  ),

                )
              );

              return $options;

        }

		function ultimate_booking_pro_cs_framework_settings($settings){

			$codestar = ultimate_booking_pro_has_codestar();
			if( !$codestar ) {

				$settings           = array(
                    'menu_title'      => esc_html__('WeDesignTech Settings', 'wedesigntech-ultimate-booking-addon'),
                    'menu_type'       => 'menu',
                    'menu_slug'       => 'wedesigntech-settings',
                    'ajax_save'       => true,
                    'show_reset_all'  => false,
                    'framework_title' => esc_html__('WeDesignTech Settings', 'wedesigntech-ultimate-booking-addon')
                  );

			}

			return $settings;
		}
	}
}