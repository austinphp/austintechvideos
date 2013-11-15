<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Home Page
 *
 * Note: You can overwrite home.php as well as any other Template in Child Theme.
 * Create the same file (name) include in /responsive-child-theme/ and you're all set to go!
 * @see            http://codex.wordpress.org/Child_Themes
 *
 * @file           home.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2012 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/home.php
 * @link           http://codex.wordpress.org/Template_Hierarchy
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

<div id="featured" class="grid col-940">


        	
        <div class="postcontent">	
 				<?php while ( have_posts() ) : the_post(); ?>

				<h2 class="title"><a href="<?php the_permalink() ?>" title=""><?php the_title(); ?></a></h2>
				<?php //the_excerpt(); 
					the_content(""); 
					
					 //truncate_post(445);
				
				?>		

				<?php endwhile; ?>  
				
			</div>     	

<div class="pagination">
	<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older Entries')) ?></div>
	<div class="alignright"><?php previous_posts_link(esc_html__('Next Entries &raquo;')) ?></div>
</div>

            
</div><!-- end of .col-460 -->



</div><!-- end of #featured -->
               

<?php get_footer(); ?>