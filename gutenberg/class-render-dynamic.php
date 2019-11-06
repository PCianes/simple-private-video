<?php

namespace SumaPress\SPV\Gutenberg;

/**
 * The static callbacks from php to render by Gutenberg
 */
class Render_Dynamic {

	public function __construct() {

	}

	/**
	 * Ajax function from web.js to control and allow users to see the private video
	 */
	public function refresh_by_ajax_temp_security_user() {

		if ( ! defined( 'DOING_AJAX' ) && ! is_user_logged_in() ) {
			wp_redirect( home_url() );
			exit();
		}

		if ( ! check_ajax_referer( 'spv-user-nonce', 'nonce' ) ) {
			wp_die( 'Error - unable to verify nonce, please try again.' );
		}

		$current_user  = wp_get_current_user();
		$transient_key = 'spv-user-' . $current_user->ID;
		$do_action     = sanitize_text_field( $_POST['doAction'] );
		$new_transient = array_map(
			function ( $videoID ) {
				return (int) sanitize_text_field( $videoID );
			},
			$_POST['videoIds']
		);

		switch ( $do_action ) {

			case 'update':
				set_transient( $transient_key, $new_transient, 3 );
				break;

			case 'delete':
				delete_transient( $transient_key );
				break;

			default:
				// code...
				break;
		}

		wp_send_json_success( $do_action );
	}

	/**
	 * Allow to work in Gutenberg with dynamic blocks
	 */
	public function register_video_dynamic_block() {

		register_block_type(
			'simple-private-video/self-hosting',
			[
				'attributes'      => [
					'color'          => [
						'type'    => 'string',
						'default' => 'rgba(43,51,63,.7)',
					],
					'blockAlignment' => [
						'type' => 'string',
					],
					'videoID'        => [
						'type' => 'number',
					],
					'imageID'        => [
						'type' => 'number',
					],
					'imageUrl'       => [
						'type' => 'string',
					],
					'content'        => [
						'type' => 'boolean',
					],
				],
				'render_callback' => [ self::class, 'render_html_video_self_hosting' ],
			]
		);

	}

	/**
	 * Callback 'self-hosting' to render dynamic video block
	 */
	public static function render_html_video_self_hosting( $attributes, $content ) {

		if ( ! self::is_user_allowed_to_see_private_video( $attributes ) ) {
			if ( isset( $attributes['content'] ) && $attributes['content'] ) {
				return wp_kses_post( $content );
			}
			return;
		}

		self::enqueue_video_assets();

		$data = self::check_attributes_data( $attributes );

		if ( ! $data['id'] ) {
			return;
		}

		ob_start();
			include plugin_dir_path( __FILE__ ) . 'views/video_self_hosting.php';
			$template_to_return = ob_get_contents();
		ob_end_clean();

		return $template_to_return;
	}

	/**
	 * Check if current user can see private videos
	 */
	public static function is_user_allowed_to_see_private_video( $attributes ) {

		$show_private_video = is_user_logged_in();

		if ( ! $show_private_video ) {
			return false;
		}

		/**
		 * Set filter to allow by code add more restrictions to show private video
		 */
		$show_private_video = apply_filters( 'spv-show-private-video', $show_private_video, $attributes );

		if ( ! $show_private_video ) {
			return false;
		}

		return true;
	}

	/**
	 * Enqueue video assets only if video is on the page and is valid to show
	 */
	public static function enqueue_video_assets() {

		wp_enqueue_style( 'spv-video-js' );
		wp_enqueue_script( 'spv-video-js' );

		wp_enqueue_style( 'simple-private-video-gutenberg' );
		wp_enqueue_script( 'simple-private-video' );
	}

	/**
	 * Check and sanitize $attributes before send to view
	 */
	public static function check_attributes_data( $attributes ) {

		$block_alignment = isset( $attributes['blockAlignment'] ) ? sanitize_text_field( $attributes['blockAlignment'] ) : '';
		$video_id        = isset( $attributes['videoID'] ) ? (int) sanitize_text_field( $attributes['videoID'] ) : 0;

		return [
			'class' => ! empty( $block_alignment ) ? 'align' . $block_alignment : '',
			'id'    => $video_id > 0 ? 'video-' . $video_id : false,
			'img'   => isset( $attributes['imageUrl'] ) ? esc_url( $attributes['imageUrl'] ) : '',
			'color' => isset( $attributes['color'] ) ? sanitize_text_field( $attributes['color'] ) : 'rgba(43,51,63,.7)',
		];
	}
}
