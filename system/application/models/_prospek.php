<?php 
class _prospek extends Model 
{
	
	function _prospek()
	{
		parent::Model();
	}
	 
	function getAll($id_user) 
	{
		//session leveling
		$role_id = $_SESSION['ROLE_ID']; 
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR 
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) { 	
			$hasil = $this->db->query("SELECT 
										b.JENIS_NASABAH,
										a.ID, a.ID_NASABAH, a.NAMA_NASABAH, a.REFERRAL_ID,
										c.KETERANGAN AS STATUS,
										a.POTENSI,
										e.BRANCH_NAME, e.BRANCH_CODE,
										d.ID AS ID_PIC, d.USERNAME AS NAMA_PIC, 
										g.REGION_NAME AS WILAYAH
										FROM TAX_PROSPEK a
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH b ON b.ID = a.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_STATUS c ON c.ID = a.STATUS
										INNER JOIN TAX_USER d ON d.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH e ON e.BRANCH_CODE = d.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION g ON g.REGION_CODE = e.REGION
										ORDER BY a.ID DESC");
		} 
		elseif ($role_id == 4){ //WILAYAH atau HCR
		//query buat level bm dan hcr		
		$hasil = $this->db->query("SELECT 
									b.JENIS_NASABAH,
									a.ID, a.ID_NASABAH, a.NAMA_NASABAH, a.REFERRAL_ID,
									c.KETERANGAN AS STATUS,
									a.POTENSI,
									e.BRANCH_NAME, e.BRANCH_CODE,
									f.POSISI,
									d.ID AS ID_PIC, d.USERNAME AS NAMA_PIC
									FROM TAX_PROSPEK a
									INNER JOIN TAX_LOOKUP_JENIS_NASABAH b ON b.ID = a.JENIS_NASABAH
									INNER JOIN TAX_LOOKUP_STATUS c ON c.ID = a.STATUS
									INNER JOIN TAX_USER d ON d.ID =  a.CREATED_BY
									INNER JOIN TAX_BRANCH e ON e.BRANCH_CODE = d.UNIT_ID
									INNER JOIN TAX_BRANCH_REGION g ON g.REGION_CODE = e.REGION
									INNER JOIN TAX_USER f ON d.unit_id = f.unit_id WHERE f.id = '$id_user'  
									ORDER BY a.ID DESC");						
		}
		elseif ($role_id == 5){ //PEMIMPIN_CABANG atau BM
		$hasil = $this->db->query("SELECT 
									b.JENIS_NASABAH,
									a.ID, a.ID_NASABAH, a.NAMA_NASABAH, a.REFERRAL_ID,
									c.KETERANGAN AS STATUS,
									a.POTENSI,
									e.BRANCH_NAME, e.BRANCH_CODE,
									f.POSISI,
									d.ID AS ID_PIC, d.USERNAME AS NAMA_PIC
									FROM TAX_PROSPEK a
									INNER JOIN TAX_LOOKUP_JENIS_NASABAH b ON b.ID = a.JENIS_NASABAH
									INNER JOIN TAX_LOOKUP_STATUS c ON c.ID = a.STATUS
									INNER JOIN TAX_USER d ON d.ID =  a.CREATED_BY
									INNER JOIN TAX_BRANCH e ON e.BRANCH_CODE = d.UNIT_ID
									INNER JOIN TAX_USER f ON d.unit_id = f.unit_id WHERE f.id = '$id_user'  
									ORDER BY a.ID DESC");		
		}elseif ($role_id == 6) { //PIC
	    //query buat level pic		
		$hasil = $this->db->query("SELECT 
									b.JENIS_NASABAH,
									a.ID, a.ID_NASABAH, a.NAMA_NASABAH, a.REFERRAL_ID,
									c.KETERANGAN AS STATUS,
									a.POTENSI,
									D.USERNAME
									FROM TAX_PROSPEK a
									INNER JOIN TAX_LOOKUP_JENIS_NASABAH b ON b.ID = a.JENIS_NASABAH
									INNER JOIN TAX_LOOKUP_STATUS c ON c.ID = a.STATUS
									INNER JOIN TAX_USER d ON d.ID =  a.CREATED_BY 
									WHERE d.ID = '$id_user' ORDER BY a.ID DESC");
		} 	
		//$result1 = $hasil1->result();
		//$result2 = $hasil2->result();
		
		//return array_merge($result1, $result2);
		//return array('hasil1' => $result1, 'hasil2' => $result2);							
		//return array_merge($result1, $result2);	
		//$return array('categories' => $query1, 'count' => $query2);		
		return $hasil->result();
		
	}
	
	function insertProspek($id_nasabah, $nama_nasabah, $jenis_nasabah, $status, $potensi, $create_by, $referral_id)
	{
		//$tgl = date();
		$create_date = date('d-M-y');
		$this->db->query("INSERT INTO TAX_PROSPEK(ID, ID_NASABAH, NAMA_NASABAH, JENIS_NASABAH, STATUS, POTENSI, CREATED_DATE, CREATED_BY, REFERRAL_ID)VALUES
        (TAX_PROSPEK_SEQ.nextval, '$id_nasabah', '$nama_nasabah', '$jenis_nasabah', '$status', '$potensi', '$create_date', '$create_by', '$referral_id')");
	}
	
	//cek status nasabah prospek yang sudah di insert
	function cekNasabahProspek($id_nasabah)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_PROSPEK WHERE ID_NASABAH = '$id_nasabah'");
		return $hasil;
	}
	
	function selectByProspek($id)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_PROSPEK WHERE ID='$id'");
		return $hasil;
	}
	
	function updateProspek($id, $id_nasabah, $nama_nasabah, $jenis_nasabah, $status, $potensi, $modified_by, $referral_id)
	{
		$modified_date = date('d-M-y');
		$this->db->query("UPDATE TAX_PROSPEK SET ID_NASABAH    = '$id_nasabah',
                                                 NAMA_NASABAH  = '$nama_nasabah',
                                                 JENIS_NASABAH = '$jenis_nasabah',
                                                 STATUS        = '$status',
                                                 POTENSI       = '$potensi',
												 MODIFIED_DATE = '$modified_date',
												 MODIFIED_BY   = '$modified_by',
												 REFERRAL_ID   = '$referral_id'
                                                 WHERE ID      = '$id'");
	}
	
	function deleteProspek($id)
	{
		$this->db->query("DELETE FROM TAX_PROSPEK WHERE ID='$id'");
	}
	
	function searchProspek()
	{
		
	}
	
	// function loaddata($dataarray) 
	// {
		// $tgl = date('d-M-Y');
		// $sid = $_SESSION['ROLE_ID'];
		// //$sid = $_SESSION['ID'];
		// //$lvl = $_SESSION['USER_LEVEL']; ROLE_ID
		// /*if($lvl=='SALES')
		// {
			// $xid=$sid;
			
		// }else{
			// $xid="$dataarray[$i]['NPP']";
		// }*/
        // for ($i = 0; $i < count($dataarray); $i++) {
            // $data = array(
			    // 'ID'			=> $dataarray[$i]['ID'],
				// 'ID_NASABAH'	=> $dataarray[$i]['ID_NASABAH'],
				// 'NAMA_NASABAH'	=> $dataarray[$i]['NAMA_NASABAH'],
				// 'JENIS_NASABAH'	=> $dataarray[$i]['JENIS_NASABAH'],
				// 'STATUS'		=> $dataarray[$i]['STATUS'],
				// 'POTENSI'		=> $dataarray[$i]['POTENSI'],
				
				// //'CREATED_DATE'	=> $tgl
                // //'CREATED_BY'	=> $dataarray[$i]['CREATED_BY']
			// );
            // //ini untuk menambahkan apakah dalam tabel sudah ada data yang sama
            // //apabila data sudah ada maka data di-skip
            // // saya contohkan kalau ada data nama yang sama maka data tidak dimasukkan
            // //$this->db->where('CIF_KEY', $this->input->post('CIF_KEY'));            
            // // if ($cek) {
            // $this->db->insert('TAX_PROSPEK', $data);
			// //$this->db->insert($this->table_report, $data);
				
           // // }
        // }
		// $this->db->close();
	// }
	
	function upload_data_prospek($dataarray)
    {
		$create_date = date('d-M-Y');
		
        for($i = 0; $i < count($dataarray); $i++){ 
            $data = array(
                $id_nasabah    = $dataarray[$i]['ID_NASABAH'],
				$nama_nasabah  = $dataarray[$i]['NAMA_NASABAH'],
				$jenis_nasabah = $dataarray[$i]['JENIS_NASABAH'],
				$status        = $dataarray[$i]['STATUS'],
				$potensi       = $dataarray[$i]['POTENSI'],
				$create_by     = $dataarray[$i]['CREATED_BY'],
				$create_date
            );
            //$this->db->insert('TAX_PROSPEK', $data);
			//$this->db->set($data)
			//TAX_PROSPEK_SEQ.nextval
			$this->db->query("INSERT INTO TAX_PROSPEK(ID, ID_NASABAH, NAMA_NASABAH, JENIS_NASABAH, STATUS,POTENSI, CREATED_DATE, CREATED_BY)
			VALUES(TAX_PROSPEK_SEQ.nextval, '$id_nasabah', '$nama_nasabah', '$jenis_nasabah', '$status', '$potensi', '$create_date', '$create_by')");
			
			
        }
    }

}
