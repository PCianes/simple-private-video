<?php

namespace SumaPress\SPV\Setup;

/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation
 */
class Deactivator {

	/**
	 * Short Description
	 *
	 * Long Description
	 *
	 * @since    0.2.0
	 */
	public static function deactivate() {

		delete_option( 'rewrite_rules' );
	}
}
