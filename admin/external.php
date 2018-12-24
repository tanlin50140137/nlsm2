<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
/**
 * 对外接口文件
 * */
// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:POST');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function test()
{
	AuthenticateUsers();
	
	echo 'OK';
}