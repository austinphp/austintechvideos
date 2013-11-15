<?php
/**
* Admin Config Functions
*
* Various functions relating to the various administration screens
*
* @package	YouTube-Embed
*/

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function vye_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {
		$settings_link = '<a href="admin.php?page=general-options">' . __( 'Settings', 'youtube-embed' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'vye_add_settings_link', 10, 2 );

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function vye_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="http://wordpress.org/support/plugin/youtube-embed">' . __( 'Support', 'youtube-embed' ) . '</a>' ) );

	}

	return $links;
}

add_filter( 'plugin_row_meta', 'vye_set_plugin_meta', 10, 2 );

/**
* Admin Screen Initialisation
*
* Set up admin menu and submenu options
*
* @since	2.0
*
* @uses     vye_contextual_help_type    Work out help type
*/

function vye_menu_initialise() {

	// Get level access for menus

	$options = vye_set_general_defaults();

	$menu_access = $options[ 'menu_access' ];

	// Depending on WordPress version and available functions decide which (if any) contextual help system to use

	$contextual_help = vye_contextual_help_type();

	// Add main admin option

	add_menu_page( __( 'About Vixy YouTube Embed', 'youtube-embed' ), __( 'YouTube', 'youtube-embed' ), $menu_access, 'general-options', 'vye_general_options', plugins_url() . '/youtube-embed/images/admin_menu_icon.png' );

	// Add options sub-menu

	if ( $contextual_help == 'new' ) { global $vye_options_hook; }

	$vye_options_hook = add_submenu_page( 'general-options', __( 'Vixy YouTube Embed Options', 'youtube-embed' ),  __( 'Options', 'youtube-embed' ), $menu_access, 'general-options', 'vye_general_options' );

	if ( $contextual_help == 'new' ) { add_action( 'load-' . $vye_options_hook, 'vye_add_options_help' ); }

	if ( $contextual_help == 'old' ) { add_contextual_help( $vye_options_hook, vye_options_help() ); }

	// Add profiles sub-menu

	if ( $contextual_help == 'new' ) { global $vye_profiles_hook; }

	$vye_profiles_hook = add_submenu_page( 'general-options', __( 'Vixy YouTube Embed Profiles', 'youtube-embed' ), __( 'Profiles', 'youtube-embed' ), $menu_access, 'profile-options', 'vye_profile_options' );

	if ( $contextual_help == 'new' ) { add_action( 'load-' . $vye_profiles_hook, 'vye_add_profiles_help' ); }

	if ( $contextual_help == 'old' ) { add_contextual_help( $vye_profiles_hook, vye_profiles_help() ); }

	// Add lists sub-menu

	if ( $contextual_help == 'new' ) { global $vye_lists_hook; }

	$vye_lists_hook = add_submenu_page( 'general-options', __( 'Vixy YouTube Embed Lists', 'youtube-embed' ), __( 'Lists', 'youtube-embed' ), $menu_access, 'list-options', 'vye_list_options' );

	if ( $contextual_help == 'new' ) { add_action( 'load-' . $vye_lists_hook, 'vye_add_lists_help' ); }

	if ( $contextual_help == 'old' ) { add_contextual_help( $vye_lists_hook, vye_lists_help() ); }

}

add_action( 'admin_menu', 'vye_menu_initialise' );

/**
* Get contextual help type
*
* Return whether this WP installation requires the new or old contextual help type, or none at all
*
* @since	2.5
*
* @return   string			Contextual help type - 'new', 'old' or false
*/

function vye_contextual_help_type() {

	global $wp_version;

	$type = false;

	if ( ( float ) $wp_version >= 3.3 ) {
		$type = 'new';
	} else {
		if ( function_exists( 'add_contextual_help' ) ) {
			$type = 'old';
		}
	}

	return $type;
}

/**
* Include general options screen
*
* XHTML options screen to prompt and update some general plugin options
*
* @since	2.0
*/

function vye_general_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-general.php' );

}

/**
* Include profile options screen
*
* XHTML options screen to prompt and update profile options
*
* @since	2.0
*/

function vye_profile_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-profiles.php' );

}

/**
* Include list options screen
*
* XHTML options screen to prompt and update list options
*
* @since	2.0
*/

function vye_list_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-lists.php' );

}

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	2.5
*
* @uses     vye_options_help    Return help text
*/

function vye_add_options_help() {

	global $vye_options_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_options_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'options-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_options_help() ) );
}

