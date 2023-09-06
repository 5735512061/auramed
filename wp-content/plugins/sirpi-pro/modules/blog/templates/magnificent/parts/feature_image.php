<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$post_meta = get_post_meta( $post_ID, '_sirpi_post_settings', TRUE );
	$post_meta = is_array( $post_meta ) ? $post_meta  : array();

	$post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format();

	$template_args['post_ID'] = $post_ID;
	$template_args['meta'] = $post_meta;
	$template_args['enable_video_audio'] = $enable_video_audio;
	$template_args['enable_gallery_slider'] = $enable_gallery_slider; ?>

	<!-- Featured Image -->
	<div class="entry-thumb">
        <div class="entry-thumb-image-group">
            <?php sirpi_template_part( 'blog', 'templates/post-format/post', $post_format, $template_args ); ?>
        </div>

        <div class="entry-thumb-detail-group">
            <?php if(in_array('author', $archive_post_elements)) :?>
                <div class="entry-author">
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>" title="<?php esc_attr_e('View all posts by ', 'sirpi-pro'); echo get_the_author();?>">
                        <?php echo get_the_author();?>
                    </a>
                    <span><?php esc_html_e('wrote', 'sirpi-pro'); ?></span>
                </div>
            <?php endif; ?>
            <?php if(in_array('title', $archive_post_elements)) :?>
                <div class="entry-title">
                    <h4><?php
                        if( is_sticky( $post_ID ) ) echo '<span class="sticky-post"><i class="wdticon-thumb-tack"></i><span>'.esc_html__('Featured', 'sirpi-pro').'</span></span>'; ?>
                        <a href="<?php echo get_permalink( $post_ID );?>" title="<?php printf(esc_attr__('Permalink to %s','sirpi-pro'), the_title_attribute('echo=0'));?>"><?php the_title();?></a>
                    </h4>
                </div>
            <?php endif; ?>

            <?php if(in_array('date', $archive_post_elements) || in_array('category', $archive_post_elements)) :?>
                <div class="entry-thumb-group">
                    <?php if(in_array('date', $archive_post_elements)) :?>
                        <div class="entry-date">
                            <i class="wdticon-calendar"> </i>
                            <?php echo get_the_date ( get_option('date_format') ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(in_array('category', $archive_post_elements)) :?>
                        <div class="entry-categories">
                            <span><?php esc_html_e('in', 'sirpi-pro'); ?></span>
                            <?php
                            $cats = wp_get_object_terms($post_ID, 'category');
                            if( !empty($cats) ):
                                $count = count($cats);
                                $out = '';
                                foreach( $cats as $key => $term ) {
                                    $out .= '<a href="'.get_term_link( $term->slug ,'category').'">'.esc_html( $term->name ).'</a>';
                                    $key += 1;

                                    if( $key !== $count ){
                                        $out .= ' ';
                                    }
                                }
                                echo "{$out}";
                            endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php do_action( 'sirpi_blog_archive_post_format', $enable_post_format, $post_format ); ?>