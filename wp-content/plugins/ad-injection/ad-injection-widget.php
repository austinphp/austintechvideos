<?php
/*
Part of the Ad Injection plugin for WordPress
http://www.reviewmylife.co.uk/
*/

// 1 = original
// 2 = split testing / alt content
// 3 = increase db rotation slots to 10 - no UI support yet
// 4 = added ui show fields for ads 4-10. Category/tag/author conditions.
// 5 = ad/alt pool show fields
// 6 = page type restrictions
// 7 = align and clear
// 8 = post/page id restrictions
define('ADINJ_WIDGET_DB_VERSION', 8);

class Ad_Injection_Widget extends WP_Widget {
	function Ad_Injection_Widget() {
		$widget_ops = array( 'classname' => 'adinjwidget', 'description' => 'Insert Ad Injection adverts into your sidebars/widget areas.' );
		$control_ops = array( 'width' => 500, 'height' => 300, 'id_base' => 'adinj' );
		$this->WP_Widget( 'adinj', 'Ad Injection', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		if (adinj_ads_completely_disabled_from_page('widget')) return;
		
		if ((is_front_page() && adinj_ticked('widget_exclude_front')) ||
			(is_home() && adinj_ticked('widget_exclude_home')) ||
			(is_page() && adinj_ticked('widget_exclude_page')) ||
			(is_single() && adinj_ticked('widget_exclude_single')) ||
			(is_archive() && adinj_ticked('widget_exclude_archive')) ||
			(is_search() && adinj_ticked('widget_exclude_search')) ||
			(is_404() && adinj_ticked('widget_exclude_404'))){
			return;
		}
		
		if ((is_front_page() && adinj_ticked('exclude_front', $instance)) ||
			(is_home() && adinj_ticked('exclude_home', $instance)) ||
			(is_page() && adinj_ticked('exclude_page', $instance)) ||
			(is_single() && adinj_ticked('exclude_single', $instance)) ||
			(is_archive() && adinj_ticked('exclude_archive', $instance)) ||
			(is_search() && adinj_ticked('exclude_search', $instance)) ||
			(is_404() && adinj_ticked('exclude_404', $instance))){
			return;
		}

		if (!adinj_allowed_in_category('widget', $instance)) return;
		if (!adinj_allowed_in_tag('widget', $instance)) return;
		if (!adinj_allowed_in_author('widget', $instance)) return;
		if (!adinj_allowed_in_id('widget', $instance)) return;
		
		extract( $args );
		
		$ops = adinj_options();
		
		$include = "";
		if (adinj_mfunc_mode()){
			$include = adinj_ad_code_include();
		}
		
		$title = apply_filters('widget_title', $instance['title'] );
		
		// The old 'non upgraded' db will be passed here if the widget hasn't
		// been resaved. We can't upgrade as doing so would mean we'd have to
		// re-save the widget files - which we can't do as we can't re-write 
		// the settings back to the db (at least not without a bit more work)
		$adcode = adinj_get_ad_code('widget_'.$this->get_id(), $instance);

		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}		
			
		if ( !empty($adcode) ){
			echo $include;
			echo $adcode;
		}

		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ){
		$updated = $this->adinj_upgrade_widget_db($new_instance, $old_instance);
		
		// Only strip tags when potential for updated title
		$updated['title'] = strip_tags( $new_instance['title'] );
		
		// After first save mark it as saved
		$updated['saved'] = 1;

		for ($i=1; $i<=10; ++$i){
			write_ad_to_file($updated['advert_'.$i], $this->get_ad_file_path($i));
		}
		for ($i=1; $i<=3; ++$i){
			write_ad_to_file($updated['advert_alt_'.$i], $this->get_alt_file_path($i));
		}
		
		return $updated;
	}
	
