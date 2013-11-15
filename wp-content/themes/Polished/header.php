<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie7style.css" />
	<![endif]-->
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie8style.css" />
	<![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie6style.css" />
    <script src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">DD_belatedPNG.fix('div#top, img#logo, img.logo_line, div#left_arrow a img, div#right_arrow a img, span a.readmore, #f_menu div.featitem,  #f_menu div.active, ul.sf-menu li.backLava');</script>
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<div id="top">
		<div id="header">
			
			<!-- Start Logo -->
			<a href="<?php bloginfo('url'); ?>"><?php $logo = (get_option('polished_logo') <> '') ? get_option('polished_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?>
				<img src="<?php echo esc_url($logo); ?>" alt="Logo" id="logo"/></a>
			<img src="<?php bloginfo('template_directory'); ?>/images/separator.png" width="2" height="59" alt="Line" class="logo_line"/>
			<p id="logo_title"><?php bloginfo('description'); ?></p>
			<!-- End Logo -->
			
			<!-- Start Searchbox -->
			<div id="searchico">
				<a href="#" id="search"><img src="<?php bloginfo('template_directory'); ?>/images/search_btn.png" width="19" height="19" alt="Search Btn"/></a>
				<form method="get" id="searchbox" action="<?php echo home_url(); ?>/">
					<input type="text" value="<?php esc_attr_e('search this site...','Polished'); ?>" name="s" id="s" />
				</form>
			</div>
			<!-- End Searchbox -->
			
			<!-- Start Menu -->
			<?php $menuClass = 'sf-menu';
			$primaryNav = '';
			
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo $menuClass; ?>">
					<?php if (get_option('polished_home_link') == 'on') { ?>
						<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php esc_html_e('Home','Polished'); ?></a></li>
					<?php }; ?>

					<?php show_categories_menu($menuClass,false); ?>
					
					<?php show_page_menu($menuClass,false,false); ?>
				</ul> <!-- end ul.nav -->
			<?php }
			else echo($primaryNav); ?>		
			<!-- End Menu -->	

			<?php if (get_option('polished_featured') == 'on' && (is_front_page() || is_home())) get_template_part('includes/featured'); ?>
		</div>
		<!-- End Header -->
        <div style="clear: both;"></div>
	</div>
	<!-- End Top -->