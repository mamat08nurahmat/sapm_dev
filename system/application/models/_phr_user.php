<?php
class _phr_user extends Model
{
	function _phr_user()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

    function getAll($id_user)
    {
        $role_id = $_SESSION['ROLE_ID'];
        if ($role_id == 1)
        {
            $hasil = $this->db->query("SELECT
                                        a.ID AS NPP, a.USERNAME, a.EMAIL, a.STATUS,
                                        b.BRANCH_NAME AS CABANG,
                                        c.NAMA_ROLE
                                        FROM PHR_USER a
                                        INNER JOIN PHR_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
                                        INNER JOIN PHR_ROLE c ON c.ID = a.ROLE_ID ");
        }
        else
        {
            $hasil = $this->db->query("SELECT
                                        a.ID AS NPP, a.USERNAME, a.EMAIL, a.STATUS,
                                        b.BRANCH_NAME AS CABANG,
                                        c.NAMA_ROLE
                                        FROM PHR_USER a
                                        INNER JOIN PHR_BRANCH b ON b.BRANCH_CODE = a.UNIT_ID
                                        INNER JOIN PHR_ROLE c ON c.ID = a.ROLE_ID
                                        AND a.ROLE_ID  != '1'");
        }
        return $hasil->result();

    }
	
	function getList($npp = 0)
	{	
		$table_name = "VW_PHR_LIST_USER_2";
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
				
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		//print_r($return['records']); die();
		//Build count query
		$this->db->select('count(NPP) as RECORD_COUNT')->from($table_name);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}

    function insertUser($id_user, $nama_user, $email, $unit_id, $level, $created_by)
	{
		$created_date = date('d-M-y');
		$this->db->query("INSERT INTO PHR_USER(ID, USERNAME, EMAIL, UNIT_ID, ROLE_ID, CREATED_DATE, CREATED_BY	)VALUES
        ('$id_user', '$nama_user', '$email', '$unit_id', '$level', '$created_date', '$created_by')");
	}

    function selectByUser($id)
	{
		$role_id = $_SESSION['ROLE_ID'];
		if ($role_id == 1) {
			$hasil = $this->db->query("SELECT * FROM PHR_USER WHERE ID = '$id'");
		}
		else {
			$hasil = $this->db->query("SELECT * FROM PHR_USER WHERE ID = '$id' AND ROLE_ID != '1'");
		}

		return $hasil;
	}

    function updateUser($id_user, $nama_user, $email, $id_unit, $level, $status, $modified_by)
	{
		//echo $id_user."=".$nama_user."=".$email."=".$id_unit."=".$level."=".$status."=".$modified_by;
		//die();
		$modified_date = date('d-M-y');
		$cetak = $this->db->query("UPDATE PHR_USER SET USERNAME        = '$nama_user',
                                                        EMAIL          = '$email',
											            UNIT_ID        = '$id_unit',
											            ROLE_ID        = '$level',
											            STATUS         = '$status',
											            MODIFIED_DATE  = '$modified_date',
											            MODIFIED_BY    = '$modified_by'
											            WHERE ID       = '$id_user'");
		//return $this->db->last_query;
	}

    function deleteUser($id)
	{
		$this->db->query("DELETE FROM PHR_USER WHERE ID = '$id'");
	}


    //function untuk mencek apakah user sudah di insert atau blm
	function cekUser($id_user)
	{
		//$hasil = $this->db->query("SELECT * FROM TAX_USER WHERE ROLE_ID >=1 and ROLE_ID <= 2");
		$hasil = $this->db->query("SELECT * FROM PHR_USER WHERE ID = '$id_user'");
		return $hasil;
	}

    function getLookupRole($id_user)
	{
		$role_id = $_SESSION['ROLE_ID'];
		if ($role_id == 1) {
			$hasil = $this->db->query("SELECT * FROM phr_role WHERE id !=1");
		}
		elseif ($role_id == 2) {
			$hasil = $this->db->query("SELECT * FROM phr_role WHERE id !=1");
		}
		return $hasil->result();
	}

    function searchUnit($cari)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_BRANCH WHERE ROWNUM <=10 and (BRANCH_CODE  LIKE '%$cari%' OR LOWER(BRANCH_NAME) LIKE '%$cari%')");
		return $hasil->result();
	}

}
?>
