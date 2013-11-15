<?php
/**
* Profiles Options Page
*
* Screen for specifying different profiles and settings the options for each
*
* @package	YouTube-Embed
* @since	2.0
*/
?>

<?php $demo_video = 'Y7ny1YdTShg'; ?>

<div class="wrap">

<div style="width: 1010px;">

<div class="icon32"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/admin_screen_icon.png" alt="" title="" height="32px" width="32px"/><br /></div>

<h2><?php _e( 'Vixy YouTube Embed Profiles', 'youtube-embed' ); ?></h2>

<?php

// Set current profile number

if ( isset( $_POST[ 'youtube_embed_profile_no' ] ) ) { $profile_no = $_POST[ 'youtube_embed_profile_no' ]; } else { $profile_no = 0; }
if ( $profile_no == '' ) { $profile_no = 0; }

// If options have been updated on screen, update the database

if ( ( !empty( $_POST[ 'Submit' ] ) ) && ( check_admin_referer( 'youtube-embed-profile' , 'youtube_embed_profile_nonce' ) ) ) {

	$options[ 'name' ] = $_POST[ 'youtube_embed_name' ];
	$options[ 'type' ] = $_POST[ 'youtube_embed_type' ];
	$options[ 'playlist' ] = $_POST[ 'youtube_embed_playlist' ];
	$options[ 'width' ] = $_POST[ 'youtube_embed_width' ];
	$options[ 'height' ] = $_POST[ 'youtube_embed_height' ];

	$options[ 'template' ] = htmlspecialchars_decode( $_POST[ 'youtube_embed_template' ] );
	if ( strpos( $options[ 'template' ], '%video%' ) === false ) { $options[ 'template' ] = '%video%'; }

	$options[ 'style' ] = $_POST[ 'youtube_embed_style' ];
	$options[ 'fullscreen' ] = $_POST[ 'youtube_embed_fullscreen' ];
	$options[ 'autoplay'] = $_POST[ 'youtube_embed_autoplay' ];
	$options[ 'loop'] = $_POST[ 'youtube_embed_loop' ];
	$options[ 'cc'] = $_POST[ 'youtube_embed_cc' ];
	$options[ 'annotation'] = $_POST[ 'youtube_embed_annotation' ];
	$options[ 'related'] = $_POST[ 'youtube_embed_related' ];
	$options[ 'info'] = $_POST[ 'youtube_embed_info' ];
	$options[ 'link'] = $_POST[ 'youtube_embed_link' ];
	$options[ 'react'] = $_POST[ 'youtube_embed_react' ];
	$options[ 'sweetspot'] = $_POST[ 'youtube_embed_sweetspot' ];
	$options[ 'disablekb'] = $_POST[ 'youtube_embed_disablekb' ];
	$options[ 'autohide'] = $_POST[ 'youtube_embed_autohide' ];
	$options[ 'controls'] = $_POST[ 'youtube_embed_controls' ];
	$options[ 'fallback'] = $_POST[ 'youtube_embed_fallback' ];
	$options[ 'wmode'] = $_POST[ 'youtube_embed_wmode' ];
	$options[ 'audio'] = $_POST[ 'youtube_embed_audio' ];
	$options[ 'hd'] = $_POST[ 'youtube_embed_hd' ];
	$options[ 'color' ] = $_POST[ 'youtube_embed_color' ];
	$options[ 'theme' ] = $_POST[ 'youtube_embed_theme' ];
	$options[ 'https' ] = $_POST[ 'youtube_embed_https' ];
	$options[ 'privacy' ] = $_POST[ 'youtube_embed_privacy' ];
	$options[ 'modest' ] = $_POST[ 'youtube_embed_modest' ];
	$options[ 'dynamic' ] = $_POST[ 'youtube_embed_dynamic' ];
	$options[ 'fixed' ] = $_POST[ 'youtube_embed_fixed' ];
	$options[ 'vixy_download' ] = $_POST[ 'youtube_embed_download' ];
	$options[ 'download_style' ] = $_POST[ 'youtube_embed_download_style' ];
	$options[ 'link_to_youtube' ] = $_POST[ 'youtube_embed_add_link' ];
	$options[ 'vq' ] = $_POST[ 'youtube_embed_vq' ];

	$default_size = $_POST[ 'youtube_embed_size' ];

	if ( $default_size !== '' ) {
		$options[ 'width' ] = ltrim( substr( $default_size, 0, 4 ), '0' );
		$options[ 'height'] = ltrim( substr( $default_size, -4, 4 ), '0' );
	}

	// Set width or height, if missing

	if ( ( $options[ 'width' ] == '' ) && ( $options[ 'height' ] == '' ) ) {
		if ( isset( $GLOBALS[ 'content_width' ] ) ) {
			$options[ 'width' ] = $GLOBALS[ 'content_width' ];
		} else {
			$options[ 'width' ] = 560;
		}
		$options[ 'height' ] = 27 + round( ( $options[ 'width' ] / 16 ) * 9, 0 );
	}
	if ( ( $options[ 'width' ] == '' ) && ( $options[ 'height' ] != '' ) ) {
			$options[ 'width' ] = round( ( $options[ 'height' ] / 9 ) * 16, 0 );
	}
	if ( ( $options[ 'width' ] != '' ) && ( $options[ 'height' ] == '' ) ) {
			$options[ 'height' ] = 27 + round( ( $options[ 'width' ] / 16 ) * 9, 0 );
	}

	update_option( 'youtube_embed_profile' . $profile_no, $options );
	echo '<div class="updated fade"><p><strong>' . __( $options[ 'name' ].' Profile Saved.' ) . "</strong></p></div>\n";
} else {
	$default_size = '';
}

