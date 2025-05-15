<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Findamidwife_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		FINDAMIDWI
 * @subpackage	Classes/Findamidwife_Run
 * @author		Marcus Powell
 * @since		1.0.0
 */
class Findamidwife_Run{

	/**
	 * Our Findamidwife_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts_and_styles' ), 20 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */


	/**
	 * Enqueue the frontend related scripts and styles for this plugin.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_frontend_scripts_and_styles() {
		wp_enqueue_style( 'findamidwi-frontend-styles', FINDAMIDWI_PLUGIN_URL . 'core/includes/assets/css/frontend-styles.css', array(), FINDAMIDWI_VERSION, 'all' );
		wp_enqueue_script( 'findamidwi-frontend-scripts', FINDAMIDWI_PLUGIN_URL . 'core/includes/assets/js/frontend-scripts.js', array( 'jquery' ), FINDAMIDWI_VERSION, true );

		add_shortcode('showMap', array($this, 'showSearchMap' ) );
	}



	public function showSearchMap() {
		FindMidwife::ShowMap();
	}
}
