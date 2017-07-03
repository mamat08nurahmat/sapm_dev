<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _news extends Model 
{
	/**
	* Instanciar o CI
	*/
	public function _news()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function get_news() 
	{
		$this->db->select('*');
		$this->db->from('NEWS');
		$this->db->where('IS_ACTIVE',1);
		$this->db->order_by('TANGGAL','desc');
		return $this->db->get()->result();
	}
	
	public function get_news_id($id) 
	{
		$this->db->select('*',FALSE);
		$this->db->from('NEWS');
		//$this->db->where('IS_ACTIVE',1);
		$this->db->where('ID',$id);
		$this->db->order_by('TANGGAL','asc');
		return $this->db->get()->result();
	}
	
	public function get_news_flexi($id = 0) 
	{
				//Select table name
		$table_name = "NEWS";
		
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
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	function save($data, $tbl_name)
	{		
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			$field 	.= $row.",";
			$value	.= $val."','"; 
		}	
		$row = rtrim($field,",");
		#$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_CUST_INDV.NEXTVAL, ".rtrim($value,",'")."')";
		$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_BERITA.NEXTVAL, ".rtrim($value,",'")."')";
		#print_r($sql); die();
		$this->db->simple_query($sql);
	}
	
		
	
	function update($id, $data, $tbl_name)
	{		
		#echo "<pre>";
		#print_r($data);die();
		$this->db->where('ID',$id);
		$this->db->update($tbl_name, $data);
	}

}