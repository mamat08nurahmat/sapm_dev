<?php
//class Countries extends CI_Controller {
class Countries extends Controller {


//	function __construct  ()
	function Countries  ()
	{
		parent::Controller();	
		$this->load->helper('flexigrid');
	}
	


	function index()
	{
		//ver lib
		
		//load model
		$this->load->model('countries_model');
/*
		$records = $this->countries_model->get_select_countries();
#print_r($records);die();
		$options = '';
		foreach( $records as $v ) {
			$options .= $v['name'] . ';';
		}
		$options = substr($options, 0, -1);
*/		

		/*
		 * 0 - display name
		 * 1 - width
		 * 2 - sortable
		 * 3 - align
		 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
		 */
		$colModel['ID'] 			= array('ID',40,TRUE,'center',2);
		$colModel['JUDUL'] 			= array('JUDUL',40,TRUE,'center',0);

		
		
		/*
		 * Aditional Parameters
		 */
		$gridParams = array(
		'width' => 'auto',
		'height' => 'auto',
		'rp' => 15,
		'rpOptions' => '[10,15,20,25,40]',
		'pagestat' => 'Displaying: {from} to {to} of {total} items.',
		'blockOpacity' => 0.5,
		'title' => 'Countries',
		'showTableToggleBtn' => true
		);
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		$buttons[] = array('separator');
		$buttons[] = array('Delete','delete','test');
		$buttons[] = array('separator');
		$buttons[] = array('Select All','add','test');
		$buttons[] = array('separator');
		$buttons[] = array('DeSelect All','delete','test');
		$buttons[] = array('separator');

		//SHS for Flexigrid issue site_url()
		$this->load->helper('url');

		//Build js
		//View helpers/flexigrid_helper.php for more information about the params on this function
		$grid_js = build_grid_js('flex1',site_url("/countries_feed"),$colModel,'id','desc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['version'] = "0.36";
		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('countries',$data);
	}
	
	function example () 
	{
		$data['version'] = "0.36";
		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('example',$data);	
	}
}
?>
