<?php
$options = get_option('hy_options');
if (!is_array($options)) {
	$options['star_background'] = false;
	$options['blog_date'] = '';
	$options['blog_description'] = '';
	$options['blog_keywords'] = '';
	$options['anousments'] = '';
	$options['side_links1'] = '';
	$options['side_links2'] = '';
	$options['side_links3'] = '';
	$options['side_links4'] = '';
	$options['side_links5'] = '';
	$options['side_links6'] = '';
	$options['side_links7'] = '';
	$options['analytics_content'] = '';
	$options['icpbei'] = '';
	update_option('hy_options', $options);
}
if(isset($_POST['hy_save'])) {
	$options['star_background'] = isset($_POST['star_background']) ? true : false;
	$options['blog_date'] = stripslashes($_POST['blog_date']);
	$options['blog_description'] = stripslashes($_POST['blog_description']);
	$options['blog_keywords'] = stripslashes($_POST['blog_keywords']);
	$options['anousments'] = stripslashes($_POST['anousments']);
	$options['side_links1'] = stripslashes($_POST['side_links1']);
	$options['side_links2'] = stripslashes($_POST['side_links2']);
	$options['side_links3'] = stripslashes($_POST['side_links3']);
	$options['side_links4'] = stripslashes($_POST['side_links4']);
	$options['side_links5'] = stripslashes($_POST['side_links5']);
	$options['side_links6'] = stripslashes($_POST['side_links6']);
	$options['side_links7'] = stripslashes($_POST['side_links7']);
	$options['analytics_content'] = stripslashes($_POST['analytics_content']);
	$options['icpbei'] = stripslashes($_POST['icpbei']);
	update_option('hy_options', $options);
}
function hy_admin_menu(){
	add_menu_page('主题设置', '主题设置', 'manage_options', 'options_set_up', 'options_panel' ,'dashicons-desktop');
	add_submenu_page( 'options_set_up', '主题说明', '主题说明', 'manage_options', 'options_desc' , 'txt_page');
}
add_action('admin_menu', 'hy_admin_menu');

