<?php $path = get_bloginfo("template_directory"); ?>
<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2><img width="258" height="16" alt="Sidebar Hr" src="'.$path.'/images/sidebar_hr.png" class="divider"/>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Footer',
    'before_widget' => '<div class="block_b">',
    'after_widget' => '</div>',	
	'before_title' => '<h2>',
    'after_title' => '</h2>',
    ));
?>