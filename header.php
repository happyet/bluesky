<!DOCTYPE html>
<html dir="ltr" lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content ="initial-scale=1.0,user-scalable=no">
	<title><?php global $page, $paged; wp_title( '|', true, 'right' ); bloginfo( 'name' ); $site_description = get_bloginfo( 'description', 'display' ); if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description"; if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ); ?></title>
	<?php lmsim_keywords(); ?>
	<?php lmsim_description(); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="dat-noise clearfix">
<div id="page-wrap" class="container clearfix">
<header class="clearfix">
	<?php $header_image = get_header_image(); ?>
	<h1 id="logo">
		<a <?php if ( ! empty( $header_image ) ) : ?>class="imglogo"<?php endif; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>	
	</h1>
	<?php if(wp_is_mobile()){ ?>
		<button class="menu-toggle">菜单</button>
		<nav class="mobile-menu">
			<?php
				if(has_nav_menu('mobile-menu')){
					wp_nav_menu( array( 'theme_location' => 'mobile-menu','depth'=> 1,'container'=>false,'items_wrap' => '<ul id="mobile-nav" class="%2$s">%3$s</ul>' ) );
				}else{
					echo '<a href="' . admin_url('nav-menus.php') . '">手机导航须单独设置，请设置菜单！</a>';
				}
			?>
		</nav>
	<?php }else{ ?>
		<nav class="header main-navigation" id="menu-bar">
			<?php
				if(has_nav_menu('header-menu')){
					wp_nav_menu( array( 'theme_location' => 'header-menu','container'=>false,'items_wrap' => '<ul id="nav" class="%2$s">%3$s</ul>' ) );
				}else{
					echo '<a href="' . admin_url('nav-menus.php') . '"><span class="dashicons dashicons-admin-tools"></span> 请设置菜单</a>';
				}
			?>
		</nav>
	<?php } ?>
</header>
<div class="main clearfix">