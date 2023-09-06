<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProPostCategoryWidget' ) ) {
    class SirpiProPostCategoryWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        }

        function register_widgets( $widgets_manager ) {
            require SIRPI_PRO_DIR_PATH. 'modules/post/elementor/widgets/post-category/class-widget-post-category.php';
            $widgets_manager->register( new \Elementor_Post_Categories() );
        }
    }
}

SirpiProPostCategoryWidget::instance();