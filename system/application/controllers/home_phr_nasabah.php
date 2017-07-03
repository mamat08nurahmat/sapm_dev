<?php
class Home_phr_nasabah extends Controller {

	function Home_phr_nasabah()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader'));
		$this->load->model('_phr_nasabah', 'phr');
		date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['USERNAME'] == ''){ redirect('login_phr_nasabah/logout/');}

	}

    function index()
    {
        $this->load->view('phrmasters/masters_phr_nasabah');
    }


	function tambah_phr()
	{
		$username = $_SESSION['ID'];
		$cif  = $this->input->post('cif');
		$this->phr->insertPHR($username,$cif);
	}

	function show_program()
	{
		$cif = $this->input->post('cif');
		$data['program'] = $this->phr->getDataProgram($cif);
		$this->load->view("phrmasters/phr_program_show_data", $data);
	}


	// function tampil_phr()
	// {
		// $username = $_SESSION['username'];
		// //$json  = '[{"var1":"9","var2":"16","var3":"16"},{"var1":"8","var2":"15","var3":"15"}]';
		// //9296692677
		// // $cif  = $this->input->post('dataJson');
		// // //$data = json_decode($cif);
		// // print_r($cif); die();
		// // $this->load->view('view_phr_produk_nasabah', $data);

		// $cif  = $this->input->post('cif');
		// //$array = array('result' => 'From controller : '.$cif);
		// $array = array('result' => 'From controller : '.$cif);
		// echo json_encode($array);
		// //$data = json_decode($json, true);
		// //$this->load->view('view_phr_produk_nasabah', $data);
	// }

}
