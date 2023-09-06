<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'SirpiPlusFooterPostType' ) ) {

	class SirpiPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'sirpi_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'sirpi_template_include' ) );
		}

		function sirpi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'sirpi-plus' ),
				'singular_name'		 => __( 'Footer', 'sirpi-plus' ),
				'menu_name'			 => __( 'Footers', 'sirpi-plus' ),
				'add_new'			 => __( 'Add Footer', 'sirpi-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'sirpi-plus' ),
				'edit'				 => __( 'Edit Footer', 'sirpi-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'sirpi-plus' ),
				'new_item'			 => __( 'New Footer', 'sirpi-plus' ),
				'view'				 => __( 'View Footer', 'sirpi-plus' ),
				'view_item' 		 => __( 'View Footer', 'sirpi-plus' ),
				'search_items' 		 => __( 'Search Footers', 'sirpi-plus' ),
				'not_found' 		 => __( 'No Footers found', 'sirpi-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'sirpi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function sirpi_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = SIRPI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

SirpiPlusFooterPostType::instance();