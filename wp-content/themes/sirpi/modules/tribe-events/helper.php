<?php

if( ! function_exists('sirpi_event_breadcrumb_title') ) {
    function sirpi_event_breadcrumb_title($title) {
        if( get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__( 'Event Detail', 'sirpi' );
            return '<h1>'.$etitle.'</h1>';
        } else {
            return $title;
        }
    }

    add_filter( 'sirpi_breadcrumb_title', 'sirpi_event_breadcrumb_title', 20, 1 );
}

?>