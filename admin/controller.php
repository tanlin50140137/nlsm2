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
	
	view( 'activities/activities' );
}
#设置
function set()
{
	#获取配置信息
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>$data['iterm']))->get()->array_row();
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
	$json = db()->select('msginfo')->from(PRE.'setconfig')->where(array('iterm'=>$data['iterm']))->get()->array_row();
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