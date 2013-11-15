<div id="wrap">
<!-- Main Content-->
	<img src="<?php bloginfo('template_directory');?>/images/content-top.gif" alt="content top" class="content-wrap" />
	<div id="content">
		<!-- Start Main Window -->
		<div id="main">
			
			<?php if (is_page()) { //if static homepage ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('includes/homepage_content'); ?>
				<?php endwhile; endif; ?>
			<?php } else { ?>
				<?php get_template_part('includes/default_home'); ?>
			
				
			<?php }; ?>
		
		</div>
		<!-- End Main -->

		<?php get_sidebar(); ?>