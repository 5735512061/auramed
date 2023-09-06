<?php
if (! class_exists ( 'DTBookingViewReservations' ) ) {

    class DTBookingViewReservations extends DTBaseBookingSC {

        function __construct() {

            add_shortcode( 'ubpro_view_reservations', array( $this, 'ultimate_booking_pro_view_reservations' ) );
            add_action( 'wp_loaded', array( $this, 'ultimate_booking_pro_update_user_action' ) );
        }

		function ultimate_booking_pro_view_reservations($attrs, $content = null) {
			extract(shortcode_atts(array(
				'title'    => '',
				'el_class' => '',
			), $attrs));

			$out = '';

			if( ! is_user_logged_in() ) {

				$out .= '<div class="dt-sc-info-box">'.esc_html__('Please logged in to view your complete reservations!', 'wedesigntech-ultimate-booking-addon').'</div>';
				$out .= wp_login_form( array( 'echo' => false, 'redirect' => get_permalink(), 'form_id' => 'viewreservelogin' ) );

			} else {
				$current_user = wp_get_current_user();
				$user_id 	  = $current_user->ID;
				$user_email   = $current_user->user_email;

				$out .= '<div class="dt-sc-view-reservations">';

					$out .= '<p>'.esc_html__('Welcome ', 'wedesigntech-ultimate-booking-addon').$current_user->display_name.'!</p>';
					$out .= '<div class="dt-sc-title"><h3>'.esc_html__('Order Details:', 'wedesigntech-ultimate-booking-addon').'</h3></div>';

					$args = array(
					    'post_type'  => 'dt_customers',
					    'order'      => 'ASC',
					    'meta_query' => array(
					    	'relation' => 'AND',
					    	array(
					    		'relation' => 'OR',
						        array(
						            'key'     => '_info',
						            'value'   => serialize( strval( $user_id ) ), // "s:1:"2";"
						            'compare' => 'LIKE',
						        ),
						        array(
						            'key'     => '_info',
						            'value'   => serialize( intval( $user_id ) ), // "i:"2";"
						            'compare' => 'LIKE',
						        ),
					    	),
					        array(
					            'key'     => '_info',
					            'value'   => serialize( strval( $user_email ) ),
					            'compare' => 'LIKE',
					        ),
					    ),
					);

					$query = new WP_Query( $args );
					if( $query->have_posts() ) {
						while( $query->have_posts() ) {
							$query->the_post();  $ID = get_the_ID();

							$customer_id = $ID;
                            $userFname = $current_user->user_firstname;
                            $userLname = $current_user->user_lastname;
                            $userEmail = $current_user->user_email;
                            $userUrl   = $current_user->user_url;

							$customer_settings = get_post_meta($ID, '_info', true);
							$customer_settings = is_array ( $customer_settings ) ? $customer_settings : array ();

							$address      = $customer_settings['address'];
							$user_country = $customer_settings['country'];
							$city         = $customer_settings['city'];
							$state        = $customer_settings['state'];
							$pincode      = $customer_settings['pincode'];
							$phone        = $customer_settings['phone'];
						}
					}
					wp_reset_postdata($query);

					// Check if customer or not...
					if( $query->found_posts == 0 ) {

						$out .= "<p>".esc_html__("Sorry you haven't made any purchases yet. Please follow the button to made your first reservation.", "wdt-ultimate-booking")."</p>";

						$view_id   = cs_get_option('appointment-pageid');
						$view_link = get_page_link($view_id);

						$out .= '<a href="'.esc_url($view_link).'" class="dt-sc-button" title="'.esc_attr__('Book Reservation', 'wedesigntech-ultimate-booking-addon').'">'.esc_html__('Book Reservation', 'wedesigntech-ultimate-booking-addon').'</a>';

						return $out;
					}

					$out .= '<div class="tbl-view-reservation-container">';
						$out .= '<table class="tbl-view-reservations">';
							$out .= '<tr>';
								$out .= '<th>'.esc_html__('Order #', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Date', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Service', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Amount', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Type', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Transaction ID', 'wedesigntech-ultimate-booking-addon').'</th>';
								$out .= '<th>'.esc_html__('Status', 'wedesigntech-ultimate-booking-addon').'</th>';
							$out .= '</tr>';

							$args = array(
								'post_type'  => 'dt_payments',
								'order'      => 'ASC',
								'meta_query' => array(
									'relation' => 'OR',
									array(
										'key'     => '_info',
										'value'   => serialize( strval( $customer_id ) ), // "s:1:"2";"
										'compare' => 'LIKE',
									),
									array(
										'key'     => '_info',
										'value'   => serialize( intval( $customer_id ) ), // "i:"2";"
										'compare' => 'LIKE',
									),
								),
							);
							$query = new WP_Query( $args );
							if( $query->have_posts() ) {
								while( $query->have_posts() ) {
									$query->the_post();  $ID = get_the_ID();

									$payments  = get_post_meta( $ID, '_info', true );
									$payments  = is_array($payments) ? $payments : array();

									$out .= '<tr>';

										$trans_id     = isset( $payments['order_transid'] ) && !empty( $payments['order_transid'] ) ? $payments['order_transid'] : '-';
										$trans_status = isset( $payments['order_status'] ) && !empty( $payments['order_status'] ) ? $payments['order_status'] : esc_html__('Completed', 'wedesigntech-ultimate-booking-addon');

										$out .= '<td>'.get_the_title( $ID ).'</td>';
										$out .= '<td>'.$payments['order_date'].'</td>';
										$out .= '<td>'.$payments['order_service'].'</td>';
										$out .= '<td>'.$payments['order_amount'].'</td>';
										$out .= '<td>'.$payments['order_type'].'</td>';
										$out .= '<td>'.$trans_id.'</td>';
										$out .= '<td>'.$trans_status.'</td>';
									$out .= '</tr>';
								}
							}
							wp_reset_postdata($query);

						$out .= '</table>';
					$out .= '</div>';

					$out .= '<div class="dt-sc-title"><h3>'.esc_html__('Profile Details:', 'wedesigntech-ultimate-booking-addon').'</h3></div>';

	                $out .= '<form method="post" id="updateuser" action="'.get_permalink().'">';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input type="hidden" name="hiduserid" value="'.$user_id.'">
	                        			<input type="hidden" name="hidcustomerid" value="'.$customer_id.'">';
	                           $out .= '<input type="text" name="name" value="'.$userFname.'" placeholder="'.esc_attr__('First Name:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><input type="text" name="lname" value="'.$userLname.'" placeholder="'.esc_attr__('Last Name:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input type="text" name="address" value="'.$address.'" placeholder="'.esc_attr__('Address:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><select name="cmbcountry">';
	                            // Getting countries...
	                            $countries = ultimate_booking_pro_countries_array();
	                            foreach( $countries as $key => $country ):
	                                $out .= '<option value="'.esc_attr($key).'" '.selected($user_country, $key, false).'>'.esc_attr($country).'</option>';
	                            endforeach;
	                        $out .= '</select></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input type="text" name="state" value="'.$state.'" placeholder="'.esc_attr__('State:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><input type="text" name="city" value="'.$city.'" placeholder="'.esc_attr__('City:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input type="text" name="pincode" value="'.$pincode.'" placeholder="'.esc_attr__('Pin Code:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><input type="tel" name="phone" value="'.$phone.'" placeholder="'.esc_attr__('Phone:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input type="email" name="email" value="'.$userEmail.'" placeholder="'.esc_attr__('Email:','wedesigntech-ultimate-booking-addon').'"></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><input type="text" name="url" value="'.$userUrl.'" placeholder="'.esc_attr__('Website', 'wedesigntech-ultimate-booking-addon').'" /></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half first">';
	                        $out .= '<div class="form-control"><input id="pass1" name="pass1" type="password" placeholder="'.esc_attr__('Password:', 'wedesigntech-ultimate-booking-addon').'" /></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-half">';
	                        $out .= '<div class="form-control"><input name="pass2" type="password" placeholder="'.esc_attr__('Repeat Password:', 'wedesigntech-ultimate-booking-addon').'" /></div>';
	                    $out .= '</div>';

	                    $out .= '<div class="column dt-sc-one-column">';
		                    $out .= '<div class="form-control">';
		                        $out .= '<textarea name="description" rows="3" cols="50" placeholder='.esc_attr__('Biographical Information', 'wedesigntech-ultimate-booking-addon').'>'.get_the_author_meta( 'description', $current_user->ID ).'</textarea>';
		                    $out .= '</div>';
		                $out .= '</div>';

                        //action hook for plugin and extra fields
                        do_action('edit_user_profile', $current_user);

	                    $out .= '<div class="form-submit">';
	                        $out .= '<input name="updateuser" type="submit" class="dt-sc-button medium bordered" value="'.esc_attr__('Update', 'wedesigntech-ultimate-booking-addon').'" />';
	                        $out .= wp_nonce_field( 'update-user', 'update__wpnonce', true, false );
	                        $out .= '<input name="action" type="hidden" id="action" value="update-user" />';
	                    $out .= '</div>';
	                $out .= '</form>';

				$out .= '</div>';
			}

			return $out;
		}

		function ultimate_booking_pro_update_user_action() {
			if( isset( $_REQUEST['action'] ) && ( $_REQUEST['action'] == 'update-user' ) && isset( $_REQUEST['update__wpnonce'] ) && wp_verify_nonce( $_REQUEST['update__wpnonce'], 'update-user' ) ) {

				$user_id     = ultimate_booking_pro_sanitization($_REQUEST['hiduserid']);

				// Update Cutomer Meta...
				$customer_id = ultimate_booking_pro_sanitization($_REQUEST['hidcustomerid']);
				$first_name  = ultimate_booking_pro_sanitization($_REQUEST['name']);
				$last_name   = ultimate_booking_pro_sanitization($_REQUEST['lname']);
				$address     = ultimate_booking_pro_sanitization($_REQUEST['address']);
				$country     = ultimate_booking_pro_sanitization($_REQUEST['cmbcountry']);
				$city        = ultimate_booking_pro_sanitization($_REQUEST['city']);
				$state       = ultimate_booking_pro_sanitization($_REQUEST['state']);
				$pincode     = ultimate_booking_pro_sanitization($_REQUEST['pincode']);
				$phone       = ultimate_booking_pro_sanitization($_REQUEST['phone']);
				$email       = ultimate_booking_pro_sanitization($_REQUEST['email']);
				$url         = ultimate_booking_pro_sanitization($_REQUEST['url']);
				$pass1       = ultimate_booking_pro_sanitization($_REQUEST['pass1']);
				$des         = ultimate_booking_pro_sanitization($_REQUEST['description']);

				$info = get_post_meta ( $customer_id, '_info', true );
				$info = is_array( $info ) ? $info : array();

				$info['firstname']        = $first_name;
				$info['lastname']         = $last_name;
				$info['address']          = $address;
				$info['country']          = $country;
				$info['city']             = $city;
				$info['state']            = $state;
				$info['pincode']          = $pincode;
				$info['phone']            = $phone;
				$info['emailid']          = $email;
				$info['aboutyourproject'] = $info['aboutyourproject'];
				$info['customer_id']      = $info['customer_id'];

				update_post_meta ( $customer_id, '_info', $info );

				// Update User Meta...
				update_user_meta( $user_id, 'first_name', $first_name );
				update_user_meta( $user_id, 'last_name', $last_name );
				update_user_meta( $user_id, 'description', $des );

				$user_info['address'] = $address;
				$user_info['country'] = $country;
				$user_info['city']    = $city;
				$user_info['state']   = $state;
				$user_info['pincode'] = $pincode;
				$user_info['phone']   = $phone;

				update_user_meta( $user_id, 'user_info', $user_info );

				wp_update_user( array( 'ID' => $user_id, 'user_email' => $email, 'user_url' => $url, 'user_pass' => $pass1 ) );

				$url = !empty(cs_get_option('view-reservations-pageid')) ? get_page_link( cs_get_option('view-reservations-pageid') ) : home_url();
				wp_safe_redirect($url);
				exit();
			}
		}
    }
}

new DTBookingViewReservations();