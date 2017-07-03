<?php 
class Location extends Controller {

	function Location()
	{
		parent::Controller();
		$this->load->helper('url', 'form');
        $this->load->library(array('table','validation', 'session', 'ldap'));
        $this->load->model('_login', 'login');
        $this->load->model('_handler', 'handler');
		$this->load->library('googlemaps');
		$this->load->model('_maps', 'maps_model');
		
		//kalo udah gak ada sessi
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	}
	
	function index()
	{
		
		$config = array();
		// Initialize the map, passing through any parameters
        $config['center'] = '-6.203764, 106.823518';
		$config['zoom']   = '15';
        $this->googlemaps->initialize($config);
		
		//ambil function get_coordinate
		$coords = $this->maps_model->get_coordinates();
		
		//looping data
		foreach ($coords as $coordinate){
			$marker = array();
			$marker['position'] = $coordinate->LAT . ',' . $coordinate->LNG;
			//$marker['onclick']  = 'alert(\'Nama : '.$coordinate->NAMA.'\')'; 
			$marker['infowindow_content'] = "NPP : " .$coordinate->NPP .
			                                "<br />Nama : " . $coordinate->NAMA . 
											"<br />Jabatan : " .$coordinate->ROLE .
											"<br />Unit : " .$coordinate->UNIT;
			$this->googlemaps->add_marker($marker);
		}
		
		//ciptakan mapsnya
		$data = array();
		$data['maps'] = $this->googlemaps->create_map();
		//print_r($data['maps']['markers']);
		$this->load->view('location_view', $data);
	}
	
}
?>