<?php

namespace SumaPress\SPV\Includes;

class Virtual_Page {

	public function __construct() {

	}

	/**
	 * Add custom query vars
	 */
	public function add_custom_query_vars( $query_vars ) {

		$query_vars[] = 'spv-video';
		$query_vars[] = 'spv-token';

		return $query_vars;
	}

	/**
	 * Create custom rewrite rules
	 */
	public function create_custom_rewrite_rules( $wp_rewrite ) {

		$wp_rewrite->rules = array_merge(
			[ '^video-src/([^/]*)/(\d+)' => 'index.php?spv-token=$matches[1]&spv-video=$matches[2]' ],
			$wp_rewrite->rules
		);
	}

	/**
	 * Load virtual template to stream video by id
	 */
	public function load_virtual_template_to_stream_video() {

		$video_id = intval( get_query_var( 'spv-video' ) );
		$token    = sanitize_text_field( get_query_var( 'spv-token' ) );

		if ( $video_id && $token ) {

			if ( ! is_user_logged_in() ) {
				wp_die( 'Access denied! :(' );
			}

			$this->check_and_load_stream_video( wp_get_current_user(), $video_id, $token );
			die;
		}
	}

	/**
	 * Check and load stream video
	 */
	private function check_and_load_stream_video( $current_user, $video_id, $token ) {

		$security_token     = isset( $token ) ? wp_verify_nonce( $token, 'spv-user-token' ) : false;
		$temp_security_user = get_transient( 'spv-user-' . $current_user->ID );

		/**
		 * Start video stream with the correct video SRC only in case of pass security rules
		 */
		if ( $security_token && $temp_security_user && $video_id > 0 && in_array( $video_id, $temp_security_user ) ) {

			/**
			 * Get origin video file path on private folder
			 */
			$video_file = get_attached_file( $video_id );

			/**
			 * Start video stream to show the video
			 */
			$video_stream = new Video_Stream( $video_file );
			$video_stream->start();
			exit();

		} else {

			/**
			 * Alert user about the misconduct by accessing directly
			 */
			$message = sprintf(
				__( 'Hello %1$s! this access is not allowed, so the administrator of %2$s will be informed :(', 'simple-private-video' ),
				strtoupper( $current_user->display_name ),
				get_bloginfo( 'name' )
			);
			wp_die( $message );
		}
	}
}
