<?php
if (! class_exists ( 'DTStaffPostType' )) {
	class DTStaffPostType {

		function __construct() {
			// Add Hook into the 'init()' action
			add_action ( 'init', array (
					$this,
					'dt_init'
			) );

			// Add Hook into the 'admin_init()' action
			add_action ( 'admin_init', array (
					$this,
					'dt_admin_init'
			) );

			// Add Hook into the 'admin_enqueue_scripts' filter
			add_action( 'admin_enqueue_scripts', array (
					$this,
					'dt_staff_admin_scripts'
			) );

			// Add Hook into the 'cs_framework_options' filter
			add_filter ( 'cs_framework_options', array (
					$this,
					'dt_staff_cs_framework_options'
			) );

			// Add Hook into the 'cs_metabox_options' filter
			add_filter ( 'cs_metabox_options', array (
					$this,
					'dt_staff_cs_metabox_options'
			) );
		}

		/**
		 * A function hook that the WordPress core launches at 'init' points
		 */
		function dt_init() {
			$this->createPostType ();

			add_action ( 'save_post', array (
					$this,
					'dt_staff_save_post_meta'
			) );
		}

		/**
		 * A function hook that the WordPress core launches at 'admin_init' points
		 */
		function dt_admin_init() {
			add_filter ( "manage_edit-dt_staff_columns", array (
					$this,
					"dt_staff_edit_columns"
			) );

			add_action ( "manage_posts_custom_column", array (
					$this,
					"dt_staff_columns_display"
			), 10, 2 );
		}

		/**
		 * custom admin scripts & styles
		 */
		function dt_staff_admin_scripts( $hook ) {

			if( $hook == "edit.php" ) {
				wp_enqueue_style ( 'dt-staff-admin', plugins_url ('wedesigntech-ultimate-booking-addon') . '/post-types/css/admin-styles.css', array (), false, 'all' );
			}
		}

		/**
		 * Creating a post type
		 */
		function createPostType() {

			$staffslug              = ultimate_booking_pro_cs_get_option( 'single-staff-slug', 'dt_staff' );
			$staff_singular         = ultimate_booking_pro_cs_get_option( 'singular-staff-text', esc_html__('Staff', 'wedesigntech-ultimate-booking-addon') );
			$staff_plural           = ultimate_booking_pro_cs_get_option( 'plural-staff-text', esc_html__('Staffs', 'wedesigntech-ultimate-booking-addon') );
			$staffdepartslug        = ultimate_booking_pro_cs_get_option( 'staff-department-slug', 'dt_staff_department' );
			$staff_depart_singular  = ultimate_booking_pro_cs_get_option( 'singular-staff-department-text', esc_html__('Department', 'wedesigntech-ultimate-booking-addon') );
			$staff_depart_plural    = ultimate_booking_pro_cs_get_option( 'plural-staff-department-text', esc_html__('Departments', 'wedesigntech-ultimate-booking-addon') );

			$labels = array (
				'name' 				 => $staff_plural,
				'all_items' 		 => esc_html__( 'All', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_plural,
				'singular_name' 	 => $staff_singular,
				'add_new' 			 => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ),
				'add_new_item' 		 => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular,
				'edit_item' 		 => esc_html__( 'Edit', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular,
				'new_item' 			 => esc_html__( 'New', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular,
				'view_item' 		 => esc_html__( 'View', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular,
				'search_items' 		 => esc_html__( 'Search', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular,
				'not_found' 		 => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon').' '.$staff_plural.' '.esc_html__('found', 'wedesigntech-ultimate-booking-addon' ),
				'not_found_in_trash' => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon').' '.$staff_plural.' '.esc_html__('found in Trash', 'wedesigntech-ultimate-booking-addon' ),
				'parent_item_colon'  => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_singular.':',
				'menu_name' 		 => $staff_plural,
			);

			$args = array (
				'labels' 				=> $labels,
				'hierarchical' 			=> false,
				'description' 			=> esc_html__( 'Post type archives of ', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_plural,
				'supports' 				=> array (
											'title',
											'editor',
											'excerpt',
											'comments',
											'thumbnail'
										),
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_menu' 			=> true,
				'menu_position' 		=> 9,
				'menu_icon' 			=> 'dashicons-businessman',

				'show_in_nav_menus' 	=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'has_archive' 			=> true,
				'query_var' 			=> true,
				'can_export' 			=> true,
				'rewrite' 				=> array( 'slug' => $staffslug ),
				'capability_type' 		=> 'post'
			);

			register_post_type ( 'dt_staff', $args );

			if( cs_get_option('enable-staff-taxonomy') ):
				// Staff Departments
				$labels = array(
					'name'              => $staff_depart_plural,
					'singular_name'     => $staff_depart_singular,
					'search_items'      => esc_html__( 'Search', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_plural,
					'all_items'         => esc_html__( 'All', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_plural,
					'parent_item'       => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular,
					'parent_item_colon' => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular.':',
					'edit_item'         => esc_html__( 'Edit', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular,
					'update_item'       => esc_html__( 'Update', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular,
					'add_new_item'      => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular,
					'new_item_name'     => esc_html__( 'New', 'wedesigntech-ultimate-booking-addon' ).' '.$staff_depart_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
					'menu_name'         => $staff_depart_plural,
				);

				register_taxonomy ( 'dt_staff_department', array (
					'dt_staff'
				), array (
					'hierarchical' 		=> true,
					'labels' 			=> $labels,
					'show_admin_column' => true,
					'rewrite' 			=> array( 'slug' => $staffdepartslug ),
					'query_var' 		=> true
				) );
			endif;
		}

		/**
		 * Staff framework options
		 */
		function dt_staff_cs_framework_options( $options ) {

			$staffslug             = ultimate_booking_pro_cs_get_option( 'single-staff-slug', 'dt_staff' );
			$staff_singular        = ultimate_booking_pro_cs_get_option( 'singular-staff-text', esc_html__('Staff', 'wedesigntech-ultimate-booking-addon') );
			$staff_plural          = ultimate_booking_pro_cs_get_option( 'plural-staff-text', esc_html__('Staffs', 'wedesigntech-ultimate-booking-addon') );
			$staffdepartslug       = ultimate_booking_pro_cs_get_option( 'staff-department-slug', 'dt_staff_department' );
			$staff_depart_singular = ultimate_booking_pro_cs_get_option( 'singular-staff-department-text', esc_html__('Department', 'wedesigntech-ultimate-booking-addon') );
			$staff_depart_plural   = ultimate_booking_pro_cs_get_option( 'plural-staff-department-text', esc_html__('Departments', 'wedesigntech-ultimate-booking-addon') );

			$options['booking-manager']['sections'][] = array(

				// -----------------------------------------
				// Staff Options
				// -----------------------------------------
				'name'      => 'staff_options',
				'title'     => $staff_singular.' '.esc_html__('Options', 'wedesigntech-ultimate-booking-addon'),
				'icon'      => 'fa fa-user',

				  'fields'      => array(
					  array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Staff Archives Post Layout', 'wedesigntech-ultimate-booking-addon' ),
					  ),

					  array(
						'id'      	   => 'staff-archives-post-layout',
						'type'         => 'image_select',
						'title'        => esc_html__('Post Layout', 'wedesigntech-ultimate-booking-addon'),
						'options'      => array(
						  'one-half-column'   => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-half-column.png',
						  'one-third-column'  => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-third-column.png',
						  'one-fourth-column' => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-fourth-column.png',
						),
						'default'      => 'one-half-column',
					  ),

					  array(
						'id'           => 'staff-archives-post-style',
						'type'         => 'select',
						'title'        => esc_html__('Style', 'wedesigntech-ultimate-booking-addon'),
						'options'      => array(
							''                                           => esc_html__('Default', 'wedesigntech-ultimate-booking-addon'),
							'hide-social-show-on-hover'                  => esc_html__('Social on hover', 'wedesigntech-ultimate-booking-addon'),
							'hide-social-role-show-on-hover'             => esc_html__('Social and Role on hover', 'wedesigntech-ultimate-booking-addon'),
							'hide-details-show-on-hover'                 => esc_html__('Details on hover', 'wedesigntech-ultimate-booking-addon'),
							'hide-social-show-on-hover details-on-image' => esc_html__('Show details & Social on hover', 'wedesigntech-ultimate-booking-addon'),
							'type2'                                      => esc_html__('Horizontal', 'wedesigntech-ultimate-booking-addon'),
							'hide-social-show-on-hover rounded'          => esc_html__('Rounded', 'wedesigntech-ultimate-booking-addon')
						),
						'class'        => 'chosen',
						'default'      => '',
						'info'         => esc_html__('Choose post style to display archive page.', 'wedesigntech-ultimate-booking-addon')
					  ),

					  array(
						'id'  	=> 'staff-archives-excerpt',
						'type'  => 'switcher',
						'title' => esc_html__('Show Excerpt', 'wedesigntech-ultimate-booking-addon'),
						'label'	=> esc_html__("YES! to enable staff's excerpt", "wdt-ultimate-booking")
					  ),

					  array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Bulk Custom Fields', 'wedesigntech-ultimate-booking-addon' ),
					  ),

					  array(
						'id'              => 'staff-custom-fields',
						'type'            => 'group',
						'title'           => esc_html__('Custom Fields', 'wedesigntech-ultimate-booking-addon'),
						'info'            => esc_html__('Click button to add custom fields like cost, url and available etc', 'wedesigntech-ultimate-booking-addon'),
						'button_title'    => esc_html__('Add New Field', 'wedesigntech-ultimate-booking-addon'),
						'accordion_title' => esc_html__('Adding New Custom Field', 'wedesigntech-ultimate-booking-addon'),
						'fields'          => array(
						  array(
							'id'          => 'staff-custom-fields-text',
							'type'        => 'text',
							'title'       => esc_html__('Enter Text', 'wedesigntech-ultimate-booking-addon')
						  ),
						)
					  ),

					  array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Permalinks', 'wedesigntech-ultimate-booking-addon' ),
					  ),

					  array(
						'id'      => 'singular-staff-text',
						'type'    => 'text',
						'title'   => esc_html__('Singular', 'wedesigntech-ultimate-booking-addon').' '.$staff_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $staff_singular,
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'plural-staff-text',
						'type'    => 'text',
						'title'   => esc_html__('Plural', 'wedesigntech-ultimate-booking-addon').' '.$staff_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $staff_plural,
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'singular-staff-department-text',
						'type'    => 'text',
						'title'   => esc_html__('Singular', 'wedesigntech-ultimate-booking-addon').' '.$staff_depart_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $staff_depart_singular,
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'plural-staff-department-text',
						'type'    => 'text',
						'title'   => esc_html__('Plural', 'wedesigntech-ultimate-booking-addon').' '.$staff_depart_plural.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $staff_depart_plural,
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'single-staff-slug',
						'type'    => 'text',
						'title'   => esc_html__('Single', 'wedesigntech-ultimate-booking-addon').' '.$staff_singular.' '.esc_html__('Slug', 'wedesigntech-ultimate-booking-addon'),
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Do not use characters not allowed in links. Use, eg. staff-item ', 'wedesigntech-ultimate-booking-addon').'<br> <b>'.esc_html__('After made changes save permalinks.', 'wedesigntech-ultimate-booking-addon').'</b></p>',
					  ),

					  array(
						'id'      => 'staff-department-slug',
						'type'    => 'text',
						'title'   => $staff_singular.' '.$staff_depart_singular.' '.esc_html__('Slug', 'wedesigntech-ultimate-booking-addon'),
						'after' 	=> '<p class="cs-text-info">'.esc_html__('Do not use characters not allowed in links. Use, eg. staff-type ', 'wedesigntech-ultimate-booking-addon').'<br> <b>'.esc_html__('After made changes save permalinks.', 'wedesigntech-ultimate-booking-addon').'</b></p>',
					  ),
				  ),
			);

			// Filter to add additional options for themes
			$options = apply_filters( 'ultimate_booking_pro_template_framework_options', $options );

			return $options;
		}

		/**
		 * Staff metabox options
		 */
		function dt_staff_cs_metabox_options( $options ) {

			global $timearray;

			$monday    = cs_get_option('appointment_fs1');
			$ultimate_booking_pro_monday_start = (isset($monday['ultimate_booking_pro_monday_start']) && !empty($monday['ultimate_booking_pro_monday_start'])) ? $monday['ultimate_booking_pro_monday_start'] : '';
			$ultimate_booking_pro_monday_end = (isset($monday['ultimate_booking_pro_monday_end']) && !empty($monday['ultimate_booking_pro_monday_end'])) ? $monday['ultimate_booking_pro_monday_end'] : '';
			$tuesday   = cs_get_option('appointment_fs2');
			$ultimate_booking_pro_tuesday_start = (isset($tuesday['ultimate_booking_pro_tuesday_start']) && !empty($tuesday['ultimate_booking_pro_tuesday_start'])) ? $tuesday['ultimate_booking_pro_tuesday_start'] : '';
			$ultimate_booking_pro_tuesday_end = (isset($tuesday['ultimate_booking_pro_tuesday_end']) && !empty($tuesday['ultimate_booking_pro_tuesday_end'])) ? $tuesday['ultimate_booking_pro_tuesday_end'] : '';
			$wednesday = cs_get_option('appointment_fs3');
			$ultimate_booking_pro_wednesday_start = (isset($wednesday['ultimate_booking_pro_wednesday_start']) && !empty($wednesday['ultimate_booking_pro_wednesday_start'])) ? $wednesday['ultimate_booking_pro_wednesday_start'] : '';
			$ultimate_booking_pro_wednesday_end = (isset($wednesday['ultimate_booking_pro_wednesday_end']) && !empty($wednesday['ultimate_booking_pro_wednesday_end'])) ? $wednesday['ultimate_booking_pro_wednesday_end'] : '';
			$thursday  = cs_get_option('appointment_fs4');
			$ultimate_booking_pro_thursday_start = (isset($thursday['ultimate_booking_pro_thursday_start']) && !empty($thursday['ultimate_booking_pro_thursday_start'])) ? $thursday['ultimate_booking_pro_thursday_start'] : '';
			$ultimate_booking_pro_thursday_end = (isset($thursday['ultimate_booking_pro_thursday_end']) && !empty($thursday['ultimate_booking_pro_thursday_end'])) ? $thursday['ultimate_booking_pro_thursday_end'] : '';
			$friday    = cs_get_option('appointment_fs5');
			$ultimate_booking_pro_friday_start = (isset($friday['ultimate_booking_pro_friday_start']) && !empty($friday['ultimate_booking_pro_friday_start'])) ? $friday['ultimate_booking_pro_friday_start'] : '';
			$ultimate_booking_pro_friday_end = (isset($friday['ultimate_booking_pro_friday_end']) && !empty($friday['ultimate_booking_pro_friday_end'])) ? $friday['ultimate_booking_pro_friday_end'] : '';
			$saturday  = cs_get_option('appointment_fs6');
			$ultimate_booking_pro_saturday_start = (isset($saturday['ultimate_booking_pro_saturday_start']) && !empty($saturday['ultimate_booking_pro_saturday_start'])) ? $saturday['ultimate_booking_pro_saturday_start'] : '';
			$ultimate_booking_pro_saturday_end = (isset($saturday['ultimate_booking_pro_saturday_end']) && !empty($saturday['ultimate_booking_pro_saturday_end'])) ? $saturday['ultimate_booking_pro_saturday_end'] : '';
			$sunday    = cs_get_option('appointment_fs7');
			$ultimate_booking_pro_sunday_start = (isset($sunday['ultimate_booking_pro_sunday_start']) && !empty($sunday['ultimate_booking_pro_sunday_start'])) ? $sunday['ultimate_booking_pro_sunday_start'] : '';
			$ultimate_booking_pro_sunday_end = (isset($sunday['ultimate_booking_pro_sunday_end']) && !empty($sunday['ultimate_booking_pro_sunday_end'])) ? $sunday['ultimate_booking_pro_sunday_end'] : '';

			$fields = cs_get_option( 'staff-custom-fields');
			$bothfields = $fielddef = $x = array();
			$before = '';

			if(!empty($fields)) :

				$i = 1;
				foreach($fields as $field):
					$x['id'] = 'staff_opt_flds_title_'.$i;
					$x['type'] = 'text';
					$x['title'] = 'Title';
					$x['attributes'] = array( 'style' => 'background-color: #f0eff9;' );
					$bothfields[] = $x;
					unset($x);

					$x['id'] = 'staff_opt_flds_value_'.$i;
					$x['type'] = 'text';
					$x['title'] = 'Value';
					$bothfields[] = $x;

					$fielddef['staff_opt_flds_title_'.$i] = $field['staff-custom-fields-text'];

					$i++;
				endforeach;
			else:
				$before = '<span>'.esc_html__('Go to options panel add few custom fields, then return back here.', 'wedesigntech-ultimate-booking-addon').'</span>';
			endif;

			$service_plural = ultimate_booking_pro_cs_get_option( 'plural-service-text', esc_html__('Services', 'wedesigntech-ultimate-booking-addon') );
			$staff_singular = ultimate_booking_pro_cs_get_option( 'singular-staff-text', esc_html__('Staff', 'wedesigntech-ultimate-booking-addon') );

			$symbol = ultimate_booking_pro_get_currency_symbol();

			$options[]    = array(
			  'id'        => '_custom_settings',
			  'title'     => esc_html__('Custom Staff Options', 'wedesigntech-ultimate-booking-addon'),
			  'post_type' => 'dt_staff',
			  'context'   => 'normal',
			  'priority'  => 'default',
			  'sections'  => array(

				array(
				  'name'  => 'gallery_section',
				  'title' => esc_html__('Gallery Options', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-picture-o',

				  'fields' => array(

					array(
					  'id'          => 'staff-gallery',
					  'type'        => 'gallery',
					  'title'       => esc_html__('Gallery Images', 'wedesigntech-ultimate-booking-addon'),
					  'desc'        => esc_html__('Simply add images to gallery items.', 'wedesigntech-ultimate-booking-addon'),
					  'add_title'   => esc_html__('Add Images', 'wedesigntech-ultimate-booking-addon'),
					  'edit_title'  => esc_html__('Edit Images', 'wedesigntech-ultimate-booking-addon'),
					  'clear_title' => esc_html__('Remove Images', 'wedesigntech-ultimate-booking-addon')
					),

				  ), // end: fields
				), // end: a section

				array(
				  'name'  => 'mand_section',
				  'title' => esc_html__('Mandatory Fields', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-envelope-o',

				  'fields' => array(

					array(
					  'id'      => 'staff-price',
					  'type'    => 'number',
					  'title'   => esc_html__('Cost', 'wedesigntech-ultimate-booking-addon'),
					  'after'	=> '&nbsp;'.$symbol,
					  'desc'    => '<p class="cs-text-muted">'.esc_html__('Put a valid price here', 'wedesigntech-ultimate-booking-addon').'</p>',
					  'attributes' => array(
						'style'    => 'width: 90px;'
					  )
					),

					array(
					  'id'      => 'staff-role',
					  'type'    => 'text',
					  'title'   => esc_html__('Role', 'wedesigntech-ultimate-booking-addon'),
					  'after'   => '<p class="cs-text-muted">'.esc_html__('Put designation here', 'wedesigntech-ultimate-booking-addon').'</p>',
					  'attributes' => array(
						'style'    => 'width: 263px;'
					  )
					),

					array(
					  'id'      => 'staff-email',
					  'type'    => 'text',
					  'title'   => esc_html__('Email Address', 'wedesigntech-ultimate-booking-addon'),
					  'after'   => '<p class="cs-text-muted">'.esc_html__('Put a valid email here', 'wedesigntech-ultimate-booking-addon').'</p>',
					  'attributes' => array(
						'style'    => 'width: 263px;'
					  )
					),

					array(
					  'id'  	=> 'staff-social',
					  'type'  	=> 'textarea',
					  'title' 	=> esc_html__('Social Profile', 'wedesigntech-ultimate-booking-addon'),
					  'info'	=> esc_html__('Add / Edit social link as you like here', 'wedesigntech-ultimate-booking-addon'),
					  'default'	=> '[dt_sc_social facebook="#" twitter="#" google="#" linkedin="#" /]',
					  'attributes' => array(
						'rows'  => 3,
						'style'	=> 'min-height:75px;'
					  )
					),

					array(
					  'id'          => 'staff-services',
					  'type'        => 'select',
					  'title'       => $service_plural,
					  'options'     => ultimate_booking_pro_get_posts_array('service'),
					  'class'       => 'chosen',
					  'attributes'  => array(
						'multiple'  => 'only-key',
						'style'     => 'width: 245px;'
					  ),
					  'info'        => esc_html__('Choose any services for this', 'wedesigntech-ultimate-booking-addon').' '.strtolower($staff_singular).'.'
					),

				  ), // end: fields
				), // end: a section

				array(
				  'name'  => 'schedule_section',
				  'title' => esc_html__('Schedule Options', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-clock-o',

				  'fields' => array(

					array(
					  'id'        => 'appointment_fs1',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Monday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_monday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_monday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_monday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_monday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_monday_start'       => $ultimate_booking_pro_monday_start,
						'ultimate_booking_pro_monday_end'         => $ultimate_booking_pro_monday_end,
						'ultimate_booking_pro_monday_break_start' => '',
						'ultimate_booking_pro_monday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs2',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Tuesday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_tuesday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_tuesday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_tuesday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_tuesday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_tuesday_start'       => $ultimate_booking_pro_tuesday_start,
						'ultimate_booking_pro_tuesday_end'         => $ultimate_booking_pro_tuesday_end,
						'ultimate_booking_pro_tuesday_break_start' => '',
						'ultimate_booking_pro_tuesday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs3',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Wednesday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_wednesday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_wednesday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_wednesday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_wednesday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_wednesday_start'       => $ultimate_booking_pro_wednesday_start,
						'ultimate_booking_pro_wednesday_end'         => $ultimate_booking_pro_wednesday_end,
						'ultimate_booking_pro_wednesday_break_start' => '',
						'ultimate_booking_pro_wednesday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs4',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Thursday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_thursday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_thursday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_thursday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_thursday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_thursday_start'       => $ultimate_booking_pro_thursday_start,
						'ultimate_booking_pro_thursday_end'         => $ultimate_booking_pro_thursday_end,
						'ultimate_booking_pro_thursday_break_start' => '',
						'ultimate_booking_pro_thursday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs5',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Friday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_friday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_friday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),
						array(
							'id'      => 'ultimate_booking_pro_friday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_friday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_friday_start'       => $ultimate_booking_pro_friday_start,
						'ultimate_booking_pro_friday_end'         => $ultimate_booking_pro_friday_end,
						'ultimate_booking_pro_friday_break_start' => '',
						'ultimate_booking_pro_friday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs6',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Saturday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_saturday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_saturday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),
						array(
							'id'      => 'ultimate_booking_pro_saturday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_saturday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

					  ),
					  'default'   => array(
						'ultimate_booking_pro_saturday_start'       => $ultimate_booking_pro_saturday_start,
						'ultimate_booking_pro_saturday_end'         => $ultimate_booking_pro_saturday_end,
						'ultimate_booking_pro_saturday_break_start' => '',
						'ultimate_booking_pro_saturday_break_end'   => ''
					  )
					),

					array(
					  'id'        => 'appointment_fs7',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Sunday', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => array(

						array(
							'id'      => 'ultimate_booking_pro_sunday_start',
							'type'    => 'select',
							'title'   => esc_html__('Available From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_sunday_end',
							'type'    => 'select',
							'title'   => esc_html__('Available To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),
						array(
							'id'      => 'ultimate_booking_pro_sunday_break_start',
							'type'    => 'select',
							'title'   => esc_html__('Break From:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),

						array(
							'id'      => 'ultimate_booking_pro_sunday_break_end',
							'type'    => 'select',
							'title'   => esc_html__('Break To:', 'wedesigntech-ultimate-booking-addon'),
							'options' => $timearray,
							'class'   => 'chosen',
						),
					  ),
					  'default'   => array(
						'ultimate_booking_pro_sunday_start'       => $ultimate_booking_pro_sunday_start,
						'ultimate_booking_pro_sunday_end'         => $ultimate_booking_pro_sunday_end,
						'ultimate_booking_pro_sunday_break_start' => '',
						'ultimate_booking_pro_sunday_break_end'   => ''
					  )
					),

				  ), // end: fields
				), // end: a section

				array(
				  'name'  => 'optional_section',
				  'title' => esc_html__('Optional Fields', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-plug',

				  'fields' => array(

					array(
					  'id'        => 'staff_opt_flds',
					  'type'      => 'fieldset',
					  'title'     => esc_html__('Optional Fields', 'wedesigntech-ultimate-booking-addon'),
					  'fields'    => $bothfields,
					  'default'   => $fielddef,
					  'before' 	  => $before
					),

				  ), // end: fields
				), // end: a section

			  ),
			);

			// Filter to add additional options for themes
			$options = apply_filters( 'ultimate_booking_pro_template_metabox_options', $options );

			return $options;
		}

		/**
		 *
		 * @param unknown $columns
		 * @return multitype:
		 */
		function dt_staff_edit_columns($columns) {

			$newcolumns = array (
				"cb"             => "<input type=\"checkbox\" />",
				"dt_staff_thumb" => esc_html__("Image", 'wedesigntech-ultimate-booking-addon'),
				"title"          => esc_html__("Title", 'wedesigntech-ultimate-booking-addon'),
				"cost"           => esc_html__("Cost", 'wedesigntech-ultimate-booking-addon'),
			);

			$columns = array_merge ( $newcolumns, $columns );
			return $columns;
		}

		/**
		 *
		 * @param unknown $columns
		 * @param unknown $id
		 */
		function dt_staff_columns_display($columns, $id) {
			global $post;

			$staff_settings = get_post_meta ( $post->ID, '_custom_settings', TRUE );
			$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();

			switch ($columns) {

				case "dt_staff_thumb" :
				    $image = wp_get_attachment_image(get_post_thumbnail_id($id), array(75,75));
					if(!empty($image)):
					  	echo "{$image}";
				    else:
						if( array_key_exists("staff-gallery", $staff_settings)) {
							$items = explode(',', $staff_settings["staff-gallery"]);
							echo wp_get_attachment_image( $items[0], array(75, 75) );
						}
					endif;
				break;

				case "cost" :
					if( array_key_exists("staff-price", $staff_settings) && $staff_settings['staff-price'] != '' ) {
						echo ultimate_booking_pro_get_currency_symbol().floatval( $staff_settings['staff-price'] );
					}
				break;
			}
		}

		/**
		 *
		 * @param $post_id
		 * @return none:
		 */
		function dt_staff_save_post_meta($post_id) {

			if( key_exists ( '_inline_edit',$_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dt_staff' == $_POST['post_type']) ) :

				$services = isset($_POST['_custom_settings']) ? ultimate_booking_pro_sanitization($_POST['_custom_settings']['staff-services']) : '';
				if( $services != '' ):
					update_post_meta ( $post_id, '_ultimate_booking_pro_staff_services', array_filter ( $services ) );
				endif;

			endif;
		}
	}
}