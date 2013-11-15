</div>
	<!-- End Content -->
    <img src="<?php bloginfo('template_directory') ?>/images/content-bottom<?php global $fullwidth; if(is_page_template('page-full.php') || (($fullwidth))) echo '-full'?>.gif" alt="content top" class="content-wrap" />
	
	<!-- Footer Widgets -->
	<div id="footer_widgets">
		<!-- Footer Widget Start-->
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?> 
		<?php endif; ?>
		
	</div>
	<!-- Footer Widgets Done -->
	<div id="footer">
		<p id="copyright"><?php esc_html_e('Powered by ','Polished'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','Polished'); ?><a href="http://www.elegantthemes.com">Elegant Themes</a></p>
	</div>
</div>
<!-- Wrap End -->


<?php get_template_part('includes/scripts'); ?>

<?php wp_footer(); ?>	
</body>
</html>
