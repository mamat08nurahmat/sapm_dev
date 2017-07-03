<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sales_ajax extends Controller {

	function Sales_ajax ()
	{
		parent::Controller();	
		$this->load->model('_sales');
		$this->load->library('flexigrid');
		$this->load->model('_handler');
		$this->load->model('_news');
		
		$session_id = $_SESSION['ID'];
		
		date_default_timezone_set('Asia/Jakarta');

		
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	
	function index()
	{
	}

//-------------------------
	function news99()
	{
		$valid_fields = array('ID','JUDUL','ISI');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		//$id = ($this->session->userdata('BRANCH_ID') <> '')?$this->session->userdata('BRANCH_ID'):0;
	  //$id = ($this->session->userdata('BRANCH_ID') <> '')?$this->session->userdata('BRANCH_ID'):0;
		
		//$records = $this->_sales->get_news99($id);
		$records = $this->_sales->get_news99();
		
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
//			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
//			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$record_items[] = array($row->ID,
				$row->ID,
				$row->JUDUL,
				$row->ISI
				//$status
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
//-------------------------

	
	function cust_ind()
	{
		$valid_fields = array('ID','CIF','CUST_NAME','AGE','TOTAL_AUM_BNI','TOTAL_LOAN_BNI','BNI_SALES_ID','BRANCH_NAME');
//		$valid_fields = array('ID','CIF_KEY','CUST_NAME','AGE','CUR_BOOK_BAL_IDR','AVG_BOOK_BAL','BNI_SALES_ID','BRANCH_NAME');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_sales->get_cust_ind($id);
		#echo '<pre>'; print_r($records); die();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
//			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
//			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$cif = ($row->CIF)?$row->CIF:'';
			
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF,
				$row->CUST_NAME,
				$row->AGE,			
				number_format($row->TOTAL_AUM_BNI, 2, ',', '.'),
				number_format($row->TOTAL_LOAN_BNI, 2, ',', '.'),
				$row->BNI_SALES_ID,
				$row->BRANCH_NAME,
				$status
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	//Tele Inbound
	function cust_tele()
	{
		$valid_fields = array('ID','SAPM_DATE','CIF','NAMA','HP','KOTA','JENIS_PRODUK','KODE_CABANG');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_sales->get_cust_tele($id);
		#echo '<pre>'; print_r($records); die();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$cif = ($row->CIF)?$row->CIF:'0';
			
			$record_items[] = array($row->ID,
				$row->ID,
				$row->SAPM_DATE,
				$row->CIF,
				$row->NAMA,
				$row->HP,			
				$row->KOTA,
				$row->JENIS_PRODUK,
				$row->KODE_CABANG
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	//leads propensity
	function leads_propensity()
	{
		$valid_fields = array('ID','CIF_KEY','NAMA','BRANCH','HANDPHONE','EXPIRED_PROGRAM','PROGRAM_NAME','PRODUK');
		
		$this->flexigrid->validate_post('CIF_KEY','asc',$valid_fields);
		$records = $this->_sales->get_leads_propensity();
		#echo '<pre>'; print_r($records); die();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$cif = ($row->CIF)?$row->CIF:'0';
			
			$record_items[] = array($row->CIF_KEY,
				$row->ID,
				$row->CIF_KEY,
				$row->NAMA,
				$row->BRANCH,			
				$row->HANDPHONE,
				$row->PROGRAM_NAME,
				$row->PRODUK,
				$row->EXPIRED_PROGRAM,
				
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function leads_offensive()
	{
		$valid_fields = array('ID','CIF_KEY','CUST_NAME','BRANCH','PHONE_1','PROGRAM_NAME','PRODUCT_NAME');
		
		$this->flexigrid->validate_post('CIF_KEY','asc',$valid_fields);
		$records = $this->_sales->get_leads_offensive();
		#echo '<pre>'; print_r($records); die();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$cif = ($row->CIF_KEY)?$row->CIF_KEY:'0';
			
			$record_items[] = array($row->CIF_KEY,
				$row->ID,
				$row->CIF_KEY,
				$row->CUST_NAME,
				$row->BRANCH,			
				$row->PHONE_1,
				$row->PROGRAM_NAME,
				$row->PRODUCT_NAME,
				
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cust_ind_pros()
	{
		$valid_fields = array('ID','CIF_KEY','CUST_NAME','AGE','CUR_BOOK_BAL_IDR','AVG_BOOK_BAL','BRANCH_CODE');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_sales->get_cust_ind_pros($id);
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			#$umur = floor((time() - strtotime($row->DATE_OF_BIRTH))/31556926);
			$year	= date('Y');
			$bday	= ($row->YEAR > $year)?substr_replace($row->YEAR,'19',0,2):$row->YEAR;
			
			$umur = $year - $bday;
			
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$cif = ($row->CIF_KEY)?$row->CIF_KEY:'';
			
			$record_items[] = array($row->ID,
				$row->ID,
				$cif,
				strtoupper($row->CUST_NAME),
				$umur	
			);
		}
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	
	function cust_ind_cab()
	{
		$valid_fields = array('ID','CIF_KEY','CUST_NAME','AGE','CUR_BOOK_BAL_IDR','AVG_BOOK_BAL','BRANCH_CODE');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('BRANCH_ID') <> '')?$this->session->userdata('BRANCH_ID'):0;
		$records = $this->_sales->get_cust_ind_cab($id);
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->CUST_NAME,
				$row->AGE,			
				number_format($row->CUR_BOOK_BAL_IDR, 2, ',', '.'),
				number_format($row->AVG_BOOK_BAL, 2, ',', '.'),
				$row->BRANCH_CODE,
				$status
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cust_corp()
	{
		$valid_fields = array('ID','CIF_KEY','COMPANY_NAME','CUR_BOOK_BAL_IDR','AVG_BOOK_BAL','BRANCH_CODE');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_sales->get_cust_corp($id);
		$this->output->set_header($this->config->item('json_header'));

		foreach ($records['records']->result() as $row)
		{
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->COMPANY_NAME,
				number_format($row->CUR_BOOK_BAL_IDR, 2, ',', '.'),
				number_format($row->AVG_BOOK_BAL, 2, ',', '.'),
				$row->BRANCH_CODE,
				$status
			);
		}

		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cust_corp_pros()
	{
		$valid_fields = array('ID','CIF_KEY','COMPANY_NAME','CUR_BOOK_BAL_IDR','AVG_BOOK_BAL','BRANCH_CODE');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_sales->get_cust_corp_pros($id);
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) > 0) ?"<img src='".ICONS."up.gif'>":"<img src='".ICONS."down.gif'>";
			$status = (($row->CUR_BOOK_BAL_IDR - $row->AVG_BOOK_BAL) == 0) ?"--":$status;
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->COMPANY_NAME,
			);
		}

		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	function del_cust_pros()
	{
		$pros_ids = split(",",$this->input->post('items'));
		
		foreach($pros_ids as $index => $id)
			if (is_numeric($id) && $id > 1) 
				$this->_sales->delete_pros($id, 'CUST_INDV');
						
			
		$error = "Selected data (id's: ".$this->input->post('items').") deleted with success";

		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}
	
	function del_corp_pros()
	{
		$pros_ids = split(",",$this->input->post('items'));
		
		foreach($pros_ids as $index => $id)
			if (is_numeric($id) && $id > 1) 
				$this->_sales->delete_pros($id, 'CUST_CORP');
						
			
		$error = "Selected data (id's: ".$this->input->post('items').") deleted with success";

		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}
	
	function umur( $date ) 
	{
		$date = strtotime($date);
		$now = time();
		return substr(timespan($date,$now),0,2);
	}
	
	function append_sales_propensity()
	{
		if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG')
		{
			$this->load->model('_sales');
			$this->load->model('_user');
			$json=array();
			
			$arr_cif_key=$this->input->post('id');
			$sales_id=$this->input->post('sales_id');
			
			if($sales_id && is_array($arr_cif_key) && !empty($arr_cif_key))
			{
				//cek apakah sales di cabang ini
				if($this->_user->is_user_exists($sales_id, $_SESSION['BRANCH_ID']))
				{
					foreach($arr_cif_key as $id)
					{
						if($id)
						{
							$this->_sales->save_leads_poropensity_sales($id, $sales_id, $_SESSION['BRANCH_ID']);
						}
					}
					$json['result']=true;
				}
				else
				{
					$json['result']=false;
					$json['msg']='Error: Sales tidak terdaftar';
				}
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Data tidak lengkap';
			}
			
			echo json_encode($json);
		}
		else
		{
			exit('Anda tidak punya hak akses di halaman ini');
		}
	}
	
	function append_sales_500046()
	{
		if($_SESSION['USER_LEVEL']=='CABANG' ||$_SESSION['USER_LEVEL']=='PIMPINAN_CABANG'||$_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
			$this->load->model('_sales');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('id');
			$sales_id=$this->input->post('sales_id');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				//cek apakah sales di cabang ini
				if($this->_user->is_user_exists($sales_id, $_SESSION['BRANCH_ID']))
				{
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_sales->save_leads_500046_sales($id, $sales_id, $_SESSION['BRANCH_ID']);
						}
					}
					$json['result']=true;
				}
				else
				{
					$json['result']=false;
					$json['msg']='Error: Sales tidak terdaftar';
				}
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Data tidak lengkap';
			}
			
			echo json_encode($json);
		}
		else
		{
			exit('Anda tidak punya hak akses di halaman ini');
		}
	}
	
	function append_sales_offensive()
	{
		if($_SESSION['USER_LEVEL']=='CABANG' ||$_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' ||$_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
			$this->load->model('_sales');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('id');
			$sales_id=$this->input->post('sales_id');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				//cek apakah sales di cabang ini
				if($this->_user->is_user_exists($sales_id, $_SESSION['BRANCH_ID']))
				{
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_sales->save_leads_offensive_sales($id, $sales_id, $_SESSION['BRANCH_ID']);
						}
					}
					$json['result']=true;
				}
				else
				{
					$json['result']=false;
					$json['msg']='Error: Sales tidak terdaftar';
				}
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Data tidak lengkap';
			}
			
			echo json_encode($json);
		}
		else
		{
			exit('Anda tidak punya hak akses di halaman ini');
		}
	}
}
?>