	function default_options(){
		/* Set up some default widget settings. */
		return array(
			'title' => '', 
			//adverts
			'advert_1' => '', 
			'advert_1_split' => '100',
			'advert_2' => '', 
			'advert_2_split' => '100',
			'advert_3' => '', 
			'advert_3_split' => '100',
			'advert_4' => '', 
			'advert_4_split' => '100',
			'advert_5' => '', 
			'advert_5_split' => '100',
			'advert_6' => '', 
			'advert_6_split' => '100',
			'advert_7' => '', 
			'advert_7_split' => '100',
			'advert_8' => '', 
			'advert_8_split' => '100',
			'advert_9' => '', 
			'advert_9_split' => '100',
			'advert_10' => '', 
			'advert_10_split' => '100',
			'advert_alt_1' => '', 
			'advert_alt_1_split' => '100', 
			'advert_alt_2' => '', 
			'advert_alt_2_split' => '100', 
			'advert_alt_3' => '', 
			'advert_alt_3_split' => '100', 
			//settings
			'margin_top' => 'd',
			'margin_bottom' => 'd',
			'padding_top' => 'd',
			'padding_bottom' => 'd',
			'align' => 'd',
			'clear' => 'd',
			'widget_category_condition_mode' => 'o',
			'widget_category_condition_entries' => '',
			'widget_tag_condition_mode' => 'o',
			'widget_tag_condition_entries' => '',
			'widget_author_condition_mode' => 'o',
			'widget_author_condition_entries' => '',
			'widget_id_condition_mode' => 'o',
			'widget_id_condition_entries' => '',
			'exclude_front' => '',
			'exclude_home' => '',
			'exclude_page' => '',
			'exclude_single' => '',
			'exclude_archive' => '',
			'exclude_search' => '',
			'exclude_404' => '',
			//ui
			'ui_ad_1_show' => 'true',
			'ui_pagetypes_show' => 'false',
			'ui_conditions_show' => 'false',
			'ui_spacing_show' => 'false',
			'ui_ad_pool_show' => 'false',
			'ui_ad_2_show' => 'false',
			'ui_ad_3_show' => 'false',
			'ui_ad_4_show' => 'false',
			'ui_ad_5_show' => 'false',
			'ui_ad_6_show' => 'false',
			'ui_ad_7_show' => 'false',
			'ui_ad_8_show' => 'false',
			'ui_ad_9_show' => 'false',
			'ui_ad_10_show' => 'false',
			'ui_alt_pool_show' => 'false',
			'ui_alt_1_show' => 'false',
			'ui_alt_2_show' => 'false',
			'ui_alt_3_show' => 'false',
			'saved' => 0,
			//
			'db_version' => ADINJ_WIDGET_DB_VERSION
			);
	}
	
	function adinj_upgrade_widget_db($new_instance, $old_instance){
		// Copy old values across to default
		$updated = $this->default_options();
		foreach ($updated as $key => $value){
			if (array_key_exists($key, $new_instance)){
				$updated[$key] = $new_instance[$key];
			}
		}
		
		// Upgrade any options as necessary
		$old_dbversion = adinj_db_version($old_instance);
		if ($old_dbversion == 1){
			$updated['advert_1'] = $old_instance['advert'];
		}
			
		$updated['db_version'] = ADINJ_WIDGET_DB_VERSION;
	
		return $updated;
	}
	
