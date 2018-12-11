<?php defined('SPOT')?'':exit('Can not be opened, not the only entrance.');
/**
 * 数据库实例
 * */
function db()
{
	return new This_Linked();
}
/**
 * 生成xml文件
 * */
function xml_str($array)
{
	$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$xml .= '<box>'."\n";
	foreach($array as $key=>$val)
	{
		$xml .= '<'.$key.'>'.$val.'</'.$key.'>'."\n";
	}
	$xml .= '</box>';
	return $xml;
}
/**
 * 生成xml文件并把内容进行url编码
 * */
function xml_str2($array)
{
	$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$xml .= '<box>'."\n";
	foreach($array as $key=>$val)
	{
		$xml .= '<'.$key.'>'.urlencode($val).'</'.$key.'>'."\n";
	}
	$xml .= '</box>';
	return $xml;
}
/**
 * 读取xml内容
 * */
function ReadXml( $xmlfile )
{
	if( is_file( $xmlfile ) )
	{
		$xml = (array)simplexml_load_file( $xmlfile );
		return $xml;
	}
	else 
	{
		return null;
	}
}
/**
 * Check in
 * */
function CheckIn()
{
	session_start();
	
	if( !isset($_SESSION['USER_LOGININ']) && empty($_SESSION['USER_LOGININ']) )
	{
		if( !isset($_COOKIE['USER_LOGININ']) && empty($_COOKIE['USER_LOGININ']) )
		{
			header('location:'.apth_url('logIn'));exit;
		}
		else
		{
			$_SESSION['USER_LOGININ'] = $_COOKIE['USER_LOGININ'];
		}
	}
	
	$userrows = db()->select('*')->from(PRE.'login')->where('tel="'.$_SESSION['USER_LOGININ'].'" or email="'.$_SESSION['USER_LOGININ'].'"')->get()->array_row();
	if( empty($userrows) )
	{
		header('location:'.apth_url('logIn'));exit;
	}
	else
	{
		return $userrows;
	}
}
function CheckInstall()
{
	if( !file_exists(dir_url(SYSTEM.'/config/config.php')) )
	{		
		header('location:'.apth_url('install'));exit;
	}
}
function ReadSession()
{
	session_start();
	
	if( !isset($_SESSION['SERIDINFO_ID']) && empty($_SESSION['SERIDINFO_ID']) )
	{
		$vals = 0;
	}
	else
	{
		$vals = $_SESSION['SERIDINFO_ID'];
	}	
	return $vals;
}
/**
 * 页面网络路由
 * */
function apth_url($str=null)
{
	if( $str != null )
	{
		if( strlen($str) > 1 )
		{
			if( substr($str, 0, 1) == '/' )
			{
				$str = PATH.$str;
			}
			else 
			{
				$str = PATH.'/'.$str;
			}
		}	
		else 
		{
			$str = PATH;
		}	
		return $str;
	}
	else 
	{
		return PATH;
	}	
}
/**
 * 文件路由
 * */
function dir_url($str=null)
{
	if( $str != null )
	{
		if( strlen($str) > 1 )
		{
			if( substr($str, 0, 1) == '/' )
			{
				$str = ROOT.$str;
			}
			else 
			{
				$str = ROOT.'/'.$str;
			}
		}	
		else 
		{
			$str = ROOT;
		}	
		return $str;
	}
	else 
	{
		return ROOT;
	}	
}
/**
 * 入口文件统一函数
 * */
function EntryFile()
{
	CheckInstall();
	
	$ACT = $_REQUEST['act']==null?'index':$_REQUEST['act'];

	require ('./'.THEME.'/component.php');
	require ('./'.THEME.'/controller.php');
	require ('./'.THEME.'/interface.php');
	require ('./'.THEME.'/function.php');
	
	if(	$ACT != null && function_exists( $ACT ) )
	{	
		$ACT();
	}
	else 
	{
		header("content-type:text/html;charset=utf-8");
		
		echo '<center style="font-size:24px;line-height:150px;"><font color="red">错误提示：'.$ACT.' 控制器不存在,请定义一个 '.$ACT.' 控制器</font></center>';
	}
}
/**
 * 后台－视图
 * */
function view( $view , $data=null )
{
	require ('./'.THEME.'/common.php');
			
	if( $view != null )
	{
		$viewarr = explode('/', $view);
		
		if( strrpos($view, '.') !== false )
		{
			$temp = './'.THEME.'/template/'.$view;
		}
		else 
		{
			$temp = './'.THEME.'/template/'.$view.SUFFIX;
		}
		
		$js = str_replace(SUFFIX, '.js', $temp);
		$css = str_replace(SUFFIX, '.css', $temp);
		
		$tempname = array_pop($viewarr);
		
		define('PATHNAME', './'.THEME.'/template/');
		
		Generate($viewarr,$temp,$js,$css,$tempname);		
	}
	
	require( './'.THEME.'/template/'.__FUNCTION__.SUFFIX );
}
/**
 * 组件－视图
 * $name ,组件名称
 * */
function view_componet( $name, $view , $data=null )
{		
	@$route  = configuration();
	$logo 	 = $route['logo'];
	$title 	 = $route['title'];
	$bar 	 = $route['bar'];
	$page    = $route['page'];
	
	if( $view != null )
	{
		$viewarr = explode('/', $view);
		
		if( strrpos($view, '.') !== false )
		{
			$temp = './'.THEME.'/componet/'.$name.'/template/'.$view;
		}
		else 
		{
			$temp = './'.THEME.'/componet/'.$name.'/template/'.$view.SUFFIX;
		}	
		$js = str_replace(SUFFIX, '.js', $temp);
		$css = str_replace(SUFFIX, '.css', $temp);
		
		$tempname = array_pop($viewarr);
		
		define('PATHNAME', './'.THEME.'/componet/'.$name.'/template/');
		
		Generate($viewarr,$temp,$js,$css,$tempname);
	}
	
	require( './'.THEME.'/componet/'.$name.'/template/index'.SUFFIX );
}
/**
 * 配置文件
 * $array = CheckIn() 
 * */
function configuration( $array )
{
	@$data = $array;
	
	require ('./'.THEME.'/route.php');
	
	return $route;
}
/**
 * 生成模板结构
 * */
function Generate($viewarr,$temp,$js,$css,$tempname)
{
	$tempname = AddHouZhui($tempname);
	$jsfile = str_replace(SUFFIX, '.js', $tempname);
	$cssfile = str_replace(SUFFIX, '.css', $tempname);
	
	foreach($viewarr as $v)
	{
		if( $v != null )
		{
			@$lj .= ($lj==null?'':'/').$v;
		}
	}
			
	$pathname = PATHNAME.$lj;
			
	if( !is_dir( $pathname ) )
	{
		mkdir($pathname,0777,true);
	}
			
	if( !is_file( $temp ) )
	{
		file_put_contents($temp, "<!-- 加载CSS文件 -->\n<link href=\"".$pathname.'/'.$cssfile."\" rel=\"stylesheet\" type=\"text/css\">\n\n<!-- 标题 -->\n<h1 class=\"bodys-inner-title\">".TITLE_TXT."</h1>\n<!-- 内容模板 -->\n<div class=\"body-block\">\n\n</div>\n\n<!-- 加载JS文件 -->\n<script src=\"".$pathname.'/'.$jsfile."\"></script>");
	}
			
	if( !is_file( $js ) )
	{
		file_put_contents($js, "/*{$tempname}-js文件 */\n\n");
	}
			
	if( !is_file( $css ) )
	{
		file_put_contents($css, "/* {$tempname}-CSS文件 */\n@CHARSET \"UTF-8\";\n.body-block{\n \tborder:1px solid red;\n \tmargin-top: 0.5rem;\n}\n");
	}
}
/**
 * 添加后缀.html
 * */
function AddHouZhui($m)
{
	if( $m !== '' )
	{
		if( strstr($m, '.html') == false )
		{
			$name = $m.SUFFIX;
		}
		else
		{
			$name = $m;
		}
	}
	return $name;
}
/**
 * 获取客户IP
 * */
