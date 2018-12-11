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