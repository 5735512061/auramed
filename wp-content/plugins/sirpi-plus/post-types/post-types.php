<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'SirpiPlusPostTypes' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class SirpiPlusPostTypes {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			// Header Post Type
			require_once SIRPI_PLUS_DIR_PATH . 'post-types/header-post-type.php';
			// Footer Post Type
			require_once SIRPI_PLUS_DIR_PATH . 'post-types/footer-post-type.php';
		}
	}
}

SirpiPlusPostTypes::instance();