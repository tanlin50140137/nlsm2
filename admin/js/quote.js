/**
 * 引用js
 */
wx.ActionEvents({
	element:'.bodys-inner-ul li a',
	events:'click',
	method:function(){
		wx.obj.removeClass('li-a-action');
		$(this).addClass('li-a-action');
		
		var id = $(this).find('font').attr('ind');
		var path = $(this).find('img').attr('src');
			path = path.replace(/1\.svg/i,'2.svg');
			$(this).find('img').attr('src',path);
			
		$.post(wx.request.url+'/SelectionMenu',{'id':id},function(d){});

	}
});

$(".tableBox tr").filter(":even").css("background","#f8f9fb").end().filter(":odd").css("background","#FFFFFF");
$(".tableBox tr").hover(function(){
	$(this).css({"background":"#FFFFDD"});
},function(){
	$(".tableBox tr").filter(":even").css("background","#f8f9fb").end().filter(":odd").css("background","#FFFFFF");
});