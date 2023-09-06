<?php
if ( !class_exists( 'DTCustomerPostType' ) ) {

	class DTCustomerPostType {

		function __construct() {
			add_action ( 'init', array (
				$this,
				'dt_init'
			) );

			add_action ( 'admin_init', array (
				$this,
				'dt_admin_init'
			) );

			add_filter ( 'cs_metabox_options', array(
				$this,
				'dt_customers_cs_metabox_options'
			) );

			add_action( 'admin_menu', array(
				$this,
				'dt_customers_post_submenu'
			) );
		}

		function dt_init() {
			$labels = array(
				'name' => esc_html__('Customers', 'wedesigntech-ultimate-booking-addon' ),
				'singular_name' => esc_html__('Customer', 'wedesigntech-ultimate-booking-addon' ),
				'menu_name' => esc_html__('Calendar', 'wedesigntech-ultimate-booking-addon' ),
				'add_new' => esc_html__('Add Customer', 'wedesigntech-ultimate-booking-addon' ),
				'add_new_item' => esc_html__('Add New Customer', 'wedesigntech-ultimate-booking-addon' ),
				'edit' => esc_html__('Edit Customer', 'wedesigntech-ultimate-booking-addon' ),
				'edit_item' => esc_html__('Edit Customer', 'wedesigntech-ultimate-booking-addon' ),
				'new_item' => esc_html__('New Customer', 'wedesigntech-ultimate-booking-addon' ),
				'view' => esc_html__('View Customer', 'wedesigntech-ultimate-booking-addon' ),
				'view_item' => esc_html__('View Customer', 'wedesigntech-ultimate-booking-addon' ),
				'search_items' => esc_html__('Search Customers', 'wedesigntech-ultimate-booking-addon' ),
				'not_found' => esc_html__('No Customers found', 'wedesigntech-ultimate-booking-addon' ),
				'not_found_in_trash' => esc_html__('No Customers found in Trash', 'wedesigntech-ultimate-booking-addon' ),
				'parent_item_colon' => esc_html__('Parent Customer:', 'wedesigntech-ultimate-booking-addon' ),
			);

			$args = array(
				'labels' => $labels,
				'hierarchical' => false,
				'description' => esc_html__('This is Custom Post type named as Customers','wedesigntech-ultimate-booking-addon'),
				'supports' => array('title'),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => 'admin.php?page=dt_calendar',
				'show_in_admin_bar' => true,
				'menu_position' => 7,
				'menu_icon' => 'dashicons-clipboard',
			);

			register_post_type('dt_customers', $args );
		}

		function dt_admin_init() {
			add_filter ( "manage_edit-dt_customers_columns", array (
				$this,
				"dt_customers_edit_columns"
			) );

			add_action ( "manage_posts_custom_column", array (
				$this,
				"dt_customers_columns_display"
			), 10, 2 );
		}

		function dt_customers_post_submenu() {
			add_submenu_page( 'dt_calendar', esc_html__('Customers', 'wedesigntech-ultimate-booking-addon'), esc_html__('Customers', 'wedesigntech-ultimate-booking-addon'), 'manage_options','edit.php?post_type=dt_customers');
		}

		function dt_customers_cs_metabox_options( $options ) {

			$options[]    = array(
			  'id'        => '_info',
			  'title'     => esc_html__('Customer Options', 'wedesigntech-ultimate-booking-addon'),
			  'post_type' => 'dt_customers',
			  'context'   => 'normal',
			  'priority'  => 'default',
			  'sections'  => array(

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
					  'options' => ultimate_booking_pro_get_wp_users(),
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

		function dt_customers_edit_columns($columns) {

			$newcolumns = array (
				"cb"         => "<input type=\"checkbox\" />",
				"title"      => esc_html__("Title", 'wedesigntech-ultimate-booking-addon'),
				"address" 	 => esc_html__("Address", 'wedesigntech-ultimate-booking-addon'),
				"user"     	 => esc_html__("User", 'wedesigntech-ultimate-booking-addon'),
			);

			$columns = array_merge ( $newcolumns, $columns );
			unset($columns['date']);
			return $columns;
		}

		function dt_customers_columns_display($columns, $id) {
			global $post;

			$customer_settings = get_post_meta ( $post->ID, '_info', TRUE );
			$customer_settings = is_array ( $customer_settings ) ? $customer_settings : array ();

			switch ($columns) {

				case "address" :
					if( array_key_exists("address", $customer_settings) && $customer_settings['address'] != '' ) {
						echo "{$customer_settings['address']}";
					}
					if( array_key_exists("city", $customer_settings) && $customer_settings['city'] != '' ) {
						echo ', '.$customer_settings['city'];
					}
					if( array_key_exists("state", $customer_settings) && $customer_settings['state'] != '' ) {
						echo ', '.$customer_settings['state'];
					}
					if( array_key_exists("country", $customer_settings) && $customer_settings['country'] != '' ) {
						echo "<br>".$customer_settings['country'];
					}
					if( array_key_exists("pincode", $customer_settings) && $customer_settings['pincode'] != '' ) {
						echo ' - '.$customer_settings['pincode'];
					}
				break;

				case "user" :
					if( array_key_exists("customer_id", $customer_settings) && $customer_settings['customer_id'] != '' ) {
						$user_id     = $customer_settings['customer_id'];
						$user_info   = get_userdata($user_id);

						echo '<a href="'.get_edit_user_link( $user_id ).'" title="'.esc_attr__('Edit Profile', 'wedesigntech-ultimate-booking-addon').'">'.$user_info->user_login.' (#'.$user_id.' - '.$user_info->user_email.')';
					}
				break;
			}
		}
	}
}