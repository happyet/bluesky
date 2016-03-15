<?php
/*
Template Name: 留言本
*/
?>
<?php get_header(); ?>
<div id="content">
	<div class="post_list">
		<div class="friends">
			<ul class="clearfix">
				<?php
					global $wpdb;
					$email = get_bloginfo('admin_email');
					$sql = "SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type 
					FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts 
					ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) 
					WHERE comment_author_email != '$email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt
					GROUP BY comment_author ORDER BY cnt DESC LIMIT 98"; 
					$counts = $wpdb->get_results($sql);
					foreach ($counts as $count) {
						if($count->comment_author_url == ''){$url = '火星';}else{$url = $count->comment_author_url;}
						$output .= '<li class="uface">' . '<a href="'. $count->comment_author_url . '" target="_blank">' . get_avatar($count->comment_author_email,72) . '</a><div class="author_detail"><p>大名：' . $count->comment_author . '</p><p>来自：' . $url . '</p><p>我在【'. get_bloginfo('name') .'】上已累计评论 ' . $count->cnt . ' 条';
						if($count->cnt >= 10){
							$output .= '，博主要奖励我什么呢？';
						}else{
							$output .= '，要经常来多努力，争取赶上前面同学哦！';
						}
						$output .= '</p></div></li>';
					}
					echo $output;
				?>
			</ul>
		</div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post page-post" id="post-<?php the_ID(); ?>">
				<div class="post_content">
					<h1><?php the_title(); ?></h1>
					<ul class="meta clearfix">
						<li class="date"><span class="dashicons dashicons-clock"></span> <?php the_time('Y-m-d'); ?></li>
						<li class="comments"><?php comments_popup_link(__('<span class="dashicons dashicons-testimonial"></span> 0'), __('<span class="dashicons dashicons-testimonial"></span> 1'), __('<span class="dashicons dashicons-testimonial"></span> %'), '', __('<span class="dashicons dashicons-welcome-comments"></span> 已关闭评论') ); ?></li>
						<?php edit_post_link(__('<li><span class="dashicons dashicons-welcome-write-blog"></span> 编辑</li>'), '',' '); ?>		
						<li class="read_more qrcode-li"><span class="dashicons dashicons-vault"></span> 二维码
							<div class="qrcode"><?php lms_getqrcode(); ?></div>
						</li>
					</ul>
					<div class="entry clearfix">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<?php comments_template(); ?>
		<?php endwhile; endif; ?>
	</div>
<?php get_footer(); ?>