/*setconfig.html-js文件 */

function sendBtn()
{
	if( $("[name=appid]").val() == '' )
	{
		layer.msg('请输入开放平台应用(AppID)');
		$("[name=appid]").focus();
		return false;
	}	
	if( $("[name=alipayrsaprivatekey]").val() == '' )
	{
		layer.msg('alipayrsaPrivateKey(支付宝公钥)');
		$("[name=alipayrsaprivatekey]").focus();
		return false;
	}
	if( $("[name=rsaprivatekey]").val() == '' )
	{
		layer.msg('rsaPrivateKey(开发者密钥)');
		$("[name=rsaprivatekey]").focus();
		return false;
	}
	if( $("[name=coupon_name]").val() == '' )
	{
		layer.msg('红包名称');
		$("[name=coupon_name]").focus();
		return false;
	}
	if( $("[name=total_money]").val() == '' )
	{
		layer.msg('设置红包最大金额');
		$("[name=total_money]").focus();
		return false;
	}
	if( $("[name=total_num]").val() == '' )
	{
		layer.msg('设置红包数量');
		$("[name=total_num]").focus();
		return false;
	}
	if( $("[name=prize_msg]").val() == '' )
	{
		layer.msg('红包活动描述');
		$("[name=prize_msg]").focus();
		return false;
	}
	if( $("[name=end_time]").val() == '' )
	{
		layer.msg('活动结束时间');
		$("[name=end_time]").focus();
		return false;
	}
	
	var dateinfo = $("#frm-setconfig").serialize();
	var index;
	$.ajax({
		url:wx.request.url+'/sendSetConfig',
		type:'post',
		data:dateinfo,
		beforeSend:function(){
			index = layer.load(1, {shade: false});
		},
		complete:function(){
			layer.close(index)
		},
		success:function(d){
			var obj = eval("("+d+")");
			if( obj.error == 0 )
			{
				layer.msg(obj.msg,{time:1000},function(){
					location.href=wx.request.url+"/set";
				});
			}
			else
			{
				layer.msg(obj.msg);
			}	
		}
	});
	
}