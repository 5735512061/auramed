<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'SirpiProCustomizerBlogPost' ) ) {
    class SirpiProCustomizerBlogPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'sirpi_pro_customizer_default', array( $this, 'default' ) );
			add_action( 'customize_register', array( $this, 'register' ), 20 );
        }

        function default( $option ) {

            $post_defaults = array();
            if( function_exists('sirpi_single_post_params_default') ) {
                $post_defaults = sirpi_single_post_params_default();
            }

            $option['enable_title'] 		  = $post_defaults['enable_title'];
            $option['enable_image_lightbox']  = $post_defaults['enable_image_lightbox'];
			$option['enable_disqus_comments'] = $post_defaults['enable_disqus_comments'];
			$option['post_disqus_shortname']  = $post_defaults['post_disqus_shortname'];
			$option['post_dynamic_elements']  = $post_defaults['post_dynamic_elements'];
            $option['post_commentlist_style'] = $post_defaults['post_commentlist_style'];

            $post_misc_defaults = array();
            if( function_exists('sirpi_single_post_misc_default') ) {
                $post_misc_defaults = sirpi_single_post_misc_default();
            }

            $option['enable_related_article'] = $post_misc_defaults['enable_related_article'];
			$option['rposts_title']    		  = $post_misc_defaults['rposts_title'];
			$option['rposts_column']   		  = $post_misc_defaults['rposts_column'];
			$option['rposts_count']    		  = $post_misc_defaults['rposts_count'];
			$option['rposts_excerpt']  		  = $post_misc_defaults['rposts_excerpt'];
			$option['rposts_excerpt_length']  = $post_misc_defaults['rposts_excerpt_length'];
			$option['rposts_carousel']  	  = $post_misc_defaults['rposts_carousel'];
			$option['rposts_carousel_nav']    = $post_misc_defaults['rposts_carousel_nav'];

            return $option;
        }

        function register( $wp_customize ) {

			/**
			 * Option : Post Title
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[enable_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_title]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Title', 'sirpi-pro'),
						'description' => esc_html__('YES! to enable the title of single post.', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Post Elements
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Sortable(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
						'type' => 'wdt-sortable',
						'label' => esc_html__( 'Post Elements Positioning', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => apply_filters( 'sirpi_blog_post_dynamic_elements', array(
							'author'		=> esc_html__('Author', 'sirpi-pro'),
							'author_bio' 	=> esc_html__('Author Bio', 'sirpi-pro'),
							'category'    	=> esc_html__('Categories', 'sirpi-pro'),
							'comment' 		=> esc_html__('Comments', 'sirpi-pro'),
							'comment_box' 	=> esc_html__('Comment Box', 'sirpi-pro'),
							'content'    	=> esc_html__('Content', 'sirpi-pro'),
							'date'     		=> esc_html__('Date', 'sirpi-pro'),
							'image'			=> esc_html__('Feature Image', 'sirpi-pro'),
							'navigation'    => esc_html__('Navigation', 'sirpi-pro'),
							'tag'  			=> esc_html__('Tags', 'sirpi-pro'),
							'title'      	=> esc_html__('Title', 'sirpi-pro'),
							'likes_views'   => esc_html__('Likes & Views', 'sirpi-pro'),
							'related_posts' => esc_html__('Related Posts', 'sirpi-pro'),
							'social'  		=> esc_html__('Social Share', 'sirpi-pro'),
						)
					),
				)
			));

			/**
			 * Option : Image Lightbox
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Feature Image Lightbox', 'sirpi-pro'),
						'description' => esc_html__('YES! to enable lightbox for feature image. Will not work in "Overlay" style.', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Article
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[enable_related_article]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_related_article]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Related Article', 'sirpi-pro'),
						'description' => esc_html__('YES! to enable related article at right hand side of post.', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Comments
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Disqus Comments', 'sirpi-pro'),
						'description' => esc_html__('YES! to enable disqus platform comments module.', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Short Name
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
						'type'    	  => 'textarea',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Shortname', 'sirpi-pro' ),
						'input_attrs' => array(
							'placeholder' => 'disqus',
						),
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Disqus Description
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[post_disqus_description]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Description(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[post_disqus_description]', array(
						'type'    	  => 'wdt-description',
						'section'     => 'site-blog-post-section',
						'description' => esc_html__('Your site\'s unique identifier', 'sirpi-pro').' '.'<a href="'.esc_url('https://help.disqus.com/customer/portal/articles/466208').'" target="_blank">'.esc_html__('What is this?', 'sirpi-pro').'</a>',
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Comment List Style
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Sirpi_Customize_Control(
				$wp_customize, SIRPI_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Comments List Style', 'sirpi-pro' ),
					'choices' => array(
						'rounded' 	=> esc_html__('Rounded', 'sirpi-pro'),
						'square'   	=> esc_html__('Square', 'sirpi-pro'),
					),
					'description' => esc_html__('Choose comments list style to display single post.', 'sirpi-pro'),
					'dependency' => array( 'enable_disqus_comments', '!=', 'true' ),
				)
			));

			/**
			 * Option : Post Related Title
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_title]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Related Posts Section Title', 'sirpi-pro' ),
						'description' => esc_html__('Put the related posts section title here', 'sirpi-pro'),
						'input_attrs' => array(
							'value'	=> esc_html__('Related Posts', 'sirpi-pro'),
						)
					)
				)
			);

			/**
			 * Option : Related Columns
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Sirpi_Customize_Control_Radio_Image(
				$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'wdt-radio-image',
					'label' => esc_html__( 'Columns', 'sirpi-pro'),
					'section' => 'site-blog-post-section',
					'choices' => apply_filters( 'sirpi_blog_post_related_columns', array(
						'one-column' => array(
							'label' => esc_html__( 'One Column', 'sirpi-pro' ),
							'path' => SIRPI_PRO_DIR_URL . 'modules/post/customizer/images/one-column.png'
						),
						'one-half-column' => array(
							'label' => esc_html__( 'One Half Column', 'sirpi-pro' ),
							'path' => SIRPI_PRO_DIR_URL . 'modules/post/customizer/images/one-half-column.png'
						),
						'one-third-column' => array(
							'label' => esc_html__( 'One Third Column', 'sirpi-pro' ),
							'path' => SIRPI_PRO_DIR_URL . 'modules/post/customizer/images/one-third-column.png'
						),
					)),
				)
			));

			/**
			 * Option : Related Count
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_count]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_count]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'No.of Posts to Show', 'sirpi-pro' ),
						'description' => esc_html__('Put the no.of related posts to show', 'sirpi-pro'),
						'input_attrs' => array(
							'value'	=> 3,
						),
					)
				)
			);

			/**
			 * Option : Enable Excerpt
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_excerpt]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_excerpt]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Excerpt Text', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Excerpt Text
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Excerpt Length', 'sirpi-pro' ),
						'description' => esc_html__('Put Excerpt Length', 'sirpi-pro'),
						'input_attrs' => array(
							'value'	=> 25,
						),
						'dependency' => array( 'rposts_excerpt', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Related Carousel
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_carousel]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Sirpi_Customize_Control_Switch(
					$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_carousel]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Carousel', 'sirpi-pro'),
						'description' => esc_html__('YES! to enable carousel related posts', 'sirpi-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'sirpi-pro' ),
							'off' => esc_attr__( 'No', 'sirpi-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Carousel Nav
			 */
			$wp_customize->add_setting(
				SIRPI_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Sirpi_Customize_Control(
				$wp_customize, SIRPI_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Navigation Style', 'sirpi-pro' ),
					'choices' => array(
						'' 			 => esc_html__('None', 'sirpi-pro'),
						'navigation' => esc_html__('Navigations', 'sirpi-pro'),
						'pager'   	 => esc_html__('Pager', 'sirpi-pro'),
					),
					'description' => esc_html__('Choose navigation style to display related post carousel.', 'sirpi-pro'),
					'dependency' => array( 'rposts_carousel', '==', 'true' ),
				)
			));

        }
    }
}

SirpiProCustomizerBlogPost::instance();