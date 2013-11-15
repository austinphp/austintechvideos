<?php

include 'wp-config.php';


global $wpdb;

$data = $wpdb->get_results("select * from wp_posts WHERE `post_status` = 'publish'");


$input = '[youtube_sc url="http://www.youtube.com/watch?v=wl53SZzRFBU"]';

$start = '[youtube_sc url="';
$end =  '"]';


function get_between($input, $start, $end)
{
  $substr = substr($input, strlen($start)+strpos($input, $start), (strlen($input) - strpos($input, $end))*(-1));
  return $substr;
} 


foreach($data as $results)
{
	
	$link = get_between($results->post_content, $start, $end);
	
	$fullLink = $start.$link.$end;
	
	//echo $link;
	
	//var_dump($results->post_content);
	echo "<br /><br /><br />";

}

//var_dump($wpdb);