<?php
class _userloginphr extends Model
{
	function _userloginphr()
	{
		parent::Model();
	}

	public function get_by_username($username)
	{
		#cek user_name ada ga di table di database
		$hasil = $this->db->query("SELECT
                                    a.ID, a.USERNAME, a.EMAIL,a.STATUS,
                                    b.BRANCH_NAME AS UNIT_ID,
                                    c.ID AS ROLE_ID, C.NAMA_ROLE,
                                    d.REGION_NAME
                                    FROM PHR_USER a
                                    LEFT JOIN PHR_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
                                    LEFT JOIN PHR_ROLE c ON C.ID = a.ROLE_ID
                                    LEFT JOIN PHR_BRANCH_REGION d ON d.REGION_CODE = b.REGION
                                    WHERE a.ID = '$username' ");


		// $hasil = $this->db->query(" SELECT
									// a.ID, a.USERNAME, a.POSISI,  a.EMAIL,
									// b.BRANCH_NAME AS UNIT_ID,
									// c.ID AS ROLE_ID, C.NAMA_ROLE,
									// d.REGION_NAME
									// FROM TAX_USER a
									// LEFT JOIN TAX_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
									// LEFT JOIN TAX_ROLE c ON C.ID = a.ROLE_ID
									// LEFT JOIN TAX_BRANCH_REGION d ON d.REGION_CODE = b.REGION
									// WHERE a.ID = '$username' ");

		return $hasil->result();

	}

    //insert loginlog
    function insertLoginLog($username)
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $this->db->query("INSERT INTO PHR_NASABAH_LOGIN_LOG(USERNAME, TIME, IP_ADDRESS)VALUES('$username', CURRENT_TIMESTAMP, '$ip_address')");
    }

    function reg_session($sid,$userid)
    {
        $date = date("Y-m-d H:i:s");
        $ip   = $_SERVER['REMOTE_ADDR'];
        $this->load->library('user_agent');
        $browser = $this->agent->browser().' '.$this->agent->version();
        $this->db->query("INSERT INTO PHR_ACTIVE_LOG (SESSION_ID, USER_ID, TIME, STATUS, IP_ADDRESS, BROWSER) VALUES ('$sid', '$userid', '$date',1,'$ip','$browser')");
    }

    function reg_session_upd($sid,$userid)
    {
        $date = date("Y-m-d H:i:s");
        $ip   = $_SERVER['REMOTE_ADDR'];
        $this->load->library('user_agent');
        $browser = $this->agent->browser().' '.$this->agent->version();
        $this->db->query("UPDATE ACTIVE_LOG SET SESSION_ID ='$sid',TIME='$date',STATUS = 1,IP_ADDRESS='$ip',BROWSER='$browser' where USER_ID ='$userid'");
    }

    public function cekOldSession($npp)
    {
    	$this->db->select('a.*', false);
    	$this->db->from('ACTIVE_LOG a');
    	$this->db->where('a.USER_ID', $npp);
    	return $this->db->get()->result();
    }

    function cekSession($npp)
    {
        $query = $this->db->query("SELECT a.* FROM PHR_ACTIVE_LOG a WHERE a.USER_ID = '$npp'");
        return $query->result();
    }

    function roll_back($userid)
    {
        $this->db->query("DELETE FROM PHR_ACTIVE_LOG where USER_ID = '$userid'");
    }

    function terminate_session($userid)
    {
        $this->db->query("DELETE FROM PHR_ACTIVE_LOG where USER_ID = '$userid'");
    }


    // public function check_on_ldap($username,$password)
	// {
		// $this->load->library('nusoap_loader');
		// $client = $this->nusoap_loader->load_cliento();
		// $params = array(
			// 'username' => $username,
			// 'password' => $password
		// );
		// $result = $client->call('doAuth', $params);
		// $err = $client->getError();

		// if ($client->fault || $err) {
			// #failed message

		// } else {
			// $lanjut=false;
			// //get data user
			// $db_user	= $this->get_by_username($username);
			// if(empty($db_user)){
			       // #error message user tidak terdaftar
				   // echo "Anda belum terdaftar di database ";
				// } elseif($result==2) {
					// #error message koneksi dengan HCMS bermasalah
				// } else {
					// $lanjut=true;
					// #session_create, goto home_tax_amnesty

			// }
		// } //end if client

	//}


}
