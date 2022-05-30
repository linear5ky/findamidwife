<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Findamidwife' ) ) :

	/**
	 * Main Findamidwife Class.
	 *
	 * @package		FINDAMIDWI
	 * @subpackage	Classes/Findamidwife
	 * @since		1.0.0
	 * @author		Marcus Powell
	 */
	final class Findamidwife {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Findamidwife
		 */
		private static $instance;

		/**
		 * FINDAMIDWI helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Findamidwife_Helpers
		 */
		public $helpers;

		/**
		 * FINDAMIDWI settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Findamidwife_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'findamidwife' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'findamidwife' ), '1.0.0' );
		}

		/**
		 * Main Findamidwife Instance.
		 *
		 * Insures that only one instance of Findamidwife exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Findamidwife	The one true Findamidwife
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Findamidwife ) ) {
				self::$instance					= new Findamidwife;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Findamidwife_Helpers();
				self::$instance->settings		= new Findamidwife_Settings();

				//Fire the plugin logic
				new Findamidwife_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'FINDAMIDWI/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once FINDAMIDWI_PLUGIN_DIR . 'core/includes/classes/class-findamidwife-helpers.php';
			require_once FINDAMIDWI_PLUGIN_DIR . 'core/includes/classes/class-findamidwife-settings.php';

			require_once FINDAMIDWI_PLUGIN_DIR . 'core/includes/classes/class-findamidwife-run.php';
			
			require_once FINDAMIDWI_PLUGIN_DIR . 'core/includes/lib/FindMidwife.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'findamidwife', FALSE, dirname( plugin_basename( FINDAMIDWI_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.