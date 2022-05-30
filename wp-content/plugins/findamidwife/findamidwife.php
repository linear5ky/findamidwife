<?php
/**
 * FindaMidWife
 *
 * @package       FINDAMIDWI
 * @author        Marcus Powell
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   FindaMidWife
 * Plugin URI:    https://imuk.org.uk/
 * Description:   This is some demo short description...
 * Version:       1.0.0
 * Author:        Marcus Powell
 * Author URI:    www.linearsky.com
 * Text Domain:   findamidwife
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'FINDAMIDWI_NAME',			'FindaMidWife' );

// Plugin version
define( 'FINDAMIDWI_VERSION',		'1.0.0' );

// Plugin Root File
define( 'FINDAMIDWI_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'FINDAMIDWI_PLUGIN_BASE',	plugin_basename( FINDAMIDWI_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'FINDAMIDWI_PLUGIN_DIR',	plugin_dir_path( FINDAMIDWI_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'FINDAMIDWI_PLUGIN_URL',	plugin_dir_url( FINDAMIDWI_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once FINDAMIDWI_PLUGIN_DIR . 'core/class-findamidwife.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Marcus Powell
 * @since   1.0.0
 * @return  object|Findamidwife
 */
function FINDAMIDWI() {
	return Findamidwife::instance();
}

FINDAMIDWI();
