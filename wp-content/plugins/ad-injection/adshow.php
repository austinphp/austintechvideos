<?php
/*
Part of the Ad Injection plugin for WordPress
http://www.reviewmylife.co.uk/
*/

// TODO set cookies here as well so blocking / showing works without JS

if (!defined('ADINJ_NO_CONFIG_FILE')){
$adinj_dir = dirname(__FILE__);
if (file_exists($adinj_dir.'/../../ad-injection-config.php')) {
	include_once($adinj_dir.'/../../ad-injection-config.php');
} else {
	echo '<!--ADINJ DEBUG: ad-injection-config.php could not be found. Re-save your settings to re-generate it.-->';
}
}

//////////////////////////////////////////////////////////////////////////////

if (!function_exists('adshow_functions_exist')){
// Used to downgrade fatal errors to printed errors to make debugging easier
// and so that a problem doesn't disable the whole website. 
// TODO can't just add new checks to here as Ad Injection might now get run before config
// file is regenerated - e.g. if cached versions of pages are served
function adshow_functions_exist(){
	if (!defined('ADINJ_NO_CONFIG_FILE')){
		if (!adshow_functions_exist_impl('adinj_config_allow_referrers')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_allowed_referrers_list')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_block_ips')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_blocked_ips_list')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_block_referrers')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_blocked_referrers_list')){ return false; }
		//if (!adshow_functions_exist_impl('adinj_config_block_hours')){ return false; }
		//if (!adshow_functions_exist_impl('adinj_config_block_after_ad_click')){ return false; }
		if (!adshow_functions_exist_impl('adinj_config_debug_mode')){ return false; }
	}
	return true;
}
function adshow_functions_exist_impl($function){
	if (!function_exists($function)){
		echo "<!--ADINJ DEBUG:".__FILE__." Error: $function does not exist. Might be because config file is missing or out of date. Re-save settings to fix. -->";
		return false;
	}
	return true;
}
}

if (defined('ADINJ_NO_CONFIG_FILE')){
function adinj_config_allow_referrers() { 
	return adinj_ticked('sevisitors_only');
}

function adinj_config_allowed_referrers_list() {
	$list = adinj_quote_list('ad_referrers');
	return preg_split("/[,'\s]+/", $list, -1, PREG_SPLIT_NO_EMPTY);
}

function adinj_config_block_ips() {
	return adinj_ticked('block_ips');
}

function adinj_config_blocked_ips_list() { 
	$list = adinj_quote_list('blocked_ips');
	return preg_split("/[,'\s]+/", $list, -1, PREG_SPLIT_NO_EMPTY);
}

function adinj_config_block_referrers() {
	return adinj_ticked('block_keywords');
}

function adinj_config_blocked_referrers_list() { 
	$list = adinj_quote_list('blocked_keywords');
	return preg_split("/[,'\s]+/", $list, -1, PREG_SPLIT_NO_EMPTY);
}

function adinj_config_block_hours() {  // if blocked by referrer
	$ops = adinj_options();
	return $ops['block_ads_for_hours'];
}

function adinj_config_block_after_ad_click() {
	return false;
	//return adinj_ticked('block_after_ad_click'); //TODO maybe this should be checking something else
}

function adinj_config_debug_mode() { 
	return adinj_ticked('debug_mode');
}
}

//////////////////////////////////////////////////////////////////////////////

if (!function_exists('adshow_display_ad_file_v2')){
function adshow_display_ad_file_v2($adfiles, $adfiles_frequency = array(), $options = array(), $altfiles = array(), $altfiles_frequency = array()){
	if (!adshow_functions_exist()){ return false; }
	if (adinj_config_debug_mode()){	echo "<!--ADINJ DEBUG: adshow_display_ad_file() quantity=".sizeof($adfiles)."-->\n"; }
	
	if (empty($adfiles) && empty($altfiles)){
		echo "<!--ADINJ DEBUG: Error: adfiles and altfiles are empty-->\n";
		return false;
	}
	
	$adfile = "";
	
	$showads = adshow_show_adverts();
	if ($showads !== true){
		if (adinj_config_debug_mode()){	echo "<!--ADINJ DEBUG: ad blocked at run time reason=$showads-->\n"; }
		$alt_content_file = adshow_pick_value($altfiles, $altfiles_frequency);
		if (!empty($alt_content_file)){
			if (adinj_config_debug_mode()){	echo "<!--ADINJ DEBUG: alt content file defined:$alt_content_file-->\n"; }
			$adfile = $alt_content_file;
		} else {
			if (adinj_config_debug_mode()){	echo "<!--ADINJ DEBUG: no alt content file defined-->\n"; }
			return false;
		}
	}
	
	if (empty($adfile)){
		$adfile = adshow_pick_value($adfiles, $adfiles_frequency);
	}
	
	if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: adshow_display_ad_file($adfile)-->\n";	}
	
	$plugin_dir = dirname(__FILE__);
	
	$ad_path = dirname($plugin_dir).'/ad-injection-data/'.$adfile;
	if (file_exists($ad_path)){
		adshow_display_ad_full_path_v2($ad_path, $options);
		return;
	}
	echo "
<!--ADINJ DEBUG: could not read ad: $ad_path
If you have just upgraded you may need to re-save your ads to regenerate the ad files.
-->";
}
}

