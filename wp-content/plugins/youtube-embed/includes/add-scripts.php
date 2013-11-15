<?php
/**
* Add Scripts
*
* Add JS and CSS to the main theme and to admin
*
* @package	YouTube-Embed
*/

// Switch on shortcodes in widgets, if requested

if ( !is_admin() ) {
	$options = get_option( 'youtube_embed_general' );
	if ( $options[ 'widgets' ] == 1 ) { add_filter( 'widget_text', 'do_shortcode' ); }
}

/**
* Plugin initialisation
*
* Loads the plugin's translated strings and the plugins' JavaScript
*
* @since	2.5.5
*/

function vye_plugin_init() {

	$language_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages/';

	load_plugin_textdomain( 'youtube-embed', false, $language_dir );

}

add_action( 'init', 'vye_plugin_init' );

/**
* Add scripts to theme
*
* Add styles and scripts to the main theme
*
* @since		2.4
*/

function vye_main_scripts() {

	wp_register_style( 'vye_dynamic', plugins_url( '/youtube-embed/css/main.min.css' ) );

	wp_enqueue_style( 'vye_dynamic' );

}

add_action( 'wp_enqueue_scripts', 'vye_main_scripts' );

/**
* Add CSS to admin
*
* Add stylesheets to the admin screens
*
* @since	2.0
*/

function vye_admin_css() {

	global $wp_version;
	if ( ( float ) $wp_version >= 3.2 ) { $version = ''; } else { $version = '-3.1'; }

	wp_enqueue_style( 'tinymce_button', plugins_url() . '/youtube-embed/css/admin' . $version . '.min.css' );

}

add_action( 'admin_print_styles', 'vye_admin_css' );
?>