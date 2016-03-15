<?php get_header(); ?>
<div id="content">
	<div class="post_list">
		<?php if ( have_posts() ) : ?>
			<div class="archive-title post clearfix">
				<?php 
					the_archive_title( '<h3>', '</h3>' );
					the_archive_description('<div class="archive-description">','</div>');
				?>
			</div>
		<?php while (have_posts()) : the_post(); ?>
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