<?php
function lms_file_get_contents($url, $post='', $method='GET'){
	$content = is_array($post) ? http_build_query($post) : $post;
	$content_length = strlen($content);
	$options = array(
            'http' => array(
                'method' => $method,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-length: $content_length\r\n",
                'content' => $content
            )
        );
	return file_get_contents($url, false, stream_context_create($options));
}
function get_url($url, $postfields='', $method='GET', $headers=array()){
	if(!function_exists('curl_init')){
		return lms_file_get_contents($url, $postfields, $method);
	}
	$ci = curl_init();
	curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	if($method=='POST'){
		curl_setopt($ci, CURLOPT_POST, TRUE);
		if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
	}
	$headers[]="User-Agent: LMS.IM Theme for WordPress";
	curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ci, CURLOPT_URL, $url);
	$response=curl_exec($ci);
	curl_close($ci);
	return $response;
}
function get_http_response_code($theURL) {
	@$headers = get_headers($theURL);
	return substr($headers[0], 9, 3);
}
function clear_version_check(){
	global $pagenow;   
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
		wp_clear_scheduled_hook( 'check_version_daily_event' );
	}
}
add_action( 'load-themes.php', 'clear_version_check' ); 

/* 每天00:00检查主题版本 */
function check_version_setup_schedule() {
	if ( ! wp_next_scheduled( 'check_version_daily_event' ) ) {
		wp_schedule_event( '1193875200', 'daily', 'check_version_daily_event');
	}
}
add_action( 'wp', 'check_version_setup_schedule' );
function check_version_do_this_daily() {
	$bluesky_version = wp_get_theme()->get( 'Version' );
	update_option('bluesky_version', $bluesky_version );
	if(get_http_response_code('http://update.lms.im/bluesky/version.json')=='200'){
		$version = json_decode(get_url('http://update.lms.im/bluesky/version.json'),true);
		if( $bluesky_version != $version && !empty( $version['version'] ) ){
			update_option('bluesky_upgrade', $version['version']);
			return true;
		}
	}
}
add_action( 'check_version_daily_event', 'check_version_do_this_daily' );
function update_alert_callback(){
	$version = get_option('bluesky_version');
	$upgrade = get_option('bluesky_upgrade');
	$ver = (int)(str_replace('.','',$version));
	$upg = (int)(str_replace('.','',$upgrade));
	if($ver > $upg){
		echo '<div class="update-nag">你当前主题版本号存在问题，请检查 style.css 文件！</div>';
	}elseif($ver < $upg){
		echo '<div class="update-nag">蓝色星空主题 BlueSky <font color="red">V'.$upgrade.'</font> 现已发布！(当前 V'.$version.')，<a href="http://lms.im/wordpress/wordpress-theme-bluesky.html" target="_blank">查看详细信息</a>。</div>';
	}
}
add_action( 'admin_notices', 'update_alert_callback' );
?>