function options_panel(){
	global $options; ?>
	<form action="#" method="post" enctype="multipart/form-data" name="hy_form" id="hy_form">
		<div class="wrap">
			<h2 style="border-bottom:1px solid #dfdfdf;padding-bottom:10px;margin-bottom:15px;"><?php _e('当前主题设置', 'hy'); ?></h2>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<?php _e('建站时间'); ?><br>
						</th>
						<td>
							<label>
								<input type="text" size="20" name="blog_date" id="blog_date" class="code" value="<?php echo($options['blog_date']); ?>" >
								<?php _e('你博客建立的时间，格式：1997-1-12。', 'hy'); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e('漂浮星空背景'); ?><br>
						</th>
						<td>
							<label>
								<input type="checkbox" name="star_background" value="checkbox" <?php if($options['star_background']) echo "checked='checked'"; ?> />
								<?php _e('打勾显示，须Chrome Firefox等高级浏览器支持。', 'hy'); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e('博客公告'); ?>
						</th>
						<td>
							<textarea name="anousments" cols="50" rows="2" id="anousments" class="code" style="width:98%;font-size:12px;"><?php echo($options['anousments']); ?></textarea>
							<br />
							<label>
								 <?php _e('网站右侧公告，支持 HTML。', 'hy'); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e('博客关键字'); ?>
						</th>
						<td>
							<label>
								<textarea name="blog_keywords" cols="50" rows="2" id="blog_keywords" class="code" style="width:98%;font-size:12px;"><?php echo($options['blog_keywords']); ?></textarea>
							</label>
							<br />
							<label>
								 <?php _e('用于搜索引擎优化的博客关键字，在首页时显示，其他页面自动生成，字数在100字以内，关键词间用半角英文逗号隔开，填写后请尽量不要去修改。', 'hy'); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e('博客描述'); ?>
						</th>
						<td>
							<label>
								<textarea name="blog_description" cols="50" rows="3" id="blog_description" class="code" style="width:98%;font-size:12px;"><?php echo($options['blog_description']); ?></textarea>
							</label>
							<br />
							<label>
								 <?php _e('用于搜索引擎优化的博客描述，在首页时显示，其他页面自动生成，字数在200字以内，填写后请尽量不要去修改。', 'hy'); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php _e('侧边社交信息', 'hy'); ?></th>
						<td>
							<label>
								QQ 号码：<br /><input type="text" size="20" name="side_links1" id="side_links1" class="code" value="<?php echo($options['side_links1']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								新浪微博地址：<br /><input type="text" size="50" name="side_links2" id="side_links2" class="code" value="<?php echo($options['side_links2']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								腾讯微博：<br /><input type="text" size="50" name="side_links3" id="side_links3" class="code" value="<?php echo($options['side_links3']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								twitter地址：<br /><input type="text" size="50" name="side_links4" id="side_links4" class="code" value="<?php echo($options['side_links4']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								facebook地址：<br /><input type="text" size="50" name="side_links5" id="side_links5" class="code" value="<?php echo($options['side_links5']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								github地址：<br /><input type="text" size="50" name="side_links6" id="side_links6" class="code" value="<?php echo($options['side_links6']); ?>" >
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
							<label>
								RSS 地址（不填则使用 wordpress 默认 rss 地址）：<br /><input type="text" size="50" name="side_links7" id="side_links7" class="code" value="<?php echo($options['side_links7']); ?>" >
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<?php _e('ICP 备案号', 'hy'); ?>
						</th>
						<td>
							<label>
								<input type="text" size="30" name="icpbei" id="icpbei" class="code" value="<?php echo($options['icpbei']); ?>" > <?php _e('没有请留空', 'hy'); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e('统计代码', 'hy'); ?>
						</th>
						<td>
							<label>
								<textarea name="analytics_content" cols="50" rows="5" id="analytics_content" class="code" style="width:98%;font-size:12px;"><?php echo($options['analytics_content']); ?></textarea>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<input class="button-primary" type="submit" name="hy_save" value="保存" style="margin-left:220px;" /> 
			</p>
		</div>
	</form><?php
}
function txt_page(){ ?>
	<div class="wrap">
		<h2 style="border-bottom:1px solid #dfdfdf;padding-bottom:10px;margin-bottom:15px;">当前主题设置 - 主题说明</h2>
		<div style="border-left: 4px solid green;background: #fff;-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);padding: 1px 12px;zoom:1;overflow: hidden;margin-bottom: 20px">
			<p>主题LOGO图片设置说明。</p>
			<p>主题默认使用文字logo，要切换图片logo，请点击侧边【外观】-》【顶部】-》【顶部图像】来设置图片</p>
			<p>图片大小要求240px*80px；超过大小的图片不能完整显示，设置图片时可上传后自行剪切，或者上传时直接上传要求大小格式的图片。</p>
		</div>
		<div style="border-left: 4px solid #dd3d36;background: #fff;-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);padding: 1px 12px;zoom:1;overflow: hidden">
			<img src="http://img.lms.im/alipayqrc.png" style="width: 120px;height: 120px;float: right;padding-left: 15px;" />
			<p>本主题为免费主题，使用本主题请保留作者版权链接信息。</p>
			<p>为保证主题使用安全，请务必从主题作者博客（http://lms.im）指定的地址下载，作者承诺提供下载的主题文件不含任何恶意代码，其他地方下载的主题可能被修改了程序代码甚至包含恶意代码，请谨慎使用！主题使用的过程中，如遇到问题需要帮助，请 <a target="_blank" title="不亦乐乎" href="http://lms.im/theme/wordpress-theme-bluesky.html">点这里--->>></a> ，或者联系作者邮箱：i@lms.im。</p>
			<p>如果你觉得这个主题还凑合可用，并有意捐赠作者，请用手机支付宝钱包扫描右边的二维码进行捐赠，谢谢！</p>
		</div>
	</div><?php
}
?>