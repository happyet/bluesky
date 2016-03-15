<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p> 
	<?php
		return;
	}
?>
<?php //trackbacks计数分离
	$trackbacks = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' AND (comment_type = 'pingback' OR comment_type = 'trackback') ORDER BY comment_date", $post->ID));
?>
<?php if ( have_comments() ) : ?>
	<h2 id="comments">本文有评论 <?php echo (count($comments)-count($trackbacks)); ?> 条<?php if ( ! empty($trackbacks) ) : ?>，被引用 <?php echo (count($trackbacks));?> 次<?php endif; ?></h2>
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=mytheme_comment&end-callback=end_comment'); ?>
	</ol>
	<div class="comment_page_navi">
		<?php paginate_comments_links('prev_text=«&next_text=»');?>
	</div>
	<?php if ( ! empty($trackbacks) ) : //嵌套ping?>
		<ul class="pingtlist">
			<?php wp_list_comments('type=pings&callback=devepings&per_page=999'); ?>
		</ul>
	<?php endif; ?>
<?php else : // 如果没有评论 ?>
	<?php if ( comments_open() ) : //允许评论但还没有评论 ?>
		<?php else : // 评论关闭 ?>
		<p class="nocomments">评论已关闭！</p>
	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<div id="respond">
	<?php cancel_comment_reply_link() ?>
		<h3><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply for %s' ) ); ?></h3>
 
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>你必须<?php wp_loginout(); ?>才能发表评论。</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( is_user_logged_in() ) : ?>
			<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>
		<?php else : ?>
			<!-- 有资料的访客 -->
			<?php if ( $comment_author != "" ) : ?>
				<script type="text/javascript">function setStyleDisplay(id, status){document.getElementById(id).style.display = status;}</script>
				<div class="form_row small">
					<?php printf('欢迎回来 <strong>%s</strong>.', $comment_author) ?>
					<span id="show_author_info"><a href="javascript:setStyleDisplay('author_info','');setStyleDisplay('show_author_info','none');setStyleDisplay('hide_author_info','');"><?php _e('修改信息 &raquo;'); ?></a></span>
					<span id="hide_author_info"><a href="javascript:setStyleDisplay('author_info','none');setStyleDisplay('show_author_info','');setStyleDisplay('hide_author_info','none');"><?php _e('关闭 &raquo;'); ?></a></span>
				</div>
			<?php endif; ?>
			<div id="author_info">
				<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /><label for="author"><small> 昵称 <?php if ($req) _e("(required)"); ?></small></label></p>
				<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /><label for="email"><small> 邮箱 <?php if ($req) _e("(required)"); ?></small></label></p>
				<p><input type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" size="22" tabindex="3" /><label for="url"><small> 网站 </small></label></p>
			</div>
			<!-- 有资料的访客 -->
			<?php if ( $comment_author != "" ) : ?>
				<script type="text/javascript">setStyleDisplay('hide_author_info','none');setStyleDisplay('author_info','none');</script>
			<?php endif; ?>
		<?php endif; ?>
			<p><?php get_template_part( 'contents/smiley' ); ?></p>
			<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交评论/Ctrl+Enter" /><?php comment_id_fields(); ?></p>
			<?php do_action('comment_form', $post->ID); ?>
<script language="javascript">
document.getElementById("comment").onkeydown = function (moz_ev)
		{
		var ev = null;
		if (window.event){
			ev = window.event;
				}else{
				ev = moz_ev;
			}
			if (ev != null && ev.ctrlKey && ev.keyCode == 13)
			{
			document.getElementById("submit").click();
			}
		}
</script>			
</form>
	<?php endif; ?>
</div>
<?php endif; ?>