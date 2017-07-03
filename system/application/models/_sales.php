<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _sales extends Model 
{
	public function _sales()
    {
        parent::Model();
		$this->CI =& get_instance();
		$this->load->helper('date');
    }
//---------------------------------------------

//---------------------------------------------


	
	function get_sumber_leads()
	{
		$this->db->where('ID',60);
		$this->db->from('PARAM_SOURCE');
		$this->db->order_by('ID','ASC');
		return $this->db->get()->result();
	}
	
	function get_cabang()
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
	
	public function get_cust_ind($id = 0) 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "VW_CR_CUST_INDV2";
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("SPV","$id");
		if($lvl == 'WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'TIM') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5) <> "," ");
		
$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		#print_r($return['records']); die();
		//Build count query
		$this->db->select('count(CIF) as RECORD_COUNT')->from($table_name);

		if($lvl == 'SALES') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("SPV","$id");
		if($lvl == 'WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'TIM') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5) <> "," ");
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}

//-------------------------------------------
	public function get_cust_ind_new($id = 0) 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "VW_CR_CUST_INDV2";
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("SPV","$id");
		if($lvl == 'WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'TIM') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5) <> "," ");

				//Get contents
		
				return $this->db->get()->result();


		
/*
//$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		#print_r($return['records']); die();
		//Build count query
		$this->db->select('count(CIF) as RECORD_COUNT')->from($table_name);

		if($lvl == 'SALES') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("SPV","$id");
		if($lvl == 'WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'TIM') $this->db->where("SUBSTR(BNI_SALES_ID,-5,5) <> "," ");
		
//		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
*/		
	}

	
	//TELE
	public function get_cust_tele($id = 0) 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "TELE_INBOUND";
		$cab1 = str_pad($cab,3, "0", STR_PAD_LEFT);
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		//print_r($cab);die();
		}
		
		if($lvl == 'CABANG' || $lvl == 'PEMIMPIN_CABANG'|| $lvl == 'PIMPINAN_CABANG' || $lvl == 'SUPERVISOR') 
		{
		$this->db->where("SANDI_CABANG","$cab1");
		$this->db->where("SALES_ID","0");
		
		//print_r($cab);die();
		}
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		//print_r($return['records']); die();
		//Build count query
		$this->db->select('count(NAMA) as RECORD_COUNT')->from($table_name);

		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		//print_r($cab);die();
		}
		
		if($lvl == 'CABANG' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PIMPINAN_CABANG' ||$lvl == 'SUPERVISOR') 
		{
		$this->db->where("SANDI_CABANG","$cab1");
		$this->db->where("SALES_ID","0");
		}
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	//-----------------------------------------------------------
	//TELE
	public function get_cust_tele_new($id = 0) 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "TELE_INBOUND";
		$cab1 = str_pad($cab,3, "0", STR_PAD_LEFT);
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		//print_r($cab);die();
		}
		
		if($lvl == 'CABANG' || $lvl == 'PEMIMPIN_CABANG'|| $lvl == 'PIMPINAN_CABANG' || $lvl == 'SUPERVISOR') 
		{
		$this->db->where("SANDI_CABANG","$cab1");
		$this->db->where("SALES_ID","0");
		
		//print_r($cab);die();
		}
