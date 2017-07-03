<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
if (! function_exists('register_session'))
{
	function reg_session($sid,$userid)
	{
	$sidx="'".$sid."'";
	$useridx="'".$userid."'";
	
	$ins = "INSERT INTO ACTIVE_LOG (sessionid, userid, time, status) VALUES ($sidx,$useridx, NOW(''),1)";

	if (! mysql_query($ins)){
		echo mysql_error();
		exit();
	}
	}
}

if (! function_exists('update_session'))
{	
	function update_session($sid)
	{
	$ins = "update active_log set time = NOW('') where sessionid = '".$sid;
	if (! mysql_query($ins)){ 
		echo mysql_error();
		exit();
	}
	}
}
	
if (! function_exists('terminate_session'))
{	
	function terminate_session($sid)
	{
	$sidx="'".$sid."'";
	$ins = "delete from active_log where sessionid = $sidx";
	//echo $ins;
	//echo mysql_error();
	if (! mysql_query($ins)){
		echo mysql_error();
		exit();
	}
	}
}
	
if (! function_exists('roll_back'))
{
	function roll_back($userid)
	{
	$useridx="'".$userid."'";
	$ins = "delete from active_log where userid = $useridx";
	//echo $ins;
	//echo mysql_error();
	if (! mysql_query($ins)){
		echo mysql_error();
	} 
	}
}


?>