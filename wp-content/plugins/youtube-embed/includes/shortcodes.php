<?php
/**
* Shortcodes
*
* Define the various shortcodes
*
* @package	YouTube-Embed
* @since	2.0
*/

/**
* Default Video shortcode
*
* Main [youtube] shortcode to display video
*
* @since	2.0
*
* @uses		vye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function vye_video_shortcode_default( $paras = '', $content = '' ) {
	return do_shortcode( vye_video_shortcode( $paras, $content ) );
}

add_shortcode( 'youtube', 'vye_video_shortcode_default' );

/**
* Alternative Video shortcode 1
*
* 1st alternative shortcode to display video
*
* @since	2.0
*
* @uses		vye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function vye_video_shortcode_alt1( $paras = '', $content = '' ) {
	return do_shortcode( vye_video_shortcode( $paras, $content, '', 1 ) );
}
$shortcode = vye_set_shortcode_option();
if ( $shortcode[ 1 ] != '' ) { add_shortcode( $shortcode[ 1 ], 'vye_video_shortcode_alt1' ); }

/**
* Alternative Video shortcode 2
*
* 2nd alternative shortcode to display video
*
* @since	2.0
*
* @uses		vye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function vye_video_shortcode_alt2( $paras = '', $content = '' ) {
	return do_shortcode( vye_video_shortcode( $paras, $content, '', 2 ) );
}
if ( $shortcode[ 2 ] != '' ) { add_shortcode( $shortcode[ 2 ], 'vye_video_shortcode_alt2' ); }

/**
* Video shortcode
*
* Use shortcode parameters to embed a YouTube video or playlist
*
* @since	2.0
*
* @uses		vye_get_embed_type			Get the embed type
* @uses		vye_set_autohide			Get the autohide parameter
* @uses     vye_set_general_defaults    Set default options
* @uses		vye_generate_youtube_code	Generate the embed code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @param	string		$alt_shortcode	The number of the alternative shortcode used
* @return   string						YouTube embed code
*/

function vye_video_shortcode( $paras = '', $content = '', $callback = '', $alt_shortcode = '' ) {

	extract( shortcode_atts( array( 'type' => '', 'width' => '', 'height' => '', 'fullscreen' => '', 'related' => '', 'autoplay' => '', 'loop' => '', 'start' => '', 'info' => '', 'annotation' => '', 'cc' => '', 'style' => '', 'link' => '', 'react' => '', 'stop' => '', 'sweetspot' => '', 'disablekb' => '', 'ratio' => '', 'autohide' => '', 'controls' => '', 'profile' => '', 'embedplus' => '', 'audio' => '', 'id' => '', 'url' => '', 'rel' => '', 'fs' => '', 	'cc_load_policy' => '', 'iv_load_policy' => '', 'showinfo' => '', 'youtubeurl' => '', 'template' => '', 'list' => '', 'hd' => '', 'color' => '', 'theme' => '', 'ssl' => '', 'height' => '', 'width' => '', 'dynamic' => '', 'h' => '', 'w' => '', 'search' => '', 'user' => '', 'vq' => '' ), $paras ) );

	// If no profile specified and an alternative shortcode used, get that shortcodes default profile

	if ( ( $profile == '' ) && ( $alt_shortcode != '' ) ) {

		// Profile is now blank or 2

		if ( $alt_shortcode == '1' ) { $alt_shortcode = ''; }

		// Get general options

		$options = vye_set_general_defaults();
		$profile = $options[ 'alt_profile' . $alt_shortcode ];
	}

	// If an alternative field is set, use it

	if ( ( $id != '' ) && ( $content == '' ) ) { $content = $id; }
	if ( ( $url != '' ) && ( $content == '' ) ) { $content = $url; }
	if ( ( $youtubeurl != '' ) && ( $content == '' ) ) { $content = $youtubeurl; }

	if ( ( $h != '' ) && ( $height == '' ) ) { $height = $h; }
	if ( ( $w != '' ) && ( $width == '' ) ) { $width = $w; }

	if ( ( $rel != '' ) && ( $related == '' ) ) { $related = $rel;}
	if ( ( $fs != '' ) && ( $fullscreen == '' ) ) { $fullscreen = $fs;}
	if ( ( $cc_load_policy != '' ) && ( $cc == '' ) ) { $cc = $cc_load_policy;}
	if ( ( $iv_load_policy != '' ) && ( $annotation == '' ) ) { $annotation = $iv_load_policy;}
	if ( ( $showinfo != '' ) && ( $info == '' ) ) { $info = $showinfo;}

	// If ID was not passed in the content and the first parameter is set, assume that to be the ID

	if ( ( $content == '' ) && ( $paras[ 0 ] != '' ) ) {
		$content = $paras[ 0 ];
		if  ( (substr( $content, 0, 1 ) == ":" ) or ( substr( $content, 0, 1 ) == "=" ) ) { $content = substr( $content, 1 ); }
		if ( $paras[ 1 ] != '' ) { $width = $paras[ 1 ]; }
		if ( $paras[ 2 ] != '' ) { $height = $paras[ 2 ]; }
	}

	// Get Embed type

	$type = vye_get_embed_type( $type, $embedplus );

	// Set up Autohide parameter

	$autohide = vye_set_autohide( $autohide );

	// Create YouTube code

	$youtube_code = vye_generate_youtube_code( $content, $type, $width, $height, vye_convert( $fullscreen ), vye_convert( $related ), vye_convert( $autoplay ), vye_convert( $loop ), $start, vye_convert( $info ), vye_convert_3( $annotation ), vye_convert( $cc ), $style, vye_convert( $link ), vye_convert( $react ), $stop, vye_convert( $sweetspot ), vye_convert( $disablekb ), $ratio, $autohide, $controls, $profile, $list, vye_convert( $audio ), $template, vye_convert( $hd ), $color, $theme, vye_convert( $ssl ), vye_convert( $dynamic ), vye_convert( $search ), vye_convert( $user ), $vq );

	return do_shortcode( $youtube_code );
}

