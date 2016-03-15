<?php

/*
* 文章摘要，完美兼容中文
* 特别感谢插件wp-utf8-excerpt作者Betty
* http://myfairland.net/wp-utf8-excerpt/
* 同时也感谢插件thumbnail-for-excerpts
*/

//自定义mb函数
/* if the host doesn't support the mb_ functions, we have to define them. From Yskin's wp-CJK-excerpt, thanks to Yskin. */
if ( !function_exists('mb_strlen') ) {
	function mb_strlen ($text, $encode) {
		if ($encode=='UTF-8') {
			return preg_match_all('%(?:
					  [\x09\x0A\x0D\x20-\x7E]           # ASCII
					| [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
					|  \xE0[\xA0-\xBF][\x80-\xBF]       # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					|  \xED[\x80-\x9F][\x80-\xBF]       # excluding surrogates
					|  \xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
					|  \xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
					)%xs',$text,$out);
		}else{
			return strlen($text);
		}
	}
}

/* from Internet, author unknown */
if (!function_exists('mb_substr')) {
    function mb_substr($str, $start, $len = '', $encoding="UTF-8"){
        $limit = strlen($str);
 
        for ($s = 0; $start > 0;--$start) {// found the real start
            if ($s >= $limit)
                break;
 
            if ($str[$s] <= "\x7F")
                ++$s;
            else {
                ++$s; // skip length
 
                while ($str[$s] >= "\x80" && $str[$s] <= "\xBF")
                    ++$s;
            }
        }
 
        if ($len == '')
            return substr($str, $s);
        else
            for ($e = $s; $len > 0; --$len) {//found the real end
                if ($e >= $limit)
                    break;
 
                if ($str[$e] <= "\x7F")
                    ++$e;
                else {
                    ++$e;//skip length
 
                    while ($str[$e] >= "\x80" && $str[$e] <= "\xBF" && $e < $limit)
                        ++$e;
                }
            }
 
        return substr($str, $s, $e - $s);
    }
}


//description=true表示用于提取摘要做description
//ignore=true表示忽略所有的more标签、已有摘要
function wp_thumbnails_excerpt($content, $description=false, $length=0, $ignore=false, $tail="tail")
{
	if($description==true) {
		$content = strip_tags($content);
		$content = strip_shortcodes($content);
		$content = trim($content);
		$content = preg_replace('/\s\s+/', " ", $content);
		$content = mb_substr ($content,0,220, 'utf-8'); 
		$content = str_replace(array('"','\'','<','>'), "", $content); //替换单双引号和尖括号
		return $content;
	}
	
	if($length==0) {
		$length = 200;
	}
	if($tail=="tail")
		$tail = $options['auto_excerpt_tail'];
	if($tail != "") {
		$tail = " <span class='read-more'><a href='".get_permalink()."'>".$tail."</a></span>";
	}
	if($ignore===false)
		$clear = "<div class=\"clear-float\"></div>
		";
	
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_shortcodes($content); //去掉短代码
	$content = trim($content);

	//兼容 <!--more--> 
  $more_pos = stripos ($content, "<!--more-->");
  if ($more_pos !== false && $ignore === false) {
  		//echo "<br>wp_thumbnails_excerpt more<br>";
  		$content = preg_replace('/\s\s+/', "<p>", $content);
  		$more_pos = stripos ($content, "<!--more-->");
      $content = substr ($content, 0, $more_pos);
  }
	//感谢Betty(http://myfairland.net/)的wp-utf8-excerpt
	//小于指定长度
	else if($length > mb_strlen(strip_tags($content), 'utf-8')) {
		//echo "<br>wp_thumbnails_excerpt short<br>";
		$content = preg_replace('/\s\s+/', "<p>", $content);
	}
	else {
		//echo "<br>wp_thumbnails_excerpt full<br>";
		//精确计数. From Bas van Doren's Advanced Excerpt, thanks to Bas van Doren.
		$num = 0;
		$in_tag = false;
		for ($i=0; $num<$length || $in_tag; $i++) {
			if(mb_substr($content, $i, 1) == '<')
				$in_tag = true;
			elseif(mb_substr($content, $i, 1) == '>')
				$in_tag = false;
			elseif(!$in_tag)
				$num++;
		}    
		$content = preg_replace('/\s\s+/', "<p>", $content);
		$content = mb_substr ($content,0,$i, 'utf-8'); 
  }

	if($ignore === false) {
		$content = "<p>".strip_tags($content, "<a> <strong> <font> <span> <br> <p> <h2> <h3> ").$tail;
	}
	else {
		$content = strip_tags($content).$tail;
	}
	$content = force_balance_tags($content); 
	$content = str_replace('<p></p>', "", $content);
	return $content.$clear;
}
add_filter('get_the_excerpt', 'wp_thumbnails_excerpt');
?>