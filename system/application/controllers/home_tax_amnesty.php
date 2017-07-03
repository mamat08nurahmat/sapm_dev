<?php
class Home_tax_amnesty extends Controller {
	
	function Home_tax_amnesty()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader'));
		date_default_timezone_set('Asia/Jakarta');
		
		if($_SESSION['ID'] == ''){ redirect('login_tax_amnesty/logout/');}
		// $this->load->model('_handler');
		
		// $session_id = $_SESSION['ID'];
		// $now = date("Y-m-d H:i:s");	
		// $this->_handler->update_session($now,$session_id);
	}
	
    function index()
    {
        $this->load->view('taxmasters/masters_tax_amnesty');
    }
}