/**
* Return a thumbnail URL
*
* Shortcode to return the URL for a thumbnail
*
* @since	2.0
*
* @uses		vye_generate_thumbnail_code	Generate the thumbnail code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube thumbnail code
*/

function vye_thumbnail_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'style' => '', 'class' => '', 'rel' => '', 'target' => '', 'width' => '', 'height' => '', 'alt' => '', 'version' => '', 'nolink' => '' ), $paras ) );
	return do_shortcode( vye_generate_thumbnail_code( $content, $style, $class, $rel, $target, $width, $height, $alt, $version, $nolink ) );
}

add_shortcode( 'youtube_thumb', 'vye_thumbnail_sc' );

/**
* Short URL shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		vye_generate_shorturl_code   Generate the code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube short URL code
*/

function vye_shorturl_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'id' => '' ), $paras ) );
	return do_shortcode( vye_generate_shorturl_code( $id ) );
}

add_shortcode( 'youtube_url', 'vye_shorturl_sc' );

/**
* Download shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		vye_generate_download_code	Generate the download code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube download link
*/

function vye_video_download( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'id' => '' ), $paras ) );

	// Get the download code

	$link = vye_generate_download_code( $id );

	// Now return the HTML

	return do_shortcode( $link );
}

add_shortcode( 'download_video', 'vye_video_download' );

/**
* Transcript Shortcode
*
* Shortcode to return YouTube transcripts
*
* @since	2.0
*
* @uses		vye_generate_transcript		Generate the transcript
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						Transcript XHTML
*/

function vye_transcript_sc( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'language' => '' ), $paras ) );

	return do_shortcode( vye_generate_transcript( $content, $language ) );
}

add_shortcode( 'transcript', 'vye_transcript_sc' );

/**
* Video Name Shortcode
*
* Shortcode to return the name of a YouTube video
*
* @since	2.0
*
* @uses		vye_extract_id				Extract the video ID
* @uses		vye_validate_id				Get the name and video type
* @uses		vye_error					Return an error
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						Video name
*/

function vye_video_name_shortcode( $paras = '', $content = '' ) {

	// Extract the ID if a full URL has been specified

	$id = vye_extract_id( $content );

	// Check what type of video it is and whether it's valid

	$return = vye_validate_id( $id, true );
	if ( !$return[ 'type' ] ) { return vye_error( sprintf( __( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) ); }
	if ( strlen( $return[ 'type' ] ) != 1 ) { return vye_error( $return[ 'type' ] ); }

	// Return the video title

	return do_shortcode( $return['title'] );
}

add_shortcode( 'youtube_name', 'vye_video_name_shortcode' );
?>