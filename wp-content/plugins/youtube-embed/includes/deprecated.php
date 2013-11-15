<?php
/**
* Deprecated Code
*
* Various pieces of code, now deprecated, but kept here for backwards compatibility
*
* @package	YouTube-Embed
* @since	2.0
*/

// Shortcode for showing playlists - can now use the standard video shortcode
// In fact, this shortcode now simply directs to the video shortcode
add_shortcode( 'youtube_playlist', 'vye_video_shortcode' );

// Shortcode for downloading playlist - in fact, this never worked as option doesn't
// allow playlists. None-the-less, now diverts to standard download shortcode
// and will display an appropriate error
add_shortcode( 'download_playlist', 'vye_video_download' );

/**
* Embed a playlist
*
* Function to embed a playlist
*
* @deprecated	2.0		Use youtube_video_embed() instead.
* @since		2.0
*
* @uses		youtube_video_embed	Embed a video
*
* @param    string  $content    Video ID
* @param	string	$paras		Parameters
* @param	string	$style		CSS
*/

function youtube_playlist_embed( $content, $paras, $style = '' ) {
	youtube_video_embed( $content, $paras, $style );
	return;
}

/**
* Get playlist download link
*
* Return YouTube playlist download URL
* No longer found to work, so simply reports an error now
*
* @deprecated	2.0		Use youtube_short_url() instead.
* @since		2.0
*
* @uses		ye_error			Display an error
*
* @param    string  $id		    Video ID
*/

function get_playlist_download( $id = '' ) {
	echo vye_error( __( 'This function does not support playlists', 'youtube-embed' ) );
	return;
}
?>