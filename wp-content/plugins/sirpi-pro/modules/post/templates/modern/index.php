<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProPostModern' ) ) {
    class SirpiProPostModern {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'sirpi_post_styles', array( $this, 'add_post_styles_option' ) );
            add_action( 'sirpi_hook_container_before', array( $this, 'add_post_hook_container_before' ) );
        }

        function add_post_styles_option( $options ) {
            $options['modern'] = esc_html__('Modern', 'sirpi-pro');
            return $options;
        }

        function add_post_hook_container_before() {

            if(is_singular('post')) {

                $post_id = get_the_ID();

                $post_meta = get_post_meta( $post_id, '_sirpi_post_settings', TRUE );
                $post_meta = is_array( $post_meta ) ? $post_meta  : array();
                $post_style = !empty( $post_meta['single_post_style'] ) ? $post_meta['single_post_style'] : '';

                if($post_style != 'modern') {
                    return;
                }

                $template_args['post_ID'] = $post_id;
                $template_args['post_Style'] = $post_style;
                $template_args = array_merge( $template_args, sirpi_single_post_params() );

                ob_start();
                echo '<div class="post-modern">';
                    echo '<div class="post-single-image">';
                        sirpi_template_part( 'post', 'templates/'.$post_style.'/parts/image', '', $template_args );
                    echo '</div>';
                    ?>
                    <div class="entry-post-navigation"><?php
                        if( ! is_attachment() ) :
                            $prev_post = get_previous_post();
                            if( !empty( $prev_post ) ):	?>

                                <div class="post-prev-link"><?php
                                    if( has_post_thumbnail( $prev_post->ID ) ):
                                        $entry_bg = '';
                                        $url = get_the_post_thumbnail_url( $prev_post->ID, 'full' );
                                        $entry_bg = "style=background-image:url(".$url.")"; ?>

                                        <a href="<?php echo get_permalink( $prev_post->ID ); ?>" <?php echo esc_attr($entry_bg);?> class="prev-post-bgimg"></a><?php
                                    endif; ?>

                                    <div class="nav-title-wrap">
                                        <span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>
                                        <p><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php esc_html_e('Prev','sirpi-pro'); ?></a></p>
                                        <h3><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php
                                            if( get_the_title( $prev_post->ID ) == '') {
                                                echo esc_html__('Previous Post', 'sirpi-pro');
                                            } else {
                                                sirpi_html_output($prev_post->post_title);
                                            } ?></a>
                                        </h3>
                                    </div>

                                </div>
                                <?php
                            else: ?>
                                <div class="post-prev-link no-post">
                                    <a href="#" style="background-image:url(<?php echo esc_url(SIRPI_ROOT_URI.'/assets/images/no-post.jpg') ?>);" class="prev-post-bgimg"></a>
                                    <div class="nav-title-wrap">
                                        <span class="zmdi zmdi-long-arrow-left zmdi-hc-fw"></span>
                                        <h3><?php echo esc_html__('No previous story to show!', 'sirpi-pro'); ?></h3>
                                    </div>
                                </div>
                                <?php
                            endif;

                            $next_post = get_next_post();
                            if( !empty( $next_post ) ):	?>
                                <div class="post-next-link"><?php

                                    if( has_post_thumbnail( $next_post->ID ) ):
                                        $entry_bg = '';
                                        $url = get_the_post_thumbnail_url( $next_post->ID, 'full' );
                                        $entry_bg = "style=background-image:url(".$url.")"; ?>

                                        <a href="<?php echo get_permalink( $next_post->ID ); ?>" <?php echo esc_attr($entry_bg);?> class="next-post-bgimg"></a><?php
                                    endif; ?>

                                    <div class="nav-title-wrap">
                                        <span class="zmdi zmdi-long-arrow-right zmdi-hc-fw"></span>
                                        <p><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php esc_html_e('Next','sirpi-pro'); ?></a></p>
                                        <h3><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php
                                            if(get_the_title( $next_post->ID ) == '') {
                                                echo esc_html__('Next Post', 'sirpi-pro');
                                            } else {
                                                sirpi_html_output($next_post->post_title);
                                            } ?></a>
                                        </h3>
                                    </div>

                                </div>
                                <?php
                            else: ?>
                                <div class="post-next-link no-post">
                                    <a href="#" style="background-image:url(<?php echo esc_url(SIRPI_ROOT_URI.'/assets/images/no-post.jpg') ?>);" class="next-post-bgimg"></a>
                                    <div class="nav-title-wrap">
                                        <span class="zmdi zmdi-long-arrow-right zmdi-hc-fw"></span>
                                        <h3><?php echo esc_html__('No next story to show!', 'sirpi-pro'); ?></h3>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endif; ?>
                    </div>
                    <?php
                echo '</div>';
                echo ob_get_clean();

            }

        }
    }
}

SirpiProPostModern::instance();