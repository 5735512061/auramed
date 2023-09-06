<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProPostRelatedArticleWidget' ) ) {
    class SirpiProPostRelatedArticleWidget {

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
            require SIRPI_PRO_DIR_PATH. 'modules/post/elementor/widgets/post-related-article/class-widget-post-related-article.php';
            $widgets_manager->register( new \Elementor_Post_Related_Article() );
        }
    }
}

SirpiProPostRelatedArticleWidget::instance();