<?php
$route = array(
	/**
	 * logo
	 * */
	'logo' => array(
		'icon' => apth_url(THEME.'/images/logo.jpg')
	),
	/**
	 * page title
	 * */
	'page' => array(
		'admin' => array(
			'title' => '呗尔商家平台'
		),
		'login' => array(
			'title' => '呗尔商家平台'
		),
		'userlogin' => array(
			'title' => '呗尔商家平台-注册'
		)
	),
	/**
	 * logo title
	 * */
	'title' => array(
		'admin' => array(
			'link' => apth_url(),
			'title' => '呗尔商家平台 '
		),
		'login' => array(
			'link' => apth_url(),
			'title' => '呗尔商家平台'
		),
		'userlogin' => array(
			'link' => apth_url(),
			'title' => '呗尔商家平台 | 注册'
		)
	),
	/**
	 * bar
	 * */
	'bar' => array(
		'admin' => array(
			array(
				'link' 	=> apth_url(),
				'title' => '文档'
			),
			array(
				'link' 	=> apth_url(),
				'title' => '设置'
			),
			array(
				'link' 	=> apth_url(),
				'title' => '<img src="'.($data['pic']==null?apth_url(THEME.'/images/pic.svg'):apth_url('pic/'.$data['pic'])).'" alt="头像"/>'
			),
			array(
				'link' 	=> apth_url(),
				'title' => $data['users']
			)
			,
			array(
				'link' 	=> apth_url('SignOut'),
				'title' => '退出'
			)
		),
		'login' => array(
			array(
				'link' 	=> apth_url('userlogIn'),
				'title' => '立即注册'
			)
		),
		'userlogin' => array(
			array(
				
			)
		)
	),
	/**
	 * menu
	 * */
	'menu' => array(
		array(
			'link' 	=> apth_url(),
			'ind'  	=> '0',	
			'title' => '后台首页',
			'icon'	=> 'home32' /* 32x32 ；第一张名称为：home32_1 ；第二张名称为：home32_2*/
		),
		array(
			'link' 	=> apth_url('merchant'),
			'ind'  	=> '1',	
			'title' => '商家管理',
			'icon'	=> 'merchant32' /* 32x32 ；第一张名称为：merchant32_1 ；第二张名称为：merchant32_2*/
		),
		array(
			'link' 	=> apth_url('east'),
			'ind'  	=> '2',	
			'title' => '服东管理',
			'icon'	=> 'east32' /* 32x32 ；第一张名称为：east32_1 ；第二张名称为：east32_2*/
		),
		array(
			'link' 	=> apth_url('site'),
			'ind'  	=> '3',	
			'title' => '团队管理',
			'icon'	=> 'site32' /* 32x32 ；第一张名称为：site32_1 ；第二张名称为：site32_2*/
		)
	)
);