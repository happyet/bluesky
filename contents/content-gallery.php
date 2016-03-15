<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?><span class="sticky"><span>[置顶]</span></span><?php endif; ?>
				<div class="author_show">
					<div class="author_face"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'author_bio_avatar_size', 60 ) ); ?></div>
					<div class="author_detail">
						<p>Posted by: <br><span class="author_name"><?php printf(get_the_author() ); ?></span> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="去看看TA的作品"><?php the_author_posts(); ?> 篇</a> <?php if ( get_the_author_meta('QQ') ) : ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php the_author_meta('QQ'); ?>&site=qq&menu=yes" title="Q我" target="_blank">QQ</a><?php endif; ?></p>
						<h2><?php if(get_the_author_meta( 'description' ) ){ the_author_meta( 'description' ); }else{ echo '该同志还没添加个人介绍';}; ?></h2>
					</div>
					<span class="views"><?php if(function_exists('the_views')) { the_views(); }elseif(function_exists('post_views')) { post_views(); } ?></span>
				</div>
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
