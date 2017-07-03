<?php
class _userlogintax extends Model
{
	function _userlogintax()
	{
		parent::Model();
	}

	public function get_by_username($username)
	{
		#cek user_name ada ga di table di database
		$hasil = $this->db->query(" SELECT
									a.ID, a.USERNAME, a.POSISI,  a.EMAIL,a.STATUS,
									b.BRANCH_NAME AS UNIT_ID,
									c.ID AS ROLE_ID, C.NAMA_ROLE,
									d.REGION_NAME
									FROM TAX_USER a
									LEFT JOIN TAX_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
									LEFT JOIN TAX_ROLE c ON C.ID = a.ROLE_ID
									LEFT JOIN TAX_BRANCH_REGION d ON d.REGION_CODE = b.REGION
									WHERE a.ID = '$username' AND a.STATUS = 1 ");


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
