<?php
use UltimateBookingPro\Widgets\UltimateBookingProWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Service_Item extends UltimateBookingProWidgetBase {

    public function get_name() {
        return 'dt-service-item';
    }

    public function get_title() {
        return $this->get_singular_name();
    }

    public function get_icon() {
		return 'eicon-apps';
	}

    public function get_singular_name() {

        $singular_name = esc_html__('Service', 'wedesigntech-ultimate-booking-addon');

        if( function_exists( 'ultimate_booking_pro_cs_get_option' ) ) :
            $singular_name = ultimate_booking_pro_cs_get_option( 'singular-service-text', esc_html__('Service', 'wedesigntech-ultimate-booking-addon') );
        endif;

        return $singular_name;
    }

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'wedesigntech-ultimate-booking-addon'),
        ) );

            $this->add_control( 'service_id', array(
                'label' => esc_html__( 'Service IDs', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->dt_get_post_ids('dt_service')
            ));

            $this->add_control( 'type', array(
                'label' => esc_html__( 'Type', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => array(
                    'type1' => esc_html__( 'Type - I', 'wedesigntech-ultimate-booking-addon' ),
                    'type2' => esc_html__( 'Type - II', 'wedesigntech-ultimate-booking-addon' ),
                )
            ));

            $this->add_control( 'excerpt', array(
                'label' => esc_html__( 'Show Excerpt?', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'wedesigntech-ultimate-booking-addon' ),
                    'no' => esc_html__( 'No', 'wedesigntech-ultimate-booking-addon' ),
                )
            ));

            $this->add_control( 'excerpt_length', array(
                'label' => esc_html__( 'Excerpt Length', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
            ));

            $this->add_control( 'meta', array(
                'label' => esc_html__( 'Show Meta?', 'wedesigntech-ultimate-booking-addon' ),
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
                'default' => esc_html__('View procedure details', 'wedesigntech-ultimate-booking-addon'),
            ));

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        extract( $settings );

        $out = '';

        #Performing query...
        $args = array('post_type' => 'dt_service', 'post__in' => $service_id );

        $the_query = new WP_Query($args);
        if($the_query->have_posts()):

            while($the_query->have_posts()): $the_query->the_post();
                $PID = get_the_ID();

                #Meta...
                $service_settings = get_post_meta($PID, '_custom_settings', true);
                $service_settings = is_array ( $service_settings ) ? $service_settings : array ();

                $out .= '<div class="dt-sc-service-item '.$type.'">';
                    $out .= '<div class="image">';
                            if(has_post_thumbnail()):
                                $attr = array('title' => get_the_title(), 'alt' => get_the_title());
                                $img_size = 'full';

                                if( $type == 'type2' ) {
                                    $img_size = 'dt-bm-service-type2';
                                }
                                $out .= get_the_post_thumbnail($PID, $img_size, $attr);
                            else:
                                $img_pros = '615x560';

                                if( $type == 'type2' ) {
                                    $img_pros = '205x205';
                                }
                                $out .= '<img src="https://place-hold.it/'.$img_pros.'&text='.get_the_title().'" alt="'.get_the_title().'" />';
                            endif;
                    $out .= '</div>';

                    $out .= '<div class="service-details">';
                        $out .= '<h3><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3>';
                        if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
                            $out .= '<h6>'.esc_html__('Duration : ', 'wedesigntech-ultimate-booking-addon').ultimate_booking_pro_duration_to_string($service_settings['service-duration']).'</h6>';
                        endif;

                        if( array_key_exists('service-price', $service_settings) ):
                            $out .= '<span class="dt-sc-service-price">'.ultimate_booking_pro_get_currency_symbol().$service_settings['service-price'].'</span>';
                        endif;

                        if( $excerpt == 'yes' && $excerpt_length > 0 ):
                            $out .= ultimate_booking_pro_post_excerpt($excerpt_length);
                        endif;

                        if( array_key_exists('service_opt_flds', $service_settings) && $meta == 'yes' ):
                            $out .= '<div class="dt-sc-service-meta">';
                                $out .= '<ul>';
                                    for($i = 1; $i <= (sizeof($service_settings['service_opt_flds']) / 2); $i++):

                                        $title = $service_settings['service_opt_flds']['service_opt_flds_title_'.$i];
                                        $value = $service_settings['service_opt_flds']['service_opt_flds_value_'.$i];

                                        if( !empty($value) ):
                                            $out .= '<li>';
                                                $out .= '<h6>'.esc_html($title).'</h6>';
                                                $out .= '<span>'.esc_html($value).'</span>';
                                            $out .= '</li>';
                                        endif;
                                    endfor;
                                $out .= '</ul>';
                            $out .= '</div>';
                        endif;

                        $out .= '<a class="dt-sc-button medium bordered" href="'.get_permalink().'" title="'.get_the_title().'">'.esc_html($button_text).'</a>';

                    $out .= '</div>';
                $out .= '</div>';
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