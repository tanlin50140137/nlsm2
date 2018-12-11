/*index.html-js文件 */

wx.ActionEvents({
	element:'.ChangeNne',
	events:'click',
	method:function(){
		var url = $(".body-inner1-img").attr('data-src');
			url = url+'?random='+Math.random();		
			$(".body-inner1-img").attr('src',url);
	}
});
wx.ActionEvents({
	element:'.frm',
	events:'submit',
	method:function(){
		var datainfo = $('.frm').serialize();
		
		var input1 = $("[name='username']").val();
		var input2 = $("[name='password1']").val();
		var input3 = $("[name='password2']").val();
		var input4 = $("[name='code']").val();
		
		if( input1 == '' ) {
			$('.frm_txt:eq(0)').html('你还没有输入帐号！');
			return false;
		}	
			
		if( input1.lastIndexOf('@') > -1 ) {
			if( !wx.relemail.test(input1) ) {
				$('.frm_txt:eq(0)').html('邮箱不正确！');
				return false;
			}				
		}else{
			if( !isNaN(input1) )
			{	
				if( !wx.relphone.test(input1) ) {
					$('.frm_txt:eq(0)').html('手机号码不正确！');
					return false;
				}
			}
			else
			{
				$('.frm_txt:eq(0)').html('请输入一个邮箱或手机号码！');
				return false;
			}	
		}	
		$('.frm_txt:eq(0)').html('');
		if(  input2 == '' ) {
			$('.frm_txt:eq(1)').html('你还没有输入密码！');
			return false;
		}
		if( input2.length > 32 ) {
			$('.frm_txt:eq(1)').html('密码最多输入32位字符长度！');
			return false;
		}		
		if(  input3 == '' ) {
			$('.frm_txt:eq(2)').html('你还没有输入密码！');
			return false;
		}	
		if( input3.length > 32 ) {
			$('.frm_txt:eq(2)').html('密码最多输入32位字符长度！');
			return false;
		}		
		if( input2 != input3){
			$('.frm_txt:eq(1)').html('你输入的密码不一至！');
			$('.frm_txt:eq(2)').html('你输入的密码不一至！');
			return false;
		}	
		$('.frm_txt:eq(1)').html('');
		$('.frm_txt:eq(2)').html('');
		
		if( input4 == '' ) {
			$('.frm_txt:eq(3)').html('你还没有输入验证码！');
			return false;
		}
		$('.frm_txt:eq(3)').html('');

		$.post(wx.request.url+'/formdatainfo',datainfo,function(d){		
			var obj = eval("("+d+")");
			if( obj.error == 0 ){
				layer.msg('注册帐号成功',{shift: -1,time:1000},function(){
					location.href = wx.request.url+"/logIn";
				});
			}else{
				layer.msg(obj.txt);
			}	
		});
		
		return false;
	}
});
wx.ActionEvents({
	element:'[name=username]',
	events:'keyup',
	method:function(){
		var input1 = $("[name='username']").val();
		if( input1 != '' ) {
			$('.frm_txt:eq(0)').html('');	
		}	
	}
});
wx.ActionEvents({
	element:'[name=password1]',
	events:'keyup',
	method:function(){
		var input2 = $("[name='password1']").val();
		if( input2 != '' ) {
			$('.frm_txt:eq(1)').html('');	
		}	
	}
});
wx.ActionEvents({
	element:'[name=password2]',
	events:'keyup',
	method:function(){
		var input3 = $("[name='password2']").val();
		if( input3 != '' ) {
			$('.frm_txt:eq(2)').html('');	
		}	
	}
});
wx.ActionEvents({
	element:'[name=code]',
	events:'keyup',
	method:function(){
		var input4 = $("[name='code']").val();
		if( input4 != '' ) {
			$('.frm_txt:eq(3)').html('');
		}	
	}
});