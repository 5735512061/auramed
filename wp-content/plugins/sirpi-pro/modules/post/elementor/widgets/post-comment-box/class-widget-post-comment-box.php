<?php
use SirpiElementor\Widgets\SirpiElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Comment_Box extends SirpiElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-comment-box';
    }

    public function get_title() {
        return esc_html__('Post - Comment Box', 'sirpi-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'sirpi-pro'),
        ) );

            $this->add_control( 'comment_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Style', 'sirpi-pro'),
                'default' => '',
                'options' => array(
                    ''  => esc_html__('Default', 'sirpi-pro'),
                    'rounded'	=> esc_html__('Rounded', 'sirpi-pro'),
                    'square'  	=> esc_html__('Square', 'sirpi-pro'),
                ),
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $Post_Style = sirpi_get_single_post_style( $post_id );

        $template_args['post_ID'] = $post_id;
        $template_args['post_Style'] = $Post_Style;
        $template_args = array_merge( $template_args, sirpi_single_post_params() );
        $template_args['post_commentlist_style'] = $comment_style;

        $out .= sirpi_get_template_part( 'post', 'templates/post-extra/comment_box', '', $template_args );

		echo $out;
	}

}