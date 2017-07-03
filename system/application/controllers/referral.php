<?php

class Referral extends Controller {

	function Referral()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file'));
        $this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_referral', 'referral', TRUE);
		date_default_timezone_set('Asia/Jakarta');
		//$this->load->model('_login', 'login', TRUE);
	}
	
	function index()
	{

		if (!$this->input->post('proses')) {
			
			$this->load->view('referral_tracking/referral_view');
		} else {
			
			$npp            = $this->input->post('npp');
			
			$this->referral->insertHits($npp);
			$start          = $this->input->post('start');
			$end            = $this->input->post('end');
			$data['filter'] = $this->referral->getKartuKredit($npp,$start,$end);
			$this->load->view('referral_tracking/referral_view', $data);
			
			/*
			$datacek        = $this->referral->getHits($npp);
			$npp            = $this->input->post('npp');
			if ($datacek == null) { 
					
				$npp            = $this->input->post('npp');
				$hits = 1;	
				$this->referral->insertHits($npp,$hits);	

				$start          = $this->input->post('start');
				$end            = $this->input->post('end');
				$data['filter'] = $this->referral->getKartuKredit($npp,$start,$end);
				
				$this->load->view('referral_view', $data);	
				
			 } else{
			
				$npp            = $this->input->post('npp');
			
				$start          = $this->input->post('start');
				$end            = $this->input->post('end');
				
				$hits = $this->referral->selectHits($npp);
				// var_dump($hits);
				// die();
				$this->referral->updateHits($hits,$npp);	
				$data['filter'] = $this->referral->getKartuKredit($npp,$start,$end);
				
				$this->load->view('referral_view', $data);			
			 }
			 */
			
			
			
		
		}
	}
	
	// function gethasilkk()
	// {
		// if (!$this->input->post('proses')) {
			
			// echo "ga masuk";
			// die();
			// $this->load->view('referral_view');
		// } else {
			// $npp            = $this->input->post('npp');
			// $start          = $this->input->post('start');
			// $end            = $this->input->post('end');
			// $data['filter'] = $this->referral->getKartuKredit($npp,$start,$end);
			// echo "masuk";
			// die();
			// $this->load->view('referral_view', $data);	
		// }
		
	// }
	
	

}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */