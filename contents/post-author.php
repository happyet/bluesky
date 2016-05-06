<?php
    $format = get_post_format();
    if(empty($format)) $format = 'standard';
    $format_icon = 'format-' . $format;
    if($format == 'link' ) $format_icon = 'admin-links';
    if($format == 'standard' ) $format_icon = 'edit';
 ?>
<div class="author_show">
    <div class="author_face">
        <div class="author_wrap">
            <div class="front">
                <span class="dashicons dashicons-<?php  echo $format_icon; ?>"></span>
            </div>
            <div class="back">
                <?php echo get_avatar(get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 60 )); ?>
            </div>
        </div>
    </div>
         <div class="author_detail">
		<div class="detail_main">
			<h2><span class="dashicons dashicons-welcome-learn-more" title="作者"></span> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="去看看TA的作品"><?php printf(get_the_author() ); ?></a></h2>
			<p><?php if(get_the_author_meta( 'description' ) ){ the_author_meta( 'description' ); }else{ echo '该同志还没添加个人介绍';}; ?></p>
		</div>
	</div>
	<?php if(function_exists('the_views')) {
		echo '<span class="views"><span class="dashicons dashicons-heart"></span>';
		the_views();
		echo '</span>';
	}elseif(function_exists('post_views')) {
		echo '<span class="views"><span class="dashicons dashicons-heart"></span>';
		post_views();
		echo '</span>';
	} ?>
</div>
