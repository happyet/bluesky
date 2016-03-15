<?php
/** * WordPress 內置嵌套評論專用 Ajax comments >> WordPress-jQuery-Ajax-Comments v1.3 by Willin Kan. */
if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}
require( dirname(__FILE__) . '/../../../../wp-load.php' );
nocache_headers();
$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
$post = get_post($comment_post_ID);
if ( empty($post->comment_status) ) {
	do_action('comment_id_not_found', $comment_post_ID);
	err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
}
$status = get_post_status($post);
$status_obj = get_post_status_object($status);
if ( !comments_open($comment_post_ID) ) {
	do_action('comment_closed', $comment_post_ID);
	err(__('Sorry, comments are closed for this item.')); // 將 wp_die 改為錯誤提示
} elseif ( 'trash' == $status ) {
	do_action('comment_on_trash', $comment_post_ID);
	err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
} elseif ( !$status_obj->public && !$status_obj->private ) {
	do_action('comment_on_draft', $comment_post_ID);
	err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
} elseif ( post_password_required($comment_post_ID) ) {
	do_action('comment_on_password_protected', $comment_post_ID);
	err(__('Password Protected')); // 將 exit 改為錯誤提示
} else {
	do_action('pre_comment_on_post', $comment_post_ID);
}
$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id
$user = wp_get_current_user();
if( $user->exists() ){
		if( empty( $user->display_name ) ) $user->display_name = $user->user_login;
		$comment_author = esc_sql( $user->display_name );
		$comment_author_email = esc_sql( $user->user_email );
		$comment_author_url = esc_sql( $user->user_url );
		$user_ID = esc_sql( $user->ID );
	if ( current_user_can('unfiltered_html') ) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if ( get_option('comment_registration') || 'private' == $status )
		err(__('对不起，可恶的博主设置了登陆后才能评论。')); // 將 wp_die 改為錯誤提示
}
$comment_type = '';
if ( get_option('require_name_email') && !$user->ID ) {
	if ( 6 > strlen($comment_author_email) || '' == $comment_author )
		err( __('大名和Email都必须填，不然我真不知道你是谁。') ); // 將 wp_die 改為錯誤提示
	elseif ( !is_email($comment_author_email))
		err( __('你的Email地址是不是搞错了，比如标点啥的？') ); // 將 wp_die 改為錯誤提示
}

if ( '' == $comment_content )
	err( __('你要我提交的内容是什么，我怎么没看见？') ); // 將 wp_die 改為錯誤提示
function err($ErrMsg) {
    header('HTTP/1.1 405 Method Not Allowed');
    echo $ErrMsg;
    exit;
}
$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ( $wpdb->get_var($dupe) ) {
    err(__('系统发现你可能回复过同样的内容，要不要检查一下看看？'));
}
if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) { 
$time_lastcomment = mysql2date('U', $lasttime, false);
$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
if ( $flood_die ) {
    err(__('一休哥你说的太快了，休息！休息！！'));
	}
}
$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
if ( $edit_id ){
$comment_id = $commentdata['comment_ID'] = $edit_id;
wp_update_comment( $commentdata );
} else {
$comment_id = wp_new_comment( $commentdata );
}
$comment = get_comment($comment_id);
if ( !$user->ID ) {
	$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
	setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
}
$comment_depth = 1;   //为评论的 class 属性准备的
$tmp_c = $comment;
while($tmp_c->comment_parent != 0){
$comment_depth++;
$tmp_c = get_comment($tmp_c->comment_parent);
}
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-body">
		<div class="comment-avatar">
			<?php echo get_avatar($comment, $size = '40', ''); ?><a class="notes-overlay"></a>
		</div>
		<div class="commenttext">
			<?php comment_text() ?>
			<?php if ($comment->comment_approved == '0'): ?>
				<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<?php endif; ?>
		</div>
		<div class="comment-author vcard">
			<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
			<?php time_diff($time_type = 'comment'); ?>
			<span class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)') , '  ', '') ?></span>
		</div>
	</div>