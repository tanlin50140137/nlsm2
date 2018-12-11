<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
/**
 * 公共文件
 * */
if( is_file( dirname(__FILE__).'/'.SYSTEM.'/config/config.php' ) ):
require dirname(__FILE__).'/'.SYSTEM.'/config/config.php';
endif;
require dirname(__FILE__).'/'.SYSTEM.'/config/route.php';
require dirname(__FILE__).'/'.SYSTEM.'/databases/this_base_concet.php';
require dirname(__FILE__).'/'.SYSTEM.'/databases/this_single_case.php';
require dirname(__FILE__).'/'.SYSTEM.'/databases/this_factory.php';
require dirname(__FILE__).'/'.SYSTEM.'/'.SPOT.'setting_uri.php';
require dirname(__FILE__).'/'.SYSTEM.'/function.php';
require dirname(__FILE__).'/'.THEME.'/index.php';