<?php
/*
Part of the Ad Injection plugin for WordPress
http://www.reviewmylife.co.uk/
*/

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

// Database cleanup
delete_option('adinj_options');
// Seems that widget settings don't automatically get cleaned up when plugin
// uninstalled
delete_option('widget_adinj');

// Delete the configuration file
$adinj_dir = dirname(__FILE__);
if (file_exists($adinj_dir.'/../../ad-injection-config.php')) {
	unlink($adinj_dir.'/../../ad-injection-config.php');
}

// Delete the ads which are stored outside the plugin directory
$adinj_dir2 = dirname($adinj_dir).'/ad-injection-data/';
adinj_delete_directory($adinj_dir2);

// From http://stackoverflow.com/questions/1447791/delete-directory-in-php
function adinj_delete_directory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!adinj_delete_directory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!adinj_delete_directory($dir . "/" . $item)) return false;
            };
        }
        return rmdir($dir);
    }

?>