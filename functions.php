<?php
// +----------------------------------------------------------------------+
// | bluesky 3 functions.php									          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 LMS.IM                                            |
// +----------------------------------------------------------------------+
// | 部分代码收集自网络，由《不亦乐乎》编辑整理，                         |
// | 使用主题请保留版权链接，谢谢！                                       |
// | 自娱自乐，不亦乐乎！                                                 |
// | http://lms.im                                                        |
// +----------------------------------------------------------------------+
// | Authors: 不亦乐乎 <i@lms.im>                                         |
// | donate:                                                              |
// +----------------------------------------------------------------------+
//
require get_template_directory() . '/includes/custom-header.php';
require get_template_directory() . '/includes/blueskywidget.php';
require get_template_directory() . '/includes/update.php';
if(is_admin()) require get_template_directory() . '/includes/theme-options.php';
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => '通用侧边栏',
        'id' => 'main-aside',
        'description' => '显示在博客各页面的通用侧边栏。',
        'before_widget' => '<div id="%1$s" class="widget sidebar-box %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => '首页侧边栏',
        'id' => 'home-aside',
        'description' => '显示在博客首页的专用侧边栏。',
        'before_widget' => '<div id="%1$s" class="widget sidebar-box %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => '文章页侧边栏',
        'id' => 'single-aside',
        'description' => '显示在博客文章页面的专用侧边栏（含 page 页面）。',
        'before_widget' => '<div id="%1$s" class="widget sidebar-box %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => '栏目分类页侧边栏',
        'id' => 'category-aside',
        'description' => '显示在博客栏目分类页面的专用侧边栏。',
        'before_widget' => '<div id="%1$s" class="widget sidebar-box %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));
}

function bluesky_theme_setup() {
	load_theme_textdomain( 'bluesky', get_template_directory() . '/languages' );
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'image', 'link', 'quote', 'status', 'audio','gallery' ) );
	register_nav_menus( array('header-menu' => '顶部导航', 'footer-menu' => '底部自定义菜单','mobile-menu' => '手机菜单' ));
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(470, 210);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_filter('the_content', 'wptexturize');
	add_filter('pre_option_link_manager_enabled', '__return_true');
	remove_action('pre_post_update', 'wp_save_post_revision');
	add_filter('use_default_gallery_style', '__return_false');
	add_action('wp_print_scripts', 'disable_autosave');
	function disable_autosave() { wp_deregister_script('autosave'); }
	add_filter('show_admin_bar', '__return_false');
}
add_action( 'after_setup_theme', 'bluesky_theme_setup' );

