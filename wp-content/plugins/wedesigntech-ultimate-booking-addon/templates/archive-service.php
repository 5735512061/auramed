<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php
	/**
	* ultimate_booking_pro_before_main_content hook.
	*/
	do_action( 'ultimate_booking_pro_before_main_content' );
?>

	<?php
		/**
		* ultimate_booking_pro_before_content hook.
		*/
		do_action( 'ultimate_booking_pro_before_content' );
    ?>

		<?php
            $post_layout    = cs_get_option( 'service-archives-post-layout' );
            $post_excerpt   = cs_get_option( 'service-archives-excerpt' );
            $excerpt_length = cs_get_option( 'service-archives-excerpt-length' );

            switch($post_layout):

                case 'one-fourth-column':
                    $post_class = " service column dt-sc-one-fourth";
                    $columns    = 4;
                break;

                case 'one-third-column':
                    $post_class = " service column dt-sc-one-third";
                    $columns    = 3;
                break;

                default:
                case 'one-half-column':
                    $post_class = " service column dt-sc-one-half";
                    $columns    = 2;
                break;
            endswitch;

            if( have_posts() ) :
                $loop = 1;?>
                <div class="dt-sc-service-container"><?php
                    while( have_posts() ):
                        the_post();
                        $the_id = get_the_ID();

                        $temp_class = 'dt-sc-service-item type1';
                        if($loop == 1) $temp_class .= $post_class.' first'; else $temp_class .= $post_class;
                        if($loop == $columns) { $loop = 1; } else { $loop = $loop + 1; }

                        #Meta...
                        $service_settings = get_post_meta($the_id, '_custom_settings', true);
                        $service_settings = is_array ( $service_settings ) ? $service_settings : array ();

                        echo '<div id="dt_service-'.esc_attr( $the_id ).'" class="'.esc_attr( trim( $temp_class ) ).'">';
                            echo '<div class="image">';
                                    if( has_post_thumbnail() ):
                                        $attr = array('title' => get_the_title(), 'alt' => get_the_title());
                                        echo get_the_post_thumbnail( $the_id, 'full', $attr );
                                    else:
                                        $img_pros = '615x560';
                                        echo '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'"/>';
                                    endif;
                            echo '</div>';

                            echo '<div class="service-details">';
                                echo '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';

                                if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
                                    echo '<h6>'.esc_html__('Duration : ', 'wedesigntech-ultimate-booking-addon').ultimate_booking_pro_duration_to_string($service_settings['service-duration']).'</h6>';
                                endif;

                                if( array_key_exists('service-price', $service_settings) ):
                                    echo '<span class="dt-sc-service-price">'.ultimate_booking_pro_get_currency_symbol().$service_settings['service-price'].'</span>';
                                endif;

                                if( $post_excerpt == true && $excerpt_length > 0 ):
                                    echo ultimate_booking_pro_post_excerpt($excerpt_length);
                                endif;

                                if( array_key_exists('service_opt_flds', $service_settings) ):
                                    echo '<div class="dt-sc-service-meta">';
                                        echo '<ul>';
                                            for( $i = 1; $i <= (sizeof($service_settings['service_opt_flds']) / 2); $i++ ):

                                                $title = $service_settings['service_opt_flds']['service_opt_flds_title_'.$i];
                                                $value = $service_settings['service_opt_flds']['service_opt_flds_value_'.$i];

                                                if( !empty($value) ):
                                                    echo '<li>';
                                                        echo '<h6>'.esc_html($title).'</h6>';
                                                        echo '<span>'.esc_html($value).'</span>';
                                                    echo '</li>';
                                                endif;
                                            endfor;
                                        echo '</ul>';
                                    echo '</div>';
                                endif;

                                echo '<a class="dt-sc-button medium bordered" href="'.get_permalink().'" title="'.get_the_title().'">'.esc_html('View procedure details', 'wedesigntech-ultimate-booking-addon').'</a>';

                            echo '</div>';
                        echo '</div>';

                    endwhile;?>
                </div><?php
            endif;?>

            <!-- **Pagination** -->
            <div class="pagination booking-pagination"><?php
				echo '<div class="older-posts">'.get_next_posts_link( esc_html__('Older Posts ', 'wedesigntech-ultimate-booking-addon').'<i class="fa fa-angle-right"></i>' ).'</div>';
                echo '<div class="newer-posts">'.get_previous_posts_link( '<i class="fa fa-angle-left"></i>'.esc_html__(' Newer Posts', 'wedesigntech-ultimate-booking-addon') ).'</div>';
            ?></div><!-- **Pagination** -->

	<?php
        /**
        * ultimate_booking_pro_after_content hook.
        */
        do_action( 'ultimate_booking_pro_after_content' );
    ?>

<?php
	/**
	* ultimate_booking_pro_after_main_content hook.
	*/
	do_action( 'ultimate_booking_pro_after_main_content' );
?>

<?php get_footer();