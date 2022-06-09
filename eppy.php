<?php
/**
 * Plugin Name: Eppy - Elementor Widget Pack Boilerplate
 * Description: A starter boilerplate for developing Elementor widget pack
 * Plugin URI: https://github.com/sh-sabbir/eppy
 * Author: Sabbir Hasan
 * Version: 0.0.1
 * Author URI: https://iamsabbir.dev
 *
 * Text Domain: eppy
 *
 * Elementor tested up to: 3.6.4
 * Elementor Pro tested up to: 3.6.5
 * 
 * @package Eppy
 * @category Core
 *
 * Eppy is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Eppy is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Eppy {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '0.0.1';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '6.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * The single instance of the class.
	 */
	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	protected function __construct() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		require_once('widgets/my-widget/my-widget.php');


		// Register Widget
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register Widget Scripts
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ] );

	}


	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\My_Widget() );

	}

	public function widget_styles() {
		wp_enqueue_style( 'my-widget-css', plugins_url( 'widgets/my-widget/css/my-widget.css', __FILE__ ) );

	}

	public function widget_scripts() {
		wp_enqueue_script( 'my-widget-js', plugins_url( 'widgets/my-widget/js/my-widget.js', __FILE__ ), array( 'jquery' ) );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-widget-pack-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Widget Pack Boilerplate', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-widget-pack-boilerplate' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-widget-pack-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Widget Pack Boilerplate', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-widget-pack-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Widget Pack Boilerplate', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

add_action( 'init', 'Eppy_elementor_init' );
function Eppy_elementor_init() {
	Eppy::get_instance();
}