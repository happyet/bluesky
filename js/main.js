jQuery(document).ready(function($){
	$('#nav .menu-item-has-children > a').append('<span class="dashicons dashicons-arrow-down"></span>');
	$('#nav .menu-item-has-children').hover(function(){
		$(this).toggleClass('on');
	});
	$('.menu-toggle').click(function(){
		$(this).next().toggle();
	});
	$(".author_show, .uface").hover(function(){
		var d=$(this).find(".author_detail");
		d.show().css("z-index",1337).animate({opacity:1},100)
	},function(){
		var d=$(this).find(".author_detail");
		d.animate({opacity:0},100,
		function(){
			$(this).hide().css("z-index",-1337)
		})
	});
	$('span.zh_share span').click(function(event) {
		
	});
	$('span.zh_share span').each(function(){
		$(this).click(function(){
			$(this).next().toggle();
		})
	});
	$(document).click(function() {
		if($('.bdsharebuttonbox').is(":visible")){
			$('.bdsharebuttonbox').hide();
		}
	});
	$('.bd_share').click(function(){
		_bd_c = $(this).find('.bdsharebuttonbox');
		_bd_c.toggle();
		event.stopPropagation();
	});
	
	//回到顶部的JS
	var back_top_btn = $('#back_top');
	if(back_top_btn.length) {
		$(window).scroll(function () {
			setTimeout(function() {
				var scrollTop = $(this).scrollTop();
				if (scrollTop > 400) {
					back_top_btn.fadeIn();
				} else {
					back_top_btn.fadeOut();
				}
			},64);
		});
		back_top_btn.on('click',function (e) {
			e.preventDefault();
			$('body,html').animate({scrollTop: 0}, 400);
		});
	}
});