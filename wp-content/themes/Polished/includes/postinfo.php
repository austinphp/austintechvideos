<div class="post_info">

	<?php if (!(is_single())) { ?>
		
		<?php esc_html_e('Posted','Polished'); ?> <?php if (in_array('author', get_option('polished_postinfo1'))) { ?> <?php esc_html_e('by','Polished'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('polished_postinfo1'))) { ?> <?php esc_html_e('on','Polished'); ?> <?php the_time(get_option('polished_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('polished_postinfo1'))) { ?> <?php esc_html_e('in','Polished'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('polished_postinfo1'))) { ?> | <img src="<?php bloginfo('template_directory'); ?>/images/comments.png" width="20" height="18" alt="Comments"/> <?php comments_popup_link(esc_html__('0 comments','Polished'), esc_html__('1 comment','Polished'), '% '.esc_html__('comments','Polished')); ?><?php }; ?>
		
	<?php } elseif (is_single()) { ?>

		<?php esc_html_e('Posted','Polished'); ?> <?php if (in_array('author', get_option('polished_postinfo2'))) { ?> <?php esc_html_e('by','Polished'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('polished_postinfo2'))) { ?> <?php esc_html_e('on','Polished'); ?> <?php the_time(get_option('polished_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('polished_postinfo2'))) { ?> <?php esc_html_e('in','Polished'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('polished_postinfo2'))) { ?> | <img src="<?php bloginfo('template_directory'); ?>/images/comments.png" width="20" height="18" alt="Comments"/> <?php comments_popup_link(esc_html__('0 comments','Polished'), esc_html__('1 comment','Polished'), '% '.esc_html__('comments','Polished')); ?><?php }; ?>

	<?php }; ?>
</div>