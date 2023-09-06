<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusPost' ) ) {
    class SirpiPlusPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once SIRPI_PLUS_DIR_PATH.'modules/post/customizer/index.php';
        }

    }
}

SirpiPlusPost::instance();