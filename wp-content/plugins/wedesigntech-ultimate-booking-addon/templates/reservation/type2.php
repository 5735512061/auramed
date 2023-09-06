<?php
if ( !defined( 'ABSPATH' ) ) {
	exit();
}
?>
<?php
    // Getting Reservation Details...
    $staffids   = isset($_REQUEST['staffids']) ? ultimate_booking_pro_sanitization($_REQUEST['staffids'])    : '';
    $serviceids = isset($_REQUEST['serviceids']) ? ultimate_booking_pro_sanitization($_REQUEST['serviceids']): '';
    $serviceid  = isset($_REQUEST['services']) ? ultimate_booking_pro_sanitization($_REQUEST['services'])   : '';
    $staffid    = isset($_REQUEST['staff']) ? ultimate_booking_pro_sanitization($_REQUEST['staff'])        : '';

    $firstname  = isset($_REQUEST['firstname']) ? ultimate_booking_pro_sanitization($_REQUEST['firstname'])  : '';
    $lastname   = isset($_REQUEST['lastname']) ? ultimate_booking_pro_sanitization($_REQUEST['lastname'])    : '';
    $phone      = isset($_REQUEST['phone']) ? ultimate_booking_pro_sanitization($_REQUEST['phone'])          : '';
    $emailid    = isset($_REQUEST['emailid']) ? ultimate_booking_pro_sanitization($_REQUEST['emailid'])      : '';
    $address    = isset($_REQUEST['address']) ? ultimate_booking_pro_sanitization($_REQUEST['address'])      : '';

    // About your project
    $about_your_project = isset($_REQUEST['about_your_project']) ? ultimate_booking_pro_sanitization($_REQUEST['about_your_project']) : '';
    $contact_info_data  = '';

    if($firstname == '') {
        $from_step1        = 'true';
        $servicebox_style  = '';
        $contactbox_style  = 'style="display:none;"';
        $gobackbox_style   = 'style="display:none;"';
        $step_value        = 1;
        $current_step1     = 'dt-sc-current-step';
        $current_step2     = '';
        $completed_step    = '';
        $timeslotbox_style = 'style="display:none;"';
    } else {
        $from_step1       = 'false';
        $servicebox_style = 'style="display:none;"';
        $contactbox_style = '';
        $gobackbox_style  = '';
        $step_value       = 2;
        $current_step1    = '';
        $current_step2    = 'dt-sc-current-step';
        $completed_step   = 'dt-sc-completed-step';

        $contact_info_data = '<ul>';
            if($firstname != '') { $contact_info_data .= '<li>'.$firstname.' '.$lastname.'</li>'; }
            if($phone != '') { $contact_info_data .= '<li>'.$phone.'</li>'; }
            if($emailid != '') { $contact_info_data .= '<li>'.$emailid.'</li>'; }
            if($address != '') { $contact_info_data .= '<li>'.$address.'</li>'; }
            if($about_your_project != '') { $contact_info_data .= '<li>'.$about_your_project.'</li>'; }
        $contact_info_data .= '</ul>';
    }?>
	<div class="dt-sc-reserve-appointment2 <?php echo esc_attr($class); ?>"><?php
		// Appointment title...
		if( $title != '')
			echo '<h2 class="appointment-title">'.$title.'</h2>'; ?>

        <div class="dt-sc-clear"></div>

        <div class="dt-sc-hr-invisible-small"></div>
        <div class="dt-sc-clear"></div>

        <!-- <p class="dt-sc-info-box"><?php //esc_html_e('All fields are mandatory','wedesigntech-ultimate-booking-addon');?></p> -->

        <div class="dt-sc-hr-invisible-small"></div>
        <div class="dt-sc-clear"></div>

        <div class="dt-sc-goback-box" <?php echo "{$gobackbox_style}"; ?>>
            <input class="appointment-goback" value="<?php echo esc_html__('Go Back and edit', 'wedesigntech-ultimate-booking-addon'); ?>" type="button" />
            <input type="hidden" value="<?php echo esc_attr($from_step1); ?>" name="appointment-step-checker"  id="appointment-step-checker"  />
            <input type="hidden" value="<?php echo esc_attr($step_value); ?>" name="appointment-step"  id="appointment-step"  />
        </div>

        <div class="dt-sc-schedule-box steps step1" <?php echo "{$servicebox_style}"; ?>>
            <h2><?php echo esc_html__('Select Service & Date', 'wedesigntech-ultimate-booking-addon'); ?></h2>
            <div class="dt-sc-single-border-separator"></div>
            <div class="dt-sc-hr-invisible-xsmall"></div>

            <div class="dt-sc-service-box" <?php echo "{$servicebox_style}"; ?>>
                <form class="dt-sc-appointment-scheduler-form" name="dt-sc-appointment-scheduler-form" method="post">
                    <div class="column dt-sc-one-third first">
                        <div class="form-control">
                            <select name="serviceid" id="serviceid" class="dt-select-service">
                                <?php echo ultimate_booking_pro_get_services( $serviceids, $serviceid ); ?>
                            </select>
                        </div>
                    </div>
                    <div class="column dt-sc-one-third">
                        <div class="form-control dtstaff-drop-down">
                            <select name="staffid" id="staffid" class="dt-select-staff">
                                <?php echo ultimate_booking_pro_get_staffs( $serviceids, $serviceid, $staffid ); ?>
                            </select>
                        </div>
                    </div>
                    <div class="column dt-sc-one-third">
                        <div class="form-control form-calendar-icon">
                            <input type="text" id="datepicker" name="date" value="<?php if(isset($_REQUEST['date'])) echo esc_attr($_REQUEST['date']); else echo esc_html__('Select Date', 'wedesigntech-ultimate-booking-addon'); ?>" required />
                        </div>
                    </div>

                    <div class="aligncenter"><input class="generate-schedule dt-sc-button medium bordered" value="<?php echo esc_html__('Check available time', 'wedesigntech-ultimate-booking-addon'); ?>" type="button" /></div>

                    <input type="hidden" id="staffids" name="staffids" value="<?php echo esc_attr($staffids); ?>" />
                    <input type="hidden" id="serviceids" name="serviceids" value="<?php echo esc_attr($serviceids); ?>" />
                </form>
            </div>

            <div class="dt-sc-timeslot-box" <?php echo "{$timeslotbox_style}"; ?>>
                <div class="appointment-ajax-holder"></div>
            </div>
        </div>

        <div class="dt-sc-contactdetails-box steps step2" <?php echo "{$contactbox_style}"; ?>>
        	<?php if( ! is_user_logged_in() ) : ?>
                <div class="ubpro-checkout-header-login">
                    <div class="ubpro-form-login-toggle">
                        <div class="ubpro-info"><?php esc_html_e('Returning customer?','wedesigntech-ultimate-booking-addon');?> <a href="#" class="showlogin"><?php esc_html_e('Click here to login','wedesigntech-ultimate-booking-addon');?></a></div>
                    </div>

                    <?php echo wp_login_form( array( 'echo' => false, 'redirect' => get_permalink(), 'form_id' => 'reserveloginform2' ) ); ?>
                </div>
            <?php endif; ?>

            <?php if( is_user_logged_in() || cs_get_option('enable-guest-checkout') ) : ?>
	            <div class="border-title"><h2><?php echo esc_html__('Contact Details', 'wedesigntech-ultimate-booking-addon'); ?></h2></div>
	            <form class="dt-sc-appointment-contactdetails-form" name="dt-sc-appointment-contactdetails-form" method="post"><?php
                        // Get User Info...
                        $current_user = wp_get_current_user();
                        $userID = $userFname = $userLname = $userEmail = '';
                        $address = $user_country = $city = $state = $pincode = $phone = '';

                        if ( 0 != $current_user->ID ) {
                            $userID    = $current_user->ID;
                            $userFname = $current_user->user_firstname;
                            $userLname = $current_user->user_lastname;
                            $userEmail = $current_user->user_email;
                            $userLogin = $current_user->user_login;

                            // Get values in customer post
                            $meta_arr     = ultimate_booking_pro_get_customer_meta( $userID );
                            $address      = isset( $meta_arr['address'] ) ? $meta_arr['address'] : '';
                            $user_country = isset( $meta_arr['country'] ) ? $meta_arr['country'] : '';
                            $city         = isset( $meta_arr['city'] ) ? $meta_arr['city'] : '';
                            $state        = isset( $meta_arr['state'] ) ? $meta_arr['state'] : '';
                            $pincode      = isset( $meta_arr['pincode'] ) ? $meta_arr['pincode'] : '';
                            $phone        = isset( $meta_arr['phone'] ) ? $meta_arr['phone'] : '';
                        } else {
                            $userFname = isset($_REQUEST['cli-name']) ? ultimate_booking_pro_sanitization($_REQUEST['cli-name']) : '';
                            $userEmail = isset($_REQUEST['cli-email']) ? ultimate_booking_pro_sanitization($_REQUEST['cli-email']) : '';
                        }
                    ?>

	                <div class="column dt-sc-one-half first">
	                	<div class="form-control"><input type="hidden" name="hiduserid" value="<?php echo "{$userID}"; ?>">
	                    <input type="text" id="firstname" name="firstname" value="<?php echo esc_attr($userFname); ?>" placeholder="<?php echo esc_html__('First Name', 'wedesigntech-ultimate-booking-addon'); ?>" required /></div>
	                </div>

	                <div class="column dt-sc-one-half">
	                    <div class="form-control"><input type="text" id="lastname" name="lastname" value="<?php echo esc_attr($userLname); ?>" placeholder="<?php echo esc_html__('Last Name', 'wedesigntech-ultimate-booking-addon'); ?>" required /></div>
	                </div>

	                <div class="column dt-sc-one-column">
	                    <div class="form-control"><input type="text" id="address" name="address" value="<?php echo esc_attr($address); ?>" placeholder="<?php echo esc_html__('Address', 'wedesigntech-ultimate-booking-addon'); ?>" required /></div>
	                </div>

                    <div class="column dt-sc-one-half first">
                        <div class="form-control"><select id="country" name="cmbcountry"><?php
                            // Getting countries...
                            $countries = ultimate_booking_pro_countries_array();
                            foreach( $countries as $key => $country ):
                                echo '<option value="'.esc_attr($key).'" '.selected($user_country, $key, false).'>'.esc_attr($country).'</option>';
                            endforeach;
                        ?></select></div>
                    </div>

                    <div class="column dt-sc-one-half">
                        <div class="form-control"><input type="text" id="state" name="state" value="<?php echo "{$state}";?>" placeholder="<?php esc_attr_e('State','wedesigntech-ultimate-booking-addon');?>"></div>
                    </div>

                    <div class="column dt-sc-one-half first">
                        <div class="form-control"><input type="text" id="city" name="city" value="<?php echo "{$city}";?>" placeholder="<?php esc_attr_e('City','wedesigntech-ultimate-booking-addon');?>"></div>
                    </div>

                    <div class="column dt-sc-one-half">
                        <div class="form-control"><input type="text" id="pincode" name="pincode" value="<?php echo "{$pincode}";?>" placeholder="<?php esc_attr_e('Pin Code','wedesigntech-ultimate-booking-addon');?>"></div>
                    </div>

	                <div class="column dt-sc-one-half first">
	                    <div class="form-control"><input type="text" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" placeholder="<?php echo esc_html__('Phone', 'wedesigntech-ultimate-booking-addon'); ?>" required /></div>
	                </div>

	                <div class="column dt-sc-one-half">
	                    <div class="form-control"><input type="text" id="emailid" name="emailid" value="<?php echo esc_attr($userEmail); ?>" placeholder="<?php echo esc_html__('Email:', 'wedesigntech-ultimate-booking-addon'); ?>" required /></div>
	                </div>

	                <p><?php echo esc_html('A brief description about your reason of visit','wedesigntech-ultimate-booking-addon'); ?></p>

	                <div class="column dt-sc-one-column">
	                    <div class="form-control"><textarea id="about_your_project" name="about_your_project" placeholder="<?php echo esc_html__('Message', 'wedesigntech-ultimate-booking-addon'); ?>" required><?php echo esc_attr($about_your_project); ?></textarea></div>
	                </div>

                    <div class="column dt-sc-one-column">
                        <div class="chkterms-holder">
                            <input type="checkbox" name="chkterms" value="yes"><span><?php esc_html_e('I agree to the terms and conditions.', 'wedesigntech-ultimate-booking-addon'); ?></span>
                        </div>
                    </div>

	                <div class="aligncenter"><input class="generate-servicebox dt-sc-button medium bordered" value="<?php echo esc_html__('Submit Details', 'wedesigntech-ultimate-booking-addon'); ?>" type="submit" /></div>
	            </form>
	        <?php endif; ?>
        </div>

        <div class="dt-sc-notification-box steps step3" style="display:none;">

            <div class="border-title"><h2><?php echo esc_html__('Confirm Details', 'wedesigntech-ultimate-booking-addon'); ?></h2></div>

            <div class="column dt-sc-one-half dt-sc-notification-details dt-sc-notification-schedulebox first">
                <div class="dt-sc-schedule-details" id="dt-sc-schedule-details"></div>
            </div>

            <div class="column dt-sc-one-half dt-sc-notification-details dt-sc-notification-contactbox ">
                <div class="dt-sc-contact-info" id="dt-sc-contact-info"><?php echo "{$contact_info_data}"; ?></div>
            </div>

            <div class="dt-sc-clear"></div>

            <div class="dt-sc-aboutproject-box">
                <input type="hidden" id="hid_firstname" name="hid_firstname" value="<?php echo esc_attr($userFname); ?>" />
                <input type="hidden" id="hid_lastname" name="hid_lastname" value="<?php echo esc_attr($userLname); ?>" />
                <input type="hidden" id="hid_phone" name="hid_phone" value="<?php echo esc_attr($phone); ?>" />
                <input type="hidden" id="hid_emailid" name="hid_emailid" value="<?php echo esc_attr($userEmail); ?>" />
                <input type="hidden" id="hid_address" name="hid_address" value="<?php echo esc_attr($address); ?>" />
                <input type="hidden" id="hid_city" name="hid_city" value="<?php echo esc_attr($city); ?>" />
                <input type="hidden" id="hid_state" name="hid_state" value="<?php echo esc_attr($state); ?>" />
                <input type="hidden" id="hid_pincode" name="hid_pincode" value="<?php echo esc_attr($pincode); ?>" />
                <input type="hidden" id="hid_country" name="hid_country" value="<?php echo esc_attr($user_country); ?>" />
                <input type="hidden" id="hid_about_your_project" name="hid_about_your_project" value="<?php echo esc_attr($about_your_project); ?>" />

                <div id="dt-sc-ajax-load-image" style="display:none;"><img src="<?php echo ULTIMATEBOOKINGPRO_URL .'/css/images/loading_icon.gif'; ?>" alt="<?php esc_attr_e('loading', 'wedesigntech-ultimate-booking-addon'); ?>" /></div>

                <form class="dt-sc-about-project-form" name="dt-sc-about-project-form" method="post">
                    <div class="aligncenter">
                        <input class="schedule-it dt-sc-button medium bordered" value="<?php echo esc_html__('Check & Confirm', 'wedesigntech-ultimate-booking-addon'); ?>" type="submit" />
                    </div>
                </form>
            </div>

            <div class="dt-sc-clear"></div>

            <div class="dt-sc-apt-success-box dt-sc-success-box" style="display:none;"><?php
                $success = cs_get_option('success_message');
                $success = stripslashes($success);
                echo !empty($success) ? $success : '';?>
            </div>
            <div class="dt-sc-apt-error-box dt-sc-error-box" style="display:none;"><?php
                $error= cs_get_option('error_message');
                $error = stripslashes($error);
                echo !empty($error) ? $error : '';?>
            </div>
            <div class="notify-buttons-wrapper" style="display: none;"><?php
                global $post;
                // Back to Reservation...
                $page_id   = $post->ID;
                $page_link = get_page_link($page_id);
                _e('<p>To continue or make another one, please click this button</p>','wedesigntech-ultimate-booking-addon');
                echo '<a href="'.esc_url($page_link).'" class="dt-sc-button" title="'.esc_attr__('Back to Reservation', 'wedesigntech-ultimate-booking-addon').'">'.esc_html__('Back to Reservation', 'wedesigntech-ultimate-booking-addon').'</a>';

                // View Reservations...
                $view_id   = cs_get_option('view-reservations-pageid');
                $view_link = get_page_link($view_id);
                if( !empty( $view_id ) ) :
                    echo '<a href="'.esc_url($view_link).'" class="dt-sc-button" title="'.esc_attr__('View Reservations', 'wedesigntech-ultimate-booking-addon').'">'.esc_html__('View Reservations', 'wedesigntech-ultimate-booking-addon').'</a>';
                endif; ?>
            </div>
        </div><!-- Reservation -->
    </div>