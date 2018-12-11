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