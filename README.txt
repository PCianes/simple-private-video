=== Simple Private Video ===
Contributors: sumapress, pablocianes
Donate link: https://sumapress.com/
Tags: video block, beta, video, video player, private video, vimeo, amazon s3, youtube, self hosting, mp4, membership, pip
Requires at least: 5.0
Tested up to: 5.2
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A video block and a simple and lean way to host your own videos and show them in private mode without external services dependencies.

== Description ==

A simple and fast way to host your own videos and show them in private mode without being able to download them and without external services dependencies like Vimeo, YouTube, etc.

**Attention! experimental beta phase plugin**

Great news for course creators who continually hacked its contents!

With the video block of this plugin you can upload your videos to a private folder on your own hosting and share them in your web only with your logged visitors.

The block has several configuration options:

* Setup your own main color to make the video player more corporate and according to the web design.
* Setup a preload image to show before the video is playing.
* Add custom content to show when video it is not allowed in case of not logged users.

In other hand the video player allow users to setup: video playback speed, audio volume, fullscreen and show whit *PiP(Picture-in-Picture)* ( the video is contained in a separate mini window that is always on top of other windows. This window stays visible even when the browser is not visible.)

There is no reference to external services such as YouTube or Vimeo since you use your own hosting and your own video player. With the advantages and disadvantages that this implies like you need a good hosting for your website if you don't want depends on external services.

Because of you use your own video player, the plugin does everything possible so that your videos cannot be downloaded even if they are your own customers who are watching the videos the ones who also try to do download them. If they try do it they will have a screen warning like:

`Hello username! this access is not allowed, so the administrator of MyDomain.com will be informed :(`

The plugin works sharing videos like a pseudo video stream to avoid users to see the video url to download it, because of the are not public url and the browser cant show the video without the php rendering and authorizations from the backend.

== Control who can watch your videos ==

By default the video is show only to logged user, but you can set more restriction with custom configuration by the filter: `spv-show-private-video`

Example with Restric Content Pro:

`if ( function_exists( 'rcp_user_has_active_membership' ) ) {

	add_filter( 'spv-show-private-video', function( $show_private_video, $attributes ){

		return rcp_user_has_active_membership();

	}, 10, 2 );

}`

Like all WordPress filters remember to always return something in this case `true` or `false`.

The first variable `$show_private_video` is `true` only in case the current user is logged on your website. The video it will only be seen in the case you return `true` and for that you can use the functions of others plugins for restrict content like the above example with RCP.

The second variable `$attributes` is an array with all data about the configuration of each video block with these keys: `color, blockAlignment, videoID, imageID, imageUrl, content`.

== This is a solution for self hosting ==

**IMPORTANT! all videos are save it in your hosting, so keep it in mind for disk space and bandwidth.
Maybe a shared hosting it is not a good idea to work in this way, especially if you will have many visualizations.
Please values if it is not better to use a VPS or even look for another type of solution instead of this plugin**

To protect the folder with the videos, the plugin adds in its activation an `.htaccess` file in `/ wp-content / uploads / spv-private /`
Be carefoul with that because of **it will only work with Apache and depending on the configuration of your hosting.**
Nobody must to know direct url of each video but if your hosting ignoring .htaccess file and show the videos please talk to the manager of your hosting to increase security and protect videos folder in the best way.

Please read carefully all **Frequently Asked Questions** at the bottom of this page before using this plugin in production, and think if it is your best option to share videos on your web. :)

== Installation ==

1. Upload `simple-private-video.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Search into post or page the block `Private Video - self hosting` into `SumaPress` category.

== Frequently Asked Questions ==

= What can I do with this plugin? =

Upload and show private videos with a block only to logged users. IMPORTANT! all videos are save it in your hosting, so keep it in mind for disk space and bandwidth. Maybe a shared hosting it is not a good idea to work in this way, especially if you will have many visualizations.

= I no longer need Vimeo or Amazon S3? =

It depends on your needs and your particular situation. Video sharing is not cheap and if you use your own server with this plugin to serve video you have to make your own accounts and see what is the best for you and study the costs of your own hosting around bandwidth spending with videos. Maybe you need a VPS and it is not good idea work on shared hosting which ends up blocking you.

= How can I setup this plugin? =

All configuration is within each block on WordPress editor.

= How can I do global setup? =

We can avoid add an options page to the plugin to only put there default block configuration, because of is already possible do that with native WordPress Block Editor.

Just add a new Private Video Block and set your favourite configuration with colors and alternative content and then “Add to Reusable Blocks” with a custom name. In this way you can set multiple default video blocks.

Whenever you want to add new Private Video Block just select your custom video block and then “Convert to Regular Block” to allow put inside the new video with all your previus default configuration already set.

= Is this plugin with self hosting video for everyone? =

Only use this plugin if you know well what kind of hosting you have and what are your expenses and limitations to use it as storage and video visualizations. Also only after comparing other options like Vimeo, Youtube, Amazon S3, etc and determining that this plugin is the best option for you.

= Is it really true that users will not be able to download the videos? =

If they insist they will get it as with any other solution, but it has been raised to be quite complicated especially for most people.

== Screenshots ==

1. Setup your videos with the video block on WordPress editor.
2. Video player with your colors and many options available to users.

== Changelog ==

= 0.2.1 =
* Fix fatal error with new version of Woo

= 0.2.0 =
* First beta publicly available version.

== Upgrade Notice ==

= 0.2.0 =
* First beta publicly available version.

== Feedback and support ==

I would be happy to receive your feedback to improve this plugin.
Please let me know through [support forums](https://wordpress.org/support/plugin/simple-private-video) if you like it and please be sure to [leave a review.](https://wordpress.org/support/plugin/simple-private-video/reviews/#new-post).

Form more information you can visit the page [SumaPress](https://sumapress.com/) or even visit [Github of Simple Private Video](https://github.com/SumaPress/simple-private-video) where you can find all the development code of this plugin.

I hope it is useful for you and look forward to reading your reviews! ;-) Thanks!
