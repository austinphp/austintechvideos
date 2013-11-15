<?php
/**
* Function Calls
*
* Various function calls that the user may call directly
*
* @package	YouTube-Embed
*/

/**
* Embed a YouTube video
*
* Write out XHTML to embed a YouTube video
*
* @since	2.0
*
* @uses		vye_get_parameters			Extract parameters from input
* @uses		vye_get_embed_type			Work out the correct embed type to use
* @uses		vye_set_autohide				Set correct autohide parameter
* @uses		vye_generate_youtube_code	Generate the YouTube code
*
* @param    string	$content	YouTube video ID
* @param 	string	$paras		List of parameters
* @param	string	$style		Optional CSS
*/

function youtube_video_embed( $content, $paras = '', $style = '' ) {
	$width = vye_get_parameters( $paras, 'width' );
	$height = vye_get_parameters( $paras, 'height' );
	$fullscreen = vye_get_parameters( $paras, 'fullscreen' );
	$related = vye_get_parameters( $paras, 'related' );
	$autoplay = vye_get_parameters( $paras, 'autoplay' );
	$loop = vye_get_parameters( $paras, 'loop' );
	$start = vye_get_parameters( $paras, 'start' );
	$info = vye_get_parameters( $paras, 'info' );
	$annotation = vye_get_parameters( $paras, 'annotation' );
	$cc = vye_get_parameters( $paras, 'cc' );
	$link = vye_get_parameters( $paras, 'link' );
	$react = vye_get_parameters( $paras, 'react' );
	$stop = vye_get_parameters( $paras, 'stop' );
	$sweetspot = vye_get_parameters( $paras, 'sweetspot' );
	$embedplus = vye_get_parameters( $paras, 'embedplus' );
	$disablekb = vye_get_parameters( $paras, 'disablekb' );
	$ratio = vye_get_parameters( $paras, 'ratio' );
	$autohide = vye_get_parameters( $paras, 'autohide' );
	$controls = vye_get_parameters( $paras, 'controls' );
	$type = vye_get_parameters( $paras, 'type' );
	$profile = vye_get_parameters( $paras, 'profile' );
	$list = vye_get_parameters( $paras, 'list' );
	$audio = vye_get_parameters( $paras, 'audio' );
	$template = vye_get_parameters( $paras, 'template' );
	$hd = vye_get_parameters( $paras, 'hd' );
	$color = vye_get_parameters( $paras, 'color' );
	$theme = vye_get_parameters( $paras, 'theme' );
	$https = vye_get_parameters( $paras, 'ssl' );
	$dynamic = vye_get_parameters( $paras, 'dynamic' );
	$search = vye_get_parameters( $paras, 'search' );
	$user = vye_get_parameters( $paras, 'user' );
	$vq = vye_get_parameters( $paras, 'vq' );

	// Get Embed type
	$type = vye_get_embed_type( $type, $embedplus );

	// Set up Autohide parameter
	$autohide = vye_set_autohide( $autohide );

	echo vye_generate_youtube_code( $content, $type, $width, $height, vye_convert( $fullscreen ), vye_convert( $related ), vye_convert( $autoplay ), vye_convert( $loop ), $start, vye_convert( $info ), vye_convert_3( $annotation ), vye_convert( $cc ), $style, vye_convert( $link ), vye_convert( $react ), $stop, vye_convert( $sweetspot ), vye_convert( $disablekb ), $ratio, $autohide, $controls, $profile, $list, vye_convert( $audio ), $template, vye_convert( $hd ), $color, $theme, vye_convert( $https ), vye_convert( $dynamic ), vye_convert( $search ), vye_convert( $user ), $vq );
	return;
}

/**
* Display a video thumbnail
*
* Display a thumbnail of a video
*
* @since	2.0
*
* @uses		vye_get_parameters			Extract parameters from a string
* @uses		vye_generate_thumbnail_code	Get the thumbnail code
*
* @param    string		$content		YouTube video ID
* @param    string		$paras			Parameters
* @param    string		$style			CSS information
* @param    string		$alt			Alt text
* @parm     string      $nolink         Whether to add a link or not
*/

