<div class="post_wrap">
<?php
	$thumb_src = '';
	if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		$thumb_src = $thumb[0];
	}elseif( thumb_image() ) {
		$thumb_src = thumb_image(false);
	}
	if($thumb_src){
?>
	<div onclick="javascript:window.location.href='<?php the_permalink() ?>'" class="pic_thumb" style="background-image:url(<?php echo $thumb_src; ?>)">
		<?php if ( is_sticky()){ ?><span class="dashicons dashicons-star-filled"></span><?php }else{ ?><span class="dashicons dashicons-format-aside"></span><?php } ?>
	</div>
<?php } ?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?><span class="sticky"><span>[置顶]</span></span><?php endif; ?>
	<?php get_template_part( 'contents/post-author' ); ?>
	<div class="post_content">
		<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="entry">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<div class="meta_container">
		<div class="tags clearfix"><?php the_category(' ') ?> <?php the_tags('', ' ', ''); ?></div>
		<ul class="meta clearfix">
			<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
			<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
			<li class="read_more"><a href="<?php the_permalink() ?>" rel="bookmark"><span class="dashicons dashicons-randomize"></span> Read More...</a></li>
		</ul>
	</div>
</div>
</div>