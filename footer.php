
</div>
	<footer id="footer">
		<nav class="footer main-navigation">
			<?php 
				if(has_nav_menu('footer-menu')){
					wp_nav_menu( array( 'theme_location' => 'footer-menu','depth'=> 1,'container'=>false,'items_wrap' => '<ul id="foot-nav" class="%2$s">%3$s</ul>' ) );
				}else{
					echo '<a href="' . admin_url('nav-menus.php') . '"><span class="dashicons dashicons-admin-tools"></span> 请设置菜单</a>';
				}
			?>
		</nav>
		<?php echo copyright(); ?>
	</footer>
	<ul class="tools">
		<?php if (!(current_user_can('level_0'))) { ?>
			<li><a title="登陆" href="<?php echo admin_url(); ?>" target="_blank"><span class="dashicons dashicons-lock"></span></a></li>
		<?php }else{ ?>
			<li><a title="后台设置" href="<?php echo admin_url(); ?>" target="_blank"><span class="dashicons dashicons-performance"></span></a></li>
		<?php } ?>
		<li class="bd_share" title="点击分享">
			<span class="dashicons dashicons-share-alt2"></span>
			<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_twi" data-cmd="twi" title="分享到Twitter"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a></div>
		</li>
		<?php if(is_singular() && comments_open()){ ?>
			<li><a href="#comments"><span class="dashicons dashicons-format-status"></span></a></li>
		<?php } ?>
		<li id="back_top"><span class="dashicons dashicons-arrow-up-alt2"></span></li>
		<?php if ((current_user_can('level_0'))) { ?>
			<li><a title="注销登陆" href="<?php echo wp_logout_url(get_bloginfo('url')); ?>"><span class="dashicons dashicons-migrate"></span></a></li>
		<?php } ?>
	</ul>
</div>
<?php $options = get_option('hy_options'); if (!$options['star_background']) { ?>
<div id="stars-1"></div><div id="stars-2"></div><div id="stars-3"></div><div id="stars-4"></div><div id="stars-5"></div>
<?php } ?>
<div id="star-mask-left"></div>
<div id="star-mask-right"></div>
</div>
<?php wp_footer(); ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"1","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>