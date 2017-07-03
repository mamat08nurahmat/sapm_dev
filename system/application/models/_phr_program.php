<?php
class _phr_program extends Model
{
	function _phr_program()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

	//validasi kalo user mengkosongkan form
	function load_form_rules_tambah()
	{
		$form = array(
					   array(
						   'field' => 'nama_program',
						   'label' => 'forms',
						   'rules' => 'required'
					   ),
					   array(
						   'field' => 'tgl_awal',
						   'label' => 'forms',
						   'rules' => 'required'
					   ),
					   array(
						   'field' => 'tgl_akhir',
						   'label' => 'forms',
						   'rules' => 'required'
					   ),
					   array(
						   'field' => 'penjelasan_program',
						   'label' => 'forms',
						   'rules' => 'required'
					   ),
	   );
	   return $form;
	}

	function validasi_tambah()
	{
		$form = $this->load_form_rules_tambah();
	    $this->form_validation->set_rules($form);

		if ($this->form_validation->run())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


    function getAll()
    {
        $tampil_data = $this->db->query("SELECT * FROM PHR_PROGRAM ORDER BY ID_PROGRAM DESC");
        return $tampil_data->result();
    }
	
	//function buat flexigrid
	function getListProgram($id_program = 0)
	{
		$table_name = "PHR_PROGRAM";
		
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
		$this->db->select('count(ID_PROGRAM) as RECORD_COUNT')->from($table_name);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}

    // function save_program($data, $table)
    // {
    //     $this->db->insert($table, $data);
    // }

    function save_program($nama_program, $tgl_awal, $tgl_akhir, $penjelasan_program)
    {
        $this->db->query("INSERT INTO PHR_PROGRAM(ID_PROGRAM, NAMA_PROGRAM, TGL_AWAL, TGL_AKHIR, PENJELASAN_PROGRAM)VALUES
        (PHR_PROGRAM_SEQ.nextval, '$nama_program', '$tgl_awal', '$tgl_akhir', '$penjelasan_program')");
    }

	function getIdProgram($id_program)
	{
		$edit = $this->db->query("SELECT * FROM PHR_PROGRAM WHERE ID_PROGRAM = '$id_program'");
		return $edit;
	}

	function UpdatingProgram($id_program, $nama_program, $tgl_awal, $tgl_akhir, $penjelasan_program)
	{
		$cetak = $this->db->query("UPDATE PHR_PROGRAM SET NAMA_PROGRAM     = '$nama_program',
                                                        TGL_AWAL           = '$tgl_awal',
											            TGL_AKHIR          = '$tgl_akhir',
											            PENJELASAN_PROGRAM = '$penjelasan_program'
											            WHERE ID_PROGRAM   = '$id_program'");
	}

	function hapusData($id_program)
	{
		$this->db->query("DELETE FROM PHR_PROGRAM WHERE ID_PROGRAM = '$id_program'");
	}

	function upload_data_program($dataarray)
    {
		//$id_program  = 1;
        for($i = 0; $i < count($dataarray); $i++){
            $data = array(
                $id_program    = $dataarray[$i]['ID_PROGRAM'],
				$cif           = $dataarray[$i]['CIF']
            );
            //$this->db->insert('TAX_PROSPEK', $data);
			//$this->db->set($data)
			//TAX_PROSPEK_SEQ.nextval
			$this->db->query("INSERT INTO PHR_PROGRAM_CIF(ID_PROGRAM, CIF)
			          VALUES('$id_program', '$cif')");


        }
    }

	function max_data()
	{
		$query = $this->db->query("SELECT MAX(ID_PROGRAM)AS ID_PROGRAM FROM PHR_PROGRAM");
		return $query->result();
	}

	// function upload_data_prospek($dataarray)
    // {
	// 	$create_date = date('d-M-Y');
	//
    //     for($i = 0; $i < count($dataarray); $i++){
    //         $data = array(
    //             $id_nasabah    = $dataarray[$i]['ID_NASABAH'],
	// 			$nama_nasabah  = $dataarray[$i]['NAMA_NASABAH'],
	// 			$jenis_nasabah = $dataarray[$i]['JENIS_NASABAH'],
	// 			$status        = $dataarray[$i]['STATUS'],
	// 			$potensi       = $dataarray[$i]['POTENSI'],
	// 			$create_by     = $dataarray[$i]['CREATED_BY'],
	// 			$create_date
    //         );
    //         //$this->db->insert('TAX_PROSPEK', $data);
	// 		//$this->db->set($data)
	// 		//TAX_PROSPEK_SEQ.nextval
	// 		$this->db->query("INSERT INTO TAX_PROSPEK(ID, ID_NASABAH, NAMA_NASABAH, JENIS_NASABAH, STATUS,POTENSI, CREATED_DATE, CREATED_BY)
	// 		VALUES(TAX_PROSPEK_SEQ.nextval, '$id_nasabah', '$nama_nasabah', '$jenis_nasabah', '$status', '$potensi', '$create_date', '$create_by')");
	//
	//
    //     }
    // }






}
?>
