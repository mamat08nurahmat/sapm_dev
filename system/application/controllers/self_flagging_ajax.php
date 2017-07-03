<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Self_flagging_ajax extends Controller {

	function Self_flagging_ajax ()
	{
		parent::Controller();	
		$this->load->model('_sales');
		$this->load->library('flexigrid');
		$this->load->model('_handler');
		$this->load->model('_news');
		$this->load->model('_self_flagging');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	
	function index()
	{
	}

	function ajax_kirim_cek()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_cek_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_cek_ajax($id, $sales_id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_kirim_sales()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			$sales_type=$this->input->post('salestype');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_sales_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_sales_ajax($id, $sales_id, $sales_type);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_kirim_spv()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_spv_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_spv_ajax($id, $sales_id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_tolakke_bm()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_tolakkebm_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_spv_ajax($id, $sales_id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_kirim_bm()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_bm_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_bm_ajax($id, $sales_id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_kirim_naskel()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_generate_naskel_detail_ajax($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->generate_naskel_detail($sales_id, $id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_update_sales()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$npp	   	= $this->input->post('NPP');
			$sales_id  	= $this->input->post('SALES_ID');
			$branch_id 	= $this->input->post('BRANCH_ID');
			$kln_id    	= $this->input->post('KLN_ID');  
			
			if(!empty($sales_id) && !empty($branch_id) && kln_id>=0)
			{
					$this->_self_flagging->insert_sales_ajax($npp, $sales_id , $branch_id , $kln_id);
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Semua pilihan harus dipilih';
				//$json['msg']=!empty($sales_id).",".!empty($branch_id).",".!empty($kln_id);
			}
			
			echo json_encode($json);
	}
	function insert_tambah()
	{

		$cif = $_POST['CIF'];
		$custtype = $_POST['JC'];
		$namanasabah = $_POST['NAMANASABAH'];
		$jp = $_POST['JP'];
		$cifutama = $_POST['CIFUTAMA'];
		$hdu = $_POST['HDU'];
		$salesid = $_SESSION['ID'];
		
		$response = $this->_self_flagging->insert_nasabah_tambahan($cif,$custtype,$namanasabah,$jp,$cifutama,$hdu,$salesid);
		
		echo $response;
	}
	function cek_tambah()
	{
		$salesid = $_SESSION['ID'];
		
		$response = $this->_self_flagging->cek_nasabah_tambahan($salesid);
		
		echo $response;
	}
	function cleansingnotok()
	{
		$salesid = $_SESSION['ID'];
		
		$response = $this->_self_flagging->cleansing_not_ok($salesid);
		
		echo $response;
	}
	function kirimsales()
	{
		$salesid = $_SESSION['ID'];
		$response = $this->_self_flagging->kirim_sales_lama($salesid);
		
		echo $response;
	}
	function tambahan_kirim_sln()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_kirim_sln_tambahan($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_sln_tambahan($id, $sales_id);
						}
					}
					$this->_self_flagging->auto_tolak($sales_id);
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	function tambahan_kirim_spv()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_kirim_spv_tambahan($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_spv_tambahan($id, $sales_id);
						}
					}
					$this->_self_flagging->auto_tolak($sales_id);
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	function tambahan_kirim_bm()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_kirim_bm_tambahan($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->kirim_bm_tambahan($id, $sales_id);
						}
					}
					$this->_self_flagging->auto_tolak($sales_id);
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
	
	function ajax_kirim_naskel_lama()
	{
			$this->load->model('_self_flagging');
			$this->load->model('_user');
			$json=array();
			
			$arr_id=$this->input->post('cek');
			$sales_id=$this->input->post('salesid');
			
			if($sales_id && is_array($arr_id) && !empty($arr_id))
			{
				$this->_self_flagging->log_kirim_sln_tambahan($sales_id);
					foreach($arr_id as $id)
					{
						if($id)
						{
							$this->_self_flagging->generate_naskel_detail_lama($sales_id, $id);
						}
					}
					$json['result']=true;
			}
			else
			{
				$json['result']=false;
				$json['msg']='Error: Nasabah harus diceklist';
			}
			
			echo json_encode($json);
	}
}