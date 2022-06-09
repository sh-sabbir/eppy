<?php
/**
 * Plugin Name: Eppy - Elementor Widget Pack Boilerplate
 * Description: A starter boilerplate for developing Elementor widget pack
 * Plugin URI: https://github.com/sh-sabbir/eppy
 * Author: Sabbir Hasan
 * Version: 1.0.0
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
namespace Eppy\Elementor;

defined( 'ABSPATH' ) || die();

final class Eppy {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

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
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	public function __construct() {
		// Define necessary constants
		$this->defines_constant();

		// Check if Elementor is installed and activated
		$this->check_elementor();

		// Continue loading plugin dependency
		add_action( 'plugins_loaded', [$this, 'on_plugins_loaded'] );
	}

	public function defines_constant() {
		// Check Developer Mode
		$version = ( defined( 'EPPY_DEV_MODE' ) && true == EPPY_DEV_MODE ) ? time() : self::VERSION;

		// Define Version Constant
		define( 'EPPY_VERSION', $version );

		// Define Plugin Path Constant
		define( 'EPPY_PATH', plugin_dir_path( __FILE__ ) );

		// Define Plugin Url Constant
		define( 'EPPY_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * @return null
	 */
	public function check_elementor() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [$this, 'admin_notice_missing_main_plugin'] );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [$this, 'admin_notice_minimum_php_version'] );
			return;
		}
	}

	public function on_plugins_loaded() {
		// error_log('test');
		add_action( 'elementor/init', [$this, 'init'] );
		$this->run();
	}

	public function init() {
		\Eppy\Elementor\Core\Widget_Loader::instance()->init();
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

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

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

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

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

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-widget-pack-boilerplate' ),
			'<strong>' . esc_html__( 'Elementor Widget Pack Boilerplate', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-widget-pack-boilerplate' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * @param $class_name
	 * @return null
	 */
	protected function autoload( $class_name ) {
		if ( 0 !== strpos( $class_name, __NAMESPACE__ ) ) {
			return;
		}

		$file_name = strtolower(
			str_replace(
				[__NAMESPACE__ . '\\', '_', '\\'],
				['', '-', '/'],
				$class_name
			)
		);

		$file_name = str_replace( 'core/', 'core/class-', $file_name );

		$file = EPPY_PATH . $file_name . '.php';

		if ( str_contains( $file_name, 'widgets/' ) ) {
			$widget = explode( '/', $file_name )[1];
			$file   = EPPY_PATH . $file_name . '/' . $widget . '.php';
		}
		
		if ( ! class_exists( $class_name ) && is_readable( $file ) ) {
			include_once $file;
		}

		// error_log( $class_name );
		// error_log( $file_name );
		// error_log( $file );
	}

	public function run() {
		spl_autoload_register( [$this, 'autoload'] );
	}

}

new Eppy();