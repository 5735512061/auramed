<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'SirpiProPostTypes' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class SirpiProPostTypes {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			// Mega Menu Post Type
			require_once SIRPI_PRO_DIR_PATH . 'post-types/mega-menu-post-type.php';

		}
	}
}

SirpiProPostTypes::instance();