<?php
class News extends Controller {

	function __construct  ()
	{
		parent::__construct();	
		$this->load->helper('flexigrid');
	}
	
	function index()
	{
		//ver lib
		
		$this->load->model('news_model');
		$records = $this->news_model->get_select_news();
		
		$options = '';
		foreach( $records as $v ) {
			$options .= $v['ID'] . ';';
		}
		$options = substr($options, 0, -1);

		/*
		 * 0 - display name
		 * 1 - width
		 * 2 - sortable
		 * 3 - align
		 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)

		 $colModel['id'] = array('ID',40,TRUE,'center',2);
		$colModel['iso'] = array('ISO',40,TRUE,'center',0);
		$colModel['name'] = array('Name',180,TRUE,'left',1);
		$colModel['printable_name'] = array('Printable Name',120,TRUE,'left',1);
		$colModel['iso3'] = array('ISO3',130, TRUE,'left',1, 'options' => array('type' => 'select', 'edit_options' => $options));
		$colModel['numcode'] = array('Number Code',80, TRUE, 'right',1, 'options' => array('type' => 'select', 'edit_options' => ":All;AND:AND;KK:KK;RE:RE"));
		$colModel['created_date'] = array('Date',80,TRUE,'left',1,'options' => array('type' => 'date'));
		$colModel['actions'] = array('Actions',80, FALSE, 'right',0);
		 */
		
		$colModel['ID'] 			= array('ID',30,TRUE,'center',1);
		$colModel['JUDUL'] 		= array('JUDUL',350,TRUE,'left',1);
		//$colModel['ISI'] 		= array('SALES',180,TRUE,'left',2);
		$colModel['IS_ACTIVE'] 			= array('IS_ACTIVE',80,TRUE,'center',1);
		$colModel['TANGGAL'] 			= array('TANGGAL',80,TRUE,'center',1);

		
		/*
		 * Aditional Parameters
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
		 */
		 
		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 610,
			'height' 			=> 300,
			'rp' 				=> 11,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST BERITA',
			'showTableToggleBtn'=> true
		);		 
		 
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		$buttons[] = array('Delete','delete','test');
		$buttons[] = array('separator');
		$buttons[] = array('Select All','add','test');
		$buttons[] = array('DeSelect All','delete','test');
		$buttons[] = array('separator');
		 */
		$buttons[] = array('View','view','view');
		$buttons[] = array('Add','add','add');	
		$buttons[] = array('Edit','edit','edit');	
		 
		 
		//SHS for Flexigrid issue site_url()
		$this->load->helper('url');

		//Build js
		//View helpers/flexigrid_helper.php for more information about the params on this function
		$grid_js = build_grid_js('flex1',site_url("/news_feed"),$colModel,'TANGGAL','DESC',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
//		$data['version'] = "0.36";
//		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('default/v_news',$data);
	}
	
	function example () 
	{
		$data['version'] = "0.36";
		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('example',$data);	
	}
}
?>
