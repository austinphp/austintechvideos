<?php global $shortname; ?>

<script src="<?php bloginfo('template_directory'); ?>/js/jquery.lavalamp.1.3.3-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/superfish.js" type="text/javascript" charset="utf-8"></script>   
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.easing.1.3.js" type="text/javascript" charset="utf-8"></script>
    
<script type="text/javascript">
//<![CDATA[
 
jQuery(function(){

		jQuery.noConflict();
	
		jQuery('ul.sf-menu').superfish({
			delay:       300,                            // one second delay on mouseout 
			animation:   {'marginLeft':'0px',opacity:'show',height:'show'},  // fade-in and slide-down animation 
			speed:       'fast',                          // faster animation speed 
			autoArrows:  true,                           // disable generation of arrow mark-up 
			onBeforeShow:      function(){ this.css('marginLeft','20px'); },
			dropShadows: false                            // disable drop shadows 
		});
		
		jQuery('ul.sf-menu ul > li').addClass('noLava');
		jQuery('ul.sf-menu > li').addClass('top-level');
		
		jQuery('ul.sf-menu > li > a.sf-with-ul').parent('li').addClass('sf-ul');
		
		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.sf-menu > li > ul").prev("a").attr("href","#");'); ?>
		
		if (!(jQuery("#footer_widgets .block_b").length == 0)) {
			jQuery("#footer_widgets .block_b").each(function (index, domEle) {
				// domEle == this
				if ((index+1)%3 == 0) jQuery(domEle).after("<div class='clear'></div>");
			});
		};
		
		/* search form */
		
		jQuery('#search').toggle(
			function () {jQuery('#searchbox').animate({opacity:'toggle', marginLeft:'-210px'},500);},
			function () {jQuery('#searchbox').animate({opacity:'toggle', marginLeft:'-200px'}, 500);}
		);
		
		var $searchinput = jQuery("#header #searchbox input");
		var $searchvalue = $searchinput.val();
		
		$searchinput.focus(function(){
			if (jQuery(this).val() == $searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() == "") jQuery(this).val($searchvalue);
		});
		
	
		jQuery('ul.sf-menu li ul').append('<li class="bottom_bg noLava"></li>');
		
		var active_subpage = jQuery('ul.sf-menu ul li.current-cat, ul.sf-menu ul li.current_page_item').parents('li.top-level').prevAll().length;
		var isHome = <?php if (is_front_page() || is_home()) echo('1'); else echo('0'); ?>; 
		
		if (active_subpage) jQuery('ul.sf-menu').lavaLamp({ startItem: active_subpage });
		else if (isHome === 1) jQuery('ul.sf-menu').lavaLamp({ startItem: 0 });
		else jQuery('ul.sf-menu').lavaLamp();
			
		
		<?php if ((is_front_page() || is_home()) && get_option($shortname.'_featured')=='on') { ?>
			
			/* featured slider */
			jQuery(window).load( function(){	
				jQuery('#spotlight').css( { 'backgroundImage' : 'none' } ).cycle({
					timeout: 0,
					speed: 1000, 
					fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>'
				});
				
				var $featured_item = jQuery('div.featitem');
				var $slider_control = jQuery('div#f_menu');
				var ordernum;
				var pause_scroll = false;
				var $featured_area = jQuery('div#featured_content');			
		 
				if ( $featured_item.length == 1 ){
					$featured_area.find('.slide').show();
					jQuery('#featured #left_arrow, #featured #right_arrow').hide();
				}
		 
				function gonext(this_element){
					$slider_control
					.children("div.featitem.active")
					.removeClass('active');
					this_element.addClass('active');
					ordernum = this_element.find("span.order").html();
					jQuery('#spotlight').cycle(ordernum - 1);
				} 
				
				$featured_item.click(function() {
					clearInterval(interval);
					gonext(jQuery(this)); 
					return false;
				});
				
				jQuery('a#previous, a#next').click(function() {
					clearInterval(interval);
					if (jQuery(this).attr("id") === 'next') {
						auto_number = $slider_control.children("div.featitem.active").prevAll().length+1;
						if (auto_number === $featured_item.length) auto_number = 0;
					} else {
						auto_number = $slider_control.children("div.featitem.active").prevAll().length-1;
						if (auto_number === -1) auto_number = $featured_item.length-1;
					};
					gonext($featured_item.eq(auto_number));
					return false;
				});

				<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>			
					$featured_area.mouseover(function(){
						pause_scroll = true;
					}).mouseout(function(){
						pause_scroll = false;
					});
				<?php }; ?>	
				
				var auto_number;
				var interval;
				
				$featured_item.bind('autonext', function autonext(){
					if (!(pause_scroll)) gonext(jQuery(this)); 
					return false;
				});
				
				<?php if (get_option($shortname.'_slider_auto') == 'on') { ?>
					interval = setInterval(function () {
						auto_number = $slider_control.find("div.featitem.active span.order").html();
						if (auto_number == $featured_item.length) auto_number = 0;
						$featured_item.eq(auto_number).trigger('autonext');
					}, <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>);
				<?php }; ?>
			} );
		<?php }; ?>
});
//]]>
</script>