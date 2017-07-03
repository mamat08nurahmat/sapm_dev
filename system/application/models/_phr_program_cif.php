<?php
class _phr_program_cif extends Model
{
	function _phr_program_cif()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

    function getAll()
    {
        $query = $this->db->query("SELECT * FROM PHR_PROGRAM_CIF ORDER BY ID_PROGRAM DESC");
        return $query->result();
    }
	
	function getProgramCifList($id_program = 0)
	{
		$table_name = "PHR_PROGRAM_CIF";
		
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

}
?>