if (!function_exists('adshow_pick_value')){
function adshow_pick_value($values, $frequency){
	if (empty($values)){
		return "";
	}
	if (!is_array($values)){
		// single value passed in
		return $values;
	}
	$val = "";

	// values is an array
	if (empty($frequency)){
		// each value has an equal chance of being picked
		$val = array_rand(array_flip($values));
	} else {
		// each value has its own probability of being picked
		$count = sizeof($values);
		if ($count != sizeof($frequency)){
			echo "<!--ADINJ DEBUG: size of arrays don't match ".$count."!=".sizeof($frequency)."-->\n";
			return "";
		}
		$total = array_sum($frequency);
		$rand = rand(0, $total);
		$cumulative = 0;
		for ($i=0; $i<$count; ++$i){
			$cumulative += $frequency[$i];
			if ($rand <= $cumulative){
				$val = $values[$i];
				if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: picked value at position $i: $val-->\n";	}
				break;
			}
		}
	}
	return $val;
}
}

if (!function_exists('adshow_display_ad_full_path_v2')){
function adshow_display_ad_full_path_v2($ad_path, $ops = array()){
	if (!adshow_functions_exist()){ return false; }

	if (!file_exists($ad_path)){
		echo "<!--ADINJ DEBUG: ad file does not exist: $ad_path.\nIf you have just upgraded you may need to re-save your ads to regenerate the ad files.\n-->\n";
		return false;
	}

	$ad = file_get_contents($ad_path);
	if ($ad === false) echo "<!--ADINJ DEBUG: could not read ad from file: $ad_path-->\n";
	$ad = adshow_eval_php($ad);
	echo adshow_add_formatting($ad, $ops);
}
}

if (!function_exists('adshow_add_formatting')){
function adshow_add_formatting($ad, $ops = array()){
	if (strlen($ops['align']) > 0 ||
		strlen($ops['clear']) > 0 ||
		strlen($ops['margin_top']) > 0 ||
		strlen($ops['margin_bottom']) > 0 ||
		strlen($ops['padding_top']) > 0 ||
		strlen($ops['padding_bottom']) > 0) {
		$clear = "";
		$mtop = "";
		$mbottom = "";
		$ptop = "";
		$pbottom = "";
		if (strlen($ops['clear']) > 0) $clear="clear:" . $ops['clear'] . ";";
		if (strlen($ops['margin_top']) > 0) $mtop="margin-top:" . $ops['margin_top'] . "px;";
		if (strlen($ops['margin_bottom']) > 0) $mbottom="margin-bottom:" . $ops['margin_bottom'] . "px;";
		if (strlen($ops['padding_top']) > 0) $ptop="padding-top:" . $ops['padding_top'] . "px;";
		if (strlen($ops['padding_bottom']) > 0) $pbottom="padding-bottom:" . $ops['padding_bottom'] . "px;";
		$cssrules = $clear . $mtop . $mbottom . $ptop . $pbottom;
		
		if ($ops['align'] == 'rand lcr') $ops['align'] = array_rand(array_flip(array('left', 'center', 'right')));
		if ($ops['align'] == 'rand float lr') $ops['align'] = array_rand(array_flip(array('float left', 'float right')));
		if ($ops['align'] == 'rand all') $ops['align'] = array_rand(array_flip(array('left', 'center', 'right', 'float left', 'float right')));
		
		if ($ops['align'] == 'left'){
			$ad = "\n<div style='float:left;" . $cssrules . "'>$ad</div><br clear='all' />";
		} else if ($ops['align'] == 'center'){
			$ad = "\n<div style='" . $cssrules . "'><center>$ad</center></div>";
		} else if ($ops['align'] == 'right'){
			$ad = "\n<div style='float:right;" . $cssrules . "'>$ad</div><br clear='all' />";
		} else if ($ops['align'] == 'float left'){
			$ad = "\n<div style='float:left;" . $cssrules . "margin-right:5px;'>$ad</div>";
		} else if ($ops['align'] == 'float right'){
			$ad = "\n<div style='float:right;" . $cssrules . "margin-left:5px;'>$ad</div>";
		} else {
			$ad = "\n<div style='" . $cssrules . "'>$ad</div>";
		}
	}
	return $ad;
}
}

//////////////////////////////////////////////////////////////////////////////

