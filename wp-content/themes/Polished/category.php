<?php get_header(); ?>
	
	<div id="wrap">
	<!-- Main Content-->
		<img src="<?php bloginfo('template_directory');?>/images/content-top.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
				<?php get_template_part('includes/entry'); ?>
			</div>
			<!-- End Main -->

	<?php get_sidebar(); ?>
	
<?php get_footer(); ?>