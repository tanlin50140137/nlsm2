<?php
/**
 * 自定义函数
 * */
function SelectionMenu()
{
	session_start();

	$_SESSION['SERIDINFO_ID'] = $_POST['id'];
}
function SignOut()
{
	session_start();
	
	$_SESSION['USER_LOGININ'] = null;
	$_COOKIE['USER_LOGININ'] = null;
	setcookie('USER_LOGININ',null,time()-1,'/');
	unset($_COOKIE['USER_LOGININ']);
	unset($_SESSION['USER_LOGININ']);
	
	header('location:'.apth_url());
}
////////////////////////////////////////////////////////////////////////////////////////////
#获取添动状态
function GetGatewayState($stete)
{
	switch ($stete)
	{
		case 'CREATED':
			$stete = '已创建未打款';
		break;
		case 'PAID':
			$stete = '已打款';
		break;
		case 'READY':
			$stete = '活动已开始';
		break;
		case 'PAUSE':
			$stete = '活动已暂停 ';
		break;
		case 'CLOSED':
			$stete = '活动已结束';
		break;
		case 'SETTLE':
			$stete = '活动已清算';
		break;
	}
	
	return $stete;
}
#现金活动列表查询
function GetGatewayList($camp_status='ALL',$page_size=10,$page_index=1)
{	
	include_once dir_url(THEME.'/alipayhb/aop/AopClient.php');
	include_once dir_url(THEME.'/alipayhb/aop/request/AlipayMarketingCampaignCashListQueryRequest.php');
	
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$row = ReadUnserialize($json['msginfo']);
	
	/*
	 *  ALL:所有类型的活动 
		CREATED: 已创建未打款 
		PAID:已打款 
		READY:活动已开始 
		PAUSE:活动已暂停 
		CLOSED:活动已结束 
		SETTLE:活动已清算
	 * */	
	$aop = new AopClient();	
	$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$aop->appId = $row['appid'];
	$aop->rsaPrivateKey = $row['rsaprivatekey'];
	$aop->alipayrsaPublicKey = $row['alipayrsaprivatekey'];
	$aop->apiVersion = '1.0';
	$aop->signType = 'RSA2';
	$aop->postCharset='UTF-8';
	$aop->format='json';
	$request = new AlipayMarketingCampaignCashListQueryRequest();
	$request->setBizContent("{" .
	"\"camp_status\":\"".$camp_status."\"," .
	"\"page_size\":\"".$page_size."\"," .
	"\"page_index\":\"".$page_index."\"" .
	"  }");
	$result = $aop->execute( $request ); 
	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;	
	if( !empty($resultCode)&&$resultCode == 10000 )
	{
		return array('list'=>$result->$responseNode->camp_list,'total_size'=>$result->$responseNode->total_size,'page_size'=>$result->$responseNode->page_size,'page_index'=>$result->$responseNode->page_index);
	} 
	else 
	{
		return null;
	}
}
#现金活动详情查询
function GetGatewayDetails($crowd_no)
{
	include_once dir_url(THEME.'/alipayhb/aop/AopClient.php');
	include_once dir_url(THEME.'/alipayhb/aop/request/AlipayMarketingCampaignCashDetailQueryRequest.php');
	
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$row = ReadUnserialize($json['msginfo']);
	
	$aop = new AopClient ();
	$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$aop->appId = $row['appid'];
	$aop->rsaPrivateKey = $row['rsaprivatekey'];
	$aop->alipayrsaPublicKey = $row['alipayrsaprivatekey'];
	$aop->apiVersion = '1.0';
	$aop->signType = 'RSA2';
	$aop->postCharset='UTF-8';
	$aop->format='json';
	$request = new AlipayMarketingCampaignCashDetailQueryRequest();
	$request->setBizContent("{" .
	"\"crowd_no\":\"".$crowd_no."\"" .
	"}");
	$result = $aop->execute ( $request); 
	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;
	if(!empty($resultCode)&&$resultCode == 10000)
	{
		$info = array(
			'crowd_no'=>$result->$responseNode->crowd_no,
			'coupon_name'=>$result->$responseNode->coupon_name,
			'prize_msg'=>$result->$responseNode->prize_msg,
			'prize_type'=>$result->$responseNode->prize_type,
			'start_time'=>$result->$responseNode->start_time,
			'end_time'=>$result->$responseNode->end_time,
			'total_amount'=>$result->$responseNode->total_amount,
			'send_amount'=>$result->$responseNode->send_amount,
			'total_num'=>$result->$responseNode->total_num,
			'total_count'=>$result->$responseNode->total_count,
			'origin_crowd_no'=>$result->$responseNode->origin_crowd_no,
			'camp_status'=>$result->$responseNode->camp_status
		);
		return $info;
	} 
	else 
	{
		return null;
	}	
}
#修改活动状态
function GetGatewaySendCangees($crowd_no,$camp_status)
{
	include_once dir_url(THEME.'/alipayhb/aop/AopClient.php');
	include_once dir_url(THEME.'/alipayhb/aop/request/AlipayMarketingCampaignCashStatusModifyRequest.php');
	
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$row = ReadUnserialize($json['msginfo']);
	
	$aop = new AopClient();
	$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$aop->appId = $row['appid'];
	$aop->rsaPrivateKey = $row['rsaprivatekey'];
	$aop->alipayrsaPublicKey = $row['alipayrsaprivatekey'];
	$aop->apiVersion = '1.0';
	$aop->signType = 'RSA2';
	$aop->postCharset='UTF-8';
	$aop->format='json';
	$request = new AlipayMarketingCampaignCashStatusModifyRequest();
	$request->setBizContent("{" .
	"\"crowd_no\":\"".$crowd_no."\"," .
	"\"camp_status\":\"".$camp_status."\"" .
	"  }");
		
	$result = $aop->execute( $request);	
	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;
	if(!empty($resultCode)&&$resultCode == 10000)
	{
		return "success";
	} 
	else 
	{
		return "fall";
	}
}
#创建现金红包
function GetGatewayCreateHB()
{
	include_once dir_url(THEME.'/alipayhb/aop/AopClient.php');
	include_once dir_url(THEME.'/alipayhb/aop/request/AlipayMarketingCampaignCashCreateRequest.php');
	
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$row = ReadUnserialize($json['msginfo']);
	
	$aop = new AopClient();
	$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$aop->appId = $row['appid'];
	$aop->rsaPrivateKey = $row['rsaprivatekey'];
	$aop->alipayrsaPublicKey = $row['alipayrsaprivatekey'];
	$aop->apiVersion = '1.0';
	$aop->signType = 'RSA2';
	$aop->postCharset='UTF-8';
	$aop->format='json';
	$request = new AlipayMarketingCampaignCashCreateRequest();
	$request->setBizContent("{" .
	"\"coupon_name\":\"".$row['coupon_name']."\"," .
	"\"prize_type\":\"random\"," .
	"\"total_money\":\"".$row['total_money']."\"," .
	"\"total_num\":\"".$row['total_num']."\"," .
	"\"prize_msg\":\"".$row['prize_msg']."\"," .
	"\"start_time\":\"NowTime\"," .
	"\"end_time\":\"".$row['end_time']."\"," .
	"\"merchant_link\":\"".apth_url('activities')."\"," .
	"\"send_freqency\":\"D3|L10\"" .
	"  }");
	$result = $aop->execute ( $request); 
	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;
	if(!empty($resultCode)&&$resultCode == 10000)
	{
		$pay_url = (string)$result->$responseNode->pay_url;
		return $pay_url;
	} 
	else 
	{
		return "fall";
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#检查用户名
function AuthenticateUsers()
{
	$user = trim($_POST['user']);
	$pwd = trim($_POST['pwd']);
	
	$u = 'nlsm'; #设置用户名
	$p = '123456'; #设置密码
	
	if( $user != $u )
	{
		echo json_encode(array('error'=>1,'msg'=>'登录名不正确'));exit;
	}
	if( $pwd != $p )
	{
		echo json_encode(array('error'=>1,'msg'=>'登录密码错误'));exit;
	}
}