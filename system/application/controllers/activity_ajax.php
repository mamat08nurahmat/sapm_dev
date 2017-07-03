<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Activity_ajax extends Controller {

	function Activity_ajax ()
	{
		parent::Controller();	
		$this->load->model('_activity');
		$this->load->model('_sales');
		$this->load->model('_log');
		$this->load->library('flexigrid');
		$this->load->model('_handler');
		$this->load->model('_news');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	}
	
	function index()
	{
	}
	
	function staging()
	{
		//List of all fields that can be sortable. This is Optional.
		//This prevents that a user sorts by a column that we dont want him to access, or that doesnt exist, preventing errors.
		$valid_fields = array('CIF','CUST_NAME','SOURCE_DATA','PRODUCT_NAME','USERID');
		
		$this->flexigrid->validate_post('CIF','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_activity->get_staging($id);
		$this->output->set_header($this->config->item('json_header'));
		
		/*
		 * Json build WITH json_encode. If you do not have this function please read
		 * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
		 */
		#$response  = $this->_activity->get_response_item();
		
		$total_staging=$this->_activity->get_staging_tot();
		$limahari=5*86400;//dalam detik
		$tujuhhari=7*86400;//dalam detik
		
		//-------------------CONFIG AREA, HARUS SESUAI DENGAN DATABASE--------------------{//
		//funding id dari table PIPELINE_CATEGORY
		$funding_id=1;
		//credit_card id dari table PIPELINE_CATEGORY
		$credit_card_id=3;
		
		//approval id dari table STAGING_LIST
		$approval_id=6;
		//acceptance id dari table STAGING_LIST
		$acceptance_id=7;
		//drawdown id dari table STAGING_LIST
		$drawdown_id=8;
		
		//stage yang tidak diisi, format array(PIPELINE_CATEGORY ID, STAGING_LIST ID)
		$non_stage=array(array($funding_id, $approval_id), array($funding_id, $drawdown_id), array($credit_card_id, $acceptance_id),array($credit_card_id, $drawdown_id));
		
		//stage yang isinya nominal bukan tanggal, format array(PIPELINE_CATEGORY ID, STAGING_LIST ID
		$nominal_stage=array(array($funding_id, $acceptance_id), array($credit_card_id, $approval_id));
		
		//total staging funding=dikurang approval dan drawdown
		$total_staging_funding=$total_staging-2;
		
		//total staging credit card=dikurang acceptance dan dikurang drawdown
		$total_staging_credit=$total_staging-2;
		//---------------END CONFIG AREA, HARUS SESUAI DENGAN DATABASE--------------------}//
		
		foreach ($records['records']->result() as $i=>$row)
		{
			$record_items[$i][0]=$row->ID;
			$record_items[$i][1]=$row->CIF;
			$record_items[$i][2]=$row->CUST_NAME;
			$record_items[$i][3]=$row->SOURCE_DATA;
			$record_items[$i][4]=$row->PRODUCT_NAME;
			$record_items[$i][5]=$row->USERID;
			
			//default kolom
			for($x=0;$x<$total_staging;$x++)
			{
				$record_items[$i][($x+6)]='&nbsp;';
			}
			
			//dapatkan staging
			$result_staging=$this->_activity->get_pipeline_staging($row->ID);
			if(!empty($result_staging))
			{
				for($n=0;$n<$total_staging;$n++)
				{
					if(in_array(array($row->CAT_ID, $result_staging[$n]->STAGING_ID), $non_stage))
					{
						$record_items[$i][($n+6)]='<div style="padding:0;margin:0;background-color:#666">&nbsp;</div>';
						continue;
					}
					
					$this_stage=$result_staging[$n]->AS_OF_DATE? strtotime($result_staging[$n]->AS_OF_DATE):null;
					$is_next_stage_exists=false;
					for($n2=($n+1);$n2<$total_staging;$n2++)
					{
						if(in_array(array($row->CAT_ID, $result_staging[$n2]->STAGING_ID), $non_stage))
						{
							continue;
						}
						else
						{
							$is_next_stage_exists=true;
							break;
						}
					}
					$next_stage=$result_staging[$n2]->AS_OF_DATE? strtotime($result_staging[$n2]->AS_OF_DATE):time();
					$first_stage=$result_staging[0]->AS_OF_DATE? strtotime($result_staging[0]->AS_OF_DATE):null;
					
					if(!empty($this_stage))
					{
						if($is_next_stage_exists)
						{
							$jeda_stage=$next_stage-$this_stage;
							$html='<span style="color:';
							if($jeda_stage<$limahari)
							{
								$html.='green';
							}
							elseif($jeda_stage>=$limahari && $jeda_stage<=$tujuhhari)
							{
								$html.='orange';
							}
							else
							{
								$html.='red';
							}
							$html.='">';
							
							if(in_array(array($row->CAT_ID, $result_staging[$n]->STAGING_ID), $nominal_stage))
							{
								$html.=number_format($result_staging[$n]->NOMINAL);
							}
							else
							{
								$html.=date('d-M-Y', $this_stage);
							}
							
							$html.='</span>';
							
							$record_items[$i][($n+6)]=$html;
						}
						elseif(!empty($first_stage))
						{
							$jeda_stage=$this_stage-$first_stage;
							if($row->CAT_ID==$funding_id)
							{
								$ts=$total_staging_funding;
							}
							elseif($row->CAT_ID==$credit_card_id)
							{
								$ts=$total_staging_credit;
							}
							else
							{
								$ts=$total_staging;
							}
							
							$html='<span style="color:';
							if($jeda_stage<=($limahari*$ts))
							{
								$html.='green';
							}
							elseif($jeda_stage>($limahari*$ts) && $jeda_stage<=($tujuhhari*$ts))
							{
								$html.='orange';
							}
							else
							{
								$html.='red';
							}
							$html.='">';
							
							if(in_array(array($row->CAT_ID, $result_staging[$n]->STAGING_ID), $nominal_stage))
							{
								$html.=number_format($result_staging[$n]->NOMINAL);
							}
							else
							{
								$html.=date('d-M-Y', $this_stage);
							}
							
							$html.='</span>';
							
							$record_items[$i][($n+6)]=$html;
						}
					}
				}
			}
			
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		 //$this->output->set_output('{"page":"1","total":"0","rows":[]}');
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search()
	{
		$valid_fields = array('ID','CIF','NAMA_NASABAH');
		
		$this->flexigrid->validate_post('ID','ASC',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search($id);
		//$records = $this->_sales->get_cust_ind($id);
		
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF,
				$row->NAMA_NASABAH
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_TOP_20_10()
	{
		$valid_fields = array('ID','CIF','NAMA_NASABAH');
		
		$this->flexigrid->validate_post('ID','ASC',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_top_20_10($id);
		//$records = $this->_sales->get_cust_ind($id);
		
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF,
				$row->NAMA_NASABAH
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_debitur()
	{
		$valid_fields = array('ID','CIF','NAMA_DEBITUR');
		
		$this->flexigrid->validate_post('ID','ASC',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_debitur_search($id);
		//$records = $this->_sales->get_cust_ind($id);
		
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF,
				$row->NAMA_DEBITUR
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_pros()
	{
		$valid_fields = array('ID','CIF_KEY','CUST_NAME');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_pros($id);
			//$records = $this->_sales->get_cust_ind($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->CUST_NAME
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_debitur_pros()
	{
		$valid_fields = array('ID','CIF_KEY','CUST_NAME');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_debitur_pros($id);
			//$records = $this->_sales->get_cust_ind($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->CUST_NAME
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_tele()
	{
		$valid_fields = array('ID','CIF','NAMA','JENIS_PRODUK');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_tele($id);
			//$records = $this->_sales->get_cust_ind($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF,
				$row->NAMA,
				$row->JENIS_PRODUK
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_propensity()
	{
		$valid_fields = array('ID','CIF_KEY','NAMA','PRODUK');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_propensity($id);
			//$records = $this->_sales->get_cust_ind($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->NAMA,
				$row->PRODUK
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	#for leads offensive
	function search_offensive()
	{
		$valid_fields = array('ID','CIF_KEY','NAMA','PRODUK');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
			$records = $this->_activity->get_search_offensive_staging($id);
			//$records = $this->_sales->get_cust_ind($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->NAMA,
				$row->PRODUK
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function search_corp()
	{
		$valid_fields = array('ID','CIF_KEY','COMPANY_CORP');
		
		$this->flexigrid->validate_post('ID','ASC',$valid_fields);
		$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
		$records = $this->_activity->get_search_corp($id);
		$this->output->set_header($this->config->item('json_header'));		
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				$row->CIF_KEY,
				$row->COMPANY_NAME
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	//Delete Activity
	function del_activity()
	{
		$ids = split(",",$this->input->post('items'));
		
		foreach($ids as $index => $id)
			if (is_numeric($id) && $id > 1) 
				$this->_activity->delete($id, 'DAILY_ACTIVITY');
						
			
		$error = "Selected data (id's: ".$this->input->post('items').") deleted with success";
		
		#-------------------------------
		#	LOG USER ACTIVITY
		#-------------------------------
		$log = array();
		$log['NPP'] 			= $this->session->userdata('ID');
		$log['ACTION'] 			= 'DELETE';
		$log['INFO'] 			= 'DAILY ACTIVITY ID = '.rtrim($this->input->post('items'),',');
		$log['DATE_CREATED'] 	= date('d-M-Y H:i:s');
		$this->_log->logs($log);
		
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}
	
	function save_komentar()
	{
		$data['AGENDA_ID']=(int) $this->input->post('AGENDA_ID');
		$data['KOMENTAR']=$this->input->post('KOMENTAR');
		$data['USERID']=$this->session->userdata('ID');
		
		$json['result']=$this->_activity->save_agenda_komentar($data);
		echo json_encode($json);
	}
	
	function load_komentar()
	{
		$AGENDA_ID=(int) $this->input->post('AGENDA_ID');
		$json['result']=$this->_activity->get_list_agenda_comment($AGENDA_ID);
		echo json_encode($json);
	}
	
	function save_pipeline_komentar()
	{
		$data['PIPELINE_ID']=(int) $this->input->post('PIPELINE_ID');
		$data['KOMENTAR']=$this->input->post('KOMENTAR');
		$data['USERID']=$this->session->userdata('ID');
		
		$json['result']=$this->_activity->save_pipeline_komentar($data);
		echo json_encode($json);
	}
	
	function load_pipeline_komentar()
	{
		$PIPELINE_ID=(int) $this->input->post('PIPELINE_ID');
		$json['result']=$this->_activity->get_list_pipeline_comment($PIPELINE_ID);
		echo json_encode($json);
	}
	
	
}
?>
