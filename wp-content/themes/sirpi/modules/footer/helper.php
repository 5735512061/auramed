<?php
add_action( 'sirpi_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'sirpi-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, SIRPI_THEME_VERSION, 'all');
}

add_action( 'sirpi_footer', 'footer_content' );
function footer_content() {
    sirpi_template_part( 'content', 'content', 'footer' );
}

add_action( 'sirpi_before_enqueue_js', 'sirpi_sticky_footer_js' );
if( !function_exists( 'sirpi_sticky_footer_js' ) ) {
    function sirpi_sticky_footer_js() {
        wp_enqueue_script('sticky-footer', get_theme_file_uri('/modules/footer/assets/js/footer.js'), array(), false, true);
    }
}