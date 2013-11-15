<?php
/*
Part of the Ad Injection plugin for WordPress
http://www.reviewmylife.co.uk/
*/

if (!is_admin()) return;

function adinj_tab_debug(){
	$ops = adinj_options();
	
	adinj_postbox_start(__("Debugging", 'adinj'), 'debugging');
	
	adinj_add_checkbox('debug_mode') ?>Enable debug mode
	
	<p>If you are not sure why ads aren't appearing, or why they are appearing, enable debug mode and look at the debug information (search for 'ADINJ DEBUG') in the HTML of your content pages.</p>
	
	<?php
	
	if (adinj_problem_with_wpminify_check()){
		echo adinj_get_problem_with_wpminify_message();
	}
	
	adinj_debug_information();
	?>
	
	<p></p>
	
	<p>If you want to restore all settings (excluding the ad contents) to their default values use this button.</p>
	
	<input type="submit" name="adinj_action" value="<?php _e('Reset to Default', 'adinj') ?>" />
	
	<p>You can delete the database settings if you are going to uninstall Ad Injection (they will be automatically deleted if you uninstall via WordPress as well).</p>
	
	<input type="submit" name="adinj_action" value="<?php _e('Delete settings from DB', 'adinj') ?>" />
	
	<p>This button will delete all your Ad Injection widgets.</p>
	
	<input type="submit" name="adinj_action" value="<?php _e('Delete widget settings from DB', 'adinj') ?>" />
	
	<?php 
	adinj_postbox_end();
}

function adinj_debug_information(){
	$stored_options = adinj_options();
	$default_options = adinj_default_options();
	?>
	<h4>Settings dump from database (all in 'adinj_options' option)</h4>
	<table border="1" style="width:610px; table-layout:fixed; word-wrap:break-word;">
	<tr><td><b>Name</b></td><td><b>Stored</b></td><td><b>Default</b></td></tr>
	<?php
	$main_length = 0;
	if ($stored_options !== false){
		$count = 0;
		foreach ($stored_options as $key => $value){
			if ($count % 2 == 0){
				echo '<tr style="background-color:#cccccc"><td>';
			} else {
				echo '<tr><td>';
			}
			echo "$key";
			$main_length += sizeof($key);
			$value = htmlspecialchars($value);
			$main_length += sizeof($value);
			$default = $default_options[$key];
			echo "</td><td>";
			if ($value != $default) echo '<font color="blue">';
			echo $value;
			if ($value != $default) echo '</font>';
			echo "</td><td>";
			echo $default;
			echo "</td></tr>";
			$count++;
		}
	} else {
		echo "<br />No options in database!";
	}
	echo '</table>';
	
	?><h4>Widget settings dump from database (all in 'widget_adinj' option)</h4>
	<table border="1" style="width:610px; word-wrap:break-word;">
	<tr><td><b>Widget</b></td><td><b>Setting:Value</b></td></tr>
	<?php
	$widgetops = get_option('widget_adinj');
	$widgets_length = 0;
	$count = 0;
	if (is_array($widgetops)){
		foreach($widgetops as $key=>$val){
			if ($count % 2 == 0){
				echo '<tr style="background-color:#cccccc"><td style="vertical-align:top">';
			} else {
				echo '<tr><td style="vertical-align:top">';
			}
			echo $key;
			$widgets_length += strlen($key);
			echo "</td>";
			echo '<td style="vertical-align:top">';
			if (is_array($val)){
				foreach($val as $subkey=>$subval){
					echo $subkey.':'.htmlspecialchars($subval).'<br />';
					$widgets_length += (strlen($subkey) + strlen($subval));
				}
			} else {
				echo htmlspecialchars($val);
				$widgets_length += strlen($val);
			}
			echo '</td></tr>';
			++$count;
		}
	} else {
		echo '<tr><td></td><td><b>No widget settings found</b></td></tr>';
	}
	echo '</table>';
	
	echo '<h4>Other settings</h4><blockquote>';
	
	echo 'ADINJ_PATH='.ADINJ_PATH.'<br />';
	echo 'ADINJ_CONFIG_FILE='.ADINJ_CONFIG_FILE.'<br />';
	echo 'ADINJ_AD_PATH='.ADINJ_AD_PATH.'<br />';
	echo 'Plugin version='.adinj_get_version().'<br />';
	echo 'Main settings length='.$main_length.' chars<br />';
	echo 'All widgets length='.$widgets_length.' chars<br />';
	echo '</blockquote>';
	
	global $adinj_warning_msg_filewrite;
	if (!empty($adinj_warning_msg_filewrite)){
		echo "<h4>Errors on 'Save all settings'</h4><blockquote>$adinj_warning_msg_filewrite</blockquote";
	}
	
	global $adinj_warning_msg_chmod;
	if (!empty($adinj_warning_msg_chmod)){
		echo "<h4>Warnings on 'Save all settings'</h4><blockquote>$adinj_warning_msg_chmod</blockquote";
	}
	
}

?>