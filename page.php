<?php get_header(); ?>
	<div id="content">
		<div class="post_list">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="page-post" id="post-<?php the_ID(); ?>">
					<?php
						$thumb_src = get_bloginfo('template_url') . '/images/page_default.jpg';
						if ( has_post_thumbnail() ) {
							$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large')[0];
						}
					?>
					<div class="pic_thumb" style="background-image:url(<?php echo $thumb_src; ?>)"></div>
					<div class="post_content">
						<h1><?php the_title(); ?></h1>
						<ul class="meta clearfix">
							<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
							<?php edit_post_link(__('<li><span class="dashicons dashicons-welcome-write-blog"></span> 编辑</li>'), '',' '); ?>
							<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
							<li class="views"><span class="dashicons dashicons-heart"></span> 
								<?php if(function_exists('the_views')) {
									the_views();
								}elseif(function_exists('post_views')) {
									post_views();
								} ?>
							</li>
							<?php edit_post_link(__('<li><span class="dashicons dashicons-welcome-write-blog"></span> 编辑</li>'), '',' '); ?>
						</ul>
						<div class="entry clearfix">
							<?php the_content(); ?>
						</div>
						<?php wp_link_pages(array('before' => '<p class="clear"><strong>' . __('Pages:') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>')); ?>
						<div class="qrcode"><?php lms_getqrcode(); ?></div>
					</div>
				</div>
				<?php comments_template(); ?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>