function youtube_thumb_embed( $content, $paras = '', $style = '', $alt = '', $nolink = '' ) {

	$class = vye_get_parameters( $paras, 'class' );
	$rel = vye_get_parameters( $paras, 'rel' );
	$target = vye_get_parameters( $paras, 'target' );
	$width = vye_get_parameters( $paras, 'width' );
	$height = vye_get_parameters( $paras, 'height' );
	$version = vye_get_parameters( $paras, 'version' );

	echo vye_generate_thumbnail_code( $content, $style, $class, $rel, $target, $width, $height, $alt, $version, $nolink );

	return;
}

/**
* Return video short URL
*
* Return a short URL for the YouTube video
*
* @since	2.0
*
* @uses		vye_generate_shorturl_code	Display an error
*
* @param    string		$id				YouTube video ID
* @return	string						Download URL
*/

function youtube_short_url( $id ) {
	return vye_generate_shorturl_code( $id );
}

/**
* Get video download URL
*
* Return a URL for the video so that it can be downloaded
*
* @since	2.0
*
* @uses		vye_generate_download_code	Get the download URL
*
* @param    string		$id				YouTube video ID
* @return	string						Download URL
*/

function get_video_download( $id ) {
	return vye_generate_download_code( $id );
}

/**
* Get XML transcript
*
* Return XML formatted YouTube transcript
*
* @since	2.0
*
* @uses		vye_error					Output an error
* @uses		vye_extract_id				Extract a video ID
* @uses		vye_get_file					Get a file
* @uses		vye_validate_id				Check the video ID is valid
*
* @param    string		$id				YouTube video ID
* @param	string		$id				Language
* @return	string						Transcript file in XML format
*/

function get_youtube_transcript_xml ( $id, $language = 'en' ) {

	// Extract the ID if a full URL has been specified
	$id = vye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$embed_type = vye_validate_id( $id );
	if ( $embed_type != 'v' ) {
		if ( strlen( $embed_type ) > 1 ) {
			echo vye_error( $embed_type );
		} else {
			echo vye_error( sprintf( __( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) );
		}
		return;
	}

	// Get transcript file
	$filename = 'http://video.google.com/timedtext?lang=' . strtolower( $language ) . '&v=' . $id;
	$xml = vye_get_file( $filename );

	// Check success and return appropriate output
	if ( $xml[ 'rc' ] > 0 ) {
		echo vye_error( sprintf( __( 'Could not fetch the transcript file %s.', 'youtube-embed' ), $id ) );
		return;
	} else {
		return $xml;
	}
}

/**
* Get transcript
*
* Return XHTML formatted YouTube transcript
*
* @since	2.0
*
* @uses		vye_generate_generatE_transcript		Generate the transcript output
*
* @param    string		$id						YouTube video ID
* @param	string		$language				Language
* @return	string								Transcript file in XHTML format
*/

function get_youtube_transcript( $id, $language = '' ) {
	return vye_generate_transcript( $id, $language );
}

/**
* Get Video Name
*
* Function to return the name of a YouTube video
*
* @since	2.0
*
* @uses		vye_extract_id				Extract the video ID
* @uses		vye_validate_id				Get the name and video type
* @uses		vye_error					Return an error
*
* @param    string		$id				Video ID
* @return   string						Video name
*/

function get_youtube_name( $id ) {

	// Extract the ID if a full URL has been specified
	$id = vye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$return = vye_validate_id( $id, true );
	$embed_type = $return[ 'type' ];
	if ( strlen( $embed_type ) > 1 ) {
		echo vye_error( $embed_type );
	} else {
		echo vye_error( sprintf( __ ( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) );
	}

	// Return the video title
	return $return['title'];
}
?>