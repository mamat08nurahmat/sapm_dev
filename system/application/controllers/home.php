<?php
class Home extends Controller {
	
	function Home()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_login', 'login', TRUE);
		 $this->load->model('_news');
		 $this->load->model('_activity');
		 $this->load->model('_home');
		$this->load->model('_agenda_bm');		 
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	}
	
    function index()
    {
/*
		$news = $this->db->query("SELECT * FROM NEWS WHERE IS_ACTIVE = 1 ORDER BY TANGGAL DESC ")->result();
*/		
		$news = $this->_news->get_news();
        $this->load->view('home/home' , array('news' => $news));
		#print_r($data);die();
		
#$data2 = $this->_home->sudah_kuesioner($_SESSION['ID']);
		#print_r($data2);die();
		//echo $data[0];die();
		//$data = $this->_home->get_sum_point($_SESSION['ID']);
		
/*
		if($data2[0]->status==1)
		{
		$this->load->view('default/home2');
		}else{
		$this->load->view('default/home2');
		
		}
*/		
#		$this->load->view('default/home',$data);
		
    }


	
	
	
    function point()
    {
    	$this->load->view('default/point');
    }
	
	   function tes()
    {
    	$this->load->view('point');
    }

}