<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, sirpi_archive_blog_post_params() );

	foreach ( $archive_post_elements as $key => $value ) {

		switch( $value ) {

			case 'content':
			case 'read_more':
			case 'meta_group':
			case 'likes_views':
				sirpi_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
			break;

            case 'title':
                echo '<div class="entry-title-group">';
                    sirpi_template_part( 'blog', 'templates/post-extra/title', '', $template_args );
                    if(in_array('date', $archive_post_elements)) :
                        $path = sirpi_get_template_part( 'blog', 'templates/post-extra/date', '', $template_args );
                        echo sirpi_html_output($path);
                    endif;
                echo '</div>';
            break;
            case 'date':
            case 'category':
            case 'social':
            break;

			default:
				$path = sirpi_get_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
				$path = !empty( $path ) ? $path : sirpi_get_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
				echo sirpi_html_output($path);
				break;
		}

		if( 'meta_group' == $value ) :
			echo '<div class="entry-meta-group">';
				foreach ( $archive_meta_elements as $key => $value ) {

					switch( $value ) {
						case 'likes_views':
						case 'social':
							sirpi_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
							break;

						default:
							$path = sirpi_get_template_part( 'blog', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
							$path = !empty( $path ) ? $path : sirpi_get_template_part( 'blog', 'templates/post-extra/'.$value, '', $template_args );
							echo sirpi_html_output($path);
							break;
					}
				}
			echo '</div>';
		endif;
	}

	do_action( 'sirpi_blog_post_entry_details_close_wrap' );