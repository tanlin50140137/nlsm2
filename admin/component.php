<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
/**
 * 系统组件，用户登录，用户注册
 * */
function logIn()
{
	//$rows = db()->select('*')->from(PRE.'apack')->where(array('id'=>1))->get()->array_row();
	view_componet( strtolower(__FUNCTION__), 'index/index' );
}
#提交数据-登录
function formlogininfo()
{
	session_start();
	
	$remember = $_POST['remember'];
	$username = htmlspecialchars($_POST['username'],ENT_QUOTES,'utf-8',false);
	$password = $_POST['password'];
	
	if( $username == '' )
	{
		echo json_encode(array('error'=>1,'txt'=>'你还没有输入帐号！'));exit;
	}
	
	if( strrpos($username, '@') === false )
	{
		if(is_numeric($username))
		{
			if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $username) )
			{
				echo json_encode(array('error'=>1,'txt'=>'手机号码不正确！'));exit;
			}
		}
		else 
		{
			echo json_encode(array('error'=>1,'txt'=>'请输入一个邮箱或手机号码！'));exit;
		}
		$wh = ' tel="'.$username.'" ';
	}
	else
	{
		if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/", $username) )
		{
			echo json_encode(array('error'=>1,'txt'=>'邮箱不正确！'));exit;
		}
		$wh = ' email="'.$username.'" ';
	}
	
	if( $password == '' )
	{
		echo json_encode(array('error'=>1,'txt'=>'你还没有输入密码！'));exit;
	}
	
	if( mb_strlen($password,'utf-8') > 32 )
	{
		echo json_encode(array('error'=>1,'txt'=>'密码最多输入32位字符长度！'));exit;
	}
	
	$password = md5(base64_encode(substr(md5($_POST['password']),0,10)));
	
	$where = $wh.' and pwd="'.$password.'" ';
	
	$int = db()->select('*')->from(PRE.'login')->where($where)->get()->array_nums();
	
	if( $int )
	{
		if( $remember == 'on' )
		{
			setcookie('USER_LOGININ',$username,time()+(60*60*24*7),'/');
			$_SESSION['USER_LOGININ'] = $username;
		}
		else 
		{
			$_SESSION['USER_LOGININ'] = $username;
		}		
		echo json_encode(array('error'=>0,'txt'=>'success'));
	}
	else
	{
		echo json_encode(array('error'=>1,'txt'=>'用户不存在'));
	}
}
function userLogIn()
{
	view_componet( strtolower(__FUNCTION__), 'index/index' );
}
#提交数据-注册
function formdatainfo()
{
	session_start();
	
	$pic = db()->select('picname')->from(PRE.'apack')->order_by('rand()')->get()->array_row();
	
	$code2 = strtolower($_POST['code']);
	$code1 = strtolower($_SESSION['virify']);
	
	$username = htmlspecialchars($_POST['username'],ENT_QUOTES,'utf-8',false);
	
	$data = array
	(
		'users'    => date('His').mt_rand(1000, 9999),
		'pic'	   => $pic['picname'],	    
	    'pwd' => md5(base64_encode(substr(md5($_POST['password1']),0,10))), 
		'publitime' => time()
	);
	
	if( $username == '' )
	{
		echo json_encode(array('error'=>1,'txt'=>'你还没有输入帐号！'));exit;
	}
		
	if( strrpos($username, '@') === false )
	{
		if(is_numeric($username))
		{
			if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $username) )
			{
				echo json_encode(array('error'=>1,'txt'=>'手机号码不正确！'));exit;
			}
		}
		else 
		{
			echo json_encode(array('error'=>1,'txt'=>'请输入一个邮箱或手机号码！'));exit;
		}
		$userint = db()->select('*')->from(PRE.'login')->where(array('tel'=>$username))->get()->array_nums();
		if( $userint > 0 )
		{
			echo json_encode(array('error'=>1,'txt'=>$username.'帐号已经存在！'));exit;
		}
		$data['tel'] = $username;
	}
	else
	{
		if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/", $username) )
		{
			echo json_encode(array('error'=>1,'txt'=>'邮箱不正确！'));exit;
		}
		$userint = db()->select('*')->from(PRE.'login')->where(array('email'=>$username))->get()->array_nums();
		if( $userint > 0 )
		{
			echo json_encode(array('error'=>1,'txt'=>$username.'帐号已经存在！'));exit;
		}
		$data['email'] = $username;
	}
	
	if( $_POST['password1'] == '' )
	{
		echo json_encode(array('error'=>1,'txt'=>'你还没有输入密码！'));exit;
	}
	
	if( mb_strlen($_POST['password1'],'utf-8') > 32 )
	{
		echo json_encode(array('error'=>1,'txt'=>'密码最多输入32位字符长度！'));exit;
	}
	
	if( $_POST['password2'] == '' )
	{
		echo json_encode(array('error'=>1,'txt'=>'你还没有输入密码！'));exit;
	}
	
	if( mb_strlen($_POST['password2'],'utf-8') > 32 )
	{
		echo json_encode(array('error'=>1,'txt'=>'密码最多输入32位字符长度！'));exit;
	}
	
	if( $_POST['password1'] != $_POST['password2'] )
	{
		echo json_encode(array('error'=>1,'txt'=>'你输入的密码不一至！'));exit;
	}
	
	if( $code2 != $code1)
	{
		echo json_encode(array('error'=>1,'txt'=>'你输入的验证码不正确！'));exit;
	}
	
	$int = db()->insert(PRE.'login',$data);
	
	if( $int )
	{
		$_SESSION['virify'] = null;
		unset( $_SESSION['virify'] );
		
		echo json_encode(array('error'=>0,'txt'=>'success'));
	}
	else
	{
		echo json_encode(array('error'=>1,'txt'=>'注册失改'));
	}
}