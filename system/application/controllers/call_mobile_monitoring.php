<?php
class Call_mobile_monitoring extends Controller {

	function Call_mobile_monitoring()
	{
		parent::Controller();
		$this->load->helper('url', 'form');
        $this->load->library(array('table','validation', 'session', 'ldap'));
        $this->load->model('_login_mobile_monitoring', 'login', TRUE);
        $this->load->model('_handler_mobile_monitoring', 'handler', TRUE);
		$this->load->model('_call_mobile_monitoring', 'call');
		$this->load->library('googlemaps');

		//kalo udah gak ada sessi
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login_sapmmobile_dashboard/logout/');}

		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");
		$this->handler->update_session($now,$session_id);
	}

	function index()
	{
		$data['data'] = $this->call->getHasil();
		$this->load->view('monitoring_mobile_call/call_view', $data);
	}

	function detail()
	{

		$lat=null;
		$lng=null;
		$nama=null;
		$id = $this->uri->segment(3);
		$coords = $this->call->getCall($id);
		foreach($coords as $coordinate){
			$lat=$coordinate->LAT;
			$lng=$coordinate->LNG;
			$nama=$coordinate->NAMA;
		}
		//location indonesia
		$config = array();
		$config['center'] = $lat . ',' . $lng;
		$config['zoom']   = '15';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $lat . ',' . $lng;
		//$marker['onclick']  = 'alert(\'Nama : '.$coordinate->NAMA.'\')';
		$marker['infowindow_content'] = "Nama : " . $nama;
		$this->googlemaps->add_marker($marker);


		//ciptakan mapsnya
		$data = array();
		$data['maps'] = $this->googlemaps->create_map();
		//print_r($data['maps']['markers']);
		$this->load->view('monitoring_mobile_call/call_detail',$data);
	}

}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */
