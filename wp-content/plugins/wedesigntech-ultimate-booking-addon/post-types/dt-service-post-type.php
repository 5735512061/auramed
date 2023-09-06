<?php
if (! class_exists ( 'DTServicePostType' )) {
	class DTServicePostType {

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
					'dt_service_admin_scripts'
			) );

			// Add Hook into the 'cs_framework_options' filter
			add_filter ( 'cs_framework_options', array (
					$this,
					'dt_service_cs_framework_options'
			) );

			// Add Hook into the 'cs_metabox_options' filter
			add_filter ( 'cs_metabox_options', array (
					$this,
					'dt_service_cs_metabox_options'
			) );
		}

		/**
		 * A function hook that the WordPress core launches at 'init' points
		 */
		function dt_init() {
			$this->createPostType ();
		}

		/**
		 * A function hook that the WordPress core launches at 'admin_init' points
		 */
		function dt_admin_init() {
			add_filter ( "manage_edit-dt_service_columns", array (
					$this,
					"dt_service_edit_columns"
			) );

			add_action ( "manage_posts_custom_column", array (
					$this,
					"dt_service_columns_display"
			), 10, 2 );
		}

		/**
		 * custom admin scripts & styles
		 */
		function dt_service_admin_scripts( $hook ) {

			if( $hook == "edit.php" ) {
				wp_enqueue_style ( 'dt-service-admin', plugins_url ('wedesigntech-ultimate-booking-addon') . '/post-types/css/admin-styles.css', array (), false, 'all' );
			}
		}

		/**
		 * Creating a post type
		 */
		function createPostType() {

			$serviceslug 			= ultimate_booking_pro_cs_get_option( 'single-service-slug', 'dt_service' );
			$service_singular		= ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
			$service_plural			= ultimate_booking_pro_cs_get_option( 'plural-service-text', esc_html__('Services', 'wedesigntech-ultimate-booking-addon') );

			$servicecatslug  		= ultimate_booking_pro_cs_get_option( 'service-cat-slug', 'dt_service_category' );
			$service_cat_singular 	= ultimate_booking_pro_cs_get_option( 'singular-service-cat-text', esc_html__('Category', 'wedesigntech-ultimate-booking-addon') );
			$service_cat_plural		= ultimate_booking_pro_cs_get_option( 'plural-service-cat-text', esc_html__('Categories', 'wedesigntech-ultimate-booking-addon') );

			$labels = array (
				'name' 				 => $service_plural,
				'all_items' 		 => esc_html__( 'All', 'wedesigntech-ultimate-booking-addon' ).' '.$service_plural,
				'singular_name' 	 => $service_singular,
				'add_new' 			 => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ),
				'add_new_item' 		 => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ).' '.$service_singular,
				'edit_item' 		 => esc_html__( 'Edit', 'wedesigntech-ultimate-booking-addon' ).' '.$service_singular,
				'new_item' 			 => esc_html__( 'New', 'wedesigntech-ultimate-booking-addon' ).' '.$service_singular,
				'view_item' 		 => esc_html__( 'View', 'wedesigntech-ultimate-booking-addon' ).' '.$service_singular,
				'search_items' 		 => esc_html__( 'Search', 'wedesigntech-ultimate-booking-addon' ).' '.$service_plural,
				'not_found' 		 => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon').' '.$service_plural.' '.esc_html__('found', 'wedesigntech-ultimate-booking-addon' ),
				'not_found_in_trash' => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon').' '.$service_plural.' '.esc_html__('found in Trash', 'wedesigntech-ultimate-booking-addon' ),
				'parent_item_colon'  => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$service_singular.':',
				'menu_name' 		 => $service_plural,
			);

			$args = array (
				'labels' 				=> $labels,
				'hierarchical' 			=> false,
				'description' 			=> esc_html__( 'Post type archives of ', 'wedesigntech-ultimate-booking-addon' ).' '.$service_plural,
				'supports' 				=> array (
											'title',
											'editor',
											'comments',
											'thumbnail',
											'excerpt'
										),
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_menu' 			=> true,
				'menu_position' 		=> 8,
				'menu_icon' 			=> 'dashicons-carrot',

				'show_in_nav_menus' 	=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'has_archive' 			=> true,
				'query_var' 			=> true,
				'can_export' 			=> true,
				'rewrite' 				=> array( 'slug' => $serviceslug ),
				'capability_type' 		=> 'post'
			);

			register_post_type ( 'dt_service', $args );

			if( cs_get_option('enable-service-taxonomy') ):
				// Service Categories
				$labels = array(
					'name'              => $service_cat_plural,
					'singular_name'     => $service_cat_singular,
					'search_items'      => esc_html__( 'Search', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_plural,
					'all_items'         => esc_html__( 'All', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_plural,
					'parent_item'       => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular,
					'parent_item_colon' => esc_html__( 'Parent', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular.':',
					'edit_item'         => esc_html__( 'Edit', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular,
					'update_item'       => esc_html__( 'Update', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular,
					'add_new_item'      => esc_html__( 'Add New', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular,
					'new_item_name'     => esc_html__( 'New', 'wedesigntech-ultimate-booking-addon' ).' '.$service_cat_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
					'menu_name'         => $service_cat_plural,
				);

				register_taxonomy ( 'dt_service_category', array (
					'dt_service'
				), array (
					'hierarchical' 		=> true,
					'labels' 			=> $labels,
					'show_admin_column' => true,
					'rewrite' 			=> array( 'slug' => $servicecatslug ),
					'query_var' 		=> true
				) );
			endif;
		}

		/**
		 * Service framework options
		 */
		function dt_service_cs_framework_options( $options ) {

			$serviceslug 			= ultimate_booking_pro_cs_get_option( 'single-service-slug', 'dt_service' );
			$service_singular		= ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
			$service_plural			= ultimate_booking_pro_cs_get_option( 'plural-service-text', esc_html__('Services', 'wedesigntech-ultimate-booking-addon') );

			$servicecatslug  		= ultimate_booking_pro_cs_get_option( 'service-cat-slug', 'dt_service_category' );
			$service_cat_singular 	= ultimate_booking_pro_cs_get_option( 'singular-service-cat-text', esc_html__('Category', 'wedesigntech-ultimate-booking-addon') );
			$service_cat_plural		= ultimate_booking_pro_cs_get_option( 'plural-service-cat-text', esc_html__('Categories', 'wedesigntech-ultimate-booking-addon') );

			$options['booking-manager']['sections'][] = array(

				// -----------------------------------------
				// Service Options
				// -----------------------------------------
				'name'      => 'service_options',
				'title'     => $service_singular.' '.esc_html__('Options', 'wedesigntech-ultimate-booking-addon'),
				'icon'      => 'fa fa-info-circle',

				  'fields'      => array(
					  array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Service Archives Post Layout', 'wedesigntech-ultimate-booking-addon' ),
					  ),

					  array(
						'id'      	   => 'service-archives-post-layout',
						'type'         => 'image_select',
						'title'        => esc_html__('Post Layout', 'wedesigntech-ultimate-booking-addon'),
						'options'      => array(
						  'one-half-column'   => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-half-column.png',
						  'one-third-column'  => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-third-column.png',
						  'one-fourth-column' => ULTIMATEBOOKINGPRO_URL . '/cs-framework-override/images/one-fourth-column.png',
						),
						'default'      => 'one-third-column',
					  ),

					  array(
						'id'  	=> 'service-archives-excerpt',
						'type'  => 'switcher',
						'title' => esc_html__('Show Excerpt', 'wedesigntech-ultimate-booking-addon'),
						'label'	=> esc_html__("YES! to enable service's excerpt", "wdt-ultimate-booking")
					  ),

					  array(
					  	'id'  	  	 => 'service-archives-excerpt-length',
					  	'type'    	 => 'number',
					  	'title'   	 => esc_html__('Excerpt Length', 'wedesigntech-ultimate-booking-addon'),
					  	'after'	   	 => '<span class="cs-text-desc">&nbsp;'.esc_html__('No.of words', 'wedesigntech-ultimate-booking-addon').'</span>',
					  	'default' 	 => 12,
					  	'dependency' => array( 'service-archives-excerpt', '==', 'true' ),
					  ),

					  array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Bulk Custom Fields', 'wedesigntech-ultimate-booking-addon' ),
					  ),

					  array(
						'id'              => 'service-custom-fields',
						'type'            => 'group',
						'title'           => esc_html__('Custom Fields', 'wedesigntech-ultimate-booking-addon'),
						'info'            => esc_html__('Click button to add custom fields like duration, url and price etc', 'wedesigntech-ultimate-booking-addon'),
						'button_title'    => esc_html__('Add New Field', 'wedesigntech-ultimate-booking-addon'),
						'accordion_title' => esc_html__('Adding New Custom Field', 'wedesigntech-ultimate-booking-addon'),
						'fields'          => array(
						  array(
							'id'          => 'service-custom-fields-text',
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
						'id'      => 'singular-service-text',
						'type'    => 'text',
						'title'   => esc_html__('Singular', 'wedesigntech-ultimate-booking-addon').' '.$service_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $service_singular,
						'after'   => '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'plural-service-text',
						'type'    => 'text',
						'title'   => esc_html__('Plural', 'wedesigntech-ultimate-booking-addon').' '.$service_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $service_plural,
						'after'   => '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'singular-service-cat-text',
						'type'    => 'text',
						'title'   => esc_html__('Singular', 'wedesigntech-ultimate-booking-addon').' '.$service_cat_singular.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $service_cat_singular,
						'after'   => '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'plural-service-cat-text',
						'type'    => 'text',
						'title'   => esc_html__('Plural', 'wedesigntech-ultimate-booking-addon').' '.$service_cat_plural.' '.esc_html__('Name', 'wedesigntech-ultimate-booking-addon'),
						'default' => $service_cat_plural,
						'after'   => '<p class="cs-text-info">'.esc_html__('Change as you like, save options & reload.', 'wedesigntech-ultimate-booking-addon').'</p>',
					  ),

					  array(
						'id'      => 'single-service-slug',
						'type'    => 'text',
						'title'   => esc_html__('Single', 'wedesigntech-ultimate-booking-addon').' '.$service_singular.' '.esc_html__('Slug', 'wedesigntech-ultimate-booking-addon'),
						'after'   => '<p class="cs-text-info">'.esc_html__('Do not use characters not allowed in links. Use, eg. service-item ', 'wedesigntech-ultimate-booking-addon').'<br> <b>'.esc_html__('After made changes save permalinks.', 'wedesigntech-ultimate-booking-addon').'</b></p>',
					  ),

					  array(
						'id'      => 'service-cat-slug',
						'type'    => 'text',
						'title'   => $service_singular.' '.$service_cat_singular.' '.esc_html__('Slug', 'wedesigntech-ultimate-booking-addon'),
						'after'   => '<p class="cs-text-info">'.esc_html__('Do not use characters not allowed in links. Use, eg. service-type ', 'wedesigntech-ultimate-booking-addon').'<br> <b>'.esc_html__('After made changes save permalinks.', 'wedesigntech-ultimate-booking-addon').'</b></p>',
					  ),
				  ),
			);

			// Filter to add additional options for themes
			$options = apply_filters( 'ultimate_booking_pro_template_framework_options', $options );

			return $options;
		}

		/**
		 * Service metabox options
		 */
		function dt_service_cs_metabox_options( $options ) {

			$fields = cs_get_option( 'service-custom-fields');
			$bothfields = $fielddef = $x = array();
			$before = '';

			if(!empty($fields)) :

				$i = 1;
				foreach($fields as $field):
					$x['id'] = 'service_opt_flds_title_'.$i;
					$x['type'] = 'text';
					$x['title'] = 'Title';
					$x['attributes'] = array( 'style' => 'background-color: #f0eff9;' );
					$bothfields[] = $x;
					unset($x);

					$x['id'] = 'service_opt_flds_value_'.$i;
					$x['type'] = 'text';
					$x['title'] = 'Value';
					$bothfields[] = $x;

					$fielddef['service_opt_flds_title_'.$i] = $field['service-custom-fields-text'];

					$i++;
				endforeach;
			else:
				$before = '<span>'.esc_html__('Go to options panel add few custom fields, then return back here.', 'wedesigntech-ultimate-booking-addon').'</span>';
			endif;

			$times = array( '' => esc_html__('Select', 'wedesigntech-ultimate-booking-addon') );
			for ( $i = 0; $i < 12; $i++ ) :
				for ( $j = 15; $j <= 60; $j += 15 ) :
					$duration = ( $i * 3600 ) + ( $j * 60 );
					$duration_output = ultimate_booking_pro_duration_to_string( $duration );
					$times[$duration] = $duration_output;
				endfor;
			endfor;

			$staff_plural     = ultimate_booking_pro_cs_get_option( 'plural-staff-text', esc_html__('Staffs', 'wedesigntech-ultimate-booking-addon') );
			$service_singular = ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );

			$symbol = ultimate_booking_pro_get_currency_symbol();

			$options[]    = array(
			  'id'        => '_custom_settings',
			  'title'     => esc_html__('Custom Service Options', 'wedesigntech-ultimate-booking-addon'),
			  'post_type' => 'dt_service',
			  'context'   => 'normal',
			  'priority'  => 'default',
			  'sections'  => array(

				array(
				  'name'  => 'gallery_section',
				  'title' => esc_html__('Gallery Options', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-picture-o',

				  'fields' => array(

					array(
					  'id'          => 'service-gallery',
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
				  'icon'  => 'fa fa-clock-o',

				  'fields' => array(

					array(
					  'id'      => 'service-price',
					  'type'    => 'number',
					  'title'   => esc_html__('Cost', 'wedesigntech-ultimate-booking-addon'),
					  'after'	=> '&nbsp;'.$symbol,
					  'desc'    => '<p class="cs-text-muted">'.esc_html__('Put a valid price here', 'wedesigntech-ultimate-booking-addon').'</p>',
					  'attributes' => array(
						'style'    => 'width: 90px;'
					  )
					),

					array(
					  'id'      => 'service-duration',
					  'type'    => 'select',
					  'title'   => esc_html__('Duration', 'wedesigntech-ultimate-booking-addon'),
					  'after'   => '<p class="cs-text-muted">'.esc_html__('Select time duration here', 'wedesigntech-ultimate-booking-addon').'</p>',
					  'options' => $times,
					  'class'   => 'chosen'
					),

				  ), // end: fields
				), // end: a section

				array(
				  'name'  => 'optional_section',
				  'title' => esc_html__('Optional Fields', 'wedesigntech-ultimate-booking-addon'),
				  'icon'  => 'fa fa-plug',

				  'fields' => array(

					array(
					  'id'        => 'service_opt_flds',
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
		function dt_service_edit_columns($columns) {

			$newcolumns = array (
				"cb"               => "<input type=\"checkbox\" />",
				"dt_service_thumb" => esc_html__("Image", 'wedesigntech-ultimate-booking-addon'),
				"title"            => esc_html__("Title", 'wedesigntech-ultimate-booking-addon'),
				"cost"        	   => esc_html__("Cost", 'wedesigntech-ultimate-booking-addon'),
				"duration"         => esc_html__("Duration", 'wedesigntech-ultimate-booking-addon')
			);

			$columns = array_merge ( $newcolumns, $columns );
			return $columns;
		}

		/**
		 *
		 * @param unknown $columns
		 * @param unknown $id
		 */
		function dt_service_columns_display($columns, $id) {
			global $post;

			$service_settings = get_post_meta ( $post->ID, '_custom_settings', TRUE );
			$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

			switch ($columns) {

				case "dt_service_thumb" :
				    $image = wp_get_attachment_image(get_post_thumbnail_id($id), array(75,75));
					if(!empty($image)):
					  	echo "{$image}";
				    else:
						if( array_key_exists("service-gallery", $service_settings)) {
							$items = explode(',', $service_settings["service-gallery"]);
							echo wp_get_attachment_image( $items[0], array(75, 75) );
						}
					endif;
				break;

				case "cost" :
					if( array_key_exists("service-price", $service_settings) && $service_settings['service-price'] != '' ) {
						echo ultimate_booking_pro_get_currency_symbol().floatval( $service_settings['service-price'] );
					}
				break;

				case "duration" :
					if( array_key_exists("service-duration", $service_settings) && $service_settings['service-duration'] != '' ) {
						echo ultimate_booking_pro_duration_to_string( $service_settings['service-duration'] );
					}
				break;
			}
		}
	}
}