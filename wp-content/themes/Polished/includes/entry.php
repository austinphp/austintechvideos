<?php
if ( is_home() ){
	global $ids;
	if (get_option('polished_duplicate') == 'false') {
		$args=array(
		   'showposts'=> (int) get_option('polished_homepage_posts'),
		   'post__not_in' => $ids,
		   'paged'=>$paged,
		   'category__not_in' => (array) get_option('polished_exlcats_recent'),
		);
	} else {
		$args=array(
		   'showposts'=> (int) get_option('polished_homepage_posts'),
		   'paged'=>$paged,
		   'category__not_in' => (array) get_option('polished_exlcats_recent'),
		);
	};
	query_posts($args);
}
if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';
		$width = (int) get_option('polished_thumbnail_width_usual');
		$height = (int) get_option('polished_thumbnail_height_usual');
		$classtext = 'post_img';
		$titletext = get_the_title();
		
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"];
		?>

	<!-- New Post-->
	<div class="new_post">
		<h2 class="title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Polished'), $titletext) ?>"><?php the_title(); ?></a></h2>
		
		<?php if (get_option('polished_postinfo1') <> '') get_template_part('includes/postinfo'); ?>
		
		<div class="postcontent">
			<?php if($thumb <> '') { ?>
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Polished'), $titletext) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
				</a>
			<?php }; ?>
			
			<?php if (get_option('polished_blog_style') == 'false') { ?>
				<p><?php truncate_post(445); ?></p>
			<?php } else { ?>
				<?php the_content(''); ?>
			<?php }; ?>
	  
			<span class="readmore_b"><a class="readmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','Polished'); ?></a></span>
			<div class="clear"></div>
		</div>	<!-- end .postcontent -->
	</div>
	<!-- End Post -->
<?php endwhile; ?>		
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		  else { ?>
			 <?php get_template_part('includes/navigation'); ?>
	<?php } ?>
<?php else : ?>
		<?php get_template_part('includes/no-results'); ?>
<?php endif; if ( is_home() ) wp_reset_query(); ?>