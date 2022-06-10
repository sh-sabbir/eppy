<?php

namespace Eppy\Elementor\Core;

use Elementor\Widget_Base;

abstract class Eppy_Base extends Widget_Base{

    const WIDGET_PREFIX = 'eppy-';
    const WIDGET_CATEGORY = 'eppy_widgets';

    /**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		/**
		 * Automatically generate widget name from class
		 *
		 * Card will be card
		 * Blog_Card will be blog-card
		 */
		$name = str_replace( strtolower( __NAMESPACE__ ), '', strtolower( $this->get_class_name() ) );
		$name = str_replace( '_', '-', $name );
		$name = substr( $name, ( strrpos( $name, 'widgets\\' ) ) );
		$name = str_replace( 'widgets\\', '', $name );
		$name = ltrim( $name, '\\' );
		return self::WIDGET_PREFIX . $name;
	}

    /**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'ezicon ezicon-eazygrid';
	}

    /**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ self::WIDGET_CATEGORY ];
	}


    /**
	 * Override from addon to add custom wrapper class.
	 *
	 * @return string
	 */
	protected function get_custom_wrapper_class() {
		return '';
	}


    /**
	 * Overriding default function to add custom html class.
	 *
	 * @return string
	 */
	public function get_html_wrapper_class() {
		$html_class  = parent::get_html_wrapper_class();
		$html_class .= ' eazy-grid-elementor';
		$html_class .= ' ' . $this->get_name();
		$html_class .= ' ' . $this->get_custom_wrapper_class();
		return rtrim( $html_class );
	}
    
    /**
	 * Overriding default function to add custom html class.
	 *
	 * @return string
	 */
	public function get_html_wrapper_class() {
		$html_class  = parent::get_html_wrapper_class();
		$html_class .= ' eppy-elementor-wrap';
		$html_class .= ' ' . $this->get_name();
		$html_class .= ' ' . $this->get_custom_wrapper_class();
		return rtrim( $html_class );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

        // HOOK: Before Register Content Control
		do_action( 'eppy/elementor/start/content/controls', $this );
        
		$this->register_content_controls();
        
        // HOOK: After Register Content Control
		do_action( 'eppy/elementor/end/content/controls', $this );

        // HOOK: Before Register Style Control
		do_action( 'eppy/elementor/start/style/controls', $this );
		
        $this->register_style_controls();
        
        // HOOK: After Register Style Control
		do_action( 'eppy/elementor/end/style/controls', $this );
	}

	/**
	 * Register content controls
	 *
	 * @return void
	 */
	abstract protected function register_content_controls();

	/**
	 * Register style controls
	 *
	 * @return void
	 */
	abstract protected function register_style_controls();
}