	function form( $instance ) {
		$instance = $this->adinj_upgrade_widget_db($instance, $instance);

		$savedfieldname = $this->get_field_name('saved');
		$savedfieldvalue = $instance['saved'];
		?>
		
		<input type='hidden' <?php $this->add_name('db_version'); ?> value='<?php echo $defaults['db_version']; ?>' />
		<input type='hidden' name="$savedfieldname" value='$savedfieldvalue' />
		
		<p>
			<b>Title:</b><br />
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:490px;" />
		<br />
			<span style="font-size:10px;">Make sure any title complies with your ad provider's TOS. More info for <a href="http://adsense.blogspot.com/2007/04/encouraging-clicks.html" target="_new">AdSense</a> users.</span>
		</p>

		<style type="text/css">
		.adinjtable td { vertical-align: top; }
		</style>
		
		<table border="0" width="490px" class="adinjtable">
		<?php
		$total_ad_split = adinj_total_split('advert_', $instance);
		$this->add_row('advert_', 1, 'Ad code 1', 'ui_ad_1_show', $total_ad_split, $instance);
		?>
		</table>
		
		<?php
		if ($savedfieldvalue != 1){
			echo '<b>The widget needs to be saved for first time to activate the other options.</b>';
			return;
		}
		?>
		
		<br />
		<b> Exclude this widget from page types</b>
		<?php $this->add_show_hide_section('ad_pagetypes_'.uniqid(''), 'ui_pagetypes_show', $instance); ?>
		<?php
		$count_pages = wp_count_posts('page', 'readable'); 
		$count_posts = wp_count_posts('post', 'readable'); 
		?>
		<?php $this->add_checkbox('exclude_front', $instance) ?>front - <?php echo get_bloginfo('url'); ?><br />
		<?php $this->add_checkbox('exclude_home', $instance) ?>home page (latest posts page - may or may not be same as front)<br />
		<?php $this->add_checkbox('exclude_page', $instance) ?>page - <?php echo $count_pages->publish; ?> single page(s)<br />
		<?php $this->add_checkbox('exclude_single', $instance) ?>single - <?php echo $count_posts->publish; ?> single post(s)<br />
		<?php $this->add_checkbox('exclude_archive', $instance) ?>archive - categories, tags, authors, dates<br />
		<?php $this->add_checkbox('exclude_search', $instance) ?>search<br />
		<?php $this->add_checkbox('exclude_404', $instance) ?>404<br />
		<span style="font-size:10px;"><b>Notes:</b> Your home page is the page displaying your latest posts. It may be different to your front page if you have configured your front page to be a static page.</span><br />
		<span style="font-size:10px;">If you have <a href='options-reading.php'>set your front page</a> to be a static 'page' rather than your latest posts, the 'page' tick box will also apply to the front page.</span>
		</div>
		
		<br />
		<b> Category, tag, author and id conditions</b>
		<?php 
		$this->add_show_hide_section('ad_restrictions_'.uniqid(''), 'ui_conditions_show', $instance);
		adinj_condition_table('widget_category', 'category slugs. e.g: cat1, cat2, cat3', 'category', $instance, $this->get_field_name('widget_category_condition_mode'), $this->get_field_name('widget_category_condition_entries'));
		adinj_condition_table('widget_tag', 'tag slugs. e.g: tag1, tag2, tag3', 'tag', $instance, $this->get_field_name('widget_tag_condition_mode'), $this->get_field_name('widget_tag_condition_entries'));
		adinj_condition_table('widget_author', 'author nicknames. e.g: john, paul', 'author', $instance, $this->get_field_name('widget_author_condition_mode'), $this->get_field_name('widget_author_condition_entries'));
		adinj_condition_table('widget_id', 'post/page ids. e.g: 7, 23, 276', 'id', $instance, $this->get_field_name('widget_id_condition_mode'), $this->get_field_name('widget_id_condition_entries'));
		echo '</div>'
		?>
		
		<br />
		<b> Spacing and alignment options</b>
		<?php $this->add_show_hide_section('ad_spacing_'.uniqid(''), 'ui_spacing_show', $instance); ?>
		<table border="0" width="490px" class="adinjtable">
		<tr><td>
			<?php adinj_add_alignment_clear_options('widget_', $instance, $this->get_field_name('align'), $this->get_field_name('clear') ); ?>
		</td><td>
			<?php adinj_add_margin_top_bottom_options('widget_', $instance, $this->get_field_name('margin_top'), $this->get_field_name('margin_bottom') ); ?>
		</td><td>
			<?php adinj_add_padding_top_bottom_options('widget_', $instance, $this->get_field_name('padding_top'), $this->get_field_name('padding_bottom') ); ?>
		</td></tr>
		</table>
		</div>
		
		<br />
		<b> Ad rotation pool</b>
		<?php $this->add_show_hide_section('ad_pool_'.uniqid(''), 'ui_ad_pool_show', $instance); ?>
		<table border="0" width="490px" class="adinjtable">
		<?php
		for ($i=2; $i<=10; ++$i){
			$this->add_row('advert_', $i, 'Ad code '.$i, 'ui_ad_'.$i.'_show', $total_ad_split, $instance);
		}
		?>
		</table></div>
		
		<br />
		<b> Alt content pool</b>
		<?php $this->add_show_hide_section('alt_pool_'.uniqid(''), 'ui_alt_pool_show', $instance); ?>
		<table border="0" cellspacing="5" width="490px" class="adinjtable">
		<?php
		$total_alt_split = adinj_total_split('advert_alt_', $instance);
		for ($i=1; $i<=3; ++$i){
			$this->add_row('advert_alt_', $i, 'Alt content '.$i, 'ui_alt_'.$i.'_show', $total_alt_split, $instance);
		}
		?>
		</table></div>
		
		<br />
		
		<p>Other options to define who sees these adverts (by page age, IP, referrer) are on the main <a href='options-general.php?page=ad-injection.php'>Ad Injection settings page</a>. You can also set a global <a href='options-general.php?page=ad-injection.php#global'>page type</a> restriction for the widgets.</p>
		
		<?php
	}
	
