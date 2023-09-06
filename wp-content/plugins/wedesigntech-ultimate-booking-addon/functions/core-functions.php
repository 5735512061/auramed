<?php
/**
 * Check activated plugins
 * @return boolean
 */
if ( ! function_exists( 'ultimate_booking_pro_check_plugin_active' ) ) {

	function ultimate_booking_pro_check_plugin_active($plugin) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || ultimate_booking_pro_check_plugin_active_for_network( $plugin );
	}
}

if ( ! function_exists( 'ultimate_booking_pro_check_plugin_active_for_network' ) ) {

	function ultimate_booking_pro_check_plugin_active_for_network( $plugin ) {
		if ( !is_multisite() )
			return false;

		$plugins = get_site_option( 'active_sitewide_plugins');
		if ( isset($plugins[$plugin]) )
			return true;

		return false;
	}
}

/**
 * Returns the value if file exists.
 * @return boolean
 */
function ultimate_booking_pro_has_codestar() {

	if ( file_exists( get_stylesheet_directory().'/cs-framework/cs-framework.php') ) {
		return true;
	}

	return false;
}

/**
 * Returns the value of excerpt content.
 * @return html content
 */
function ultimate_booking_pro_post_excerpt($limit = NULL) {
	$limit = !empty($limit) ? $limit : 10;

	$excerpt = explode(' ', get_the_excerpt(), $limit);
	$excerpt = array_filter($excerpt);

	if (!empty($excerpt)) {
		if (count($excerpt) >= $limit) {
			array_pop($excerpt);
			$excerpt = implode(" ", $excerpt).'...';
		} else {
			$excerpt = implode(" ", $excerpt);
		}
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
		$excerpt = str_replace('&nbsp;', '', $excerpt);
		if(!empty ($excerpt))
			return "<p>{$excerpt}</p>";
	}
}

/**
 * Returns the value from codestar array.
 * @return any value
 */
if ( ! function_exists( 'ultimate_booking_pro_cs_get_option' ) ) {

	function ultimate_booking_pro_cs_get_option( $key, $value = '' ) {

		$v = cs_get_option( $key );

		if ( !empty( $v ) ) {
			return $v;
		} else {
			return $value;
		}
	}
}

/**
 * Returns string for time duration.
 */
if ( ! function_exists( 'ultimate_booking_pro_duration_to_string' ) ) {

	function ultimate_booking_pro_duration_to_string( $duration ) {

		$hours   = (int)( $duration / 3600 );
		$minutes = (int)( ( $duration % 3600 ) / 60 );
		$result  = '';
		if ( $hours > 0 ) {
			$result = ( $hours == 1 ) ? sprintf( esc_html__( '%d hr', 'wedesigntech-ultimate-booking-addon' ), $hours ) : sprintf( esc_html__( '%d hrs', 'wedesigntech-ultimate-booking-addon' ), $hours );
			if ( $minutes > 0 ) {
				$result .= ' ';
			}
		}

		if ( $minutes > 0 ) {
			$result .= sprintf( esc_html__( '%d mins', 'wedesigntech-ultimate-booking-addon' ), $minutes );
		}
		return $result;
	}
}

/**
 * Returns time for string.
 */
if ( ! function_exists( 'ultimate_booking_pro_string_to_time' ) ) {

	function ultimate_booking_pro_string_to_time( $str ) {
		return strtotime( sprintf( '1985-03-17 %s', $str ) );
	}
}

/**
 * Returns posts array with price.
 */
if ( ! function_exists( 'ultimate_booking_pro_get_posts_array' ) ) {

	function ultimate_booking_pro_get_posts_array( $post_type = 'service' ) {

		$result_arr = array();
		$symbol = ultimate_booking_pro_get_currency_symbol();
        $args = array( 'post_type' => 'dt_'.$post_type, 'order' => 'ASC', 'posts_per_page' => '-1', 'post_status' => 'publish' );

		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ){
				$the_query->the_post();
				$id = get_the_ID();
				$title = get_the_title();

				$post_meta = get_post_meta($id ,'_custom_settings',TRUE);
				$post_meta = is_array($post_meta) ? $post_meta : array();

				$price = !empty( $post_meta[$post_type.'-price'] ) ? $post_meta[$post_type.'-price'] : '0';

				$result_arr[$id] = $title.' ( '.$symbol.' '.ultimate_booking_pro_number_format($price).' )';

			}
			wp_reset_postdata();
		}

		return $result_arr;
	}
}

/**
 * Get Base Currency Code.
 * @return string
 */
function ultimate_booking_pro_get_currency() {
	return apply_filters( 'ultimate_booking_pro_currency', cs_get_option( 'book-currency' ) );
}

/**
 * Get full list of currency codes.
 * @return array
 */
