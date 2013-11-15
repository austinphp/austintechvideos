<?php
/**
* Widgets
*
* Create and display widgets
*
* @package	YouTube-Embed
*/

class YouTubeEmbedWidget extends WP_Widget {

	/**
	* Widget Constructor
	*
	* Call WP_Widget class to define widget
	*
	* @since	2.0
	*
	* @uses		WP_Widget				Standard WP_Widget class
	*/

	function YouTubeEmbedWidget() {
		parent::WP_Widget(	'youtube_embed_widget',
							__( 'YouTube Embed', 'youtube-embed' ),
							array( 'description' => __( 'Embed YouTube Widget.', 'youtube-embed' ), 'class' => 'my-widget-class' )
							);
	}

	/**
	* Display widget
	*
	* Display the YouTube widget
	*
	* @since	2.0
	*
	* @uses		generate_youtube_code	Generate the required YouTube code
	*
	* @param	string		$args			Arguments
	* @param	string		$instance		Instance
	*/

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		// Output the header
		echo $before_widget;

		// Extract title for heading
		$title = $instance[ 'titles' ];

		// Output title, if one exists
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

		// Set the correct
		if ( $instance[ 'id_type' ] == 's' ) { $search = 1; } else { $search = ''; }
		if ( $instance[ 'id_type' ] == 'u' ) { $user = 1; } else { $user = ''; }

		// Generate the video and output it
		echo vye_generate_youtube_code ( $instance[ 'id' ],
										$instance[ 'type' ],
										$instance[ 'width' ],
										$instance[ 'height' ],
										'',
										'',
										$instance[ 'autoplay' ],
										$instance[ 'loop' ],
										$instance[ 'start' ],
										'',
										'',
										'',
										$instance[ 'style' ],
										'',
										'',
										$instance[ 'stop' ],
										'',
										'',
										'',
										'',
										'',
										$instance[ 'profile' ],
										$instance[ 'list' ],
										'',
										$instance[ 'template' ],
										'',
										'',
										'',
										'',
										$instance[ 'dynamic' ],
										$search,
										$user );

		// Output the trailer
		echo $after_widget;
	}

	/**
	* Widget update/save function
	*
	* Update and save widget
	*
	* @since	2.0
	*
	* @param	string		$new_instance		New instance
	* @param	string		$old_instance		Old instance
	* @return	string							Instance
	*/

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance[ 'titles' ] = strip_tags( $new_instance[ 'titles' ] );
		$instance[ 'id' ] = $new_instance[ 'id' ];
		$instance[ 'profile' ] = $new_instance[ 'profile' ];
		$instance[ 'type' ] = $new_instance[ 'type' ];
		$instance[ 'template' ] = $new_instance[ 'template' ];
		$instance[ 'style' ] = $new_instance[ 'style' ];
		$instance[ 'start' ] = $new_instance[ 'start' ];
		$instance[ 'autoplay' ] = $new_instance[ 'autoplay' ];
		$instance[ 'width' ] = $new_instance[ 'width' ];
		$instance[ 'height' ] = $new_instance[ 'height' ];
		$instance[ 'dynamic' ] = $new_instance[ 'dynamic' ];
		$instance[ 'list' ] = $new_instance[ 'list' ];
		$instance[ 'loop' ] = $new_instance[ 'loop' ];
		$instance[ 'stop' ] = $new_instance[ 'stop' ];
		$instance[ 'id_type' ] = $new_instance[ 'id_type' ];

		return $instance;

	}

	/**
	* Widget Admin control form
	*
	* Define admin file
	*
	* @since	2.0
	*
	* @param	string		$instance		Instance
	*/

	function form( $instance ) {
		include ( WP_PLUGIN_DIR . '/youtube-embed/includes/options-widgets.php' );
	}
}

/**
* Register Widget
*
* Register widget when loading the WP core
*
* @since	2.0
*/

function youtube_embed_register_widgets() {
	register_widget( 'YouTubeEmbedWidget' );
}
add_action( 'widgets_init', 'youtube_embed_register_widgets' );
?>