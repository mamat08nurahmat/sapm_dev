<?php
class Upload_dpk3 extends Controller {
	
	function Upload_dpk3()
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
//		echo"Upload Pencapainan Manual c->csv/upload_sln";
//        $this->load->view('default/home');
    }

  function upload_sln()
    {
		echo"Upload Pengurangan DPK c->upload_dpk3/upload_sln";
//        $this->load->view('default/home');
    }
  
}