// Video option button has been pressed

if ( !empty( $_POST[ 'Video' ] ) ) { $video_type = $_POST[ 'youtube_embed_video_type' ]; } else { $video_type = 'd'; }

// Fetch options into an array

$options = vye_set_profile_defaults( $profile_no );
$general = vye_set_general_defaults();
?>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=profile-options' ?>">

<span class="alignright">
<select name="youtube_embed_profile_no">
<?php vye_generate_profile_list( $profile_no, $general[ 'profile_no' ] ) ?>
</select>
<input type="submit" name="Profile" class="button-secondary" value="<?php _e( 'Change profile', 'youtube-embed' ); ?>"/>
</span><br/>

<?php
if ( $profile_no == '0' ) {
	_e( 'These are the options for the default profile.', 'youtube-embed' );
} else {
	sprintf( _e( 'These are the options for profile %s.', 'youtube-embed' ), $profile_no );
}
echo ' ' . __( 'Use the drop-down on the right hand side to swap between profiles.', 'youtube-embed' );
?>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Profile name', 'youtube-embed' ); ?></th><td>
<input type="text" size="20" name="youtube_embed_name" value="<?php echo $options[ 'name' ]; ?>"<?php if ( $profile_no == 0 ) { echo ' readonly="readonly"'; } ?>/>
<?php if ( $profile_no != 0 ) { echo '&nbsp;<span class="description">' . __( 'The name you wish to give this profile', 'youtube-embed'  ) . '</span>'; } ?>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e( 'Video Embed Type', 'youtube-embed' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use for videos.', 'youtube-embed'  ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="v"<?php if ( $options[ 'type' ] == "v" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'IFRAME', 'youtube-embed' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Uses AS3 Flash player, if Flash is available. Alternatively, uses HTML5 player. This is the current YouTube default.', 'youtube-embed'  ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="p"<?php if ( $options[ 'type' ] == "p" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'OBJECT', 'youtube-embed' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use the AS3 Flash player.', 'youtube-embed' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="c"<?php if ( $options[ 'type' ] == "c" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'Chromeless', 'youtube-embed' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use the <a href="http://vixy.net/youtube-embed/documentation.php#Chromeless_Player">Chromeless</a> version of the AS3 Flash Player.', 'youtube-embed' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="m"<?php if ( $options[ 'type' ] == "m" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'EmbedPlus', 'youtube-embed' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use <a href="http://vixy.net/youtube-embed/documentation.php#EmbedPlus">EmbedPlus</a>, if Flash is available.', 'youtube-embed' ); ?></span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Playlist Embed Type', 'youtube-embed' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use when showing playlists.', 'youtube-embed' ); ?></span><br/>
<input type="radio" name="youtube_embed_playlist" value="v"<?php if ( $options[ 'playlist' ] == "v" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'IFRAME', 'youtube-embed' ); ?><br/>
<input type="radio" name="youtube_embed_playlist" value="o"<?php if ( $options[ 'playlist' ] == "o" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'OBJECT', 'youtube-embed' ); ?><br/>
</td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Options For All Player Types', 'youtube-embed' ); ?></span>

<table class="form-table ytbox_grey">
<tr>
<th scope="row"><?php _e( 'Show Links to YouTube', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_add_link" value="1"<?php if ( $options[ 'link_to_youtube' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php echo __( 'Show a link to the original YouTube video (if not a playlist)', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Show Download Links', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_download" value="1"<?php if ( $options[ 'vixy_download' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php echo __( 'Show <a href="http://www.vixy.net">Vixy.net</a> links under a video, allowing user to download video or MP3', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Bar Style', 'youtube-embed' ); ?></th>
<td><input type="text" size="40" name="youtube_embed_download_style" value="<?php echo htmlspecialchars( $options[ 'download_style' ] ); ?>"/>&nbsp;<span class="description"><?php _e( 'CSS elements to apply to links under video', 'youtube-embed' ); ?></span></td>
</tr>

<?php if ( $general[ 'shareasale_id' ] == '' ) : ?>

<tr><td colspan="2"><?php _e( 'If a ShareASale affiliate ID is specified in the <a href="admin.php?page=general-options">Options screen</a> then an additional, sponsored link will be added under the video, which could earn you 30% revenue for any sales.', 'youtube-embed' );?></td></tr>

<?php endif; ?>

<?php if ( ( $options[ 'link_to_youtube' ] == '1' ) or ( $options[ 'vixy_download' ] == '1' ) ) : ?>

<tr><td colspan="2"><?php _e( 'Currently, the links will appear like this..', 'youtube-embed' ); ?><br/>
<?php echo vye_add_links( $options[ 'link_to_youtube' ], $options[ 'vixy_download' ], $options[ 'download_style' ], $demo_video, '' ); ?>
</td></tr>

<?php endif; ?>
</table><br/>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Template', 'youtube-embed' ); ?></th>
<td><input type="text" size="40" name="youtube_embed_template" value="<?php echo htmlspecialchars( $options[ 'template' ] ); ?>"/>&nbsp;<span class="description"><?php _e( 'Wrapper for video output. Must include <code>%video%</code> tag to show video position', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Style', 'youtube-embed' ); ?></th>
<td><input type="text" size="40" name="youtube_embed_style" value="<?php echo htmlspecialchars( $options[ 'style' ] ); ?>"/>&nbsp;<span class="description"><?php _e( 'CSS elements to apply to video', 'youtube-embed' ); ?></span></td>
</tr>
</table>

<table class="form-table ytbox_grey">
<tr>
<th scope="row"><?php _e( 'Video size', 'youtube-embed' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_width" value="<?php echo $options[ 'width' ]; ?>"/>&nbsp;x&nbsp;<input type="text" size="3" maxlength="3" name="youtube_embed_height" value="<?php echo $options[ 'height' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'The width x height of the video, in pixels', 'youtube-embed' ); ?></span></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Default Sizes', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_size">
<option value=""<?php if ( $default_size == '' ) { echo " selected='selected'"; } ?>><?php _e( 'Use above sizes', 'youtube-embed' ); ?></option>
<option value="04800385"<?php if ( $default_size == "04800385" ) { echo " selected='selected'"; } ?>><?php echo '480x385 4:3'; ?></option>
<option value="05600340"<?php if ( $default_size == "05600340" ) { echo " selected='selected'"; } ?>><?php echo '560x340 16:9'; ?></option>
<option value="06400385"<?php if ( $default_size == "06400385" ) { echo " selected='selected'"; } ?>><?php echo '640x385 16:9'; ?></option>
<option value="08530505"<?php if ( $default_size == "08530505" ) { echo " selected='selected'"; } ?>><?php echo '853x505 16:9'; ?></option>
<option value="12800745"<?php if ( $default_size == "12800745" ) { echo " selected='selected'"; } ?>><?php echo '1280x745 16:9'; ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Select one of these default sizes to override the above video sizes', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Dynamically Resize', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_dynamic" value="1"<?php if ( $options[ 'dynamic' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show full width and resize with the browser', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Set Maximum Size', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_fixed" value="1"<?php if ( $options[ 'fixed' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Use above width to define maximum size', 'youtube-embed' ); ?></span></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Video Quality', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_vq">
<option value=""<?php if ( $options[ 'vq' ] == '' ) { echo " selected='selected'"; } ?>><?php _e( 'Not set', 'youtube-embed' ); ?></option>
<option value="small"<?php if ( $options[ 'vq' ] == "small" ) { echo " selected='selected'"; } ?>><?php echo '240p (Small)'; ?></option>
<option value="medium"<?php if ( $options[ 'vq' ] == "medium" ) { echo " selected='selected'"; } ?>><?php echo '360p (Medium)'; ?></option>
<option value="large"<?php if ( $options[ 'vq' ] == "large" ) { echo " selected='selected'"; } ?>><?php echo '480p (Large)'; ?></option>
<option value="hd720"<?php if ( $options[ 'vq' ] == "hd720" ) { echo " selected='selected'"; } ?>><?php echo '720p (HD)'; ?></option>
<option value="hd1080"<?php if ( $options[ 'vq' ] == "hd1080" ) { echo " selected='selected'"; } ?>><?php echo '1080p (HD)'; ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Specify the required resolution (if available).', 'youtube-embed' ); ?></span></td>
</tr>
</table>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Audio Only', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_audio" value="1"<?php if ( $options[ 'audio' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Only show the toolbar for audio only playback', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Autoplay', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_autoplay" value="1"<?php if ( $options[ 'autoplay' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'The video will start playing when the player loads', 'youtube-embed' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options Not Supported by EmbedPlus', 'youtube-embed' ); ?></span>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Auto hide', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_autohide">
<option value="0"<?php if ( $options[ 'autohide' ] == "0" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls &amp; progress bar remain visible', 'youtube-embed' ); ?></option>
<option value="1"<?php if ( $options[ 'autohide' ] == "1" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls &amp; progress bar fade out', 'youtube-embed' ); ?></option>
<option value="2"<?php if ( $options[ 'autohide' ] == "2" ) { echo " selected='selected'"; } ?>><?php _e( 'Progress bar fades', 'youtube-embed' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Video controls will automatically hide after a video begins playing', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Controls', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_controls">
<option value="0"<?php if ( $options[ 'controls' ] == "0" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls do not display &amp; Flash player loads immediately', 'youtube-embed' ); ?></option>
<option value="1"<?php if ( $options[ 'controls' ] == "1" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls display &amp; Flash player loads immediately', 'youtube-embed' ); ?></option>
<option value="2"<?php if ( $options[ 'controls' ] == "2" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls display &amp; Flash player loads once video starts', 'youtube-embed' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Whether the video player controls will display. For AS3 player it also defines when the Flash player will load', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row">SSL</th>
<td><input type="checkbox" name="youtube_embed_https" value="1"<?php if ( $options[ 'https' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Use SSL? <a href="http://www.google.com/support/youtube/bin/answer.py?answer=171780&expand=UseHTTPS#HTTPS">Read more</a>', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Loop Video', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_loop" value="1"<?php if ( $options[ 'loop' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Play the initial video again and again. In the case of a playlist, this will play the entire playlist and then start again at the first video', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Information', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_info" value="1"<?php if ( $options[ 'info' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Display the video title and uploader before the video starts. If displaying a playlist this will show video thumbnails', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Related Videos', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_related" value="1"<?php if ( $options[ 'related' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Load related videos once playback starts. Also toggles the search option.', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Theme', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_theme">
<option value="dark"<?php if ( $options[ 'theme' ] == "dark" ) { echo " selected='selected'"; } ?>><?php _e( 'Dark', 'youtube-embed' ); ?></option>
<option value="light"<?php if ( $options[ 'theme' ] == "light" ) { echo " selected='selected'"; } ?>><?php _e( 'Light', 'youtube-embed' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Display player controls within a dark or light control bar', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Progress Bar Color', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_color">
<option value="red"<?php if ( $options[ 'color' ] == "red" ) { echo " selected='selected'"; } ?>><?php _e( 'Red', 'youtube-embed' ); ?></option>
<option value="white"<?php if ( $options[ 'color' ] == "white" ) { echo " selected='selected'"; } ?>><?php _e( 'White (desaturated)', 'youtube-embed' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'The color that will be used in the player\'s video progress bar to highlight the amount of the video that\'s already been seen', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Modest Branding', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_modest" value="1"<?php if ( $options[ 'modest' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Reduce branding on video.', 'youtube-embed' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options for AS3 Player', 'youtube-embed' ); ?></span>
<br/><br/><?php _e( 'The following options are not supported if using EmbedPlus or if the IFRAME player uses HTML5.' ); ?>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Annotations', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_annotation" value="1"<?php if ( $options[ 'annotation' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Video annotations are shown by default', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Closed Captions', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_cc" value="1"<?php if ( $options[ 'cc' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show closed captions (subtitles) by default, even if the user has turned captions off', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Disable Keyboard', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_disablekb" value="1"<?php if ( $options[ 'disablekb' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Disable the player keyboard controls', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Fullscreen', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_fullscreen" value="1"<?php if ( $options[ 'fullscreen' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'A button will allow the viewer to watch the video fullscreen', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Link to YouTube', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_link" value="1"<?php if ( $options[ 'link' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Video links back to YouTube when clicked', 'youtube-embed' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options Not Supported by HTML5 Player', 'youtube-embed' ); ?></span>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e( 'Window Mode', 'youtube-embed' ); ?></th>
<td><select name="youtube_embed_wmode">
<option value="opaque"<?php if ( $options[ 'wmode' ] == "opaque" ) { echo " selected='selected'"; } ?>><?php _e( 'Opaque', 'youtube-embed' ); ?></option>
<option value="transparent"<?php if ( $options[ 'wmode' ] == "transparent" ) { echo " selected='selected'"; } ?>><?php _e( 'Transparent', 'youtube-embed' ); ?></option>
<option value="window"<?php if ( $options[ 'wmode' ] == "window" ) { echo " selected='selected'"; } ?>><?php _e( 'Window', 'youtube-embed' ); ?></option>
</select><span class="description"><?php _e( 'Sets the Window Mode property of the Flash movie for transparency, layering, and positioning in the browser. <a href="http://www.communitymx.com/content/article.cfm?cid=e5141">Learn more</a>.', 'youtube-embed' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options Only Supported By EmbedPlus', 'youtube-embed' ); ?></span>&nbsp;&nbsp;<span class="description"><?php echo '<a href="http://vixy.net/youtube-embed/documentation.php#EmbedPlus">' . __( 'Learn more about EmbedPlus', 'youtube-embed' ) . '</a>'; ?></span>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e( 'Fallback Embed Type', 'youtube-embed' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use if Flash is not available and EmbedPlus cannot be used.', 'youtube-embed' ); ?></span><br/>
<input type="radio" name="youtube_embed_fallback" value="v"<?php if ( $options[ 'fallback' ] == "v" ) { echo ' checked="checked"'; } ?>/>&nbsp;<?php _e( 'IFRAME', 'youtube-embed' ); ?><br/>
<input type="radio" name="youtube_embed_fallback" value="p"<?php if ( $options[ 'fallback' ] == "p" ) { echo ' checked="checked"'; } ?>/>&nbsp;<?php _e( 'OBJECT', 'youtube-embed' ); ?></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Play HD', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_hd" value="1"<?php if ( $options[ 'hd' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Play the video in HD if possible', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Real-time Reactions', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_react" value="1"<?php if ( $options[ 'react' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show the Real-time Reactions button', 'youtube-embed' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Sweet Spots', 'youtube-embed' ); ?></th>
<td><input type="checkbox" name="youtube_embed_sweetspot" value="1"<?php if ( $options[ 'sweetspot' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Find sweet spots for the next and previous buttons', 'youtube-embed' ); ?></span></td>
</tr>
</table>

<?php wp_nonce_field( 'youtube-embed-profile', 'youtube_embed_profile_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Settings', 'youtube-embed' ); ?>"/></p>

</form>

</div>

<a href="#" name="video"></a>
<form method="post" action="<?php echo get_bloginfo( 'wpurl' ).'/wp-admin/admin.php?page=profile-options#video' ?>">
<div class="ytbox_grey">
<h3><?php _e( 'YouTube Video Sample', 'youtube-embed' ); ?></h3>
<p><?php _e( 'The video below uses the above, saved profile settings. Use the drop-down below to change which parameters the video uses - press the Change Video button to update it.', 'youtube-embed' ); ?></p>
<p><select name="youtube_embed_video_type">
<option value="d"<?php if ( $video_type == "d" ) { echo " selected='selected'"; } ?>><?php _e( 'Standard', 'youtube-embed' ); ?></option>
<option value="p"<?php if ( $video_type == "p" ) { echo " selected='selected'"; } ?>><?php _e( 'EmbedPlus', 'youtube-embed' ); ?></option>
<option value="3"<?php if ( $video_type == "3" ) { echo " selected='selected'"; } ?>><?php _e( '3D', 'youtube-embed' ); ?></option>
<option value="l"<?php if ( $video_type == "l" ) { echo " selected='selected'"; } ?>><?php _e( 'Playlist', 'youtube-embed' ); ?></option>
</select>
<?php wp_nonce_field( 'youtube-embed-profile', 'youtube_embed_profile_nonce', true, true ); ?>
<input type="submit" name="Video" class="button-secondary" value="<?php _e( 'Change video', 'youtube-embed' ); ?>"/></p>

<p><?php
if ( $video_type == "d" ) { $id = $demo_video; $type = ''; }
if ( $video_type == "p" ) { $id = 'YVvn8dpSAt0'; $type = 'm'; }
if ( $video_type == "3" ) { $id = 'NR5UoBY87GM'; $type = ''; ; }
if ( $video_type == "l" ) { $id = '095393D5B42B2266'; $type = ''; }
echo vye_generate_youtube_code( $id, $type, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $profile_no );
?></p>
</div>

</form>

</div>