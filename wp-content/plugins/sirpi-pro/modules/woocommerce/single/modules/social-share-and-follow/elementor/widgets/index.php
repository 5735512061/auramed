<?php

namespace SirpiElementor\Widgets;
use SirpiElementor\Widgets\Sirpi_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Sirpi_Shop_Widget_Product_Summary_Extend extends Sirpi_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'sirpi-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'sirpi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'sirpi-pro'),
					'share'  => esc_html__('Share', 'sirpi-pro'),
					'follow' => esc_html__('Follow', 'sirpi-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'sirpi-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'sirpi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'sirpi-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'sirpi-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'sirpi-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'sirpi-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'sirpi-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'sirpi-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'sirpi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'sirpi-pro' ),
					'rounded' => esc_html__( 'Rounded', 'sirpi-pro' ),
					'circle'  => esc_html__( 'Circle', 'sirpi-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'sirpi-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'sirpi-pro' ),
				'label_off'    => esc_html__( 'no', 'sirpi-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'sirpi-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}