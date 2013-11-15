<?php get_header(); ?>
	
	<div id="wrap">
	<!-- Main Content-->
		<img src="<?php bloginfo('template_directory');?>/images/content-top.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php if (get_option('polished_integration_single_top') <> '' && get_option('polished_integrate_singletop_enable') == 'on') echo(get_option('polished_integration_single_top')); ?>
					<div class="new_post entry clearfix">

						<h1 id="post-title"><?php the_title(); ?></h1>

						<?php if (get_option('polished_postinfo2') <> '') get_template_part( 'includes/postinfo'); ?>
						
						<div class="postcontent">
						
							<?php if (get_option('polished_thumbnails') == 'on') { ?>
								<?php $thumb = '';
			  
									  $width = (int) get_option('polished_thumbnail_width_posts');
									  $height = (int) get_option('polished_thumbnail_height_posts');
									  $classtext = 'post_img';
									  $titletext = get_the_title();
									  
									  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
									  $thumb = $thumbnail["thumb"]; ?>
									  
								<?php if($thumb <> '') print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								
							<?php }; ?>

							<?php the_content(); ?>

							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Polished').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
							
							<?php edit_post_link(esc_html__('Edit this page','Polished')); ?>

							<?php if (get_option('polished_integration_single_bottom') <> '' && get_option('polished_integrate_singlebottom_enable') == 'on') echo(get_option('polished_integration_single_bottom')); ?>
							<?php if (get_option('polished_468_enable') == 'on') { ?>
								<?php if(get_option('polished_468_adsense') <> '') echo(get_option('polished_468_adsense'));
								else { ?>
									<a href="<?php echo esc_url(get_option('polished_468_url')); ?>"><img src="<?php echo esc_url(get_option('polished_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
								<?php } ?>	
							<?php } ?>

							<?php if (get_option('polished_show_postcomments') == 'on') comments_template('', true); ?>
						</div> 
					</div>
				<?php endwhile; endif; ?>
			</div>
			<!-- End Main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>