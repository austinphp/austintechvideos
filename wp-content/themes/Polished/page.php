<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
<?php get_header(); ?>
	<div id="wrap">
	<!-- Main Content-->
		<img src="<?php bloginfo('template_directory');?>/images/content-top.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<div class="new_post entry clearfix">

					<h1 id="post-title"><?php the_title(); ?></h1>
						<div class="postcontent">		
							<?php $width = (int) get_option('polished_thumbnail_width_pages');
								  $height = (int) get_option('polished_thumbnail_height_pages');
								  $classtext = 'post_img';
								  $titletext = get_the_title();
								
								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>
							
							<?php if($thumb <> '' && get_option('polished_page_thumbnails') == 'on') { ?>
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<?php }; ?>
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Polished').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
							<?php edit_post_link(esc_html__('Edit this page','Polished')); ?>
							<div class="clear"></div>
						
							<?php if (get_option('polished_show_pagescomments') == 'on') comments_template('', true); ?>
						</div> <!-- end .post -->
				</div> 
			<?php endwhile; endif; ?>
			</div>
			<!-- End Main -->
	
	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>