	function add_checkbox($name, $instance){
	?>
		<input type="hidden" <?php $this->add_name($name); ?> value="off" />
		<input type="checkbox" <?php $this->add_name($name); ?> <?php echo adinj_ticked($name, $instance); ?> />
	<?php
	}
	
	function add_row($op_stem, $num, $label, $show_op, $total_split, $ops){
		$op = $op_stem.$num;
		$op_split = $op.'_split';
		$anchorid = $op.'_'.uniqid('');
		
		$percentage_split = adinj_percentage_split($op_stem, $num, $ops, $total_split);
		?>
		<tr><td colspan='2'>
		<input style="float:right; padding:0; margin:0;" <?php $this->add_name($op_split); ?> size="7" value="<?php echo $ops[$op_split]; ?>" />
		
		<?php
		echo <<<HTML
		<b> $label</b> <label style='float:right'>(Rotation: $percentage_split)</label>
		
HTML;
		$this->add_show_hide_section($anchorid, $show_op, $ops);

		if ($op_stem == 'advert_' && $num == 2){
			echo '<span style="font-size:10px;">These boxes are for defining rotated adverts which replace the original advert according to the percentages defined. If you want multiple sidebar/widget ads you need to drag another widget into the sidebar.</span><br />';
		}
		if ($op_stem == 'advert_alt_' && $num == 1){
			echo '<span style="font-size:10px;">Here you can define content which is shown if ads are blocked for the viewer (only for mfunc and dynamic ad insertion modes).</span><br />';
		}
		
		?>
		
		<textarea class="widefat" rows="8" cols="50" width="100%" <?php $this->add_name($op); ?>><?php echo $ops[$op]; ?></textarea>
		</div><!--add_show_hide_section-->
		</td></tr>
		<?php
	}
	
	function add_show_hide_section($anchor, $show_op, $ops){
		$show_field_name = $this->get_field_name($show_op);
		adinj_add_show_hide_section($anchor, $show_op, $show_field_name, $ops);
	}
	
	function add_name($op){
		echo 'id="'.$this->get_field_id($op).'" name="'.$this->get_field_name($op).'"';
	}
	
	function get_ad_file_path($num){
		return ADINJ_AD_PATH.'/'.$this->get_ad_file_name($num);
	}
	
	function get_alt_file_path($num){
		return ADINJ_AD_PATH.'/'.$this->get_alt_file_name($num);
	}
	
	function get_ad_file_name($num){
		return 'ad_widget_'.$this->get_id().'_'.$num.'.txt';
	}
	
	function get_alt_file_name($num){
		return 'ad_widget_'.$this->get_id().'_alt_'.$num.'.txt';
	}
	
	function get_id(){
		$field = $this->get_field_id('advert_1');
		preg_match('/-(\d+)-/', $field, $matches);
		return $matches[1];
	}
}

?>