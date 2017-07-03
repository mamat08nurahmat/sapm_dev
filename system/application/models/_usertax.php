<?php
class _usertax extends Model
{
	function _usertax()
	{
		parent::Model();
	}

	function getAll($id_user)
	{
		$role_id = $_SESSION['ROLE_ID'];

		if ($role_id == 1) { //LEVEL SUPER_ADMIN
			$hasil = $this->db->query("SELECT
										a.ID AS NPP, a.USERNAME, a.EMAIL, a.STATUS,
										b.BRANCH_NAME AS CABANG,
										c.NAMA_ROLE
										FROM TAX_USER a
										INNER JOIN TAX_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
										INNER JOIN TAX_ROLE c ON c.ID = a.ROLE_ID");
		}
		else{ //LEVEL ADMIN
			$hasil = $this->db->query("SELECT
										a.ID AS NPP, a.USERNAME, a.EMAIL, a.STATUS,
										b.BRANCH_NAME AS CABANG,
										c.NAMA_ROLE
										FROM TAX_USER a
										INNER JOIN TAX_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
										INNER JOIN TAX_ROLE c ON c.ID = a.ROLE_ID
										AND a.ROLE_ID  != '1'");
		}
		return $hasil->result();
	}

	function insertUser($id_user, $nama_user, $email, $unit_id, $level, $created_by)
	{
		$created_date = date('d-M-y');
		$this->db->query("INSERT INTO TAX_USER(ID, USERNAME, EMAIL, UNIT_ID, ROLE_ID, CREATED_DATE, CREATED_BY	)VALUES
        ('$id_user', '$nama_user', '$email', '$unit_id', '$level', '$created_date', '$created_by')");
	}

	function selectByUser($id)
	{
		$role_id = $_SESSION['ROLE_ID'];
		if ($role_id == 1) {
			$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ID = '$id'");
		}
		else {
			$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ID = '$id' AND ROLE_ID != '1'");
		}

		return $hasil;
	}

	//function cegah editing user superadmin
	function blockEditing($role_id)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ROLE_ID = '$role_id'");
		return $hasil->result();
	}

	function updateUser($id_user, $nama_user, $email, $id_unit, $level, $status, $modified_by)
	{
		//echo $id_user."=".$nama_user."=".$email."=".$id_unit."=".$level."=".$status."=".$modified_by;
		//die();
		$modified_date = date('d-M-y');
		$cetak = $this->db->query("UPDATE TAX_USER SET USERNAME       = '$nama_user',
                                                        EMAIL          = '$email',
											            UNIT_ID        = '$id_unit',
											            ROLE_ID        = '$level',
											            STATUS         = '$status',
											            MODIFIED_DATE  = '$modified_date',
											            MODIFIED_BY    = '$modified_by'
											            WHERE ID       = '$id_user'");
		//return $this->db->last_query;
	}

	// function updateProspek($id, $id_nasabah, $nama_nasabah, $jenis_nasabah, $status, $potensi, $modified_by)
	// {
		// $modified_date = date('d-M-y');
		// $this->db->query("UPDATE TAX_PROSPEK SET ID_NASABAH    = '$id_nasabah',
                                                 // NAMA_NASABAH  = '$nama_nasabah',
                                                 // JENIS_NASABAH = '$jenis_nasabah',
                                                 // STATUS        = '$status',
                                                 // POTENSI       = '$potensi',
												 // MODIFIED_DATE = '$modified_date',
												 // MODIFIED_BY   = '$modified_by'
                                                 // WHERE ID      = '$id' ");
	// }

	function deleteUser($id)
	{
		$this->db->query("DELETE FROM TAX_USER WHERE ID = '$id'");
	}

	//function untuk mencek apakah user sudah di insert atau blm
	function cekUser($id_user)
	{
		//$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ROLE_ID >=1 and ROLE_ID <= 2");
		$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ID = '$id_user'");
		return $hasil;
	}

	function searchUnit($cari)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_BRANCH WHERE ROWNUM <=10 and (BRANCH_CODE  LIKE '%$cari%' OR LOWER(BRANCH_NAME) LIKE '%$cari%')");
		return $hasil->result();
	}


}
?>
