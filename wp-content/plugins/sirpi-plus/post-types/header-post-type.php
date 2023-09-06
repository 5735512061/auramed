<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'SirpiPlusHeaderPostType' ) ) {

	class SirpiPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'sirpi_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'sirpi_template_include' ) );
		}

		function sirpi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'sirpi-plus' ),
				'singular_name'		 => __( 'Header', 'sirpi-plus' ),
				'menu_name'			 => __( 'Headers', 'sirpi-plus' ),
				'add_new'			 => __( 'Add Header', 'sirpi-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'sirpi-plus' ),
				'edit'				 => __( 'Edit Header', 'sirpi-plus' ),
				'edit_item'			 => __( 'Edit Header', 'sirpi-plus' ),
				'new_item'			 => __( 'New Header', 'sirpi-plus' ),
				'view'				 => __( 'View Header', 'sirpi-plus' ),
				'view_item' 		 => __( 'View Header', 'sirpi-plus' ),
				'search_items' 		 => __( 'Search Headers', 'sirpi-plus' ),
				'not_found' 		 => __( 'No Headers found', 'sirpi-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'sirpi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function sirpi_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = SIRPI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

SirpiPlusHeaderPostType::instance();