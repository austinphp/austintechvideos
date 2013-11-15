<?php
/**
* Generate Download Code
*
* Create code to allow a YouTube video to be downloaded
*
* @package	YouTube-Embed
* @since	2.0
*
* @uses		vye_extract_id				Extract an ID from a string
* @uses		vye_validate_id				Confirm the type of video
* @uses		vye_error					Display an error
* @uses		vye_get_file				Fetch a file
*
* @param    string	$id					YouTube video ID
* @return	string						Download HTML
*/

function vye_generate_download_code( $id ) {

	if ( $id == '' ) { return vye_error( __ ( 'No YouTube ID was found.', 'youtube-embed' ) ); }

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

	// See if a ShareASale affiliate ID has been specified - if so, get it!

	$options = vye_set_general_defaults();
	if ( $options[ 'shareasale_id' ] == '' ) {
		$affiliate = '';
	} else {
		$affiliate = $options[ 'shareasale_id' ];
	}

	// Get the link from Vixy

	$url = 'http://vixy.net/downloadbar?id=' . $id . '&sip=' . $_SERVER['SERVER_ADDR']. '&lang=' . str_replace( '_', '-', get_bloginfo( 'language' ) ) . '&affiliate_id=' . $affiliate;

	$file = vye_get_file( $url );

	// Now clean the code to ensure nothing nasty lurks within!

	$allowed_html = array (
							'a' => array(
								'href' => array(),
								'title' => array(),
								'class' => array(),
								'id' => array(),
								'style' => array()
							),
							'br' => array(),
							'p' => array(
								'class' => array(),
								'id' => array(),
								'style' => array()
							),
							'span' => array(
								'class' => array(),
								'id' => array(),
								'style' => array()
							),
							'div' => array(
								'class' => array(),
								'id' => array(),
								'style' => array()
							),
							'img' => array(
								'alt' => array(),
								'src' => array(),
								'width' => array(),
								'height' => array()
							) );

	$file = wp_kses( $file, $allowed_html );

	// Return the resulting code

	return $file[ 'file' ];
}
?>