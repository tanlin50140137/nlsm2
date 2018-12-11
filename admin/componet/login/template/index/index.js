/*index.html-js文件 */

wx.ActionEvents({
	element:'.login-block-button',
	events:'click',
	method:function(){
		var datainfo = $('.login-block-form').serialize();
		var input1 = $('.login-block-line2').find('input').val();
		var input2 = $('.login-block-line3').find('input').val();
		if( input1 == '' ) {
			$('.login-block-span').html('你还没有输入帐号！');
			return false;
		}	
			
		if( input1.lastIndexOf('@') > -1 ) {
			if( !wx.relemail.test(input1) ) {
				$('.login-block-span').html('邮箱不正确！');
				return false;
			}				
		}else{
			if( !isNaN(input1) )
			{	
				if( !wx.relphone.test(input1) ) {
					$('.login-block-span').html('手机号码不正确！');
					return false;
				}
			}
			else
			{
				$('.login-block-span').html('请输入一个邮箱或手机号码！');
				return false;
			}	
		}	
		
		if(  input2 == '' ) {
			$('.login-block-span').html('你还没有输入密码！');
			return false;
		}
		
		if( input2.length > 32 ) {
			$('.login-block-span').html('密码最多输入32位字符长度！');
			return false;
		}
		
		$.post(wx.request.url+'/formlogininfo',datainfo,function(d){
				var obj = eval("("+d+")");
				if( obj.error == 0 ){
					layer.msg('登录成功请稍等...',{shift: -1,time:1000},function(){
						location.href = wx.request.url;
					});
				}else{						
					layer.msg(obj.txt);
				}
		});
	}
});
wx.ActionEvents({
	element:'.login-block-line2 input',
	events:'keyup',
	method:function(){
		var input1 = $('.login-block-line2').find('input').val();
		if( input1 != '' ) {
			$('.login-block-span').html('');	
		}	
	}
});
wx.ActionEvents({
	element:'.login-block-line3 input',
	events:'keyup',
	method:function(){
		var input1 = $('.login-block-line3').find('input').val();
		if( input1 != '' ) {
			$('.login-block-span').html('');	
		}	
	}
});