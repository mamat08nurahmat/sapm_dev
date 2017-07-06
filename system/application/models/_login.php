<?php

class _login extends Model 
{
	// table name

	function _login()
	{
		parent::Model();
	}
	
	function cekData($npp=0)
	{
		$this->db->select('a.*, b.SALES_TYPE, c.BRANCH_NAME, c.REGION ',false);
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID', 'LEFT');
		$this->db->join('BRANCH c','a.BRANCH = c.BRANCH_CODE');
//----->>>manual input npp		
//pemimpin cabang
//		$this->db->where('a.ID', '19000');
//		$this->db->where('a.ID', '21308');
//
		
//pemimpin Superviser
//		$this->db->where('a.ID', '27807');


//sales
//		$this->db->where('a.ID', '27424');
//		$this->db->where('a.ID', '15057');

		$this->db->where('a.ID', $npp);
		return $this->db->get()->result();
	}

/*
	function cekData($npp)
	{
		$this->db->select('a.*, b.SALES_TYPE, c.BRANCH_NAME, c.REGION ',false);
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID', 'LEFT');
		$this->db->join('BRANCH c','a.BRANCH = c.BRANCH_CODE');
		$this->db->where('a.ID', $npp);
		return $this->db->get()->result();
	}
*/	
	
	function CekOldSession($npp)
	{
		$this->db->select('a.*',false);
		$this->db->from('ACTIVE_LOG a');
		$this->db->where('a.USER_ID', $npp);
		return $this->db->get()->result();
	}
	
	function cekDataDesc($kond, $value, $tbl_name)
	{
		$this->db->where($kond, $value);
		$this->db->order_by('ID', 'desc');
		return $this->db->get($tbl_name)->result();
	}

	function get_query($sql)
	{		
		return $this->db->query($sql);
	}
	
	// get data by id
	function get_by_id($id, $tbl_name)
	{
		$this->db->where('id', $id);
		return $this->db->get($tbl_name);
	}
	
	function getUser($id, $tblname)
	{
		$data = $this->get_by_id($id, $tblname)->result();
		return $this->make_json($data[0]);
	}
	
	function update_lastlogin($npp, $time)
	{
			$time1=date('Y-m-d H:i:s');
			$ip =$_SERVER['REMOTE_ADDR'];
			$q="
			INSERT INTO LOGIN_LOG
			SELECT
			'$npp' USER_ID,
			sysdate TIME,
			'$ip' IP_ADDRESS
			FROM DUAL
			";
		$this->db->query($q);
		$this->db->query("update USER_TST set LAST_LOGIN = '$time1' where SUBSTR(ID,-5,5) = '$npp'");
	}
	
	function cek_session($npp)
	{
		$this->db->query("SELECT * FROM ACTIVE_LOG where USER_ID = '$npp'");
	}
	
	function cekSession($npp)
	{
		$this->db->select('a.*',false);
		$this->db->from('ACTIVE_LOG a');
		$this->db->where('a.USER_ID', $npp);
		return $this->db->get()->result();
	}
	
}

?>