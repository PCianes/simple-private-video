<figure class="wp-block-video <?php echo esc_attr( $data['class'] ); ?>">
	<video
		id="<?php echo esc_attr( $data['id'] ); ?>"
		class="video-js vjs-big-play-centered vjs-show-big-play-button-on-pause"
		controls
		controlsList="nodownload"
		preload="auto"
		poster="<?php echo esc_attr( $data['img'] ); ?>"
		data-setup="{}"
		>
	</video>
	<noscript>
		<p class="vjs-no-js">
			<?php esc_html_e( 'To view this video please enable JavaScript', 'simple-private-video' ); ?>
		</p>
	</noscript>
	<style>
		#<?php echo esc_attr( $data['id'] ); ?>.video-js .vjs-control-bar,
		#<?php echo esc_attr( $data['id'] ); ?>.video-js .vjs-big-play-button,
		#<?php echo esc_attr( $data['id'] ); ?>.video-js .vjs-modal-dialog {
			background-color: <?php echo esc_attr( $data['color'] ); ?>;
		}
	</style>
</figure>
