<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Berita_ajax extends Controller {

	function Berita_ajax ()
	{
		parent::Controller();	
		$this->load->model('_news');
		$this->load->library('flexigrid');
		$this->load->model('_handler');
	date_default_timezone_set('Asia/Jakarta');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	
	function index()
	{


		$valid_fields = array('ID','JUDUL','IS_ACTIVE','TANGGAL');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$records = $this->_news->get_news_flexi();
		//echo '<pre>'; print_r($records); die();
		$this->output->set_header($this->config->item('json_header'));
		
//		foreach ($records['record_count']->result() as $row)
		foreach ($records['records']->result() as $row)
		{
			
			$record_items[] = array($row->ID,
				$row->ID,
				$row->JUDUL,
				$row->IS_ACTIVE,
				$row->TANGGAL
			);
		}
		//Print please
		if (isset($record_items))
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	 
	}
}