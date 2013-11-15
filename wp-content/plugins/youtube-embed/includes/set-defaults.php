<?php
/**
* Set Default Options
*
* Set up default values for the various options
*
* @package	YouTube-Embed
*/

/**
* Function to set Shortcode option
*
* Looks up shortcode option - if it's not set, assign a default
*
* @since	2.0
*
* @return   string		Alternative Shortcode
*/

function vye_set_shortcode_option() {

	$shortcode = get_option( 'youtube_embed_shortcode' );

	// If setting doesn't exist, set defaults

	if ( $shortcode == '' ) {
		$shortcode[ 1 ] = 'youtube_video';
		$shortcode[ 2 ] = '';
		update_option( 'youtube_embed_shortcode', $shortcode );
	}

	return $shortcode;
}

/**
* Function to set URL option
*
* Looks up URL option - if it's not set, override the WP URL embedding
*
* @since	2.0
*
* @return   string		URL override
*/

function vye_set_url_option() {

	$url = get_option( 'youtube_embed_url' );

	// If setting doesn't exist, set defaults

	if ( $url == '' ) { update_option( 'youtube_embed_url', '' ); }

	return $url;
}

/**
* Function to set editor button shortcode
*
* Looks up editor button shortcode - sets it if not set-up
* Ensures matching cookie is in place
*
* @since	2.6
*
* @return   string		Editor shortcode
*/

function vye_set_editor_sc() {

	$editor_sc = get_option( 'youtube_embed_editor_sc' );

	// If setting doesn't exist, set defaults

	if ( $editor_sc == '' ) { update_option( 'youtube_embed_editor_sc', 'youtube' ); }

	// Return the shortcode

	return $editor_sc;
}


/**
* Function to set general YouTube options
*
* Looks up options. If none exist, or some are missing, set default values
*
* @since	2.0
*
* @return   strings		Options array
*/

