<?php
use UltimateBookingPro\Widgets\UltimateBookingProWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Reservation_Form extends UltimateBookingProWidgetBase {

    public function get_name() {
        return 'dt-reservation-form';
    }

    public function get_title() {
        return esc_html__('Reservation Form', 'wedesigntech-ultimate-booking-addon');
    }

    public function get_icon() {
		return 'eicon-apps';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'wedesigntech-ultimate-booking-addon'),
        ) );

			$this->add_control( 'title', array(
				'label' => esc_html__( 'Title', 'wedesigntech-ultimate-booking-addon' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Appointment', 'wedesigntech-ultimate-booking-addon'),
			) );

            $this->add_control( 'serviceids', array(
                'label' => esc_html__( 'Service IDs', 'wedesigntech-ultimate-booking-addon' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->dt_get_post_ids('dt_service')
            ) );

            $this->add_control( 'staffids', array(
				'label'       => esc_html__( 'Staff IDs', 'wedesigntech-ultimate-booking-addon' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $this->dt_get_post_ids('dt_staff')
            ) );

			$this->add_control(	'el_class', array(
				'type' => Controls_Manager::TEXT,
				'label'       => esc_html__('Extra class name', 'wedesigntech-ultimate-booking-addon'),
				'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'wedesigntech-ultimate-booking-addon')
			) );

		$this->end_controls_section();
	}

    protected function render() {

		$settings = $this->get_settings();
		extract( $settings );

		$out = '';

		$url = get_page_link( cs_get_option('appointment-pageid') );
		$url = isset( $url ) ? $url : '';

		if($url != '') {

			$out = '<div class="dt-sc-appointment-wrapper '.esc_attr($el_class).'">';

				$out .= '<div class="dt-sc-title">';
					$out .= '<h2>'.$title.'</h2>';
				$out .= '</div>';

				$out .= '<form class="dt-sc-reservation-form dt-appointment-form" name="reservation-schedule-form" method="post" action="'.$url.'">';

				$out .= '<div class="dt-sc-one-column column">
							<div class="frm-group">
								<div class="">
            						<label for="cli-name">'.esc_html__('Hello Iam!','wedesigntech-ultimate-booking-addon').'</label>
          						</div>
								<input type="text" id="cli-name" name="cli-name" class="frm-control" placeholder="Name" required>
							</div>
						</div>';

				$out .= '<div class="dt-sc-one-column column">
							<div class="frm-group">
								<div class="">
									<label for="services">'.esc_html__('Iam looking it for treatments','wedesigntech-ultimate-booking-addon').'</label>
									<span class="star">*</span>
								</div>
								<select name="services" id="services" class="dt-select-service frm-control" required>
									<option value="">Select treatments</option>';
									if($serviceids != '') {
										$cp_services = get_posts( array('post_type'=>'dt_service', 'posts_per_page'=>'-1', 'post__in' => $serviceids, 'suppress_filters' => false ));
									} else {
									$cp_services = get_posts( array('post_type'=>'dt_service', 'posts_per_page'=>'-1', 'suppress_filters' => false ) );
									}

									if( $cp_services ) {
										foreach( $cp_services as $cp_service ){
											$id = $cp_service->ID;
											$title = $cp_service->post_title;

											$service_settings = get_post_meta($id, '_custom_settings', true);
											$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

											$out .= "<option value='{$id}'>{$title}";
												if( cs_get_option('enable-price-in-dropdown') && array_key_exists('service-price', $service_settings) ):
													$out .= ' - '.ultimate_booking_pro_get_formatted_price( $service_settings['service-price'] );
												endif;
											$out .= "</option>";
										}
									}
								$out .= '</select>
							</div>
						</div>';

				$out .= '<div class="dt-sc-one-column column">
							<div class="frm-group dt-appoint-date form-calendar-icon">
								<div class="">
									<label for="datepicker">'.esc_html__('Date to fix a surgery or treatments','wedesigntech-ultimate-booking-addon').'</label>
									<span class="star">*</span>
								</div>
									<input type="text" id="datepicker" name="date" class="frm-control datepicker" required placeholder="Select a date">
							</div>
						</div>';

				
				$out .= '<div class="dt-sc-one-column column">
							<div class="frm-group">
								<div class="">
									<label for="phone">'.esc_html__('Your Contact Number','wedesigntech-ultimate-booking-addon').'</label>
								</div>
								<input type="text" id="phone" name="phone" class="frm-control" placeholder="Contact Number">
							</div>
							<div class="frm-group">
								<div class="">
            						<label for="cli-email">'.esc_html__('Your Email Id','wedesigntech-ultimate-booking-addon').'</label>
          						</div>
								<input type="text" id="cli-email" name="cli-email" class="frm-control" placeholder="Email" required>
							</div>
						</div>';

				// $out .= '<div class="dt-sc-one-column column">
						// 	<div class="frm-group">
						// 		<div class="">
            			// 			<label for="staff">'.esc_html__('Name of Staff','wedesigntech-ultimate-booking-addon').'</label>
            			// 			<span class="star">*</span>
          				// 		</div>
						// 		<select name="staff" id="staff" class="dt-select-staff frm-control" required>
						// 			<option value="">Select Doctor</option>';
						// 			if($staffids != '') {
						// 				$cp_staffs = get_posts( array('post_type'=>'dt_staff', 'posts_per_page'=>'-1', 'post__in' => $staffids ) );
						// 			} else {
						// 				$cp_staffs = get_posts( array('post_type'=>'dt_staff', 'posts_per_page'=>'-1' ) );
						// 			}
						// 			if( $cp_staffs ){
						// 				foreach( $cp_staffs as $cp_staff ){
						// 					$id = $cp_staff->ID;
						// 					$title = $cp_staff->post_title;

						// 					$staff_settings = get_post_meta($id, '_custom_settings', true);
						// 					$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();

						// 					$out .= '<option value="'.$id.'">'.$title;
						// 						if( cs_get_option('enable-price-in-dropdown') && array_key_exists('staff-price', $staff_settings) ):
						// 							$out .= ' - '.ultimate_booking_pro_get_formatted_price( $staff_settings['staff-price'] );
						// 						endif;
						// 					$out .= '</option>';
						// 				}
						// 			}
						// 		$out .= '</select>
						// 	</div>
						// </div>';

				$out .= '<div class="dt-sc-one-column column">
						<div class="frm-group">
							<div class="">
								<label for="cli-message">'.esc_html__('Message','wedesigntech-ultimate-booking-addon').'</label>
							  </div>
							<input type="text" id="cli-message" name="cli-message" class="frm-control" placeholder="Enter your Message" required>
						</div>
					</div>';

				$out .= '<div class="dt-sc-one-column column">
							<div class="aligncenter">
								<input name="subschedule" class="dt-sc-button filled medium show-time-shortcode" value="'.esc_attr__('Send', 'wedesigntech-ultimate-booking-addon').'" type="submit">
							</div>
						</div>';

						if( !empty( $staffids ) ) {
							$out .= '<input type="hidden" id="staffids" name="staffids" value="'. implode( ',', $staffids ) .'" />';
						}
						if( !empty( $serviceids ) ) {
							$out .= '<input type="hidden" id="serviceids" name="serviceids" value="'. implode( ',', $serviceids ).'" />';
						}

				$out .= '</form>';

			$out .= '</div>';
		} else {
			$out .= '<div class="dt-sc-info-box">'.esc_html__('Please create Reservation template page in order to make this shortcode work properly!', 'wedesigntech-ultimate-booking-addon').'</div>';
		}

		echo "{$out}";
	}

	protected function _content_template() {
    }
}