function bluesky_theme_scripts_styles() {
	global $wp_styles;
	$options = get_option('hy_options');
	$theme_dir = get_bloginfo('template_directory');
	wp_deregister_script('jquery');
    wp_register_script('jquery',  $theme_dir . '/js/jquery-1.11.1.min.js',array(), null, true);
	wp_enqueue_script('happyet', $theme_dir . '/js/main.js', array('jquery'), null, true);
	wp_deregister_script('comment-reply');
    wp_register_script('comment-reply', $theme_dir . '/js/comments-ajax.js', array('jquery') , null, true);
	if ( is_singular()){
		wp_localize_script( 'happyet', 'ajax_url', $theme_dir);
		if(comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script('thickbox');
	wp_enqueue_style( 'awesome', $theme_dir . '/css/font-awesome.min.css');
	wp_enqueue_style( 'bluesky-style', get_stylesheet_uri() );
	if ($options['star_background'] == true) wp_enqueue_style( 'bluesky-bg', $theme_dir . '/css/stars.css', array('bluesky-style'), '' );
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'bluesky-ie', $theme_dir . '/css/ie.css', array( 'bluesky-style' ), '20141212' );
	$wp_styles->add_data( 'bluesky-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'bluesky_theme_scripts_styles' );
function cut_str($src_str, $cut_length) {
    $return_str = '';
    $i = 0;
    $n = 0;
    $str_length = strlen($src_str);
    while (($n < $cut_length) && ($i <= $str_length)) {
        $tmp_str = substr($src_str, $i, 1);
        $ascnum = ord($tmp_str);
        if ($ascnum >= 224) {
            $return_str = $return_str . substr($src_str, $i, 3);
            $i = $i + 3;
            $n = $n + 2;
        } elseif ($ascnum >= 192) {
            $return_str = $return_str . substr($src_str, $i, 2);
            $i = $i + 2;
            $n = $n + 2;
        } elseif ($ascnum >= 65 && $ascnum <= 90) {
            $return_str = $return_str . substr($src_str, $i, 1);
            $i = $i + 1;
            $n = $n + 2;
        } else {
            $return_str = $return_str . substr($src_str, $i, 1);
            $i = $i + 1;
            $n = $n + 1;
        }
    }
    if ($i < $str_length) {
        $return_str = $return_str . '';
    }
    if (get_post_status() == 'private') {
        $return_str = $return_str . '（private）';
    }
    return $return_str;
}

function my_profile($contactmethods) {
    $contactmethods['QQ'] = 'QQ';
    $contactmethods['weibo'] = '微博';
    $contactmethods['twitter'] = '推特';
    $contactmethods['facebook'] = '脸书';
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    return $contactmethods;
}
add_filter('user_contactmethods', 'my_profile');
//~ 反解析地址函数
if( ! function_exists('unparse_url') ){
	function unparse_url($parsed_url){
		$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
		$pass = ($user || $pass) ? "$pass@" : '';
		$path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}
}
//~ 通过解析地址科学替换网址
function dmeng_replace_gravatar_host($url){
	//~ 解析地址
	$url = parse_url($url);
	if( strpos( $url['host'], 'gravatar.com') !== false ){
		//~ 替换为 https 协议
		$url['scheme'] = 'https';
		//~ 替换为 https 的域名
		$url['host'] = 'secure.gravatar.com';
	}
	//~ 反解析地址
	$url = unparse_url($url);
	return $url;
}
//~ gravatar 替换为 https 线路，http 线路国内已被墙
function dmeng_get_https_avatar($avatar){
	//~ 匹配头像地址
	preg_match( "|src='([^']+)'|", $avatar, $matches );
	//~ 替换地址的协议和网址
	$image_url = dmeng_replace_gravatar_host($matches[1]);
	//~ 解析地址
	$url = parse_url($matches[1]);
	//~ 解析参数
	parse_str( htmlspecialchars_decode($url['query']), $query_args);
	//~ 如果设置有默认头像并且是Gravatar，则也替换默认头像的地址的协议和网址
	if( isset($query_args['d']) ){
		if(strpos($query_args['d'], 'gravatar.com') !== false){
			$image_url = str_replace( urlencode($query_args['d']), urlencode(dmeng_replace_gravatar_host($query_args['d'])), $image_url );
		}
	}
	//~ 替换头像HTML的地址
	$avatar = str_replace( $matches[1], $image_url, $avatar);
return $avatar;
}
add_filter('get_avatar', 'dmeng_get_https_avatar');

function search_filter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts', 'search_filter');
function lmsim_keywords() {
    global $s, $post;
    $keywords = '';
    if (is_single()) {
        if (get_the_tags($post->ID)) {
            foreach (get_the_tags($post->ID) as $tag) $keywords.= $tag->name . ', ';
        }
        foreach (get_the_category($post->ID) as $category) $keywords.= $category->cat_name . ', ';
        $keywords = substr_replace($keywords, "", -2);
    } elseif (is_home()) {
        $options = get_option('hy_options');
        $keywords = $options['blog_keywords'];
    } elseif (is_tag()) {
        $keywords = single_tag_title('', false);
    } elseif (is_category()) {
        $keywords = single_cat_title('', false);
    } elseif (is_search()) {
        $keywords = esc_html($s, 1);
    } else {
        $keywords = trim(wp_title('', false));
    }
    if ($keywords) {
        echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
    }
}
function lmsim_description() {
    global $s, $post;
    $description = '';
    $blog_name = get_bloginfo('name');
    if (is_singular()) {
        if (!empty($post->post_excerpt)) {
            $text = $post->post_excerpt;
        } else {
            $text = $post->post_content;
        }
        $description = trim(str_replace(array(
            "\r\n",
            "\r",
            "\n",
            "　",
            " "
        ) , " ", str_replace("\"", "'", strip_tags($text))));
        if (!($description)) $description = $blog_name . " - " . trim(wp_title('', false));
    } elseif (is_home()) {
        $options = get_option('hy_options');
        $description = $options['blog_description'];
    } elseif (is_tag()) {
        $description = $blog_name . "有关 '" . single_tag_title('', false) . "' 的文章";
    } elseif (is_category()) {
        $description = $blog_name . single_cat_title('', false) . "栏目下关于" . trim(strip_tags(category_description())) . "的文章";
    } elseif (is_archive()) {
        $description = $blog_name . "在: '" . trim(wp_title('', false)) . "' 的文章";
    } elseif (is_search()) {
        $description = $blog_name . ": '" . esc_html($s, 1) . "' 的搜索結果";
    } else {
        $description = $blog_name . "有关 '" . trim(wp_title('', false)) . "' 的文章";
    }
    $description = cut_str($description, 400);
    echo "<meta name=\"description\" content=\"$description\" />\n";
}
function happyet_record_views() {
    if (is_singular()) {
        global $post, $user_ID;
        $post_ID = $post->ID;
        if (empty($_COOKIE[USER_COOKIE]) && intval($user_ID) == 0) {
            if ($post_ID) {
                $post_views = (int)get_post_meta($post_ID, 'views', true);
                if (!update_post_meta($post_ID, 'views', ($post_views + 1))) {
                    add_post_meta($post_ID, 'views', 1, true);
                }
            }
        }
    }
}
add_action('wp_head', 'happyet_record_views');
function post_views($before = '', $after = '', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) {
        echo $before, format_num($views) , $after;
    } else {
        return format_num($views);
    }
}
function format_num($number) {
    if($number >= 1000) {
       return round($number/1000,1) . "k";
    }
    else {
        return $number;
    }
}
function add_gallery_id_rel($link) {
    global $post;
    return str_replace('<a href', '<a class="thickbox" rel="gallery-'. $post->ID .'" href', $link);
}
add_filter('wp_get_attachment_link', 'add_gallery_id_rel');

function thickbox( $content ){
	global $post;
	return preg_replace( '/<a(.*?)href=(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i', '<a$1href=$2.$3" $4 class="thickbox" rel="gallery-'. $post->ID .'">', $content );
}
add_filter( 'the_content', 'thickbox', 2 );
function hy_continue_reading_link() {
    return '';
}
function hy_auto_excerpt_more($more) {
    return ' &hellip;' . hy_continue_reading_link();
}
add_filter('excerpt_more', 'hy_auto_excerpt_more');
function hy_excerpt_length($length) {
    return 150;
}
add_filter('excerpt_length', 'hy_excerpt_length');
function thumb_image($type=true) {
    global $post, $posts, $title;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if($output > 0){
		$first_img = $matches[1][0];
		if($type==true){
			return $show_img = "<img src=\"" . $first_img . "\"  alt=\"" . get_the_title() . "\" />";
		}else{
			return $first_img;
		}
    }
}
function time_diff($time_type) {
    switch ($time_type) {
        case 'comment':
            $time_diff = current_time('timestamp') - get_comment_time('U');
            if ($time_diff <= 604800) echo human_time_diff(get_comment_time('U') , current_time('timestamp')) . '前';
            else printf(__('%1$s at %2$s') , get_comment_date() , get_comment_time());
            break;

        case 'post';
        $time_diff = current_time('timestamp') - get_the_time('U');
        if ($time_diff <= 43200) echo '<span class="red">NEW! </span>';
        elseif ($time_diff <= 604800) echo human_time_diff(get_the_time('U') , current_time('timestamp')) . '前';
        else the_time('Y-m-d');
        break;
    }
}
function lms_getqrcode() {
    $qrcode_img = '<img src="http://s.jiathis.com/qrcode.php?url=' . get_permalink() . '?via=wechat_qr" alt="二维码"/>';
    echo $qrcode_img;
}
function fb_addgravatar($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory') . '/images/default.jpg';
    $avatar_defaults[$myavatar] = '自定义头像';
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'fb_addgravatar');
function scp_comment_post($incoming_comment) {
    $pattern = '/[一-龥]/u';
    if (!preg_match($pattern, $incoming_comment['comment_content'])) {
        err("为防止垃圾评论，您的评论中必须包含汉字!");
    }
    return ($incoming_comment);
}
add_filter('preprocess_comment', 'scp_comment_post');
function CheckEmailAndName() {
    global $wpdb;
    $comment_author = (isset($_POST['author'])) ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = (isset($_POST['email'])) ? trim($_POST['email']) : null;
    if (!$comment_author || !$comment_author_email) {
        return;
    }
    $result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
    if ($result_set) {
        if ($result_set[0]->display_name == $comment_author) {
            err(__('<span class="red">大丈夫行不改名坐不改姓，何必冒充他人？！</span>'));
        } else {
            err(__('<span class="red">你的邮箱可能是注册用户邮箱，须登陆评论！</span>'));
        }
        fail($errorMessage);
    }
}
add_action('pre_comment_on_post', 'CheckEmailAndName');
function custom_smilies_src ($img_src, $img, $siteurl){
	return get_template_directory_uri() .'/images/smilies/'.$img;
}
add_filter('smilies_src','custom_smilies_src',1,10);
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount, $comment_depth, $page, $wpdb;
	$commentcountText = '';
    if ((int)get_option('page_comments') === 1 && (int)get_option('thread_comments') === 1) {
        if (!$commentcount) {
            $page = (!empty($in_comment_loop)) ? get_query_var('cpage') : get_page_of_comment($comment->comment_ID, $args);
            $cpp = get_option('comments_per_page');
            if (get_option('comment_order') === 'desc') {
                $comments = get_comments(array('status' => 'approve','parent' => '0','post_id' => $comment->comment_post_ID,'count' => true));
                if (ceil($comments / $cpp) == 1 || ($page > 1 && $page == ceil($comments / $cpp))) {
                    $commentcount = $comments + 1;
                } else {
                    $commentcount = $cpp * $page + 1;
                }
            } else {
                $commentcount = $cpp * ($page - 1);
            }
        }
        if (!$parent_id = $comment->comment_parent) {
            if (get_option('comment_order') === 'desc') {
                $commentcountText.= --$commentcount . '楼';
            } else {
                switch ($commentcount) {
                    case 0:
                        $commentcountText.= '沙发！';
                        ++$commentcount;
                        break;

                    case 1:
                        $commentcountText.= '板凳！';
                        ++$commentcount;
                        break;

                    case 2:
                        $commentcountText.= '地板！';
                        ++$commentcount;
                        break;

                    default:
                        $commentcountText.= ++$commentcount . '楼';
                        break;
                }
            }
        }
    } ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-avatar">
				<?php echo get_avatar($comment, $size = '40', ''); ?>
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
				<span class="floor"><?php echo $commentcountText; ?></span>
				<span class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)') , '  ', '') ?></span>
				<span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '<span class="dashicons dashicons-controls-repeat"></span>回复', 'add_below' =>'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
			</div>
		</div>
<?php
}
function end_comment() {
    echo '</li>';
}
function devepings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?><li id="comment-<?php
    comment_ID(); ?>"><?php
    comment_author_link(); ?><?php
}
function comment_code_filter($incoming_comment) {
    $incoming_comment = htmlspecialchars($incoming_comment, ENT_QUOTES);
    return $incoming_comment;
}
add_filter('comment_text', 'comment_code_filter');
add_filter('comment_text_rss', 'comment_code_filter');
function theme_copyright() {
    $options = get_option('hy_options');$url = '<a href="';$url.= 'htt';$url.= 'p://l';$url.= 'm';$url.= 's.i';$url.= 'm" tar';$url.= 'get="_blan';$url.= 'k" title="自';$url.= '娱自乐，不';$url.= '亦乐乎！">不';$url.= '亦乐乎</a>.<br />' . $options['analytics_content'] . '</p>';
    return $url;
}
function blog_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate,YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'");
    $output = '';
    if ($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright.= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}
