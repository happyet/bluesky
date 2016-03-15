<script type="text/javascript" language="javascript">
/* <![CDATA[ */
    function grin(tag) {
    	var myField;
    	tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
    		myField = document.getElementById('comment');
    	} else {
    		return false;
    	}
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = tag;
    		myField.focus();
    	}
    	else if (myField.selectionStart || myField.selectionStart == '0') {
    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		var cursorPos = endPos;
    		myField.value = myField.value.substring(0, startPos)
    					  + tag
    					  + myField.value.substring(endPos, myField.value.length);
    		cursorPos += tag.length;
    		myField.focus();
    		myField.selectionStart = cursorPos;
    		myField.selectionEnd = cursorPos;
    	}
    	else {
    		myField.value += tag;
    		myField.focus();
    	}
    }
/* ]]> */
</script>
<div class="smiley">
<a title="嘿" href="javascript:grin(':mrgreen:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_mrgreen.gif" /></a> 
<a title="色" href="javascript:grin(':razz:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_razz.gif" /></a> 
<a title="悲" href="javascript:grin(':sad:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_sad.gif" /></a> 
<a title="笑" href="javascript:grin(':smile:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_smile.gif" /></a> 
<a title="惊" href="javascript:grin(':oops:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_redface.gif" /></a> 
<a title="亲" href="javascript:grin(':grin:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_biggrin.gif" /></a> 
<a title="雷" href="javascript:grin(':eek:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_surprised.gif" /></a> 
<a title="晕" href="javascript:grin(':???:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_confused.gif" /></a> 
<a title="酷" href="javascript:grin(':cool:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_cool.gif" /></a> 
<a title="奸" href="javascript:grin(':lol:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_lol.gif" /></a> 
<a title="怒" href="javascript:grin(':mad:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_mad.gif" /></a> 
<a title="狂" href="javascript:grin(':twisted:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_twisted.gif" /></a> 
<a title="萌" href="javascript:grin(':roll:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_rolleyes.gif" /></a> 
<a title="吃" href="javascript:grin(':wink:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_wink.gif" /></a> 
<a title="贪" href="javascript:grin(':idea:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_idea.gif" /></a> 
<a title="囧" href="javascript:grin(':arrow:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_arrow.gif" /></a> 
<a title="羞" href="javascript:grin(':neutral:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_neutral.gif" /></a> 
<a title="哭" href="javascript:grin(':cry:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_cry.gif" /></a> 
<a title="汗" href="javascript:grin(':?:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_question.gif" /></a> 
<a title="宅" href="javascript:grin(':evil:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_evil.gif" /></a> 
<a title="馋" href="javascript:grin(':shock:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_eek.gif" /></a> 
<a title="槑" href="javascript:grin(':!:')"><img src="<?php bloginfo('template_directory'); ?>/images/smilies/icon_exclaim.gif" /></a>
</div>