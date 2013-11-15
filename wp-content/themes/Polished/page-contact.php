<?php session_start();
/*
Template Name: Contact Page
*/
?>
<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
<?php 
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );
	
	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
	
	$et_regenerate_numbers = isset( $et_ptemplate_settings['et_regenerate_numbers'] ) ? (bool) $et_ptemplate_settings['et_regenerate_numbers'] : false;
		
	$et_error_message = '';
	$et_contact_error = false;
	
	if ( isset($_POST['et_contactform_submit']) ) {
		if ( !isset($_POST['et_contact_captcha']) || empty($_POST['et_contact_captcha']) ) {
			$et_error_message .= '<p>' . esc_html__('Make sure you entered the captcha. ','Polished') . '</p>';
			$et_contact_error = true;
		} else if ( $_POST['et_contact_captcha'] <> ( $_SESSION['et_first_digit'] + $_SESSION['et_second_digit'] ) ) {			
			$et_numbers_string = $et_regenerate_numbers ? __('Numbers regenerated.') : '';
			$et_error_message .= '<p>' . esc_html__('You entered the wrong number in captcha. ','Polished') . $et_numbers_string . '</p>';
			
			if ($et_regenerate_numbers) {
				unset( $_SESSION['et_first_digit'] );
				unset( $_SESSION['et_second_digit'] );
			}
			
			$et_contact_error = true;
		} else if ( empty($_POST['et_contact_name']) || empty($_POST['et_contact_email']) || empty($_POST['et_contact_subject']) || empty($_POST['et_contact_message']) ){
			$et_error_message .= '<p>' . esc_html__('Make sure you fill all fields. ','Polished') . '</p>';
			$et_contact_error = true;
		}
		
		if ( !is_email( $_POST['et_contact_email'] ) ) {
			$et_error_message .= '<p>' . esc_html__('Invalid Email. ','Polished') . '</p>';
			$et_contact_error = true;
		}
	} else {
		$et_contact_error = true;
		if ( isset($_SESSION['et_first_digit'] ) ) unset( $_SESSION['et_first_digit'] );
		if ( isset($_SESSION['et_second_digit'] ) ) unset( $_SESSION['et_second_digit'] );
	}
	
	if ( !isset($_SESSION['et_first_digit'] ) ) $_SESSION['et_first_digit'] = $et_first_digit = rand(1, 15);
	else $et_first_digit = $_SESSION['et_first_digit'];
	
	if ( !isset($_SESSION['et_second_digit'] ) ) $_SESSION['et_second_digit'] = $et_second_digit = rand(1, 15);
	else $et_second_digit = $_SESSION['et_second_digit'];
	
	if ( !$et_contact_error ) {
		$et_email_to = ( isset($et_ptemplate_settings['et_email_to']) && !empty($et_ptemplate_settings['et_email_to']) ) ? $et_ptemplate_settings['et_email_to'] : get_site_option('admin_email');
				
		$et_site_name = is_multisite() ? $current_site->site_name : get_bloginfo('name');	
		wp_mail($et_email_to, sprintf( '[%s] ' . esc_html($_POST['et_contact_subject']), $et_site_name ), esc_html($_POST['et_contact_message']),'From: "'. esc_html($_POST['et_contact_name']) .'" <' . esc_html($_POST['et_contact_email']) . '>');
		
		$et_error_message = '<p>' . esc_html__('Thanks for contacting us','Polished') . '</p>';
	}
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
							
							<div id="et-contact">

								<div id="et-contact-message"><?php echo($et_error_message); ?> </div>
								
								<?php if ( $et_contact_error ) { ?>
									<form action="<?php echo(get_permalink($post->ID)); ?>" method="post" id="et_contact_form">
										<div id="et_contact_left">
											<p class="clearfix">
												<input type="text" name="et_contact_name" value="<?php if ( isset($_POST['et_contact_name']) ) echo esc_attr($_POST['et_contact_name']); else esc_attr_e('Name','Polished'); ?>" id="et_contact_name" class="input" />
											</p>
											
											<p class="clearfix">
												<input type="text" name="et_contact_email" value="<?php if ( isset($_POST['et_contact_email']) ) echo esc_attr($_POST['et_contact_email']); else esc_attr_e('Email Address','Polished'); ?>" id="et_contact_email" class="input" />
											</p>
											
											<p class="clearfix">
												<input type="text" name="et_contact_subject" value="<?php if ( isset($_POST['et_contact_subject']) ) echo esc_attr($_POST['et_contact_subject']); else esc_attr_e('Subject','Polished'); ?>" id="et_contact_subject" class="input" />
											</p>
										</div> <!-- #et_contact_left -->
										
										<div id="et_contact_right">
											<p class="clearfix">
												<?php 
													esc_html_e('Captcha: ','Polished');	
													echo '<br/>';
													echo esc_attr($et_first_digit) . ' + ' . esc_attr($et_second_digit) . ' = ';
												?>
												<input type="text" name="et_contact_captcha" value="<?php if ( isset($_POST['et_contact_captcha']) ) echo esc_attr($_POST['et_contact_captcha']); ?>" id="et_contact_captcha" class="input" size="2" />
											</p>
										</div> <!-- #et_contact_right -->
										
										<div class="clear"></div>
										
										<p class="clearfix">
											<textarea class="input" id="et_contact_message" name="et_contact_message"><?php if ( isset($_POST['et_contact_message']) ) echo esc_textarea($_POST['et_contact_message']); else echo esc_textarea('Message','Polished'); ?></textarea>
										</p>
											
										<input type="hidden" name="et_contactform_submit" value="et_contact_proccess" />
										
										<input type="reset" id="et_contact_reset" value="<?php esc_attr_e('Reset','Polished'); ?>" />
										<input class="et_contact_submit" type="submit" value="<?php esc_attr_e('Submit','Polished'); ?>" id="et_contact_submit" />
									</form>
								<?php } ?>
							</div> <!-- end #et-contact -->
							
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