<?php


/*this function allows for the auto-creation of post excerpts*/
if ( ! function_exists( 'truncate_post' ) ){
	function truncate_post($amount,$echo=true,$post='') {
		global $shortname;
		
		if ( $post == '' ) global $post;
			
		$postExcerpt = '';
		$postExcerpt = $post->post_excerpt;
		
		if (get_option($shortname.'_use_excerpt') == 'on' && $postExcerpt <> '') { 
			if ($echo) echo $postExcerpt;
			else return $postExcerpt;	
		} else {
			$truncate = $post->post_content;
			
			$truncate = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate);
			
			if ( strlen($truncate) <= $amount ) $echo_out = ''; else $echo_out = '...';
			$truncate = apply_filters('the_content', $truncate);
			$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
			$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
			
			$truncate = strip_tags($truncate); 
			
			if ($echo_out == '...') $truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
			else $truncate = substr($truncate, 0, $amount);

			if ($echo) echo $truncate,$echo_out;
			else return ($truncate . $echo_out);
		};
	}
}