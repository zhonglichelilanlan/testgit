$(document).ready(function() {
	
//banner切换
var index_i=1,func=setInterval(Scroll, 3000);
function Scroll(){
	$(".banner_background li").eq(index_i).fadeIn(1000).siblings("li").fadeOut(1000);
	$(".switch_box li").eq(index_i).addClass("cur").siblings("li").removeClass("cur");
	index_i=index_i+1>$(".banner_background li").length-1 ? 0:index_i+1
	}
$(".switch_box a").click(function(){
	clearInterval(func);
	index_i=$(this).parent().index();
	Scroll();
	});
$(".switch_box li").mouseleave(function(){
	func=setInterval(Scroll, 3000)
	});
$(".switch_box li").mouseover(function(){
	clearInterval(func);
	});

		
});