function ultimate_booking_pro_get_currencies() {
	return array_unique(
		apply_filters( 'ultimate_booking_pro_currencies',
			array(
				'AED' => esc_html__( 'United Arab Emirates dirham', 'wedesigntech-ultimate-booking-addon' ),
				'AFN' => esc_html__( 'Afghan afghani', 'wedesigntech-ultimate-booking-addon' ),
				'ALL' => esc_html__( 'Albanian lek', 'wedesigntech-ultimate-booking-addon' ),
				'AMD' => esc_html__( 'Armenian dram', 'wedesigntech-ultimate-booking-addon' ),
				'ANG' => esc_html__( 'Netherlands Antillean guilder', 'wedesigntech-ultimate-booking-addon' ),
				'AOA' => esc_html__( 'Angolan kwanza', 'wedesigntech-ultimate-booking-addon' ),
				'ARS' => esc_html__( 'Argentine peso', 'wedesigntech-ultimate-booking-addon' ),
				'AUD' => esc_html__( 'Australian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'AWG' => esc_html__( 'Aruban florin', 'wedesigntech-ultimate-booking-addon' ),
				'AZN' => esc_html__( 'Azerbaijani manat', 'wedesigntech-ultimate-booking-addon' ),
				'BAM' => esc_html__( 'Bosnia and Herzegovina convertible mark', 'wedesigntech-ultimate-booking-addon' ),
				'BBD' => esc_html__( 'Barbadian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'BDT' => esc_html__( 'Bangladeshi taka', 'wedesigntech-ultimate-booking-addon' ),
				'BGN' => esc_html__( 'Bulgarian lev', 'wedesigntech-ultimate-booking-addon' ),
				'BHD' => esc_html__( 'Bahraini dinar', 'wedesigntech-ultimate-booking-addon' ),
				'BIF' => esc_html__( 'Burundian franc', 'wedesigntech-ultimate-booking-addon' ),
				'BMD' => esc_html__( 'Bermudian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'BND' => esc_html__( 'Brunei dollar', 'wedesigntech-ultimate-booking-addon' ),
				'BOB' => esc_html__( 'Bolivian boliviano', 'wedesigntech-ultimate-booking-addon' ),
				'BRL' => esc_html__( 'Brazilian real', 'wedesigntech-ultimate-booking-addon' ),
				'BSD' => esc_html__( 'Bahamian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'BTC' => esc_html__( 'Bitcoin', 'wedesigntech-ultimate-booking-addon' ),
				'BTN' => esc_html__( 'Bhutanese ngultrum', 'wedesigntech-ultimate-booking-addon' ),
				'BWP' => esc_html__( 'Botswana pula', 'wedesigntech-ultimate-booking-addon' ),
				'BYR' => esc_html__( 'Belarusian ruble', 'wedesigntech-ultimate-booking-addon' ),
				'BZD' => esc_html__( 'Belize dollar', 'wedesigntech-ultimate-booking-addon' ),
				'CAD' => esc_html__( 'Canadian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'CDF' => esc_html__( 'Congolese franc', 'wedesigntech-ultimate-booking-addon' ),
				'CHF' => esc_html__( 'Swiss franc', 'wedesigntech-ultimate-booking-addon' ),
				'CLP' => esc_html__( 'Chilean peso', 'wedesigntech-ultimate-booking-addon' ),
				'CNY' => esc_html__( 'Chinese yuan', 'wedesigntech-ultimate-booking-addon' ),
				'COP' => esc_html__( 'Colombian peso', 'wedesigntech-ultimate-booking-addon' ),
				'CRC' => esc_html__( 'Costa Rican col&oacute;n', 'wedesigntech-ultimate-booking-addon' ),
				'CUC' => esc_html__( 'Cuban convertible peso', 'wedesigntech-ultimate-booking-addon' ),
				'CUP' => esc_html__( 'Cuban peso', 'wedesigntech-ultimate-booking-addon' ),
				'CVE' => esc_html__( 'Cape Verdean escudo', 'wedesigntech-ultimate-booking-addon' ),
				'CZK' => esc_html__( 'Czech koruna', 'wedesigntech-ultimate-booking-addon' ),
				'DJF' => esc_html__( 'Djiboutian franc', 'wedesigntech-ultimate-booking-addon' ),
				'DKK' => esc_html__( 'Danish krone', 'wedesigntech-ultimate-booking-addon' ),
				'DOP' => esc_html__( 'Dominican peso', 'wedesigntech-ultimate-booking-addon' ),
				'DZD' => esc_html__( 'Algerian dinar', 'wedesigntech-ultimate-booking-addon' ),
				'EGP' => esc_html__( 'Egyptian pound', 'wedesigntech-ultimate-booking-addon' ),
				'ERN' => esc_html__( 'Eritrean nakfa', 'wedesigntech-ultimate-booking-addon' ),
				'ETB' => esc_html__( 'Ethiopian birr', 'wedesigntech-ultimate-booking-addon' ),
				'EUR' => esc_html__( 'Euro', 'wedesigntech-ultimate-booking-addon' ),
				'FJD' => esc_html__( 'Fijian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'FKP' => esc_html__( 'Falkland Islands pound', 'wedesigntech-ultimate-booking-addon' ),
				'GBP' => esc_html__( 'Pound sterling', 'wedesigntech-ultimate-booking-addon' ),
				'GEL' => esc_html__( 'Georgian lari', 'wedesigntech-ultimate-booking-addon' ),
				'GGP' => esc_html__( 'Guernsey pound', 'wedesigntech-ultimate-booking-addon' ),
				'GHS' => esc_html__( 'Ghana cedi', 'wedesigntech-ultimate-booking-addon' ),
				'GIP' => esc_html__( 'Gibraltar pound', 'wedesigntech-ultimate-booking-addon' ),
				'GMD' => esc_html__( 'Gambian dalasi', 'wedesigntech-ultimate-booking-addon' ),
				'GNF' => esc_html__( 'Guinean franc', 'wedesigntech-ultimate-booking-addon' ),
				'GTQ' => esc_html__( 'Guatemalan quetzal', 'wedesigntech-ultimate-booking-addon' ),
				'GYD' => esc_html__( 'Guyanese dollar', 'wedesigntech-ultimate-booking-addon' ),
				'HKD' => esc_html__( 'Hong Kong dollar', 'wedesigntech-ultimate-booking-addon' ),
				'HNL' => esc_html__( 'Honduran lempira', 'wedesigntech-ultimate-booking-addon' ),
				'HRK' => esc_html__( 'Croatian kuna', 'wedesigntech-ultimate-booking-addon' ),
				'HTG' => esc_html__( 'Haitian gourde', 'wedesigntech-ultimate-booking-addon' ),
				'HUF' => esc_html__( 'Hungarian forint', 'wedesigntech-ultimate-booking-addon' ),
				'IDR' => esc_html__( 'Indonesian rupiah', 'wedesigntech-ultimate-booking-addon' ),
				'ILS' => esc_html__( 'Israeli new shekel', 'wedesigntech-ultimate-booking-addon' ),
				'IMP' => esc_html__( 'Manx pound', 'wedesigntech-ultimate-booking-addon' ),
				'INR' => esc_html__( 'Indian rupee', 'wedesigntech-ultimate-booking-addon' ),
				'IQD' => esc_html__( 'Iraqi dinar', 'wedesigntech-ultimate-booking-addon' ),
				'IRR' => esc_html__( 'Iranian rial', 'wedesigntech-ultimate-booking-addon' ),
				'IRT' => esc_html__( 'Iranian toman', 'wedesigntech-ultimate-booking-addon' ),
				'ISK' => esc_html__( 'Icelandic kr&oacute;na', 'wedesigntech-ultimate-booking-addon' ),
				'JEP' => esc_html__( 'Jersey pound', 'wedesigntech-ultimate-booking-addon' ),
				'JMD' => esc_html__( 'Jamaican dollar', 'wedesigntech-ultimate-booking-addon' ),
				'JOD' => esc_html__( 'Jordanian dinar', 'wedesigntech-ultimate-booking-addon' ),
				'JPY' => esc_html__( 'Japanese yen', 'wedesigntech-ultimate-booking-addon' ),
				'KES' => esc_html__( 'Kenyan shilling', 'wedesigntech-ultimate-booking-addon' ),
				'KGS' => esc_html__( 'Kyrgyzstani som', 'wedesigntech-ultimate-booking-addon' ),
				'KHR' => esc_html__( 'Cambodian riel', 'wedesigntech-ultimate-booking-addon' ),
				'KMF' => esc_html__( 'Comorian franc', 'wedesigntech-ultimate-booking-addon' ),
				'KPW' => esc_html__( 'North Korean won', 'wedesigntech-ultimate-booking-addon' ),
				'KRW' => esc_html__( 'South Korean won', 'wedesigntech-ultimate-booking-addon' ),
				'KWD' => esc_html__( 'Kuwaiti dinar', 'wedesigntech-ultimate-booking-addon' ),
				'KYD' => esc_html__( 'Cayman Islands dollar', 'wedesigntech-ultimate-booking-addon' ),
				'KZT' => esc_html__( 'Kazakhstani tenge', 'wedesigntech-ultimate-booking-addon' ),
				'LAK' => esc_html__( 'Lao kip', 'wedesigntech-ultimate-booking-addon' ),
				'LBP' => esc_html__( 'Lebanese pound', 'wedesigntech-ultimate-booking-addon' ),
				'LKR' => esc_html__( 'Sri Lankan rupee', 'wedesigntech-ultimate-booking-addon' ),
				'LRD' => esc_html__( 'Liberian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'LSL' => esc_html__( 'Lesotho loti', 'wedesigntech-ultimate-booking-addon' ),
				'LYD' => esc_html__( 'Libyan dinar', 'wedesigntech-ultimate-booking-addon' ),
				'MAD' => esc_html__( 'Moroccan dirham', 'wedesigntech-ultimate-booking-addon' ),
				'MDL' => esc_html__( 'Moldovan leu', 'wedesigntech-ultimate-booking-addon' ),
				'MGA' => esc_html__( 'Malagasy ariary', 'wedesigntech-ultimate-booking-addon' ),
				'MKD' => esc_html__( 'Macedonian denar', 'wedesigntech-ultimate-booking-addon' ),
				'MMK' => esc_html__( 'Burmese kyat', 'wedesigntech-ultimate-booking-addon' ),
				'MNT' => esc_html__( 'Mongolian t&ouml;gr&ouml;g', 'wedesigntech-ultimate-booking-addon' ),
				'MOP' => esc_html__( 'Macanese pataca', 'wedesigntech-ultimate-booking-addon' ),
				'MRO' => esc_html__( 'Mauritanian ouguiya', 'wedesigntech-ultimate-booking-addon' ),
				'MUR' => esc_html__( 'Mauritian rupee', 'wedesigntech-ultimate-booking-addon' ),
				'MVR' => esc_html__( 'Maldivian rufiyaa', 'wedesigntech-ultimate-booking-addon' ),
				'MWK' => esc_html__( 'Malawian kwacha', 'wedesigntech-ultimate-booking-addon' ),
				'MXN' => esc_html__( 'Mexican peso', 'wedesigntech-ultimate-booking-addon' ),
				'MYR' => esc_html__( 'Malaysian ringgit', 'wedesigntech-ultimate-booking-addon' ),
				'MZN' => esc_html__( 'Mozambican metical', 'wedesigntech-ultimate-booking-addon' ),
				'NAD' => esc_html__( 'Namibian dollar', 'wedesigntech-ultimate-booking-addon' ),
				'NGN' => esc_html__( 'Nigerian naira', 'wedesigntech-ultimate-booking-addon' ),
				'NIO' => esc_html__( 'Nicaraguan c&oacute;rdoba', 'wedesigntech-ultimate-booking-addon' ),
				'NOK' => esc_html__( 'Norwegian krone', 'wedesigntech-ultimate-booking-addon' ),
				'NPR' => esc_html__( 'Nepalese rupee', 'wedesigntech-ultimate-booking-addon' ),
				'NZD' => esc_html__( 'New Zealand dollar', 'wedesigntech-ultimate-booking-addon' ),
				'OMR' => esc_html__( 'Omani rial', 'wedesigntech-ultimate-booking-addon' ),
				'PAB' => esc_html__( 'Panamanian balboa', 'wedesigntech-ultimate-booking-addon' ),
				'PEN' => esc_html__( 'Peruvian nuevo sol', 'wedesigntech-ultimate-booking-addon' ),
				'PGK' => esc_html__( 'Papua New Guinean kina', 'wedesigntech-ultimate-booking-addon' ),
				'PHP' => esc_html__( 'Philippine peso', 'wedesigntech-ultimate-booking-addon' ),
				'PKR' => esc_html__( 'Pakistani rupee', 'wedesigntech-ultimate-booking-addon' ),
				'PLN' => esc_html__( 'Polish z&#x142;oty', 'wedesigntech-ultimate-booking-addon' ),
				'PRB' => esc_html__( 'Transnistrian ruble', 'wedesigntech-ultimate-booking-addon' ),
				'PYG' => esc_html__( 'Paraguayan guaran&iacute;', 'wedesigntech-ultimate-booking-addon' ),
				'QAR' => esc_html__( 'Qatari riyal', 'wedesigntech-ultimate-booking-addon' ),
				'RON' => esc_html__( 'Romanian leu', 'wedesigntech-ultimate-booking-addon' ),
				'RSD' => esc_html__( 'Serbian dinar', 'wedesigntech-ultimate-booking-addon' ),
				'RUB' => esc_html__( 'Russian ruble', 'wedesigntech-ultimate-booking-addon' ),
				'RWF' => esc_html__( 'Rwandan franc', 'wedesigntech-ultimate-booking-addon' ),
				'SAR' => esc_html__( 'Saudi riyal', 'wedesigntech-ultimate-booking-addon' ),
				'SBD' => esc_html__( 'Solomon Islands dollar', 'wedesigntech-ultimate-booking-addon' ),
				'SCR' => esc_html__( 'Seychellois rupee', 'wedesigntech-ultimate-booking-addon' ),
				'SDG' => esc_html__( 'Sudanese pound', 'wedesigntech-ultimate-booking-addon' ),
				'SEK' => esc_html__( 'Swedish krona', 'wedesigntech-ultimate-booking-addon' ),
				'SGD' => esc_html__( 'Singapore dollar', 'wedesigntech-ultimate-booking-addon' ),
				'SHP' => esc_html__( 'Saint Helena pound', 'wedesigntech-ultimate-booking-addon' ),
				'SLL' => esc_html__( 'Sierra Leonean leone', 'wedesigntech-ultimate-booking-addon' ),
				'SOS' => esc_html__( 'Somali shilling', 'wedesigntech-ultimate-booking-addon' ),
				'SRD' => esc_html__( 'Surinamese dollar', 'wedesigntech-ultimate-booking-addon' ),
				'SSP' => esc_html__( 'South Sudanese pound', 'wedesigntech-ultimate-booking-addon' ),
				'STD' => esc_html__( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'wedesigntech-ultimate-booking-addon' ),
				'SYP' => esc_html__( 'Syrian pound', 'wedesigntech-ultimate-booking-addon' ),
				'SZL' => esc_html__( 'Swazi lilangeni', 'wedesigntech-ultimate-booking-addon' ),
				'THB' => esc_html__( 'Thai baht', 'wedesigntech-ultimate-booking-addon' ),
				'TJS' => esc_html__( 'Tajikistani somoni', 'wedesigntech-ultimate-booking-addon' ),
				'TMT' => esc_html__( 'Turkmenistan manat', 'wedesigntech-ultimate-booking-addon' ),
				'TND' => esc_html__( 'Tunisian dinar', 'wedesigntech-ultimate-booking-addon' ),
				'TOP' => esc_html__( 'Tongan pa&#x2bb;anga', 'wedesigntech-ultimate-booking-addon' ),
				'TRY' => esc_html__( 'Turkish lira', 'wedesigntech-ultimate-booking-addon' ),
				'TTD' => esc_html__( 'Trinidad and Tobago dollar', 'wedesigntech-ultimate-booking-addon' ),
				'TWD' => esc_html__( 'New Taiwan dollar', 'wedesigntech-ultimate-booking-addon' ),
				'TZS' => esc_html__( 'Tanzanian shilling', 'wedesigntech-ultimate-booking-addon' ),
				'UAH' => esc_html__( 'Ukrainian hryvnia', 'wedesigntech-ultimate-booking-addon' ),
				'UGX' => esc_html__( 'Ugandan shilling', 'wedesigntech-ultimate-booking-addon' ),
				'USD' => esc_html__( 'United States dollar', 'wedesigntech-ultimate-booking-addon' ),
				'UYU' => esc_html__( 'Uruguayan peso', 'wedesigntech-ultimate-booking-addon' ),
				'UZS' => esc_html__( 'Uzbekistani som', 'wedesigntech-ultimate-booking-addon' ),
				'VEF' => esc_html__( 'Venezuelan bol&iacute;var', 'wedesigntech-ultimate-booking-addon' ),
				'VND' => esc_html__( 'Vietnamese &#x111;&#x1ed3;ng', 'wedesigntech-ultimate-booking-addon' ),
				'VUV' => esc_html__( 'Vanuatu vatu', 'wedesigntech-ultimate-booking-addon' ),
				'WST' => esc_html__( 'Samoan t&#x101;l&#x101;', 'wedesigntech-ultimate-booking-addon' ),
				'XAF' => esc_html__( 'Central African CFA franc', 'wedesigntech-ultimate-booking-addon' ),
				'XCD' => esc_html__( 'East Caribbean dollar', 'wedesigntech-ultimate-booking-addon' ),
				'XOF' => esc_html__( 'West African CFA franc', 'wedesigntech-ultimate-booking-addon' ),
				'XPF' => esc_html__( 'CFP franc', 'wedesigntech-ultimate-booking-addon' ),
				'YER' => esc_html__( 'Yemeni rial', 'wedesigntech-ultimate-booking-addon' ),
				'ZAR' => esc_html__( 'South African rand', 'wedesigntech-ultimate-booking-addon' ),
				'ZMW' => esc_html__( 'Zambian kwacha', 'wedesigntech-ultimate-booking-addon' ),
			)
		)
	);
}

/**
 * Get Currency symbol.
 * @param string $currency (default: '')
 * @return string
 */
function ultimate_booking_pro_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = ultimate_booking_pro_get_currency();
	}

	$symbols = apply_filters( 'ultimate_booking_pro_currency_symbols', array(
		'AED' => '&#x62f;.&#x625;',
		'AFN' => '&#x60b;',
		'ALL' => 'L',
		'AMD' => 'AMD',
		'ANG' => '&fnof;',
		'AOA' => 'Kz',
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => 'Afl.',
		'AZN' => 'AZN',
		'BAM' => 'KM',
		'BBD' => '&#36;',
		'BDT' => '&#2547;&nbsp;',
		'BGN' => '&#1083;&#1074;.',
		'BHD' => '.&#x62f;.&#x628;',
		'BIF' => 'Fr',
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => 'Bs.',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTC' => '&#3647;',
		'BTN' => 'Nu.',
		'BWP' => 'P',
		'BYR' => 'Br',
		'BZD' => '&#36;',
		'CAD' => '&#36;',
		'CDF' => 'Fr',
		'CHF' => '&#67;&#72;&#70;',
		'CLP' => '&#36;',
		'CNY' => '&yen;',
		'COP' => '&#36;',
		'CRC' => '&#x20a1;',
		'CUC' => '&#36;',
		'CUP' => '&#36;',
		'CVE' => '&#36;',
		'CZK' => '&#75;&#269;',
		'DJF' => 'Fr',
		'DKK' => 'DKK',
		'DOP' => 'RD&#36;',
		'DZD' => '&#x62f;.&#x62c;',
		'EGP' => 'EGP',
		'ERN' => 'Nfk',
		'ETB' => 'Br',
		'EUR' => '&euro;',
		'FJD' => '&#36;',
		'FKP' => '&pound;',
		'GBP' => '&pound;',
		'GEL' => '&#x10da;',
		'GGP' => '&pound;',
		'GHS' => '&#x20b5;',
		'GIP' => '&pound;',
		'GMD' => 'D',
		'GNF' => 'Fr',
		'GTQ' => 'Q',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => 'L',
		'HRK' => 'Kn',
		'HTG' => 'G',
		'HUF' => '&#70;&#116;',
		'IDR' => 'Rp',
		'ILS' => '&#8362;',
		'IMP' => '&pound;',
		'INR' => '&#8377;',
		'IQD' => '&#x639;.&#x62f;',
		'IRR' => '&#xfdfc;',
		'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
		'ISK' => 'kr.',
		'JEP' => '&pound;',
		'JMD' => '&#36;',
		'JOD' => '&#x62f;.&#x627;',
		'JPY' => '&yen;',
		'KES' => 'KSh',
		'KGS' => '&#x441;&#x43e;&#x43c;',
		'KHR' => '&#x17db;',
		'KMF' => 'Fr',
		'KPW' => '&#x20a9;',
		'KRW' => '&#8361;',
		'KWD' => '&#x62f;.&#x643;',
		'KYD' => '&#36;',
		'KZT' => 'KZT',
		'LAK' => '&#8365;',
		'LBP' => '&#x644;.&#x644;',
		'LKR' => '&#xdbb;&#xdd4;',
		'LRD' => '&#36;',
		'LSL' => 'L',
		'LYD' => '&#x644;.&#x62f;',
		'MAD' => '&#x62f;.&#x645;.',
		'MDL' => 'MDL',
		'MGA' => 'Ar',
		'MKD' => '&#x434;&#x435;&#x43d;',
		'MMK' => 'Ks',
		'MNT' => '&#x20ae;',
		'MOP' => 'P',
		'MRO' => 'UM',
		'MUR' => '&#x20a8;',
		'MVR' => '.&#x783;',
		'MWK' => 'MK',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => 'MT',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => 'C&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#x631;.&#x639;.',
		'PAB' => 'B/.',
		'PEN' => 'S/.',
		'PGK' => 'K',
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PRB' => '&#x440;.',
		'PYG' => '&#8370;',
		'QAR' => '&#x631;.&#x642;',
		'RMB' => '&yen;',
		'RON' => 'lei',
		'RSD' => '&#x434;&#x438;&#x43d;.',
		'RUB' => '&#8381;',
		'RWF' => 'Fr',
		'SAR' => '&#x631;.&#x633;',
		'SBD' => '&#36;',
		'SCR' => '&#x20a8;',
		'SDG' => '&#x62c;.&#x633;.',
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&pound;',
		'SLL' => 'Le',
		'SOS' => 'Sh',
		'SRD' => '&#36;',
		'SSP' => '&pound;',
		'STD' => 'Db',
		'SYP' => '&#x644;.&#x633;',
		'SZL' => 'L',
		'THB' => '&#3647;',
		'TJS' => '&#x405;&#x41c;',
		'TMT' => 'm',
		'TND' => '&#x62f;.&#x62a;',
		'TOP' => 'T&#36;',
		'TRY' => '&#8378;',
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => 'Sh',
		'UAH' => '&#8372;',
		'UGX' => 'UGX',
		'USD' => '&#36;',
		'UYU' => '&#36;',
		'UZS' => 'UZS',
		'VEF' => 'Bs F',
		'VND' => '&#8363;',
		'VUV' => 'Vt',
		'WST' => 'T',
		'XAF' => 'Fr',
		'XCD' => '&#36;',
		'XOF' => 'Fr',
		'XPF' => 'Fr',
		'YER' => '&#xfdfc;',
		'ZAR' => '&#82;',
		'ZMW' => 'ZK',
	) );

	$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

	return apply_filters( 'ultimate_booking_pro_currency_symbol', $currency_symbol, $currency );
}

/**
 * Get number format
 * @return number with format
 */
function ultimate_booking_pro_number_format($n = 1) {

	$d = cs_get_option('price-decimal');

	return number_format($n, $d);
}

/**
 * Get formatted price
 * @return html
 */
function ultimate_booking_pro_get_formatted_price($price = 30.55, $symbol = '$', $pos = 'left') {

	$symbol = ultimate_booking_pro_get_currency_symbol();
	$pos 	= cs_get_option('currency-pos');

	switch($pos):
		case 'left':
		default:
			return $symbol.ultimate_booking_pro_number_format($price);
			break;

		case 'left-with-space':
			return $symbol.' '.ultimate_booking_pro_number_format($price);
			break;

		case 'right-with-space':
			return ultimate_booking_pro_number_format($price).' '.$symbol;
			break;

		case 'right':
			return ultimate_booking_pro_number_format($price).$symbol;
			break;
	endswitch;
}

/**
 * Get date range
 * @return dates
 */
function ultimate_booking_pro_dates_range( $start_date, $end_date, $days = array() ){

    $interval = new DateInterval( 'P1D' );

    $realEnd = new DateTime( $end_date );
    $realEnd->add( $interval );

    $period = new DatePeriod( new DateTime( $start_date ), $interval, $realEnd );
    $dates = array();

    foreach ( $period as $date ) {
        $dates[] = in_array( strtolower( $date->format('l')) , $days ) ? $date->format( 'Y-m-d l' ) : '';
    }

    $dates = array_filter($dates);
    return $dates;
}

/**
 * Get replace values
 * @return array
 */
function ultimate_booking_pro_replace( $content , $array ){
    $replace = array(
		'[ADMIN_NAME]'        => $array['admin_name'],
		'[STAFF_NAME]'        => $array['staff_name'],
		'[SERVICE]'           => $array['service_name'],
		'[CLIENT_NAME]'       => $array['client_name'],
		'[CLIENT_PHONE]'      => $array['client_phone'],
		'[CLIENT_EMAIL]'      => $array['client_email'],
		'[APPOINTMENT_ID]'    => $array['appointment_id'],
		'[APPOINTMENT_TIME]'  => $array['appointment_time'],
		'[APPOINTMENT_DATE]'  => $array['appointment_date'],
		'[APPOINTMENT_TITLE]' => $array['appointment_title'],
		'[APPOINTMENT_BODY]'  => $array['appointment_body'],
		'[AMOUNT]'            => $array['amount'],
		'[COMPANY_LOGO]'      => $array['company_logo'],
		'[COMPANY_NAME]'      => $array['company_name'],
		'[COMPANY_PHONE]'     => $array['company_phone'],
		'[COMPANY_ADDRESS]'   => $array['company_address'],
		'[COMPANY_WEBSITE]'   => $array['company_website']);

    return str_replace( array_keys( $replace ), array_values( $replace ), $content );
}

/**
 * Get replace values
 * @return array
 */
function ultimate_booking_pro_replace_agenda( $content , $array ){
    $replace = array(
		'[STAFF_NAME]'      => $array['staff_name'],
		'[TOMORROW]'        => $array['tomorrow'],
		'[TOMORROW_AGENDA]' => $array['tomorrow_agenda'],
		'[COMPANY_LOGO]'    => $array['company_logo'],
		'[COMPANY_NAME]'    => $array['company_name'],
		'[COMPANY_PHONE]'   => $array['company_phone'],
		'[COMPANY_ADDRESS]' => $array['company_address'],
		'[COMPANY_WEBSITE]' => $array['company_website']);

    return str_replace( array_keys( $replace ), array_values( $replace ), $content );
}

/**
 * Send email
 * @return mail
 */
function ultimate_booking_pro_send_mail( $to, $subject, $message ){
	$sender_name =  cs_get_option('notification_sender_name');
	$sender_name = !empty($sender_name) ? $sender_name : get_option( 'blogname' );

	$sender_email = cs_get_option('notification_sender_email');
	$sender_email = !empty( $sender_email ) ? $sender_email : get_option( 'admin_email' );

	$from = $sender_name." <{$sender_email}>";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.$from.'' . "\r\n";

	return wp_mail( $to, $subject, $message, $headers );
}

/*
 * Get Available Services
 * @return services
 */
if( !function_exists( 'ultimate_booking_pro_get_services' ) ) {
	function ultimate_booking_pro_get_services( $include_ids, $service_id ) {
		$out = '';

		$out .= '<option value="">'.esc_html__('Treatment Type','wedesigntech-ultimate-booking-addon').'</option>';

        $services_args = array('post_type'=>'dt_service', 'posts_per_page'=>'-1', 'suppress_filters' => false, 'orderby' => 'title' );

        if($include_ids != '') {
			$serviceids_arr            = explode(',', $include_ids);
			$services_args['post__in'] = $serviceids_arr;
        }

        $cp_services = get_posts( $services_args );
        if( $cp_services ) {
            foreach( $cp_services as $cp_service ) {

                $id = $cp_service->ID;

				$service_settings = get_post_meta($id, '_custom_settings', true);
				$service_settings = is_array ( $service_settings ) ? $service_settings : array ();

                $title = $cp_service->post_title;
                $out .= '<option value="'.esc_attr($id).'" '.selected($service_id, $id, false).'>';
                    $out .= esc_html($title);

                    $out .= ' (';
                        if( array_key_exists('service-duration', $service_settings) && $service_settings['service-duration'] != '' ):
                            $out .= ultimate_booking_pro_duration_to_string( $service_settings['service-duration'] );
                        endif;
                    $out .= ')';

                    if( cs_get_option('enable-price-in-dropdown') && array_key_exists('service-price', $service_settings) ):
					    $out .= ' - '.ultimate_booking_pro_get_formatted_price( $service_settings['service-price'] );
                    endif;
                $out .= '</option>';
            }
        }

        return ($out);
	}
}

/*
 * Get Aviailable Staffs
 * @return staffs
 */
if( !function_exists( 'ultimate_booking_pro_get_staffs' ) ) {
	function ultimate_booking_pro_get_staffs( $include_ids, $service_id, $staff_id ) {
		$out = '';

		$out .= '<option value="" style="background-image:url('.ULTIMATEBOOKINGPRO_URL .'/cs-framework/assets/images/doctor-logo.png'.');">'.esc_html__('Select Doctor','wedesigntech-ultimate-booking-addon').'</option>';

	    $staffs_args = array( 'post_type' => 'dt_staff', 'posts_per_page' => '-1', 'meta_query' => array() );

	    if($include_ids != '') {
			$staffids_arr            = explode(',', $include_ids);
			$staffs_args['post__in'] = $staffids_arr;
	    }

	    if(isset($service_id)) {
	        $staffs_args['meta_query'][] = array(
	            'key'     => '_ultimate_booking_pro_staff_services',
	            'value'   =>  $service_id,
	            'compare' => 'LIKE'
	        );
	    }

	    $cp_staffs = get_posts( $staffs_args );
	    if( $cp_staffs ) {
	        foreach( $cp_staffs as $cp_staff ) {

	            $id = $cp_staff->ID;

				$staff_settings = get_post_meta($id, '_custom_settings', true);
				$staff_settings = is_array ( $staff_settings ) ? $staff_settings : array ();

				if( has_post_thumbnail( $id ) ) {
					$post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'dt-bm-dropdown-staff', false );
					$image = isset($post_thumb[0]) ? $post_thumb[0] : 'https://via.placeholder.com/60X60.jpg&text='.get_the_title( $id );
				} else {
					$image = $popup = 'https://via.placeholder.com/60X60.jpg&text='.get_the_title( $id );
				}

                //wp_die();

	            $title = $cp_staff->post_title;
	            $out .= '<option value="'.esc_attr($id).'" '.selected($staff_id, $id, false).' style="background-image:url(\''.$image.'\');">';
	            	$out .= esc_html($title);

					if( cs_get_option('enable-price-in-dropdown') && array_key_exists('staff-price', $staff_settings) ):
						$out .= ' - '.ultimate_booking_pro_get_formatted_price( $staff_settings['staff-price'] );
					endif;
				$out .= '</option>';
	        }
	    }

	    return ($out);
	}
}

/*
 * Get Start Time
 * @return time
 */
if( !function_exists( 'ultimate_booking_pro_get_start_time' ) ) {
	function ultimate_booking_pro_get_start_time( $fetch_start_time, $time_format ) {
		$out = '';

		$times = array(
			'00:00' => '12:00 am', '01:00' => '1:00 am',  '02:00' => '2:00 am',
			'03:00' => '3:00 am',  '04:00' => '4:00 am',  '05:00' => '5:00 am',
			'06:00' => '6:00 am',  '07:00' => '7:00 am',  '08:00' => '8:00 am',
			'09:00' => '9:00 am',  '10:00' => '10:00 am', '11:00' => '11:00 am',
			'12:00' => '12:00 am', '13:00' => '1:00 pm',  '14:00' => '2:00 pm',
			'15:00' => '3:00 pm',  '16:00' => '4:00 pm',  '17:00' => '5:00 pm',
			'18:00' => '6:00 pm',  '19:00' => '7:00 pm',  '20:00' => '8:00 pm',
			'21:00' => '9:00 pm',  '22:00' => '10:00 pm', '23:00' => '11:00 pm'
		);

		foreach ($times as $key => $value) {
			$value = date($time_format, strtotime($value));
			$out   .= '<option value="'.$key.'" '.selected($fetch_start_time, $value, false).'>'.$value.'</option>';
		}

		return ($out);
	}
}

/*
 * Get End Time
 * @return time
 */
if( !function_exists( 'ultimate_booking_pro_get_end_time' ) ) {
	function ultimate_booking_pro_get_end_time( $fetch_end_time, $time_format ) {
		$out = '';

		$times = array(
			'09:00' => '9:00 am',  '10:00' => '10:00 am', '11:00' => '11:00 am',
			'12:00' => '12:00 am', '13:00' => '1:00 pm',  '14:00' => '2:00 pm',
			'15:00' => '3:00 pm',  '16:00' => '4:00 pm',  '17:00' => '5:00 pm',
			'18:00' => '6:00 pm',  '19:00' => '7:00 pm',  '20:00' => '8:00 pm',
			'21:00' => '9:00 pm',  '22:00' => '10:00 pm', '23:00' => '11:00 pm',
			'23:59' => '12:00 am'
		);

		foreach ($times as $key => $value) {
			$value = date($time_format, strtotime($value));
			$out   .= '<option value="'.$key.'" '.selected($fetch_end_time, $value, false).'>'.$value.'</option>';
		}

		return ($out);
	}
}

/*
 * Reserve Login Top
 * @return top
 */
add_filter( 'login_form_top', 'ultimate_booking_pro_login_form_top', 10, 2 );
if( !function_exists( 'ultimate_booking_pro_login_form_top' ) ) {
	function ultimate_booking_pro_login_form_top( $content, $args ) {

		if( $args['form_id'] == 'reserveloginform' ) {
			return '<p>'.esc_html__('If you have booked with us before, please enter your details below. If you are a new customer, please proceed to the Personal Info section.','wedesigntech-ultimate-booking-addon').'</p>';
		} elseif( $args['form_id'] == 'reserveloginform2' ) {
			return '<p>'.esc_html__('If you have booked with us before, please enter your details below. If you are a new customer, please proceed to the Contact Details section.','wedesigntech-ultimate-booking-addon').'</p>';
		} else {
			return $content;
		}
	}
}

/*
 * Reserve Login Bottom
 * @return bottom
 */
add_filter( 'login_form_bottom', 'ultimate_booking_pro_login_form_bottom', 10, 2 );
if( !function_exists( 'ultimate_booking_pro_login_form_bottom' ) ) {
	function ultimate_booking_pro_login_form_bottom( $content, $args ) {

		if( $args['form_id'] == 'reserveloginform' || $args['form_id'] == 'reserveloginform2' ) {
			$lostpass_url = add_query_arg( array(
	            'services' => isset($_REQUEST['services']) ? ultimate_booking_pro_sanitization($_REQUEST['services']) : '',
	            'staff'    => isset($_REQUEST['staff']) ? ultimate_booking_pro_sanitization($_REQUEST['staff']) : '',
	            'date'     => date('Y-m-d')
	        ), wp_lostpassword_url( get_permalink() ) );

			return '<p class="lost_password"><a href="'.$lostpass_url.'">'.esc_html__('Lost your password?','wedesigntech-ultimate-booking-addon').'</a></p>';
		} else {
			return '<p class="lost_password"><a href="'.wp_lostpassword_url( get_permalink() ).'">'.esc_html__('Lost your password?','wedesigntech-ultimate-booking-addon').'</a></p>';
		}
	}
}

/*
 * Get WP Users List
 * @return users
 */
if( !function_exists( 'ultimate_booking_pro_get_wp_users' ) ) {
	function ultimate_booking_pro_get_wp_users() {

		$args  = array( 'orderby' => 'user_nicename', 'order'   => 'ASC' );
		$users = get_users( $args );

		$user_arr = array();

		foreach( $users as $user ) {
			$user_arr[$user->ID] = $user->user_login.' (#'.$user->ID.' - '.$user->user_email.')';
		}

		return $user_arr;
	}
}

/*
 * Get Customer Meta
 * @return meta
 */
if( !function_exists( 'ultimate_booking_pro_get_customer_meta' ) ) {
	function ultimate_booking_pro_get_customer_meta( $user_id ) {

		$meta_arr = array();
		$args = array(
		    'post_type'  => 'dt_customers',
		    'order'      => 'ASC',
		    'meta_query' => array(
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
		);

		$query = new WP_Query( $args );
		if( $query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				$ID = get_the_ID();

				$customer_settings = get_post_meta($ID, '_info', true);
				$customer_settings = is_array ( $customer_settings ) ? $customer_settings : array ();

				$meta_arr['address'] = $customer_settings['address'];
				$meta_arr['country'] = $customer_settings['country'];
				$meta_arr['city']    = $customer_settings['city'];
				$meta_arr['state']   = $customer_settings['state'];
				$meta_arr['pincode'] = $customer_settings['pincode'];
				$meta_arr['phone']   = $customer_settings['phone'];
			}
		}
		wp_reset_postdata($query);

		return $meta_arr;
	}
}

/*
 * Get Countries array from text
 * return array
 */
if( !function_exists( 'ultimate_booking_pro_countries_array' ) ) {
	function ultimate_booking_pro_countries_array() {

		// All countries
		$countries = array(
			'' 	 => esc_html__('Select a country / region', 'wedesigntech-ultimate-booking-addon'),
			'AF' => 'Afghanistan',
			'AX' => 'Aland Islands',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua and Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BQ' => 'Bonaire, Sint Eustatius and Saba',
			'BA' => 'Bosnia and Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'BN' => 'Brunei Darussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CG' => 'Congo',
			'CD' => 'Congo, Democratic Republic of the Congo',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CI' => 'Cote D\'Ivoire',
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CW' => 'Curacao',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'GQ' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands (Malvinas)',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard Island and Mcdonald Islands',
			'VA' => 'Holy See (Vatican City State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran, Islamic Republic of',
			'IQ' => 'Iraq',
			'IE' => 'Ireland',
			'IM' => 'Isle of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KP' => 'Korea, Democratic People\'s Republic of',
			'KR' => 'Korea, Republic of',
			'XK' => 'Kosovo',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => 'Lao People\'s Democratic Republic',
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libyan Arab Jamahiriya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao',
			'MK' => 'Macedonia, the Former Yugoslav Republic of',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States of',
			'MD' => 'Moldova, Republic of',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestinian Territory, Occupied',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'BL' => 'Saint Barthelemy',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts and Nevis',
			'LC' => 'Saint Lucia',
			'MF' => 'Saint Martin',
			'PM' => 'Saint Pierre and Miquelon',
			'VC' => 'Saint Vincent and the Grenadines',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'ST' => 'Sao Tome and Principe',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'CS' => 'Serbia and Montenegro',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SX' => 'Sint Maarten',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia and the South Sandwich Islands',
			'SS' => 'South Sudan',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard and Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syrian Arab Republic',
			'TW' => 'Taiwan, Province of China',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania, United Republic of',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad and Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks and Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom',
			'US' => 'United States',
			'UM' => 'United States Minor Outlying Islands',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Viet Nam',
			'VG' => 'Virgin Islands, British',
			'VI' => 'Virgin Islands, U.s.',
			'WF' => 'Wallis and Futuna',
			'EH' => 'Western Sahara',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe'
		);

		return $countries;
	}
}

/* ---------------------------------------------------------------------------
 * Text Field Sanitization
 * --------------------------------------------------------------------------- */

if(!function_exists('ultimate_booking_pro_sanitization')) {
	function ultimate_booking_pro_sanitization($data) {
		if ( is_array( $data ) && !empty( $data ) ) {
			foreach ( $data as $key => &$value ) {
				if ( is_array( $value ) ) {
					$data[$key] = ultimate_booking_pro_sanitization($value);
				} else {
					$data[$key] = sanitize_text_field( $value );
				}
			}
		}
		else {
			$data = sanitize_text_field( $data );
		}
    	return $data;
    }
}