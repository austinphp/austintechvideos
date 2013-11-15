<?php 
/*
Template Name: Search Page
*/
?>
<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
<?php 
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );
	
	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>
	<div id="wrap"<?php if ($fullwidth) echo ' class="no_sidebar"'; ?>>
	<!-- Main Content-->
		<img src="<?php bloginfo('template_directory');?>/images/content-top<?php if ($fullwidth) echo ('-full');?>.gif" alt="content top" class="content-wrap" />
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
							
							<div id="et-search">
								<div id="et-search-inner" class="clearfix">
									<p id="et-search-title"><span><?php esc_html_e('search this website','Polished'); ?></span></p>
									<form action="<?php echo home_url(); ?>" method="get" id="et_search_form">
										<div id="et-search-left">
											<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','Polished'); ?>" /></p>
																			
											<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','Polished'); ?></label></p>
											<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','Polished'); ?></label></p>
											<p id="et_choose_date">
												<select id="et-month-choice" name="et-month-choice">
													<option value="no-choice"><?php esc_html_e('Select a month','Polished'); ?></option>
													<?php 
														global $wpdb, $wp_locale;
														
														$selected = '';
														$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
														
														$arcresults = $wpdb->get_results($query);
																															
														foreach ( (array) $arcresults as $arcresult ) {
															if ( isset($_POST['et-month-choice']) && ( $_POST['et-month-choice'] == ($arcresult->year . $arcresult->month) ) ) {
																$selected = ' selected="selected"';
															}
															echo "<option value='{$arcresult->year}{$arcresult->month}'{$selected}>{$wp_locale->get_month($arcresult->month)}" . ", {$arcresult->year}</option>";
															if ( $selected <> '' ) $selected = '';
														}
													?>
												</select>
											</p>
										
											<p id="et_choose_cat"><?php wp_dropdown_categories('show_option_all=Choose a Category&show_count=1&hierarchical=1&id=et-cat&name=et-cat'); ?></p>
										</div> <!-- #et-search-left -->
										
										<div id="et-search-right">
											<input type="hidden" name="et_searchform_submit" value="et_search_proccess" />
											<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','Polished'); ?>" id="et_search_submit" />
										</div> <!-- #et-search-right -->
									</form>
								</div> <!-- end #et-search-inner -->
							</div> <!-- end #et-search -->
							
							<div class="clear"></div>
							
							<?php edit_post_link(esc_html__('Edit this page','Polished')); ?>
							<div class="clear"></div>
						
						</div> <!-- end .post -->
				</div> 
			<?php endwhile; endif; ?>
			</div>
			<!-- End Main -->
	
	<?php if (!$fullwidth) get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>