function copyright() {
    if (function_exists("theme_copyright")) {
        $options = get_option('hy_options');
		$site_time = $options['blog_date'];
		if(empty($site_time)) { 
			$output = '<p class="copyright">' . blog_copyright() . ' ' . get_bloginfo('name') . '. ' . $options['icpbei'] . '<br /> Powered by <a href="http://www.wordpress.org" target="_blank" rel="external">WordPress</a>, Theme by ' . theme_copyright();
		}else{
			if (floor((date('Y') - date("Y",strtotime($site_time))) > 0) ){
				$output = '<p class="copyright"> &copy' . date("Y",strtotime($site_time)) . ' - ' . date('Y') . ' ' .  get_bloginfo('name') . '. ' . $options['icpbei'] . '<br /> Powered by <a href="http://www.wordpress.org" target="_blank" rel="external">WordPress</a>, Theme by ' . theme_copyright();
			}else{
				$output = '<p class="copyright"> &copy' . date('Y') . ' ' .  get_bloginfo('name') . '. ' . $options['icpbei'] . '<br /> Powered by <a href="http://www.wordpress.org" target="_blank" rel="external">WordPress</a>, Theme by ' . theme_copyright();
			}
		}
    }
    return $output;
}
function bluesky_theme_statistics(){
	wp_remote_post( 'http://api.lms.im/index.php', array( 'body' => array(
		'url'        => home_url(),
		'name'       => get_bloginfo( 'name' ),
		'theme'      => get_stylesheet(),
		'version'    => wp_get_theme()->get( 'Version' ),
		'wp_version' => $GLOBALS['wp_version']
	) ) );
}
add_action( 'after_switch_theme', 'bluesky_theme_statistics', 18, 2 );
function comment_mail_notify($comment_id) {
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '您在 [' . get_option("blogname") . '] 的留言被围观';
        $message = '<div style="color: #111; padding: 0 15px;"><p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p><p>您在《' . get_the_title($comment->comment_post_ID) . '》的留言:</p><p style="background-color: #eef2fa; border: 1px solid #d8e3e8; color: #111; padding:15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">' . trim(get_comment($parent_id)->comment_content) . '</p><p>被' . trim($comment->comment_author) . ' 围观:</p><p style="background-color: #eef2fa; border: 1px solid #d8e3e8; color: #111; padding:15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">' . trim($comment->comment_content) . '<br /></p><p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array(
            'type' => 'comment'
        ))) . '">这里查看围观內容。</a></p><p><a href="' . get_option('home') . '">' . get_option('blogname') . '</a>-' . get_option('home') . '欢迎您的再度光临！</p><p>(此邮件由系统自动发出, 请勿回复.)</p></div>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}
