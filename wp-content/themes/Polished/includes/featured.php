<?php global $ids; ?>
<?php	
	$ids = array();
	$arr = array();
	$i=1;
	
	$width = 177;
	$height = 177;
	
	$width2 = 35;
	$height2 = 35;
		
	$featured_cat = get_option('polished_feat_cat');
	$featured_num = get_option('polished_featured_num');
	
	if (get_option('polished_use_pages') == 'false') query_posts("showposts=$featured_num&cat=".get_catId($featured_cat));
	else { 
		global $pages_number;
		if (get_option('polished_feat_pages') <> '') $featured_num = count(get_option('polished_feat_pages'));
		else $featured_num = $pages_number;
		
		query_posts(array
						('post_type' => 'page',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__in' => (array) get_option('polished_feat_pages'),
						'showposts' => (int) $featured_num
					));
	};
	
	while (have_posts()) : the_post();
			
		$arr[$i]["title"] = truncate_title(22,false);
		$arr[$i]["title2"] = truncate_title(25,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);
		$arr[$i]["excerpt"] = truncate_post(345,false);
		$arr[$i]["permalink"] = get_permalink();
		$arr[$i]["postinfo"] = esc_html__("Posted by", "Polished")." ". get_the_author_meta('display_name') . esc_html__(' on ','Polished') . get_the_time(get_option('polished_date_format'));
		
		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'featured_img',$arr[$i]["fulltitle"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];
		
		$arr[$i]["thumbnail2"] = get_thumbnail($width2,$height2,'',$arr[$i]["fulltitle"]);
		$arr[$i]["thumb2"] = $arr[$i]["thumbnail2"]["thumb"];

		$i++;
		$ids[]= $post->ID;
	endwhile; wp_reset_query();	?>
	
	<!-- Start Featured -->	
		<div id="featured">
			<div id="left_arrow"><a href="#" id="previous"><img src="<?php bloginfo('template_directory'); ?>/images/fleft_arrow.png" width="32" height="70" alt="Featured Previous"/></a></div>
			
			<!-- Featured Content -->
			<div id="featured_content"> 
				
				<!-- Featured Articles -->
				<div id="spotlight">
					<?php if ($featured_num > 4) $featured_num=4;
					for ($i = 1; $i <= $featured_num; $i++) { ?>
						<div class="slide">
							<h1><?php echo esc_html($arr[$i]["title"]); ?></h1>
							<br class="clear" />
							<?php print_thumbnail($arr[$i]["thumb"], $arr[$i]["use_timthumb"], $arr[$i]["fulltitle"] , $width, $height,'featured_img'); ?>
							<?php echo $arr[$i]["excerpt"]; ?>
							
							<span class="readmore_g"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"> <?php esc_html_e('Read More','Polished') ?></a></span>
						</div>
					<?php }; ?>
				</div>
				<!-- End Featured Articles -->
				
				<!-- Featured Menu -->
				<div id="f_menu">
					<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
						<div class="featitem<?php if ($i==1) echo ' active'; if ($i==$featured_num) echo ' last'; ?>">
							<?php print_thumbnail($arr[$i]["thumb2"], $arr[$i]["use_timthumb"], $arr[$i]["fulltitle"] , $width2, $height2); ?>
							<h2><?php echo $arr[$i]["title2"]; ?></h2>
							<span class="meta"><?php echo $arr[$i]["postinfo"]; ?></span>
							<span class="order"><?php echo $i; ?></span> 
						</div>
					<?php }; ?>							
				</div>
				<!-- End Featured Menu -->	
			</div>
			<!-- End Featured Content -->
			
			<div id="right_arrow"><a href="#" id="next"><img src="<?php bloginfo('template_directory'); ?>/images/fright_arrow.png" width="32" height="70" alt="Featured Next"/></a></div>
		</div>
		<!-- End Featured -->
