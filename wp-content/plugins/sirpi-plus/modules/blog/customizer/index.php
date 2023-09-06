<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiPlusCustomizerSiteBlog' ) ) {
    class SirpiPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'sirpi_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $blog_defaults = array();
            if( function_exists('sirpi_archive_blog_post_defaults') ) {
                $blog_defaults = sirpi_archive_blog_post_defaults();
            }

            $option['blog-post-layout']          = $blog_defaults['post-layout'];
            $option['blog-post-cover-style']     = $blog_defaults['post-cover-style'];
            $option['blog-post-grid-list-style'] = $blog_defaults['post-gl-style'];
            $option['blog-list-thumb']           = $blog_defaults['list-type'];
            $option['blog-image-hover-style']    = $blog_defaults['hover-style'];
            $option['blog-image-overlay-style']  = $blog_defaults['overlay-style'];
            $option['blog-alignment']            = $blog_defaults['post-align'];
            $option['blog-post-columns']         = $blog_defaults['post-column'];

            $blog_misc_defaults = array();
            if( function_exists('sirpi_archive_blog_post_misc_defaults') ) {
                $blog_misc_defaults = sirpi_archive_blog_post_misc_defaults();
            }

            $option['enable-equal-height']       = $blog_misc_defaults['enable-equal-height'];
            $option['enable-no-space']           = $blog_misc_defaults['enable-no-space'];

            $blog_params = array();
            if( function_exists('sirpi_archive_blog_post_params_default') ) {
                $blog_params = sirpi_archive_blog_post_params_default();
            }

            $option['enable-post-format']        = $blog_params['enable_post_format'];
            $option['enable-video-audio']        = $blog_params['enable_video_audio'];
            $option['enable-gallery-slider']     = $blog_params['enable_gallery_slider'];
            $option['blog-elements-position']    = $blog_params['archive_post_elements'];
            $option['blog-meta-position']        = $blog_params['archive_meta_elements'];
            $option['blog-readmore-text']        = $blog_params['archive_readmore_text'];
            $option['enable-excerpt-text']       = $blog_params['enable_excerpt_text'];
            $option['blog-excerpt-length']       = $blog_params['archive_excerpt_length'];
            $option['blog-pagination']           = $blog_params['archive_blog_pagination'];


            return $option;

        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Sirpi_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'sirpi-plus'),
                        'priority' => sirpi_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new Sirpi_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'sirpi-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control_Radio_Image(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'sirpi-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'sirpi_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        ),
                        'entry-cover' => array(
                            'label' => esc_html__( 'Cover', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-cover.png'
                        ),
                    ))
                )
            ));

            /**
             * Option : Post Grid, List Style
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'sirpi-plus' ),
                    'choices' => apply_filters('blog_post_grid_list_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'sirpi-plus'),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' )
                )
            ));

            /**
             * Option : Post Cover Style
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'sirpi-plus' ),
                    'choices' => apply_filters('blog_post_cover_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'sirpi-plus')
                    )),
                    'dependency'   => array( 'blog-post-layout', '==', 'entry-cover' )
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control_Radio_Image(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Columns', 'sirpi-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'sirpi_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control_Radio_Image(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'List Type', 'sirpi-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'sirpi_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'sirpi-plus' ),
                            'path' => SIRPI_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'sirpi-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'sirpi-plus'),
                      'alignleft'   => esc_html__('Align Left', 'sirpi-plus'),
                      'aligncenter' => esc_html__('Align Center', 'sirpi-plus'),
                      'alignright'  => esc_html__('Align Right', 'sirpi-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new Sirpi_Customize_Control_Separator(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control_Sortable(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'sirpi-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'sirpi_archive_post_elements_options', array(
                        'feature_image' => esc_html__('Feature Image', 'sirpi-plus'),
                        'title'         => esc_html__('Title', 'sirpi-plus'),
                        'content'       => esc_html__('Content', 'sirpi-plus'),
                        'read_more'     => esc_html__('Read More', 'sirpi-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'sirpi-plus'),
                        'author'        => esc_html__('Author', 'sirpi-plus'),
                        'date'          => esc_html__('Date', 'sirpi-plus'),
                        'comment'       => esc_html__('Comments', 'sirpi-plus'),
                        'category'      => esc_html__('Categories', 'sirpi-plus'),
                        'tag'           => esc_html__('Tags', 'sirpi-plus'),
                        'social'        => esc_html__('Social Share', 'sirpi-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'sirpi-plus'),
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control_Sortable(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'sirpi-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'sirpi_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'sirpi-plus'),
                        'date'          => esc_html__('Date', 'sirpi-plus'),
                        'comment'       => esc_html__('Comments', 'sirpi-plus'),
                        'category'      => esc_html__('Categories', 'sirpi-plus'),
                        'tag'           => esc_html__('Tags', 'sirpi-plus'),
                        'social'        => esc_html__('Social Share', 'sirpi-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'sirpi-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'sirpi-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new Sirpi_Customize_Control_Separator(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Post Format
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-post-format]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-post-format]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Post Format', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'sirpi-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'sirpi-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control_Switch(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'sirpi-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'sirpi-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'sirpi-plus' ),
                            'off' => esc_attr__( 'No', 'sirpi-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Sirpi_Customize_Control(
                    $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'sirpi-plus' ),
                        'description' => esc_html__('Put the read more text here', 'sirpi-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'sirpi-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'sirpi-plus' ),
                    'choices' => array(
                      'wdt-default'     => esc_html__('Default', 'sirpi-plus'),
                      'wdt-blur'        => esc_html__('Blur', 'sirpi-plus'),
                      'wdt-bw'          => esc_html__('Black and White', 'sirpi-plus'),
                      'wdt-brightness'  => esc_html__('Brightness', 'sirpi-plus'),
                      'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'sirpi-plus'),
                      'wdt-fadeinright' => esc_html__('Fade InRight', 'sirpi-plus'),
                      'wdt-hue-rotate'  => esc_html__('Hue-Rotate', 'sirpi-plus'),
                      'wdt-invert'      => esc_html__('Invert', 'sirpi-plus'),
                      'wdt-opacity'     => esc_html__('Opacity', 'sirpi-plus'),
                      'wdt-rotate'      => esc_html__('Rotate', 'sirpi-plus'),
                      'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'sirpi-plus'),
                      'wdt-scalein'     => esc_html__('Scale In', 'sirpi-plus'),
                      'wdt-scaleout'    => esc_html__('Scale Out', 'sirpi-plus'),
                      'wdt-sepia'       => esc_html__('Sepia', 'sirpi-plus'),
                      'wdt-tint'        => esc_html__('Tint', 'sirpi-plus'),
                    ),
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'sirpi-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'sirpi-plus' ),
                    'choices' => array(
                      'wdt-default'           => esc_html__('None', 'sirpi-plus'),
                      'wdt-fixed'             => esc_html__('Fixed', 'sirpi-plus'),
                      'wdt-tb'                => esc_html__('Top to Bottom', 'sirpi-plus'),
                      'wdt-bt'                => esc_html__('Bottom to Top', 'sirpi-plus'),
                      'wdt-rl'                => esc_html__('Right to Left', 'sirpi-plus'),
                      'wdt-lr'                => esc_html__('Left to Right', 'sirpi-plus'),
                      'wdt-middle'            => esc_html__('Middle', 'sirpi-plus'),
                      'wdt-middle-radial'     => esc_html__('Middle Radial', 'sirpi-plus'),
                      'wdt-tb-gradient'       => esc_html__('Gradient - Top to Bottom', 'sirpi-plus'),
                      'wdt-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'sirpi-plus'),
                      'wdt-rl-gradient'       => esc_html__('Gradient - Right to Left', 'sirpi-plus'),
                      'wdt-lr-gradient'       => esc_html__('Gradient - Left to Right', 'sirpi-plus'),
                      'wdt-radial-gradient'   => esc_html__('Gradient - Radial', 'sirpi-plus'),
                      'wdt-flash'             => esc_html__('Flash', 'sirpi-plus'),
                      'wdt-circle'            => esc_html__('Circle', 'sirpi-plus'),
                      'wdt-hm-elastic'        => esc_html__('Horizontal Elastic', 'sirpi-plus'),
                      'wdt-vm-elastic'        => esc_html__('Vertical Elastic', 'sirpi-plus'),
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'sirpi-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                SIRPI_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Sirpi_Customize_Control(
                $wp_customize, SIRPI_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'sirpi-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'sirpi-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'sirpi-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'sirpi-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'sirpi-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'sirpi-plus')
                )
            ));

        }
    }
}

SirpiPlusCustomizerSiteBlog::instance();