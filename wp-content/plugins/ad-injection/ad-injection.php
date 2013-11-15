<?php
/*
Plugin Name: Ad Injection
Plugin URI: http://www.reviewmylife.co.uk/blog/2010/12/06/ad-injection-plugin-wordpress/
Description: Injects any advert (e.g. AdSense) into your WordPress posts or widget area. Restrict who sees the ads by post length, age, referrer or IP. Cache compatible.
Version: 1.2.0.16
Author: reviewmylife
Author URI: http://www.reviewmylife.co.uk/
License: GPLv2
*/

/* License header moved to ad-injection-admin.php */

//error_reporting(E_ALL ^ E_STRICT);

//
define('ADINJ_NO_CONFIG_FILE', 1);

// DB Versions
// _ = before split testing
// 2 = split testing support
// 3 = added front options
// 4 = new character counting option
// 5 = search/404 exclusion, increase db ad rotations to 10 + author conditions
// 6 = archive/home options
// 7 = cat/tag/author restriction for top/random/bottom ads
// 8 = ui options for new layout
// 9 = replace the two direct modes with 'direct'
// 10 = exclusion tick boxes for top, random, bottom, and new footer ad
// 11 = options to disable rnd ad at bottom, and to get new ad for each rnd slot
// 13 = post/page id restrictions
// 14 = template ads
// 15 = remove duplicate 'Disabled' option from top/bottom ad section
// 16 = after paragraph options, older option for widget
// 17 = block ads for days
// 18 = 1.2.0.0 New ad insertion engine and new top/random/bottom positioning options
// 20 = 1.2.0.3 the_content_filter_priority setting
// 21 = 1.2.0.8 Template conditions
// 22 = 1.2.0.13 exclude_ads_from_block_tags option
// 23 = 1.2.0.15 exclude_ads_from_[div/list/form]_tags option
// 24 = 1.2.0.16 exclude_ads_from_table_tags option
define('ADINJ_DB_VERSION', 24);

// Files
// TODO will these paths work on windows?
//define('ADINJ_PATH', WP_PLUGIN_DIR.'/ad-injection');
define('ADINJ_PATH', dirname(__FILE__));
define('ADINJ_CONFIG_FILE', WP_CONTENT_DIR . '/ad-injection-config.php');
define('ADINJ_AD_PATH', WP_PLUGIN_DIR.'/ad-injection-data');

// Constants
define('ADINJ_DISABLED', 'Disabled'); // todo deprecated?
define('ADINJ_RULE_DISABLED', 'Rule Disabled'); // todo depreacated?
//
define('ADINJ_ONLY_SHOW_IN', 'Only show in');
define('ADINJ_NEVER_SHOW_IN', 'Never show in');
define('ADINJ_NA', 'n/a');
//
define('ADINJ_PARA', '</p>');

// Global variables
$adinj_total_top_ads_used = 0;
$adinj_total_random_ads_used = 0;
$adinj_total_bottom_ads_used = 0;
$adinj_data = array();

require_once(ADINJ_PATH . '/adshow.php');
if (is_admin()){
	require_once(ADINJ_PATH . '/ad-injection-admin.php');
}

function adinj_admin_menu_hook(){
	$options_page = add_options_page('Ad Injection', 'Ad Injection', 'manage_options', basename(__FILE__), 'adinj_options_page');
	add_action("admin_print_scripts-".$options_page, "adinj_admin_print_scripts_main");
	add_action("admin_print_scripts-widgets.php", "adinj_admin_print_scripts_widgets");
	
}

function adinj_options_link_hook($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if ($file == $this_plugin){
		$link = "<a href='options-general.php?page=ad-injection.php'>" . __("Settings") . "</a>";
		array_unshift($links, $link);
	}
	return $links;
}

function adinj_options($reset=false){
	global $adinj_data;
	if (empty($adinj_data) || $reset !== false){
		$adinj_data = get_option('adinj_options');
	}
	return $adinj_data;
}

function adinj_option($option){
	$ops = adinj_options();
	return $ops[$option];
}

function adinj_addsevjs_hook(){
	// TODO can re-enable this check once the widget ads are factored in.
	//if (adinj_ads_completely_disabled_from_page()) return;
	if (!adinj_ticked('sevisitors_only') && !adinj_ticked('block_keywords')) return;
	// Put the search engine detection / cookie setting script in the footer
	// TODO would be better to use plugin version, but that only seems accessible in admin
	$version = adinj_db_version(adinj_options());
	wp_enqueue_script('adinj_sev', WP_PLUGIN_URL.'/ad-injection/adinj-sev.js?v='.$version, NULL, NULL, false);
}

// TODO make the cookie domain from wp-config.php accessible to script
//$cookie_domain = COOKIE_DOMAIN; // TODO test
//var adinj_cookie_domain = "$cookie_domain"; //JS line. TODO test
function adinj_print_referrers_hook(){
	// TODO can re-enable this check once the widget ads are factored in.
	//if (adinj_ads_completely_disabled_from_page()) return;
	$sevisitors = adinj_ticked('sevisitors_only');
	$block = adinj_ticked('block_keywords');
	if (!$sevisitors && !$block) return;
	
	echo <<<SCRIPT

<script type="text/javascript">
// Ad Injection plugin

SCRIPT;

	$ops = adinj_options();
	$referrer_list = adinj_quote_list('ad_referrers');
	$blocked_list = adinj_quote_list('blocked_keywords');
	$blocked_hours = $ops['block_ads_for_hours'];
	if ($sevisitors) echo "var adinj_referrers = new Array($referrer_list);\n";
	if ($block) echo "var adinj_blocked_referrers = new Array($blocked_list);\n";
	if ($block) echo "var adinj_blocked_hours = $blocked_hours;\n";
	echo "adinj_dynamic_checks();\n";
	echo "</script>\n";
}

function adinj_quote_list($option){
	$ops = adinj_options();
	$list = $ops[$option];
	
	// I'm sure this whole thing could be done with a much simpler single
	// line of PHP - but right now my brain isn't up to thinking about it!
	$lines = explode("\n", $list);
	foreach ($lines as $line){
		$stripped_lines[] = preg_replace("/\/\/.*/", "", $line);
	}
	$list = implode(" ", $stripped_lines);
	
	$list = preg_replace("/'/", "", $list);
	$referrers = preg_split("/[\s,]+/", $list, -1, PREG_SPLIT_NO_EMPTY);
	if (empty($referrers)) return '';
	foreach ($referrers as $referrer){
		$newlist[] = "'" . $referrer . "'";
	}
	return implode(", ", $newlist);
}

