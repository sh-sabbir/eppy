<?php
namespace Elementor;

class My_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'my-widget';
	}

	/**
	 * Get widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return 'My Widget';
	}

	/**
	 * Get widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-editor-code';
	}

	/**
	 * Get widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register widget controls.
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		/**
		 *  Here you can add your controls. The controls below are only examples.
		 *  Check this: https://developers.elementor.com/elementor-controls/
		 *
		 **/


		$this->end_controls_section();
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'My Section', 'elementor-widget-pack-boilerplate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'custom',
			[
				'label' => __( 'Your Label', 'elementor-widget-pack-boilerplate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text'
			]
		);      

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		/**
		 *  Here you can output your control data and build your content.
		 **/

 ?>
<!-- Here you can add your custom HTML output.
You can use all field variables you created above. -->
<div>
  <h2>Start writing. This is just an <?php echo $settings['example'] ?></h2>
</div>
 <?php

	}

	/**
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 * With JS templates we don’t really need to retrieve the data using a special function, its done by Elementor for us.
	 * The data from the controls stored in the settings variable.
	 */
	protected function _content_template() {
		?>
<!-- Here you can add your custom HTML output.
You can use all field variables you created above. -->
<div>
  <h2>Start writing. This is just an {{{ settings.example }}}</h2>
</div>
		<?php
	}
}

    