<?php
class Segmentasi extends Controller {
	
	function Segmentasi()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_login', 'login', TRUE);
		// $this->load->model('_news');
		// $this->load->model('_activity');
		// $this->load->model('_home');
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	}
	
    function index()
    {
//        $this->load->view('default/home');
    }

    function audit()
    {
//echo"Audit Trail c->segmentasi/audit";

		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN','TIM','ADMIN','USERMGT');
//if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$data['type'] = 0;
		$this->load->view('segmentasi/audit_segmentasi');
    }

}