if (!function_exists('adshow_show_adverts')){
function adshow_show_adverts(){
	if (!adshow_functions_exist()){ return false; }
	//echo 'ref:'.$_SERVER['HTTP_REFERER'];
	//if (adinj_config_block_after_ad_click() && adshow_clicked_ad()) return "click_blocked"; //TODO
	
	if ($_COOKIE["adlogblocked"]==1) {
		if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: no ads because adlogblocked cookie set-->\n"; }
		return "click_blocked";
	}
	
	if (adinj_config_block_ips() && adshow_blocked_ip()) return "blocked_ip";
	
	if ($_COOKIE["adinj"]==1) {
		if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: blocked check ignored because adinj cookie set-->\n"; }
		return true;
	}
	
	if ($_COOKIE["adinjblocked"]==1) {
		if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: no ads because adinjblocked cookie set-->\n"; }
		return "blocked_referrer";
	}
	
	if (adinj_config_block_referrers() && adshow_blocked_referrer()) return "blocked_referrer";
	if (adinj_config_block_referrers() && adshow_blocked_referrer()){
		if (!headers_sent()){
			setcookie('adinjblocked', '1', time()+adinj_config_block_hours()*3600, '/');
		}
		return "blocked_referrer";
	}
	
	if (adinj_config_allow_referrers() && !adshow_allowed_referrer()) return "not_an_allowed_referrer";
	
	//Set cookie
	if (!headers_sent()){
		setcookie('adinj', '1', time()+3600, '/');
	}
	return true;
}
}

// Redirect new config method to old config methods until the config file gets re-generated.
// TODO test!
if (!function_exists('adinj_config_allow_referrers') && function_exists('adinj_config_sevisitors_only')){ 
function adinj_config_allow_referrers() { return adinj_config_sevisitors_only(); }
}
if (!function_exists('adinj_config_allowed_referrers_list') && function_exists('adinj_config_search_engine_referrers')){ 
function adinj_config_allowed_referrers_list() { return adinj_config_search_engine_referrers(); }
}
//
if (!function_exists('adinj_config_block_referrers') && function_exists('adinj_config_block_keywords')){ 
function adinj_config_block_referrers() { return adinj_config_block_keywords(); }
}
if (!function_exists('adinj_config_blocked_referrers_list') && function_exists('adinj_config_blocked_keywords')){ 
function adinj_config_blocked_referrers_list() { return adinj_config_blocked_keywords(); }
}
//
if (!function_exists('adinj_config_blocked_ips_list') && function_exists('adinj_config_blocked_ips')){ 
function adinj_config_blocked_ips_list() { return adinj_config_blocked_ips(); }
}

if (!function_exists('adshow_allowed_referrer')){
function adshow_allowed_referrer(){
	if (!adshow_functions_exist()){ return false; }
	
	// return true if the visitor has recently come from a search engine
	// and has the adinj cookie set.
	if ($_COOKIE["adinj"]==1) {
		if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: adinj cookie set-->\n"; }
		return true;
	}
	
	$referrer = $_SERVER['HTTP_REFERER'];
	$allowedreferrers = adinj_config_allowed_referrers_list();
	foreach ($allowedreferrers as $allowed) {
		if (stripos($referrer, $allowed) !== false) {
			return true;
		}
	}
	return false;
}
}

if (!function_exists('adshow_blocked_referrer')){
function adshow_blocked_referrer(){
	if (!adshow_functions_exist()){ return false; }

	$referrer = $_SERVER['HTTP_REFERER'];
	if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: referrer=$referrer-->\n"; }

	$blocked = adinj_config_blocked_referrers_list();
	foreach ($blocked as $bl) {
		if (stripos($referrer, $bl) !== false) {
			if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: ads blocked - referrer contains $bl -->\n"; }
			return true;
		}
	}
	return false;
}
}

if (!function_exists('adshow_blocked_ip')){
function adshow_blocked_ip(){
	if (!adshow_functions_exist()){ return false; }

	$visitorIP = $_SERVER['REMOTE_ADDR'];
	return in_array($visitorIP, adinj_config_blocked_ips_list());
}
}

if (!function_exists('adshow_clicked_ad')){
function adshow_clicked_ad(){
	if (!adshow_functions_exist()){ return false; }

	if ($_COOKIE["adlogblocked"]==1) {
		if (adinj_config_debug_mode()){ echo "<!--ADINJ DEBUG: blocked because adlogblocked cookie set-->\n"; }
		return true;
	}
	return false;
}
}

// From: Exec-PHP plugin
if (!function_exists('adshow_eval_php')){
function adshow_eval_php($code)	{
	ob_start();
	$return = eval("?>$code<?php ");
	if ($return === false && function_exists('error_get_last') && ($error = error_get_last())){
		echo "<!--\nADINJ: Parse error in code\nType: " . $error['type'] . "\nMsg: " . $error['message'] . "\nFile: " . $error['file'] . "\nLine: " . $error['line']  . "\n-->";
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
}

//////////////////////////////////////////////////////////////////////////////

?>