/**
* Options Help
*
* Return help text for options screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_options_help() {

	$help_text = '<p>' . __( 'This screen allows you to select non-specific options for the Vixy YouTube Embed plugin. For the default embedding settings, please select the <a href="admin.php?page=profile-options">Profiles</a> administration option.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'Remember to click the Save Settings button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:', 'youtube-embed' ) . '</strong></p>';
	$help_text .= '<p><a href="http://vixy.net/youtube-embed/documentation.php">' . __( 'Vixy YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Add Profiles Help
*
* Add help tab to profiles screen
*
* @since	2.5
*
* @uses     vye_profiles_help    Return help text
*/

function vye_add_profiles_help() {

	global $vye_profiles_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_profiles_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'profiles-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_profiles_help() ) );
}

/**
* Profiles Help
*
* Return help text for profiles screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_profiles_help() {

	$help_text = '<p>' . __( 'This screen allows you to set the options for the default and additional profiles. If you don\'t specify a specific parameter when displaying your YouTube video then the default profile option will be used instead. Additional profiles, which you may name, can be used as well and used as required.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'Remember to click the Save Settings button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:' ) . '</strong></p>';
	$help_text .= '<p><a href="http://vixy.net/youtube-embed/documentation.php">' . __( 'Vixy YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://embedplus.com/">' . __( 'EmbedPlus website', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Add Lists Help
*
* Add help tab to lists screen
*
* @since	2.5
*
* @uses     vye_lists_help    Return help text
*/

function vye_add_lists_help() {

	global $vye_lists_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_lists_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'lists-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_lists_help() ) );
}

/**
* List Help
*
* Return help text for lists screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_lists_help() {

	$help_text = '<p>' . __( 'This screen allows you to create lists of YouTube videos, which may be named. These lists can then be used in preference to a single video ID.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'Remember to click the Save Settings button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:', 'youtube-embed' ) . '</strong></p>';
	$help_text .= '<p><a href="http://vixy.net/youtube-embed/documentation.php">' . __( 'Vixy YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Detect plugin activation
*
* Upon detection of activation set an option
*
* @since	2.4
*/

function vye_plugin_activate() {

	update_option( 'youtube_embed_activated', true );

}

register_activation_hook( WP_PLUGIN_DIR . "/youtube-embed/youtube-embed.php", 'vye_plugin_activate' );

// If plugin activated, run activation commands and delete option

global $wp_version;

if ( get_option( 'youtube_embed_activated' ) && ( ( float ) $wp_version >= 3.3 ) ) {

	add_action( 'admin_enqueue_scripts', 'vye_admin_enqueue_scripts' );

	delete_option( 'youtube_embed_activated' );
}

/**
* Enqueue Feature Pointer files
*
* Add the required feature pointer files
*
* @since	2.4
*/

function vye_admin_enqueue_scripts() {

	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );

	add_action( 'admin_print_footer_scripts', 'vye_admin_print_footer_scripts' );
}

/**
* Show Feature Pointer
*
* Display feature pointer
*
* @since	2.4
*/

function vye_admin_print_footer_scripts() {

	$pointer_content = '<h3>' . __( 'Welcome to Vixy YouTube Embed', 'youtube-embed' ) . '</h3>';
	$pointer_content .= '<p style="font-style:italic;">' . __( 'Thank you for installing this plugin.', 'youtube-embed' ) . '</p>';
	$pointer_content .= '<p>' . __( 'These new menu options will allow you to configure your videos to just how you want them and provide links for help and support.', 'youtube-embed' ) . '</p>';
	$pointer_content .= '<p>' . __( 'Even if you do nothing else, please visit the Profiles option to check your default video values.', 'youtube-embed' ) . '</p>';
?>
<script>
jQuery(function () {
	var body = jQuery(document.body),
	menu = jQuery('#toplevel_page_support-about'),
	collapse = jQuery('#collapse-menu'),
	yembed = menu.find("a[href='admin.php?page=profile-options']"),
	options = {
		content: '<?php echo $pointer_content; ?>',
		position: {
			edge: 'left',
			align: 'center',
			of: menu.is('.wp-menu-open') && !menu.is('.folded *') ? yembed : menu
		},
		close: function() {
		}};

	if ( !yembed.length )
		return;

	body.pointer(options).pointer('open');
});
</script>
<?php
}
?>