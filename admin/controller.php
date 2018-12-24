<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
/**
 * 控制器,命名规则：不区分大小写,传入的控制器名称必须与定义名称一至
 * */
function index()
{	
	
	view( 'index/index');
}
function merchant()
{	
	view( 'merchant/merchant' );
}
function east()
{
	view( 'east/east' );
}
function site()
{
	view( 'site/site' );
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#现金活动列表
function activities()
{
	$page = GetIndexValue(1)==null?1:GetIndexValue(1);
	
	//获取现金活动列表
	$data['rows'] = GetGatewayList('ALL',10,$page);
	
	view( 'activities/activities' ,$data);
}
#设置
function set()
{
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$data['row'] = ReadUnserialize($json['msginfo']);
	
	view( 'set/set' , $data);
}
#修改配置
function setConfig()
{
	$data['alipayhb'] = GetIndexValue(1);
	
	$end_time = time()+(60*60*24*30*3);
	
	$data['end_time'] = date('Y-m-d H:i:s',$end_time);
	
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>'alipayhb'))->get()->array_row();
	$data['row'] = ReadUnserialize($json['msginfo']);
	
	view( 'setconfig/setconfig' ,$data);
}
#添加、修改配置信息
function sendSetConfig()
{
	$data['appid'] = trim($_POST['appid']);
	if( $data['appid'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'请输入开放平台应用(AppID)'));exit;
	}
	$data['alipayrsaprivatekey'] = trim($_POST['alipayrsaprivatekey']);
	if( $data['alipayrsaprivatekey'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'alipayrsaPrivateKey(支付宝公钥)'));exit;
	}
	$data['rsaprivatekey'] = trim($_POST['rsaprivatekey']);
	if( $data['rsaprivatekey'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'rsaPrivateKey(开发者密钥)'));exit;
	}
	$data['coupon_name'] = trim($_POST['coupon_name']);
	if( $data['coupon_name'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'红包名称'));exit;
	}
	$data['total_money'] = trim($_POST['total_money']);
	if( $data['total_money'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'设置红包最大金额'));exit;
	}
	$data['total_num'] = trim($_POST['total_num']);
	if( $data['total_num'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'设置红包数量'));exit;
	}
	$data['prize_msg'] = trim($_POST['prize_msg']);
	if( $data['prize_msg'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'红包活动描述'));exit;
	}
	$data['end_time'] = trim($_POST['end_time']);
	if( $data['end_time'] == '' )
	{
		echo json_encode(array('error'=>1,'msg'=>'活动结束时间'));exit;
	}
	
	$data['iterm'] = trim($_POST['iterm']);
	
	$int = db()->select('*')->from(PRE.'setconfig')->where(array('iterm'=>$data['iterm']))->get()->array_nums();
	
	if( $int == 0 )
	{
		$info['iterm'] = $data['iterm'];
		$info['msginfo'] = serialize($data);
		$int = db()->insert(PRE.'setconfig',$info);
	}
	else
	{
		$info['msginfo'] = serialize($data);
		$int = db()->update(PRE.'setconfig', $info, array('iterm'=>$data['iterm']));
	}
	
	if( $int )
	{
		echo json_encode(array('error'=>0,'msg'=>'提交成功'));
	}
	else
	{
		echo json_encode(array('error'=>1,'msg'=>'提交失败'));
	}
}
#获取活动详情
function GetDetails()
{
	$crowd_no = trim($_POST['crowd_no']);
	
	$row = GetGatewayDetails($crowd_no);
		
	if($row!=null)
	{
		echo json_encode(array('error'=>0,'msg'=>$row));
	}
	else
	{
		echo json_encode(array('error'=>1,'msg'=>'获取内容为空，可能的原因是：参数错误、活动停止或活动已经过期'));
	}
}
#修改活动状态
function sendCangees()
{
	$crowd_no = trim($_POST['crowd_no']);
	$camp_status = trim($_POST['camp_status']);
	$page = trim($_POST['page']);
	
	$int = GetGatewaySendCangees($crowd_no,$camp_status);
	
	if( $int == 'success' )
	{
		echo json_encode(array('error'=>0,'msg'=>'更改成功'));
	}
	else 
	{
		echo json_encode(array('error'=>1,'msg'=>'更改失败，活动已经结束，无法修改'));
	}
}
#创建现金红包
function createHB()
{
	$createHB = trim($_POST['createHB']);
	if( $createHB == 'yes' )
	{
		$url = GetGatewayCreateHB();
		if( $url != 'fall')
		{
			echo json_encode(array('error'=>0,'msg'=>'创建成功','url'=>$url));
		}
		else
		{
			echo json_encode(array('error'=>1,'msg'=>'创建失败'));
		}
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
