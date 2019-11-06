<?php

namespace SumaPress\SPV\Core;

/**
 * The core plugin class
 *
 * This is used to define admin-specific hooks, and public-facing site hooks
 */
class Core {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Loader    $loader    Maintains and registers all hooks for the plugin
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		/**
		 * Get loader using its singleton
		 */
		$this->loader = Loader::get_instance();

		$this->define_virtual_page();

		/**
		 * Only load if Gutenberg is available.
		*/
		if ( function_exists( 'register_block_type' ) ) {
			$this->define_main_hooks();
			$this->define_dynamic_hooks();
		}
	}

	/**
	 * Define virtual page as video src with pseudo video stream
	 */
	private function define_virtual_page() {

		$virtual_page = new \SumaPress\SPV\Includes\Virtual_Page();

		$this->loader->add_filter( 'query_vars', $virtual_page, 'add_custom_query_vars' );
		$this->loader->add_filter( 'generate_rewrite_rules', $virtual_page, 'create_custom_rewrite_rules' );

		$this->loader->add_action( 'template_redirect', $virtual_page, 'load_virtual_template_to_stream_video' );
	}

	/**
	 * Define main filter and actions hooks of the plugin
	 */
	private function define_main_hooks() {

		$plugin_gutenberg = new \SumaPress\SPV\Gutenberg\Gutenberg();

		$this->loader->add_filter( 'upload_dir', $plugin_gutenberg, 'change_media_upload_folder_on_private_files' );
		$this->loader->add_filter( 'wp_prepare_attachment_for_js', $plugin_gutenberg, 'add_private_label_on_gallery' );

		$this->loader->add_filter( 'block_categories', $plugin_gutenberg, 'add_custom_blocks_categories', 10, 2 );

		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_gutenberg, 'enqueue_all_blocks_assets_editor' );
		$this->loader->add_action( 'enqueue_block_assets', $plugin_gutenberg, 'enqueue_all_blocks_assets_frontend' );
	}

	/**
	 * Define actions hooks about dynamic video block
	 */
	private function define_dynamic_hooks() {

		$plugin_gutenberg_dynamic = new \SumaPress\SPV\Gutenberg\Render_Dynamic();

		$this->loader->add_action( 'wp_ajax_load_user_video', $plugin_gutenberg_dynamic, 'refresh_by_ajax_temp_security_user' );
		$this->loader->add_action( 'init', $plugin_gutenberg_dynamic, 'register_video_dynamic_block' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress
	 *
	 * @since 0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin
	 *
	 * @since  1.0.0
	 * @return Loader    Orchestrates the hooks of the plugin
	 */
	public function get_loader() {
		return $this->loader;
	}
}