function adinj_get_ad_code($adtype, $ads_db){
	$ops = adinj_options();
	$ads_live = NULL;
	$ads_split = NULL;
	$alt_live = NULL;
	$alt_split = NULL;
	$formatting = NULL;
	if (adinj_mfunc_mode()){
		adinj_live_ads_array($adtype, $ads_db, $ads_live, $ads_split, 'string');
		adinj_live_ads_array($adtype.'_alt', $ads_db, $alt_live, $alt_split, 'string');
		$formatting = adinj_formatting_options($adtype, $ads_db, 'string');
	} else {
		$ads_live = array();
		$ads_split = array();
		$alt_live = array();
		$alt_split = array();
		adinj_live_ads_array($adtype, $ads_db, $ads_live, $ads_split, 'array');
		adinj_live_ads_array($adtype.'_alt', $ads_db, $alt_live, $alt_split, 'array');
		$formatting = adinj_formatting_options($adtype, $ads_db, 'array');
	}
	if (empty($ads_live) && empty($alt_live)){
		return "";
	}
	if (adinj_mfunc_mode()){
		return adinj_ad_code_eval("\n
<!--Ad Injection mfunc mode ad code--><!--mfunc adshow_display_ad_file_v2(array($ads_live), array($ads_split), array($formatting), array($alt_live), array($alt_split)) -->
<?php adshow_display_ad_file_v2(array($ads_live), array($ads_split), array($formatting), array($alt_live), array($alt_split)); ?>
<!--/mfunc-->
");
	}
	
	// else dynamic ad
	if (adshow_show_adverts() !== true){
		$adname = adshow_pick_value($alt_live, $alt_split);
	} else {
		$adname = adshow_pick_value($ads_live, $ads_split);
	}
	$ad = $ads_db[$adname];
	
	if (empty($ad)){
		return "";
	}
	
	$ad = adshow_add_formatting($ad, $formatting);
	return "<!--Ad Injection:$adtype-->".adinj_ad_code_eval($ad);
}

function adinj_ad_code_random(){
	return adinj_get_ad_code('random', adinj_options());
}

function adinj_ad_code_top(){
	return adinj_get_ad_code('top', adinj_options());
}

function adinj_ad_code_bottom(){
	return adinj_get_ad_code('bottom', adinj_options());
}

function adinj_ad_code_footer(){
	return adinj_get_ad_code('footer', adinj_options());
}

/**
Old:
ad_code_random_1 <-> ad_random_1.txt

New:
ad_code_random_1:ad_code_random_1_split <-> ad_random_1.txt
ad_code_random_alt_1:ad_code_random_alt_1_split <-> ad_random-alt_1.txt
*/
function adinj_live_ads_array($type, $ads_option, &$ads, &$split, $output_type="string"){
	$op_stem = "";
	$file_stem = "";

	if ($type == 'random' || $type == 'top' || $type == 'bottom' || $type == 'footer' ||
		$type == 'random_alt' || $type == 'top_alt' || $type == 'bottom_alt' || $type == 'footer_alt'){
		$op_stem = 'ad_code_'.$type.'_';
		$file_stem = 'ad_'.$type.'_';
	} else if (preg_match("/widget_[\d+]/i", $type)){
		if (strpos($type, '_alt') === false){
			$op_stem = 'advert_';
		} else {
			$op_stem = 'advert_alt_';
		}
		$file_stem = 'ad_'.$type.'_';
	}
	
	// DB with support for ad rotation
	for ($i=1; $i<=10; ++$i){
		$ad_name = $op_stem.$i;
		if (!array_key_exists($ad_name.'_split', $ads_option)) return;
		
		$split_val = $ads_option[$ad_name.'_split'];
		
		if (!empty($ads_option[$ad_name]) && is_numeric($split_val) && $split_val > 0){
			if ($output_type == "string"){
				if (!empty($ads)) $ads .= ",";
				$ads .= "'".$file_stem."$i.txt'";
				if (!empty($split)) $split .= ",";
				$split .= $split_val;
			} else {
				$ads[] = $ad_name;
				$split[] = $split_val;
			}
		}
	}
}

function adinj_formatting_options($adtype, $ops, $output_type="string"){
	$align = "";
	$clear = "";
	$margin_top = "";
	$margin_bottom = "";
	$padding_top = "";
	$padding_bottom = "";

	$prefix = '';
	if ($adtype == 'random') $prefix = 'rnd_';
	if ($adtype == 'top') $prefix = 'top_';
	if ($adtype == 'bottom') $prefix = 'bottom_';
	if ($adtype == 'footer') $prefix = 'footer_';
	//widgets have no prefix

	$align = $ops[$prefix.'align'];
	$clear = $ops[$prefix.'clear'];
	$margin_top = $ops[$prefix.'margin_top'];
	$margin_bottom = $ops[$prefix.'margin_bottom'];
	$padding_top = $ops[$prefix.'padding_top'];
	$padding_bottom = $ops[$prefix.'padding_bottom'];
	
	if (adinj_not_set($align)) $align = "";
	if (adinj_not_set($clear)) $clear = "";
	if (adinj_not_set($margin_top)) $margin_top = "";
	if (adinj_not_set($margin_bottom)) $margin_bottom = "";
	if (adinj_not_set($padding_top)) $padding_top = "";
	if (adinj_not_set($padding_bottom)) $padding_bottom = "";
	
	if ($output_type == "string"){
		return "'align' => '$align', 'clear' => '$clear', 'margin_top' => '$margin_top', 'margin_bottom' => '$margin_bottom', 'padding_top' => '$padding_top', 'padding_bottom' => '$padding_bottom'";
	} else {
		return array('align' => $align,
			'clear' => $clear,
			'margin_top' => $margin_top,
			'margin_bottom' => $margin_bottom,
			'padding_top' => $padding_top,
			'padding_bottom' => $padding_bottom);
	}
}

function adinj_ad_code_eval($ad){
	if (strlen($ad) == 0) return $ad;
	if (stripos($ad, '<?php') !== false){
		return adshow_eval_php($ad);
	}
	return $ad;
}

function adinj_ad_code_include(){
	$plugin_dir = ADINJ_PATH;
	if (adinj_mfunc_mode()){
		// WP Super Cache's support for mclude assumes that we will be including
		// files from within ABSPATH. To remove this limitation we do the include
		// using mfunc instead.
		return adinj_ad_code_eval("\n
<!--Ad Injection mfunc mode ad include code--><!--mfunc include_once('$plugin_dir/adshow.php') --><?php include_once('$plugin_dir/adshow.php'); ?><!--/mfunc-->
");
	}
	return "";
}

function read_ad_from_file($ad_path){
	$contents = "";
	if (file_exists($ad_path)){
		$contents = file_get_contents($ad_path);
		if ($contents === false) return "Error: can't read from file: $ad_path";
	}
	return $contents;
}

// Based on: http://www.wprecipes.com/wordpress-hack-how-to-display-ads-on-old-posts-only
// Only use for pages and posts. Not for archives, categories, home page, etc.
function adinj_is_old_post($adtype){
	$ops = adinj_options();
	if ($adtype == 'widget'){
		$days = $ops['widgets_on_page_older_than'];
	} else {
		$days = $ops['ads_on_page_older_than'];
	}
	if ($days == 0) return true;
	if(is_single() || is_page()) {
		$current_date = time();
		$offset = $days * 60*60*24;
		$post_date = get_the_time('U');
		if(($post_date + $offset) > $current_date){
			return false;
		} else {
			return true;
		}
	}
	return false;
}

function adinj_adverts_disabled_flag(){
	$custom_fields = get_post_custom();
	if (isset($custom_fields['disable_adverts'])){
		$disable_adverts = $custom_fields['disable_adverts'];
		return ($disable_adverts[0] == 1);
	}
	return 0;
}

function adinj($content, $message){
	if (!adinj_ticked('debug_mode')) return $content;
	global $adinj_total_top_ads_used, $adinj_total_random_ads_used, $adinj_total_bottom_ads_used;
	$ops = adinj_options();
	
	$rnd_start_at = $ops['random_ads_start_at'];
	$rnd_start_mode = $ops['random_ads_start_mode'];
	if ($rnd_start_mode == 'after') $rnd_start_mode = 'at or after';
	$rnd_start_unit = $ops['random_ads_start_unit'];
	
	$rnd_end_at = $ops['random_ads_end_at'];
	$rnd_end_mode = $ops['random_ads_end_mode'];
	$rnd_end_unit = $ops['random_ads_end_unit'];
	$rnd_end_unit_dir = $ops['random_ads_end_direction'];
	
	$mode = $ops['ad_insertion_mode'];
	
	$posttype = get_post_type() . ' (';
	if (is_archive()) $posttype .= ' archive';
	if (is_front_page()) $posttype .= ' front';
	if (is_home()) $posttype .= ' home';
	if (is_page()) $posttype .= ' page';
	if (is_search()) $posttype .= ' search';
	if (is_single()) $posttype .= ' single';
	if (is_404()) $posttype .= ' 404';
	$posttype .= ')';
	
	if(is_single() || is_page()) {
		$currentdate = time();
		$postdate = get_the_time('U');
		$currentday = $currentdate / 24 / 60 / 60;
		$postday = $postdate / 24 / 60 / 60;
	}
	return $content."
<!--
ADINJ DEBUG
$message
\$adinj_total_top_ads_used=$adinj_total_top_ads_used
\$adinj_total_random_ads_used=$adinj_total_random_ads_used
\$adinj_total_bottom_ads_used=$adinj_total_bottom_ads_used
random ads start=$rnd_start_mode - $rnd_start_unit - $rnd_start_at
random ads end=$rnd_end_mode - $rnd_end_unit - $rnd_end_at $rnd_end_unit_dir
posttype=$posttype
currentdate=$currentdate ($currentday)
postdate=$postdate ($postday)
injection mode=$mode
-->\n";
}

// todo check exclude options for hardcoded ads
function adinj_excluded_by_tick_box($prefix){
	if (is_front_page() && adinj_ticked($prefix.'exclude_front') ||
		is_home() && adinj_ticked($prefix.'exclude_home') ||
		is_search() && adinj_ticked($prefix.'exclude_search') ||
		is_404() && adinj_ticked($prefix.'exclude_404') ||
		is_page() && adinj_ticked($prefix.'exclude_page') ||
		is_single() && adinj_ticked($prefix.'exclude_single') ||
		is_archive() && adinj_ticked($prefix.'exclude_archive')){
		return true;
	}
	return false;
}

function adinj_ads_completely_disabled_from_page($adtype, $content=NULL){
	$ops = adinj_options();
	if ($ops['ads_enabled'] == 'off' ||
		$ops['ads_enabled'] == ''){
		return "NOADS: Ads are not switched on";
	}
	if ($ops['ads_enabled'] == 'test' && !current_user_can('activate_plugins')){
		return "NOADS: test mode enabled - ads only shown admins";
	}
	
	// check for ads on certain page types being disabled
	if (is_front_page() && adinj_ticked('exclude_front')){ return "NOADS: excluded from front page"; }
	if (is_home() && adinj_ticked('exclude_home')){ return "NOADS: excluded from home page"; }
	if (is_search() && adinj_ticked('exclude_search')){ return "NOADS: excluded from search pages"; }
	if (is_404() && adinj_ticked('exclude_404')){ return "NOADS: excluded from 404 pages"; }
	if ((is_page() && adinj_ticked('exclude_page')) ||
		(is_single() && adinj_ticked('exclude_single')) ||
		(is_archive() && adinj_ticked('exclude_archive'))){
		return "NOADS: excluded from this page type: ".get_post_type();
	}
	
	// if disable_adverts==1
	if (adinj_adverts_disabled_flag()) return "NOADS: adverts_disabled_flag";
	
	// no ads on old posts/pages if rule is enabled
	if((is_page() || is_single()) && !adinj_is_old_post($adtype)) return "NOADS: !is_old_post";
	
	if (!adinj_allowed_in_category('global', $ops)) return "NOADS: globally blocked from category";
	if (!adinj_allowed_in_tag('global', $ops)) return "NOADS: globally blocked from tag";	
	if (!adinj_allowed_in_author('global', $ops)) return "NOADS: globally blocked from author";
	if (!adinj_allowed_in_id('global', $ops)) return "NOADS: globally blocked from post/page id";
	
	// manual ad disabling tags
	if ($content == NULL) return false;
	if (stripos($content, "<!--noadsense-->") !== false) return "NOADS: noadsense tag"; // 'Adsense Injection' tag
	if (stripos($content, "<!-no-adsense-->") !== false) return "NOADS: no-adsense tag"; // 'Whydowork Adsense' tag
	if (stripos($content,'<!--NoAds-->') !== false) return "NOADS: NoAds tag"; // 'Quick Adsense' tag
	if (stripos($content,'<!--OffAds-->') !== false) return "NOADS: OffAds tag"; // 'Quick Adsense' tag
	
	return false;
}

function adinj_allowed_in_list($all_entries, $config_entries, $mode, $func){
	if (is_array($all_entries)){
		foreach($all_entries as $entry){
			$string = $func($entry);
			$decoded = rawurldecode($string); //allow UTF-8 encoded strings
			if (in_array($string, $config_entries) || in_array($decoded, $config_entries)){
				if (adinj_mode_only_show_in($mode)){
					return true;
				} else if (adinj_mode_never_show_in($mode)){
					return false;
				}
			}
		}
	}
	if (adinj_mode_only_show_in($mode)){
		return false;
	} else if (adinj_mode_never_show_in($mode)){
		return true;
	}
	echo ("<!--ADINJ DEBUG: error in adinj_allowed_in_list($func)-->");
	return true;
}

function adinj_mode_only_show_in($mode){
	return ($mode == ADINJ_ONLY_SHOW_IN || $mode == 'o');
}

function adinj_mode_never_show_in($mode){
	return ($mode == ADINJ_NEVER_SHOW_IN || $mode == 'n');
}

function adinj_allowed_in_category($scope, $ops){
	$conditions = adinj_split_comma_list($ops[$scope.'_category_condition_entries']);
	if (empty($conditions)) return true;
	
	$mode = $ops[$scope.'_category_condition_mode'];
	
	// widget ads and footer ad
	if (!in_the_loop() && adinj_mode_only_show_in($mode) && !(is_single() || is_category())){
		return false;
	}
	
	if (in_the_loop() && adinj_mode_only_show_in($mode) && !(is_single() || is_home() || is_category())){
		return false;
	}
	
	$categories = array();
	global $post;
	if (in_the_loop() && (is_single() || is_home())){
		$categories = get_the_category($post->ID);
	} else if (!in_the_loop() && is_single()){
		$cat_ids = wp_get_object_terms($post->ID, 'category', 'fields=all');
		foreach($cat_ids as $id){
			$categories[] = get_category($id);
		}
	} else if (is_category()){
		$categories[] = get_category(get_query_var('cat'));
	} // else cat array is empty
	return adinj_allowed_in_list($categories, $conditions, $mode, 'adinj_category_nicename');
}

function adinj_allowed_in_tag($scope, $ops){
	$conditions = adinj_split_comma_list($ops[$scope.'_tag_condition_entries']);
	if (empty($conditions)) return true;
	
	$mode = $ops[$scope.'_tag_condition_mode'];

	if (!in_the_loop() && adinj_mode_only_show_in($mode) && !(is_single() || is_tag())){
		return false;
	}

	if (in_the_loop() && adinj_mode_only_show_in($mode) && !(is_single() || is_home() || is_tag())){
		return false;
	}
	
	$tags = array();
	global $post;
	if (in_the_loop() && (is_single() || is_home())){
		$tags = get_the_tags($post->ID);
	} else if (!in_the_loop() && is_single()){
		$tag_ids = wp_get_object_terms($post->ID, 'post_tag', 'fields=all');
		foreach($tag_ids as $id){
			$tags[] = get_tag($id);
		}
	} else if (is_tag()){
		$tags[] = get_tag(get_query_var('tag_id'));
	} // else tag array is empty
	return adinj_allowed_in_list($tags, $conditions, $mode, 'adinj_tag_slug');
}

function adinj_allowed_in_author($scope, $ops){
	$conditions = adinj_split_comma_list($ops[$scope.'_author_condition_entries']);
	if (empty($conditions)) return true;
	
	$mode = $ops[$scope.'_author_condition_mode'];
	
	if (!in_the_loop() && adinj_mode_only_show_in($mode) && !(is_single() || is_page() || is_author())){
		return false;
	}
	
	if (in_the_loop()&& adinj_mode_only_show_in($mode) && !(is_single() || is_page() || is_home() || is_author())){
		return false;
	}
	
	$user = array();
	if (is_single() || is_page() || is_home()){
		$data = get_the_author_meta('user_login'); // works in and out of the loop
		$user[] = $data; //need to make it into array
	} else if (is_author()){
		$curauth = get_userdata(get_query_var('author'));
		$user[] = $curauth->user_login;
	} // else author array is empty
	
	return adinj_allowed_in_list($user, $conditions, $mode, 'adinj_author_data');
}

function adinj_allowed_in_id($scope, $ops){
	$conditions = adinj_split_comma_list($ops[$scope.'_id_condition_entries']);
	if (empty($conditions)) return true;
	
	$postid = -1;
	if (in_the_loop()){
		global $post;
		$postid = $post->ID;
	} else {
		global $wp_query;
		$postid = $wp_query->post->ID;
	}
	
	$mode = $ops[$scope.'_id_condition_mode'];
	return adinj_allowed_in_list(array($postid), $conditions, $mode, 'adinj_post_id');
}

//function parameters
function adinj_category_nicename($category){ return $category->category_nicename; }
function adinj_tag_slug($tag){ return $tag->slug; }
function adinj_author_data($data){ return $data; }
function adinj_post_id($data){ return $data; }

function adinj_split_comma_list($list){
	$list = preg_split("/[,]+/", $list, -1, PREG_SPLIT_NO_EMPTY);
	array_walk($list, 'adinj_trim_value');
	return $list;
}

function adinj_trim_value(&$value){ 
    $value = trim($value); 
}


function adinj_footer_hook(){
	if (is_feed()) return; // TODO feed specific ads
	if (adinj_num_footer_ads_to_insert() <= 0) return;
	echo adinj_ad_code_footer();
}

function adinj_debug_on(){
	return adinj_ticked('debug_mode');
}

function adinj_content_hook($content){
	if (is_feed()) return $content; // TODO feed specific ads
	if (!in_the_loop()) return $content; // Don't insert ads into meta description tags
	$ops = adinj_options();
	if(empty($ops)){
		return $content;
	}
	
	$debug_on = adinj_debug_on();
	$debug = "";
	if ($debug_on) echo "<!--adinj Ad Injection debug mode on-->";
	
	adinj_upgrade_db_if_necessary();

	global $adinj_total_random_ads_used, $adinj_total_top_ads_used, $adinj_total_bottom_ads_used;
	if(!is_archive() && (is_page() || is_single())){
		// On single page the_content may be called more than once - e.g. for
		// description meta tag and for content.
		$adinj_total_top_ads_used = 0;
		$adinj_total_random_ads_used = 0;
		$adinj_total_bottom_ads_used = 0;
	}

	$reason = adinj_ads_completely_disabled_from_page('in-content', $content);
	if ($reason !== false){
		return adinj($content, $reason);
	}
	
	if ($debug_on && adinj_direct_mode()){
		$showads = adshow_show_adverts();
		if ($showads !== true){
			$debug .= "\nNOADS: ad blocked at run time reason=$showads";
		}
	}

	$topad = adinj_ad_code_top();
	if (empty($topad)) { if ($debug_on) $debug .= "\nNo top ad defined in any of the ad code boxes"; }
	$randomad = adinj_ad_code_random();
	if (empty($randomad)) { if ($debug_on) $debug .= "\nNo random ad defined in any of the ad code boxes"; }
	$bottomad = adinj_ad_code_bottom();
	if (empty($bottomad)) { if ($debug_on) $debug .= "\nNo bottom ad defined in any of the ad code boxes"; }
	
	if (empty($topad) && empty($randomad) && empty($bottomad)){
		return adinj($content, "None of top, random or bottom ads are defined.");
	}
	
	$ad_include = "";
	if (adinj_mfunc_mode()){
		$ad_include = adinj_ad_code_include();
	}
	
	# Ad sandwich mode
	if(is_page() || is_single()){
		if(stripos($content, "<!--adsandwich-->") !== false) return adinj($ad_include.$topad.$content.$bottomad, "Ads=sandwich" . $debug);
		if(stripos($content, "<!--adfooter-->") !== false) return adinj($content.$ad_include.$bottomad, "Ads=footer" . $debug);
	}
	
	# Get content length for ad placement settings
	$rawlength = strlen($content);
	$length = 0;
	if ($ops['content_length_unit'] == 'all'){
		$length = $rawlength;
	} else if ($ops['content_length_unit'] == 'viewable'){
		$length = strlen(strip_tags($content));
	} else {
		$length = str_word_count_utf8(strip_tags($content));
	}
	
	# Record original paragraph positions
	$original_paragraph_positions = array();
	$prevpos = -1;
	while(($prevpos = stripos($content, ADINJ_PARA, $prevpos+1)) !== false){
		
		$valid = true;
		if (adinj_ticked('exclude_ads_from_block_tags')){
			$next_blockquote_open = adinj_stripos($content, '<blockquote', $prevpos);
			$next_blockquote_close = adinj_stripos($content, '</blockquote>', $prevpos);
			$next_pre_open = adinj_stripos($content, '<pre', $prevpos);
			$next_pre_close = adinj_stripos($content, '</pre>', $prevpos);
			$valid = (($next_blockquote_open == $next_blockquote_close) || 
						($next_blockquote_open > $prevpos && $next_blockquote_open <= $next_blockquote_close)) &&
						(($next_pre_open == $next_pre_close) || 
						($next_pre_open > $prevpos && $next_pre_open <= $next_pre_close));
			if (!$valid) continue;
		}
		
		if (adinj_ticked('exclude_ads_from_div_tags')){
			$next_open = adinj_stripos($content, '<div', $prevpos);
			$next_close = adinj_stripos($content, '</div>', $prevpos);
			$valid = (($next_open == $next_close) || 
						($next_open > $prevpos && $next_open <= $next_close));
			if (!$valid) continue;
		}
		
		
		if (adinj_ticked('exclude_ads_from_list_tags')){
			$next_open = adinj_stripos($content, '<ol', $prevpos);
			$next_close = adinj_stripos($content, '</ol>', $prevpos);
			$valid = (($next_open == $next_close) || 
						($next_open > $prevpos && $next_open <= $next_close));
			if (!$valid) continue;
		}
		
		if (adinj_ticked('exclude_ads_from_list_tags')){
			$next_open = adinj_stripos($content, '<ul', $prevpos);
			$next_close = adinj_stripos($content, '</ul>', $prevpos);
			$valid = (($next_open == $next_close) || 
						($next_open > $prevpos && $next_open <= $next_close));
			if (!$valid) continue;
		}
		
		if (adinj_ticked('exclude_ads_from_form_tags')){
			$next_open = adinj_stripos($content, '<form', $prevpos);
			$next_close = adinj_stripos($content, '</form>', $prevpos);
			$valid = (($next_open == $next_close) || 
						($next_open > $prevpos && $next_open <= $next_close));
			if (!$valid) continue;
		}
		
		if (adinj_ticked('exclude_ads_from_table_tags')){
			$next_open = adinj_stripos($content, '<table', $prevpos);
			$next_close = adinj_stripos($content, '</table>', $prevpos);
			$valid = (($next_open == $next_close) || 
						($next_open > $prevpos && $next_open <= $next_close));
			if (!$valid) continue;
		}
		
		if($valid){
			$next_exclude_open = adinj_stripos($content, '<!--adinj_exclude_start-->', $prevpos);
			$next_exclude_close = adinj_stripos($content, '<!--adinj_exclude_end-->', $prevpos);
			 if (($next_exclude_open == $next_exclude_close) || 
					($next_exclude_open > $prevpos && $next_exclude_open <= $next_exclude_close)){
				$original_paragraph_positions[] = $prevpos + strlen(ADINJ_PARA);
			}
		}
	}
	$paracount = count($original_paragraph_positions);
	if ($debug_on) $debug .= "\nContent length=$length (".$ops['content_length_unit'].") Raw character length=$rawlength Paragraph count=$paracount";
	if($paracount == 0) {
		if ($debug_on) $debug .= "\nWarning: No paragraph (&lt;/p&gt;) tags found.\n
	Your theme or one of your plugins may have changed the priority of the wpautop\n
	filter so it is getting run later than expected (after Ad Injection has run).\n
	You can try modifying the priority setting of Ad Injection's wp_content filter\n
	from the settings screen.\n
	Try 100, or if that fails 200!";
	}
	
	# Positions to insert ads
	$top_ad_paragraph = -1;
	$random_ad_paragraphs = array();
	$bottom_ad_paragraph = -1;
	
	$fixed_top = stripos($content, "<!--topad-->");
	$fixed_random = stripos($content, "<!--randomad-->");
	$fixed_bottom = stripos($content, "<!--bottomad-->");
	
	# Find top ad position
	if ($fixed_top === false){
		if (adinj_num_top_ads_to_insert($length, $debug) > 0){
			$top_ad_paragraph = adinj_get_paragraph('top', $content, $original_paragraph_positions, $debug);
		}
	}
	if ($debug_on) $debug .= "\nTop ad paragraph: $top_ad_paragraph";
	
	# Find bottom ad position
	if ($fixed_bottom === false){
		if (adinj_num_bottom_ads_to_insert($length, $debug) > 0){
			$bottom_ad_paragraph = adinj_get_paragraph('bottom', $content, $original_paragraph_positions, $debug);
		}
		if ($bottom_ad_paragraph !== -1){
			$bottom_ad_paragraph = $paracount - $bottom_ad_paragraph;
		}
	}
	if ($debug_on) $debug .= "\nBottom ad paragraph: $bottom_ad_paragraph";
	
	# Find random ad positions
	if ($fixed_random === false){
		$random_ad_paragraphs = adinj_get_random_paragraphs($content, $length, $original_paragraph_positions, $debug);
		$random_ads_to_insert_count = sizeof($random_ad_paragraphs);
		if ($random_ads_to_insert_count == 0){
			if ($debug_on) $debug .= "\nWarning: No random ad injection positions";
		}
	}
	
	# Insert the adverts into the content. Scan through the paragraph list in reverse order.
	$adpos = count($random_ad_paragraphs);
	$bottomadsetting = $ops['bottom_ad_position'];
	for ($i=$paracount; $i>0; --$i){
		if ($i === $bottom_ad_paragraph && $bottomadsetting != 0){
			$content = substr_replace($content, $bottomad, $original_paragraph_positions[$i-1], 0);
			++$adinj_total_bottom_ads_used;
		}
		for ($j=$adpos-1; $j>=0; --$j){
			$rnd = $random_ad_paragraphs[$j];
			if ($i==$rnd){
				if (adinj_ticked('rnd_reselect_ad_per_position_in_post')){
					$randomad = adinj_ad_code_random();
				}
				$content = substr_replace($content, $randomad, $original_paragraph_positions[$rnd-1], 0);
				++$adinj_total_random_ads_used;
				--$adpos;
			} else {
				break;
			}
		}
		if ($i === $top_ad_paragraph){
			$content = substr_replace($content, $topad, $original_paragraph_positions[$i-1], 0);
			++$adinj_total_top_ads_used;
		}
	}
	if ($top_ad_paragraph === 0){ // default is special case
		$content = $topad.$content;
		++$adinj_total_top_ads_used;
	}
	if ($bottom_ad_paragraph !== -1 && $bottomadsetting == 0){ // default is special case as themes can't be trusted to close the final paragraph
		$content = $content.$bottomad;
		++$adinj_total_bottom_ads_used;
	}
	
	if($fixed_top) {
		adinj_insert_fixed_ad($content, $topad, 'top', $adinj_total_top_ads_used, $debug);
	}
	if($fixed_random) {
		adinj_insert_fixed_ad($content, $randomad, 'random', $adinj_total_random_ads_used, $debug);
	}
	if($fixed_bottom) {
		adinj_insert_fixed_ad($content, $bottomad, 'bottom', $adinj_total_bottom_ads_used, $debug);
	}
	
	$content = $ad_include.$content;
	
	return adinj($content, "Ad Injection in-content injections complete!" . $debug);
}

function adinj_stripos($haystack, $needle, $offset=0){
	$pos = stripos($haystack, $needle, $offset);
	if ($pos === false) $pos = -1;
	return $pos;
}

function adinj_insert_fixed_ad(&$content, $ad, $adname, &$counter, &$debug){
	if (!adinj_excluded_by_tick_box($adname.'_')){
		$tagname = $adname.'ad';
		if (adinj_debug_on()) $debug .= "\n$adname ad position(s) fixed by '$tagname' tag";
		$counter += substr_count($content, "<!--$tagname-->");
		$content = str_replace("<!--$tagname-->", $ad, $content);
	} else {
		if (adinj_debug_on()) $debug .= "\nFixed $adname ad excluded by tick box";
	}
}

// length here can be raw characters, displayable, or number of words
// returns array of paragraph positions to insert rnd ads into
function adinj_get_random_paragraphs($content, $length, $original_paragraph_positions, &$debug){
	$ops = adinj_options();
	$debug_on = adinj_debug_on();
	$random_ad_paragraphs = array();
	$random_start_paragraph = 0;
	$random_end_paragraph = 0;
	adinj_get_random_ad_start_end_paragraph($content, $original_paragraph_positions, $random_start_paragraph, $random_end_paragraph, $debug);
	if ($debug_on) $debug .= "\n1st Injected random ads range starts at: $random_start_paragraph, and ends at: $random_end_paragraph";
	
	$paracount = count($original_paragraph_positions);
	$random_end_paragraph = min($random_end_paragraph, $paracount);
	if (!adinj_ticked('rnd_allow_ads_on_last_paragraph')){
		if ($random_end_paragraph == $paracount) --$random_end_paragraph;
		if ($random_end_paragraph == 0){
			if ($debug_on) $debug .= "\nNo random ads: no potential inj positions after removing last paragraph position";
			return;
		}
	}
	
	if ($random_start_paragraph <= 0 || $random_end_paragraph <= 0 ||
		$random_end_paragraph - $random_start_paragraph < 0){
		if ($debug_on) $debug .= "\nWarning: No paragraphs: random_start_paragraph:$random_start_paragraph random_end_paragraph:$random_end_paragraph";
		return array();
	}
	
	if ($debug_on) $debug .= "\n2nd Injected random ads range starts at: $random_start_paragraph, and ends at: $random_end_paragraph";
	
	$potential_random_ad_paragraphs = range($random_start_paragraph, $random_end_paragraph);
	if ($debug_on) $debug .= "\npotential_random_ad_paragraphs:".sizeof($potential_random_ad_paragraphs);
	if (sizeof($potential_random_ad_paragraphs) == 0){
		if ($debug_on) $debug .= "\nNo random ads: no potential inj positions found in content";
		return array();
	}
	
	# Checks to see if we can inject random ads
	$requested_num_rand_ads_to_insert = adinj_num_rand_ads_to_insert($length, $debug);
	if ($debug_on) $debug .= "\nrequested_num_rand_ads_to_insert:$requested_num_rand_ads_to_insert";
	if ($requested_num_rand_ads_to_insert <= 0) {
		if ($debug_on) $debug .= "\nNo random ads enabled on this post";
		return array();
	}
	$num_rand_ads_to_insert = $requested_num_rand_ads_to_insert;
	
	# We have to put the first ad at the first position we already selected unless the first ad can start 'anywhere'
	if ($ops['random_ads_start_mode'] != 'anywhere' && $ops['random_ads_start_mode'] != 'after'){
		$random_ad_paragraphs[] = array_shift($potential_random_ad_paragraphs);
		--$num_rand_ads_to_insert;
	}
	
	# Pick the correct number of random injection points
	if (sizeof($potential_random_ad_paragraphs) > 0 && $num_rand_ads_to_insert > 0){
		if (!adinj_ticked('multiple_ads_at_same_position')){
			// Each ad is inserted into a unique position
			if (sizeof($potential_random_ad_paragraphs) < $num_rand_ads_to_insert){
				$debug .= "\nNum random ads requested=$requested_num_rand_ads_to_insert. But restricted to ". (sizeof($potential_random_ad_paragraphs) + sizeof($random_ad_paragraphs)) . " due to limited injection points.";
				$num_rand_ads_to_insert = sizeof($potential_random_ad_paragraphs);
			}
			$rand_positions = array_rand(array_flip($potential_random_ad_paragraphs), $num_rand_ads_to_insert);
			if ($num_rand_ads_to_insert == 1){
				// Add the single value to the array
				$random_ad_paragraphs[] = $rand_positions;
			} else {
				// Merge the values with the array
				$random_ad_paragraphs = array_merge($random_ad_paragraphs, $rand_positions);
			}
		} else {
			// Multiple ads may be inserted at the same position
			$injections = 0;
			while($injections++ < $num_rand_ads_to_insert){
				$rnd = array_rand($potential_random_ad_paragraphs);
				$random_ad_paragraphs[] = $potential_random_ad_paragraphs[$rnd];
			}
		}
	}

	# Sort positions
	sort($random_ad_paragraphs);
	
	if ($debug_on){
		$injected_list = '';
		foreach($random_ad_paragraphs as $pos){
			$injected_list .= "$pos ";
		}
		$debug .= "\nInjected ads at: $injected_list";
	}
	
	return $random_ad_paragraphs;
}

// for top/bottom ad
// returns valid paragraph or -1
// will return 0 if the position is 0
function adinj_get_paragraph($op, $content, $original_paragraph_positions, &$debug){ // op is top or bottom
	$ops = adinj_options();
	$position = $ops[$op.'_ad_position'];
	$paracount = count($original_paragraph_positions);
	$rawlength = strlen($content);
	$ad_paragraph = 0;
	if ($position != 0){
		if ($ops[$op.'_ad_position_unit'] == 'paragraph'){
			if ($paracount < $position){
				$ad_paragraph = -1;
				if (adinj_debug_on()) $debug .= "\nPost too short for $op ad paracount($paracount) < para-position($position)";
			} else {
				$ad_paragraph = $position;
			}
		} else { //unit==character
			if ($rawlength < $position){
				$ad_paragraph = -1;
				if (adinj_debug_on()) $debug .= "\nPost too short for $op ad rawlength($rawlength) < char-position($position)";
			} else {
				$ad_paragraph = adinj_get_paragraph_from_position($content, $position, $original_paragraph_positions, 1);
			}
		}
	}
	return (int)$ad_paragraph;
}

// Return a valid paragraph or -1
function adinj_get_paragraph_from_position($content, $offset, $original_paragraph_positions, $adjust=0, $mode='fromstart'){
	$paracount = count($original_paragraph_positions);
	if ($paracount == 0) return -1;
	$contentlength = strlen($content);
	if ($offset > $contentlength) return -1;
	if ($mode == 'fromend') $offset = $contentlength - $offset;
	$position = stripos($content, ADINJ_PARA, $offset);
	if ($position === false) return -1;
	$position += strlen(ADINJ_PARA);
	for ($i=0; $i<$paracount; ++$i){
		if ($position <= $original_paragraph_positions[$i]) {
			$paragraph = $i+$adjust;
			return min($paragraph, $paracount);
		}
	}
	return -1;
}

// Can return 0 as the end paragraph - meaning no random ads TODO check
function adinj_get_random_ad_start_end_paragraph($content, $original_paragraph_positions, &$start, &$end, &$debug){
	$ops = adinj_options();
	$debug_on = adinj_debug_on();
	
	$paracount = count($original_paragraph_positions);
	if ($paracount == 0){
		$start = -1;
		$end = -1;
		return;
	}

	// initialise to 'anywhere' max range
	$start = 1;
	$end = $paracount;
	
	// todo docs: should include these tags on same line as paragraph or can affect paragraph count
	$tagposition = stripos($content, '<!--adstart-->');
	if ($tagposition === false) $tagposition = stripos($content, '<!--adsensestart-->');
	if ($tagposition === false){
		$start = adinj_get_random_ad_paragraph($content, $original_paragraph_positions, 'start', $start, $debug);
	} else {
		$start = adinj_get_paragraph_from_position($content, $tagposition, $original_paragraph_positions, 1);
		if ($debug_on) $debug .= "\nFound hardcoded start tag. Starting ads at paragraph $start";
	}
	
	$tagposition = stripos($content, '<!--adend-->');
	if ($tagposition === false) $tagposition = stripos($content, '<!--adsenseend-->');
	if ($tagposition === false){
		$end = adinj_get_random_ad_paragraph($content, $original_paragraph_positions, 'end', $end, $debug);
	} else {
		$end = adinj_get_paragraph_from_position($content, $tagposition, $original_paragraph_positions, 0);
		if ($debug_on) $debug .= "\nFound hardcoded end tag. Ending ads at paragraph $end";
	}
}

// Returns -1 if paragraph can't be located
function adinj_get_random_ad_paragraph($content, $original_paragraph_positions, $opname, $default, &$debug){
	$ops = adinj_options();
	$mode = $ops['random_ads_'.$opname.'_mode'];
	$paracount = count($original_paragraph_positions);
	$rawlength = strlen($content);
	$paragraph = -1;
	
	if ($mode == 'anywhere'){
		$paragraph = $default;
	} else if ($mode == 'at' || $mode == 'after'){
		$position = $ops['random_ads_'.$opname.'_at'];
		$unit = $ops['random_ads_'.$opname.'_unit'];
		$direction = $ops['random_ads_'.$opname.'_direction'];
		if ($unit == 'character'){
			$adjust = ($direction == 'fromend') ? 0 : 1;
			$paragraph = adinj_get_paragraph_from_position($content, $position, $original_paragraph_positions, $adjust, $direction);
			if ($opname == 'end' && $direction == 'fromstart' && $paragraph == -1){
				$paragraph = $paracount;
			}
		} else {
			// paragraph is same as value in UI
			$paragraph = $position;
			if ($direction == 'fromend'){
				$paragraph = $paracount - $paragraph;
			}
		}
	} else if ($mode == 'middleback'){
		$pos = round(($rawlength / 2), 0);
		$paragraph = adinj_get_paragraph_from_position($content, $pos, $original_paragraph_positions, 0);
	} else if ($mode == 'middleforward'){
		$pos = round(($rawlength / 2), 0);
		$paragraph = adinj_get_paragraph_from_position($content, $pos, $original_paragraph_positions, 1);
	} else if ($mode == 'middleparaback'){
		$val = ($paracount % 2 == 0) ? 0 : 0.5;
		$paragraph = intval(round((($paracount-$val) / 2), 0)); // todo test with 0 and 1 paragraphs
	} else if ($mode == 'middleparaforward'){
		$paragraph = intval(round(($paracount / 2), 0));
	} else if ($mode == 'twothirds'){
		$pos = round(($rawlength * 0.66), 0);
		$paragraph = adinj_get_paragraph_from_position($content, $pos, $original_paragraph_positions, 1);
	}
	if ($paragraph == -1){
		if ($debug_on) $debug .= "\nParagraph not found - mode:$randomaftermode op:$opname";
	}
	return $paragraph;
}

//http://php.net/manual/en/function.str-word-count.php
define("WORD_COUNT_MASK", "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u");
function str_word_count_utf8($str){
	if (@preg_match('/\pL/u', 'a') == 1) { // check if utf8 support is compile in
		return preg_match_all(WORD_COUNT_MASK, $str, $matches);
	} else {
		return str_word_count($str);
	}
}

function adinj_ads_filtered_out($adname, &$debug){
	$ops = adinj_options();
	if (!adinj_allowed_in_category($adname, $ops)){
		$debug .= "\n$adname ad filtered out by categories";
		return true;
	}
	if (!adinj_allowed_in_tag($adname, $ops)){
		$debug .= "\n$adname ad filtered out by tags";
		return true;
	}
	if (!adinj_allowed_in_author($adname, $ops)){
		$debug .= "\n$adname ad filtered out by authors";
		return true;
	}
	if (!adinj_allowed_in_id($adname, $ops)){
		$debug .= "\n$adname ad filtered out by ids";
		return true;
	}
	return false;
}

function adinj_get_current_page_type_prefix(){
	if (is_home()) return 'home_';
	if (is_archive()) return 'archive_';
	return '';
}

function adinj_num_top_ads_to_insert($content_length, &$debug){
	if (adinj_excluded_by_tick_box('top_')) return 0;
	$ops = adinj_options();
	$prefix = adinj_get_current_page_type_prefix();
	$max_num_ads_to_insert = 0;
	if (is_single() || is_page()){
		$max_num_ads_to_insert = 1;
	} else {
		global $adinj_total_top_ads_used;
		$max_num_ads_to_insert = $ops[$prefix.'max_num_top_ads_per_page'] - $adinj_total_top_ads_used;
	}
	if ($max_num_ads_to_insert <= 0) return 0;

	if (adinj_ads_filtered_out('top', $debug)) return 0;
	
	$val = $ops[$prefix.'top_ad_if_longer_than'];
	if (adinj_not_set($val) || adinj_true_if($content_length, '>', $val)){
		return 1;
	}
	$debug .= "\nNo top ad because post length < $val";
	return 0;
}

function adinj_num_bottom_ads_to_insert($content_length, &$debug){
	if (adinj_excluded_by_tick_box('bottom_')) return 0;
	$ops = adinj_options();
	$prefix = adinj_get_current_page_type_prefix();
	$max_num_ads_to_insert = 0;
	if (is_single() || is_page()){
		$max_num_ads_to_insert = 1;
	} else {
		global $adinj_total_bottom_ads_used;
		$max_num_ads_to_insert = $ops[$prefix.'max_num_bottom_ads_per_page'] - $adinj_total_bottom_ads_used;
	}
	if ($max_num_ads_to_insert <= 0) return 0;
	
	if (adinj_ads_filtered_out('bottom', $debug)) return 0;
	
	$val = $ops[$prefix.'bottom_ad_if_longer_than'];
	if (adinj_not_set($val) || adinj_true_if($content_length, '>', $val)){
		return 1;
	}
	$debug .= "\nNo bottom ad because post length < $val";
	return 0;
}

function adinj_num_rand_ads_to_insert($content_length, &$debug){
	if (adinj_excluded_by_tick_box('random_')) return 0;
	global $adinj_total_random_ads_used; // a page can be more than one post
	$ops = adinj_options();
	$max_ads_in_post = 0;
	$prefix = adinj_get_current_page_type_prefix();
	if (is_single() || is_page()){
		$max_num_rand_ads_to_insert = $ops['max_num_of_ads'] - $adinj_total_random_ads_used;
		$max_ads_in_post = $max_num_rand_ads_to_insert;
	} else if (is_home() || is_archive()){
		$max_num_rand_ads_to_insert = $ops[$prefix.'max_num_random_ads_per_page'] - $adinj_total_random_ads_used;
		$max_ads_in_post = $ops[$prefix.'max_num_random_ads_per_post'];
	} else {
		$debug .= "\nNo random ads because not correct page type";
		return 0;
	}
	
	$max_num_rand_ads_to_insert = min($max_num_rand_ads_to_insert, $max_ads_in_post);

	if ($max_num_rand_ads_to_insert <= 0) {
		$debug .= "\nNo random ads to insert in this post";
		return 0;
	}
	
	if (adinj_ads_filtered_out('random', $debug)) return 0;

	$length = $content_length;
	$conditionlength = $ops[$prefix.'no_random_ads_if_shorter_than'];
	if (!adinj_rule_disabled($conditionlength) && adinj_true_if($length, '<', $conditionlength)){
		$debug .= "\nNo random ads because post length < $conditionlength";
		return 0;
	}
	$conditionlength = $ops[$prefix.'one_ad_if_shorter_than'];
	if (!adinj_rule_disabled($conditionlength) && adinj_true_if($length, '<', $conditionlength)){
		$debug .= "\nOnly 1 random ad because post length < $conditionlength";
		return 1;
	}
	$conditionlength = $ops[$prefix.'two_ads_if_shorter_than'];
	if (!adinj_rule_disabled($conditionlength) && adinj_true_if($length, '<', $conditionlength)){
		$debug .= "\nLimit on random ads because post length < $conditionlength";
		return min(2, $max_num_rand_ads_to_insert);
	}
	$conditionlength = $ops[$prefix.'three_ads_if_shorter_than'];
	if (!adinj_rule_disabled($conditionlength) && adinj_true_if($length, '<', $conditionlength)){
		$debug .= "\nLimit on random ads because post length < $conditionlength";
		return min(3, $max_num_rand_ads_to_insert);
	}
	return $max_num_rand_ads_to_insert;
}

function adinj_num_footer_ads_to_insert(){
	if (adinj_excluded_by_tick_box('footer_')) return 0;
	$reason = adinj_ads_completely_disabled_from_page('footer', $content);
	if ($reason !== false){
		return 0;
	}
	$ops = adinj_options();
	if (adinj_ads_filtered_out('footer', $debug)) return 0;
	return 1;
}

function adinj_true_if($rule_value, $condition, $content_length){
	if ($condition == '>'){
		return ($rule_value >= $content_length);
	} else if ($condition == '<'){
		return ($rule_value <= $content_length);
	} else {
		die("adinj_true_if bad condition: $condition");
	}
}

function adinj_direct_mode(){
	$ops = adinj_options();
	return ($ops['ad_insertion_mode'] != 'mfunc');
}

function adinj_mfunc_mode(){
	$ops = adinj_options();
	return ($ops['ad_insertion_mode'] == 'mfunc');
}

function adinj_rule_disabled($value){
	return "$value" == ADINJ_RULE_DISABLED || "$value" == ADINJ_DISABLED || "$value" == 'd' || "$value" == '';
}

function adinj_not_set($value){
	return adinj_rule_disabled($value);
}

function adinj_ticked($option, $ops=array()){
	if (empty($ops)) $ops = adinj_options();
	if (!empty($ops[$option]) && $ops[$option] != 'off') return 'checked="checked"';
	return false;
}

function adinj_upgrade_db_if_necessary(){
	$cached_options = adinj_options();
	if(empty($cached_options)){
		// 1st Install.
		require_once(ADINJ_PATH . '/ad-injection-admin.php');
		adinj_install_db();
		return;
	}

	$cached_dbversion = adinj_db_version($cached_options);
	
	if (ADINJ_DB_VERSION != $cached_dbversion){
		require_once(ADINJ_PATH . '/ad-injection-admin.php');
		adinj_upgrade_db();
	}
}

// Main options table and widgets could have different db version at the same
// time depending on when the settings were last saved
function adinj_db_version($ops){
	if (!array_key_exists('db_version', $ops)){
		return 1;
	} else {
		return $ops['db_version'];
	}
}

// template ads
function adinj_print_ad($adname=''){
	$reason = adinj_ads_completely_disabled_from_page('template', "");
	if ($reason !== false){
		return;
	}
	if (adinj_excluded_by_tick_box('template_')) return;
	$dummydebug = '';
	if (adinj_ads_filtered_out('template', $dummydebug)) return;
	if ($adname == 'random'){
		echo adinj_ad_code_random();
	} else if ($adname == 'top'){
		echo adinj_ad_code_top();
	} else if ($adname == 'bottom'){
		echo adinj_ad_code_bottom();
	} else if ($adname == 'footer'){
		echo adinj_ad_code_footer();
	} else if (preg_match("/.+\.txt/i", $adname)){
		adshow_display_ad_file_v2($adname);
	}
}

// Widget support
require_once('ad-injection-widget.php');
add_action('widgets_init', 'adinj_widgets_init');
function adinj_widgets_init() {
	register_widget('Ad_Injection_Widget');
}

adinj_setup_hooks_and_filters();
function adinj_setup_hooks_and_filters(){
	// activate
	register_activation_hook(__FILE__, 'adinj_activate_hook');
	// Content injection
	add_action('wp_enqueue_scripts', 'adinj_addsevjs_hook');
	$setting = adinj_option('the_content_filter_priority');
	$priority = isset($setting) ? $setting : 10; // 10 is the WordPress default filter priority
	add_filter('the_content', 'adinj_content_hook', $priority);
	add_action('wp_footer', 'adinj_footer_hook');
	add_action('wp_footer', 'adinj_print_referrers_hook');
}

?>