/*setconfig.html-js文件 */
//输入页码
function getGo()
{
	var val = $('#getGo').val();
	if(val!='')
	{
		location.href = wx.request.url+'/activities/'+val;
	}
}
//创建现金红包
function createHB()
{
	layer.confirm('是否创建现金红包？', {
		  title:'创建现金红包',
		  btn: ['是','否'] //按钮
		}, function(){
			var index;
			$.ajax({
				url:wx.request.url+'/createHB',
				type:'post',
				data:'createHB=yes',
				beforeSend:function(){
					index = layer.load(1, {shade: false});
				},
				complete:function(){
					layer.close(index)
				},
				success:function(d){
					//alert(d);return false;
					var obj = eval("("+d+")");		
					if( obj.error == 0 )
					{
						layer.msg(obj.msg,{time:1000},function(){
							location.href=wx.request.url+"/activities";
						});
					}
					else
					{
						layer.msg(obj.msg);				
					}	
				}
			});
		}, function(){});
}
//更改现金活动状态
var boxdes='';
function openChanges(crowd_no,page)
{
	var html  = '<div style="margin:1.5rem 2rem;">';
	html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">选择状态：';
	html += '<select name="camp_status">';
	html += '<option value="0">--请选择--</option>';
	html += '<option value="READY">活动已开始</option>';
	html += '<option value="PAUSE">活动已暂停</option>';
	html += '<option value="CLOSED">活动已结束</option>';
	html += '</select>';
	html += '</p>';
	html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">';
	html += '<input type="button" onclick="sendCangees(\''+crowd_no+'\',\''+page+'\')" value="提交" style="border:1px solid #ded6d6;padding:0.4rem 5.5rem;border-radius:0.2rem;cursor:pointer;">';
	html += '</p>';
	html += '</div>';
	boxdes=layer.open({
		  type: 1,
		  title:'更改当前活动状态',
		  skin: 'layui-layer-demo', //样式类名
		  anim: 2,
		  area: ['230px', '170px'],
		  shadeClose: true, //开启遮罩关闭
		  content: html
	});
}
function sendCangees(crowd_no,page)
{
	var status = $("[name=camp_status]").val()
	if( status == 0 )
	{
		layer.msg('请选择');
		return false;
	}	
	var index;
	$.ajax({
		url:wx.request.url+'/sendCangees',
		type:'post',
		data:'crowd_no='+crowd_no+'&camp_status='+status+'&page='+page,
		beforeSend:function(){
			index = layer.load(1, {shade: false});
		},
		complete:function(){
			layer.close(index)
		},
		success:function(d){
			//alert(d);return false;
			var obj = eval("("+d+")");		
			if( obj.error == 0 )
			{
				layer.msg(obj.msg,{time:1000},function(){
					location.href=wx.request.url+"/activities/"+page;
				});
			}
			else
			{
				layer.msg(obj.msg,{time:2000},function(){
					layer.close(boxdes);
				});				
			}	
		}
	});
}
//活动详情
function openDetails(crowd_no)
{
	$.post(wx.request.url+'/GetDetails',{'crowd_no':crowd_no},function(d){
		//alert(d);return false;
		var obj = eval("("+d+")");
		if( obj.error == 0 )
		{	
			var html  = '<div style="margin:2rem;">';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">活动名称：'+obj.msg.coupon_name+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">活动描述：'+obj.msg.prize_msg+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">开始时间：'+obj.msg.start_time+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">结束时间：'+obj.msg.end_time+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">红包金额：'+obj.msg.total_amount+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">已发金额：'+obj.msg.send_amount+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">红包个数：'+obj.msg.total_count+'</p>';
				html += '<p style="height:3rem;line-height:3rem;font-size:1.2rem;">当前状态：'+GetGatewayState(obj.msg.camp_status)+'</p>';
				html += '</div>';
			layer.open({
				  type: 1,
				  title:'现金活动详情查询',
				  skin: 'layui-layer-demo', //样式类名
				  anim: 2,
				  area: ['750px', '400px'],
				  shadeClose: true, //开启遮罩关闭
				  content: html
			});
		}
		else
		{
			layer.msg(obj.msg);
		}	
	});
}
//活动状态
function GetGatewayState(stete)
{
	switch (stete)
	{
		case 'CREATED':
			var stete = '已创建未打款';
		break;
		case 'PAID':
			var stete = '已打款';
		break;
		case 'READY':
			var stete = '活动已开始';
		break;
		case 'PAUSE':
			var stete = '活动已暂停 ';
		break;
		case 'CLOSED':
			var stete = '活动已结束';
		break;
		case 'SETTLE':
			var stete = '活动已清算';
		break;
	}
	
	return stete;
}