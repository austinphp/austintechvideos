<!-- New Post-->
<div class="new_post">
	<h2 class="title"><?php the_title(); ?></h2>
	<div class="postcontent">
		<?php global $more;   
			  $more = 0; 
		the_content(""); ?>

		<div class="clear"></div>
	</div>	<!-- end .postcontent -->
</div>