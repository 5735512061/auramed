<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProBreadcrumb' ) ) {
    class SirpiProBreadcrumb {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->load_frontend();
        }

        function load_modules() {
            include_once SIRPI_PRO_DIR_PATH.'modules/breadcrumb/customizer/index.php';
            include_once SIRPI_PRO_DIR_PATH.'modules/breadcrumb/metabox/index.php';
        }

        function load_frontend() {
            include_once SIRPI_PRO_DIR_PATH.'modules/breadcrumb/templates/index.php';
        }
    }
}

SirpiProBreadcrumb::instance();