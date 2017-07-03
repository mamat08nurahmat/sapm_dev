<?php
class phr_program_cif extends Controller {

	function phr_program_cif()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file','flexigrid','html','array'));
        $this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader','form_validation','flexigrid'));
		$this->load->model('_phr_program_cif', 'phr_program_cif', TRUE);

		date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['USERNAME'] == ''){ redirect('login_phr_nasabah/logout/');}

	}

	function index()
	{
		// $data['tampil'] = $this->phr_program_cif->getAll();
        // $this->load->view("phrprogramcif/index", $data);
		
		$this->load->helper('form');
		$this->load->helper('html');
		
		$colModel['ID_PROGRAM'] = array('ID_PROGRAM',150,TRUE,'center',1);
        $colModel['CIF']        = array('CIF',350,TRUE,'left',1);

		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 'auto', //610
			'height' 			=> 300,
			'rp' 				=> 11,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> '',
			'showTableToggleBtn'=> true
		);

		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		// $buttons[] = array('Add','add','add');
		// $buttons[] = array('Edit','edit','edit');
		// $buttons[] = array('Delete','delete','del');
		//$buttons[] = array('separator');
		#$buttons[] = array('Delete','delete','del');
		#$buttons[] = array('Select All','add','sel');
		#$buttons[] = array('DeSelect All','delete','sel');
		#$buttons[] = array('separator');

		$grid_js = build_grid_js('result_list',site_url("/phr_program_cif/cif_ajax_list/"),$colModel,'ID_PROGRAM','DESC',
			$gridParams);

		$data['js_grid'] = $grid_js;

		$this->load->view('phrprogramcif/index',$data);
	}
	
	function cif_ajax_list()
	{
		$valid_fields = array('ID_PROGRAM','CIF');
		
		$this->flexigrid->validate_post('ID_PROGRAM','asc',$valid_fields);
		$records = $this->phr_program_cif->getProgramCifList();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			
			$record_items[] = array($row->ID_PROGRAM,
				$row->ID_PROGRAM,
				$row->CIF
			);
		}
		
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
        else
         	$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}


}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */
