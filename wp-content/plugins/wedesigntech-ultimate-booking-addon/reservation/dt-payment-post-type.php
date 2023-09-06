<?php
if ( !class_exists( 'DTPaymentPostType' ) ) {

	class DTPaymentPostType {

		function __construct() {
			add_action ( 'init', array (
				$this,
				'dt_init'
			) );

			add_action ( 'admin_init', array (
				$this,
				'dt_admin_init'
			) );

			add_filter ( "cs_metabox_options", array(
				$this,
				"dt_payments_cs_metabox_options"
			) );

			add_action( 'admin_menu', array(
				$this,
				'dt_payments_post_submenu'
			) );
		}

		function dt_init() {
			$labels = array(
				'name' => esc_html__('Payments', 'wedesigntech-ultimate-booking-addon' ),
				'singular_name' => esc_html__('Payment', 'wedesigntech-ultimate-booking-addon' ),
				'menu_name' => esc_html__('Calendar', 'wedesigntech-ultimate-booking-addon' ),
				'add_new' => esc_html__('Add Payment', 'wedesigntech-ultimate-booking-addon' ),
				'add_new_item' => esc_html__('Add New Payment', 'wedesigntech-ultimate-booking-addon' ),
				'edit' => esc_html__('Edit Payment', 'wedesigntech-ultimate-booking-addon' ),
				'edit_item' => esc_html__('Edit Payment', 'wedesigntech-ultimate-booking-addon' ),
				'new_item' => esc_html__('New Payment', 'wedesigntech-ultimate-booking-addon' ),
				'view' => esc_html__('View Payment', 'wedesigntech-ultimate-booking-addon' ),
				'view_item' => esc_html__('View Payment', 'wedesigntech-ultimate-booking-addon' ),
				'search_items' => esc_html__('Search Payments', 'wedesigntech-ultimate-booking-addon' ),
				'not_found' => esc_html__('No Payments found', 'wedesigntech-ultimate-booking-addon' ),
				'not_found_in_trash' => esc_html__('No Payments found in Trash', 'wedesigntech-ultimate-booking-addon' ),
				'parent_item_colon' => esc_html__('Parent Payment:', 'wedesigntech-ultimate-booking-addon' ),
			);

			$args = array(
				'labels' => $labels,
				'hierarchical' => false,
				'description' => esc_html__('This is Payment Post type named as Payments','wedesigntech-ultimate-booking-addon'),
				'supports' => array('title'),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => 'admin.php?page=dt_calendar',
				'show_in_admin_bar' => true,
				'menu_position' => 7,
				'menu_icon' => 'dashicons-clipboard',
			);

			register_post_type('dt_payments', $args );
		}

		function dt_admin_init() {
			add_filter ( "manage_edit-dt_payments_columns", array (
				$this,
				"dt_payments_edit_columns"
			) );

			add_action ( "manage_posts_custom_column", array (
				$this,
				"dt_payments_columns_display"
			), 10, 2 );
		}

		function dt_payments_post_submenu() {
			add_submenu_page( 'dt_calendar', esc_html__('Payments', 'wedesigntech-ultimate-booking-addon'), esc_html__('Payments', 'wedesigntech-ultimate-booking-addon'), 'manage_options','edit.php?post_type=dt_payments');
		}

		function dt_payments_cs_metabox_options( $options ) {

			$options[]    = array(
			  'id'        => '_info',
			  'title'     => esc_html__('Payment Options', 'wedesigntech-ultimate-booking-addon'),
			  'post_type' => 'dt_payments',
			  'context'   => 'normal',
			  'priority'  => 'default',
			  'sections'  => array(
				array(
				  'name'   => 'orders_section',
				  'title'  => esc_html__('Orders', 'wedesigntech-ultimate-booking-addon'),
				  'icon'   => 'fa fa-gift',

				  'fields' => array(
					array(
					  'id'    => 'order_date',
					  'type'  => 'text',
					  'title' => esc_html__('Order Date', 'wedesigntech-ultimate-booking-addon'),
					),
					array(
					  'id'    => 'order_type',
					  'type'  => 'text',
					  'title' => esc_html__('Order Type', 'wedesigntech-ultimate-booking-addon'),
					),
					array(
					  'id'    => 'order_service',
					  'type'  => 'text',
					  'title' => esc_html__('Service', 'wedesigntech-ultimate-booking-addon'),
					),
					array(
					  'id'    => 'order_status',
					  'type'  => 'text',
					  'title' => esc_html__('Order Status', 'wedesigntech-ultimate-booking-addon'),
					),
					array(
					  'id'    => 'order_transid',
					  'type'  => 'text',
					  'title' => esc_html__('Transaction ID', 'wedesigntech-ultimate-booking-addon'),
					),
					array(
					  'id'    => 'order_amount',
					  'type'  => 'text',
					  'title' => esc_html__('Amount', 'wedesigntech-ultimate-booking-addon'),
					),
				  ), // end: fields
				), // end: a section

				array(
				  'name'  => 'address_section',
				  'title' => esc_html__('Address', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-map-pin',

				  'fields' => array(
					array(
					  'id'    => 'firstname',
					  'type'  => 'text',
					  'title' => esc_html__('First Name', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'lastname',
					  'type'  => 'text',
					  'title' => esc_html__('Last Name', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'address',
					  'type'  => 'text',
					  'title' => esc_html__('Address', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'      => 'country',
					  'type'    => 'select',
					  'title'   => esc_html__('Country', 'wedesigntech-ultimate-booking-addon'),
					  'options' => ultimate_booking_pro_countries_array(),
					  'class'   => 'chosen',
					  'attributes' => array(
						'style' => 'width: 63%;',
					  )
					),

					array(
					  'id'    => 'city',
					  'type'  => 'text',
					  'title' => esc_html__('City', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'state',
					  'type'  => 'text',
					  'title' => esc_html__('State', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'pincode',
					  'type'  => 'text',
					  'title' => esc_html__('Pin Code', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'phone',
					  'type'  => 'text',
					  'title' => esc_html__('Phone', 'wedesigntech-ultimate-booking-addon'),
					  'attributes' => array(
						'placeholder' => '022-65265'
					  )
					),

					array(
					  'id'    => 'aboutyourproject',
					  'type'  => 'text',
					  'title' => esc_html__('Notes', 'wedesigntech-ultimate-booking-addon'),
					),

					array(
					  'id'    => 'emailid',
					  'type'  => 'text',
					  'title' => esc_html__('Email Id', 'wedesigntech-ultimate-booking-addon'),
					  'attributes' => array(
						'placeholder' => 'testmail@domain.com',
					  )
					),

				    array(
					  'id'      => 'customer_id',
					  'type'    => 'select',
					  'title'   => esc_html__('Customer', 'wedesigntech-ultimate-booking-addon'),
					  'options' => 'posts',
					  'query_args' => array(
						'post_type'      => 'dt_customers',
						'orderby'        => 'ID',
						'order'          => 'ASC',
						'posts_per_page' => -1,
					  ),
					  'class'   => 'chosen',
					  'default_option' => esc_html__('Guest', 'wedesigntech-ultimate-booking-addon'),
					  'attributes' => array(
						'style' => 'width: 60%;',
					  )
				    ),

				  ), // end: fields
				), // end: a section

			  ),
			);

			return $options;
		}

		function dt_payments_edit_columns($columns) {

			$newcolumns = array (
				"cb"         => "<input type=\"checkbox\" />",
				"title"      => esc_html__("Title", 'wedesigntech-ultimate-booking-addon'),
				"order_date" => esc_html__("Order Date", 'wedesigntech-ultimate-booking-addon'),
				"type"       => esc_html__("Order Type", 'wedesigntech-ultimate-booking-addon'),
				"cost"       => esc_html__("Cost", 'wedesigntech-ultimate-booking-addon'),
				"status"     => esc_html__("Status", 'wedesigntech-ultimate-booking-addon'),
			);

			$columns = array_merge ( $newcolumns, $columns );
			unset($columns['date']);
			return $columns;
		}

		function dt_payments_columns_display($columns, $id) {
			global $post;

			$payment_settings = get_post_meta ( $post->ID, '_info', TRUE );
			$payment_settings = is_array ( $payment_settings ) ? $payment_settings : array ();

			switch ($columns) {

				case "order_date" :
					if( array_key_exists("order_date", $payment_settings) && $payment_settings['order_date'] != '' ) {
						echo "{$payment_settings['order_date']}";
					}
				break;

				case "type" :
					if( array_key_exists("order_type", $payment_settings) && $payment_settings['order_type'] != '' ) {
						echo "{$payment_settings['order_type']}";
					}
				break;

				case "cost" :
					if( array_key_exists("order_amount", $payment_settings) && $payment_settings['order_amount'] != '' ) {
						echo "{$payment_settings['order_amount']}";
					}
				break;

				case "status" :
					if( array_key_exists("order_status", $payment_settings) && $payment_settings['order_status'] != '' ) {
						echo "{$payment_settings['order_status']}";
					} else {
						echo esc_html__('Completed', 'wedesigntech-ultimate-booking-addon');
					}
				break;
			}
		}
	}
}