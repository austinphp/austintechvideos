<?php if ( ! function_exists( 'et_custom_comments_display' ) ) :
function et_custom_comments_display($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	  <div class="comment-top-left"></div>
	  <div class="comment-top-main"></div>
	  <div class="bubble"></div>
	  <div class="comment-top-right"></div>
   <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='50'); ?>
		 <div class="comment-info">		
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>','Polished'), get_comment_author_link()) ?>
			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s at %2$s','Polished'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(esc_html__('(Edit)','Polished'),'  ','') ?></div>
		 </div> <!-- end comment-info-->  
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em class="moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
		
	  <div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
	  <?php 
			$et_comment_reply_link = get_comment_reply_link( array_merge( $args, array('reply_text' => esc_attr__('reply','Polished'),'depth' => $depth, 'max_depth' => $args['max_depth'])) );
			if ( $et_comment_reply_link ) echo '<div class="reply-container">' . $et_comment_reply_link . '</div>';
		?>
	</div> <!-- end comment-body-->
	<div class="comment-bottom-left"></div><div class="comment-bottom-right"></div>	
<?php }
endif; ?>