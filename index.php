<?php get_header(); ?>
<div id="content">
	<div class="post_list">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'contents/content', get_post_format() ); ?>
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
		<div id="pagination" class="clearfix">
			<?php par_pagenavi('<div class="page-nav">','</div>'); ?>
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>