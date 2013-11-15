=== Vimeo Short Code ===
Contributors: Matroschka, Gabriele Maidecchi
Tags: video, embed, movie, shortcode, plugin, clip, vimeo, flv, quicktag, html5
Requires at least: 2.5
Tested up to: 3.7-alpha
Stable tag: trunk

Allows the user to embed Vimeo movie clips by entering a shortcode ([vimeo]) into the post area.

== Description ==

Allows the user to embed Vimeo movie clips by entering a shortcode (`[vimeo]`) into the post area. Vimeo's options regarding the display of meta properties like by-line, title, or the video author's portrait are supported as short code attributes. We built this plugin as a solution for embedding videos on [our site](http://www.partnervermittlung-ukraine.net/info/lux-vimeo-wordpress-plugin). Both conventional Flash-based embedding and native HTML5 video are supported.

= Credits =

HTML5 embed code contributed by Gabriele Maidecchi. German translation by [@talkpress](http://talkpress.de/).

== Installation ==

1. Unzip `lux_vimeo.zip` and upload the contained files to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Usage ==
1. Enter the `[vimeo clip_id="XXXXXXX"]` short code into any post. `clip_id` is the number from the clip's URL (e.g. `vimeo.com/12345678`)
1. Optionally modify the clip's appearance by specifying width or height, like so: `[vimeo clip_id="XXXXXXX" width="400" height="225"]`
1. Toggle byline, portrait and title like so: `[vimeo clip_id="XXXXXXX" title="1" byline="0" portrait="1"]`
1. Toggle HTML5 vs. older object embedding method like so: `[vimeo clip_id="XXXXXXX" html5="0"]`
1. Using empty values for either the `width` or `height`attributes will cause Lux Vimeo to calculate the proper dimension based on a 16:9 aspect ration. Example: `[vimeo clip_id="12345678" height="300" width=""]` or `[vimeo clip_id="12345678" height="" width="640"]`

== Change log ==

= Version 1.2 =

1. Tested for WP 3.7-alpha compatibility

= Version 1.1 =

1. Added attributes: byline, title, portrait, html5 (props Gabriele Maidecchi), color
1. Fixed bug in dimension calculation.

= Version 1.0 =

Initial release.