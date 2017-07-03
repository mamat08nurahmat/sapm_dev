<?php
class Export extends Controller {

	function __construct  ()
	{
		parent::__construct();	
		//$this->load->helper('flexigrid');
		$this->load->model('_export');
	}
	
	function index()
	{
		
$data = $this->_export->get_all()-result_array();
print_r($data);
//$this->load->view(v_export);
	//ver lib
//		echo"ssssssssssssssssssssss";

	}
	
	function example() 
	{
		$data['version'] = "0.36";
		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('example',$data);	
	}
}
?>
