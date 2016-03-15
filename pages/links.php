<?php
/*
Template Name: 友情链接
*/
?>
<?php get_header(); ?>
<div id="content">
	<div class="post_list">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post page-post" id="post-<?php the_ID(); ?>">
			<div class="page_thumb"">
				<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail(); ?>
				<?php } else {?>
					<img src="<?php bloginfo('template_url'); ?>/images/page_default.jpg" />
				<?php } ?>
			</div>
			<div class="post_content">
				<h1><?php the_title(); ?></h1>
				<ul class="meta clearfix">
					<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
					<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
					<?php edit_post_link(__('<li><span class="dashicons dashicons-welcome-write-blog"></span> 编辑</li>'), '',' '); ?>		
					<li class="read_more qrcode-li"><span class="dashicons dashicons-vault"></span> 二维码
						<div class="qrcode"><?php lms_getqrcode(); ?></div>
					</li>
				</ul>
				<div class="entry">
					<?php the_content(); ?>

					<?php $link_cats = get_terms( 'link_category' );
					if($link_cats) : foreach($link_cats as $linkcat) : ?>
					<div class="blogroll-catigories"><h3><?php echo $linkcat->name; ?></h3>
						<ul class="xoxo blogroll">
							<?php 
								$bookmarks = get_bookmarks('orderby=date&category_name=' . $linkcat->name);
								if ( !empty($bookmarks) ) {
									foreach ($bookmarks as $bookmark) {
										echo '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" ><img width="16px";height="16px"; src="' . $bookmark->link_url . '/favicon.ico" onerror="javascript:this=\'wp-content/themes/bluesky/images/link-default.png\'" />' . $bookmark->link_name . '</a></li>';
									}
								}
							?>
						</ul>
					</div>
					<?php endforeach; endif; ?>	
				</div>
			</div>
		</div>
		<?php comments_template(); ?>
		<?php endwhile; endif; ?>
	</div>
<?php get_footer(); ?>