<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Berita extends Controller {

	function Berita()
	{
		parent::Controller();
		$this->load->helper('flexigrid');
		$this->load->model('_news');
		$this->load->model('_log');
		if($_SESSION['ID'] == ''){ redirect('login');}
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN', 'ADMIN');
		//if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$this->load->model('_handler');
		$this->load->model('_news');
		
		date_default_timezone_set('Asia/Jakarta');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	

	function index($year = 0, $month = 0)
	{
/*
echo"BERITA";
*/		
		//*
		 //* 0 - display name
		 //* 1 - width
		 //* 2 - sortable
		 //* 3 - align
		 //* 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
		 //*

		#-------------------------------------------		
		#		GET DATA realisasi PER SALES
		#-------------------------------------------		
		$colModel['ID'] 			= array('ID',30,TRUE,'center',1);
		$colModel['JUDUL'] 		= array('JUDUL',350,TRUE,'left',1);
		//$colModel['ISI'] 		= array('SALES',180,TRUE,'left',2);
		$colModel['IS_ACTIVE'] 			= array('IS_ACTIVE',80,TRUE,'center',1);
		$colModel['TANGGAL'] 			= array('TANGGAL',80,TRUE,'center',1);

		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 610,
			'height' 			=> 300,
			'rp' 				=> 11,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST BERITA',
			'showTableToggleBtn'=> true
		);
		
		//*
		 //* 0 - display name
		 //* 1 - bclass
		 //* 2 - onpress
		 //*
		$buttons[] = array('View','view','view');
		$buttons[] = array('Add','add','add');	
		$buttons[] = array('Edit','edit','edit');	
		
		//$buttons[] = array('separator');
		#$buttons[] = array('Delete','delete','del');
		#$buttons[] = array('Select All','add','sel');
		#$buttons[] = array('DeSelect All','delete','sel');
		#$buttons[] = array('separator');

		$grid_js = build_grid_js('berita_list',site_url("/berita_ajax/"),$colModel,'TANGGAL','DESC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

		//print_r($data);
		//echo $grid_js;
		$this->load->view('berita/index',$data);
	}


	
	
	function view($id)
	{
		$data['data'] = $this->_news->get_news_id($id);
		$this->load->view('berita/view', $data);
	}
	
	function add($id = '')
	{
		$this->load->view("berita/add", $data);
	}
	
	function edit($id = 0){
	
		
		$data['data']= $this->_news->get_news_id($id);
		$this->load->view('berita/edit', $data);	
	}
	
	function save_berita()
	{		
		$id = ($this->input->post('ID'));
		#echo $id;die();
		if($id == ''){
			array_shift($_REQUEST);
			$data = $this->unset_array($_REQUEST);			
			$this->data_save($data, 1, 'NEWS');
		} else {
			$data = $this->unset_array($_REQUEST);
			$this->data_edit($id, $data, 'NEWS');	
		}
			redirect('berita');	
	}
	
	function unset_array($data){
		if (array_key_exists('ci_session', $data)) {
    		unset($data['ci_session']);
		}
		if (array_key_exists('PHPSESSID', $data)) {
    		unset($data['PHPSESSID']);
		}
		return $data;
	}
	
	function data_save($arr, $prospek = 0, $tbl_name)
	{
		$tgl = date('d-M-Y');
		$arrplus	= ($prospek == 1)?array('TANGGAL'=>$tgl):array('TANGGAL'=>$tgl);
		$arr 		= array_merge($arr, $arrplus);
		
		#echo "<pre>"; print_r($arr); die();
		$this->_news->save($arr, $tbl_name );
	}
	
	
	function data_edit($id, $arr, $tbl_name)
	{
		$this->_news->update($id, $arr, $tbl_name );
	}
	
	
}