function getIP()
{
	static $realip;
	if (isset($_SERVER)){
	      if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
	          $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	 	  } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
	         $realip = $_SERVER["HTTP_CLIENT_IP"];
	 	  } else {
	         $realip = $_SERVER["REMOTE_ADDR"];
	 	  }
	 } else {
	        if (getenv("HTTP_X_FORWARDED_FOR")){
	            $realip = getenv("HTTP_X_FORWARDED_FOR");
	        } else if (getenv("HTTP_CLIENT_IP")) {
	            $realip = getenv("HTTP_CLIENT_IP");
	        } else {
	            $realip = getenv("REMOTE_ADDR");
	        }
	 }
	 return $realip;
}
/**
 * 转换时间
 * */
function formatSeconds($value) { 
	$theTime = intval($value);// 秒 
	$theTime1 = 0;// 分 
	$theTime2 = 0;// 小时 
	// alert(theTime); 
	if($theTime > 60) { 
		$theTime1 = intval($theTime/60); 
		$theTime = intval($theTime%60); 
		// alert(theTime1+"-"+theTime); 
		if($theTime1 > 60) { 
			$theTime2 = intval($theTime1/60); 
			$theTime1 = intval($theTime1%60); 
		} 
	} 
	$result = "".intval($theTime)."秒"; 
	if($theTime1 > 0) { 
		$result = "".intval($theTime1)."分".$result; 
	} 
	if($theTime2 > 0) { 
		$result = "".intval($theTime2)."小时".$result; 
	} 
	return $result; 
} 
/**
 * 将二维数组转成一维数组  
 * */
function GetoNesArr($array,$key)
{
	if(!empty($array))
	{
		foreach($array as $k=>$v)
		{
			$a[] = $v[$key];
		}
		return array_unique($a);
	}
	else 
	{
		return array();
	}
}
/**
 * 二维关联数组排序，可以指定字段排序,排序顺序标志 SORT_DESC 降序；SORT_ASC 升序    
 * */
function array_Two_sort($array,$string,$sort='SORT_ASC')
{
	$sort = array(    
            'direction' => $sort, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序    
            'field'     => $string,       //排序字段    
    );    
    $arrSort = array();    
    foreach($array as $uniqid => $row){    
        foreach($row as $key=>$value){    
            $arrSort[$key][$uniqid] = $value;    
        }    
    }   
    if($sort['direction']){    
        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $array);    
    }       
    return $array;  
}
/**
 * 图片重采样，设置大小
 * */
function get_pixels($dir,$x,$y)
{
	return apth_url("system/img_pixels.php?dir=$dir&x=$x&y=$y");
}
/**
 * 字节单位转换
 * */
function getbyte($byte=0)
{
	$i = 0;
	while ($byte > 1024)
	{
		$byte /= 1024;
		$i++;
	}
	$brr = array('B','KB','MB','GB','TB');
	
	return round($byte,2).$brr[$i];
}
/**
 * 小于10的两位数转换
 * */
function getInts($int)
{
	if($int<10)
	{
		$int = '0'.$int;
	}
	return $int;
}
/**
 * 网络请求
 * */
function vcurl($url, $post = '', $cookie = '', $cookiejar = '', $referer = '') {
	$tmpInfo = '';
	$cookiepath = getcwd () . '. / ' . $cookiejar;
	$curl = curl_init ();
	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt ( $curl, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] );
	if ($referer) {
		curl_setopt ( $curl, CURLOPT_REFERER, $referer );
	} else {
		curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 );
	}
	if ($post) {
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
	}
	if ($cookie) {
		curl_setopt ( $curl, CURLOPT_COOKIE, $cookie );
	}
	if ($cookiejar) {
		curl_setopt ( $curl, CURLOPT_COOKIEJAR, $cookiepath );
		curl_setopt ( $curl, CURLOPT_COOKIEFILE, $cookiepath );
	}
	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 100 );
	curl_setopt ( $curl, CURLOPT_HEADER, 0 );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	$tmpInfo = curl_exec ( $curl );
	if (curl_errno ( $curl )) {
		// echo ' < pre > < b > 错误: < /b><br / > ' . curl_error ( $curl );
	}
	curl_close ( $curl );
	return $tmpInfo;
}