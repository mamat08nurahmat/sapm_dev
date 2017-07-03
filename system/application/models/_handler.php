<?php

class _handler extends Model
{
	// table name

	function _handler()
	{
		parent::Model();
	}

	// function reg_session($sid,$userid)
	// {
	// $date=date("Y-m-d H:i:s");
	// $ip =$_SERVER['REMOTE_ADDR'];
	// $this->load->library('user_agent');
	// $browser = $this->agent->browser().' '.$this->agent->version();
	// $this->db->query("INSERT INTO ACTIVE_LOG (SESSION_ID,SESSION_ID_OLD, USER_ID, TIME, STATUS, IP_ADDRESS, BROWSER) VALUES ('$sid','$sid','$userid', '$date',1,'$ip','$browser')");
	// }

	function reg_session($sid,$userid)
	{
	$date=date("Y-m-d H:i:s");
	$ip =$_SERVER['REMOTE_ADDR'];
	$this->load->library('user_agent');
	$browser = $this->agent->browser().' '.$this->agent->version();
	$this->db->query("INSERT INTO ACTIVE_LOG (SESSION_ID, USER_ID, TIME, STATUS, IP_ADDRESS, BROWSER) VALUES ('$sid','$userid', '$date',1,'$ip','$browser')");
	}

	function reg_session_upd($sid,$userid)
	{
	$date=date("Y-m-d H:i:s");
	$ip =$_SERVER['REMOTE_ADDR'];
	$this->load->library('user_agent');
	$browser = $this->agent->browser().' '.$this->agent->version();
	$this->db->query("UPDATE ACTIVE_LOG SET SESSION_ID ='$sid',TIME='$date',STATUS = 1,IP_ADDRESS='$ip',BROWSER='$browser' where USER_ID ='$userid'");
	#$this->db->query("INSERT INTO ACTIVE_LOG (SESSION_ID, USER_ID, TIME, STATUS, IP_ADDRESS, BROWSER) VALUES ('$sid','$userid', '$date',1,'$ip','$browser')");
	}

	function update_session($time,$userid)
	{
	$this->db->query("update active_log set time = '$time' where user_id = '$userid'");
	}

	function terminate_session($userid)
	{
	$this->db->query("delete from active_log where user_id = '$userid'");
	}

	function roll_back($userid)
	{
	$this->db->query("delete from active_log where user_id = '$userid'");
	}

}
?>
