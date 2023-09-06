<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
			if( have_posts() ) {
				while( have_posts() ) {
					the_post();
					$PID = get_the_ID();

					$staff_settings = get_post_meta($PID, '_custom_settings', true);
					$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();

					echo '<div class="staff-header">';
						echo '<div class="staff-image dt-sc-one-half column first">';
							the_post_thumbnail( 'post-thumbnail', array( 'loading' => false ) );
						echo '</div>';

						echo '<div class="staff-info dt-sc-one-half column">';
							the_title('<h2>', '</h2>');

							// Checking Role...
							if( array_key_exists('staff-role', $staff_settings) ):
								echo '<h6>'.$staff_settings['staff-role'].'</h6>';
							endif;

							the_excerpt();

							// Socials...
							if( array_key_exists('staff-social', $staff_settings) ):
								echo '<h4 class="social_heading">'.esc_html__('Follow us on', 'wedesigntech-ultimate-booking-addon').':</h4>';
								echo do_shortcode($staff_settings['staff-social']);
							endif;

							// Book an Appointment...
				            $view_id   = cs_get_option('appointment-pageid');
				            $view_link = get_page_link($view_id);
							if( !empty( $view_id ) ) :
								echo '<a href="'.esc_url($view_link).'" class="dt-sc-button" title="'.esc_attr__('Book an Appointment', 'wedesigntech-ultimate-booking-addon').'">'.esc_html__('Book an Appointment', 'wedesigntech-ultimate-booking-addon').'</a>';
							endif;
						echo '</div>';
					echo '</div>';

					the_content();
				}
			}?>

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