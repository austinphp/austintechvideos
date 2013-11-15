<?php
/*
Plugin Name: Lux Vimeo
Plugin URI: http://www.partnervermittlung-ukraine.net/info/lux-vimeo-wordpress-plugin
Description: Allows the user to embed Vimeo movie clips by entering a shortcode ([vimeo]) into the post area.
Author: Matroschka
Version: 1.2
Author URI: http://www.pastukhova-floeder.de/
License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
*/

class lux_vimeo {
    function shortcode($atts, $content=null) {
		extract(shortcode_atts(array(
			'clip_id' 	=> '',
			'width' 	=> '400',
			'height' 	=> '225',
			'title'	=> '1',
			'byline'	=> '1',
			'portrait'	=> '1',
			'color'		=> '',
			'html5' 	=> '1',
		), $atts));

		if (empty($clip_id) || !is_numeric($clip_id)) return '<!-- Lux Vimeo: Invalid clip_id -->';
		if ($height && !$atts['width']) $width = intval($height * 16 / 9);
		if (!$atts['height'] && $width) $height = intval($width * 9 / 16);

		return $html5 ?
			"<iframe src='http://player.vimeo.com/video/$clip_id?title=$title&amp;byline=$byline&amp;portrait=$portrait' width='$width' height='$height' frameborder='0'></iframe>" :
			"<object width='$width' height='$height'><param name='allowfullscreen' value='true' />".
    			"<param name='allowscriptaccess' value='always' />".
    			"<param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' />".
    			"<embed src='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='$width' height='$height'></embed></object>".
    			"<br /><a href='http://vimeo.com/$clip_id'>View on Vimeo</a>.";
    }
}

add_shortcode('vimeo', array('lux_vimeo', 'shortcode'));

?>