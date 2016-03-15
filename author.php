<?php get_header(); ?>
<div id="content" class="author-content">
	<?php if (have_posts()) : the_post(); ?>
		<div class="author_posts_top clearfix">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 120 ) ); ?>
			</div>
			<h1><?php printf('%s', get_the_author() ); ?></h1>
			<div class="author-description">
				<p><?php if(get_the_author_meta( 'description' ) ){ the_author_meta( 'description' ); }else{ echo '该同志还没添加个人介绍';}; ?></p>
			</div>
			<div class="tags">
				<?php if ( get_the_author_meta('QQ') ) : ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php the_author_meta('QQ'); ?>&site=qq&menu=yes" title="Q我" target="_blank" rel="nofollow">QQ</a><?php endif; ?>
				<?php if ( get_the_author_meta('weibo') ) : ?><a href="<?php the_author_meta('weibo'); ?>" title="访问TA的微博" target="_blank" rel="nofollow">微博</a><?php endif; ?>
				<?php if ( get_the_author_meta('twitter') ) : ?><a href="<?php the_author_meta('twitter'); ?>" title="访问TA的twitter" target="_blank" rel="nofollow">推特</a><?php endif; ?>
				<?php if ( get_the_author_meta('facebook') ) : ?><a href="<?php the_author_meta('facebook'); ?>" title="访问TA的facebook" target="_blank" rel="nofollow">脸书</a><?php endif; ?>
				<?php if ( get_the_author_meta('url') ) : ?><a href="<?php the_author_meta('url'); ?>" title="访问TA的站点" target="_blank" rel="nofollow">网站</a><?php endif; ?>
				<a href="<?php echo get_author_feed_link(get_the_author_meta( 'ID' )); ?>"><span class="dashicons dashicons-rss"></span></a>
			</div>
		</div>
	<?php rewind_posts(); ?>
	<div class="post author_posts">
		<h3 class="all_posts"><span><?php printf('%s', get_the_author() ); ?> 共发布了 <?php the_author_posts(); ?> 篇文章</span></h3>
		<ul class="author_posts_list">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'contents/content', 'author' ); ?>
		<?php endwhile; else: ?>
		</ul>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>	
	</div>
	<div id="pagination" class="clearfix">
		<?php par_pagenavi('<div class="page-nav">','</div>'); ?>
	</div>
</div>
<?php get_footer(); ?>