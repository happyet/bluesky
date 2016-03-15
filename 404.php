<?php get_header(); ?>
<div id="content">
	<div class="post_list">
		<div class="post 404">
			<span class="sticky"><span>[404]</span></span>
			<div class="post_content">
				<h1>木有东东哦</h1>
				<div class="entry">
					<div class="clearfix">
						<img src="<?php echo get_template_directory_uri(); ?>/images/nopost.gif" class="alignright" />
						<p>Sorry, 你可能输错了地址，或者你查看的东西已经不在了...</p>
					</div>
					<div class="clearfix">
						<h3>倾情为你推荐</h3>
						<ol>
							<?php
								$posts = get_posts('numberposts=5&orderby=rand');
								foreach($posts as $post) {
									setup_postdata($post);
									echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
								}
								$post = $posts[0];
							?>
						</ol>
					</div>
					<h3>或者再找找</h3>
					<div><?php get_search_form(); ?></div>
				</div>
				
			</div>
			<div class="meta_container">
				<div class="tags clearfix"></div>
				<ul class="meta clearfix">
					<li class="date"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">返回首页</a></li>
					<li class="read_more"><a class="back1" onclick="javascript:history.go(-1);return false;" href="javascript:;">返回上一页</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>