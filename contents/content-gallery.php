<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?><span class="sticky"><span>[置顶]</span></span><?php endif; ?>
				<?php get_template_part( 'contents/post-author' ); ?>
	<div class="post_content">
					<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="entry">
		<?php if ( is_single() || ! get_post_gallery() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		<?php else : ?>
			<?php echo get_post_gallery(); ?>
		<?php endif; // is_single() ?>
	</div>
				</div>
				<div class="meta_container">
					<div class="tags clearfix"><?php the_category(' ') ?> <?php the_tags('', ' ', ''); ?></div>
					<ul class="meta clearfix">
						<li class="date"><a><?php the_time('Y-m-d'); ?></a></li>
						<li class="comments"><?php comments_popup_link(__('No Comment'), __('1 Comment'), __('% Comments'), '', __('已关闭评论') ); ?></li>
						<li class="read_more"><a href="<?php the_permalink() ?>" rel="bookmark">Read More...</a></li>
					</ul>
				</div>
			</div>
			<div class="post-bottom"></div>
