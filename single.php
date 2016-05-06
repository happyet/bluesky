<?php get_header(); ?>
	<div id="content">
		<div class="post_list">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post" id="post-<?php the_ID(); ?>">
					<?php get_template_part( 'contents/post-author' ); ?>
					<div class="post_content">
				            	<?php if ( has_post_thumbnail() ) { ?>
					            	<div class="pic_thumb">
						            	<a href="<?php the_permalink() ?>" rel="bookmark">	
							            	<?php the_post_thumbnail(); ?>
						            	</a>
					            	</div>
				            	<?php } ?>
				            	<h1><?php the_title(); ?></h1>
				            	<div class="meta_container">
												<ul class="meta clearfix">
													<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
													<li><span class="dashicons dashicons-category"></span> <?php the_category(', ') ?></li>
													<li><?php edit_post_link(__('<span class="dashicons dashicons-welcome-write-blog"></span> 编辑'), '',' '); ?>	</li>
													<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
												</ul>
											</div>
				         
				            	<div class="entry clearfix">
							<?php the_content(); ?>
						</div>
						<?php 
							wp_link_pages(array(
								'before' => '<p class="clear"><strong>' . __('Pages:') . '</strong> ',
								'after' => '</p>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>'
							));
						 ?>
					</div>
					<div class="meta_container clearfix">
						<h3 class="meta-title"><span>版权申明</span></h3>
						<div class="post-copy">
							<h3>未注明出处的文章均为本站原创，转载请注明出处。</h3>
							<p class="copy-link"><?php bloginfo("name"); ?> | <?php the_permalink() ?></p>
						</div>
					</div>
					<div class="tags singletags">
						<?php the_tags('', ' ', ''); ?>
					</div>
					<div class="relatepost clearfix">
						<h3 class="meta-title"><span>相关文章</span></h3>
						<ul class="clearfix">	
							<?php $post_num = 6; $exclude_id = $post->ID;$posttags = get_the_tags(); $i = 0;if ( $posttags ) { $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';$args = array('post_status' => 'publish','tag_slug__in' => explode(',', $tags), 'post__not_in' => explode(',', $exclude_id), 'ignore_sticky_posts' => 1, 'orderby' => 'comment_date', 'posts_per_page' => $post_num);query_posts($args); while( have_posts() ) { the_post(); ?><li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="relatetime">Posted on <?php the_time('Y.m.j'); ?></span></li>
							<?php $exclude_id .= ',' . $post->ID; $i ++;} wp_reset_query();}if ( $i < $post_num ) { $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';$args = array('category__in' => explode(',', $cats), 'post__not_in' => explode(',', $exclude_id),'ignore_sticky_posts' => 1,'orderby' => 'comment_date','posts_per_page' => $post_num - $i);query_posts($args);while( have_posts() ) { the_post(); ?> <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="relatetime">Posted on <?php the_time('Y.m.j'); ?></span></li>
							<?php $i ++;} wp_reset_query();}if ( $i  == 0 )  echo '<li>还没有相关文章</li>';?>
						</ul>
					</div>
				</div>
				<div id="pagination" class="clearfix">
					<?php if (get_previous_post()) : ?>
						<div id="pag-prev-wrap"><?php previous_post_link('%link','<span class="dashicons dashicons-arrow-left-alt2"></span>上一篇','','') ?></div>
					<?php endif; ?>
					<?php if (get_next_post()) : ?>
						<div id="pag-next-wrap"><?php next_post_link('%link','下一篇<span class="dashicons dashicons-arrow-right-alt2"></span>','','') ?></div>
					<?php endif; ?>
				</div>
				<?php comments_template(); ?>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>
