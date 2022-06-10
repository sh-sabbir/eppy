<?php
namespace Eppy\Elementor\Core;

defined( 'ABSPATH' ) || die();

class Asset_Loader {

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
		// General scripts
		add_action( 'wp_enqueue_scripts', [$this, 'frontend_scripts_register'] );
		add_action( 'admin_enqueue_scripts', [$this, 'backend_scripts_register'] );

		// Elementor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'ele_editor_enqueue'] );
		add_action( 'elementor/preview/enqueue_scripts', [$this, 'ele_frontend_enqueue'] );

		// Declare Additional Icon pack for Elementor
		add_filter( 'elementor/icons_manager/additional_tabs', [$this, 'ele_add_eappyicons_tab'] );
	}

	public function frontend_scripts_register() {
        //
    }

	public function backend_scripts_register() {
        // Load the icons for admin backend
        wp_enqueue_style(
			'eppyicons',
			EPPY_URL . 'assets/vendor/eppyicons/style.min.css',
			null,
			EPPY_VERSION
		);
    }

	public function ele_editor_enqueue() {

    }
	public function ele_frontend_enqueue() {

    }

	/**
	 * @param $tabs
	 * @return mixed
	 */
	public function ele_add_eappyicons_tab( $tabs ) {
		$tabs['eazy-icons'] = [
			'name'          => 'eazy-icons',
			'label'         => __( 'Eazy Icons', 'eazygrid-elementor' ),
			'url'           => EAZYGRIDELEMENTOR_URL . 'assets/vendor/ezicon/style.min.css',
			'enqueue'       => [EAZYGRIDELEMENTOR_URL . 'assets/vendor/ezicon/style.min.css'],
			'prefix'        => 'ezicon-',
			'displayPrefix' => 'ezicon',
			'labelIcon'     => 'ezicon ezicon-eazyplugins',
			'ver'           => EAZYGRIDELEMENTOR_VERSION,
			'fetchJson'     => EAZYGRIDELEMENTOR_URL . 'assets/vendor/ezicon/fonts/ezicon.js?v=' . EAZYGRIDELEMENTOR_VERSION,
			'native'        => false,
		];
		return $tabs;
	}
}