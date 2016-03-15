<li>
	<div class="clearfix">
		<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php if ( is_sticky()) : ?><span class="dashicons dashicons-admin-post"></span><?php endif; ?> <?php the_title(); ?></a></h1>
		<ul class="meta_right">
			<li><span class="dashicons dashicons-category"></span> <?php the_category(' ') ?></li>
			<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
			<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
		</ul>
	</div>
</li>