add_action('comment_post', 'comment_mail_notify');
$match_num_from = 1;
$match_num_to = 1;
add_filter('the_content', 'tag_link', 1);
function tag_sort($a, $b) {
    if ($a->name == $b->name) return 0;
    return (strlen($a->name) > strlen($b->name)) ? -1 : 1;
}
function tag_link($content) {
    global $match_num_from, $match_num_to;
    $posttags = get_the_tags();
	$ex_word = '';
	$case = '';
    if ($posttags) {
        usort($posttags, "tag_sort");
        foreach ($posttags as $tag) {
            $link = get_tag_link($tag->term_id);
            $keyword = $tag->name;
            $cleankeyword = stripslashes($keyword);
            $url = "<a href=\"$link\" title=\"" . str_replace('%s', addcslashes($cleankeyword, '$') , __('View all posts in %s')) . "\"";
            $url.= ' target="_blank" class="tag_link"';
            $url.= ">" . addcslashes($cleankeyword, '$') . "</a>";
            $limit = rand($match_num_from, $match_num_to);
            $content = preg_replace('|(<a[^>]+>)(.*)(' . $ex_word . ')(.*)(</a[^>]*>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
            $content = preg_replace('|(<img)(.*?)(' . $ex_word . ')(.*?)(>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
            $cleankeyword = preg_quote($cleankeyword, '\'');
            $regEx = '\'(?!((<.*?)|(<a.*?)))(' . $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
            $content = preg_replace($regEx, $url, $content, $limit);
            $content = str_replace('%&&&&&%', stripslashes($ex_word) , $content);
        }
    }
    return $content;
}
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );
//修复4.2表情bug
function lmsim_disable_emoji9s_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array(
            'wpemoji'
        ));
    } else {
        return array();
    }
}
function custom_gitsmilie_src($old, $img) {
    return get_stylesheet_directory_uri() . '/images/smilies/' . $img;
}
function init_gitsmilie() {
    global $wpsmiliestrans;
    //默认表情文本与表情图片的对应关系(可自定义修改)
    $wpsmiliestrans = array(
        ':mrgreen:' => 'icon_mrgreen.gif',
        ':neutral:' => 'icon_neutral.gif',
        ':twisted:' => 'icon_twisted.gif',
        ':arrow:' => 'icon_arrow.gif',
        ':shock:' => 'icon_eek.gif',
        ':smile:' => 'icon_smile.gif',
        ':???:' => 'icon_confused.gif',
        ':cool:' => 'icon_cool.gif',
        ':evil:' => 'icon_evil.gif',
        ':grin:' => 'icon_biggrin.gif',
        ':idea:' => 'icon_idea.gif',
        ':oops:' => 'icon_redface.gif',
        ':razz:' => 'icon_razz.gif',
        ':roll:' => 'icon_rolleyes.gif',
        ':wink:' => 'icon_wink.gif',
        ':cry:' => 'icon_cry.gif',
        ':eek:' => 'icon_surprised.gif',
        ':lol:' => 'icon_lol.gif',
        ':mad:' => 'icon_mad.gif',
        ':sad:' => 'icon_sad.gif',
        '8-)' => 'icon_cool.gif',
        '8-O' => 'icon_eek.gif',
        ':-(' => 'icon_sad.gif',
        ':-)' => 'icon_smile.gif',
        ':-?' => 'icon_confused.gif',
        ':-D' => 'icon_biggrin.gif',
        ':-P' => 'icon_razz.gif',
        ':-o' => 'icon_surprised.gif',
        ':-x' => 'icon_mad.gif',
        ':-|' => 'icon_neutral.gif',
        ';-)' => 'icon_wink.gif',
        '8O' => 'icon_eek.gif',
        ':(' => 'icon_sad.gif',
        ':)' => 'icon_smile.gif',
        ':?' => 'icon_confused.gif',
        ':D' => 'icon_biggrin.gif',
        ':P' => 'icon_razz.gif',
        ':o' => 'icon_surprised.gif',
        ':x' => 'icon_mad.gif',
        ':|' => 'icon_neutral.gif',
        ';)' => 'icon_wink.gif',
        ':!:' => 'icon_exclaim.gif',
        ':?:' => 'icon_question.gif',
    );
    //移除WordPress4.2版本更新所带来的Emoji钩子同时挂上主题自带的表情路径
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'lmsim_disable_emoji9s_tinymce');
    add_filter('smilies_src', 'custom_gitsmilie_src', 10, 2);
}
add_action('init', 'init_gitsmilie', 5);
//分页导航
function par_pagenavi( $before = '', $after = '', $p = 1 ) {   
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;   
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	echo $before;   
	if ( $paged > 1 ) p_link( $paged - 1, '上一页', '<i class="fa fa-angle-left"></i>', 'class="prev-page"' );
	if ( $paged > $p + 1 ) p_link( 1, '最前一页','', 'class="first-page"' );   
	if ( $paged > $p + 2 ) echo '<span class="disable">...</span>';   
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='current'>{$i}</span>" : p_link( $i );
	}   
	if ( $paged < $max_page - $p - 1 ) echo '<span class="disable">...</span>';
	if ( $paged < $max_page - $p ) p_link( $max_page, '最后一页','', 'class="last-page"' );   
	if ( $paged < $max_page ) p_link( $paged + 1,'下一页', '<i class="fa fa-angle-right"></i>', 'class="next-page"' );
	echo $after;
}   
function p_link( $i, $title = '', $linktype = '', $class = '' ) {
	if ( $title == '' ) $title = "第{$i}页";
	if ( $linktype == '' ) { 
		$linktext = $i;
	} else { 
		$linktext = $linktype; 
	}
	echo "<a {$class} href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a>";   
}
?>