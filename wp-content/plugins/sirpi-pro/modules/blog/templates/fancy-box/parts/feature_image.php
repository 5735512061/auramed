<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$post_meta = get_post_meta( $post_ID, '_sirpi_post_settings', TRUE );
	$post_meta = is_array( $post_meta ) ? $post_meta  : array();

	$post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format();

	$template_args['post_ID'] = $post_ID;
	$template_args['meta'] = $post_meta;
	$template_args['enable_video_audio'] = $enable_video_audio;
	$template_args['enable_gallery_slider'] = $enable_gallery_slider;

    ?>

	<!-- Featured Image -->
	<div class="entry-thumb">
		<?php sirpi_template_part( 'blog', 'templates/post-format/post', $post_format, $template_args ); ?>
        <?php
        if( has_post_thumbnail( $post_ID ) ) :
            ?>
            <div class="entry-thumb-meta-group">
                <?php
                if(in_array('social', $archive_post_elements)) :
                    $path = sirpi_get_template_part( 'blog', 'templates/post-extra/social', '', $template_args );
                    echo sirpi_html_output($path);
                endif;
                if(in_array('category', $archive_post_elements)) :
                    $path = sirpi_get_template_part( 'blog', 'templates/fancy-box/parts/category', '', $template_args );
                    $path = !empty( $path ) ? $path : sirpi_get_template_part( 'blog', 'templates/post-extra/category', '', $template_args );
                    echo sirpi_html_output($path);
                endif;
                ?>
            </div>
        <?php
        endif;
        ?>
        <?php do_action( 'sirpi_blog_archive_post_format', $enable_post_format, $post_format ); ?>