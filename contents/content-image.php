<div onclick="javascript:window.location.href='<?php the_permalink() ?>'" class="pic_thumb img-holder">
	<ul class="clearfix">
	<?php
		global $post;
		$postImages = '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim'; 
		preg_match_all( $postImages, $post->post_content, $allImages, PREG_PATTERN_ORDER ); 
		$num = count($allImages[1]);
		$tim_file = get_bloginfo('template_directory') . '/includes/timthumb.php?src=';
		if ( $num >= 9 ) {
			for ( $i=0; $i <= 7; $i++ ) {
				echo '<li class="col-8 col-8-'.$i.'" style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=160&amp;h=160&amp;zc=1&amp;q=100)"></li>'; 
			}
		}elseif ( $num >= 6 ) {
			for ( $i=0; $i <= 5; $i++ ) { 
				echo '<li class="col-6 col-6-'.$i.'" style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=315&amp;h=300&amp;zc=1&amp;q=100)"></li>'; 
			}
		}elseif (  $num >= 3 ) {
			for ( $i=0; $i <= 2; $i++ ) { 
				echo '<li class="col-5 col-3-'.$i.'" style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=315&amp;h=300&amp;zc=1&amp;q=100)"></li>'; 
			}
		}else{
			echo '<p>图片太少，没得搞！</p>';
		}
	?>
	</ul>
	<span class="dashicons dashicons-format-gallery"></span>
</div>
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
			<li title="图片数量"><span class="dashicons dashicons-images-alt2"></span> <?php echo $num; ?></li>
			<li class="read_more"><a href="<?php the_permalink() ?>" rel="bookmark"><span class="dashicons dashicons-welcome-view-site"></span> Read More...</a></li>
		</ul>
	</div>
</div>
