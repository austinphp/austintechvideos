<?php
/**
* Generate video short URL
*
* Create a short URL to a YouTube video
*
* @package	YouTube-Embed
* @since	2.0
*
* @uses		vye_extract_id				Extract an ID from a string
* @uses		vye_validate_id				Confirm the type of video
* @uses		vye_error					Display an error
*
* @param    string	$id					YouTube video ID
* @return	string	$youtube_code		Code
*/

function vye_generate_shorturl_code( $id ) {

	// Check that an ID has been specified
	if ( $id == '' ) {
		return vye_error( __( 'No video ID has been supplied', 'youtube-embed' ) );
	} else {

		// Extract the ID if a full URL has been specified
		$id = vye_extract_id( $id );

		// Check what type of video it is and whether it's valid
		$embed_type = vye_validate_id( $id );
		if ( $embed_type != 'v' ) {
			if ( strlen( $embed_type ) > 1 ) {
				return vye_error( $embed_type );
			} else {
				return vye_error( sprintf( __( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) );
			}
		}

		return 'http://youtu.be/' . $id;
	}
}
?>