//		$this->CI->flexigrid->build_query();
/*
		//Get contents
		$return['records'] = $this->db->get();
		//print_r($return['records']); die();
		//Build count query
		$this->db->select('count(NAMA) as RECORD_COUNT')->from($table_name);
*/		

		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		//print_r($cab);die();
		}
		
		if($lvl == 'CABANG' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PIMPINAN_CABANG' ||$lvl == 'SUPERVISOR') 
		{
		$this->db->where("SANDI_CABANG","$cab1");
		$this->db->where("SALES_ID","0");
		}
/*
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
*/		
		return $this->db->get()->result();


	}


	
	//leads propensity
	public function get_leads_propensity() 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "NEW_LEADS_PROPENSITY";
		$cab1 = str_pad($cab,3, "0", STR_PAD_LEFT);
		
		//Build contents query
		$this->db->select("*");
		$this->db->from($table_name);
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("IS_EXPIRED","0");
		//print_r($cab);die();
		}
		if($lvl == 'PIMPINAN_CABANG' || $lvl == 'CABANG' || $lvl == 'SUPERVISOR' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PEMIMPIN_KLN-KK') 
		{
		$this->db->where("BRANCH","$cab1");
		$this->db->where("IS_EXPIRED","0");
		#$this->db->where("SALES_ID","0");
		
		//print_r($cab);die();
		}
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		//print_r($return['records']); die();
		//Build count query
		$this->db->select('count(NAMA) as RECORD_COUNT')->from($table_name);

		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		$this->db->where("IS_EXPIRED","0");
		//print_r($cab);die();
		}
		if($lvl == 'PIMPINAN_CABANG' || $lvl == 'CABANG' || $lvl == 'SUPERVISOR' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PEMIMPIN_KLN-KK') 
		{
			$this->db->where("BRANCH","$cab1");
			$this->db->where("IS_STAGING","0");
			$this->db->where("IS_EXPIRED","0");
			#$this->db->where("SALES_ID","0");
		}
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	//
	
	//leads propensity
	public function get_leads_offensive() 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "LEADS_OFFENSIVE a";
		$cab1 = str_pad($cab,3, "0", STR_PAD_LEFT);
		
		//Build contents query
		$this->db->select("a.*,b.product_name");
		$this->db->from($table_name);
		$this->db->join('product b','a.product_id = b.id','left');
		
		#----------------------------
		#	Cek level user
		#----------------------------
		if($lvl == 'SALES') 
		{
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		#$this->db->where("IS_EXPIRED","0");
		//print_r($cab);die();
		}
		if($lvl == 'PIMPINAN_CABANG' || $lvl == 'CABANG' || $lvl == 'SUPERVISOR' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PEMIMPIN_KLN-KK') 
		{
		$this->db->where("BRANCH","$cab1");
		$this->db->where("SALES_ID","0");
		
		//print_r($cab);die();
		}
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		//print_r($return['records']); die();
		//Build count query
		$this->db->select('count(cust_name) as RECORD_COUNT')->from($table_name);

		if($lvl == 'SALES') 
		{
		$this->db->where("BRANCH","$cab1");
		$this->db->where("SALES_ID","$id");
		$this->db->where("IS_STAGING","0");
		#$this->db->where("IS_EXPIRED","0");
		//print_r($cab);die();
		}
		if($lvl == 'PIMPINAN_CABANG' || $lvl == 'CABANG' || $lvl == 'SUPERVISOR' || $lvl == 'PEMIMPIN_CABANG' || $lvl == 'PEMIMPIN_KLN-KK') 
		{
			$this->db->where("BRANCH","$cab1");
			$this->db->where("IS_STAGING","0");
			#$this->db->where("IS_EXPIRED","0");
			$this->db->where("SALES_ID","0");
		}
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	//
	
	public function get_cust_ind_cab($id = 0) 
	{
		//Select table name
		$table_name = "CUST_INDV";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY,CUST_NAME,AGE,CUR_BOOK_BAL_IDR,AVG_BOOK_BAL,BRANCH_CODE")->from($table_name);
		$this->db->where("BRANCH_CODE",$id);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		$this->db->where("BRANCH_CODE",$id);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_cust_ind_pros($id = 0) 
	{
		//Select table name
		$table_name = "CUST_INDV_PROS";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY,CUST_NAME,DATE_OF_BIRTH,CUR_BOOK_BAL_IDR,AVG_BOOK_BAL,BRANCH_CODE, EXTRACT(YEAR FROM DATE_OF_BIRTH) YEAR")->from($table_name);
		$this->db->where("TRIM(SUBSTR(BNI_SALES_ID,-5,5))",$id);
		#$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		$this->db->where("TRIM(SUBSTR(BNI_SALES_ID,-5,5))",$id);
		$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	public function get_cust_corp($id = 0) 
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		//Select table name
		$table_name = "CUST_CORP a";
		
		//Build contents query
		$this->db->select("a.ID,a.CIF_KEY,a.COMPANY_NAME,a.CUR_BOOK_BAL_IDR,a.AVG_BOOK_BAL,a.BRANCH_CODE,b.SPV")->from($table_name);
		$this->db->join('USER_TST b',"TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID", 'left');
		$this->db->join('BRANCH c',"b.BRANCH = c.BRANCH_CODE",'LEFT');

		if($lvl == 'SALES') $this->db->where("SUBSTR(a.BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("b.SPV","$id");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("c.REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("b.BRANCH","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'WILAYAH') $this->db->where("c.REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("b.BRANCH","$cab");
		$this->db->where("a.IS_PROSPECT",'0');
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(a.ID) as RECORD_COUNT')->from($table_name);
		$this->db->join('USER_TST b',"TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID", 'left');
		$this->db->join('BRANCH c',"b.BRANCH = c.BRANCH_CODE",'LEFT');

		if($lvl == 'SALES') $this->db->where("SUBSTR(a.BNI_SALES_ID,-5,5)","$id");
		if($lvl == 'SUPERVISOR') $this->db->where("b.SPV","$id");
		if($lvl == 'WILAYAH') $this->db->where("c.REGION","$wil");
		if($lvl == 'CABANG') $this->db->where("b.BRANCH","$cab");
		if($lvl == 'PIMPINAN_WILAYAH') $this->db->where("c.REGION","$wil");
		if($lvl == 'PIMPINAN_CABANG') $this->db->where("b.BRANCH","$cab");
		if($lvl == 'PEMIMPIN_CABANG') $this->db->where("BRANCH_CODE","$cab");
		if($lvl == 'PEMIMPIN_KLN-KK') $this->db->where("BRANCH_CODE","$cab");
		$this->db->where("a.IS_PROSPECT",'0');
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
		//Return all
		return $return;
	}
	
	public function get_cust_corp_pros($id = 0) 
	{
		//Select table name
		$table_name = "CUST_CORP";
		
		//Build contents query
		$this->db->select("ID,CIF_KEY,COMPANY_NAME,CUR_BOOK_BAL_IDR,AVG_BOOK_BAL,BRANCH_CODE")->from($table_name);
		$this->db->where("TRIM(SUBSTR(BNI_SALES_ID,-5,5))",$id);
		$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		$this->db->where("TRIM(SUBSTR(BNI_SALES_ID,-5,5))",$id);
		$this->db->where("IS_PROSPECT",'1');
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
		//Return all
		return $return;
	}
	
	function get_bni_product()
	{	
		$this->db->where('CATEGORY','Financial');
		$this->db->where('ID < ',9);
		$this->db->order_by('PRODUCT_NAME', 'asc');
		return $this->db->get('PRODUCT')->result();	
	}
	
	function get_other_product($branch)
	{
		#$this->db->where('BRANCH_CODE',$branch);
		$this->db->order_by('PRODUCT', 'asc');
		return $this->db->get('OTHER_PRODUCT')->result();
	}
	
	function get_branch_sales($branch)
	{
		$this->db->select('a.*,b.sales_type',false);
		$this->db->from('USER_TST a');
		$this->db->where('a.BRANCH',$branch);
		$this->db->where('a.USER_LEVEL','SALES');
		$this->db->where('a.STATUS',1);
		$this->db->join('SALES_TYPE b','a.SALES=b.id');
		$this->db->order_by('b.SALES_TYPE,a.ID','asc');
		return $this->db->get()->result();
	}
	
	function save($data, $tbl_name)
	{		
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			$field 	.= $row.",";
			$value	.= $val."','"; 
		}

		$ids = now();
		
		$row = rtrim($field,",");
		#$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_CUST_INDV.NEXTVAL, ".rtrim($value,",'")."')";
		$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES ($ids, ".rtrim($value,",'")."')";
		#print_r($sql); die();
		$this->db->simple_query($sql);
	}
	
	function save_offensive($data, $tbl_name)
	{		
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			$field 	.= $row.",";
			$value	.= $val."','"; 
		}

		$ids = now();
		
		$row = rtrim($field,",");
		#$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_CUST_INDV.NEXTVAL, ".rtrim($value,",'")."')";
		$seq= "select SAPM_LOFFENSIVE.nextval ID from dual";
		$ids=$this->db->query($seq);
		if($c=$ids->row())
		{
			$sql = "INSERT INTO $tbl_name (ID,AS_OF_DATE,PROGRAM_NAME,".$row.") VALUES (".$c->ID.", SYSDATE,'RTGS', ".rtrim($value,",'")."')";
		}
		#print_r($sql); die();
		$this->db->simple_query($sql);
	}
	
	function save_corp($data, $tbl_name)
	{		
		$ids = now();
		
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			if(! in_array($row,$data)){
				$field 	.= $row.",";
				$value	.= $val."','"; 
			}
		}
		$row = rtrim($field,",");
		#$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES (SEQ_CUST_CORP.NEXTVAL, ".rtrim($value,",'")."')";
		$sql = "INSERT INTO $tbl_name (ID,".$row.") VALUES ($ids, ".rtrim($value,",'")."')";
		$this->db->simple_query($sql);
	}
	
	function update($id, $data, $tbl_name)
	{		
		$datep = date('d-M-Y');
		#echo "<pre>";
		#print_r($data);die();
		$this->db->where('ID',$id);
		$this->db->update($tbl_name, $data);
		if($tbl_name=='TELE_INBOUND')
		{
			$this->db->where('ID',$id);
			$this->db->set('ASSIGN_DATE',$datep);
			$this->db->update('SAPM_TELE_ASSIGN');
		}
	}
	
	function update_cust_ind($id, $data, $tbl_name)
	{		
		#echo "<pre>";
		#print_r($data);die();
		$this->db->where('CIF',$id);
		$this->db->update($tbl_name, $data);
	}
	
	public function delete_pros($id, $tbl_name) 
	{
		$delete_pros = $this->db->query('DELETE FROM '.$tbl_name.' WHERE ID='.$id);
		return TRUE;
	}
	
	function get_data_cust($type=0, $id, $tbl_name)
	{
		if($type!=0)
			$this->db->where("CIF",$id);
		else
			$this->db->where("ID",$id);
		return $this->db->get($tbl_name)->result_array();
	}
	
	function get_data_tele($id)
	{
		$this->db->where("ID",$id);
		return $this->db->get('TELE_INBOUND')->result_array();
	}
	
	function get_param($param_name)
	{
		return $this->db->get('PARAM_'.strtoupper($param_name))->result();
	}
	
	function save_leads_poropensity_sales($ID, $SALES_ID, $BRANCH_ID)
	{
		$this->db->where('ID', $ID);
		$this->db->where('BRANCH', str_pad($BRANCH_ID,3, "0", STR_PAD_LEFT));
		$this->db->set('SALES_ID', $SALES_ID);
		return $this->db->update('NEW_LEADS_PROPENSITY');
	}
	
	function save_leads_500046_sales($ID, $SALES_ID, $SANDI_CABANG)
	{
		$this->db->where('ID', $ID);
		$this->db->where('SANDI_CABANG', str_pad($SANDI_CABANG,3, "0", STR_PAD_LEFT));
		$this->db->set('SALES_ID', $SALES_ID);
		return $this->db->update('TELE_INBOUND');
	}
	
	function save_leads_offensive_sales($ID, $SALES_ID, $BRANCH_ID)
	{
		$this->db->where('ID', $ID);
		$this->db->where('BRANCH', str_pad($BRANCH_ID,3, "0", STR_PAD_LEFT));
		$this->db->set('SALES_ID', $SALES_ID);
		return $this->db->update('LEADS_OFFENSIVE');
	}
	
	function get_detail_propensity($CIF_KEY,$id)
	{
		if($CIF_KEY)
		{
			$this->db->where('CIF_KEY', $CIF_KEY);
			$this->db->where('ID', $id);
			$this->db->from('NEW_LEADS_PROPENSITY');
			$this->db->select('ID, CIF_KEY, NAMA, LIFE_TIME, REGION, BRANCH, ALAMAT, HANDPHONE, ESTIMASI_DPK, ESTIMASI_LOAN, ESTIMASI_INVESTASI, MACRO_SEGMENT, MICRO_SEGMENT, SALES_ID, PROGRAM_NAME, PRODUK');
			$this->db->select("TO_CHAR(TO_DATE(EXPIRED_PROGRAM, 'DDMMYYYY'),'DD-MON-YYYY') AS EXPIRED_PROGRAM", false);
			$qry=$this->db->get();
			return $qry->row();
		}
		return false;
	}
	
	function get_detail_offensive($id)
	{
			$this->db->where('ID', $id);
			$this->db->from('VW_LEADS_OFFENSIVE');
			$this->db->select("*", false);
			$qry=$this->db->get();
			return $qry->row();
		return false;
	}
//----------------------------------
//	public function get_news99($id = 0) 
	public function get_news99() 
	{
		//Select table name
		$table_name = "NEWS";
		
		//Build contents query
		$this->db->select("ID,JUDUL,ISI")->from($table_name);
		//$this->db->where("BRANCH_CODE",$id);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		
		//$this->db->where("BRANCH_CODE",$id);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
//----------------------------------
	
	
	
}
?>
