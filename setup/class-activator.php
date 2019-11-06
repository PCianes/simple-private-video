<?php

namespace SumaPress\SPV\Setup;

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation
 */
class Activator {

	public static function activate() {

		$activator = new Activator();
		$activator->add_private_folder_with_htaccess( 'spv-private' );

		/**
		 * Reset rewrite rules to avoid go to permalinks page
		 * through deleting the database options to force WP to do it
		 * because of on activation not work well flush_rewrite_rules()
		 */
		delete_option( 'rewrite_rules' );
	}

	private function add_private_folder_with_htaccess( $folder_name ) {

		WP_Filesystem();
		global $wp_filesystem;

		$private_folder = $this->make_new_private_folder_on_wp_upload_dir( $wp_filesystem, $folder_name );
		$this->add_htaccess_on_custom_private_folder( $wp_filesystem, $private_folder );

		if ( ! empty( $wp_filesystem->errors->errors ) ) {
			wp_die( 'Error when creating a new private folder' );
		}
	}

	private function make_new_private_folder_on_wp_upload_dir( $wp_filesystem, $folder_name ) {

		$wp_upload_dir  = wp_upload_dir();
		$private_folder = trailingslashit( $wp_upload_dir['basedir'] ) . $folder_name;
		$wp_filesystem->mkdir( $private_folder );

		return $private_folder;
	}

	private function add_htaccess_on_custom_private_folder( $wp_filesystem, $private_folder ) {

		$file = trailingslashit( $private_folder ) . '.htaccess';
		$wp_filesystem->put_contents( $file, $this->return_htaccess_file_content(), FS_CHMOD_FILE );
	}

	private function return_htaccess_file_content() {

		return <<<END
# Deny access to everything by default
Order Deny,Allow
deny from all

# Deny access to sub directory
<Files subdirectory/*>
	deny from all
</Files>

#In case of fail because of apache configuration
Redirect 404.html
END;
	}
}
