
( function( $ ) {

	'use strict';

	$( function() {

		var options = {
			playbackRates: $videoData.playbackRates,
			controlBar: { volumePanel: { inline: false } }
		};
		var videoIds = [];

		$('video')
		.each( function(){

			var videoID = this.id.replace('video-', '');

			if( 'undefined' != videoID && this.className.indexOf('vjs-tech') > -1 ) { // was --> video-js

				videoIds.push( videoID );

				videojs( this.id, options, function onPlayerReady() {

					videojs.log('Your player is ready!');
					var currentTime = this.currentTime();

					loadVideo();
					loadSRC( this, videoID );

					this.on( 'timeupdate', function(){
						if( this.scrubbing() && this.bufferedPercent() < 1 ){
							loadVideo();
						}
					});
					this.on( 'useractive', function(){
						if( this.bufferedPercent() < 1 ){
							loadVideo();
						}
					});
					this.on( 'error', function(){
						currentTime = this.currentTime();
						loadVideo();
						loadSRC( videojs( 'video-' + videoID ), videoID );
						setTimeout( function( player, currentTime ) {
							player.play();
							player.currentTime( currentTime );
						}, 1000, this, currentTime );
					});

				})
				videojs.log.level('off');
			}

		})
		.on( 'contextmenu', function() {
			return false;
		});

		$('body').on('mouseleave', function(){
			setTimeout( function() {
				loadVideo('delete');
			}, 1000 );
		});

		function loadSRC( videoPlayer, videoID ){
			videoPlayer.src({
				type: $videoData.type,
				src: $videoData.src + videoID
			});
		}

		function loadVideo( doAction = 'update' ){
			$.ajax(
				{
					url: $videoData.url,
					type: 'POST',
					data: {
						action: 'load_user_video',
						nonce: $videoData.nonce,
						videoIds,
						doAction
					}
				}
			);
		}
	});

}( jQuery ) );
