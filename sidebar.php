<?php 
	$options = get_option('hy_options');
	$opens = array();
	if($options['side_links1']) $opens['qq'] = $options['side_links1'];
	if($options['side_links2']) $opens['weibo'] = $options['side_links2'];
	if($options['side_links3']) $opens['tencent-weibo'] = $options['side_links3'];
	if($options['side_links4']) $opens['twitter'] = $options['side_links4'];
	if($options['side_links5']) $opens['facebook'] = $options['side_links5'];
	if($options['side_links6']) $opens['github'] = $options['side_links6'];
	if($options['side_links7']){ $opens['rss'] = $options['side_links7']; }else{ $opens['rss'] = get_bloginfo('rss2_url');}
	$num = count($opens);
	$class = (!empty($options['anousments'])) ? 'has-anous ' : '';
?>
<div id="sidebar" class="clearfix">
	<div id="sidebar-main">
		<div id="side-top-wrap">
			<ul id="side-top" class="<?php echo $class; ?>list-inline clearfix">
				<?php 
					foreach($opens as $key=>$open){
						$open = ($key != 'qq') ? $open : 'http://wpa.qq.com/msgrd?v=3&uin=' . $open . '&site=' . get_bloginfo('name') . '&menu=yes';
						echo '<li class="col-' . $num . '"><a href="' . $open . '" target="_blank"><i class="fa fa-' . $key . '"></i></a></li>';
					}
				?>
			</ul>
			<?php if(!empty($options['anousments'])){ ?>
				<div id="anousment">
					<h2><span class="dashicons dashicons-megaphone"></span> <strong>网站公告</strong></h2>
					<div class="anousment-content">
						<?php echo($options['anousments']); ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<div id="sidebar-content">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('main-aside') ) : ?><?php endif; ?>
			<?php if(is_home()){ dynamic_sidebar('home-aside'); }?>
			<?php if(is_singular()){ dynamic_sidebar('single-aside'); }?>
			<?php if(is_category()){ dynamic_sidebar('category-aside'); }?>
		</div>
	</div>
</div>