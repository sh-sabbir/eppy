<?php
namespace Eppy\Elementor\Core;

defined( 'ABSPATH' ) || die();

class Widget_Loader {

	/**
	 * @var mixed
	 */
	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		add_action( 'elementor/widgets/widgets_registered', [$this, 'init_widgets'], 30 );
	}

	/**
	 * @return mixed
	 */
	public static function get_widget_list() {
		$widgets_map = [];
		foreach ( glob( EPPY_PATH . 'widgets/**/*.php' ) as $filename ) {
			$class_name    = str_replace( EPPY_PATH . 'widgets/', '', $filename );
			$class_name    = str_replace( '-', '_', $class_name );
			$class_name    = str_replace( '.php', '', $class_name );
			$class_name	   = explode('/',$class_name);
			$widgets_map[] = $class_name[1];
		}

		// error_log(print_r($widgets_map,true));

		return $widgets_map;
	}

	public function init_widgets() {
		foreach ( $this->get_widget_list() as $class_name ) {
			$class_name = "\\Eppy\\Elementor\\Widgets\\{$class_name}";
			error_log($class_name);
			if ( class_exists( $class_name ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new $class_name() );
			}
		}
	}
}