<?php
use UltimateBookingPro\Widgets\UltimateBookingProWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Staff_Item extends UltimateBookingProWidgetBase {

    public function get_name() {
        return 'dt-staff-item';
    }

    public function get_title() {
        return $this->get_singular_name();
    }

    public function get_icon() {
		return 'eicon-apps';
	}

    public function get_singular_name() {

        $singular_name = esc_html__('Staff', 'wedesigntech-ultimate-booking-addon');

        if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
            $singular_name = ultimate_booking_pro_cs_get_option( 'singular-staff-text', esc_html__('Staff', 'wedesigntech-ultimate-booking-addon') );
        endif;

        return $singular_name;
    }

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'wedesigntech-ultimate-booking-addon'),
        ) );

            $this->add_control( 'staff_id', array(
                'label' => esc_html__( 'Enter Staff ID', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => false,
                'options' => $this->dt_get_post_ids('dt_staff')
            ));

            $this->add_control( 'type', array(
                'label' => esc_html__( 'Type', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => array(
                    'type1' => esc_html__( 'Type - I', 'wedesigntech-ultimate-booking-addon' ),
                    'type2' => esc_html__( 'Type - II', 'wedesigntech-ultimate-booking-addon' ),
                    'type3' => esc_html__( 'Type - III', 'wedesigntech-ultimate-booking-addon' ),
                )
            ));

            $this->add_control( 'show_button', array(
                'label' => esc_html__( 'Show button?', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'wedesigntech-ultimate-booking-addon' ),
                    'no' => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon' ),
                )
            ));

            $this->add_control( 'show_appoinment', array(
                'label' => esc_html__( 'Show appointment?', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'wedesigntech-ultimate-booking-addon' ),
                    'no' => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon' ),
                )
            ));

            $this->add_control( 'button_text', array(
                'label' => esc_html__( 'Button Text', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Book an appointment', 'wedesigntech-ultimate-booking-addon'),
            ));

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        extract( $settings );

        $out = '';

        #Performing query...
        $args = array('post_type' => 'dt_staff', 'p' => $staff_id );

        $the_query = new WP_Query($args);
        if($the_query->have_posts()):

            while($the_query->have_posts()): $the_query->the_post();
                $PID = $staff_id;

                #Meta...
                $staff_settings = get_post_meta($PID, '_custom_settings', true);
                $staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();
                if( $type == 'type1' || $type == 'type2') {

                    $out .= '<div class="dt-sc-staff-item '.$type.'">';
                        $out .= '<div class="image">';
                        $out .= '<a class="dt-sc-image-wrapper" href="'.get_permalink().'" title="'.get_the_title().'">';
                                if(has_post_thumbnail()):
                                    $attr = array('title' => get_the_title(), 'alt' => get_the_title());
                                    $img_size = 'full';

                                    if( $type == 'type2' ) {
                                        $img_size = 'dt-bm-staff-type2';
                                    }
                                    $out .= get_the_post_thumbnail($PID, $img_size, $attr);
                                else:
                                    $img_pros = '600x692';

                                    if( $type == 'type2' ) {
                                        $img_pros = '205x205';
                                    }
                                    $out .= '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'" />';
                                endif;

                                if( $type == 'type1' ) {
                                    if( array_key_exists('staff-social', $staff_settings) ):
                                        $socialicondr = do_shortcode($staff_settings['staff-social']);
                                        $out .= '<div class="socialicon">'.$socialicondr.'</div>';
                                    endif;
                                }
                                $out .= '</a>';

                        $out .= '</div>';

                        $out .= '<div class="staff-details">';
                            $out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';
                            if( array_key_exists('staff-role', $staff_settings) ):
                                $out .= '<h6>'.$staff_settings['staff-role'].'</h6>';
                            endif;

                            if( $show_button == 'yes' ):
                                $out .= '<div class="dt-sc-staff-overlay">';
                                    $out .= '<a class="dt-sc-button white medium bordered" href="'.get_permalink().'" title="'.get_the_title().'">'.esc_html($button_text).'<i class="wdticon-angle-right"></i></a>';
                                $out .= '</div>';
                            endif;

                            if( $type == 'type1' && $show_appoinment == 'yes') {
                                if( array_key_exists('appointment_fs1', $staff_settings) && array_key_exists('appointment_fs5', $staff_settings) ):
                                    $out .= '<p>'.esc_html__('Monday to Friday : ', 'wedesigntech-ultimate-booking-addon').$staff_settings['appointment_fs1']['ultimate_booking_pro_monday_start'].' - '.$staff_settings['appointment_fs5']['ultimate_booking_pro_friday_end'].esc_html__(' hrs', 'wedesigntech-ultimate-booking-addon');
                                endif;
                            }
                        $out .= '</div>';
                    $out .= '</div>';
                 }


                // type 3
                if( $type == 'type3') {
                    $out .= '<div class="dt-sc-staff-item '.$type.'">';
                        $out .= '<div class="dt-sc-staff-item-container '.$type.'">';
                            $out .= '<div class="dt-sc-staff-image">';
                                $out .= '<a class="dt-sc-image-wrapper" href="'.get_permalink().'" title="'.get_the_title().'">';
                                        if(has_post_thumbnail()):
                                            $attr = array('title' => get_the_title(), 'alt' => get_the_title());
                                            $img_size = 'full';
            
                                            if( $type == 'type2' ) {
                                                $img_size = 'dt-bm-staff-type2';
                                            }
                                            $out .= get_the_post_thumbnail($PID, $img_size, $attr);
                                        else:
                                            $img_pros = '600x692';
            
                                            if( $type == 'type2' ) {
                                                $img_pros = '205x205';
                                            }
                                            $out .= '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'" />';
                                        endif;
            
                                        if( $type == 'type1' ) {
                                            if( array_key_exists('staff-social', $staff_settings) ):
                                                $socialicondr = do_shortcode($staff_settings['staff-social']);
                                                $out .= '<div class="socialicon">'.$socialicondr.'</div>';
                                            endif;
                                        }
                                $out .= '</a>';
    
                            $out .= '</div>';
                            
                            $out .= '<div class="dt-sc-staff-content">';
                                $out .= '<div class="dt-sc-staff-title-container">';
                                    $out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';
                                    if( array_key_exists('staff-role', $staff_settings) ):
                                        $out .= '<span>'.$staff_settings['staff-role'].'</span>';
                                    endif;
                                 $out .= '</div>';

                                $out .= '<div class="dt-sc-staff-experience-container">';
                                    if( array_key_exists('staff_opt_flds', $staff_settings) ):
                                    $out .= '<h4>'.$staff_settings['staff_opt_flds']['staff_opt_flds_title_3'].'</h4>';
                                    $out .= '<p>'.$staff_settings['staff_opt_flds']['staff_opt_flds_value_3'].'</p>';
                                    endif;
                                $out .= '</div>';

                                $out .= '<div class="dt-sc-staff-special-container">';
                                    $out .= '<h4>'.esc_html__('Specialized In :','wedesigntech-ultimate-booking-addon').'</h4>';
                                    $out .= '<p>'.$staff_settings['staff-role'].'</p>';
                                $out .= '</div>';

                                $out .= '<div class="dt-content-container">';
                                    $out .= '<h4>'.esc_html__('Description :','wedesigntech-ultimate-booking-addon').'</h4>';
                                    $out .= '<p>'.get_the_excerpt().'</p>';
                                $out .= '</div>';

                                $out .= '<div class="dt-sc-staff-awards-container">';
                                    if( array_key_exists('staff_opt_flds', $staff_settings) ):
                                        $out .= '<h4>'.$staff_settings['staff_opt_flds']['staff_opt_flds_title_1'].'</h4>';
                                        $staffawardone = $staff_settings['staff_opt_flds']['staff_opt_flds_value_1'];
                                        $staffawardtwo = $staff_settings['staff_opt_flds']['staff_opt_flds_value_2'];
                                        $out .= '<img src="'.$staffawardone.'" alt="'.get_the_title().'" />';
                                        $out .= '<img src="'.$staffawardtwo.'" alt="'.get_the_title().'" />';
                                    endif;
                                $out .= '</div>';

                                $out .= '<div class="dt-sc-staff-social-container">';
                                    if( array_key_exists('staff-social', $staff_settings) ):
                                        $out .= '<h4>'.esc_html__('Social Media :','wedesigntech-ultimate-booking-addon').'</h4>';
                                        $socialicondr = do_shortcode($staff_settings['staff-social']);
                                        $out .= '<div class="social-media">'.$socialicondr.'</div>';
                                    endif;
                                $out .= '</div>';
                            $out .= '</div>';
                        $out .= '</div>';
                    $out .= '</div>';
                }

            endwhile;

            wp_reset_postdata();
        else:
            $out .= '<h2>'.esc_html__("Nothing Found.", "wdt-ultimate-booking").'</h2>';
            $out .= '<p>'.esc_html__("Apologies, but no results were found for the requested archive.", "wdt-ultimate-booking").'</p>';
        endif;

        echo "{$out}";
    }

    protected function _content_template() {
    }
}