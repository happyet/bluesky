<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?><span class="sticky"><span>[置顶]</span></span><?php endif; ?>
	<?php get_template_part( 'contents/post-author' ); ?>
	<div class="format-images-content">
		<div class="img-holder">
			<ul class="clearfix">
			<?php
				global $post;
				$postImages = '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim'; 
				preg_match_all( $postImages, $post->post_content, $allImages, PREG_PATTERN_ORDER ); 
				$num = count($allImages[1]);
				$tim_file = get_bloginfo('template_directory') . '/includes/timthumb.php?src=';
				if ( $num >= 9 ) {
					for ( $i=0; $i <= 8; $i++ ) {
						echo '<li><span style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=240&amp;h=240&amp;zc=1&amp;q=100)"></span></li>'; 
					}
				}elseif ( $num >= 6 ) {
					for ( $i=0; $i <= 5; $i++ ) { 
						echo '<li><span style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=240&amp;h=240&amp;zc=1&amp;q=100)"></span></li>'; 
					}
				}elseif (  $num >= 3 ) {
					for ( $i=0; $i <= 2; $i++ ) { 
						echo '<li><span style="background-image:url(' . $tim_file . $allImages[1][$i] . '&amp;w=240&amp;h=240&amp;zc=1&amp;q=100)"></span></li>'; 
					}
				}else{
					echo '<p>图片太少，没得搞！</p>';
				}
			?>
			</ul>
		</div>

		<div class="post_content">
		
			<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<div class="meta_container">
				<ul class="meta clearfix">
					<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
					<li><span class="dashicons dashicons-category"></span> <?php the_category(', ') ?></li>
					<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
