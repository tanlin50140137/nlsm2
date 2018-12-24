/*set.html-js文件 */
//现金活动列表
function openActivities()
{
	location.href=wx.request.url+"/activities";
}
//修改配置
function opensetConfig(s)
{
	location.href=wx.request.url+"/setConfig/"+s;
}
//查看key
function openGetKey(t,s,h)
{
	var html  = '<div style="word-wrap:break-word;font-size:1.4rem;margin:1.5rem;">';
		html += s;
		html += '</div>';
	layer.open({
		  type: 1,
		  title:t+' | 查看KEY',
		  skin: 'layui-layer-demo', //样式类名
		  anim: 2,
		  shadeClose: true, //开启遮罩关闭
		  area: ['880px', h+'px'],
		  content: html
	});
}