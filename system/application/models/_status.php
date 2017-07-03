<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _status extends Model 
{
	/**
	* Instanciar o CI
	*/
	public function _status()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function get_status_user($id) 
	{
		$this->db->select('*',FALSE);
		$this->db->from('STATUS_NONSALES');
		$this->db->where('ID',$id);
		$this->db->order_by('ID','asc');
		return $this->db->get()->result();
	}
	
	function get_status($start, $end)
	{
		
		$tgl1 	= date('m/d/Y', strtotime($start));
		$tgl2 	= date('m/d/Y', strtotime($end));
		
		$start 	= getdate(strtotime($start));
		$d1		= $start['mday'];
		$m1		= $start['mon'];
		$y1		= $start['year'];
		$end 	= getdate(strtotime($end));
		$d2		= $end['mday'];
		$m2		= $end['mon'];
		$y2		= $end['year'];		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT TANGGAL, 
				NPP,
				NAMA,
				JENIS,
				CABANG,
				WILAYAH,
				TGL_AWAL,
				TGL_AKHIR,
				KET_SURAT		 
				FROM 
						STATUS_NONSALES
				WHERE  
						TGL_AWAL 
						BETWEEN TO_DATE('$tgl1','MM/DD/YYYY') AND TO_DATE('$tgl2','MM/DD/YYYY')
				";
			
		return $this->db->query($sql)->result();	
	}
	
	public function get_status_cek($id) 
	{
		$this->db->select('NPP,EXTRACT(MONTH FROM TGL_AWAL) BLN_AWAL,EXTRACT(MONTH FROM TGL_AKHIR) BLN_AKHIR,EXTRACT(YEAR FROM TGL_AWAL) THN_AWAL,EXTRACT(YEAR FROM TGL_AKHIR) THN_AKHIR,TGL_AWAL,TGL_AKHIR',FALSE);
		$this->db->from('STATUS_NONSALES');
		$this->db->where('NPP',$id);
		$this->db->order_by('NPP','asc');
		return $this->db->get()->result();
	}
	
	public function get_status_cek1($id,$m,$y) 
	{
		$sql ="WITH T AS (
							SELECT NPP,TGL_AWAL START_DATE,TGL_AKHIR END_DATE FROM STATUS_NONSALES WHERE NPP=$id
						)
              SELECT
			NPP,
			START_DATE,
			END_DATE,
			CASE
			WHEN SUBSTR(TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM'),1,1) =0 THEN
			SUBSTR(TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM'),2,1)
			ELSE TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM') 
			END AS MONTH,
            TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'YYYY') YEAR
			FROM  T WHERE TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'YYYY') =$y and
            TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM') =$m
			CONNECT BY TRUNC(END_DATE,'MM') >= ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1) 
			";
		return $this->db->query($sql)->result();
	}
	
	public function get_status_flexi($id = 0) 
	{
				//Select table name
		$table_name = "STATUS_NONSALES";
		
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
		$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_NONSALES.NEXTVAL, ".rtrim($value,",'")."')";
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