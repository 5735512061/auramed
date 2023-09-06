<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Heading {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_content_position;
	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents(array (), array (), array (), array ());
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

		// Actions & Filters
			add_filter( 'wdt_elementor_localize_settings', array( $this, 'wdt_register_elementor_localize_settings' )  );

	}

	public function name() {
		return 'wdt-heading';
	}

	public function title() {
		return esc_html__( 'Heading', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/heading/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function wdt_register_elementor_localize_settings($settings) {
		$settings['wdtHeaderItems'] = array(
			'icon' => esc_html__( 'Icon', 'wdt-elementor-addon'),
			'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
			'separator' => esc_html__( 'Separator', 'wdt-elementor-addon'),
			'subtitle' => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
            'background_text' => esc_html__( 'Background Text', 'wdt-elementor-addon'),
			'content' => esc_html__( 'Content', 'wdt-elementor-addon')
		);
		return $settings;
	}


	public function create_elementor_controls($elementor_object) {

		// Header

			$elementor_object->start_controls_section( 'wdt_section_header', array(
				'label' => esc_html__( 'Header', 'wdt-elementor-addon'),
			));

				// Title

					$elementor_object->add_control(
						'title_heading',
						array (
							'label' => esc_html__( 'Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING
						)
					);

					$elementor_object->add_control( 'title_tag', array(
						'label'   => esc_html__( 'Title Tag', 'wdt-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => 'h2',
						'options' => array(
							'div'  => esc_html__( 'Div', 'wdt-elementor-addon' ),
							'h1'   => esc_html__( 'H1', 'wdt-elementor-addon' ),
							'h2'   => esc_html__( 'H2', 'wdt-elementor-addon' ),
							'h3'   => esc_html__( 'H3', 'wdt-elementor-addon' ),
							'h4'   => esc_html__( 'H4', 'wdt-elementor-addon' ),
							'h5'   => esc_html__( 'H5', 'wdt-elementor-addon' ),
							'h6'   => esc_html__( 'H6', 'wdt-elementor-addon' ),
							'span' => esc_html__( 'Span', 'wdt-elementor-addon' ),
							'p'    => esc_html__( 'P', 'wdt-elementor-addon' )
						)
					));

					$elementor_object->add_control( 'title', array(
						'label'       => esc_html__( 'Title', 'wdt-elementor-addon' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => esc_html__( 'Your title goes here', 'wdt-elementor-addon' ),
						'default'     => esc_html__( 'Heading', 'wdt-elementor-addon' )
					));


				// Sub Title

					$elementor_object->add_control(
						'subtitle_heading',
						array (
							'label' => esc_html__( 'Sub Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control(
						'subtitle',
						array (
							'label' => esc_html__( 'Sub Title', 'elementor' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'label_block' => true,
							'placeholder' => esc_html__( 'Your sub title goes here', 'wdt-elementor-addon' ),
							'default' => esc_html__( 'Sub Heading', 'wdt-elementor-addon' )
						)
					);


				// Content

					$elementor_object->add_control(
						'content_heading',
						array (
							'label' => esc_html__( 'Content', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control(
						'content',
						array (
							'label' => esc_html__( 'Content', 'elementor' ),
							'type' => \Elementor\Controls_Manager::TEXTAREA,
							'default' => esc_html__( 'Few lines to well describe your content supporting headline.', 'wdt-elementor-addon' )
						)
					);


				// Background Text

                    $elementor_object->add_control(
                        'background_text_heading',
                        array (
                            'label' => esc_html__( 'Background Text', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::HEADING,
                            'separator' => 'before'
                        )
                    );

                    $elementor_object->add_control(
                        'background_text',
                        array (
                            'label' => esc_html__( 'Background Text', 'elementor' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'placeholder' => esc_html__( 'Your background text goes here', 'wdt-elementor-addon' ),
                            'default' => ''
                        )
                    );

			$elementor_object->end_controls_section();


		// Header - Decorative Elements

			$elementor_object->start_controls_section( 'wdt_section_header_decorative_elements', array(
				'label' => esc_html__( 'Header - Decorative Elements', 'wdt-elementor-addon'),
			));

				$elementor_object->add_control( 'apply_decoration_to', array(
					'label'   => esc_html__( 'Apply Decoration To', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'title',
					'options' => array(
						'title'  => esc_html__( 'Title', 'wdt-elementor-addon' ),
						'subtitle'   => esc_html__( 'Sub Title', 'wdt-elementor-addon' )
					),
					'separator' => 'after'
				));

				$elementor_object->add_control( 'header_media_type', array(
					'label'   => esc_html__( 'Media Type', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::CHOOSE,
					'default' => 'none',
					'options' => array(
						'none' => array (
							'title' => esc_html__( 'None', 'wdt-elementor-addon' ),
							'icon' => 'eicon-ban',
						),
						'image' => array (
							'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
							'icon' => 'eicon-image',
						),
						'icon' => array (
							'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'icon' => 'eicon-star',
						)
					)
				));

				$elementor_object->add_control(
					'header_image',
					array (
						'label' => esc_html__( 'Choose Image', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => array (
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
						'condition' => array (
							'header_media_type' => 'image'
						)
					)
				);

				$elementor_object->add_control(
					'header_icon',
					array (
						'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::ICONS,
						'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
						'condition' => array (
							'header_media_type' => 'icon'
						)
					)
				);

				$elementor_object->add_control(
					'header_show_line',
					array(
						'label'              => esc_html__( 'Show Line', 'wdt-elementor-addon' ),
						'type'               => \Elementor\Controls_Manager::SWITCHER,
						'frontend_available' => true,
						'default'            => '',
						'separator'          => 'before',
						'return_value'       => 'true'
					)
				);

			$elementor_object->end_controls_section();


		// Decorative Elements

			$elementor_object->start_controls_section( 'wdt_section_decorative_elements', array(
				'label' => esc_html__( 'Decorative Elements', 'wdt-elementor-addon'),
			));

				// Icon

					$elementor_object->add_control(
						'icon_heading',
						array (
							'label' => esc_html__( 'Icon', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control(
						'icon',
						array (
							'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'label_block' => false,
							'skin' => 'inline'
						)
					);

				// Separator

					$elementor_object->add_control(
						'separator_heading',
						array (
							'label' => esc_html__( 'Separator', 'elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before'
						)
					);

					$elementor_object->add_control( 'separator_type', array(
						'label'   => esc_html__( 'Separator Type', 'wdt-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => 'line',
						'options' => array(
							''  => esc_html__( 'None', 'wdt-elementor-addon' ),
							'line'  => esc_html__( 'Line', 'wdt-elementor-addon' ),
							'icon_n_line' => esc_html__( 'Icon & Line', 'wdt-elementor-addon' )
						)
					));

					$elementor_object->add_control(
						'separator_icon',
						array (
							'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ),
							'condition' => array(
								'separator_type' => array('icon_n_line')
							)
						)
					);

			$elementor_object->end_controls_section();

		// Highlight Elements

			$elementor_object->start_controls_section( 'wdt_section_highlight_elements', array(
				'label' => esc_html__( 'Highlight Elements', 'wdt-elementor-addon'),
			));

				$elementor_object->add_control( 'colored_elements', array(
					'label'       => esc_html__( 'Colored Elements', 'wdt-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => '1,2',
					'description'     => esc_html__( 'Enter comma separated positions of the Title, for colored elements.', 'wdt-elementor-addon' )
				));

			$elementor_object->end_controls_section();

		// Content Positions

			$elementor_object->start_controls_section( 'wdt_section_content_positions', array(
				'label' => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
			));

				$header_positions = new \Elementor\Repeater();
				$header_positions->add_control( 'element_value', array(
					'type'    => \Elementor\Controls_Manager::SELECT,
					'label'   => esc_html__('Element', 'wdt-elementor-addon'),
					'default' => 'title',
					'options' => array(
						'icon'            => esc_html__( 'Icon', 'wdt-elementor-addon'),
						'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator'       => esc_html__( 'Separator', 'wdt-elementor-addon'),
						'subtitle'        => esc_html__( 'Sub Text', 'wdt-elementor-addon'),
						'background_text' => esc_html__( 'Background Text', 'wdt-elementor-addon'),
						'content'         => esc_html__( 'Content', 'wdt-elementor-addon')
					)
				) );
				$elementor_object->add_control( 'header_positions', array(
					'type'          => \Elementor\Controls_Manager::REPEATER,
					'label'         => esc_html__('Positions', 'wdt-elementor-addon'),
					'fields'        => $header_positions->get_controls(),
					'default'       =>  array(
						array(
							'element_value' => 'icon'
						),
						array(
							'element_value' => 'title'
						),
						array(
							'element_value' => 'separator'
						),
						array(
							'element_value' => 'subtitle'
						),
						array(
							'element_value' => 'background_text'
						),
						array(
							'element_value' => 'content'
						)
					),
					'prevent_empty' => true,
					'title_field'   => '{{ wdtGetHeaderItems( obj ) }}'
				) );

			$elementor_object->end_controls_section();


		// Styles

			// Item
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'item',
					'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'control_type' => 'responsive',
							'default' => 'center',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-separator-wrapper .wdt-heading-separator, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-title-wrapper .wdt-heading-title, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-subtitle-wrapper .wdt-heading-subtitle' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						)
					)
				));

			// Title
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'title',
					'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'styles' => array (
						'vertical_align' => array (
							'field_type' => 'vertical_align',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'start' => array (
									'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'center' => array (
									'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'end' => array (
									'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'center',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'align-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'gradient_color' => array (
							'field_type' => 'gradient_color',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'separator' => 'after',
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'separator' => 'before',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'text_shadow' => array (
							'field_type' => 'text_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						)
					)
				));

			// Sub Title
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'subtitle',
					'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
					'styles' => array (
						'vertical_align' => array (
							'field_type' => 'vertical_align',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'start' => array (
									'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'center' => array (
									'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'end' => array (
									'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'center',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper .wdt-heading-subtitle' => 'align-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-subtitle-wrapper',
							'condition' => array ()
						),
					)
				));

			// Background Text
                $this->cc_style->get_style_controls($elementor_object, array (
                    'slug' => 'background_text',
                    'title' => esc_html__( 'Background Text', 'wdt-elementor-addon' ),
                    'styles' => array (
                        'margin' => array (
                            'field_type' => 'margin',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper .wdt-heading-background-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array ()
                        ),
                        'padding' => array (
                            'field_type' => 'padding',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper .wdt-heading-background-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array ()
                        ),
                        'typography' => array (
                            'field_type' => 'typography',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper .wdt-heading-background-text',
                            'condition' => array ()
                        ),
                        'color' => array (
                            'field_type' => 'color',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-background-text-wrapper .wdt-heading-background-text' => 'color: {{VALUE}};'
                            ),
                            'condition' => array ()
                        )
                    )
                ));

			// Content
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'content',
					'title' => esc_html__( 'Content', 'wdt-elementor-addon' ),
					'styles' => array (
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-content-wrapper',
							'condition' => array ()
						),
					)
				));

			// Icon
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'icon',
					'title' => esc_html__( 'Decorative Element - Icon', 'wdt-elementor-addon' ),
					'condition' => array (
						'icon[value]!' => ''
					),
					'styles' => array (
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'font_size' => array (
							'field_type' => 'font_size',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'font-size: {{SIZE}}{{UNIT}};'
							)
						),
						'width' => array (
							'field_type' => 'width',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'width: {{SIZE}}{{UNIT}};'
							)
						),
						'height' => array (
							'field_type' => 'height',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'height: {{SIZE}}{{UNIT}};'
							)
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-icon-wrapper .wdt-content-icon',
							'condition' => array ()
						)
					)
				));

			// Header - Decorative Elements
                $this->cc_style->get_style_controls($elementor_object, array (
                    'slug' => 'header_decorative_elements',
                    'title' => esc_html__( 'Header - Decorative Elements', 'wdt-elementor-addon' ),
                    'styles' => array (
                        'heading_deco' => array (
                            'field_type' => 'heading',
                            'unique_key' => 'deco',
                            'title' => esc_html__( 'Common', 'wdt-elementor-addon' ),
                            'condition' => array ()
                        ),
                        'space_deco' => array (
                            'field_type' => 'slider',
                            'unique_key' => 'deco_space',
                            'label' => esc_html__( 'Space', 'wdt-elementor-addon' ),
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'range' => array (
                                'px' => array (
                                    'min' => 1,
                                    'max' => 500,
                                )
                            ),
                            'selector' => array(
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner.wdt-left-part' => 'margin-right: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner.wdt-right-part' => 'margin-left: {{SIZE}}{{UNIT}};'
                            )
                        ),

                        'heading_line' => array (
                            'field_type' => 'heading',
                            'unique_key' => 'line',
                            'title' => esc_html__( 'Line', 'wdt-elementor-addon' ),
                            'condition' => array (),
                            'separator' => 'before',
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),
                        'alignment_line' => array (
                            'field_type' => 'alignment',
                            'unique_key' => 'line',
                            'label' => esc_html__( 'Position', 'wdt-elementor-addon' ),
                            'default' => 'before-after-title',
                            'options' => array(
                                'before-title' => array (
                                    'title' => esc_html__( 'Before Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-left',
                                ),
                                'before-after-title' => array (
                                    'title' => esc_html__( 'Before and After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-stretch',
                                ),
                                'after-title' => array (
                                    'title' => esc_html__( 'After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-right',
                                )
                            ),
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),
                        'width_line' => array (
                            'field_type' => 'width',
                            'unique_key' => 'line_width',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'range' => array (
                                'px' => array (
                                    'min' => 1,
                                    'max' => 500,
                                )
                            ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-line' => 'width: {{SIZE}}{{UNIT}};'
                            ),
                            'condition' => array (
                                'header_show_line' => 'true'
                            ),
                        ),
                        'height_line' => array (
                            'field_type' => 'height',
                            'unique_key' => 'line_height',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'range' => array (
                                'px' => array (
                                    'min' => 1,
                                    'max' => 500,
                                )
                            ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-line' => 'height: {{SIZE}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),
                        'background_line' => array (
                            'field_type' => 'background',
                            'unique_key' => 'line_background',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-line',
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),
                        'border_line' => array (
                            'field_type' => 'border',
                            'unique_key' => 'line_border',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-line',
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),
                        'border_radius_line' => array (
                            'field_type' => 'border_radius',
                            'unique_key' => 'line_border_radius',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-line' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_show_line' => 'true'
                            )
                        ),

                        'heading_icon' => array (
                            'field_type' => 'heading',
                            'unique_key' => 'icon',
                            'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
                            'condition' => array (),
                            'separator' => 'before',
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'alignment_icon' => array (
                            'field_type' => 'alignment',
                            'unique_key' => 'icon',
                            'label' => esc_html__( 'Position', 'wdt-elementor-addon' ),
                            'default' => 'before-after-title',
                            'options' => array(
                                'before-title' => array (
                                    'title' => esc_html__( 'Before Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-left',
                                ),
                                'before-after-title' => array (
                                    'title' => esc_html__( 'Before and After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-stretch',
                                ),
                                'after-title' => array (
                                    'title' => esc_html__( 'After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-right',
                                )
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'margin_icon' => array (
                            'field_type' => 'margin',
                            'unique_key' => 'icon',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'padding_icon' => array (
                            'field_type' => 'padding',
                            'unique_key' => 'icon',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'font_size_icon' => array (
                            'field_type' => 'font_size',
                            'unique_key' => 'icon',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'width_icon' => array (
                            'field_type' => 'width',
                            'unique_key' => 'icon',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};'
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'height_icon' => array (
                            'field_type' => 'height',
                            'unique_key' => 'icon',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};'
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'color_icon' => array (
                            'field_type' => 'color',
                            'unique_key' => 'icon',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span' => 'color: {{VALUE}};'
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'background_icon' => array (
                            'field_type' => 'background',
                            'unique_key' => 'icon',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span:before',
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'border_icon' => array (
                            'field_type' => 'border',
                            'unique_key' => 'icon',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span:before',
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'border_radius_icon' => array (
                            'field_type' => 'border_radius',
                            'unique_key' => 'icon',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),
                        'box_shadow_icon' => array (
                            'field_type' => 'box_shadow',
                            'unique_key' => 'icon',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-icon .wdt-content-icon span:before',
                            'condition' => array (
                                'header_media_type' => 'icon'
                            )
                        ),

                        'heading_image' => array (
                            'field_type' => 'heading',
                            'unique_key' => 'image',
                            'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
                            'condition' => array (),
                            'separator' => 'before',
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        ),
                        'alignment_image' => array (
                            'field_type' => 'alignment',
                            'unique_key' => 'image',
                            'label' => esc_html__( 'Position', 'wdt-elementor-addon' ),
                            'default' => 'before-after-title',
                            'options' => array(
                                'before-title' => array (
                                    'title' => esc_html__( 'Before Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-left',
                                ),
                                'before-after-title' => array (
                                    'title' => esc_html__( 'Before and After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-stretch',
                                ),
                                'after-title' => array (
                                    'title' => esc_html__( 'After Title', 'wdt-elementor-addon' ),
                                    'icon' => 'eicon-h-align-right',
                                )
                            ),
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        ),
                        'margin_iamge' => array (
                            'field_type' => 'margin',
                            'unique_key' => 'iamge',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'iamge'
                            )
                        ),
                        'padding_iamge' => array (
                            'field_type' => 'padding',
                            'unique_key' => 'iamge',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'iamge'
                            )
                        ),
                        'width_image' => array (
                            'field_type' => 'width',
                            'unique_key' => 'image_width',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'range' => array (
                                'px' => array (
                                    'min' => 1,
                                    'max' => 500,
                                )
                            ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span' => 'width: {{SIZE}}{{UNIT}};'
                            ),
                            'condition' => array (
                                'header_media_type' => 'image'
                            ),
                        ),
                        'height_image' => array (
                            'field_type' => 'height',
                            'unique_key' => 'image_height',
                            'default' => array (
                                'unit' => 'px'
                            ),
                            'size_units' => array ( 'px' ),
                            'range' => array (
                                'px' => array (
                                    'min' => 1,
                                    'max' => 500,
                                )
                            ),
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span' => 'height: {{SIZE}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        ),
                        'border_image' => array (
                            'field_type' => 'border',
                            'unique_key' => 'image',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span:before',
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        ),
                        'border_radius_image' => array (
                            'field_type' => 'border_radius',
                            'unique_key' => 'image',
                            'selector' => array (
                                '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        ),
                        'box_shadow_image' => array (
                            'field_type' => 'box_shadow',
                            'unique_key' => 'image',
                            'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-deco-wrapper .wdt-heading-deco-inner .wdt-heading-deco-image span:before',
                            'condition' => array (
                                'header_media_type' => 'image'
                            )
                        )

                    )
                ));

			// Decorative Element - Separator
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'separator',
					'title' => esc_html__( 'Decorative Element - Separator', 'wdt-elementor-addon' ),
					'styles' => array (
						'heading_line' => array (
							'field_type' => 'heading',
							'unique_key' => 'line',
							'title' => esc_html__( 'Line', 'wdt-elementor-addon' ),
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							),
							'separator' => 'before'
						),
						'width_line' => array (
							'field_type' => 'width',
							'unique_key' => 'line_width',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'range' => array (
								'px' => array (
									'min' => 1,
									'max' => 500,
								)
							),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line' => 'width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							)
						),
						'height_line' => array (
							'field_type' => 'height',
							'unique_key' => 'line_height',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'range' => array (
								'px' => array (
									'min' => 1,
									'max' => 500,
								)
							),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line' => 'height: {{SIZE}}{{UNIT}};',
							),
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							)
						),
						'space_line' => array (
							'field_type' => 'slider',
							'unique_key' => 'line_space',
							'label' => esc_html__( 'Space', 'wdt-elementor-addon' ),
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'range' => array (
								'px' => array (
									'min' => 1,
									'max' => 50,
								)
							),
							'selector' => array(
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line.wdt-left-part' => 'margin-right: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line.wdt-right-part' => 'margin-left: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'separator_type' => array ( 'icon_n_line' )
							)
						),

						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line',
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							)
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line',
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							)
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-line .wdt-separator-line' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'separator_type' => array ( 'line', 'icon_n_line' )
							)
						),
						'heading_icon' => array (
							'field_type' => 'heading',
							'unique_key' => 'icon',
							'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							),
							'separator' => 'before'
						),
						'margin_icon' => array (
							'field_type' => 'margin',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'padding_icon' => array (
							'field_type' => 'padding',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'font_size_icon' => array (
							'field_type' => 'font_size',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'width_icon' => array (
							'field_type' => 'width',
							'unique_key' => 'icon',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'height_icon' => array (
							'field_type' => 'height',
							'unique_key' => 'icon',
							'default' => array (
								'unit' => 'px'
							),
							'size_units' => array ( 'px' ),
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};'
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'color_icon' => array (
							'field_type' => 'color',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span' => 'color: {{VALUE}};'
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'background_icon' => array (
							'field_type' => 'background',
							'unique_key' => 'icon',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span:before',
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'border_icon' => array (
							'field_type' => 'border',
							'unique_key' => 'icon',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span:before',
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'border_radius_icon' => array (
							'field_type' => 'border_radius',
							'unique_key' => 'icon',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						),
						'box_shadow_icon' => array (
							'field_type' => 'box_shadow',
							'unique_key' => 'icon',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-separator-wrapper .wdt-heading-separator.with-icon .wdt-content-icon span:before',
							'condition' => array (
								'separator_type' => array ( 'icon', 'icon_n_line' )
							)
						)
					)
				));

			// Highlight Elements
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'highlight_elements',
					'title' => esc_html__( 'Highlight Elements', 'wdt-elementor-addon' ),
					'condition' => array (
						'colored_elements!' => ''
					),
					'styles' => array (
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title .wdt-heading-colored-elements' => 'color: {{VALUE}};'
							)
						),
						'gradient_color' => array (
							'field_type' => 'gradient_color',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title .wdt-heading-colored-elements',
							'separator' => 'after',
							'condition' => array ()
						),
					)
				));

		do_action('wdt_heading_pro_controls', $elementor_object);


	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		$classes = array ();
		$module_id = $widget_object->get_id();

		$content_positions = $this->cc_repeater_contents->content_position_items($settings['header_positions']);
		if(is_array($content_positions) && !empty($content_positions)) {

			$output .= '<div class="wdt-heading-holder '.esc_attr(implode(' ', $classes)).'" id="wdt-heading-'.esc_attr($module_id).'">';

			foreach($content_positions as $content_position) {
				if($content_position == 'icon') {
					$output .= $this->render_icon_html($module_id, $widget_object, $settings);
				} else if($content_position == 'title') {
					$output .= $this->render_title_html($settings);
				} else if($content_position == 'separator') {
					$output .= $this->render_separator_html($settings);
				} else if($content_position == 'subtitle') {
					$output .= $this->render_subtitle_html($settings, $widget_object);
				} else if($content_position == 'background_text') {
					$output .= $this->render_background_text_html($settings, $widget_object);
				} else if($content_position == 'content') {
					$output .= $this->render_content_html($settings);
				}
			}

			$output .= '</div>';

		}

		return $output;

	}

	public function render_icon($icon) {
		$output = '';
		if(!empty($icon['value'])):

			$output .= '<span class="wdt-content-icon-wrapper">';
				$output .= '<span class="wdt-content-icon"><span>';
					$output .= ($icon['library'] === 'svg') ? '<i>' : '';
						ob_start();
						\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
						$output .= ob_get_clean();
					$output .= ($icon['library'] === 'svg') ? '</i>' : '';
				$output .= '</span></span>';
			$output .= '</span>';

		endif;
		return $output;
	}

	public function render_icon_html($module_id, $widget_object, $settings) {

		$output = '';

		if(isset($settings['icon']) && !empty($settings['icon']['value'])) {
			$output .= '<div class="wdt-heading-icon-wrapper">';
				$output .= $this->render_icon($settings['icon']);
			$output .= '</div>';
		}

		return $output;

	}

	public function render_title_html($settings) {

		$output = '';

		$deco_class = '';
		if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'title') {
			$deco_class = 'wdt-heading-deco-wrapper';
		}

		if(isset($settings['title']) && !empty($settings['title'])) {
			$output .= '<'.esc_attr($settings['title_tag']).' class="wdt-heading-title-wrapper wdt-heading-align-'.esc_attr($settings['title_vertical_align']).' '.esc_attr($deco_class).'">';
				$output .= '<span class="wdt-heading-title">';
					if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'title') {
						$output .= $this->render_header_decorative_left_html($settings);
					}
					$output .= $this->render_title_splitup_html($settings['title'], $settings['colored_elements']);
					if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'title') {
						$output .= $this->render_header_decorative_right_html($settings);
					}
				$output .= '</span>';
			$output .= '</'.esc_attr($settings['title_tag']).'>';
		}

		return $output;

	}

	public function render_title_splitup_html($title, $colored_elements) {

		$splitted_titles = explode(' ', $title);
		$colored_elements_splitted = explode(',', trim($colored_elements));

		$text = '';
		foreach($splitted_titles as $key => $splitted_title) {
			$updated_key = $key + 1;
			if(in_array($updated_key, $colored_elements_splitted)) {
				$text .= '<span class="wdt-heading-colored-elements">'.$splitted_title.'</span>';
			} else {
				$text .= $splitted_title.' ';
			}
		}

		return trim($text);

	}

	public function render_subtitle_html($settings) {

		$output = '';

		$deco_class = '';
		if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'subtitle') {
			$deco_class = 'wdt-heading-deco-wrapper';
		}

		if(isset($settings['subtitle']) && !empty($settings['subtitle'])) {
			$output .= '<div class="wdt-heading-subtitle-wrapper wdt-heading-align-'.esc_attr($settings['subtitle_vertical_align']).' '.esc_attr($deco_class).'">';
				$output .= '<span class="wdt-heading-subtitle">';
					if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'subtitle') {
						$output .= $this->render_header_decorative_left_html($settings);
					}
					$output .= $settings['subtitle'];
					if(isset($settings['apply_decoration_to']) && $settings['apply_decoration_to'] == 'subtitle') {
						$output .= $this->render_header_decorative_right_html($settings);
					}
				$output .= '</span>';
			$output .= '</div>';
		}

		return $output;

	}

	public function render_background_text_html($settings) {

		$output = '';

		if(isset($settings['background_text']) && !empty($settings['background_text'])) {
			$output .= '<div class="wdt-heading-background-text-wrapper">';
				$output .= '<div class="wdt-heading-background-text">';
					$output .= $settings['background_text'];
				$output .= '</div>';
			$output .= '</div>';
		}

		return $output;

	}

	public function render_header_decorative_left_html($settings) {

		$output = '';

		if(($settings['header_media_type'] == 'icon' && isset($settings['header_icon']['value'])) || ($settings['header_media_type'] == 'image' && isset($settings['header_image']['url'])) || (isset($settings['header_show_line']) && $settings['header_show_line'] == 'true' && ($settings['header_decorative_elements_line_align'] == 'before-title' || $settings['header_decorative_elements_line_align'] == 'before-after-title'))) {

			$output .= '<span class="wdt-heading-deco-inner wdt-left-part">';

				if(isset($settings['header_show_line']) && $settings['header_show_line'] == 'true') {
					if(isset($settings['header_decorative_elements_line_align']) && ($settings['header_decorative_elements_line_align'] == 'before-title' || $settings['header_decorative_elements_line_align'] == 'before-after-title')) {
						$output .= '<span class="wdt-heading-deco-line"></span>';
					}
				}
				if(isset($settings['header_decorative_elements_image_align']) && ($settings['header_decorative_elements_image_align'] == 'before-title' || $settings['header_decorative_elements_image_align'] == 'before-after-title')) {
					$output .= $this->render_header_media_image_html($settings);
				}
				if(isset($settings['header_decorative_elements_icon_align']) && ($settings['header_decorative_elements_icon_align'] == 'before-title' || $settings['header_decorative_elements_icon_align'] == 'before-after-title')) {
					$output .= $this->render_header_media_icon_html($settings);
				}

			$output .= '</span>';

		}

		return $output;

	}

	public function render_header_decorative_right_html($settings) {

		$output = '';

		if(($settings['header_media_type'] == 'icon' && isset($settings['header_icon']['value'])) || ($settings['header_media_type'] == 'image' && isset($settings['header_image']['url'])) || (isset($settings['header_show_line']) && $settings['header_show_line'] == 'true' && ($settings['header_decorative_elements_line_align'] == 'after-title' || $settings['header_decorative_elements_line_align'] == 'before-after-title'))) {

			$output .= '<span class="wdt-heading-deco-inner wdt-right-part">';

				if(isset($settings['header_decorative_elements_icon_align']) && ($settings['header_decorative_elements_icon_align'] == 'after-title' || $settings['header_decorative_elements_icon_align'] == 'before-after-title')) {
					$output .= $this->render_header_media_icon_html($settings);
				}
				if(isset($settings['header_decorative_elements_image_align']) && ($settings['header_decorative_elements_image_align'] == 'after-title' || $settings['header_decorative_elements_image_align'] == 'before-after-title')) {
					$output .= $this->render_header_media_image_html($settings);
				}
				if(isset($settings['header_show_line']) && $settings['header_show_line'] == 'true') {
					if(isset($settings['header_decorative_elements_line_align']) && ($settings['header_decorative_elements_line_align'] == 'after-title' || $settings['header_decorative_elements_line_align'] == 'before-after-title')) {
						$output .= '<span class="wdt-heading-deco-line"></span>';
					}
				}

			$output .= '</span>';

		}

		return $output;

	}

	public function render_header_media_icon_html($settings) {

		$output = '';

		if($settings['header_media_type'] == 'icon' && isset($settings['header_icon']) && !empty($settings['header_icon']['value'])) {
			$output .= '<span class="wdt-heading-deco-icon">';
				$output .= $this->render_icon($settings['header_icon']);
			$output .= '</span>';
		}

		return $output;

	}

	public function render_header_media_image_html($settings) {

		$output = '';

		if($settings['header_media_type'] == 'image' && isset($settings['header_image']) && !empty($settings['header_image']['url'])) {
			$output .= '<span class="wdt-heading-deco-image">';
				$output .= '<span><img src="'.esc_url($settings['header_image']['url']).'" alt=""></span>';
			$output .= '</span>';
		}

		return $output;

	}

	public function render_content_html($settings) {

		$output = '';

		if(isset($settings['content']) && !empty($settings['content'])) {
			$output .= '<div class="wdt-heading-content-wrapper">';
				$output .= $settings['content'];
			$output .= '</div>';
		}

		return $output;

	}

	public function render_separator_html($settings) {

		$output = '';

		if(isset($settings['separator_type']) && $settings['separator_type'] != '') {
			$output .= '<div class="wdt-heading-separator-wrapper">';
				if($settings['separator_type'] == 'line') {
					$output .= '<div class="wdt-heading-separator with-line">';
						$output .= '<div class="wdt-separator-line"></div>';
					$output .= '</div>';
				}
				if($settings['separator_type'] == 'icon_n_line') {
					$output .= '<div class="wdt-heading-separator with-icon with-line">';
						$output .= '<div class="wdt-separator-line wdt-left-part"></div>';
						$output .= $this->render_icon($settings['separator_icon']);
						$output .= '<div class="wdt-separator-line wdt-right-part"></div>';
					$output .= '</div>';
				}
			$output .= '</div>';
		}

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_heading' ) ) {
    function wedesigntech_widget_base_heading() {
		/* if(class_exists('WeDesignTechElementorProAddon') && class_exists('WeDesignTech_Pro_Widget_Base_Heading')) {
        	return WeDesignTech_Pro_Widget_Base_Heading::instance();
		} else { */
			return WeDesignTech_Widget_Base_Heading::instance();
		//}
    }
}