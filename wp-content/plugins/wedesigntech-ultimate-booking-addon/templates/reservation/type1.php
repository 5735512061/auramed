<?php
if ( !defined( 'ABSPATH' ) ) {
	exit();
}
?>
<div class="dt-sc-reserve-appointment type1 <?php echo esc_attr($class); ?>"><?php
	// Appointment title...
	if( $title != '')
		echo '<div class="dt-sc-title"><h2 class="appointment-title">'.$title.'</h2></div>';

	global $post;

	if( isset($_REQUEST['action'] ) && ( $_REQUEST['action'] === "success" || $_REQUEST['action'] === "error" ) ):
		if( $_REQUEST['action'] === "success" ):
			$successmsg = cs_get_option('success_message');
			$successmsg = isset($successmsg) ? '<div class="dt-sc-success-box">'.$successmsg.'</div>' : '';
			echo "{$successmsg}";

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
			endif;
		elseif( $_REQUEST['action'] === "error" ):
			$errormsg = cs_get_option('error_message');
			$errormsg = isset($errormsg) ? '<div class="dt-sc-error-box">'.$errormsg.'</div>' : '';
			echo "{$errormsg}";
		endif;
	else:
        $staffids   = isset($_REQUEST['staffids']) ? ultimate_booking_pro_sanitization($_REQUEST['staffids'])    : '';
        $serviceids = isset($_REQUEST['serviceids']) ? ultimate_booking_pro_sanitization($_REQUEST['serviceids']): '';
        $serviceid  = isset($_REQUEST['services']) ? ultimate_booking_pro_sanitization($_REQUEST['services'])    : '';
        $staffid    = isset($_REQUEST['staff']) ? ultimate_booking_pro_sanitization($_REQUEST['staff'])         : '';

        $time_format      = get_option( 'time_format' );

        $fetch_start_time = isset($_REQUEST['start-time']) ? ultimate_booking_pro_sanitization($_REQUEST['start-time']) : '8:00 am';
        $fetch_start_time = date($time_format, strtotime($fetch_start_time));

        $fetch_end_time   = isset($_REQUEST['end-time']) ? ultimate_booking_pro_sanitization($_REQUEST['end-time']) : '11:00 pm';
        $fetch_end_time   = date($time_format, strtotime($fetch_end_time)); ?>

        <div class="column dt-sc-one-half first">
            <label><?php esc_html_e('Available Services','wedesigntech-ultimate-booking-addon');?></label>
            <div class="form-control">
                <select name="services" class="dt-select-service">
                    <?php echo ultimate_booking_pro_get_services( $serviceids, $serviceid ); ?>
                </select>
            </div>
        </div>

        <div class="column dt-sc-one-half">
            <label><?php esc_html_e('Staffs','wedesigntech-ultimate-booking-addon');?></label>
            <div class="form-control dtstaff-drop-down">
                <select name="staff" class="dt-select-staff">
                    <?php echo ultimate_booking_pro_get_staffs( $serviceids, $serviceid, $staffid ); ?>
                </select>
            </div>
        </div>

        <div class="dt-sc-hr-invisible-small"></div>
        <div class="dt-sc-clear"> </div>
        <div class="dt-sc-title"><h3><?php esc_html_e('Time','wedesigntech-ultimate-booking-addon');?></h3></div>

        <div class="column dt-sc-one-third first">
            <label><?php esc_html_e('I am available on','wedesigntech-ultimate-booking-addon');?></label>
            <div class="form-control form-calendar-icon">
                <input type="text" id="datepicker" name="date" value="<?php if(isset($_REQUEST['date'])) echo esc_attr($_REQUEST['date']); else echo date('Y-m-d'); ?>"/>
            </div>
        </div>

        <div class="column dt-sc-one-third">
            <label><?php esc_html_e('Start','wedesigntech-ultimate-booking-addon');?></label>
            <div class="form-control"><select name="start-time" class='start-time'>
                <?php echo ultimate_booking_pro_get_start_time( $fetch_start_time, $time_format ); ?>
            </select></div>
        </div>

        <div class="column dt-sc-one-third">
            <label><?php esc_html_e('End','wedesigntech-ultimate-booking-addon');?></label>
            <div class="form-control"><select name="end-time" class='end-time'>
                <?php echo ultimate_booking_pro_get_end_time( $fetch_end_time, $time_format ); ?>
            </select></div>
        </div>

        <input type="hidden" id="hidden-end-time" name="hidden-end-time" value="<?php echo esc_attr($fetch_end_time); ?>">

        <div class="dt-sc-clear"></div>

        <div class="aligncenter">
            <a href="#" class="dt-sc-button medium bordered show-time"><?php esc_html_e('Show Time','wedesigntech-ultimate-booking-addon');?></a>
        </div>

        <div class="dt-sc-hr-invisible-small"></div>
        <div class="dt-sc-clear"> </div>
        <div class="available-times"></div>

        <div class="dt-sc-hr-invisible-medium"></div>
        <div class="dt-sc-clear"></div>

        <div class="dt-sc-complete-details" style="display:none;">

            <div class="column dt-sc-one-third first">

                <div class="total-cost-info">
                    <div class="dt-sc-title"><h3><?php esc_html_e('Booking Details', 'wedesigntech-ultimate-booking-addon'); ?></h3></div>
                    <p class="total-cinfo-wrapper">
                        <span class="dt-sc-display-timing"><?php esc_html_e('Date & Time:', 'wedesigntech-ultimate-booking-addon'); ?> <span></span></span>
                        <span class="total-cinfo-service"><?php esc_html_e('Service Price', 'wedesigntech-ultimate-booking-addon');?></span> +
                        <span class="total-cinfo-staff"><?php esc_html_e('Staff Cost', 'wedesigntech-ultimate-booking-addon');?></span>
                        <span class="total-cinfo-price">$ 00.00</span>
                    </p>
                </div>

                <div class="aligncenter">
                    <a href="#" class="dt-sc-button medium bordered dt-sc-update-details"><?php esc_html_e('Update Details','wedesigntech-ultimate-booking-addon');?></a>
                </div>

            </div>

            <div class="column dt-sc-two-third">

                <div id="personalinfo" class="personal-info">

                    <?php if( ! is_user_logged_in() ) : ?>
                        <div class="ubpro-checkout-header-login">
                            <div class="ubpro-form-login-toggle">
                                <div class="ubpro-info"><?php esc_html_e('Returning customer?','wedesigntech-ultimate-booking-addon');?> <a href="#" class="showlogin"><?php esc_html_e('Click here to login','wedesigntech-ultimate-booking-addon');?></a></div>
                            </div>

                            <?php echo wp_login_form( array( 'echo' => false, 'redirect' => get_permalink(), 'form_id' => 'reserveloginform' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( is_user_logged_in() || cs_get_option('enable-guest-checkout') ) : ?>
                        <form name="frm-booking-reserve-default" class="dt-sc-booking-reservation default">
                            <div class="dt-sc-title"><h3><?php esc_html_e('Personal Info','wedesigntech-ultimate-booking-addon');?></h3></div><?php
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
                                <input type="text" name="name" value="<?php echo "{$userFname}";?>" placeholder="<?php esc_attr_e('First Name','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half">
                                <div class="form-control"><input type="text" name="lname" value="<?php echo "{$userLname}";?>" placeholder="<?php esc_attr_e('Last Name','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-column">
                                <div class="form-control"><input type="text" name="address" value="<?php echo "{$address}";?>" placeholder="<?php esc_attr_e('Address','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-column">
                                <div class="form-control"><select name="cmbcountry"><?php
                                    // Getting countries...
                                    $countries = ultimate_booking_pro_countries_array();
                                    foreach( $countries as $key => $country ):
                                        echo '<option value="'.esc_attr($key).'" '.selected($user_country, $key, false).'>'.esc_attr($country).'</option>';
                                    endforeach;
                                ?></select></div>
                            </div>

                            <div class="column dt-sc-one-half first">
                                <div class="form-control"><input type="text" name="city" value="<?php echo "{$city}";?>" placeholder="<?php esc_attr_e('City','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half">
                                <div class="form-control"><input type="text" name="state" value="<?php echo "{$state}";?>" placeholder="<?php esc_attr_e('State','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half first">
                                <div class="form-control"><input type="text" name="pincode" value="<?php echo "{$pincode}";?>" placeholder="<?php esc_attr_e('Pin Code','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half">
                                <div class="form-control"><input type="tel" name="phone" value="<?php echo "{$phone}";?>" placeholder="<?php esc_attr_e('Phone','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half first">
                                <div class="form-control"><input type="email" name="email" value="<?php echo "{$userEmail}"; ?>" placeholder="<?php esc_attr_e('Email','wedesigntech-ultimate-booking-addon');?>"></div>
                            </div>

                            <div class="column dt-sc-one-half">
                                <div class="choose-payment form-control" style="display:none;"><?php
                                    $payatarrival = cs_get_option('enable-pay-at-arrival');
                                    $paypal       = cs_get_option('enable-paypal');
                                    $stripe       = cs_get_option('enable-stripe');?>
                                    <select name="payment_type">
                                        <option value=""><?php esc_html_e('Choose Payment','wedesigntech-ultimate-booking-addon');?></option>
                                        <?php if( !empty($payatarrival) ): ?>
                                            <option value="local"><?php esc_html_e('Pay At Arrival','wedesigntech-ultimate-booking-addon');?></option>
                                        <?php endif;?>
                                        <?php if( !empty($paypal) ): ?>
                                            <option value="paypal"><?php esc_html_e('Pay with Paypal','wedesigntech-ultimate-booking-addon');?></option>
                                        <?php endif;?>
                                        <?php if( !empty($stripe) ): ?>
                                            <option value="stripe"><?php esc_html_e('Pay using Stripe','wedesigntech-ultimate-booking-addon');?></option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-control"><textarea name="note" placeholder="<?php esc_attr_e('Note','wedesigntech-ultimate-booking-addon');?>"><?php if(isset($_REQUEST['cli-msg'])) echo esc_attr($_REQUEST['cli-msg']); ?></textarea></div>

                            <div class="form-control">
                                <input type="text" name="captcha" required  placeholder="<?php esc_attr_e('Captcha','wedesigntech-ultimate-booking-addon');?>">
                                <?php $temp = $ctemp = rand(3212, 8787); $temp = str_split($temp, 1); ?>
                                <span class="dt-sc-captcha">
                                    <?php echo esc_html($temp[0]);?>
                                    <sup><?php echo esc_html($temp[1]);?></sup>
                                    <?php echo esc_html($temp[2]);?>
                                    <sub><?php echo esc_html($temp[3]);?></sub>
                                </span>
                                <input type="hidden" name="hiddencaptcha" id="hiddencaptcha" readonly="readonly" value="<?php echo esc_attr($ctemp);?>"/>
                            </div>

                            <div class="column dt-sc-one-column">
                                <div class="chkterms-holder">
                                    <input type="checkbox" name="chkterms" value="yes"><span><?php esc_html_e('I agree to the terms and conditions.', 'wedesigntech-ultimate-booking-addon'); ?></span>
                                </div>
                            </div>

                            <div class="dt-sc-clear"> </div>

                            <div class="aligncenter">
                                <div id="dt-sc-ajax-load-image" style="display:none;"><img src="<?php echo ULTIMATEBOOKINGPRO_URL .'/css/images/loading_icon.gif'; ?>" alt="<?php esc_attr_e('loading', 'wedesigntech-ultimate-booking-addon'); ?>" /></div>
                            </div>

                            <p class="aligncenter"><input type="submit" id="checkout-button" name="subscheduleit" class="dt-sc-button medium bordered schedule-it" value="<?php esc_html_e('Schedule It', 'wedesigntech-ultimate-booking-addon'); ?>" /></p>
                        </form>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <?php
	endif;?></div>