<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class _activity extends Model 
{
	/**
	* Instanciar o CI
	*/
	public function _activity()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	function get_branch($id)
	{
		$sql ="select
				branch_code,
				UPPER(branch_name) branch_name
				from
				branch
				where region not in(99,98,88,80) and UPPER(branch_name) NOT LIKE 'KANTOR WILAYAH%'
				order by branch_name asc";
		return $this->db->query($sql)->result();
	}
	
	public function get_staging($id = 0) 
	{
		
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$branch_id = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:0;
		
				$querykesut = $_REQUEST['squery'];
		//echo $_REQUEST['squery'];
		$sqtype = $_REQUEST['sqtype'];
		
		//Build contents query
		$this->db->select("a.*, b.SOURCE_DATA, c.PRODUCT_NAME,CASE WHEN A.LAST_STAGING=7 AND A.CAT_ID = 1 THEN 1 
		WHEN A.LAST_STAGING=8 AND A.CAT_ID = 2 THEN 1
		WHEN A.LAST_STAGING=6 AND A.CAT_ID = 3 THEN 1
		ELSE 0 END AS END_STAGING");
		$this->db->from('PIPELINE_MASTER a');
		$this->db->join('PARAM_SOURCE b','a.SOURCE_ID = b.ID');
		$this->db->join('PIPE_LOOKUP_PRODUCT c','a.PRODUCT_ID = c.ID');
		$this->db->join('USER_TST d','a.USERID = d.ID');
		
		$this->db->order_by('a.ENDSTAGING', 'asc');
		$this->db->order_by('a.LAST_STAGING', 'desc');
		$this->db->order_by('a.STAGING_UPDATE', 'desc');
		

		if($lvl == 'SUPERVISOR')
		{
			$this->db->where("d.SPV","$id");
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
		}
		elseif($lvl=='CABANG' || $lvl =='PIMPINAN_CABANG' || $lvl =='PEMIMPIN_CABANG' || $lvl =='PEMIMPIN_KLN-KK')
		{
			$this->db->where('d.BRANCH', $branch_id);
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
		}
		else
		{
			
			$this->db->where("SUBSTR(a.USERID,-5,5) ","$id");	
			$this->db->where("a.ENDSTAGING ",0);
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
			//$this->db->where("CIF","9212730077");
		}
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(a.ID) AS RECORD_COUNT');
		$this->db->from('PIPELINE_MASTER a');
		$this->db->join('PARAM_SOURCE b','a.SOURCE_ID = b.ID');
		$this->db->join('PIPE_LOOKUP_PRODUCT c','a.PRODUCT_ID = c.ID');
		$this->db->join('USER_TST d','a.USERID = d.ID');
		
				if($lvl == 'SUPERVISOR')
		{
			$this->db->where("d.SPV","$id");
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
		}
		elseif($lvl=='CABANG' || $lvl =='PIMPINAN_CABANG' || $lvl =='PEMIMPIN_CABANG' || $lvl =='PEMIMPIN_KLN-KK')
		{
			$this->db->where('d.BRANCH', $branch_id);
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
		}
		else
		{
			
			$this->db->where("SUBSTR(a.USERID,-5,5) ","$id");	
			$this->db->where("a.ENDSTAGING ",0);
			if ( ! empty($querykesut))
		{
			if($sqtype == 'CIF')
			{
				$this->db->where($sqtype,$querykesut);
			}
			else
			{
			$this->db->where("UPPER($sqtype) LIKE '%$querykesut%'");
			}
		}
			//$this->db->where("CIF","9212730077");
		}
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_search($id = 0) 
	{
		//Select table name
		$table_name = "CUSTOMER_INDIVIDU";
		
		//Build contents query
		$this->db->select("ID, CIF, NAMA_NASABAH");
		$this->db->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_search_top_20_10($id = 0) 
	{
		//Select table name
		$table_name = "CUSTOMER_INDIVIDU";
		
		//Build contents query
		$this->db->select("a.ID, a.CIF, a.NAMA_NASABAH");
		$this->db->from("$table_name a");
		$this->db->join("CR_FLAGGING_TOP b","a.CIF=b.CIF_KEY");
		$this->db->where("SUBSTR(TRIM(b.NPP),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select("COUNT(a.ID) AS RECORD_COUNT")->from("$table_name a")->join("cr_flagging_top b","a.CIF = b.CIF_KEY");
		$this->db->where("SUBSTR(TRIM(b.NPP),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_search_pros($id = 0) 
	{
		//Select table name
		$table_name = "CUST_INDV_PROS";
		
		//Build contents query
		$this->db->select("ID, CIF_KEY, CUST_NAME");
		$this->db->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->db->where("IS_PROSPECT",'1');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//TEle
	public function get_search_tele($id = 0) 
	{
		//Select table name
		$table_name = "TELE_INBOUND";
		
		//Build contents query
		$this->db->select("ID, CIF, NAMA, JENIS_PRODUK");
		$this->db->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//propensity
	public function get_search_propensity($id = 0) 
	{
		//Select table name
		$table_name = "NEW_LEADS_PROPENSITY";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY, NAMA, PRODUK");
		$this->db->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(CIF_KEY) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//offensive
	public function get_search_offensive($id = 0) 
	{
		//Select table name
		$table_name = "VW_LEADS_OFFENSIVE";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY, CUST_NAME NAMA, PRODUCT_NAME PRODUK");
		$this->db->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		#$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(CIF_KEY) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		#$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//
	
	//offensive
	public function get_search_offensive_staging($id = 0) 
	{
		//Select table name
		$table_name = "VW_LEADS_OFFENSIVE";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY, CUST_NAME NAMA, PRODUCT_NAME PRODUK");
		$this->db->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("REFFERAL_LEADS_ID>=","0");
		#$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("REFFERAL_LEADS_ID>=","0");
		#$this->db->where("IS_EXPIRED","0");
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//
	
	// Debitur
	public function get_debitur_search($id = 0) 
	{
		//Select table name
		$table_name = "DEBITUR";
		
		//Build contents query
		$this->db->select("ID, CIF, NAMA_DEBITUR");
		$this->db->from($table_name);
		$this->db->where("SUBSTR(TRIM(RM_CODE),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SUBSTR(TRIM(RM_CODE),-5,5) ","$id");
		//$this->db->where("IS_PROSPECT <>",1);
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_search_debitur_pros($id = 0) 
	{
		//Select table name
		$table_name = "DEBITUR_PROS";
		
		//Build contents query
		$this->db->select("ID, CIF_KEY, CUST_NAME");
		$this->db->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->db->where("IS_PROSPECT",'1');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	
	//
	public function get_search_corp($id = 0) 
	{
		//Select table name
		$table_name = "CUST_CORP";
		
		//Build contents query
		$this->db->select("ID, CIF_KEY, COMPANY_NAME");
		$this->db->from($table_name);
		#$this->db->where("BNI_SALES_ID LIKE ","%$id");
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('COUNT(ID) AS RECORD_COUNT')->from($table_name);
		#$this->db->where("BNI_SALES_ID LIKE ","%$id");
		$this->db->where("SUBSTR(TRIM(BNI_SALES_ID),-5,5) ","$id");
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	function get_product_item()
	{	
		$this->db->where("CATEGORY",'Financial');
		return $this->db->get('PRODUCT')->result();	
	}
	
	function get_activity_item()
	{	
		return $this->db->get('ACTIVITY')->result();	
	}
	
	function get_response_item()
	{
		return $this->db->get('RESPONSE')->result();
	}
	
	function save($data, $tbl_name)
	{		
		$sql = "INSERT INTO $tbl_name 
				(
					ID,
					USERID,
					CIF_KEY ,
					CUST_NAME,
					TANGGAL,
					D,
					M,
					Y,
					H,
					I,
					PRODUK_ID,
					STAGING_ID,
					KETERANGAN,
					REALISASI
				)
				VALUES 
				(
					SEQ_AGENDA.NEXTVAL,".
					$data['USERID'].",'".
					$data['CIF_KEY ']."','".
					$data['CUST_NAME']."','".
					$data['TANGGAL']."','".
					$data['D']."','".
					$data['M']."','".
					$data['Y']."','".
					$data['H']."','".
					$data['I']."','".
					$data['PRODUK_ID']."','".
					$data['STAGING_ID']."','".
					$data['KETERANGAN']."','".
					$data['REALISASI']."'
				)";
				 
		#echo "<pre>";print_r($data);
		#echo "<pre>";print_r($sql); die();
		$this->db->query($sql);
		#return $this->db->insert_id();
	}
	
	function update($id, $data, $tbl_name)
	{		
		#print_r($data);die();
		$this->db->where('ID',$id);
		$this->db->update($tbl_name, $data);
	}
	
	public function delete($id, $tbl_name) 
	{
		$this->db->where('ID',$id);
		$this->db->delete($tbl_name);
		#$delete = $this->db->query('DELETE FROM '.$tbl_name.' WHERE id='.$id);
		return TRUE;
	}
	
	function get_data_act($id, $tbl_name)
	{
		$this->db->where("ID",$id);
		return $this->db->get($tbl_name)->result_array();
	}
	
	function get_next_stage_data($PIPELINE_ID)
	{
		$this->db->from('PIPELINE_MASTER');
		$this->db->where('ID', $PIPELINE_ID);
		$qry=$this->db->get();
		
		if($row=$qry->row_array())
		{
			//-------------------CONFIG AREA, HARUS SESUAI DENGAN DATABASE--------------------{//
			//funding id dari table PIPELINE_CATEGORY
			$funding_id=1;
			//credit_card id dari table PIPELINE_CATEGORY
			$credit_card_id=3;
			//lending id dari table PIPELINE_CATEGORY
			$lending_id = 2;
			
			//approval id dari table STAGING_LIST
			$application_id=5;
			//approval id dari table STAGING_LIST
			$approval_id=6;
			//acceptance id dari table STAGING_LIST
			$acceptance_id=7;
			//drawdown id dari table STAGING_LIST
			$drawdown_id=8;
			
			//stage yang tidak diisi, format array(PIPELINE_CATEGORY ID, STAGING_LIST ID)
			$non_stage=array(array($funding_id, $approval_id), array($funding_id, $drawdown_id), array($credit_card_id, $acceptance_id),array($credit_card_id, $drawdown_id));
			
			//stage yang isinya nominal bukan tanggal, format array(PIPELINE_CATEGORY ID, STAGING_LIST ID
			$nominal_stage=array(array($funding_id, $acceptance_id), array($credit_card_id, $approval_id), array($lending_id, $drawdown_id));
			
			//stage nominal khusus apllication noaplikasi
			$noaplikasi_stage = array(array($lending_id, $application_id));
			//---------------END CONFIG AREA, HARUS SESUAI DENGAN DATABASE--------------------}//
			
			$list_stage=$this->get_pipeline_staging($PIPELINE_ID);
			$tot_list_stage=count($list_stage);
			$row['STAGING']='';
			$row['NOMINAL_WAJIB_ISI']=false;
			$row['NO_APLIKASI_WAJIB_ISI']=false;
			$row['NO_CIF_WAJIB_ISI']=false;
			$row['ESTIMASI_NOMINAL']=null;
			$row['LAST_DATE']=null;
			foreach($list_stage as $pos=>$row2)
			{
				if(is_null($row['ESTIMASI_NOMINAL']))
				{
					$row['ESTIMASI_NOMINAL']=number_format($row2->NOMINAL);
				}
				
				if(is_null($row2->AS_OF_DATE))
				{
					if(in_array(array($row['CAT_ID'], $row2->STAGING_ID), $non_stage))
					{
						continue;
					}
					
					else if(in_array(array($row['CAT_ID'], $row2->STAGING_ID), $nominal_stage))
					{
						$row['NOMINAL_WAJIB_ISI']=true;
						$row['NO_CIF_WAJIB_ISI']=true;
						$row['NO_APLIKASI_WAJIB_ISI']=false;
					}
					else if(in_array(array($row['CAT_ID'], $row2->STAGING_ID),$noaplikasi_stage))
					{
						$row['NO_APLIKASI_WAJIB_ISI']=true;
					}
					
					$row['STAGING']=$row2->STAGING_NAME;
					$row['STAGING_ID']=$row2->STAGING_ID;
					break;
				}
				else
				{
					$row['LAST_DATE']=$row2->AS_OF_DATE;
				}
			}
			
			return $row;
		}
		return false;
	}
	
	function get_act_items($data)
//	function get_act_items($arr)
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$branch_id = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:0;
		$region = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:0;
		$this->db->select('a.*, b.PRODUCT_NAME, c.STAGING_NAME, d.USER_NAME');
		$this->db->from('AGENDA a');
		$this->db->join('PIPE_LOOKUP_PRODUCT b', 'a.PRODUK_ID = b.ID','left');
		$this->db->join('STAGING_LIST c', 'a.STAGING_ID = c.ID','left');
		$this->db->join('USER_TST d','a.USERID = d.ID');
		$this->db->join('BRANCH e','d.BRANCH = e.BRANCH_CODE');
		
		if($lvl == 'SUPERVISOR')
		{
			$this->db->where("d.SPV","$id");
		}
		elseif($lvl == 'CABANG' || $lvl == 'PIMPINAN_CABANG' || $lvl =='PIMPINAN_CABANG' || $lvl =='PEMIMPIN_CABANG' || $lvl =='PIMPINAN_KLN-KK')
		{
			$this->db->where('d.BRANCH', $branch_id);
		}
		elseif($lvl == 'WILAYAH' || $lvl == 'PIMPINAN_WILAYAH')
		{
			$this->db->where('e.REGION', $region);
		}
		elseif($lvl == 'SALES') 
		{
			$this->db->where("SUBSTR(a.USERID,-5,5) ","$id");
		}
		else 
		{
			$this->db->where("SUBSTR(a.USERID,-5,5) <>","0");	
		}
			
		$this->db->where($data);
//		$this->db->where($arr);
		$this->db->order_by('H, I','DESC');
		return $this->db->get()->result();	
	}
	
	function get_tele($id,$type)
	{
		if($type == 0) $where2 ='SALES_ID =' .$id.' AND IS_STAGING=0';
		if($type == 1) $where2 ='SANDI_CABANG ='.$id.' AND SALES_ID = 0';
		if($type == 2) $where2 ='SALES_ID = 99';
		if($type == 3) $where2 ='SANDI_CABANG ='.$id.' AND SALES_ID = 0';
		if($type == 4) $where2 ='SANDI_CABANG ='.$id.' AND SALES_ID = 0';
		
		$sql ="SELECT COUNT(ID) JUMLAH FROM TELE_INBOUND WHERE $where2";
		//echo $sql;die();
		return $this->db->query($sql)->result();
	}
	
	function get_pipe_produk()
	{
		$this->db->from('PIPE_LOOKUP_PRODUCT');
		$qry=$this->db->get();
		return $qry->result();
	}
	
	function get_pipe_produk_json()
	{
		$this->db->from('PIPE_LOOKUP_PRODUCT');
		$this->db->order_by('CATEGORY, PRODUCT_NAME');
		$qry=$this->db->get();
		
		$result=array();
		foreach($qry->result() as $row)
		{
			$result["CAT_{$row->CATEGORY}"][]=array('value'=>$row->ID, 'innerHTML'=>$row->PRODUCT_NAME);
		}
		return $result;
	}
	
	function get_pipeline_category()
	{
		$this->db->from('PIPELINE_CATEGORY');
		$qry=$this->db->get();
		return $qry->result();
	}
	
	function get_staging_list()
	{
		$this->db->from('STAGING_LIST');
		$this->db->order_by('ID');
		$qry=$this->db->get();
		return $qry->result();
	}
	
	function get_staging_id_list()
	{
		$result=array();
		foreach($this->get_staging_list() as $row)
		{
			$result[]=$row->ID;
		}
		return $result;
	}
	
	function get_staging_tot()
	{
		$this->db->from('STAGING_LIST');
		$this->db->select("COUNT(ID) TOTAL", false);
		$qry=$this->db->get();
		
		if($row=$qry->row())
		{
			return $row->TOTAL;
		}
		return 0;
	}
	
	function get_pipeline_staging($PIPELINE_ID)
	{
		if($PIPELINE_ID)
		{
			$this->db->from('STAGING_LIST A');
			$this->db->JOIN('PIPELINE_STAGING B', "A.ID=B.STAGING_ID AND B.PIPELINE_ID='{$PIPELINE_ID}'", 'left');
			$this->db->select('A.STAGING_NAME, A.ID STAGING_ID, B.NOMINAL , B.NOAPLIKASI');
			$this->db->select("TO_CHAR(B.AS_OF_DATE, 'YYYY-MM-DD HH24:MI:SS') AS_OF_DATE", false);
			$this->db->order_by('A.ID');
			$qry=$this->db->get();
			return $qry->result();
		}
		return array();
	}
	
	function save_pipeline_staging($data)
	{
		$tgl="TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')";
		$this->db->set('PIPELINE_ID', $data['PIPELINE_ID']);
		$this->db->set('AS_OF_DATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
		$this->db->set('STAGING_ID', $data['STAGING_ID']);
		$this->db->set('NOMINAL', $data['NOMINAL']);
		$this->db->set('NOAPLIKASI', $data['NOAPLIKASI']);
		$this->db->set('NOCIF', $data['NOCIF']);
		$this->db->set('SYS_DATE', 'SYSDATE', false);
		 $sql="INSERT INTO SAPM_DETAIL_STAGING(ID_DETAIL_STAGING,WAKTU,TANGGAL,ID_PRODUK,STATUS,ID_STAGING)
               VALUES
			   (
                    ".$data['PIPELINE_ID'].",
                    TO_CHAR(".$tgl.",'HH24:MI:SS'),
                    ".$tgl.",
                    NULL,
                    ".$data['STAGING_ID'].",
                    ".$data['PIPELINE_ID']."
                )";
				
		if($this->db->insert('PIPELINE_STAGING'))
		{
			$this->db->set('LAST_STAGING', $data['STAGING_ID']);
			$this->db->set('STAGING_UPDATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
			$this->db->where('ID', $data['PIPELINE_ID']);
			$this->db->update('PIPELINE_MASTER');
			$this->db->query($sql);
			return true;
		}
		

		return false;
	}
	
	function save_pipeline_master($data)
	{
		$qry=$this->db->query('SELECT SEQ_PIPELINE_MASTER.NEXTVAL ID FROM DUAL');
		if($row=$qry->row())
		{
			$this->db->set('ID', $row->ID);
			$this->db->set('CIF', $data['CIF']);
			$this->db->set('CUST_NAME', $data['CUST_NAME']);
			$this->db->set('SOURCE_ID', $data['SOURCE_ID']);
			$this->db->set('PRODUCT_ID', $data['PRODUCT_ID']);
			$this->db->set('CAT_ID', $data['CAT_ID']);
			$this->db->set('USERID', $data['USERID']);
			$this->db->set('LEADS_ID', $data['LEADS_ID']);
			
			if($this->db->insert('PIPELINE_MASTER'))
			{
				return $row->ID;
			}
		}
		return null;
	}
	
	function get_first_stage_name()
	{
		$this->db->from('STAGING_LIST');
		$this->db->order_by('ID');
		$this->db->limit(1, 1);
		$qry=$this->db->get();
		
		if($row=$qry->row())
		{
			return $row->STAGING_NAME;
		}
		return '';
	}
	
	function get_first_stage_id()
	{
		$this->db->from('STAGING_LIST');
		$this->db->order_by('ID');
		$this->db->limit(1, 1);
		$qry=$this->db->get();
		
		if($row=$qry->row())
		{
			return $row->ID;
		}
		return null;
	}
	
	function get_pipeline_master_detail($ID)
	{
		if($ID)
		{
			$this->db->where('A.ID', $ID);
			$this->db->from('PIPELINE_MASTER A');
			$this->db->join('PIPE_LOOKUP_PRODUCT B', 'A.PRODUCT_ID=B.ID');
			$this->db->join('PIPELINE_CATEGORY C', 'A.CAT_ID=C.ID');
			$this->db->join('PARAM_SOURCE D', 'A.SOURCE_ID = D.ID');
			$this->db->select('A.*, B.PRODUCT_NAME, C.KATEGORI, D.SOURCE_DATA');
			$qry=$this->db->get();
			return $qry->row();
		}
		return false;
	}
	
	function save_agenda_komentar($data)
	{
		$this->db->set('AGENDA_ID', $data['AGENDA_ID']);
		$this->db->set('USERID', $data['USERID']);
		$this->db->set('TANGGAL', "TO_DATE('".date('d-m-Y H:i:s')."', 'DD-MM-YYYY HH24:MI:SS')", false);
		$this->db->set('KOMENTAR', $data['KOMENTAR']);
		
		return $this->db->insert('AGENDA_COMMENT');
	}
	
	function save_pipeline_komentar($data)
	{
		$this->db->set('PIPELINE_ID', $data['PIPELINE_ID']);
		$this->db->set('USERID', $data['USERID']);
		$this->db->set('DT_CREATED', "TO_DATE('".date('d-m-Y H:i:s')."', 'DD-MM-YYYY HH24:MI:SS')", false);
		$this->db->set('KOMENTAR', $data['KOMENTAR']);
		
		return $this->db->insert('PIPELINE_MASTER_KOMEN');
	}
	
	function get_list_agenda_comment($AGENDA_ID)
	{
		$this->db->where('A.AGENDA_ID', $AGENDA_ID);
		$this->db->from('AGENDA_COMMENT A');
		$this->db->join('USER_TST B', 'A.USERID=B.ID');
		$this->db->select('A.AGENDA_ID, A.USERID, A.KOMENTAR, B.USER_NAME');
		$this->db->select("TO_CHAR(A.TANGGAL, 'DD-Mon-YYYY HH24:MI:SS') TANGGAL", false);
		$this->db->order_by('TANGGAL');
		
		$qry=$this->db->get();
		return $qry->result();
	}
	
	function get_list_pipeline_comment($PIPELINE_ID)
	{
		$this->db->where('A.PIPELINE_ID', $PIPELINE_ID);
		$this->db->from('PIPELINE_MASTER_KOMEN A');
		$this->db->join('USER_TST B', 'A.USERID=B.ID');
		$this->db->select('A.PIPELINE_ID, A.USERID, A.KOMENTAR, B.USER_NAME');
		$this->db->select("TO_CHAR(A.DT_CREATED, 'DD-Mon-YYYY HH24:MI:SS') DT_CREATED", false);
		$this->db->order_by('DT_CREATED');
		
		$qry=$this->db->get();
		return $qry->result();
	}
	
	#ACCOUNT PLANNING
	function save_account_planning($data)
	{
		$qry=$this->db->query('SELECT SEQ_ACCOUNT_PLANNING.NEXTVAL ID FROM DUAL');
		if($row=$qry->row())
		{
			$this->db->set('ID', $row->ID);
			$this->db->set('CIF_KEY', $data['CIF']);
			$this->db->set('CUST_NAME', $data['CUST_NAME']);
			$this->db->set('PRODUCT_ID', $data['PRODUCT_ID']);
			$this->db->set('CAT_ID', $data['CAT_ID']);
			$this->db->set('SALES_ID', $data['USERID']);
			$this->db->set('RENCANA', $data['RENCANA']);
			$this->db->set('TARGET', $data['TARGET']);
			$this->db->set('UPLOAD_DATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
			$this->db->set('MONTH', $data['MONTH']);
			$this->db->set('YEAR', $data['YEAR']);
			$this->db->set('WEEK', 0);
			
			if($this->db->insert('NEW_ACCOUNT_PLANNING'))
			{
				return $row->ID;
			}
		}
		return null;
	}
	
	#TAP
	function save_tap($data)
	{
		$qry=$this->db->query('SELECT SEQ_TAP.NEXTVAL ID FROM DUAL');
		if($row=$qry->row())
		{
			$this->db->set('ID', $row->ID);
			$this->db->set('CIF_KEY', $data['CIF']);
			$this->db->set('CUST_NAME', $data['CUST_NAME']);
			$this->db->set('PRODUCT_ID', $data['PRODUCT_ID']);
			$this->db->set('CAT_ID', $data['CAT_ID']);
			$this->db->set('SALES_ID', $data['USERID']);
			$this->db->set('TARGET', $data['TARGET']);
			$this->db->set('UPLOAD_DATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
			$this->db->set('MONTH', $data['MONTH']);
			$this->db->set('YEAR', $data['YEAR']);
			
			if($this->db->insert('NEW_TAP'))
			{
				return $row->ID;
			}
		}
		return null;
	}
	
	function update_source_staging($data)
	{
		$object=array
				(
					'IS_STAGING'=>'1'
				);
		$this->db->where('ID',$data['LEADS_ID']);
		if($data['SOURCE_ID'] =='10')
		{
			$this->db->update('NEW_LEADS_PROPENSITY',$object);
		}
		elseif($data['SOURCE_ID'] =='20')
		{
			$this->db->update('TELE_INBOUND',$object);
		}
	}
	
	#PIPELINE BM
	function save_account_planning_BM($data)
	{
		$qry=$this->db->query('SELECT SAPM_PB.NEXTVAL ID FROM DUAL');
		if($row=$qry->row())
		{
			$this->db->set('ID', $row->ID);
			$this->db->set('CIF_KEY', $data['CIF']);
			$this->db->set('CUST_NAME', $data['CUST_NAME']);
			$this->db->set('PRODUCT_ID', $data['PRODUCT_ID']);
			#$this->db->set('CAT_ID', $data['CAT_ID']);
			$this->db->set('SALES_ID', $data['USERID']);
			$this->db->set('RENCANA', $data['RENCANA']);
			#$this->db->set('TARGET', $data['TARGET']);
			$this->db->set('UPLOAD_DATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
			$this->db->set('WEEK', $data['WEEK']);
			$this->db->set('MONTH', $data['MONTH']);
			$this->db->set('YEAR', $data['YEAR']);
			
			if($this->db->insert('PIPELINE_BM'))
			{
				return $row->ID;
			}
		}
		return null;
	}
	
}
?>
