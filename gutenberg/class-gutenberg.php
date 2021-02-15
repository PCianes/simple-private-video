<?php

namespace SumaPress\SPV\Gutenberg;

class Gutenberg {

	public function __construct() {

	}

	/**
	 * Change media uploader folder only in case of private files
	 */
	public function change_media_upload_folder_on_private_files( $data ) {

		include_once( ABSPATH . 'wp-includes/pluggable.php' );

		if ( ! current_user_can( 'upload_files' ) ) {
			return $data;
		}

		$url            = wp_get_referer();
		$private_folder = 'spv-private';

		if ( strpos( $url, $private_folder ) !== false ) {

			$data['path']   = $data['basedir'] . '/' . $private_folder;
			$data['url']    = $data['baseurl'] . '/' . $private_folder;
			$data['subdir'] = $private_folder;
		}

		return $data;
	}

	/**
	 * If the media is into private folder change response to show
	 */
	public function add_private_label_on_gallery( $response ) {

		if ( strpos( $response['url'], 'spv-private' ) !== false ) {

			$response['filename'] = __( 'Private: ', 'simple-private-video' ) . $response['filename'];
		}

		return $response;
	}

	/**
	 * Add new custom categories for blocks
	 */
	public function add_custom_blocks_categories( $categories, $post ) {

		$custom_category = [
			'slug'  => 'sumapress',
			'title' => esc_html__( 'SumaPress', 'simple-private-video' ),
		];
		if ( false === array_search( $custom_category['slug'], array_column( $categories, 'slug' ) ) ) {
			return array_merge( $categories, [ $custom_category ] );
		}
		return $categories;

	}

	/**
	 * Enqueue all Gutenberg blocks assets for only backend editor
	 */
	public function enqueue_all_blocks_assets_editor() {

		$plugin_name = 'simple-private-video';

		wp_enqueue_script(
			$plugin_name . '-gutenberg-editor',
			plugin_dir_url( __FILE__ ) . 'dist/blocks.build.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'dist/blocks.build.js' )
		);
		$plugins_options = [
			'pluginName' => $plugin_name,
		];
		wp_localize_script( $plugin_name . '-gutenberg-editor', '$plugin_options', $plugins_options );

		wp_enqueue_style(
			$plugin_name . '-gutenberg-editor',
			plugin_dir_url( __FILE__ ) . 'dist/blocks.editor.build.css',
			[ 'wp-edit-blocks' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'dist/blocks.editor.build.css' )
		);
	}

	/**
	 * Enqueue all Gutenberg blocks assets for only frontend
	 */
	public function enqueue_all_blocks_assets_frontend() {

		if ( is_admin() ) {
			return;
		}

		wp_register_style(
			'simple-private-video-gutenberg',
			plugin_dir_url( __FILE__ ) . 'dist/blocks.style.build.css',
			[ 'wp-editor' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'dist/blocks.style.build.css' )
		);

		$this->register_video_assets( 'spv-video-js' );
		$this->register_custom_video_block_js( 'spv-video-js' );
	}

	/**
	 * Register video-js assets
	 */
	private function register_video_assets( $assets_video_key ) {

		wp_register_style( $assets_video_key, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/video-js.min.css', [], '7.11.4', 'all' );

		wp_register_script( $assets_video_key, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/video.min.js', [ 'jquery' ], '7.11.4', true );
	}

	/**
	 * Register custom js to work with media player
	 */
	private function register_custom_video_block_js( $assets_video_key ) {

		$plugin_name = 'simple-private-video';

		wp_register_script(
			$plugin_name,
			plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/web.js',
			[ 'jquery', $assets_video_key ],
			filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/web.js' ),
			true
		);

		$video_data = [
			'type'          => 'video/mp4',
			'src'           => sprintf( site_url( 'video-src/%s/' ), wp_create_nonce( 'spv-user-token' ) ),
			'url'           => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'spv-user-nonce' ),
			'playbackRates' => [ 0.75, 1, 1.25, 1.5, 1.75, 2, 2.5 ],
		];
		wp_localize_script( $plugin_name, '$videoData', $video_data );
	}
}
