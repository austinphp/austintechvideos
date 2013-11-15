<?php 
add_action( 'admin_enqueue_scripts', 'import_epanel_javascript' );
function import_epanel_javascript( $hook_suffix ) {
	if ( 'admin.php' == $hook_suffix && isset( $_GET['import'] ) && isset( $_GET['step'] ) && 'wordpress' == $_GET['import'] && '1' == $_GET['step'] )
		add_action( 'admin_head', 'admin_headhook' );
}

function admin_headhook(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("p.submit").before("<p><input type='checkbox' id='importepanel' name='importepanel' value='1' style='margin-right: 5px;'><label for='importepanel'>Replace ePanel settings with sample data values</label></p>");
		});
	</script>
<?php }

add_action('import_end','importend');
function importend(){
	global $wpdb, $shortname;
	
	#make custom fields image paths point to sampledata/sample_images folder
	$sample_images_postmeta = $wpdb->get_results("SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE meta_value REGEXP 'http://et_sample_images.com'");
	if ( $sample_images_postmeta ) {
		foreach ( $sample_images_postmeta as $postmeta ){
			$template_dir = get_template_directory_uri();
			if ( is_multisite() ){
				switch_to_blog(1);
				$main_siteurl = site_url();
				restore_current_blog();
				
				$template_dir = $main_siteurl . '/wp-content/themes/' . get_template();
			}
			preg_match( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $postmeta->meta_value, $matches );
			$image_path = $matches[1];
			
			$local_image = preg_replace( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $template_dir . '/sampledata/sample_images/$1.jpg', $postmeta->meta_value );
			
			$local_image = preg_replace( '/s:55:/', 's:' . strlen( $template_dir . '/sampledata/sample_images/' . $image_path . '.jpg' ) . ':', $local_image );
			
			$wpdb->update( $wpdb->postmeta, array( 'meta_value' => $local_image ), array( 'meta_id' => $postmeta->meta_id ), array( '%s' ) );
		}
	}
	
	if ( !isset($_POST['importepanel']) )
		return;
	
	$importOptions = 'YTo5NDp7czowOiIiO047czoxMzoicG9saXNoZWRfbG9nbyI7czowOiIiO3M6MTY6InBvbGlzaGVkX2Zhdmljb24iO3M6MDoiIjtzOjIxOiJwb2xpc2hlZF9jb2xvcl9zY2hlbWUiO3M6NDoiQmx1ZSI7czoxOToicG9saXNoZWRfYmxvZ19zdHlsZSI7TjtzOjE5OiJwb2xpc2hlZF9ncmFiX2ltYWdlIjtOO3M6MjE6InBvbGlzaGVkX2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI1OiJwb2xpc2hlZF9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjQ6InBvbGlzaGVkX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJwb2xpc2hlZF90YWdudW1fcG9zdHMiO3M6MToiNSI7czoyMDoicG9saXNoZWRfZGF0ZV9mb3JtYXQiO3M6NjoiTSBqLCBZIjtzOjIwOiJwb2xpc2hlZF91c2VfZXhjZXJwdCI7TjtzOjIzOiJwb2xpc2hlZF9ob21lcGFnZV9wb3N0cyI7czoxOiI3IjtzOjIzOiJwb2xpc2hlZF9leGxjYXRzX3JlY2VudCI7TjtzOjE3OiJwb2xpc2hlZF9mZWF0dXJlZCI7czoyOiJvbiI7czoxODoicG9saXNoZWRfZHVwbGljYXRlIjtzOjI6Im9uIjtzOjE3OiJwb2xpc2hlZF9mZWF0X2NhdCI7czo4OiJGZWF0dXJlZCI7czoyMToicG9saXNoZWRfZmVhdHVyZWRfbnVtIjtzOjE6IjMiO3M6MTg6InBvbGlzaGVkX3VzZV9wYWdlcyI7TjtzOjE5OiJwb2xpc2hlZF9mZWF0X3BhZ2VzIjtOO3M6MjI6InBvbGlzaGVkX3NsaWRlcl9lZmZlY3QiO3M6NDoiZmFkZSI7czoyMDoicG9saXNoZWRfc2xpZGVyX2F1dG8iO047czoyMDoicG9saXNoZWRfcGF1c2VfaG92ZXIiO047czoyNToicG9saXNoZWRfc2xpZGVyX2F1dG9zcGVlZCI7czo0OiIzMDAwIjtzOjE4OiJwb2xpc2hlZF9tZW51cGFnZXMiO047czoyNToicG9saXNoZWRfZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoxODoicG9saXNoZWRfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjE5OiJwb2xpc2hlZF9zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjE5OiJwb2xpc2hlZF9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoyNjoicG9saXNoZWRfdGllcnNfc2hvd25fcGFnZXMiO3M6MToiMyI7czoxNzoicG9saXNoZWRfbWVudWNhdHMiO047czozNjoicG9saXNoZWRfZW5hYmxlX2Ryb3Bkb3duc19jYXRlZ29yaWVzIjtzOjI6Im9uIjtzOjI1OiJwb2xpc2hlZF9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjMxOiJwb2xpc2hlZF90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MTc6InBvbGlzaGVkX3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTg6InBvbGlzaGVkX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjQ6InBvbGlzaGVkX2Rpc2FibGVfdG9wdGllciI7TjtzOjE4OiJwb2xpc2hlZF9wb3N0aW5mbzIiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjE5OiJwb2xpc2hlZF90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI2OiJwb2xpc2hlZF9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czozMDoicG9saXNoZWRfdGh1bWJuYWlsX3dpZHRoX3Bvc3RzIjtzOjM6IjE4NSI7czozMToicG9saXNoZWRfdGh1bWJuYWlsX2hlaWdodF9wb3N0cyI7czozOiIxODUiO3M6MjQ6InBvbGlzaGVkX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI3OiJwb2xpc2hlZF9zaG93X3BhZ2VzY29tbWVudHMiO047czozMDoicG9saXNoZWRfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjE4NSI7czozMToicG9saXNoZWRfdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIxODUiO3M6MTg6InBvbGlzaGVkX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MzA6InBvbGlzaGVkX3RodW1ibmFpbF93aWR0aF91c3VhbCI7czozOiIxNjQiO3M6MzE6InBvbGlzaGVkX3RodW1ibmFpbF9oZWlnaHRfdXN1YWwiO3M6MzoiMTY0IjtzOjIyOiJwb2xpc2hlZF9jdXN0b21fY29sb3JzIjtOO3M6MTg6InBvbGlzaGVkX2NoaWxkX2NzcyI7TjtzOjIxOiJwb2xpc2hlZF9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjIzOiJwb2xpc2hlZF9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjM6InBvbGlzaGVkX2NvbG9yX21haW5saW5rIjtzOjA6IiI7czoyMzoicG9saXNoZWRfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjMwOiJwb2xpc2hlZF9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjIzOiJwb2xpc2hlZF9jb2xvcl9oZWFkaW5ncyI7czowOiIiO3M6Mjg6InBvbGlzaGVkX2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjI0OiJwb2xpc2hlZF9mb290ZXJfaGVhZGluZ3MiO3M6MDoiIjtzOjI2OiJwb2xpc2hlZF9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6MjM6InBvbGlzaGVkX3Nlb19ob21lX3RpdGxlIjtOO3M6Mjk6InBvbGlzaGVkX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjY6InBvbGlzaGVkX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6Mjc6InBvbGlzaGVkX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI3OiJwb2xpc2hlZF9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMzOiJwb2xpc2hlZF9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjMwOiJwb2xpc2hlZF9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjIyOiJwb2xpc2hlZF9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjY6InBvbGlzaGVkX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNToicG9saXNoZWRfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjMxOiJwb2xpc2hlZF9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjg6InBvbGlzaGVkX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyOToicG9saXNoZWRfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czozMToicG9saXNoZWRfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6Mzc6InBvbGlzaGVkX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozNDoicG9saXNoZWRfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI0OiJwb2xpc2hlZF9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyODoicG9saXNoZWRfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjg6InBvbGlzaGVkX3Nlb19pbmRleF9jYW5vbmljYWwiO047czozMDoicG9saXNoZWRfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjM6InBvbGlzaGVkX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6Mjc6InBvbGlzaGVkX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzI6InBvbGlzaGVkX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMwOiJwb2xpc2hlZF9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzU6InBvbGlzaGVkX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM4OiJwb2xpc2hlZF9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNToicG9saXNoZWRfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjU6InBvbGlzaGVkX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjMxOiJwb2xpc2hlZF9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNDoicG9saXNoZWRfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTk6InBvbGlzaGVkXzQ2OF9lbmFibGUiO047czoxODoicG9saXNoZWRfNDY4X2ltYWdlIjtzOjA6IiI7czoxNjoicG9saXNoZWRfNDY4X3VybCI7czowOiIiO3M6MjA6InBvbGlzaGVkXzQ2OF9hZHNlbnNlIjtzOjA6IiI7fQ==';
	
	/*global $options;
	
	foreach ($options as $value) {
		if( isset( $value['id'] ) ) { 
			update_option( $value['id'], $value['std'] );
		}
	}*/
	
	$importedOptions = unserialize(base64_decode($importOptions));
	
	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}
	update_option( $shortname . '_use_pages', 'false' );
} ?>