<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Activity_bm extends Controller {

	function Activity_bm()
	{
		parent::Controller();
		$this->load->helper('flexigrid');
		$this->load->model('_activity');
		$this->load->model('_sales');
		$this->load->model('_log');
		$this->load->model('_handler');
		$this->load->model('_news');
		$this->load->model('_agenda_bm');

		date_default_timezone_set('Asia/Jakarta');	
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
		if($_SESSION['ID'] == ''){ redirect('login');}
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPERVISOR','CABANG', 'TIM', 'SLN', 'WILAYAH','PIMPINAN_CABANG','PIMPINAN_WILAYAH','PEMIMPIN_CABANG','PEMIMPIN_KLN-KK');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
	}
	
	
	function index()
	{

	}

function get_rekap_outlet(){
//	echo"REKAP ACTIVITY (activity_bm/get_rekap_outlet)";
	$this->load->view('default/rekap_outlet');
}	
	
function update_top(){
	echo"ADMIN TOP (activity_bm/update_top)";
	
}	
	

}
?>
