<?php
if (! class_exists ( 'DTBaseBookingSC' ) ) {

    class DTBaseBookingSC {

        function __construct() {
			add_shortcode( 'dt_sc_social', array( $this, 'dt_sc_social' ) );
		}

		function dtShortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dt_sc_social($attrs, $content = null) {
			extract ( shortcode_atts ( array (
				'class' => ''
			), $attrs ) );
	
			$sociables = array('fa-dribbble' => 'dribble', 'fa-flickr' => 'flickr', 'fa-github' => 'github', 'Pi' => 'pinterest','Tw' => 'twitter', 'fa-youtube' => 'youtube', 'fa-android' => 'android', 'fa-dropbox' => 'dropbox', 'In' => 'instagram', 'fa-windows' => 'windows', 'fa-apple' => 'apple', 'Fb' => 'facebook', 'Go' => 'google', 'In' => 'linkedin', 'fa-skype' => 'skype', 'fa-tumblr' => 'tumblr', 'fa-vimeo-square' => 'vimeo', 'fa-behance' => 'behance');
	
			$s = $out = "";
			foreach ( $sociables as $key => $value ) {
				if(is_array($attrs) && array_key_exists($value, $attrs) && $attrs[$value] != '')
					$s .= '<li><a class="fab '.$key.'" href="'.$attrs[$value].'" title="'.ucfirst($value).'"><span>'.$key.'</span></a></li>';
			}
			$s = ! empty ( $s ) ? "<ul class='dt-sc-team-social {$class}'>$s</ul>" : "";
			$out .= $s;
	
			return $out;
		}

		function ultimate_booking_pro_vc_autocomplete_serviceids_field_search( $search_string ) {
			$data = array();
			$vc_filter_by = vc_post_param( 'vc_filter_by', '' );
			$vc_services = get_posts( array(
				'posts_per_page' => -1,
				'post_type' => 'dt_service',
				'search' => $search_string
			) );
			if ( is_array( $vc_services ) && ! empty( $vc_services ) ) {
				foreach ( $vc_services as $t ) {
					if ( is_object( $t ) ) {
						$data[] = $this->ultimate_booking_pro_get_post_object( $t );
					}
				}
			}
		
			return $data;
		}

		function ultimate_booking_pro_vc_autocomplete_serviceids_field_render( $post ) {
			$services = get_posts( array(
				'include' => array( $post['value'] ),
				'posts_per_page' => -1,
				'post_type' => 'dt_service'
			) );
			$data = false;
			if ( is_array( $services ) && 1 === count( $services ) ) {
				$term = $services[0];
				$data = $this->ultimate_booking_pro_get_post_object( $term );
			}

			return $data;
		}

		function ultimate_booking_pro_vc_autocomplete_staffids_field_search( $search_string ) {
			$data = array();
			$vc_filter_by = vc_post_param( 'vc_filter_by', '' );
			$vc_staffs = get_posts( array(
				'posts_per_page' => -1,
				'post_type' => 'dt_staff',
				'search' => $search_string
			) );
			if ( is_array( $vc_staffs ) && ! empty( $vc_staffs ) ) {
				foreach ( $vc_staffs as $t ) {
					if ( is_object( $t ) ) {
						$data[] = $this->ultimate_booking_pro_get_post_object( $t );
					}
				}
			}

			return $data;
		}

		function ultimate_booking_pro_vc_autocomplete_staffids_field_render( $post ) {
			$staffs = get_posts( array(
				'include' => array( $post['value'] ),
				'posts_per_page' => -1,
				'post_type' => 'dt_staff'
			) );		

			$data = false;
			if ( is_array( $staffs ) && 1 === count( $staffs ) ) {
				$term = $staffs[0];
				$data = $this->ultimate_booking_pro_get_post_object( $term );
			}

			return $data;
		}

		function ultimate_booking_pro_posts_types() {
			global $dt_posts_types;

			if ( is_null( $dt_posts_types ) ) {
				$dt_posts_types = get_post_types( array( '_builtin' => false ), 'objects' );
			}

			return $dt_posts_types;
		}

		function ultimate_booking_pro_get_post_object( $post ) {
			$dt_posts_types = $this->ultimate_booking_pro_posts_types();

			return array(
				'label' => $post->post_name,
				'value' => $post->ID,
				'group_id' => $post->post_type,
				'group' => isset( $dt_posts_types[ $post->post_type ], $dt_posts_types[ $post->post_type ]->labels, $dt_posts_types[ $post->post_type ]->labels->name ) ? $dt_posts_types[ $post->post_type ]->labels->name : esc_html__( 'Post Types', 'wedesigntech-ultimate-booking-addon' ),
			);
		}

		function ultimate_booking_pro_service_list_vc_autocomplete_terms_field_search( $search_string ) {
			$data = array();
			$vc_filter_by = vc_post_param( 'vc_filter_by', '' );
			$vc_taxonomies = get_terms( array(
				'hide_empty' => false,
				'search' => $search_string,
				'taxonomy' => 'dt_service_category'
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = vc_get_term_object( $t );
					}
				}
			}

			return $data;
		}

		function ultimate_booking_pro_service_list_vc_autocomplete_terms_field_render( $term ) {
			$terms = get_terms( array(
				'include' => array( $term['value'] ),
				'hide_empty' => false,
				'taxonomy' => 'dt_service_category'
			) );
			$data = false;
			if ( is_array( $terms ) && 1 === count( $terms ) ) {
				$term = $terms[0];
				$data = vc_get_term_object( $term );
			}

			return $data;
		}
    }
}

new DTBaseBookingSC();