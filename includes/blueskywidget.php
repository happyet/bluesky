<?php
// +----------------------------------------------------------------------+
// | wordpress主题bluesky自定义小工具                                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 http://lms.im                            |
// +----------------------------------------------------------------------+
// | 部分代码收集自网络，由【不亦乐乎】整理修改，自娱自乐，不亦乐乎！     |
// +----------------------------------------------------------------------+
// | Authors: 不亦乐乎 <i@happyet.org>                                    |
// +----------------------------------------------------------------------+
//

class happyet_widget1 extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_avatar_comments',
            'description' => '可显示头像的最新评论'
        );
        parent::__construct('happyet_widget1', 'hy-最新评论', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $limit = strip_tags($instance['limit']);
        $length = strip_tags($instance['length']);
        echo $before_widget;
		echo '<h1>最新评论</h1>';
		echo '<ul class="Hy-nc">';
		global $wpdb,$post_HTML;
		$my_email = get_bloginfo('admin_email');
		$comments = $wpdb->get_results("SELECT ID, post_title, comment_ID, comment_author,comment_author_email,comment_date,comment_content FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID  = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND comment_author_email != '$my_email' ORDER BY comment_date_gmt DESC LIMIT $limit");
		$output = '';
		foreach ($comments as $comment) {
			$output.= '<li class="clearfix">' . get_avatar($comment->comment_author_email, 40) . '<div class="overlay"></div><span>' . $comment->comment_author . '</span>: <a href="' . get_permalink($comment->ID) . '#comment-' . $comment->comment_ID . '" title="《' . $comment->post_title . '》">' . cut_str(strip_tags($comment->comment_content) , $length) . '</a>...</li>';
		}
		$output.= $post_HTML;
		$output = convert_smilies($output);
		echo $output; 
		echo '</ul>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['length'] = strip_tags($new_instance['length']);
		return $instance;
	}
	function form($instance) {
       global $wpdb;
        $instance = wp_parse_args((array)$instance, array(
            'limit' => '5',
            'length' => '40'
        ));
        $limit = strip_tags($instance['limit']);
        $length = strip_tags($instance['length']);
		echo '<p><label for="' . $this->get_field_id('limit') . '">显示数量：(默认5条)<input class="widefat" id="' . $this->get_field_id('limit') . '" name="' . $this->get_field_name('limit') . '" type="text" value="' . $limit . '" /></label></p>';
		echo '<p><label for="' . $this->get_field_id('length') . '">评论内容长度：(默认20字符)<input class="widefat" id="' . $this->get_field_id('length') . '" name="' . $this->get_field_name('length') . '" type="text" value="' . $length . '" /></label></p>';
		echo '<input type="hidden" id="' . $this->get_field_id('submit') . '" name="' . $this->get_field_name('submit') . '" value="1" />';
    }
}
add_action('widgets_init', 'happyet_widget1_init');
function happyet_widget1_init() {
    register_widget('happyet_widget1');
}
class happyet_widget2 extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_admin_tools',
            'description' => '主题自带的边栏用户管理小工具'
        );
        parent::__construct('happyet_widget2', 'hy-管理工具', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
		echo '<h1>管理工具</h1>';
		echo '<ul class="tworow clearfix">';
		if (current_user_can('level_10')) { 
			echo '<li><a href="' . get_bloginfo('url') . '/wp-admin/post-new.php">撰写文章</a></li>';
			echo '<li><a href="' . get_bloginfo('url') . '/wp-admin/edit-comments.php">评论管理</a></li>';
		}
        wp_register();
		echo '<li>';wp_loginout();echo '</li>';
		echo '</ul>';
		echo $after_widget;
    }
    function form($instance) {
        global $wpdb;
		echo '<p>该工具没有选项!</p>';
    }
}
add_action('widgets_init', 'happyet_widget2_init');
function happyet_widget2_init() {
    register_widget('happyet_widget2');
}
class happyet_widget3 extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_statistics',
            'description' => '主题自带的边栏网站统计小工具'
        );
        parent::__construct('happyet_widget3', 'hy-网站统计', $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);
        echo $before_widget; ?>
		<h1>网站统计</h1>
		<ul class="tworow clearfix">
			<li>文章数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish; ?></li>
			<li>评论数：<?php $count_comments = get_comment_count(); echo $count_comments['approved']; ?></li>
			<li>页面数：<?php $count_pages = wp_count_posts('page'); echo $page_posts = $count_pages->publish; ?></li>
			<li>分类数：<?php echo $count_categories = wp_count_terms('category'); ?></li>
			<li>标签数：<?php echo $count_tags = wp_count_terms('post_tag'); ?></li>
			<?php $options = get_option('hy_options'); $blog_date = $options['blog_date']; if($blog_date){ ?>
				<li>建博日：<?php echo $blog_date; ?></li>
				<li>博客龄：<?php echo floor((time() - strtotime($blog_date)) / 86400); ?> 天</li>
			<?php } ?>
			<li>新发布：<?php global $wpdb; $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')"); $last = date('Y-n-j', strtotime($last[0]->MAX_m)); echo $last; ?></li>
		</ul><?php
        echo $after_widget;
    }
    function form($instance) {
        global $wpdb; ?><p>该工具没有选项!</p><?php
    }
}
add_action('widgets_init', 'happyet_widget3_init');
function happyet_widget3_init() {
    register_widget('happyet_widget3');
}
class happyet_widget4 extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_month_activity',
            'description' => '当月根据评论者评论数量的头像排行'
        );
        parent::__construct('happyet_widget4', 'hy-月评排行', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $limit = strip_tags($instance['limit']);
        echo $before_widget; ?><h1>月评排行</h1><ul class="Hy-hot clearfix"><?php
        global $wpdb;
        $my_email = get_bloginfo('admin_email');
        $sql = "SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url,comment_author_email,comment_type FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE MONTH(comment_date)=MONTH(now()) and YEAR(comment_date)=YEAR(now()) AND comment_author_email != '$my_email' AND comment_type = '' AND post_password='' AND comment_approved='1') AS tempcmt GROUP BY comment_author ORDER BY cnt DESC LIMIT $limit";
        $counts = $wpdb->get_results($sql);
		$output = '';
        if (!empty($counts)) {
            foreach ($counts as $count) {
                $output.= '<li>' . '<a href="' . $count->comment_author_url . '" target="_blank" title="' . $count->comment_author . ' 本月评论数：' . $count->cnt . '" rel="nofollow">' . get_avatar($count->comment_author_email, 90) . '</a></li>';
            }
        } else {
            $output.= '本月评论热潮还没开始';
        }
        echo $output; ?></ul><?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array)$instance, array(
            'limit' => '10'
        ));
        $limit = strip_tags($instance['limit']); ?><p><label for="<?php
        echo $this->get_field_id('limit'); ?>">显示数量：(默认10个)<input class="widefat" id="<?php
        echo $this->get_field_id('limit'); ?>" name="<?php
        echo $this->get_field_name('limit'); ?>" type="text" value="<?php
        echo $limit; ?>" /></label></p><input type="hidden" id="<?php
        echo $this->get_field_id('submit'); ?>" name="<?php
        echo $this->get_field_name('submit'); ?>" value="1" /><?php
    }
}
add_action('widgets_init', 'happyet_widget4_init');
function happyet_widget4_init() {
    register_widget('happyet_widget4');
}
class happyet_Links extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_double_Links',
            'description' => '当月根据评论者评论数量的头像排行'
        );
        parent::__construct('happyet_Links', 'hy-友情链接', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $limit = strip_tags($instance['limit']);
		$cats = strip_tags($instance['cats']);
		$orderby = strip_tags($instance['orderby']);
        echo $before_widget;
		echo '<h1>友情链接</h1>';
		echo '<ul class="tworow clearfix">';
		$bookmarks = get_bookmarks('orderby=' . $orderby . '&limit=' . $limit . 'category=' . $cats);
        if (!empty($bookmarks)) {
            foreach ($bookmarks as $bookmark) {
                echo '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >' . $bookmark->link_name . '</a></li>';
            }
        }
		echo '</ul>';
		echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['limit'] = strip_tags($new_instance['limit']);
		$instance['cats'] = strip_tags($new_instance['cats']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array)$instance, array(
            'limit' => '-1',
			'cats' => '',
			'orderby' => 'name'
        ));
        $limit = strip_tags($instance['limit']);
		$cats = strip_tags($instance['cats']);
		$orderby = strip_tags($instance['orderby']);
		?>
		<p>
            <label for="<?php echo $this->get_field_id('cats'); ?>">分类ID：（<a href="<?php echo admin_url(); ?>/edit-tags.php?taxonomy=link_category">查看链接分类ID</a>）<br>留空显示所有分类链接<input class="widefat" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" type="text" value="<?php echo $cats; ?>" /></label>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>">排序：(<a target="_blank" href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks">查看orderby排序参数</a>)<input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" /></label>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php  _e('Number of links to show:'); ?>(-1为全部显示)</label><input id="<?php  echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" />
		</p>
		
		<input type="hidden" id="<?php
        echo $this->get_field_id('submit'); ?>" name="<?php
        echo $this->get_field_name('submit'); ?>" value="1" /><?php
    }
}
add_action('widgets_init', 'happyet_Links_init');
function happyet_Links_init() {
    register_widget('happyet_Links');
}
class happyet_QQ_list extends WP_Widget {
    function __construct() {
        $widget_ops = array(
			'classname' => 'widget_qq_list',
            'description' => 'QQ 邮件订阅挂件'
        );
        parent::__construct('happyet_QQ_list', 'hy-QQ 邮件订阅', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $qq_list_ID = strip_tags($instance['qq_list_ID']);
        echo $before_widget; ?><h1>邮件订阅</h1><form method="post" id="ql_form" target="_blank" action="http://list.qq.com/cgi-bin/qf_compose_send"><input type="hidden" value="qf_booked_feedback" name="t"><input type="hidden" value="<?php
        echo $qq_list_ID; ?>" name="id"><input type="text" value="" class="rsstxt" name="to" id="to" placeholder="请输入邮件地址订阅更新"><input type="submit" class="ql_submit" value="订阅"></form><?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['qq_list_ID'] = strip_tags($new_instance['qq_list_ID']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array)$instance, array(
            'qq_list_ID' => ''
        ));
        $qq_list_ID = esc_attr($instance['qq_list_ID']); ?><p><label for="<?php
        echo $this->get_field_id('qq_list_ID'); ?>">QQ 邮件订阅识别 ID<input class="widefat" id="<?php
        echo $this->get_field_id('qq_list_ID'); ?>" name="<?php
        echo $this->get_field_name('qq_list_ID'); ?>" type="text" value="<?php
        echo $qq_list_ID; ?>" /></label></p><input type="hidden" id="<?php
        echo $this->get_field_id('submit'); ?>" name="<?php
        echo $this->get_field_name('submit'); ?>" value="1" /><?php
    }
}
add_action('widgets_init', 'happyet_QQ_list_init');
function happyet_QQ_list_init() {
    register_widget('happyet_QQ_list');
}

