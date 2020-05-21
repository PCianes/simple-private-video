<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also core all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Private Video
 * Plugin URI:        https://sumapress.com/simple-private-video/
 * Description:       A video block and a simple and lean way to host your own videos and show them in private mode without external services dependencies
 * Version:           0.2.1
 * Author:            SumaPress
 * Author URI:        https://sumapress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-private-video
 * Domain Path:       /languages
 */

/*
This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this plugin. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

namespace SumaPress\SPV;

/**
* If this file is called directly, abort.
*/
if ( ! defined( 'ABSPATH' ) ) {
	die( "Oh, silly, there's nothing to see here." );
}

require_once plugin_dir_path( __FILE__ ) . 'core/autoload.php';

/**
 * The code that runs during plugin activation
 */
register_activation_hook( __FILE__ , function() {
    Setup\Activator::activate();
} );

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook( __FILE__ , function() {
	Setup\Deactivator::deactivate();
} );

/**
 * Load plugin text-domain to i18n
 */
add_action( 'plugins_loaded', function() {

	$plugin_info = get_file_data( __FILE__ , [ 'text-domain' => 'Text Domain' ] );

	load_plugin_textdomain( $plugin_info[ 'text-domain' ], false,  dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

} );

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle
 *
 * @since    1.0.0
 */
call_user_func( function(){

	$plugin = new Core\Core();

	/**
	 * Run the loader to execute all of the hooks with WordPress
	 */
	$plugin->run();

} );
