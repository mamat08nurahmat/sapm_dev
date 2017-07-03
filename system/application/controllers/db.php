<?php
class Db extends Controller {
	
	function Db()
	{
		parent::Controller();
	/*
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_login', 'login', TRUE);
		 $this->load->model('_news');
		 $this->load->model('_activity');
		 //$this->load->model('_home');
				 $this->load->model('_report');
 
		$this->load->model('_agenda_bm');		 
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	*/	
		/*
		*/
	}
	

    function index()
    {

echo"DBBBBBBBBBBBB";	
	}

function tabel($cek='news'){
	
	$quert = $this->db->query("SELECT * FROM $cek WHERE ROWNUM <= 10")->result();
	
	print_r($quert);
}


function sesi(){
	
	
echo $_SESSION['SALES_TYPE'];	
echo 'ID : ';
echo $this->session->userdata('ID');
echo"<br>";
echo 'USER_NAME : ';
echo $this->session->userdata('USER_NAME');
echo"<br>";
echo 'EMAIL : ';
echo $this->session->userdata('EMAIL');
echo"<br>";
echo 'USER_LEVEL : ';
echo $this->session->userdata('USER_LEVEL');
echo"<br>";
echo 'SALES_TYPE : ';
echo $this->session->userdata('SALES_TYPE');
echo"<br>";
echo 'SALES_ID : ';
echo $this->session->userdata('SALES_ID');
echo"<br>";
echo 'BRANCH_ID : ';
echo $this->session->userdata('BRANCH_ID');
echo"<br>";
echo 'REGION : ';
echo $this->session->userdata('REGION');
echo"<br>";
echo 'SPV : ';
echo $this->session->userdata('SPV');
echo"<br>";
echo 'BRANCH_NAME : ';
echo $this->session->userdata('BRANCH_NAME');
echo"<br>";
echo 'GRADE : ';
echo $this->session->userdata('GRADE');

	
}



function cekdata($npp=0){
		$this->db->select('a.*, b.SALES_TYPE, c.BRANCH_NAME, c.REGION ',false);
		$this->db->select('a.*');
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID', 'LEFT');
		$this->db->join('BRANCH c','a.BRANCH = c.BRANCH_CODE');
		$this->db->where('a.ID', '27424');
		$cek =  $this->db->get()->result();
/*
*/	
/*

						$sql="select
							a.*,
                            b.SALES_TYPE,
							c.BRANCH_NAME,
							c.REGION
                            from
                            USER_TST a							
							join 
							SALES_TYPE b
                            on a.SALES = b.ID
							join 
							BRANCH c
                            on a.BRANCH = c.BRANCH_CODE
                            where
                            a.ID = $npp ";
							
		$cek =  $this->db->query($sql)->result();	
*/
	print_r($cek);
}
		
}