function vye_set_general_defaults() {

	$options = get_option( 'youtube_embed_general' );
	$changed = false;
	$default_error = '<p>' . __( 'The video cannot be shown at the moment. Please try again later.', 'youtube-embed' ) . '</p>';

	// If the old options exist, import them and then delete them

	if ( !is_array( $options ) ) {
		if ( get_option( 'youtube_embed_editor' ) ) {
			$old_opts = get_option( 'youtube_embed_editor' );
			$options[ 'editor_button' ] = $old_opts[ 'youtube' ];
			delete_option( 'youtube_embed_editor' );
			$changed = true;
		} else {
			$options = array();
		}
	}

	// Set current version level. Because this can be used to detect version changes (and to what extent), this information may be useful in future upgrades

	if ( $options[ 'current_version' ] != youtube_embed_version ) {
		$options[ 'current_version' ] = youtube_embed_version;
		$changed = true;
	}

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'editor_button', $options ) ) { $options[ 'editor_button' ] = 1; $changed = true; }
	if ( !array_key_exists( 'admin_bar', $options ) ) { $options[ 'admin_bar' ] = 1; $changed = true; }
	if ( !array_key_exists( 'profile_no', $options ) ) { $options[ 'profile_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'list_no', $options ) ) { $options[ 'list_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'info_cache', $options ) ) { $options[ 'info_cache' ] = 1; $changed = true; }
	if ( !array_key_exists( 'embed_cache', $options ) ) { $options[ 'embed_cache' ] = 24; $changed = true; }
	if ( !array_key_exists( 'transcript_cache', $options ) ) { $options[ 'transcript_cache' ] = 24; $changed = true; }
	if ( !array_key_exists( 'alt_profile', $options ) ) { $options[ 'alt_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'alt_profile2', $options ) ) { $options[ 'alt_profile2' ] = 0; $changed = true; }
	if ( !array_key_exists( 'bracket', $options ) ) { $options[ 'bracket' ] = ''; $changed = true; }
	if ( !array_key_exists( 'alt', $options ) ) { $options[ 'alt' ] = 0; $changed = true; }
	if ( !array_key_exists( 'other_profile', $options ) ) { $options[ 'other_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'comments', $options ) ) { $options[ 'comments' ] = ''; $changed = true; }
	if ( !array_key_exists( 'comments_profile', $options ) ) { $options[ 'comments_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'metadata', $options ) ) { $options[ 'metadata' ] = 1; $changed = true; }
	if ( !array_key_exists( 'feed', $options ) ) { $options[ 'feed' ] = 'b'; $changed = true; }
	if ( !array_key_exists( 'api', $options ) ) { $options[ 'api' ] = 1; $changed = true; }
	if ( !array_key_exists( 'error_message', $options ) ) { $options[ 'error_message' ] = $default_error; $changed = true; }
	if ( !array_key_exists( 'thumbnail', $options ) ) { $options[ 'thumbnail' ] = 2; $changed = true; }
	if ( !array_key_exists( 'privacy', $options ) ) { $options[ 'privacy' ] = 0; $changed = true; }
	if ( !array_key_exists( 'frameborder', $options ) ) { $options[ 'frameborder' ] = 1; $changed = true; }
	if ( !array_key_exists( 'widgets', $options ) ) { $options[ 'widgets' ] = 0; $changed = true; }
	if ( !array_key_exists( 'menu_access', $options ) ) { $options[ 'menu_access' ] = 'list_users'; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_general', $options ); }
	return $options;
}

/**
* Function to set YouTube profile options
*
* Looks up profile options, based on passed profile numer.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$profile	Profile number
* @return   string				Options array
*/

function vye_set_profile_defaults( $profile ) {

	if ( $profile == 0 ) {
		$profname = 'Default';
	} else {
		$profname = 'Profile ' . $profile;
	}
	$options = get_option( 'youtube_embed_profile' . $profile );

	$changed = false;
	$new_user = false;

	// Work out default dimensions

	$width = 0;
	if ( isset( $content_width ) ) { $width = $content_width; }
	if ( ( $width == 0 ) or ( $width == '' ) ) { $width = 560; }
	$height = 25 + round( ( $width / 16 ) * 9, 0 );

	// If the old options exist, import them and then delete them

	if ( !is_array( $options ) ) {
		if ( ( $profile == 0 ) && ( get_option( 'youtube_embed' ) ) ) {
			$old_opts = get_option( 'youtube_embed' );
			$options = $old_opts;
			delete_option( 'youtube_embed' );
			$changed = true;
		} else {
			$options = array();
		}
	}

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'name', $options ) ) { $options[ 'name' ] = $profname; $changed = true; }

	if ( !array_key_exists( 'width', $options ) ) {
		$options[ 'width' ] = $width;
		$options[ 'height' ] = $height;
		$changed = true;
	}
	if ( !array_key_exists( 'height', $options ) ) { $options[ 'height' ] = 340; $changed = true; }
	if ( !array_key_exists( 'fullscreen', $options ) ) { $options[ 'fullscreen' ] = ''; $changed = true; }
	if ( !array_key_exists( 'template', $options ) ) { $options[ 'template' ] = '%video%'; $changed = true; }
	if ( !array_key_exists( 'autoplay', $options ) ) { $options[ 'autoplay' ] = ''; $changed = true; }
	if ( !array_key_exists( 'start', $options ) ) { $options[ 'start' ] = 0; $changed = true; }
	if ( !array_key_exists( 'loop', $options ) ) { $options[ 'loop' ] = ''; $changed = true; }
	if ( !array_key_exists( 'cc', $options ) ) { $options[ 'cc' ] = ''; $changed = true; }
	if ( !array_key_exists( 'annotation', $options ) ) { $options[ 'annotation' ] = 1; $changed = true; }
	if ( !array_key_exists( 'related', $options ) ) { $options[ 'related' ] = ''; $changed = true; }
	if ( !array_key_exists( 'info', $options ) ) { $options[ 'info' ] = 1; $changed = true; }
	if ( !array_key_exists( 'link', $options ) ) { $options[ 'link' ] = 1; $changed = true; }
	if ( !array_key_exists( 'react', $options ) ) { $options[ 'react' ] = 1; $changed = true; }
	if ( !array_key_exists( 'stop', $options ) ) { $options[ 'stop' ] = 0; $changed = true; }
	if ( !array_key_exists( 'sweetspot', $options ) ) { $options[ 'sweetspot' ] = 1; $changed = true; }
	if ( !array_key_exists( 'type', $options ) ) { $options[ 'type' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'disablekb', $options ) ) { $options[ 'disablekb' ] = ''; $changed = true; }
	if ( !array_key_exists( 'autohide', $options ) ) { $options[ 'autohide' ] = 2; $changed = true; }
	if ( !array_key_exists( 'controls', $options ) ) { $options[ 'controls' ] = 1; $changed = true; }
	if ( !array_key_exists( 'playlist', $options ) ) { $options[ 'playlist' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'fallback', $options ) ) { $options[ 'fallback' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'wmode', $options ) ) { $options[ 'wmode' ] = 'window'; $changed = true; }
	if ( !array_key_exists( 'audio', $options ) ) { $options[ 'audio' ] = ''; $changed = true; }
	if ( !array_key_exists( 'hd', $options ) ) { $options[ 'hd' ] = 1; $changed = true; }
	if ( !array_key_exists( 'style', $options ) ) { $options[ 'style' ] = ''; $changed = true; }
	if ( !array_key_exists( 'color', $options ) ) { $options[ 'color' ] = 'red'; $changed = true; }
	if ( !array_key_exists( 'theme', $options ) ) { $options[ 'theme' ] = 'dark'; $changed = true; }
	if ( !array_key_exists( 'https', $options ) ) { $options[ 'https' ] = 0; $changed = true; }
	if ( !array_key_exists( 'modest', $options ) ) { $options[ 'modest' ] = 1; $changed = true; }
	if ( !array_key_exists( 'dynamic', $options ) ) { $options[ 'dynamic' ] = ''; $changed = true; }
	if ( !array_key_exists( 'fixed', $options ) ) { $options[ 'fixed' ] = ''; $changed = true; }
	if ( !array_key_exists( 'download_style', $options ) ) { $options[ 'download_style' ] = ''; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_profile' . $profile, $options ); }

	// Remove added slashes from template XHTML

	$options[ 'template' ] = stripslashes( $options[ 'template' ] );

	return $options;
}

/**
* Function to set default list options
*
* Looks up list options, based on passed list number.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$list		List number
* @return   string				Options array
*/

function vye_set_list_defaults( $list ) {
	$options = get_option( 'youtube_embed_list' . $list );
	$changed = false;

	// If array doesn't exist create an empty one

	if ( !is_array( $options ) ) { $options = array(); }

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'name',$options ) ) { $options[ 'name' ] = 'List ' . $list; $changed = true; }
	if ( !array_key_exists( 'list',$options ) ) { $options[ 'list' ] = ''; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_list' . $list, $options ); }
	return $options;
}
?>